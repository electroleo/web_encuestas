<?php header('Content-Type: application/javascript'); ?>
posicionarMenu();

function getQueryVariable(variable) {
   var query = window.location.search.substring(1);
   var vars = query.split("&");
   for (var i=0; i < vars.length; i++) {
       var pair = vars[i].split("=");
       if(pair[0] == variable) {
           return pair[1];
       }
   }
   return false;
}

function checkRut(rut) {
    // Despejar Puntos
    var valor = rut.value.replace('.','');
    // Despejar Guión
    valor = valor.replace('-','');
    
    // Aislar Cuerpo y Dígito Verificador
    cuerpo = valor.slice(0,-1);
    dv = valor.slice(-1).toUpperCase();
    
    // Formatear RUN
    rut.value = cuerpo + '-'+ dv
    
    // Si no cumple con el mínimo ej. (n.nnn.nnn)
    if(cuerpo.length < 7) { rut.setCustomValidity("RUT Incompleto"); return false;}
    
    // Calcular Dígito Verificador
    suma = 0;
    multiplo = 2;
    
    // Para cada dígito del Cuerpo
    for(i=1;i<=cuerpo.length;i++) {
    
        // Obtener su Producto con el Múltiplo Correspondiente
        index = multiplo * valor.charAt(cuerpo.length - i);
        
        // Sumar al Contador General
        suma = suma + index;
        
        // Consolidar Múltiplo dentro del rango [2,7]
        if(multiplo < 7) { multiplo = multiplo + 1; } else { multiplo = 2; }
  
    }
    
    // Calcular Dígito Verificador en base al Módulo 11
    dvEsperado = 11 - (suma % 11);
    
    // Casos Especiales (0 y K)
    dv = (dv == 'K')?10:dv;
    dv = (dv == 0)?11:dv;
    
    // Validar que el Cuerpo coincide con su Dígito Verificador
    if(dvEsperado != dv) { rut.setCustomValidity("RUT Inválido"); return false; }
    
    // Si todo sale bien, eliminar errores (decretar que es válido)
    rut.setCustomValidity('');
}

function validarEmail(email){
    expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (!expr.test(email))
    	return false;
    return true;
        // alert("Error: La dirección de correo " + email + " es incorrecta.");
}

function seteaError(){
	$("#error").fadeOut(500);
}

function activaCampo(value,id)
{
	if(value==true)
	{
		document.getElementById(id).disabled=false;
		document.getElementById(id).required=true;
	}else if(value==false){
		document.getElementById(id).disabled=true;
		document.getElementById(id).required=false;
		document.getElementById(id).value='';
	}
}

function reset_respuesta(value)
{
	if(value==true)
	{
		$('#miform input[type1!=10]').prop('checked', false);
		$('#miform input[type1!=10]').prop('disabled', true);
	}else
		$('#miform input[type1!=10]').prop('disabled', false);
}

function disableEnterKey(e){
	var key; 
	if(window.event){
		key = window.event.keyCode; //IE
	}else{
		key = e.which; //firefox 
	}
	if(key==13){
		return false;
	}else{
		return true;
	}
}

function posicionarMenu() {
    var altura_del_header = $('.top-header').outerHeight(true);
    var altura_del_menu = $('.bottom-header').outerHeight(true);

    if ($(window).scrollTop() >= altura_del_header){
        $('.header-menu').addClass('fixed');
        $('.logo').addClass('logo-fixed');
		$('.top-nav').addClass('top-nav-fixed');
		$('.top-nav-para-fixed').addClass('top-nav-para-fixed-fixed');
        // $('.wrapper').css('margin-top', (altura_del_menu) + 'px');
    } else {
        $('.header-menu').removeClass('fixed');
        $('.logo').removeClass('logo-fixed');
        $('.top-nav').removeClass('top-nav-fixed');
		$('.top-nav-para-fixed').removeClass('top-nav-para-fixed-fixed');
        // $('.wrapper').css('margin-top', '0');
    }
}

jQuery(document).ready(function($) {
	$(".scroll").click(function(event){		
		event.preventDefault();
		$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
	});
	$(window).scroll(function() {    
	    posicionarMenu();
	});

	$("#next").click(function(e){
		e.preventDefault();
        var parametros 	= new Array(),
        	tipo 		= 0,
        	conf 		= false,<?php /*debe confirmar pues se cambiaron las respuestas*/ ?>
        	inicial 	= '',
        	existe 		= ($('#miform input:hidden[type1=6]').val() == 'existe')? true:false,
        	no_contesta = $('#miform input[type1=10]').is(':checked');

        // if(!no_contesta){
        $('#miform :input').each(function(i,val){
        	tipo 	= val.attributes.type1.value;<?php /*tipo son los tipos de pregunta*/ ?>
        	// existe 	= (val.attributes.type6.value == 'existe')? true:false;

        	if( tipo == 1 || tipo == 2 || tipo == 10) <?php /*tipo=1 seleccion simple    tipo=2 seleccion multiple     tipo=10 no_contesta*/ ?>
        	{	
        		inicial = val.attributes.inicial.value;<?php /*verifica si existe respuesta*/ ?>

				if(val.attributes.type.value == 'text')
	        	{
	        		if(val.value.length > 1)
	        			parametros[val.id] = val.value;
	        		else{
	        			swal('Falta Respuesta','Debe completar los campos requeridos','error');
	        			return false;
	        		}
	        	}else{
		        	if(val.checked)
						parametros[val.id] = 'on';

					if( (inicial=='true' && !val.checked) || (inicial=='false' && val.checked) )
						conf=true;
	        	}
	        		
        	}else if(tipo == 3) <?php /*ingreso de texto*/ ?>
        	{
        		if(val.value != '')
	        		parametros[val.attributes.idspan.value] = val.value;
        	}else if(tipo == 4) <?php /*tabla de respuestas*/ ?>
        	{
        		if(val.checked)
					parametros[val.id] = 'on';
        	}
        });

        	// $('#miform').submit(function(){

	        if((tipo!=4 && tipo!=3 && !$.isEmptyObject(parametros)) || 
	        	(tipo==4 && tipo!=3 && Object.keys(parametros).length == ($('table.table tr').size()-2)) || <?php /* menos 2 input que son el hidden que es si existe la pregunta*/ ?>
	        	(tipo!=4 && tipo==3 && Object.keys(parametros).length == ($('#miform :input').size()-2)))   <?php /* y el input del no_contestar*/ ?>
	        {
	        	if( (tipo == 1 || tipo == 2) && conf && existe)
	        	{
					swal({ 
							title: "¿Deseas continuar?", 
							text: "Su respuesta es distinta a la ingresada anteriormente.", 
							type: "info", 
							showCancelButton: true,
							showConfirmButton:true,
							cancelButtonText: "Cancelar", 
							confirmButtonText: "Aceptar", 
							confirmButtonColor: "#0175BA", 
							cancelButtonColor: "#1A232D",
							closeOnConfirm: false,
							showLoaderOnConfirm: true }, 
						function(){ 
							parametros['confirma'] = 'on';
							$.ajax({
					            url: 'ingreso.php',
					            type: 'post',
					            dataType: 'json',
					            data: $.extend({}, parametros),
					            success: function(data) {
					                if(data.final)
					                {
					                	// $('div.fondo-encuesta').unblock();
					                	swal({ 
												title: "Muchas Gracias por tu tiempo!", 
												text: "Todas tus respuestas serán confidenciales", 
												type: "success", 
												showCancelButton: false,
												showConfirmButton:true,
												confirmButtonText: "Finalizar", 
												confirmButtonColor: "#0175BA",
												closeOnConfirm: false,   
												showLoaderOnConfirm: true 
											}, 
											function(){ 
												window.location = "encuesta.php";
											}
										);
					                }else
					                	window.location = "encuesta.php";
					            },
					            error:function(){
					            	// $('div.fondo-encuesta').unblock();
					            	swal('No hay conexión a Internet','Verifique su conexión y vuelva a intentarlo','error');
					            }
				        	});
		                }
					);
	        	}else{
	        		$('div.fondo-encuesta').block({ 
		            	fadeIn: 500,
		            	timeout:1000,
		                message: '<h1><img src="images/loading.gif" />Ingresando Respuesta...</h1>', 
		                css: { border: '1px solid #fff' }, 
		                onBlock: function() { 
							$.ajax({
					            url: 'ingreso.php',
					            type: 'post',
					            dataType: 'json',
					            data: $.extend({}, parametros),
					            success: function(data) {
					                if(data.final)
					                {
					                	$('div.fondo-encuesta').unblock();
					                	swal({ 
												title: "Muchas Gracias por tu tiempo!", 
												text: "Todas tus respuestas serán confidenciales", 
												type: "success", 
												showCancelButton: false,
												showConfirmButton:true,
												confirmButtonText: "Finalizar", 
												confirmButtonColor: "#0175BA",
												closeOnConfirm: false,   
												showLoaderOnConfirm: true 
											}, 
											function(){ 
												window.location = "encuesta.php";
											}
										);
					                }else
					                	window.location = "encuesta.php";
					            },
					            error:function(){
					            	$('div.fondo-encuesta').unblock();
					            	swal('No hay conexión a Internet','Verifique su conexión y vuelva a intentarlo','error');
					            }
					        });
		                }
		            });
	        	} 	
			}else{
				if(tipo != 4 && tipo != 3)
					swal('Ingrese una respuesta.','','warning');
				else
					swal('Ingrese todas las respuestas.','','warning');
			}
	});

	$("#back").click(function(e){
		e.preventDefault();
		$('div.fondo-encuesta').block({ 
        	fadeIn: 500,
        	timeout:1000,
            message: '<h1><img src="images/loading.gif" />Espere...</h1>', 
            css: { border: '1px solid #fff' }, 
            onBlock: function() { 
				$.ajax({
		            url: 'retrocede.php',
		            type: 'post',
		            dataType: 'json',
		            success: function(data) {
		                window.location = "encuesta.php";
		            },
		            error:function(){
		            	$('div.fondo-encuesta').unblock();
		            	swal('No hay conexión a Internet','Verifique su conexión y vuelva a intentarlo','error');
		            }
		        });
			}
		});
	});

	$("#acepta_encuesta").click(function(e){
		e.preventDefault();
		var conta = 0;
		$('#miform2 :input').each(function(i,val){
        	if(val != '')
				conta++;
        });

		if($('#miform2 :input').size() === conta)
		{
			if($('#rut')[0].checkValidity()) <?php /*con datos*/ ?>
			{
				$.ajax({
		            url: 'ingreso.php',
		            type: 'post',
		            dataType: 'json',
		            data: {'acepta':'S','extra_nombre':$('#name')[0].value,'extra_rut':$('#rut')[0].value},
		            success: function(data) {
		            	if(data.success)
		                	location.reload();
		               	else
		               		swal('Algo ha ocurrido',data.mensaje,'error');
		            },
		            error:function(){
		            	swal('No hay conexión a Internet','Verifique su conexión y vuelva a intentarlo','error');
		            }
		        });
	        }else{
	        	swal('Debe ingresar Nombre y Rut en el recuadro correspondiente.','','warning');
	        }			
		}else{
			swal('Para continuar debe aceptar todas las opciones.','','warning');;
		}
	});

	$("#restablecerPass").click(function(e){
		swal({
				title: "Restableciendo Contraseña",
				text: "Ingresa tu correo:",
				type: "input",
				showCancelButton: true,
				closeOnConfirm: false,
				animation: "slide-from-top",
				inputPlaceholder: "ejemplo@correo.cl",
				closeOnConfirm: false,
				showLoaderOnConfirm: true
			},
			function(inputValue){
				if (inputValue === false || inputValue === "") return false;

				// if (inputValue === "") {
				// 	swal.showInputError("You need to write something!");
				// return false;

				if(!validarEmail(inputValue))
				{
					swal.showInputError("Correo no válido");
					return false;
				}

				$.ajax({
		            url: 'reestablece.php',
		            type: 'post',
		            dataType: 'json',
		            data: {'mail':inputValue},
		            success: function(data) {
		                if(data.success)
		                	swal("Un mensaje ha sido enviado a tu cuenta de correo", "Revisa tu correo "+inputValue+"  y sigue los pasos que se indican.", "success");
		                else
		                	swal.showInputError(data.error);
		            },
		            error:function(){
		            	swal('No hay conexión a Internet','Verifique su conexión y vuelva a intentarlo','error');
		            }
	        	});
		});
	});

	$("#pass").submit(function(event){
		var pass1= $("#password").val(),
			pass2= $("#password2").val();
		if(pass1.length >= 6)
		{
			if(pass1 === pass2)
				return;
			else
				$("#error").text("Las contraseñas no son iguales").fadeIn(500);
		}else		
 			$("#error").text("La contraseña debe ser mayor a 6 caracteres").fadeIn(500);

		
		event.preventDefault();
	});


	// if(getQueryVariable('error')==1)
	// 	swal('NO HA INICIADO LA SESION.','','error');

	switch(getQueryVariable('error')){
		case '1':
			swal('No ha iniciado la sesión.','','error');
			break;
		case '2':
			swal('Usuario desconocido.','','error');
			break;
		case '3':
			swal('Si olvidó su contraseña, recuperela en "Restablecer Contraseña"','','error');
			break;
		case '4':
			swal('Contraseña no ingresada, revise y vuelva a intentarlo.','','error');
			break;
		case '5':
			swal('Sesión iniciada, puede continuar su encuesta.','','warning');
			break;
		case '6':
			swal('','','error');
			break;
		case '7':
			swal('Contraseña no válida, contiene espacios.','','error');
			break;
		case '8':
			swal('Contraseña no válida, es menor a 6 caracteres.','','error');
			break;
		case '9':
			swal('','','error');
			break;
		case '10':
			swal('','','error');
			break;
		case '11':
			swal('Las contraseñas ingresadas son distintas.','','error');
			break;
		case '12':
			swal('Validación de suma no es válida.','','error');
			break;
		case '13':
			swal('Contraseña ingresada correctamente.','','success');
			break;
		case '14':
			swal('Contraseña incorrecta','','error');
			break;
		case '15':
			swal('No existe el usuario','','error');
			break;
		default:
			break;
	}
});



