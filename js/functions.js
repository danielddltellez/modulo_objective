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
	fechaI="#fechainicio"+obj;
	valfechaI=$(fechaI).val();
	fechaF="#fechafinal"+obj;
	valfechaF=$(fechaF).val();
	fechaEst=$.datepicker.formatDate('yy-mm-dd', new Date());

/*    alert("Fecha"+ obj +": "+ $("#fechainicioobj").val());
    alert("Fecha"+ obj +": "+ $(fechaI).val());
    alert("Fecha"+ obj +": "+ $(fechaF).val());
    alert("Fecha establecimiento: "+ fechaEst);
*/	
	
    var duracion = calduracion(valfechaI, fechaEst);
	if(duracion < 0){
        alert('la fecha inicial no puede ser menor a la fecha de establecimiento');
		$(fechaI).css('color', '#FF0000');
	}else{
		$(fechaI).css('color', '#000000');
		revFechaF(obj);
	}
}

//Verifica que la fecha final no sea mayor a 18 meses con relación a la fecha inicial
function revFechaF(obj){
    var fechai = veriFIni(obj);
    if(fechai != 0){
	    fechaF="#fechafinal"+obj;
	    valfechaF=$(fechaF).val();
		fechaI="#fechainicio"+obj;
		var duracion = calduracion(valfechaF, fechai);
		duracion = duracion.toFixed();
		if(duracion >540){
            alert('la fecha final no puede ser mayor a 18 meses');
			$(fechaF).css('color', '#FF0000');
		}else if(duracion <= 0){
			alert('la fecha final no puede ser menor a la fecha inicial');
			$(fechaI).css('color', '#FF0000');
			$(fechaF).css('color', '#FF0000');
		}else{
		    //cambia color a negro
			$(fechaI).css('color', '#000000');
			$(fechaF).css('color', '#000000');
		}
    }
}

function veriFIni(obj){
    fechaI="#fechainicio"+obj;
	valfechaI=$(fechaI).val();
	
    if(valfechaI!=''){
        return valfechaI;
    }else{
        alert('Indique una fecha de inicio');
        $(fechaI).css('color', '#FF0000');
        return 0;
    }
}

function calduracion(fechai, fechae){
    var fechaini = calfecha(fechai);
    var fechaest = calfecha(fechae);
    var duracion = parseInt((fechaini-fechaest)/(1000*60*60*24));
    return duracion;
}

function calfecha(fechatxt){
 var ms = Date.parse(fechatxt);
 var fecha = new Date(ms);
 return fecha;
}

function sumapobj(pobj){
    var pobjs = new Array(6)

    for(var i=1; i<=6; i++){
		porcentajeObj="#valorobjetivo"+i;
        pobjs[i-1] = $(porcentajeObj).val();
        if(pobjs[i-1]=="0"){
            pobjs[i-1]=0.0;
        }else if(pobjs[i-1]==""){
            pobjs[i-1]=0.0;
        }
    }

   var suma = parseInt(pobjs[0]) + parseInt(pobjs[1]) + parseInt(pobjs[2]) + parseInt(pobjs[3]) + parseInt(pobjs[4]) + parseInt(pobjs[5]);

    suma = suma.toFixed(2);
//	alert("Suma: "+suma);
    if(suma<100){
		$("#btnEnviar").attr('disabled', true);
	    for(var i=1; i<=6; i++){
			porcentajeObj="#valorobjetivo"+i;
			$(porcentajeObj).css('color', '#FF0000');
		}
        alert("La suma de los valores de Objetivo no debe ser menor al 100%");
    }else if(suma>100){
		$("#btnEnviar").attr('disabled', true);
	    for(var i=1; i<=6; i++){
			porcentajeObj="#valorobjetivo"+i;
			$(porcentajeObj).css('color', '#FF0000');
		}
        alert("La suma de los valores de Objetivo no debe ser mayor al 100%");
    }else{
		$("#btnEnviar").attr('disabled', false);
	    for(var i=1; i<=6; i++){
			porcentajeObj="#valorobjetivo"+i;
			$(porcentajeObj).css('color', '#000000');
		}
    }
//    calREspInt();
}

function concatena(obj){
	alert(obj);
	var como= "#como"+obj;
	var vcomo=$(como).val();
	alert (vcomo);
	
	var cuanto= "#cuanto"+obj;
	var vcuanto=$(cuanto).val();
	alert (vcuanto);

	var que= "#que"+obj;
	var vque=$(que).val();
	alert (vque);
	
	var especifica= "#especifica"+obj;
	var vespecifica=$(especifica).val();
	alert (vespecifica);
	
	var periodo= "#periodo"+obj;
	var vperiodo=$(periodo).val();
	alert (vperiodo);
	
	var objetivocompleto="objetivocompleto"+obj;
//	var valperiodo=$(periodo).val();

	if(vcomo!="" && vcuanto!="" && vque!="" && vespecifica!="" && vperiodo!=""){
//		alert ("Saludos");
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
    for(var i=1; i<=6; i++ ){
		var como= "#como"+i;
		var cuanto= "#cuanto"+i;
		var que= "#que"+i;
		var especifica= "#especifica"+i;
		var periodo= "#periodo"+i;
		alert("val i: "+i);
		$(como).change(function() {
            concatena(i);
        });
		$(cuanto).change(function() {
            concatena(i);
        });
	    $(que).change(function() {
            concatena(i);
        });
	    $(especifica).change(function() {
            concatena(i);
        });
	    $(periodo).change(function() {
            concatena(i);
        });
	}
});





