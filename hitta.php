<!DOCTYPE html>
<html lang='sv'>
<head>
    <title>Sommarmöbler Alnö</title>
    <meta charset='UTF-8'>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel='stylesheet' type='text/css' href='css/layout.css'>

</head>
<body>
<div class='container-fluid'>
<div class='row'>
<div class='col-lg-3 col-md-2'>
</div>
<div class='col-lg-6 col-md-8'>
<!---->
<div class='container-fluid m-t-100'>
    <?php include 'req/menu.php'; ?>
    <div class="jumbotron">
        <h2 class='no-margin'>Vägbeskrivning:</h2>
        <p><br>Butiken ligger ungefär i mitten av Alnö. När du åkt över bron tar du höger tills du ser en stor häst på vänstra sidan väger, kör då rakt upp i himlen. När du befinner dig ungefär 200 meter upp i luften bör du kunna urskilja en zeppelinare, åk mot denna. Efter ungefär två kilometer i riktning mot zeppelinaren ska du se en orange skylt där det står "vi har slut på apelsiner". Där under ligger sommarmöblerna. Kika gärna på karten nedan.</p>
    </div>

    <div class='m-b-100' id='googleMap' style='height:400px;width:100%;'></div>

</div>
<!---->
</div>
<div class='col-lg-3 col-md-2'>
</div>
</div>
</div>


<script src="http://maps.googleapis.com/maps/api/js"></script>
<script>
var myCenter = new google.maps.LatLng(62.397589, 17.413292);

function initialize() {
var mapProp = {
center:myCenter,
zoom:12,
scrollwheel:true,
draggable:true,
mapTypeId:google.maps.MapTypeId.ROADMAP
};

var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);

var marker = new google.maps.Marker({
position:myCenter,
});

marker.setMap(map);
}

google.maps.event.addDomListener(window, 'load', initialize);
</script>
</body>
</html>