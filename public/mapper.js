function setDataSelect(array, valueName, textName, idSelectInput, emptyOption = true) {
    let options = ""
    if(emptyOption) options += `<option value=""></option>`
    array.forEach(element => {
        options += `<option value="${element[valueName]}">${element[textName]}</option>`
    });
    $("#"+idSelectInput).html(options)
}