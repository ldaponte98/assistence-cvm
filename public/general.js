$('.select2').select2( {
    theme: 'bootstrap-5'
});

function showAlert(titulo = "Información", mensaje, tipo = "info") {
  Swal.fire({
    title: titulo,
    text: mensaje,
    icon: tipo,
    confirmButtonText: 'Aceptar'
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