var map;
var markerCreate;
var marker_;
var lonLatUser;
var kmlFeatures;
var distance_ = {};
var weight_ = {};
var minStart = 15;

const styleKml = function (feature) {
	const opacity = 0.5;
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

function setPoint(map){
	var markerShelter = new ol.layer.Vector({
		source: new ol.source.Vector(),
		style: new ol.style.Style({
		  image: new ol.style.Icon({
			anchor: [0.5, 1],
			src: 'shelter.png'
		  })
		})
	  });
	map.addLayer(markerShelter);
	var markerWaypoint = new ol.layer.Vector({
		source: new ol.source.Vector(),
		style: new ol.style.Style({
		  image: new ol.style.Icon({
			anchor: [0.5, 1],
			src: 'waypoint.png'
		  })
		})
	  });
	map.addLayer(markerWaypoint);

	var n = 0;
	waypoints.forEach(el => {
		var marker = new ol.Feature(new ol.geom.Point(ol.proj.fromLonLat([el.lng, el.lat])));
		if (shelters.includes(el.kode)){
			var iconShelter = new ol.style.Style({
				text: new ol.style.Text({
				  text: el.kode, scale: 1, fill: new ol.style.Fill({ color: "#fff" }),
				  stroke: new ol.style.Stroke({ color: "0", width: 3 })
				}),
				image: new ol.style.Icon({ anchor: [0.5, 1], src: 'shelter.png' })
			});
			marker.setStyle(iconShelter);
			markerShelter.getSource().addFeature(marker);
		}else{
			var iconWaypoint = new ol.style.Style({
				text: new ol.style.Text({
				  text: el.kode, scale: 1, fill: new ol.style.Fill({ color: "#fff" }),
				  stroke: new ol.style.Stroke({ color: "0", width: 3 })
				}),
				image: new ol.style.Icon({ anchor: [0.5, 1], src: 'waypoint.png' })
			});
			marker.setStyle(iconWaypoint);
			markerWaypoint.getSource().addFeature(marker);
		}
		n++;
	});
}

function createPoint(evt){
	var point = map.getCoordinateFromPixel(evt.pixel);
	lonLatUser = ol.proj.toLonLat(point); 
	if(markerCreate != null){ markerCreate.setMap(null);}
	markerCreate = new ol.layer.Vector({
		source: new ol.source.Vector(),
		style: new ol.style.Style({
		  image: new ol.style.Icon({
			anchor: [0.5, 1],
			src: 'marker.png'
		  })
		})
	  }); 
	marker_ = new ol.Feature(new ol.geom.Point(ol.proj.fromLonLat(lonLatUser)));
	markerCreate.getSource().addFeature(marker_);
	markerCreate.setMap(map); 
}

function getStatus(lonLat){
	var status = "-";
	var x = ol.proj.fromLonLat(lonLat); 
	for (let j = 0; j < kmlFeatures.length; j++) {
        var geometry = kmlFeatures[j].getGeometry();
        isInsidePolygon = geometry.intersectsCoordinate(x);
        if (isInsidePolygon) status = kmlFeatures[j].get('Keterangan');
    } 
	return status;
}

function getDataWeight(status){
	if (status=="SANGAT AMAN") return 1;
	else if (status=="AMAN") return 0.9;
	else if (status=="RAWAN") return 0.75;
	else if (status=="SANGAT RAWAN") return 0.5;
	else if (status=="WASPADA") return 0.1;
}

function getDistance(point1, point2){
	var location_1 = ol.proj.fromLonLat([point1[0], point1[1]]);
	var location_2 = ol.proj.fromLonLat([point2[0], point2[1]]);
	var line = new ol.geom.LineString([location_1 , location_2]);
	return line.getLength();
}

function setDataFromMap(t1, t2, point1, point2){
    distance_[t1][t2] = getDistance(point1,point2);
}

function getStatusDistancePointStart(){
    var min;
    waypoints.forEach(el => {
        distance = getDistance([lonLatUser[0], lonLatUser[1]], [el.lng, el.lat]);
        if ((min == null) || (min > distance)){
            min = distance;
        } 
    });
    return (min > minStart) ? false : true;
}

function setData(){
    if (!getStatusDistancePointStart()){
        alert('Jarak titik awal dengan waypoint yang tersedia maksimal '+minStart+' meter');
    }else{    
	document.getElementById('result').innerHTML = 'Harap Tunggu....';
	process = false;
	var n;
	distance_ = {};
	weight_ = {};
	//Titik awal terhadap semua waypoint
	weight_['S'] = getDataWeight(getStatus([lonLatUser[0],lonLatUser[1]]));
	distance_['S'] = {}
	waypoints.forEach(el => {
            tmpDistance = getDistance([lonLatUser[0], lonLatUser[1]], [el.lng, el.lat]);
            if (tmpDistance <= minStart){
                links_.S.push(el.kode);
                distance_['S'][el.kode] = tmpDistance;
            }
	});
	//semua waypoint
	waypoints.forEach((el_1, len1, arr1) => {
            distance_[el_1.kode] = {}
            weight_[el_1.kode] = getDataWeight(getStatus([el_1.lng, el_1.lat]));
            waypoints.forEach((el_2, len2, arr2) => {
                if (links_[el_1.kode].includes(el_2.kode)){
                    distance_[el_1.kode][el_2.kode] = getDistance([el_1.lng, el_1.lat], [el_2.lng, el_2.lat]);
                }
                if ((len1===arr1.length-1)&&(len2===arr2.length-1)){
                    setAjax();
		}
            });
	});
    }
}

function setAjax(){
        var xhr = new XMLHttpRequest();
	var data = JSON.stringify({
		dimension: waypoints.length+1,
		point: _point_,
		distance: distance_,
		destination: shelters,
		weight: weight_,
		links: links_
	}); 
	var url = "./rute.php";
	xhr.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			console.log(this.response);
			document.getElementById('result').innerHTML = '<h3>Titik Awal</h3>'+JSON.stringify(lonLatUser)+
			'<h3>Waypoints</h3>'+JSON.stringify(waypoints)+  
			'<h3>Shelter</h3>'+JSON.stringify(shelters)+ 
			'<h3>Link</h3>'+JSON.stringify(links_)+
			'<h3>Distance</h3>'+JSON.stringify(distance_)+ 
			'<h3>Weight</h3>'+JSON.stringify(weight_)+
			'<h3>Result</h3>'+JSON.stringify(this.responseText);
			var r = JSON.parse(this.response);
			//destination
			var pathDestination;
			waypoints.forEach(el => {
				if (el.kode == r[(r.length-1)]){ pathDestination = [el.lng, el.lat] }
			});
			
			//Waypoints
			var waypts = [lonLatUser];
			for (let i = 1; i < r.length-1; i++) {
				var path;
				waypoints.forEach(el => {
					if (el.kode == r[i]){ path = [el.lng, el.lat] }
				});
				waypts.push(path);
			}
			waypts.push(pathDestination);

			for (var i = 0; i < waypts.length; i++) {
				waypts[i] = ol.proj.transform(waypts[i], "EPSG:4326", "EPSG:3857");
			}
			var featureLine = new ol.Feature({
				geometry: new ol.geom.LineString(waypts)
			});
			var vectorLine = new ol.source.Vector({});
			vectorLine.addFeature(featureLine);
			var vectorLineLayer = new ol.layer.Vector({
				source: vectorLine,
				style: new ol.style.Style({
					fill: new ol.style.Fill({ color: '#ff0000', weight: 4 }),
					stroke: new ol.style.Stroke({ color: '#000000', width: 2 })
				})
			});
			map.addLayer(vectorLineLayer);

		}
	};
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
	xhr.send(data); 
}
function setShowData(){
	if (lonLatUser != null){
		setData();
	}else alert('Pilih titik awal terlebih dahulu !');
}

function initMap() {
	var sourceTile = new ol.source.OSM();
	var tile = new ol.layer.Tile({
        source: sourceTile
    }); 
	var sourceKml = new ol.source.Vector({
		url: petaKML,
		format: new ol.format.KML({ extractStyles: false })
	}); 
	var kmlLayers = new ol.layer.Vector({
		source: sourceKml,
		style: styleKml
	});
	kmlLayers.getSource().on('change', function(evt){
		var source = evt.target;
		if (source.getState() === 'ready') {
		  	kmlFeatures = source.getFeatures(); 
		}
	  });
	map = new ol.Map({
        layers: [tile, kmlLayers],
        target: 'map',
		projection: 'EPSG:3857',
        view: new ol.View({
          center: ol.proj.fromLonLat([119.48628704215113,-5.173193107185329]),
          zoom: 14
        })
      });
	map.on("click", function(evt) { createPoint(evt); });
	setPoint(map);
}

initMap();
