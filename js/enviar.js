$(document).on('ready', function() {

            $('#establecimientoobj').parsley().on('field:validated', function() {
                var ok = $('.parsley-error').length === 0;
                $('.bs-callout-info').toggleClass('hidden', !ok);
                $('.bs-callout-warning').toggleClass('hidden', ok);
            })

            $('#btn-ingresar').click(function() {
                var url = "envio.php";

                $.ajax({
                    type: "POST",
                    url: url,
                    data: $("#formulario").serialize(),
                    success: function(data) {
                        $('#resp').html(data);
                    }
                });
            });
            /*
                .on('form:submit', function() {

                    $.ajax({
                        type: $(this).attr("method"),
                        url: $(this).attr("action"),
                        data: $(this).serialize(),
                        beforeSend: function() {
                            /*
                             * Esta función se ejecuta durante el envió de la petición al
                             * servidor.
                             * */
            // btnEnviar.text("Enviando"); Para button 
            /*          btnEnviar.val("Enviando"); // Para input de tipo button
                      btnEnviar.attr("disabled", "disabled");
                  },
                  complete: function(data) {
                      /*
                       * Se ejecuta al termino de la petición
                       * */
            /*       btnEnviar.val("Enviar formulario");
                   btnEnviar.removeAttr("disabled");
               },
               success: function(data) {
                   /*
                    * Se ejecuta cuando termina la petición y esta ha sido
                    * correcta
                    * */
            /*              location.reload(true);
                      },
                      error: function(data) {
                          /*
                           * Se ejecuta si la peticón ha sido erronea
                           * */
            /*              alert("Problemas al tratar de enviar el formulario");
                      }
                  });
                  // Nos permite cancelar el envio del formulario
                  return false;


              });*/