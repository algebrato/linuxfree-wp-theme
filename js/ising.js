var larg=jQuery("#isingDIV").width();
var size=150;  
var dimension=larg/size;
if( dimension > 2 ){
	dimension=2;
}
var IsingModel = new terra.Terrarium(size, size, {
  id: 'IsingTerrarium',
  periodic: true,
  neighborhood: 'vonNeumann',
  cellSize: dimension,
  trails: 0,
  insertAfter: document.getElementById('isingDIV'),
  background: 'transparent'
});




var temp=0.05;
var magnetization = 0;
var counter=0;

terra.registerCA({

  type: 'Ising',    
  colorFn: function ()  
  {
	return this.state==1 ? '255,255,255,255' : '0,0,0,255';
  },
  process: function (neighbors, x, y) 
  {
	counter+=1;
	if (counter==size*size)
	{ 
		counter=magnetization=0;
	}
	magnetization +=this.state;
	if(Math.random() > 0.9 )
	{	
		deltaE = 0;
		for (var i = 0; i < neighbors.length; i++)
			deltaE += neighbors[i].creature.state;
		deltaE *=this.state;  
		if (deltaE<0)
			this.state *= -1;  
		
		else if (Math.random() < Math.min(1.0,Math.exp(-deltaE*0.5/temp)) )
			this.state *= -1; 
	}
	return true;
  }
},function (){
	if(Math.random() < 0.5 ){
		this.state = 1;
	}else{
		this.state = -1;
	}
});
IsingModel.grid = IsingModel.makeGrid('Ising');
IsingModel.draw();
