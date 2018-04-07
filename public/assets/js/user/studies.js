document.addEventListener("DOMContentLoaded", function () {
    for (let form of document.getElementsByName('submit')) {
        form.addEventListener("click", formSubmit, true);
    }
});

function formSubmit(e) {
    if (this.value == "calculateStudy" && e.isTrusted) {
        let btn = this;
        e.stopPropagation();
        e.preventDefault();

        swal({
            "title": "Confirmación de calculo",
            "text": "Una vez realizado el calculo no podrás realizar cambios, ¿estás seguro?",
            "icon": "info",
            buttons: {
                "cancel": "Cancelar",
                "confirm": "Continuar con el calculo",
            }

        }).then(function (isConfirm) {
            if (isConfirm) {
                btn.click();
            }
        });
    }
}
