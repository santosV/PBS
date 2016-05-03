$(document).ready(function(){
  main_route = "/BSTest/public/";
  var regex = new RegExp("(?!^[0-9]*$)(?!^[a-zA-Z]*$)^([a-zA-Z0-9]{6,30})$");
  var passeval = false;
  $("#pass1").keyup(function(){
    if(!regex.test($(this).val()))
    {
        $(this).css("border-color", "rgba(255, 0, 0, 0.44)");
        passeval = false;
    }
    else{
        $(this).css("border-color", "#ccc");
        passeval = true;
    }
    console.log(passeval);
  });
  $("#pass1").focusout(function(){
    $(this).css("border-color", "#ccc");
  });
  $("#pass1").focusin(function(){
    if(!regex.test($(this).val()))
    {
        $(this).css("border-color", "rgba(255, 0, 0, 0.44)");
        passeval = false;
    }
    else{
        $(this).css("border-color", "#ccc");
        passeval = true;
    }
  });
  //Delete user salad
  $(".deleteUserSalad").click(function(){
        var id = $(this).parent().parent().attr("id");
        var fila = $(this).parent().parent();
        $.ajax({
            type: 'POST',
            url: main_route + 'delete-salad',
            data: {
              id: id,
            },
            success:function(data){
              eliminarFila(fila);
                alertify.success("Eliminado");
            }
        });
  });
    function eliminarFila(fila)
    {
        fila.remove();
    }
  //
  $("#finishSalad").submit(function(e){
    e.preventDefault();
  });
  //Enviar correo de contacto
  $("#contactForm").submit(function(e){
    e.preventDefault();
    var email = $(this).find("#correo").val();
    var name = $(this).find("#nombre").val();
    var telefono = $(this).find("#tel").val();
    var comentarios = $(this).find("#comment").val();
    $.ajax({
            type: 'POST',
            url: main_route + 'send-mail',
            data: {
              body: comentarios,
              from: email,
              name: name,
            },
            success:function(data){
             alertify.success("Enviado");
            }
        });
  });
 //hacer que nav normal se haga fixed hasta top
  var menu = $('.menuHeaderF');
  var menu_offset = menu.offset();

  $(window).on('scroll', function() {
    if($(window).scrollTop() > menu_offset.top) {
      menu.addClass('menu-fijo');
    } else {
      menu.removeClass('menu-fijo');
    }
  });
//Opciones menu

//unos
 $('#btnPanini').click(function(){
  $('#paniniM').css("display","block");
  $('#contentMenuCompra').css("display","none");
 $('html, body').animate({scrollTop: '0px'}, 50);
    });

 $('#rPanini').click(function(){
$('#paniniM').css("display","none");
  $('#contentMenuCompra').css("display","block");
 });
//dos
 $('#btnHamburguesa').click(function(){
  $('#hamburguesaM').css("display","block");
  $('#contentMenuCompra').css("display","none");
$('html, body').animate({scrollTop: '0px'}, 50);
    });

 $('#rHamburguesa').click(function(){
  $('#hamburguesaM').css("display","none");
  $('#contentMenuCompra').css("display","block");
 });

//tres
 $('#btnSopasM').click(function(){
  $('#sopasM').css("display","block");
  $('#contentMenuCompra').css("display","none");
     $('html, body').animate({scrollTop: '0px'}, 50);
    });

 $('#rSopas').click(function(){
 $('#sopasM').css("display","none");
  $('#contentMenuCompra').css("display","block");
 });
//cuatro

 $('#btnCremaM').click(function(){
  $('#cremaM').css("display","block");
 $('#contentMenuCompra').css("display","none");
$('html, body').animate({scrollTop: '0px'}, 50);
    });

 $('#rCremas').click(function(){
 $('#cremaM').css("display","none");
 $('#contentMenuCompra').css("display","block");
 });

//cinco

$('#btnBaguetteM').click(function(){
  $('#baguetteM').css("display","block");
 $('#contentMenuCompra').css("display","none");
 $('html, body').animate({scrollTop: '0px'}, 50);   
    });

 $('#rBaguettes').click(function(){
 $('#baguetteM').css("display","none");
 $('#contentMenuCompra').css("display","block");
 });
 //seis

$('#btnLasagnaM').click(function(){
  $('#lasagnaM').css("display","block");
 $('#contentMenuCompra').css("display","none");
    $('html, body').animate({scrollTop: '0px'}, 50);
    });

 $('#rLasagna').click(function(){
  $('#lasagnaM').css("display","none");
 $('#contentMenuCompra').css("display","block");
 });

//siete
$('#btnPlatillosM').click(function(){
  $('#platillosM').css("display","block");
 $('#contentMenuCompra').css("display","none");
    $('html, body').animate({scrollTop: '0px'}, 50);
    });

 $('#rPlatillos').click(function(){
  $('#platillosM').css("display","none");
 $('#contentMenuCompra').css("display","block");
 });

//ocho
$('#btnPastasM').click(function(){
  $('#pastasM').css("display","block");
 $('#contentMenuCompra').css("display","none");
    $('html, body').animate({scrollTop: '0px'}, 50);
    });

 $('#rPastas').click(function(){
  $('#pastasM').css("display","none");
 $('#contentMenuCompra').css("display","block");

});
 //nueve
$('#btnFrutasM').click(function(){
  $('#frutasM').css("display","block");
 $('#contentMenuCompra').css("display","none");
    $('html, body').animate({scrollTop: '0px'}, 50);
    });

 $('#rFrutas').click(function(){
  $('#frutasM').css("display","none");
 $('#contentMenuCompra').css("display","block");

});
//diez
$('#btnDesayunoM').click(function(){
  $('#desayunosM').css("display","block");
 $('#contentMenuCompra').css("display","none");
    $('html, body').animate({scrollTop: '0px'}, 50);
    });

 $('#rDesayunos').click(function(){
  $('#desayunosM').css("display","none");
 $('#contentMenuCompra').css("display","block");

});
 //once
$('#btnOmeletteM').click(function(){
  $('#omelettesM').css("display","block");
 $('#contentMenuCompra').css("display","none");
    $('html, body').animate({scrollTop: '0px'}, 50);
    });

 $('#rOmelettes').click(function(){
  $('#omelettesM').css("display","none");
 $('#contentMenuCompra').css("display","block");

});
 //doce
$('#bntBebidasM').click(function(){
  $('#bebidasM').css("display","block");
 $('#contentMenuCompra').css("display","none");
    $('html, body').animate({scrollTop: '0px'}, 50);
    });

 $('#rBebidas').click(function(){
  $('#bebidasM').css("display","none");
 $('#contentMenuCompra').css("display","block");

});


//fin opciones menu
    $("#message_register").delay(3000).fadeOut();

    // Validacion de formularios
        $("#registerForm").submit(function(e){
            var pass1 = $("#pass1").val();
            var pass2 = $("#pass2").val();
            if(pass1 != pass2)
            {
               alertify.error("Opss..! Las contraseñas no coiciden.");
                e.preventDefault();
            }
        });
    //
    
    //Permite aparecer y desaparecer el menu responsivo.
     $('.btn-menu').on('click',function(){
	   $('nav').toggleClass('mostrar');   
     }); 
     $('li').on('click',function(){
	   $('.menuMobile').removeClass('mostrar');
     }); 
    //Limite de duracion de notificaciones y arranque de notificacion inicial Crea tu ensalada.    
    alertify.set({ delay: 3000 });
    setTimeout(function() {$("#alert_inicial").fadeOut(1500);},5000);
    //llamado del metodo para crear imagenes seleccionables  Crea tu ensalada y validaciones.
    reset_img();
    // Validacion para limites de productos en ensaladas
    $('.btnSiguientevalid').click(function(){
    var select=$("select option:selected").val();
    if(select=='nada'){
         alertify.error("Ops..! Falta tamaño de porción.");
     }else{
     $('.nav-tabs > .active').next('li').find('a').trigger('click');  
     $('html, body').animate({scrollTop: '0px'}, 50);
     }
    });
    //Avanzar o retroceder mediante pasos de crea tu ensalada.
    $('.btnSiguiente').click(function(){
    $('.nav-tabs > .active').next('li').find('a').trigger('click');
    $('html, body').animate({scrollTop: '0px'}, 50); 
    });
    $('.btnAtras').click(function(){
    $('.nav-tabs > .active').prev('li').find('a').trigger('click');
    $('html, body').animate({scrollTop: '0px'}, 50);//nos avienta al inicio de la pagina.
    });
    });
//Fin document ready
//Metodo para crear imagenes seleccionables  Crea tu ensalada y validaciones.
function reset_img(){
    //instancias de select , grupos de imagenes.
    $("#porciones").imagepicker({
    hide_select: true,
    show_label: true
    });
    $("#pollos_mariscos").imagepicker({
    hide_select: true,
    show_label: true,
         limit: 0
    });
    $("#barra_fria").imagepicker({
    hide_select: true,
    show_label: true,
    limit: 0
    });
    $("#aderezos").imagepicker({
    hide_select: true,
    show_label: true,
    limit: 0
    });
    $("#extras").imagepicker({
    hide_select: true,
    show_label: true,
    limit: 0
    });
    //validaciones y limites.
   
$("#porciones").imagepicker({
    hide_select: true,
    show_label: true,
    selected: function(option){
        var values = this.val();
       if(values=='chico'){
          $("#ayudaRMC").html("Selecciona una de las siguientes opciones*"); 
            $("#ayudaRBC").html("Selecciona tres de las siguientes opciones*"); 
            $("#ayudaRAC").html("Selecciona dos de las siguientes opciones*"); 
            $("#ayudaREC").html("Selecciona una de las siguientes opciones*"); 
           
            $("#ayudaRMC").css("display","block"); 
            $("#ayudaRBC").css("display","block"); 
            $("#ayudaRAC").css("display","block"); 
            $("#ayudaREC").css("display","block"); 
            $("#ayudaRMM").css("display","none"); 
            $("#ayudaRBM").css("display","none"); 
            $("#ayudaRAM").css("display","none"); 
            $("#ayudaREM").css("display","none"); 
            $("#ayudaRMG").css("display","none"); 
            $("#ayudaRBG").css("display","none"); 
            $("#ayudaRAG").css("display","none"); 
            $("#ayudaREG").css("display","none"); 
           
         $("#pollos_mariscos").imagepicker({
         limit_reached: function(){
             alertify.confirm("¿Desea añadir 1 ingrediente extra?",
            function (e) {
            if (e) {
         $("#pollos_mariscos").imagepicker({
         limit_reached: function(){
            alertify.error("Opss..! Ingredientes superados.");},
            hide_select: true,show_label: true,limit: 30}); } });
         },   
         hide_select: true,
         show_label: true,
         limit: 1
     }); 
         $("#barra_fria").imagepicker({
         limit_reached: function(){
             alertify.confirm("¿Desea añadir 1 ingrediente extra?",
            function (e) {
            if (e) {
         $("#barra_fria").imagepicker({
         limit_reached: function(){
            alertify.error("Opss..! Ingredientes superados.");},
            hide_select: true,show_label: true,limit: 30}); } });
         },
         hide_select: true,
         show_label: true,
         limit: 3
     });
        $("#aderezos").imagepicker({
         limit_reached: function(){
            alertify.confirm("¿Desea añadir 1 ingrediente extra?",
            function (e) {
            if (e) {
         $("#aderezos").imagepicker({
         limit_reached: function(){
            alertify.error("Opss..! Ingredientes superados.");},
            hide_select: true,show_label: true,limit: 30}); } });        
         },
         hide_select: true,
         show_label: true,
         limit: 2
     });
        $("#extras").imagepicker({
         limit_reached: function(){
             alertify.confirm("¿Desea añadir 1 ingrediente extra?",
            function (e) {
            if (e) {
         $("#extras").imagepicker({
         limit_reached: function(){
            alertify.error("Opss..! Ingredientes superados.");},
            hide_select: true,show_label: true,limit: 30}); } }); 
         },
         hide_select: true,
         show_label: true,
         limit:1
     });
        
       }
        if(values=='mediano'){
             $("#ayudaRMM").html("Selecciona dos de las siguientes opciones*"); 
            $("#ayudaRBM").html("Selecciona cuatro de las siguientes opciones*"); 
            $("#ayudaRAM").html("Selecciona dos de las siguientes opciones*"); 
            $("#ayudaREM").html("Selecciona una de las siguientes opciones*"); 
            
            $("#ayudaRMC").css("display","none"); 
            $("#ayudaRBC").css("display","none"); 
            $("#ayudaRAC").css("display","none"); 
            $("#ayudaREC").css("display","none"); 
            $("#ayudaRMM").css("display","block"); 
            $("#ayudaRBM").css("display","block"); 
            $("#ayudaRAM").css("display","block"); 
            $("#ayudaREM").css("display","block"); 
            $("#ayudaRMG").css("display","none"); 
            $("#ayudaRBG").css("display","none"); 
            $("#ayudaRAG").css("display","none"); 
            $("#ayudaREG").css("display","none"); 
            
        $("#pollos_mariscos").imagepicker({
         limit_reached: function(){
              alertify.confirm("¿Desea añadir 1 ingrediente extra?",
            function (e) {
            if (e) {
         $("#pollos_mariscos").imagepicker({
         limit_reached: function(){
            alertify.error("Opss..! Ingredientes superados.");},
            hide_select: true,show_label: true,limit: 30}); } }); 
         },
         hide_select: true,
         show_label: true,
         limit: 2
     });  
        $("#barra_fria").imagepicker({
         limit_reached: function(){
              alertify.confirm("¿Desea añadir 1 ingrediente extra?",
            function (e) {
            if (e) {
         $("#barra_fria").imagepicker({
         limit_reached: function(){
            alertify.error("Opss..! Ingredientes superados.");},
            hide_select: true,show_label: true,limit: 30}); } }); 
         },
         hide_select: true,
         show_label: true,
         limit: 4
     });
        $("#aderezos").imagepicker({
        limit_reached: function(){
             alertify.confirm("¿Desea añadir 1 ingrediente extra?",
            function (e) {
            if (e) {
         $("#aderezos").imagepicker({
         limit_reached: function(){
            alertify.error("Opss..! Ingredientes superados.");},
            hide_select: true,show_label: true,limit: 30}); } }); 
        },
         hide_select: true,
         show_label: true,
         limit: 2
     });
        $("#extras").imagepicker({
         limit_reached: function(){
              alertify.confirm("¿Desea añadir 1 ingrediente extra?",
            function (e) {
            if (e) {
         $("#extras").imagepicker({
         limit_reached: function(){
            alertify.error("Opss..! Ingredientes superados.");},
            hide_select: true,show_label: true,limit: 30}); } }); 
         },
         hide_select: true,
         show_label: true,
         limit:1
     });
     }
        if(values=='grande'){
             $("#ayudaRMG").html("Selecciona tres de las siguientes opciones*"); 
            $("#ayudaRBG").html("Selecciona cinco de las siguientes opciones*"); 
            $("#ayudaRAG").html("Selecciona dos de las siguientes opciones*"); 
            $("#ayudaREG").html("Selecciona una de las siguientes opciones*"); 
            
            $("#ayudaRMC").css("display","none"); 
            $("#ayudaRBC").css("display","none"); 
            $("#ayudaRAC").css("display","none"); 
            $("#ayudaREC").css("display","none"); 
            $("#ayudaRMM").css("display","none"); 
            $("#ayudaRBM").css("display","none"); 
            $("#ayudaRAM").css("display","none"); 
            $("#ayudaREM").css("display","none"); 
            $("#ayudaRMG").css("display","block"); 
            $("#ayudaRBG").css("display","block"); 
            $("#ayudaRAG").css("display","block"); 
            $("#ayudaREG").css("display","block"); 
        $("#pollos_mariscos").imagepicker({
         limit_reached: function(){
              alertify.confirm("¿Desea añadir 1 ingrediente extra?",
            function (e) {
            if (e) {
         $("#pollos_mariscos").imagepicker({
         limit_reached: function(){
            alertify.error("Opss..! Ingredientes superados.");},
            hide_select: true,show_label: true,limit: 30}); } }); 
         },
         hide_select: true,
         show_label: true,
         limit: 3
     });  
        $("#barra_fria").imagepicker({
         limit_reached: function(){
              alertify.confirm("¿Desea añadir 1 ingrediente extra?",
            function (e) {
            if (e) {
         $("#barra_fria").imagepicker({
         limit_reached: function(){
            alertify.error("Opss..! Ingredientes superados.");},
            hide_select: true,show_label: true,limit: 30}); } }); 
         },
         hide_select: true,
         show_label: true,
         limit: 5
     });
        $("#aderezos").imagepicker({
        limit_reached: function(){
             alertify.confirm("¿Desea añadir 1 ingrediente extra?",
            function (e) {
            if (e) {
         $("#aderezos").imagepicker({
         limit_reached: function(){
            alertify.error("Opss..! Ingredientes superados.");},
            hide_select: true,show_label: true,limit: 30}); } }); 
        },
         hide_select: true,
         show_label: true,
         limit: 2
     });
        $("#extras").imagepicker({
         limit_reached: function(){
              alertify.confirm("¿Desea añadir 1 ingrediente extra?",
            function (e) {
            if (e) {
         $("#extras").imagepicker({
         limit_reached: function(){
            alertify.error("Opss..! Ingredientes superados.");},
            hide_select: true,show_label: true,limit: 30}); } }); 
         },
         hide_select: true,
         show_label: true,
         limit:1
     });
     }
     } 
    });
    };

function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};
