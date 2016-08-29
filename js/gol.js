var dim=8;
var larg=jQuery("#placeholder").width();
var sizex=0;
var iteration=1000;
console.log(sizex);
console.log(larg);
if( larg > 1023 ){
	sizex=1024/dim;
}else{
	sizex=larg/dim;
}
console.log(sizex);
var size=60/(2*dim/10);
var bbTerrarium = new terra.Terrarium
(sizex,size,"GameOfLife",dim,document.getElementById('placeholder'));

terra.registerCreature({
  type: 'piante',
  color: [0, 120, 0],
  size: 10,
  initialEnergy: 5,
  maxEnergy: 20,
  wait: function() {
    this.energy += 1;
  },
  move: false,
  reproduceLv: 0.65
});

terra.registerCreature({
  type: 'lupi',
  color: [0, 255, 255],
  maxEnergy: 50,
  initialEnergy: 10,
  size: 20
});

terra.registerCreature({
  type: 'leoni',
  color: [241, 196, 15],
  initialEnergy: 20,
  reproduceLv: 0.6,
  sustainability: 3
});

bbTerrarium.grid = bbTerrarium.makeGridWithDistribution([['piante', 50], ['lupi', 2], ['leoni', 2]]);
bbTerrarium.animate(iteration);
//jQuery("#out").show();
