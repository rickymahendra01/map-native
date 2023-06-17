const styleKml = function (feature) {
    const opacity = 0.3;
    var status = feature.get('Keterangan');
    if (status=="SANGAT AMAN"){
	return new ol.style.Style({
            fill: new ol.style.Fill({ color: [3, 135, 37, opacity]}),
            stroke: new ol.style.Stroke({ color: '#038725'}),
        });
    }
    if (status=="AMAN"){
	return new ol.style.Style({
            fill: new ol.style.Fill({ color: [6, 235, 66, opacity]}),
            stroke: new ol.style.Stroke({ color: '#06eb42'}),
	});
    }	
    if (status=="RAWAN"){
        return new ol.style.Style({
            fill: new ol.style.Fill({ color: [209, 207, 7, opacity]}),
            stroke: new ol.style.Stroke({ color: '#d1cf07'}),
        });
    }
    if (status=="SANGAT RAWAN"){
        return new ol.style.Style({
            fill: new ol.style.Fill({ color: [232, 134, 6, opacity]}),
            stroke: new ol.style.Stroke({ color: '#e88606'}),
        });
    }	
    if (status=="WASPADA"){
        return new ol.style.Style({
            fill: new ol.style.Fill({ color: [232, 59, 6, opacity]}),
            stroke: new ol.style.Stroke({ color: '#e83b06'}),
        });
    } 
}

var map = null;
var kmlFeatures;
var points = [];
var createWaypoint = false;
var createShelter = false;
var markerCreate;

function setShowKML(kmlFile){
    var sourceTile = new ol.source.OSM();
	var tile = new ol.layer.Tile({ source: sourceTile }); 
    var sourceKml = new ol.source.Vector({
        url: 'assets/kawasan/'+kmlFile, format: new ol.format.KML({ extractStyles: false })
    }); 
    var kmlLayers = new ol.layer.Vector({ source: sourceKml, style: styleKml});
	kmlLayers.getSource().on('change', function(evt){
            var source = evt.target;
            if (source.getState() === 'ready') {
                kmlFeatures = source.getFeatures(); 
            }
    });
    map = new ol.Map({
        layers: [tile, kmlLayers],
        target: 'map', projection: 'EPSG:3857',
        view: new ol.View({
            center: ol.proj.fromLonLat([119.48628704215113,-5.173193107185329]),
            zoom: 13
        })
    });
} 

function setShelter(){
    var markerShelter = new ol.layer.Vector({
		source: new ol.source.Vector(),
		style: new ol.style.Style({
		  image: new ol.style.Icon({
			anchor: [0.5, 1],
			src: 'shelter.png'
		  })
		})
	  });
          
    var sShelter = $("#inShelter").val();
    var rShelter = sShelter.split("#");
    var dataPeta = Array();
    for(i=0;i<rShelter.length;i++){
        dataPeta[i] = rShelter[i].split(";");
    }
    for (var i = 0; i < dataPeta.length; i++){
            var marker = new ol.Feature(new ol.geom.Point(ol.proj.fromLonLat([dataPeta[i][0], dataPeta[i][1]])));
            var iconShelter = new ol.style.Style({
				text: new ol.style.Text({
				  text: dataPeta[i][2], scale: 1, fill: new ol.style.Fill({ color: "#fff" }),
				  stroke: new ol.style.Stroke({ color: "0", width: 3 })
				}),
				image: new ol.style.Icon({ anchor: [0.5, 1], src: 'assets/img/shelter.png' })
			});
            marker.setStyle(iconShelter);
            markerShelter.getSource().addFeature(marker);
        
    }
    markerShelter.setMap(map);
}
function setWaypoint(){
    var markerWaypoint = new ol.layer.Vector({
		source: new ol.source.Vector(),
		style: new ol.style.Style({
		  image: new ol.style.Icon({
			anchor: [0.5, 1],
			src: 'waypoint.png'
		  })
		})
	  });
    
    var sWaypoint = $("#inWaypoint").val();
    var rWaypoint = sWaypoint.split("#");
    var dataPeta = Array();
    for(i=0;i<rWaypoint.length;i++){
        dataPeta[i] = rWaypoint[i].split(";");
    }
    for (var i = 0; i < dataPeta.length; i++){
            var marker = new ol.Feature(new ol.geom.Point(ol.proj.fromLonLat([dataPeta[i][0], dataPeta[i][1]])));
            var iconWaypoint = new ol.style.Style({
				text: new ol.style.Text({
				  text: dataPeta[i][2], scale: 1, fill: new ol.style.Fill({ color: "#fff" }),
				  stroke: new ol.style.Stroke({ color: "0", width: 3 })
				}),
				image: new ol.style.Icon({ anchor: [0.5, 1], src: 'assets/img/waypoint.png' })
			});
            marker.setStyle(iconWaypoint);
            markerWaypoint.getSource().addFeature(marker);
        
    }
    markerWaypoint.setMap(map);
}
function setMapWaypoint(){
    markerCreate = null;
    var kmlFile = $('#petaKml').val();
    setShowKML(kmlFile);
    
    setWaypoint();
    setShelter();
    
    callSingle('waypoint', 'list.php', '', 'formWaypoint');
    createWaypoint = false;
    map.on("click", function(evt) { createPointWaypoint(evt); });
}

function setMapShelter(){
    markerCreate = null;
    var kmlFile = $('#petaKml').val();
    setShowKML(kmlFile);
    
    setShelter();
    setWaypoint();
    
    callSingle('shelter', 'list.php', '', 'formShelter');
    createShelter = false;
    map.on("click", function(evt) { createPointShelter(evt); });
}
function createPointWaypoint(evt){
    if (createWaypoint){
	var point = map.getCoordinateFromPixel(evt.pixel);
	lonLat = ol.proj.toLonLat(point); 
	if(markerCreate != null){ markerCreate.setMap(null);}
	markerCreate = new ol.layer.Vector({
		source: new ol.source.Vector(),
		style: new ol.style.Style({
		  image: new ol.style.Icon({
			anchor: [0.5, 1],
			src: 'assets/img/flag.png'
		  })
		})
	  }); 
	marker_ = new ol.Feature(new ol.geom.Point(ol.proj.fromLonLat(lonLat)));
	markerCreate.getSource().addFeature(marker_);
	markerCreate.setMap(map);
        $('#longitude').val(lonLat[0]);
        $('#latitude').val(lonLat[1]);
    }
}
function createPointShelter(evt){
    if (createShelter){
	var point = map.getCoordinateFromPixel(evt.pixel);
	lonLat = ol.proj.toLonLat(point); 
	if(markerCreate != null){ markerCreate.setMap(null);}
	markerCreate = new ol.layer.Vector({
		source: new ol.source.Vector(),
		style: new ol.style.Style({
		  image: new ol.style.Icon({
			anchor: [0.5, 1],
			src: 'assets/img/flagShelter.png'
		  })
		})
	  }); 
	marker_ = new ol.Feature(new ol.geom.Point(ol.proj.fromLonLat(lonLat)));
	markerCreate.getSource().addFeature(marker_);
	markerCreate.setMap(map);
        $('#longitude').val(lonLat[0]);
        $('#latitude').val(lonLat[1]);
    }
}
function setZoom(location){ 
    map.getView().setCenter(ol.proj.fromLonLat(location));
    map.getView().setZoom(20);
}
  
