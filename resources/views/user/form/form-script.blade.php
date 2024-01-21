<script>
    $(document).ready(() => {
        
    })

    function findRegisters(value) {
        console.log(value);
        var availableTags = [
        "ActionScript",
        "AppleScript",
        "Asp",
        "BASIC",
        "C",
        "C++",
        "Clojure",
        "COBOL",
        "ColdFusion",
        "Erlang",
        "Fortran",
        "Groovy",
        "Haskell",
        "Java",
        "JavaScript",
        "Lisp",
        "Perl",
        "PHP",
        "Python",
        "Ruby",
        "Scala",
        "Scheme"
        ];
        $("#register").autocomplete({
            source: availableTags
        });
        $("#register").autocomplete("search");
    }
</script>