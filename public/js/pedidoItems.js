var pedido;
var productos;
var articulo;
var idItem = 0;
var total=0;
var cantidad=0;


$(document).ready(function() {
    enviar_a_bebidas();
});  
function enviar_a_bebidas(){
    var valor = getUrlVars()["b"];
        if (valor==1) {
            document.getElementById('bntBebidasM').click();
        } 
}

function getUrlVars()
{
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}

function añadirPedido(){	
  $('select.articulos').each(function(){ 
  	 var opciones = this.options;
    for (i=0;i<opciones.length;i++) {
      if (opciones[i].selected == true ) {
          if (!document.getElementById(opciones[i].dataset.id)) {
              $('#pedido').append('<tr id='+opciones[i].dataset.id+'><td>'+opciones[i].dataset.nombre+'</td><td id="precio">'+opciones[i].dataset.precio+'</td><td><div class="form-group"><select onChange="getTotal();"  class="form-control carp_cant cantidad_item" id="'+opciones[i].dataset.id+'"><option >1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option></select></div></td></tr>');
          }
      }else{
          if (document.getElementById(opciones[i].dataset.id)) {
                var fila = document.getElementById(opciones[i].dataset.id);
                fila.parentNode.removeChild(fila);
          }
      }
    } 
  });
  getTotal();
}


function getTotal(){
      total=0;
      $(".cantidad_item").each(function() {
        idItem = $(this).attr('id');
        var elemento = document.getElementById(idItem).firstChild.nextSibling;
        var precio = $(elemento).text();
        var cantidad = $(this).find('option:selected').text();
        total += parseFloat(precio*cantidad);
      });
      $('#total').html('Total: $'+total); 
}

function enviarPedido()
{
  var products_list = {
    products:[]
  }
  $("#tblPList tbody tr").each(function(){
     console.log($(this).attr('id'));
     var cantidad_pcar = $(this).find(".carp_cant option:selected").text();
     products_list.products.push({id:$(this).attr('id'), cantidad: cantidad_pcar});
  })
  $('#pedido').html("");
  $('#total').html("");
  $.ajax({
    type: 'POST',
    url: main_route + 'carrito/additem',
    data: {
      productos: products_list.products,
    },
    success:function(data){

          alertify.confirm("Añadido al carrito, ¿Desea agregar otro producto?",
            function (e) {
            if (e) {
                 window.location.href = main_route + "menu";
            }else{
                  window.location.href = main_route + "carrito";
            }
                }); 
    }
  });
  //var parsed_list = JSON.stringify(products_list.products);
  //alert(parsed_list);
}
