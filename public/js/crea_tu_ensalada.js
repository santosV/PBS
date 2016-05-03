//variables globales
var ingredientes, yeison, dataCookie, lista, contador = 0; ;
var salad_size = '';
$(".salad_size").click(function(){
  alert($(this).val());
});

//Función que calcula a través de cada Item seleccionado en los ingredientes la sumatoria de cada uno de los atributos de calorías.
function calcularCalorias() {
  var calorias=0,TransFat=0, Protein=0, Sugar=0, Fiber=0, Carbo=0, Sod=0, Chol=0, SatFat=0, Fat=0, CalFat=0;
  ingredientes = {};
  $('select.ingrdientes').each(function(){   
     var opciones = this.options;
     for (i=1;i<opciones.length;i++) {
              if (opciones[i].selected == true ) {
                    var cal = opciones[i].dataset.cal;
                    var transfat = opciones[i].dataset.transfat;
                    var protein = opciones[i].dataset.protein;
                    var sugar = opciones[i].dataset.sugar;
                    var fiber = opciones[i].dataset.fiber;
                    var carbo = opciones[i].dataset.carbo;
                    var sod = opciones[i].dataset.sod;
                    var chol = opciones[i].dataset.chol;
                    var satfat = opciones[i].dataset.satfat;
                    var fat = opciones[i].dataset.fat;
                    var calfat = opciones[i].dataset.calfat;
                    calorias += (parseFloat(cal));
                    TransFat += (parseFloat(transfat));
                    Protein += (parseFloat(protein));
                    Sugar += (parseFloat(sugar));
                    Fiber += (parseFloat(fiber));
                    Carbo += (parseFloat(carbo));
                    Sod += (parseFloat(sod));
                    Chol += (parseFloat(chol));
                    SatFat += (parseFloat(satfat));
                    Fat += (parseFloat(fat));
                    CalFat += (parseFloat(calfat)); 
                    ingredientes[opciones[i].dataset.id]= opciones[i].dataset.id;
                 }
              }  
   });
    //se añaden la sumatoria a cada una de las etiquetas.
    $('#cal').html(calorias);
    $('#transfat').html(TransFat+"g");
    $('#protein').html(Protein+"g");
    $('#sugar').html(Sugar+"g");
    $('#fiber').html(Fiber+"g");
    $('#carbo').html(Carbo+"g");
    $('#sod').html(Sod+"mg");
    $('#chol').html(Chol+"mg");
    $('#satfat').html(SatFat+"g");
    $('#fat').html(Fat+"g");
    $('#calfat').html(CalFat+"%");
}

//Función que crea un objeto JSON que contiene cada característica de la ensalada creada (CustomSalad).
function cargarJSON(){
  var name = document.getElementById('name').value;
  var position = document.getElementById('cant').options.selectedIndex; //posicion
  var cantidad_ensaladas = document.getElementById('cant').options[position].text;
  var comment = document.getElementById('comment').value;
  var combo = document.getElementById('combo').value;
  var id_producto;
  try{
      id_producto = atob(document.getElementById('producto1').value);
  } catch(ex){
      id_producto = 0;
  }
      $.ajax({
            type: 'POST',
            url: main_route + 'ensaladas/addsalad',
            data: {
              id: '1',
              idingredientes :ingredientes,
              idUser: '1',
              nombre: name,
              comentarios: comment,
              cantidad: cantidad_ensaladas,
              is_combo: combo,
              id_producto: id_producto
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
//Función que obtiene los datos ingresados y llama a función carrito() y su vez llama a llenarCarrito().
function terminar(){
  cargarJSON();
}

