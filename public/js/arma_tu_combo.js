var paq=""; 
function armarCombo(){
paq=""
var combo = document.getElementById("armaCombo");
var opciones = combo.options;
 	for (i=1;i<opciones.length;i++) {
		if (opciones[i].selected == true ) {
      		paq += opciones[i].dataset.paq+"-";
		}
  	}
	switch(paq) {
	    case "panini-baguette-":
	        	location.href = "http://localhost/BSTest/public/combo2/?pq=panini&and=baguette";
	        break;
	    case "panini-ensalada-":
	    		location.href = "http://localhost/BSTest/public/combo2/?pq=panini&and=ensalada";
	        break;
	    case "panini-sopa-":
	    		location.href = "http://localhost/BSTest/public/combo2/?pq=panini&and=sopa";
	        break;	
	    case "panini-crema-":
	    		location.href = "http://localhost/BSTest/public/combo2/?pq=panini&and=crema";
	        break;
	    case "baguette-ensalada-":
	    		location.href = "http://localhost/BSTest/public/combo2/?pq=baguette&and=ensalada";
	        break;
	    case "baguette-sopa-":
	    		location.href = "http://localhost/BSTest/public/combo2/?pq=baguette&and=sopa";
	        break;
	    case "baguette-crema-":
	    		location.href = "http://localhost/BSTest/public/combo2/?pq=baguette&and=crema";
	        break;
	    case "ensalada-sopa-":
	    		location.href = "http://localhost/BSTest/public/combo2/?pq=sopa&and=ensalada";
	        break;
	    case "ensalada-crema-":
	    		location.href = "http://localhost/BSTest/public/combo2/?pq=crema&and=ensalada";
	        break;
	    case "sopa-crema-":
	    		location.href = "http://localhost/BSTest/public/combo2/?pq=sopa&and=crema";
	        break;
	    default:
	    	alertify.success("Elige tus dos productos del combo");
	}
}

function registrar(){
	var decide = document.getElementById("nextItem").value;
	var producto = obtener();
		var id = producto.dataset.id;
	if (decide=='ninguno') {
		registrarItem();
	}else if (decide=='ensalada'){
		location.href = "http://localhost/BSTest/public/ensaladas/?pq=t"+"&pt="+btoa(id);
	}else{
		location.href = "http://localhost/BSTest/public/combo2/?pq="+decide+"&pt="+btoa(id);
	}
}

function registrarItem(){
	var producto = obtener();
	var id_producto2 = producto.dataset.id;
	var id_producto1 = atob(document.getElementById('producto1').value);
  $.ajax({
            type: 'POST',
            url: main_route + 'new-combo',
            data: {
              p1: id_producto1,
              p2: id_producto2,
             },
            success:function(data){	
                  alertify.confirm("Añadido al carrito, ¿Desea agregar una bebida?",
            function (e) {
            if (e) {
                  window.location.href = main_route + "menu?b=1";
            }else{
                  window.location.href = main_route + "carrito";
            }
                }); 
            }
        });
}

function obtener(){
	var combo = document.getElementById("items");
	var index = combo.selectedIndex;
	var item = combo.options[index];
	return item;
}

