var _token = ""
$("[name='_token']").each(function() { _token = this.value })

$('.select2').select2( {
    theme: 'bootstrap-5'
});

jQuery.each( [ "put", "delete", "post" ], function( i, method ) {
  jQuery[ method ] = function( url, data, callback, type ) {
    if ( jQuery.isFunction( data ) ) {
      type = type || callback;
      callback = data;
      data = undefined;
    }
    if(data == undefined){
      data = {_token: _token}
    }else{
      data._token = _token
    }
    return jQuery.ajax({
      url: url,
      type: method,
      dataType: type,
      data: data,
      success: callback
    });
  };
});

function showAlert(titulo = "Información", mensaje, tipo = "info", onSuccess = null, onClose = null) {
  Swal.fire({
    title: titulo,
    text: mensaje,
    icon: tipo,
    showCloseButton: true,
    showCancelButton: onClose != null,
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Aceptar',
    allowOutsideClick: false
  }).then((result) => {
    /* Read more about isConfirmed, isDenied below */
    if (result.isConfirmed) {
      if(onSuccess != null) onSuccess()
    } else if (result.isDismissed) {
      if(onClose != null) onClose()
    }
  })
}

function setFilter(id_input_filtro, id_tabla) {
    $(`#${id_input_filtro}`).keyup(function() {
        var rex = new RegExp($(this).val(), 'i');
        $(`#${id_tabla} tbody tr`).hide();
        $(`#${id_tabla} tbody tr`).filter(function() {
            return rex.test($(this).text());
        }).show();
    })
}

function setLoading(loading = true) {
  if(loading){
    $(".btn-loading").css('display', 'none')
    $(".loading").css('display', 'block')
  }else{
    $(".loading").css('display', 'none')
    $(".btn-loading").css('display', 'block')
  }
}

function setLoadingFullScreen(show = true, message = "Por favor espere...") {
  if (show) {
      $.blockUI({
          message: `<i class="fa fa-spinner mt-3 fa-spin fa-5x fa-fw" style="color: #ffffff;"></i><h1><b>${message}</b></h1>`,
          css: {
              border: 'none',
              padding: '70px 5px 30px 5px',
              backgroundColor: 'transparent',
              '-webkit-border-radius': '10px',
              '-moz-border-radius': '10px',
              opacity: 1,
              color: '#ffffff'
          }
      });
  } else {
      $.unblockUI();
  }
}

var tableToExcel = (function() {
  var uri = 'data:application/vnd.ms-excel;base64,',
      template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
      base64 = function(s) {
          return window.btoa(unescape(encodeURIComponent(s)))
      },
      format = function(s, c) {
          return s.replace(/{(\w+)}/g, function(m, p) {
              return c[p];
          })
      }
  return function(table, name = 'Informe') {
      console.log(name)
      if (!table.nodeType) table = document.getElementById(table)
      var ctx = {
          worksheet: name || 'Worksheet',
          table: table.innerHTML
      }
      console.log(ctx)
      var downloadLink;
      downloadLink = document.createElement("a");
      document.body.appendChild(downloadLink);
      downloadLink.href = uri + base64(format(template, ctx))
      downloadLink.download = name + '.xls';
      downloadLink.click();
  }
})()

function removeColumnTableToExcel(idTable, numColumn) {
  var row;
  row = document.getElementById(idTable).getElementsByTagName('tr');
  lastColumn = row.length - 1
  for (var i = 0; i <= lastColumn; i++) {
      var f = row[i].getElementsByTagName('td')[numColumn];
      f.innerHTML = ""
  }
}

function isEmpty(value) {
  return value == "" || value == null || value == undefined
}

function isMobile() {
  return /Android|webOS|iPhone|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)
}

$('body').on('click', 'button.fc-prev-button', function () {
  if(jQuery.isFunction('callbackPrevCalendar')) callbackPrevCalendar();
});
$('body').on('click', 'button.fc-next-button', function () {
  if(jQuery.isFunction('callbackNextCalendar')) callbackNextCalendar();
});

FullCalendar.globalLocales.push(function () {
  'use strict';
   var es = {
       code: "es",
       week: {
           dow: 1,
           doy: 4
       },
       buttonText: {
           prev: "Ant",
           next: "Sig",
           today: "Hoy",
           month: "Mes",
           week: "Semana",
           day: "Día",
           list: "Agenda"
       },
       weekText: "Sm",
       allDayText: "Todo el día",
       moreLinkText: "más",
       noEventsText: "No hay eventos para mostrar"
   };
   return es;
}());