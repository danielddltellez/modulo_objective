$.datepicker.regional['es'] = {
    closeText: 'Cerrar',
    prevText: '< Ant',
    nextText: 'Sig >',
    currentText: 'Hoy',
    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
    dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
    dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
    dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
    weekHeader: 'Sm',
    dateFormat: 'dd/mm/yy',
    firstDay: 1,
    isRTL: false,
    showMonthAfterYear: false,
    yearSuffix: ''
};
$.datepicker.setDefaults($.datepicker.regional['es']);
$(function() {
    $("#datepicker").datepicker();
});

function openCity(cityName) {
    var i;
    var x = document.getElementsByClassName("vistas");
    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
    }
    document.getElementById(cityName).style.display = "block";
}

function revFechaI(obj) {
    fechaI = "#fechainicio" + obj;
    valfechaI = $(fechaI).val();
    fechaF = "#fechafinal" + obj;
    valfechaF = $(fechaF).val();
    //fechaEst=$.datepicker.formatDate('yy-mm-dd', new Date());
    fechaEst = $("fechaobjetivo").val();

    var duracion = calduracion(valfechaI, fechaEst);
    if (duracion < 0) {
        alert('la fecha inicial no puede ser menor a la fecha de establecimiento');
        $(fechaI).css('color', '#FF0000');
        $("#btnEnviar").attr('disabled', true);
        return 0;
    } else {
        $(fechaI).css('color', '#000000');
        var result = revFechaF(obj);
        $("#btnEnviar").attr('disabled', false);
        return result;
    }
}

//Verifica que la fecha final no sea mayor a 18 meses con relación a la fecha inicial
function revFechaF(obj) {
    var fechai = veriFIni(obj);
    if (fechai != 0) {
        fechaF = "#fechafinal" + obj;
        valfechaF = $(fechaF).val();
        fechaI = "#fechainicio" + obj;
        var duracion = calduracion(valfechaF, fechai);
        duracion = duracion.toFixed();
        if (duracion > 540) {
            alert('la fecha final no puede ser mayor a 18 meses');
            $(fechaF).css('color', '#FF0000');
            $("#btnEnviar").attr('disabled', true);
            return 0;
        } else if (duracion <= 0) {
            alert('la fecha final no puede ser menor a la fecha inicial');
            $(fechaI).css('color', '#FF0000');
            $(fechaF).css('color', '#FF0000');
            $("#btnEnviar").attr('disabled', true);
            return 0;
        } else {
            //cambia color a negro
            $(fechaI).css('color', '#000000');
            $(fechaF).css('color', '#000000');
            $("#btnEnviar").attr('disabled', false);
            return 1;
        }
    } else {
        return 0;
    }
}

function veriFIni(obj) {
    fechaI = "#fechainicio" + obj;
    valfechaI = $(fechaI).val();

    if (valfechaI != '') {
        return valfechaI;
    } else {
        alert('Indique una fecha de inicio');
        $(fechaI).css('color', '#FF0000');
        $("#btnEnviar").attr('disabled', true);
        return 0;
    }
}

function calduracion(fechai, fechae) {
    var fechaini = calfecha(fechai);
    var fechaest = calfecha(fechae);
    var duracion = parseInt((fechaini - fechaest) / (1000 * 60 * 60 * 24));
    return duracion;
}

function calfecha(fechatxt) {
    var ms = Date.parse(fechatxt);
    var fecha = new Date(ms);
    return fecha;
}

function sumapobj(pobj) {
    var pobjs = new Array(6)

    for (var i = 1; i <= 6; i++) {
        porcentajeObj = "#valorobjetivo" + i;
        pobjs[i - 1] = $(porcentajeObj).val();
        if (pobjs[i - 1] == "0") {
            pobjs[i - 1] = 0.0;
        } else if (pobjs[i - 1] == "") {
            pobjs[i - 1] = 0.0;
        } else if (pobjs[i - 1] >= 100) {
            $(porcentajeObj).val("");
            pobjs[i - 1] = 0.0;

        }
    }

    var suma = parseInt(pobjs[0]) + parseInt(pobjs[1]) + parseInt(pobjs[2]) + parseInt(pobjs[3]) + parseInt(pobjs[4]) + parseInt(pobjs[5]);

    suma = suma.toFixed(2);
    //	alert("Suma: "+suma);
    if (suma < 100) {
        $("#btnEnviar").attr('disabled', true);
        for (var i = 1; i <= 6; i++) {
            porcentajeObj = "#valorobjetivo" + i;
            $(porcentajeObj).css('color', '#FF0000');
        }
        //        alert("La suma de los valores de Objetivo no debe ser menor al 100%");
        return 0;
    } else if (suma > 100) {
        $("#btnEnviar").attr('disabled', true);
        for (var i = 1; i <= 6; i++) {
            porcentajeObj = "#valorobjetivo" + i;
            $(porcentajeObj).css('color', '#FF0000');
        }
        alert("La suma de los valores de Objetivo no debe ser mayor al 100%");
        return 0;
    } else {
        $("#btnEnviar").attr('disabled', false);
        for (var i = 1; i <= 6; i++) {
            porcentajeObj = "#valorobjetivo" + i;
            $(porcentajeObj).css('color', '#000000');
        }
        return 1;
    }
    //    calREspInt();
}

function concatena(obj) {
    //alert(obj);
    var como = "#como" + obj;
    var vcomo = $(como).val();
    //alert (vcomo);

    var cuanto = "#cuanto" + obj;
    var vcuanto = $(cuanto).val();
    //alert (vcuanto);

    var que = "#que" + obj;
    var vque = $(que).val();
    //alert (vque);

    var especifica = "#especifica" + obj;
    var vespecifica = $(especifica).val();
    //alert (vespecifica);

    var periodo = "#periodo" + obj;
    var vperiodo = $(periodo).val();
    //alert (vperiodo);

    var objetivocompleto = "#objetivocompleto" + obj;
    //	var valperiodo=$(periodo).val();

    if (vcomo != "" && vcuanto != "" && vque != "" && vespecifica != "" && vperiodo != "") {
        var objCompleto = vcomo + " " + vcuanto + " " + vque + " " + vespecifica + " " + vperiodo;
        //alert ($(objetivocompleto).val());
        //		$(objetivocompleto).val()=objCompleto;
        $(objetivocompleto).val(objCompleto);
    }
}

//Revisa todo
function revAll() {

    var resultF = 1;
    var resultO = 1;
    var objetivocompleto = "";
    for (var i = 1; i <= 6; i++) {

        objetivocompleto = "#objetivocompleto" + i;
        valobjetivocompleto = $.trim($(objetivocompleto).val());
        //		$.trim($("#comment").val())
        //alert(valobjetivocompleto);
        if (i >= 1) {
            if (valobjetivocompleto == "") {
                //alert(valobjetivocompleto);
                porcentajeObj = "#valorobjetivo" + i;
                $(porcentajeObj).val("");
                continue;
            } else {
                resultF = revFechaI(i);
                if (resultF == 0) {
                    $("#btnEnviar").attr('disabled', true);
                    return;
                }
            }
        } else {
            resultF = revFechaI(i);
            if (resultF == 0) {
                $("#btnEnviar").attr('disabled', true);
                return;
            }
        }
    }
    resultO = sumapobj(i);

    if (resultF == 1 && resultO == 1) {

        $("#btnEnviar").attr('disabled', false);

        $("#btnEnviar").click();




    } else {
        $("#btnEnviar").attr('disabled', true);
    }
}

//Promedia Competencias en Revisión 1
function promediaComp(inicio, tam) {
    var radioName = "";
    //	alert($("input[name='valores[1][valor]']:checked").val());
    tam = inicio + tam;
    var valorfinal = "valorfinal" + tam;
    var valorfinalvista = "valorfinalvista" + tam;
    var prom = contadorc = 0;
    for (var i = inicio; i < tam; i++) {
        //		radioName="valores["+i+"][valor]";
        //		alert($("input[name='"+radioName+"']:checked").val());
        //        alert($("input[name1='"+i+"']:checked").val());
        //        if($("input[name1='"+radioName+"']:checked").val() >= 1 || $("input[name='"+radioName+"']:checked").val() <=4){
        if ($("input[name1='" + i + "']:checked").val() >= 1 || $("input[name1='" + i + "']:checked").val() <= 4) {
            //			prom=parseInt(prom)+parseInt($("input[name='"+radioName+"']:checked").val());
            prom = parseInt(prom) + parseInt($("input[name1='" + i + "']:checked").val());
            contadorc++;
        }
    }
    if (contadorc > 0) {
        prom = prom / contadorc;
        prom = prom.toFixed(2);
        $("input[name1='" + valorfinal + "']").val(prom);
        $("input[name1='" + valorfinalvista + "']").val(prom);
    }
}

//Pronedia competencias en Revisión final
function promediaCompf(inicio, tam) {
    var radioName = "";
    tam = inicio + tam;
    var valorfinal = "valorfinal" + tam;
    var valorfinalvista = "valorfinalvista" + tam;
    var prom = contadorc = 0;
    for (var i = inicio; i < tam; i++) {
        if ($("input[name2='" + i + "']:checked").val() >= 1 || $("input[name2='" + i + "']:checked").val() <= 4) {
            prom = parseInt(prom) + parseInt($("input[name2='" + i + "']:checked").val());
            contadorc++;
        }
    }
    if (contadorc > 0) {
        prom = prom / contadorc;
        prom = prom.toFixed(2);
        $("input[name2='" + valorfinal + "']").val(prom);
        $("input[name2='" + valorfinalvista + "']").val(prom);
    }
}

function validaJFinal(obj) {

    var valobj = parseFloat($(obj).val());

    if (valobj < 0 || valobj > 100 || isNaN(valobj)) {
        alert("Proporcione un valor entre 0 y 100");
        $(obj).val("");
        $(obj).focus();
    }
}


function validaCFinal(obj) {

    var valobj = parseFloat($(obj).val());

    if (valobj < 0 || valobj > 100 || isNaN(valobj)) {
        alert("Proporcione un valor entre 0 y 100");
        $(obj).val("");
        $(obj).focus();
    }
}





$(document).on('ready', function() {

    //Eventos relacionados con la comprobación de fechas en los objetivos
    $("#fechainicio1").change(function() {
        revFechaI(1);
    });
    $("#fechafinal1").change(function() {
        revFechaI(1);
    });
    $("#fechainicio2").change(function() {
        revFechaI(2);
    });
    $("#fechafinal2").change(function() {
        revFechaI(2);
    });
    $("#fechainicio3").change(function() {
        revFechaI(3);
    });
    $("#fechafinal3").change(function() {
        revFechaI(3);
    });
    $("#fechainicio4").change(function() {
        revFechaI(4);
    });
    $("#fechafinal4").change(function() {

        revFechaI(4);
    });
    $("#fechainicio5").change(function() {
        revFechaI(5);
    });
    $("#fechafinal5").change(function() {
        revFechaI(5);
    });
    $("#fechainicio6").change(function() {
        revFechaI(6);
    });
    $("#fechafinal6").change(function() {
        revFechaI(6);
    });


    //Eventos relacionados al cáculo de la suma de objetivos 100%
    $("#valorobjetivo1").change(function() {
        sumapobj(1);
    });
    $("#valorobjetivo2").change(function() {
        sumapobj(2);
    });
    $("#valorobjetivo3").change(function() {
        sumapobj(3);
    });
    $("#valorobjetivo4").change(function() {
        sumapobj(4);
    });
    $("#valorobjetivo5").change(function() {
        sumapobj(5);
    });
    $("#valorobjetivo6").change(function() {
        sumapobj(6);
    });

    // Eventos relacionados para armado de objetivos
    $("#como1").change(function() {
        concatena(1);
    });
    $("#cuanto1").change(function() {
        concatena(1);
    });
    $("#que1").change(function() {
        concatena(1);
    });
    $("#especifica1").change(function() {
        concatena(1);
    });
    $("#periodo1").change(function() {
        concatena(1);
    });


    $("#como2").change(function() {
        concatena(2);
    });
    $("#cuanto2").change(function() {
        concatena(2);
    });
    $("#que2").change(function() {
        concatena(2);
    });
    $("#especifica2").change(function() {
        concatena(2);
    });
    $("#periodo2").change(function() {
        concatena(2);
    });


    $("#como3").change(function() {
        concatena(3);
    });
    $("#cuanto3").change(function() {
        concatena(3);
    });
    $("#que3").change(function() {
        concatena(3);
    });
    $("#especifica3").change(function() {
        concatena(3);
    });
    $("#periodo3").change(function() {
        concatena(3);
    });


    $("#como4").change(function() {
        concatena(4);
    });
    $("#cuanto4").change(function() {
        concatena(4);
    });
    $("#que4").change(function() {
        concatena(4);
    });
    $("#especifica4").change(function() {
        concatena(4);
    });
    $("#periodo4").change(function() {
        concatena(4);
    });


    $("#como5").change(function() {
        concatena(5);
    });
    $("#cuanto5").change(function() {
        concatena(5);
    });
    $("#que5").change(function() {
        concatena(5);
    });
    $("#especifica5").change(function() {
        concatena(5);
    });
    $("#periodo5").change(function() {
        concatena(5);
    });


    $("#como6").change(function() {
        concatena(6);
    });
    $("#cuanto6").change(function() {
        concatena(6);
    });
    $("#que6").change(function() {
        concatena(6);
    });
    $("#especifica6").change(function() {
        concatena(6);
    });
    $("#periodo6").change(function() {
        concatena(6);
    });


    $("#BTNvalida").click(function() {
        revAll();
    });


    //Evento para promediar competencias En revisión 1
    $("input[name1='1']").change(function() {
        promediaComp(1, 4);
    });
    $("input[name1='2']").change(function() {
        promediaComp(1, 4);
    });
    $("input[name1='3']").change(function() {
        promediaComp(1, 4);
    });
    $("input[name1='4']").change(function() {
        promediaComp(1, 4);
    });
    $("input[name1='valorfinal5']").change(function() {
        //		validaCompetencias('valorfinal5',1,4);
        promediaComp(1, 4);
    });
    $("input[name1='valorfinalvista5']").change(function() {
        //		validaCompetencias('valorfinalvista5',1,4);
        promediaComp(1, 4);
    });


    $("input[name1='7']").change(function() {
        promediaComp(7, 3);
    });
    $("input[name1='8']").change(function() {
        promediaComp(7, 3);
    });
    $("input[name1='9']").change(function() {
        promediaComp(7, 3);
    });
    $("input[name1='valorfinal10']").change(function() {
        //		validaCompetencias('valorfinal10',7,3);
        promediaComp(7, 3);
    });
    $("input[name1='valorfinalvista10']").change(function() {
        //		validaCompetencias('valorfinalvista10',7,3);
        promediaComp(7, 3);
    });




    $("input[name1='12']").change(function() {
        promediaComp(12, 3);
    });
    $("input[name1='13']").change(function() {
        promediaComp(12, 3);
    });
    $("input[name1='14']").change(function() {
        promediaComp(12, 3);
    });
    $("input[name1='valorfinal15']").change(function() {
        //		validaCompetencias('valorfinal15',12,3);
        promediaComp(12, 3);
    });
    $("input[name1='valorfinalvista15']").change(function() {
        //		validaCompetencias('valorfinalvista15',12,3);
        promediaComp(12, 3);
    });



    $("input[name1='17']").change(function() {
        promediaComp(17, 3);
    });
    $("input[name1='18']").change(function() {
        promediaComp(17, 3);
    });
    $("input[name1='19']").change(function() {
        promediaComp(17, 3);
    });
    $("input[name1='valorfinal20']").change(function() {
        //		validaCompetencias('valorfinal20',17,3);
        promediaComp(17, 3);
    });
    $("input[name1='valorfinalvista20']").change(function() {
        //		validaCompetencias('valorfinalvista20',17,3);
        promediaComp(17, 3);
    });


    $("input[name1='22']").change(function() {
        promediaComp(22, 3);
    });
    $("input[name1='23']").change(function() {
        promediaComp(22, 3);
    });
    $("input[name1='24']").change(function() {
        promediaComp(22, 3);
    });
    $("input[name1='valorfinal25']").change(function() {
        //		validaCompetencias('valorfinal25',22,3);
        promediaComp(22, 3);
    });
    $("input[name1='valorfinalvista25']").change(function() {
        //		validaCompetencias('valorfinalvista25',22,3);
        promediaComp(22, 3);
    });


    $("input[name1='27']").change(function() {
        promediaComp(27, 3);
    });
    $("input[name1='28']").change(function() {
        promediaComp(27, 3);
    });
    $("input[name1='29']").change(function() {
        promediaComp(27, 3);
    });
    $("input[name1='valorfinal30']").change(function() {
        //		validaCompetencias('valorfinal30',27,3);
        promediaComp(27, 3);
    });
    $("input[name1='valorfinalvista30']").change(function() {
        //		validaCompetencias('valorfinalvista30',27,3);
        promediaComp(27, 3);
    });


    //Competencias para Gestor
    $("input[name1='32']").change(function() {
        promediaComp(32, 3);
    });
    $("input[name1='33']").change(function() {
        promediaComp(32, 3);
    });
    $("input[name1='34']").change(function() {
        promediaComp(32, 3);
    });
    $("input[name1='valorfinal35']").change(function() {
        promediaComp(32, 3);
        //		validaCompetencias('valorfinal35',32,3);
    });
    $("input[name1='valorfinalvista35']").change(function() {
        //		validaCompetencias('valorfinalvista35',32,3);
        promediaComp(32, 3);
    });


    $("input[name1='37']").change(function() {
        promediaComp(37, 3);
    });
    $("input[name1='38']").change(function() {
        promediaComp(37, 3);
    });
    $("input[name1='39']").change(function() {
        promediaComp(37, 3);
    });
    $("input[name1='valorfinal40']").change(function() {
        //		validaCompetencias('valorfinal40',37,3);
        promediaComp(37, 3);
    });
    $("input[name1='valorfinalvista40']").change(function() {
        //		validaCompetencias('valorfinalvista40',37,3);
        promediaComp(37, 3);
    });


    $("input[name1='42']").change(function() {
        promediaComp(42, 4);
    });
    $("input[name1='43']").change(function() {
        promediaComp(42, 4);
    });
    $("input[name1='44']").change(function() {
        promediaComp(42, 4);
    });
    $("input[name1='45']").change(function() {
        promediaComp(42, 4);
    });
    $("input[name1='valorfinal46']").change(function() {
        //		validaCompetencias('valorfinal46',42,4);
        promediaComp(42, 4);
    });
    $("input[name1='valorfinalvista46']").change(function() {
        //		validaCompetencias('valorfinalvista46',42,4);
        promediaComp(42, 4);
    });


    //Evento para promediar competencias Revisión final
    $("input[name2='1']").change(function() {
        promediaCompf(1, 4);
    });
    $("input[name2='2']").change(function() {
        promediaCompf(1, 4);
    });
    $("input[name2='3']").change(function() {
        promediaCompf(1, 4);
    });
    $("input[name2='4']").change(function() {
        promediaCompf(1, 4);
    });
    $("input[name2='valorfinal5']").change(function() {
        //		validaCompetencias('valorfinal5',1,4);
        promediaCompf(1, 4);
    });
    $("input[name2='valorfinalvista5']").change(function() {
        //		validaCompetencias('valorfinalvista5',1,4);
        promediaCompf(1, 4);
    });


    $("input[name2='7']").change(function() {
        promediaCompf(7, 3);
    });
    $("input[name2='8']").change(function() {
        promediaCompf(7, 3);
    });
    $("input[name2='9']").change(function() {
        promediaCompf(7, 3);
    });
    $("input[name2='valorfinal10']").change(function() {
        //		validaCompetencias('valorfinal10',7,3);
        promediaCompf(7, 3);
    });
    $("input[name2='valorfinalvista10']").change(function() {
        //		validaCompetencias('valorfinalvista10',7,3);
        promediaCompf(7, 3);
    });




    $("input[name2='12']").change(function() {
        promediaCompf(12, 3);
    });
    $("input[name2='13']").change(function() {
        promediaCompf(12, 3);
    });
    $("input[name2='14']").change(function() {
        promediaCompf(12, 3);
    });
    $("input[name2='valorfinal15']").change(function() {
        //		validaCompetencias('valorfinal15',12,3);
        promediaCompf(12, 3);
    });
    $("input[name2='valorfinalvista15']").change(function() {
        //		validaCompetencias('valorfinalvista15',12,3);
        promediaCompf(12, 3);
    });



    $("input[name2='17']").change(function() {
        promediaCompf(17, 3);
    });
    $("input[name2='18']").change(function() {
        promediaCompf(17, 3);
    });
    $("input[name2='19']").change(function() {
        promediaCompf(17, 3);
    });
    $("input[name2='valorfinal20']").change(function() {
        //		validaCompetencias('valorfinal20',17,3);
        promediaCompf(17, 3);
    });
    $("input[name2='valorfinalvista20']").change(function() {
        //		validaCompetencias('valorfinalvista20',17,3);
        promediaCompf(17, 3);
    });


    $("input[name2='22']").change(function() {
        promediaCompf(22, 3);
    });
    $("input[name2='23']").change(function() {
        promediaCompf(22, 3);
    });
    $("input[name2='24']").change(function() {
        promediaCompf(22, 3);
    });
    $("input[name2='valorfinal25']").change(function() {
        //		validaCompetencias('valorfinal25',22,3);
        promediaCompf(22, 3);
    });
    $("input[name2='valorfinalvista25']").change(function() {
        //		validaCompetencias('valorfinalvista25',22,3);
        promediaCompf(22, 3);
    });


    $("input[name2='27']").change(function() {
        promediaCompf(27, 3);
    });
    $("input[name2='28']").change(function() {
        promediaCompf(27, 3);
    });
    $("input[name2='29']").change(function() {
        promediaCompf(27, 3);
    });
    $("input[name2='valorfinal30']").change(function() {
        //		validaCompetencias('valorfinal30',27,3);
        promediaCompf(27, 3);
    });
    $("input[name2='valorfinalvista30']").change(function() {
        //		validaCompetencias('valorfinalvista30',27,3);
        promediaCompf(27, 3);
    });


    //Competencias para Gestor
    $("input[name2='32']").change(function() {
        promediaCompf(32, 3);
    });
    $("input[name2='33']").change(function() {
        promediaCompf(32, 3);
    });
    $("input[name2='34']").change(function() {
        promediaCompf(32, 3);
    });
    $("input[name2='valorfinal35']").change(function() {
        promediaCompf(32, 3);
        //		validaCompetencias('valorfinal35',32,3);
    });
    $("input[name2='valorfinalvista35']").change(function() {
        //		validaCompetencias('valorfinalvista35',32,3);
        promediaCompf(32, 3);
    });


    $("input[name2='37']").change(function() {
        promediaCompf(37, 3);
    });
    $("input[name2='38']").change(function() {
        promediaCompf(37, 3);
    });
    $("input[name2='39']").change(function() {
        promediaCompf(37, 3);
    });
    $("input[name2='valorfinal40']").change(function() {
        //		validaCompetencias('valorfinal40',37,3);
        promediaCompf(37, 3);
    });
    $("input[name2='valorfinalvista40']").change(function() {
        //		validaCompetencias('valorfinalvista40',37,3);
        promediaCompf(37, 3);
    });


    $("input[name2='42']").change(function() {
        promediaCompf(42, 4);
    });
    $("input[name2='43']").change(function() {
        promediaCompf(42, 4);
    });
    $("input[name2='44']").change(function() {
        promediaCompf(42, 4);
    });
    $("input[name2='45']").change(function() {
        promediaCompf(42, 4);
    });
    $("input[name2='valorfinal46']").change(function() {
        //		validaCompetencias('valorfinal46',42,4);
        promediaCompf(42, 4);
    });
    $("input[name2='valorfinalvista46']").change(function() {
        //		validaCompetencias('valorfinalvista46',42,4);
        promediaCompf(42, 4);
    });


    $("#valorevaluacionjefe1").change(function() {
        validaJFinal('#valorevaluacionjefe1');
    });
    $("#valorevaluacionjefe2").change(function() {
        validaJFinal('#valorevaluacionjefe2');
    });
    $("#valorevaluacionjefe3").change(function() {
        validaJFinal('#valorevaluacionjefe3');
    });
    $("#valorevaluacionjefe4").change(function() {
        validaJFinal('#valorevaluacionjefe4');
    });
    $("#valorevaluacionjefe5").change(function() {
        validaJFinal('#valorevaluacionjefe5');
    });
    $("#valorevaluacionjefe6").change(function() {
        validaJFinal('#valorevaluacionjefe6');
    });


    $("#valorautoevaluacion1").change(function() {
        validaJFinal('#valorautoevaluacion1');
    });
    $("#valorautoevaluacion2").change(function() {
        validaJFinal('#valorautoevaluacion2');
    });
    $("#valorautoevaluacion3").change(function() {
        validaJFinal('#valorautoevaluacion3');
    });
    $("#valorautoevaluacion4").change(function() {
        validaJFinal('#valorautoevaluacion4');
    });
    $("#valorautoevaluacion5").change(function() {
        validaJFinal('#valorautoevaluacion5');
    });
    $("#valorautoevaluacion6").change(function() {
        validaJFinal('#valorautoevaluacion6');
    });

    $("#BTNvalida1").click(function() {
        validaCompetencias();
    });
});