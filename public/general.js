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

function showAlert(
  titulo = "Información", 
  mensaje, 
  tipo = "info", 
  onSuccess = null, 
  onClose = null,
  textButtonSuccess = "Aceptar",
  textButtonCancel = "Cancelar",
  ) 
  {
  Swal.fire({
    title: titulo,
    text: mensaje,
    icon: tipo,
    showCloseButton: true,
    showCancelButton: onClose != null,
    cancelButtonText: textButtonCancel,
    confirmButtonText: textButtonSuccess,
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

function setLoading(loading = true, idBtn = null, idSpinner = null) {
  if(loading){
    if(idBtn == null){
      $(".btn-loading").css('display', 'none')
      $(".loading").css('display', 'block')
    }else{
      $("#"+idBtn).css('display', 'none')
      $("#"+idSpinner).css('display', 'block')
    }
  }else{
    if(idBtn == null){
      $(".loading").css('display', 'none')
      $(".btn-loading").css('display', 'block')
    }else{
      $("#"+idSpinner).css('display', 'none')
      $("#"+idBtn).css('display', 'block')
    }
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
  if(Array.isArray(value)) return value.length == 0;
  return value == "" || value == null || value == undefined
}

function isMobile() {
  return /Android|webOS|iPhone|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)
}

new DataTable('.data-table', {
  language: {
      url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
  },
});
function refreshTables() {
  feather.replace();
}

//SET DATATABLE SIZES
setTimeout(() => {
  let initSize = 5
  let sizes = [5, 10, 20, 50, 100]
  let options = ""
  sizes.forEach((num) => {
      options += `<option value='${num}'>${num}</option>`
  }) 
  $(".form-select-sm").html(options);
  $(".form-select-sm").val(initSize);
  $(".form-select-sm").trigger("change");
}, 1 * 1000);

$('body').on('click', 'button.fc-prev-button', function () {
  if(jQuery.isFunction('callbackPrevCalendar')) callbackPrevCalendar();
});
$('body').on('click', 'button.fc-next-button', function () {
  if(jQuery.isFunction('callbackNextCalendar')) callbackNextCalendar();
});

if(isMobile()) {
  let element = document.getElementById("content")
  element.addEventListener("click", function (e) {
    $("#db-wrapper").removeClass("toggled")
  });
}

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

jQuery.datetimepicker.setLocale('es');

jQuery('.datetimepicker').datetimepicker({
 i18n:{
  es:{
   months:[
    'Enero','Febrero','Marzo','Abril',
    'Mayo','Junio','Julio','Agosto',
    'Septiembre','Octubre','Noviembre','Diciembre',
   ],
   dayOfWeek:[
    "Do", "Lu", "Ma", "Mi",
    "Ju", "Vi", "Sa",
   ]
  }
 },
 timepicker: true,
 format:'Y-m-d H:i'
});

jQuery('.datepicker').datetimepicker({
  i18n:{
   es:{
    months:[
     'Enero','Febrero','Marzo','Abril',
     'Mayo','Junio','Julio','Agosto',
     'Septiembre','Octubre','Noviembre','Diciembre',
    ],
    dayOfWeek:[
     "Do", "Lu", "Ma", "Mi",
     "Ju", "Vi", "Sa",
    ]
   }
  },
  timepicker: false,
  format:'Y-m-d'
 });




function addZero(i) {
  if (i < 10) {i = "0" + i}
  return i;
}

function getHour(d) {
  let h = addZero(d.getHours());
  let m = addZero(d.getMinutes());
  let s = addZero(d.getSeconds());
  return h + ":" + m;
}


function parseDateEventShow(strDate) {
  var currentdate = new Date(strDate); 
  let year = currentdate.getFullYear()
  let month = addZero(currentdate.getMonth() + 1)
  let day	= 	addZero(currentdate.getDate())
  let hour = 	addZero(currentdate.getHours())
  let minute = addZero(currentdate.getMinutes())
  let second = addZero(currentdate.getSeconds())
  let res = `${year}-${month}-${day} ${hour}:${minute}`;  
  currentdate = null; 
  year = null;
  month = null;
  day = null;
  hour = null;
  minute = null;
  second = null;
  return res;
}

$('.daterangepicker').daterangepicker({
  timePicker: true,
  startDate: moment().startOf('hour'),
  endDate: moment().startOf('hour').add(32, 'hour'),
  locale: {
    format: 'M/DD hh:mm A'
  }
});