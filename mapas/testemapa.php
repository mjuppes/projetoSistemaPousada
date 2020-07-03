
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<title></title>

	<script src="../js/jquery-1.4.4.min.js" type="text/javascript" charset="utf-8"></script>
	<!--
		<link href="../css/bootstrap.css" rel="stylesheet">
		<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="../css/formularios.css" rel="stylesheet" type="text/css"/>
	-->
</head>
	<script src="js_pousada/pousada.js" type="text/javascript" charset="charset=iso-8859-1"></script>
	<link rel="stylesheet" type="text/css" href="style.css">
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="polygon.min.js"></script>
		<link rel="stylesheet" type="text/css" href="style.css">
	<script type="text/javascript">
	
/*	
	var objectLabel = eval([{"label":"Nome do quarto","width":100}
							,{"label":"Hóspede","width":100}
							,{"label":"Data Inicial","width":100}
							,{"label":"Data Final","width":100}
							,{"label":"Opção de quarto","width":100}
							,{"label":"Empresa","width":100}]);

	var objectConfig = eval({'gridDiv' : 'tabelaReserva',
							 'width': 800,
							 'class' : 'tabelaPadrao',
							 'border':1,
							 'id':'idreserva',
							 'page':true,
							 'title':'Histórico de reservas',
							 'colspan':5,
							 'crud':false});
*/
	$(function(){
		var myLatlng = new google.maps.LatLng(-30.072473635363284, -51.201181411743164);

		//(1.5317236449601048, 104.1339111328125)

		var mapOptions = {
			zoom: 4,
			center: myLatlng,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		}

		var map = new google.maps.Map(document.getElementById('main-map'), mapOptions);

		//alert();

		var contentString = 'teste';

		/*
			var infowindow = new google.maps.InfoWindow({
				  content: contentString,
				  maxWidth: 200
			});
		*/
		var marker = new google.maps.Marker({
			position: myLatlng,
			map: map,
			title: 'Uluru (Ayers Rock)'
		});
		/*
		google.maps.event.addListener(marker, 'click', function() {
			infowindow.open(map,marker);
		});
		*/

		/*
		google.maps.event.addListener(marker, 'click', function(event) {
			  placeMarker(event.latLng);
		});
		*/

		google.maps.event.addListener(marker, 'click', toggleBounce);

		function toggleBounce()
		{
			if (marker.getAnimation() != null) 
				marker.setAnimation(null);
			else
				marker.setAnimation(google.maps.Animation.BOUNCE);
		}
		
		function placeMarker(location) {
			var marker = new google.maps.Marker({
			position: location,
			map: map,
			title:"Hello World!"});

			var infowindow = new google.maps.InfoWindow({
					content: 'Latitude: ' + location.lat() +
					'<br>Longitude: ' + location.lng()});
					infowindow.open(map,marker);
		}
		return;

		//var jq17 = jQuery.noConflict();
		//getJsonSelect('selectHistorico',false,objectConfig,objectLabel,'viewPousada.php',10);

		//create map
		 var singapoerCenter = new google.maps.LatLng(1.37584,103.829);
		 var myOptions = {
		  	zoom: 4,
		  	center: singapoerCenter,
		  	mapTypeId: google.maps.MapTypeId.ROADMAP
		  }
		 map = new google.maps.Map(document.getElementById('main-map'), myOptions);
		 
		 
		 var marker = new google.maps.Marker({
						position: map.getCenter(),
						map: map,
						title: 'Click to zoom'});

		google.maps.event.addListener(map, 'center_changed', function() {
			//3 seconds after the center of the map has changed, pan back to the
			//marker.
			window.setTimeout(function() {
					map.panTo(marker.getPosition());
			}, 3000);
		});

		google.maps.event.addListener(marker, 'click', function() {
				map.setZoom(15);
				map.setCenter(marker.getPosition());
		});

		var creator = new PolygonCreator(map);

		//alert('teste');
		//reset
		/*
			$('#reset').click(function(){
					creator.destroy();
					creator=null;
					
					creator=new PolygonCreator(map);
			 });
		 */
		 
		 //show paths
		 $('#showData').click(function(){ 
		 		$('#dataPanel').empty();
		 		if(null==creator.showData()){
		 			$('#dataPanel').append('Please first create a polygon');
		 		}else{
		 			$('#dataPanel').append(creator.showData());
		 		}
		 });
	
		 //show color
		/* $('#showColor').click(function(){ 
		 		$('#dataPanel').empty();
		 		if(null==creator.showData()){
		 			$('#dataPanel').append('Please first create a polygon');
		 		}else{
		 				$('#dataPanel').append(creator.showColor());
		 		}
		 });*/
	});	
	</script>
<body>
<div>
<?php //include "../topo.php"; ?>
</div>
<!--<div id="tabelaReserva"></div>-->

<input id="showData"  value="Show Paths (class function) " type="button" class="navi"/>
<div   id="dataPanel"></div>
<!--<div id="main-map" style="width:100%"></div>-->
<div id="main-map"></div>
<div id="panel"></div>
</body>
</html>