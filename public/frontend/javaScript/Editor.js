var canvas;
$(document).ready(function() {
		//setup front side canvas 
 		canvas = new fabric.Canvas('canvasEle', {
		  hoverCursor: 'pointer',
		  selection: true,
		  selectionBorderColor:'blue'
		});
 		canvas.on({
			 'object:moving': function(e) {		  	
			    e.target.opacity = 0.5;
			    var obj = e.target;
				 // if object is too big ignore
				if(obj.currentHeight > obj.canvas.height || obj.currentWidth > obj.canvas.width){
					return;
				}        
				obj.setCoords();        
				// top-left  corner
				if(obj.getBoundingRect().top < 0 || obj.getBoundingRect().left < 0){
					obj.top = Math.max(obj.top, obj.top-obj.getBoundingRect().top);
					obj.left = Math.max(obj.left, obj.left-obj.getBoundingRect().left);
				}
				// bot-right corner
				if(obj.getBoundingRect().top+obj.getBoundingRect().height  > obj.canvas.height || obj.getBoundingRect().left+obj.getBoundingRect().width  > obj.canvas.width){
					obj.top = Math.min(obj.top, obj.canvas.height-obj.getBoundingRect().height+obj.top-obj.getBoundingRect().top);
					obj.left = Math.min(obj.left, obj.canvas.width-obj.getBoundingRect().width+obj.left-obj.getBoundingRect().left);
				}
			  },
			  'object:modified': function(e) {		  	
			    e.target.opacity = 1;
			  },
			 'object:selected':onObjectSelected,
			 'selection:cleared':onSelectedCleared
		 });
		// piggyback on `canvas.findTarget`, to fire "object:over" and "object:out" events
 		canvas.findTarget = (function(originalFn) {
		  return function() {
		    var target = originalFn.apply(this, arguments);
		    if (target) {
		      if (this._hoveredTarget !== target) {
		    	  canvas.fire('object:over', { target: target });
		        if (this._hoveredTarget) {
		        	canvas.fire('object:out', { target: this._hoveredTarget });
		        }
		        this._hoveredTarget = target;
		      }
		    }
		    else if (this._hoveredTarget) {
		    	canvas.fire('object:out', { target: this._hoveredTarget });
		      this._hoveredTarget = null;
		    }
		    return target;
		  };
		})(canvas.findTarget);

 		canvas.on('object:over', function(e) {		
		  //e.target.setFill('red');
		  //canvas.renderAll();
		});
		
 		canvas.on('object:out', function(e) {		
		  //e.target.setFill('green');
		  //canvas.renderAll();
		});
		 		 	 
		document.getElementById('add_text').onclick = function() {
			var text = $("#text-string").val();
			var fontFamily = $(".option-text.selection").attr("data-value");
			if(fontSlugPathMap[fontFamily]){
				fabric.fontPaths[fontFamily] = fontSlugPathMap[fontFamily];
			}

			if(!fontFamily)
				fontFamily='helvetica';
		    var textSample = new fabric.Text(text, {
			      left: fabric.util.getRandomInt(20, 70),
			      top: fabric.util.getRandomInt(20, 70),
			      fontFamily: fontFamily,
			      angle: 0,
			      fill: '#000000',
			      scaleX: 0.5,
			      scaleY: 0.5,
			      fontWeight: '',
		  		  hasRotatingPoint:true
		    });		    
            canvas.add(textSample);	
            canvas.item(canvas.item.length-1).hasRotatingPoint = true;    
            $("#texteditor").css('display', 'block');
            $("#imageeditor").css('display', 'block');
	  	};

	  	$("#text-string").keyup(function(){	  		
	  		var activeObject = canvas.getActiveObject();
		      if (activeObject && activeObject.type === 'text') {
		    	  activeObject.text = this.value;
		    	  canvas.renderAll();
		      }
	  	});  		  
  

	    $('.color-variant .color').on('click', function (e) {
   			var selectedColor = $(this).css("background-color");
   		 	var activeObject = canvas.getActiveObject();
		    if (activeObject && activeObject.type === 'text') {
		      // activeObject.setFill(selectedColor);
		      activeObject.set('fill',selectedColor);
		       canvas.renderAll();
		   }
      	});	 

      $(document).keypress(function(e){
     		if(e.which == 13 && canvas.getActiveObject()) {
       		 canvas.discardActiveObject();
   		 }
	  });
	
	   $("#drawingArea").hover(
	       
	   );
	      
	   //$(".clearfix button,a").tooltip();
		   line1 = new fabric.Line([0,0,200,0], {"stroke":"#000000", "strokeWidth":1,hasBorders:false,hasControls:false,hasRotatingPoint:false,selectable:false});
		   line2 = new fabric.Line([199,0,200,399], {"stroke":"#000000", "strokeWidth":1,hasBorders:false,hasControls:false,hasRotatingPoint:false,selectable:false});
		   line3 = new fabric.Line([0,0,0,400], {"stroke":"#000000", "strokeWidth":1,hasBorders:false,hasControls:false,hasRotatingPoint:false,selectable:false});
		   line4 = new fabric.Line([0,400,200,399], {"stroke":"#000000", "strokeWidth":1,hasBorders:false,hasControls:false,hasRotatingPoint:false,selectable:false});
});

function onObjectSelected(e) {	 
	    var selectedObject = e.target;
	    $("#text-string").val("");
	    selectedObject.hasRotatingPoint = true
	    if (selectedObject && selectedObject.type === 'text') {
	    	//display text editor	    	
	    	$("#texteditor").css('display', 'block');
	    	$("#text-string").val(selectedObject.getText());	    	
	    	$('#text-fontcolor').miniColors('value',selectedObject.fill);
	    	$('#text-strokecolor').miniColors('value',selectedObject.strokeStyle);	 
	    	$("#imageeditor").css('display', 'block');
	    }
	    else if (selectedObject && selectedObject.type === 'image'){
	    	//display image editor
	    	$("#texteditor").css('display', 'none');	
	    	$("#imageeditor").css('display', 'block');	    	
	    }
}

function onSelectedCleared(e){
		 $("#texteditor").css('display', 'none');
		 $("#text-string").val("");
		 $("#imageeditor").css('display', 'none');
		 var canvasObs=canvas.getObjects();
	      for(var ind in canvasObs){
	      	if(canvasObs[ind] && canvasObs[ind].type=="image")
	      		canvasObs[ind].sendToBack();	      	
	      }
	      canvas.renderAll();
}

function zoomInActiveObj(){
       var activeObject = canvas.getActiveObject();
		  if (activeObject && activeObject.type === 'text') {
			 var scaleX = activeObject.scaleX;	
			 var scaleY = activeObject.scaleY;
			 activeObject.set('scaleX',scaleX+0.5);
			 activeObject.set('scaleY',scaleY+0.5);
		     canvas.renderAll();
		  }
}

function zoomOutActiveObj(){
	 	var activeObject = canvas.getActiveObject();
		  if (activeObject && activeObject.type === 'text') {
			 var scaleX = activeObject.scaleX;	
			 var scaleY = activeObject.scaleY;
			 activeObject.set('scaleX',scaleX-0.5);
			 activeObject.set('scaleY',scaleY-0.5);
		     canvas.renderAll();
		  }
}


 function rotateRightActiveObject(){
	 	var activeObject = canvas.getActiveObject();
		  if (activeObject && activeObject.type === 'text') {
		  	 var currentAngle = activeObject.angle;	    
			  activeObject.rotate(currentAngle+10);	    
		    canvas.renderAll();
		  }
}

 function rotateLeftActiveObject(){
	 	var activeObject = canvas.getActiveObject();
		  if (activeObject && activeObject.type === 'text') {
			  var currentAngle = activeObject.angle;	    
			  activeObject.rotate(currentAngle-10);		    	    
		    canvas.renderAll();
		  }
}

function deleteActiveObj(){
	 	var activeObject = canvas.getActiveObject();
		  if (activeObject /*&& activeObject.type === 'text'*/) {
			  canvas.remove(activeObject);		    
		    canvas.renderAll();
		  }
}

 function addImageTocanvasByURL(imgURL){
	 		var left = fabric.util.getRandomInt((mapingBackgroundInfo.width/2)-50, mapingBackgroundInfo.width/2);
	        var top = fabric.util.getRandomInt((mapingBackgroundInfo.height/2)-50, mapingBackgroundInfo.height/2);
	        var angle = fabric.util.getRandomInt(-20, 40);
	        var width = fabric.util.getRandomInt(30, 50);
	        var opacity = (function(min, max){ return Math.random() * (max - min) + min; })(0.5, 1);
	 		fabric.Image.fromURL(imgURL, function(image) {
		          image.set({
		            left: 0,
		            top: top,
		            angle: 0,
		            padding: 10,
		            cornersize: 10,
	      	  		hasRotatingPoint:true
		          });
		          //image.scale(getRandomNum(0.1, 0.25)).setCoords();
		          //first delete previous existing image 
		          var canvasObs=canvas.getObjects();
		          for(var ind in canvasObs){
		          	if(canvasObs[ind] && canvasObs[ind].type=="image")
		          		canvas.remove(canvasObs[ind]);
		          }
		          canvas.add(image);
		          //send image to lowest layer
		          var canvasRenderObs=canvas.getObjects();
		          for(var i in canvasRenderObs){
		          	if(canvasRenderObs[i] && canvasRenderObs[i].type=="image")
		          		canvasRenderObs[i].sendToBack();
		          }
		          canvas.discardActiveObject();
                  canvas.renderAll();
		    },{
      			crossOrigin: 'anonymous'
    		});
}

function openFileSelector() {
	 $("#fileLoader").click();
}
