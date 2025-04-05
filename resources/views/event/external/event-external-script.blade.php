<script>
    $(document).ready(() => {
        fillYears()
    })

    function fillYears() {
        let options = `<option selected disabled value="">Año</option>`;  
        current = new Date().getFullYear();
        final = current - 110;
        for (let year = current; year >= final; year--) {
            options += `<option value="${year}">${year}</option>`;  
        }
        $("#select-year").html(options)
    }

    function validate() {
        if ($('input[name="fullname"]').val().trim() == "") { showAlert("Error", "El nombre es obligatorio", "error"); return; }
        if ($('input[name="lastname"]').val().trim() == "") { showAlert("Error", "El apellido es obligatorio", "error"); return; }
        if ($('input[name="phone"]').val().trim() == "") { showAlert("Error", "El número de telefono es obligatorio", "error"); return; }
        if ($('select[name="gender"]').val().trim() == "" || $('select[name="gender"]').val() == null) { showAlert("Error", "El sexo es obligatorio", "error"); return; }
        if ($('select[name="birthdayDay"]').val() == "" || $('select[name="birthdayDay"]').val() == null) { showAlert("Error", "El dia de nacimiento es obligatorio", "error"); return; }
        if ($('select[name="birthdayMonth"]').val() == "" || $('select[name="birthdayMonth"]').val() == null) { showAlert("Error", "El mes de nacimiento es obligatorio", "error"); return; }
        if ($('select[name="birthdayYear"]').val() == "" || $('select[name="birthdayYear"]').val() == null) { showAlert("Error", "El año de nacimiento es obligatorio", "error"); return; }
        if (!validatePhone($('input[name="phone"]').val().trim())) { showAlert("Error", "El número de telefono no es valido", "error"); return; }
        setLoadingFullScreen(true);
        setTimeout(() => {
            $("#form").submit()
        }, 500);
    }

    function validatePhone(phone) {
        if (phone[0] != 3) return false;
        if (phone.trim().length != 10) return false;
        const regexExp = /^(?:\+?57)?(?:\(?(\d{1,3})\)?[\s\-]?)?(\d{3})[\s\-]?(\d{4})$/;
        return regexExp.test(phone);
    }
</script>