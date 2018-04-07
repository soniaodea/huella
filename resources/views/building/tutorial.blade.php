<div class="modal fade" tabindex="-1" role="dialog" id="tutorial">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tutorial</h4>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="steps" data-step="0">
                    <div class="step-0">
                        <h5>Introducción</h5>
                        <p class="text-justify">
                            ¡Bienvenido y gracias por unirte! Ya queda menos para dar finalización al cálculo de la huella, durante los siguientes minutos te vamos a explicar los pasos que has de seguir para poder dar finalización a la huella.
                        </p>
                        <p class="text-justify">
                            Vamos a resumirte brevemente lo que vamos a explicar por si no quieres leer todo esto y prefieres investigar por tu cuenta:
                        </p>
                        <ol>
                            <li>Añadir nuevo edificio</li>
                            <li>Inserción de datos (alcances)</li>
                            <li>Realización del cálculo</li>
                            <li>Visualización de estadísticas</li>
                        </ol>
                    </div>
                    <div class="step-1 d-none">
                        <h5>Añadir nuevo edificio</h5>

                        <p class="text-justify">
                            La huella de carbono se realiza por edificios, tendrás que añadir uno nuevo por cada uno que poseas. Para ello entra en el apartado de edificios y pulsa sobre el botón "Añadir edificio" situado bajo la tabla esto te abrirá una ventana en la cual tendrás que insertar el nombre, descripción y otros campos.
                        </p>
                        <p class="text-justify">
                            Una vez finalizada la inserción de los mismos pulsa sobre "Guardar Cambios", se actualizará la página mostrando el edificio en la tabla.
                        </p>
                        <p class="text-justify">
                            Puedes realizar modificaciones de cualquier campo pulsando sobre el lapiz (<i class="fa fa-pencil"></i>), eliminarlo (<i class="fa fa-trash"></i>) o establecer las coordenadas manualmente.
                        </p>
                        <p>
                            <strong>Nota:</strong> si eliminas el edificio también serán eliminados los registros de la huella.
                        </p>
                    </div>
                    <div class="step-2 d-none">
                        <h5>Inserción de datos (alcances)</h5>

                        <p class="text-justify">
                            Ahora que posees al menos un edificio puedes comenzar a completar los alcances para ello pulsa sobre la huella (<i class="fa fa-paw"></i>). Los datos requeridos para realizar el cálculo están divididos en tres apartados:
                        </p>
                        <ul class="list-unstyled">
                            <li>
                                <strong>Alcance 1:</strong>
                                aquí se introducen las emisiones que ha realizado el centro de forma directa. Por ejemplo el gas consumido para cocinar, combustible para la calefacción, etc.
                            </li>
                            <li>
                                <strong>Alcance 2:</strong>
                                en este apartado se tienen en cuenta las emisiones realizadas de forma indirecta, como puede ser la electricidad en cuyo caso dependiendo de la compañia tendrá mayor o menor efecto.
                            </li>
                            <li>
                                <strong>Alcance 3:</strong>
                                otro tipo de emisiones, todas las que no estén contempladas en los previos alcances.
                            </li>
                        </ul>
                        <p class="text-justify">
                            Para poder completar correctamente todos los campos deberás de consultar las facturas, te recomendamos ir completando estos campos cada vez que te llegue la mensualidad debido a que el calculo es anual. De esta forma te será más fácil y comodo.
                        </p>
                    </div>
                    <div class="step-3 d-none">
                        <h5>Realización del cálculo</h5>

                        <p class="test-justify">
                            Una vez hayas terminado con la inserción, a final de año en vez de pulsar sobre "Guardar" has de pulsar sobre "Calcular huella de carbono" de esta forma guardarás los cambios y se realizará el cálculo con lo indicado en los formularios.
                        </p>
                    </div>
                    <div class="step-4 d-none">
                        <h5>Visualización de estadísticas</h5>

                        <p class="text-justify">
                            Una vez realizado el cálculo final podrás ver comparaciones entre los edificios que has introducido y ver una comparativa respecto a otros centros registrados.
                        </p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" name="next">
                    Siguiente
                    <i class="fa fa-arrow-right"></i>
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(function () {
    $("#tutorial").modal("show");
    $("#tutorial [name=next]").on("click", function () {
        let $step = $("#tutorial .steps").first();
        let stepNum = parseInt($step.attr("data-step"));

        if ($("#tutorial .step-" + (stepNum + 1)).length) {

            $(".step-" + stepNum).toggleClass("d-none");
            stepNum++;

            $(".step-" + stepNum).toggleClass("d-none");
            $step.attr("data-step", stepNum);

            // no more steps
            if (!$("#tutorial .step-" + (stepNum + 1)).length) {
                $(this).text("Finalizar");
            }

        } else {
            $(this).parents(".modal").modal("hide");
        }
    });
});
</script>
