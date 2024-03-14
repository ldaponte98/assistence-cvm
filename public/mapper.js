function setDataSelect(array, valueName, textName, idSelectInput, emptyOption = true, emptyOptionText = "", valueSelected = null) {
    let options = ""
    if(emptyOption) options += `<option value="">${emptyOptionText}</option>`
    array.forEach(element => {
        let selected = ""
        if(valueSelected != null && valueSelected == element[valueName]) selected = "selected"
        options += `<option ${selected} value="${element[valueName]}">${element[textName]}</option>`
    });
    $("#"+idSelectInput).html(options)
}