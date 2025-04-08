<script>
    const urlValidatePeople = "{{env('APP_URL')}}/people/find-by-phone/"

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

    
    async function validatePhoneExist() {
        let value = $("#phone-validation").val()
        if(isEmpty(value)){
            showAlert("Error", "El numero telefonico es obligatorio", "error")
            return;
        }
        setLoading(true)
        try {
            let validation = await $.get(urlValidatePeople + value)
            setLoading(false)
            if(validation.error) throw validation.message
            let search = validation.data
            if(search != null){
                let message = `Se encontro que el número de telefono pertenece a ${search.fullname + " " + search.lastname} ¿Confirmas que eres tu?`
                showAlert("!Confirma¡", message, "info", () => {
                    sendExistingPeople(search)
                }, null, "Sí", "Cancelar")
            }else{
                $("#box-group").fadeOut()
                $("#box-new").fadeIn()
                $('input[name="phone"]').val(value)
            }              
        } catch (error) {
            showAlert("Error", error, "error")
            setLoading(false)
        }
    }

    function sendExistingPeople(people) {
        $('input[name="fullname"]').val(people.fullname)
        $('input[name="lastname"]').val(people.lastname)
        $('input[name="phone"]').val(people.phone)
        $('select[name="gender"]').val(people.gender)
        const birthday = people.birthday
        console.log({birthday: birthday})
        if (birthday == null || birthday == undefined || birthday == "") {
            $("#box-group").fadeOut()
            $("#box-new").fadeIn()
        }else{
            console.log({birthday: birthday})
            $('select[name="birthdayDay"]').val(birthday.split("-")[2])
            $('select[name="birthdayMonth"]').val(birthday.split("-")[1])
            $('select[name="birthdayYear"]').val(birthday.split("-")[0])
        }
    }
</script>