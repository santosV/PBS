$(document).ready(function(){

	$("#pagarCompra").click(function(){
		pagarTotalCarrito();
	});

    $(".item_detele").click(function(){
        var t = $(this).parent().parent().attr('type');
        var id = $(this).parent().parent().attr('id');
        var fila = $(this).parent().parent();
        var ttl = $("span#total").text().substr(7);
        var dcto = fila.children(".item_ttl").text().substr(1);

        $("span#total").text("Total: "+ (ttl - dcto));
        //alert(t + "-" + id);
        $.ajax({
            type: 'POST',
            url: main_route + 'carrito/delete',
            data: {
                type: t,
                id: id,
            },
            success:function(data){
                // var obj = JSON.parse(data.result);
                // alert(obj.resultado);
                eliminarFila(fila);
                $("span#total").text("Total: "+ (ttl - dcto));
            }
        });
        
    });

    function eliminarFila(fila)
    {
        fila.remove();
    }


    $(".addSaladToCar").click(function(){
        var id = $(this).parent().parent().attr("id");
        var cantidad = $(this).parent().parent().find("select option:selected").text();

        $.ajax({
            type: 'POST',
            url: main_route + 'add-existing-salad',
            data: {
              id: id,
              cantidad: cantidad,
            },
            success:function(data){
             alertify.success("Agregada");
            }
        });
    });

	function pagarTotalCarrito()
	{
		$.ajax({
            type: 'POST',
            url: main_route + 'principal/carrito/pagartotal',
            data: {
              id: '1',
            },
            success:function(data){
              //alert(data.result);
            }
        });
        location.reload();
	}


});

var articulos="";

function pagar(productos){
        var products = productos.split(",");
        var numero_articulo=0;
        $(".obtenerCarrito").each(function() {
            numero_articulo++;
            idItem = $(this).attr('id');
                var index = products.indexOf(idItem);
                var name = atob(atob(products[index+1]));
                var amount = atob(atob(products[index+2]));
                var quantity = atob(atob(products[index+3]));
                pedidos = '<input type="hidden" name="item_name_'+numero_articulo+'" value="'+name+'"><input type="hidden" name="amount_'+numero_articulo+'" value="'+amount+'"><input type="hidden" name="quantity_'+numero_articulo+'" value="'+quantity+'">';
                articulos += pedidos;     
        });
        $('#pedido').append('<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" name="pedidoPaypal"> <input type="hidden" name="cbt" value="Volver a www.bajasalads.com"><input type="hidden" name="cmd" value="_cart"><input type="hidden" name="upload" value="1"><input type="hidden" name="business" value="santosvega.a-facilitator-1@gmail.com"><input type="hidden" name="currency_code" value="MXN">'+articulos+'<input type="hidden" name="return" value="http://localhost/BSTest/public/carrito/"><input type="hidden" name="notify_url" value="http://bajasalads.com/newsite/BSTest/public/user-payment"><input type="hidden" name="cancel_return" value="http://localhost/BSTest/public/carrito/"></form>');
        $.ajax({
            type: 'POST',
            url: main_route + 'user-payment',
            success:function(data){
              //alert(data.result);
              document.pedidoPaypal.submit();
            }
        });
}