$(document).ready(function () {
	$("#combo_pan, #combo_bag, #combo_soc").hide();
	$("#comboPicker").imagepicker()
	$("#btnCombo").click(function(){
		var ing = [];
		$("#comboPicker :selected").each(function(i, selected){
			ing[i] = $(selected).attr("value");
		});
		if (ing.includes("pan") && ing.includes("bag")) {
			//alert("Panini y Baguette");
			$("#comboContainer").html("").append($("#combo_pan"));
			$("#combo_pan").show();
			//$("#combo_pan").appendTo("#comboContainer");
		}
		else if(ing.includes("pan") && ing.includes("ens")){
			alert("Panini y Ensalada");
		}
		else if(ing.includes("pan") && ing.includes("soc")){
			alert("Panini y Sopa o Crema");
		}
		else if(ing.includes("bag") && ing.includes("ens")){
			alert("Baguette y Ensalada");
		}
		else if(ing.includes("bag") && ing.includes("soc")){
			alert("Baguette y Sopa o Crema");
		}
		else if(ing.includes("ens") && ing.includes("soc")){
			alert("Ensalada y Sopa o Crema");
		}
	});
});