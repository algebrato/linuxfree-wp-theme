jQuery("#stop").click( function(){
	console.log("Stop");
	IsingModel.stop();
	jQuery("#stop").hide();
	jQuery("#go").show();
});

jQuery("#go").click( function(){
	console.log("Start");
	IsingModel.animate();
	jQuery("#stop").show();
	jQuery("#go").hide();
});

