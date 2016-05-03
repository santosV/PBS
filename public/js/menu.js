$(document).ready(function(){ 

 $("#paninis").imagepicker({
    hide_select: true,
    show_label: true
    });

     $("#hambur").imagepicker({
    hide_select: true,
    show_label: true
    });
    

     $("#items").imagepicker({
    hide_select: true,
    show_label: true
    });
    
    $("#sopas").imagepicker({
    hide_select: true,
    show_label: true
    });
    
    $("#cremas").imagepicker({
    hide_select: true,
    show_label: true
    }); 
    
    $("#baguets").imagepicker({
    hide_select: true,
    show_label: true
    });
    
    $("#lasagna").imagepicker({
    hide_select: true,
    show_label: true
    }); 
    
    $("#platillos").imagepicker({
    hide_select: true,
    show_label: true
    }); 
    
    $("#pastas").imagepicker({
    hide_select: true,
    show_label: true
    });
    
    $("#frutas").imagepicker({
    hide_select: true,
    show_label: true
    });
    
    $("#desayunos").imagepicker({
    hide_select: true,
    show_label: true
    });
    
    $("#omelets").imagepicker({
    hide_select: true,
    show_label: true
    }); 
    $("#bebidas").imagepicker({
    hide_select: true,
    show_label: true
    });
     $("#armaCombo").imagepicker({
    limit_reached: function(){alertify.error("Opss..! Solo puedes elegir dos opciones.");},
         hide_select: true,
         show_label: true,
         limit: 2
    });
     $("#pollos_mariscos2").imagepicker({
    hide_select: true,
    show_label: true,
         limit: 0
    });
     $("#items").imagepicker({
    hide_select: true,
    show_label: true,
         limit: 1
    });
    $("#barra_fria2").imagepicker({
    hide_select: true,
    show_label: true,
    limit: 0
    });
    $("#aderezos2").imagepicker({
    hide_select: true,
    show_label: true,
    limit: 0
    });
    $("#extras2").imagepicker({
    hide_select: true,
    show_label: true,
    limit: 0
    });
    //validaciones y limites.
    $("#pollos_mariscos2").imagepicker({
         limit_reached: function(){alertify.error("Opss..! Ingredientes superados.");},
         hide_select: true,
         show_label: true,
         limit: 1  
     }); 
         $("#barra_fria2").imagepicker({
         limit_reached: function(){alertify.error("Opss..! Ingredientes superados.");},
         hide_select: true,
         show_label: true,
         limit: 3
     });
        $("#aderezos2").imagepicker({
         limit_reached: function(){alertify.error("Opss..! Ingredientes superados.");},
         hide_select: true,
         show_label: true,
         limit: 2
     });

        $("#extras2").imagepicker({
         limit_reached: function(){alertify.error("Opss..! Ingredientes superados.");},
         hide_select: true,
         show_label: true,
         limit:1
     });
    
    $('.SiguienteCombo').click(function(){
    var select=$("select option:selected").val();
        console.log(select);
    if(select =='nada'){
         alertify.error("Ops..! Falta seleccionar 1 producto.");
     }else{
      $('.nav-tabs > .active').next('li').find('a').trigger('click');  
     $('html, body').animate({scrollTop: '0px'}, 50);
     }
    });
        
       

   
    
});//fin documento ready