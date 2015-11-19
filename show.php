<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Title of the document</title>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?libraries=geometry"></script>
<script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
<style type="text/css">
      #map, html, body {
        padding: 0;
        margin: 0;
        height: 100%;
      }
      #panel {
        width: 200px;
        font-family: Arial, sans-serif;
        font-size: 13px;
        float: right;
        margin: 10px;
      }
	  p{
		  text-align: center;
	  }
	  .savebutton{
		  text-align: center;
	  }
      .color-button {
        width: 14px;
        height: 14px;
        font-size: 0;
        margin: 2px;
        float: left;
        cursor: pointer;
      }
</style>
</head>
<body>
<div id="panel">
	<div id="info">
		<p><b>Мэдээлэл</b></p>
		<b>Эзэн:</b><input class="form-control" id="first_name" type="text">
		<b>Аймаг:</b><input class="form-control" id="last_name" type="text">
		<b>Баг:</b><br/><input class="form-control" id="inputdefault" type="text"><br/><br/>
		<button type="button" class="btn btn-primary center-block" id="savebutton" onclick="ajax_post();">Search</button>
		<br/><button type="button" class="btn btn-primary center-block" id="savebutton" onclick="clear();">Clear</button>
		<div id="result"></div>
	</div>
	</div>
<div id="map"></div>
<p id="mydiv"></p>
<script>
var obj;
var map;
function ajax_post(){
    // Create our XMLHttpRequest object
    var hr = new XMLHttpRequest();
    // Create some variables we need to send to our PHP file
    var url = "parseFile.php";
    var fn = document.getElementById("first_name").value;
    //var ln = document.getElementById("last_name").value;
    var vars = "firstname="+fn;
    hr.open("POST", url, true);
    // Set content type header information for sending url encoded variables in the request
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	//hr.setRequestHeader('Content-type','application/json; charset=utf-8');
    // Access the onreadystatechange event for the XMLHttpRequest object
    hr.onreadystatechange = function() {
	    if(hr.readyState == 4 && hr.status == 200) {
		    var return_data = hr.responseText;
			document.getElementById("result").innerHTML = return_data;
			obj = eval(return_data);
			console.log(obj);
			drawPolygon();
	    }
		else
		{
			document.getElementById("result").innerHTML = "aldaa";
		}
    }
    // Send the data to PHP now... and wait for response to update the status div
    hr.send(vars); // Actually execute the request
    document.getElementById("result").innerHTML = "processing...";
}

// This example creates a simple polygon representing the Bermuda Triangle.

function initMap() {
	map = new google.maps.Map(document.getElementById('map'), {
    zoom: 5,
    center: {lat: 46.5273315, lng: 94.851387},
    mapTypeId: google.maps.MapTypeId.TERRAIN
  });
}

function drawPolygon(){
  // Define the LatLng coordinates for the polygon's path.
  var triangleCoords = [
    {lat: 25.774, lng: -80.190},
    {lat: 18.466, lng: -66.118},
    {lat: 32.321, lng: -64.757},
    {lat: 25.774, lng: -80.190}
  ];
	triangleCoords = obj;
  // Construct the polygon.
  var bermudaTriangle = new google.maps.Polygon({
    paths: triangleCoords,
    strokeColor: '#FF0000',
    strokeOpacity: 0.8,
    strokeWeight: 2,
    fillColor: '#FF0000',
    fillOpacity: 0.35
  });
  bermudaTriangle.setMap(map);
}
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAwSuyehFPYIeiqgZ24u1CfjNzXrDjduOY&signed_in=true&callback=initMap"></script>
</body>

</html>
