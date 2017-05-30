<html>
<head>
  <title>Easy-Infra 2</title>
<?php require_once('json.php'); ?>
  <style type="text/css">
    html { height: 100% }
    body { height: 100%; margin: 0; padding: 0 }
    p {font-size: 1.2em;}
    b {font-size: 1.7em;}
    #map_canvas { height: 100% }
  </style>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <style>
   #wrapper { position: relative; }
   #over_map { position: absolute; top: 10px; left: 10px; z-index: 99; }
</style>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyB1tbIAqN0XqcgTR1-FxYoVTVq6Is6lD98&sensor=false">
</script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


 

<!-- <?php
if ($_REQUEST['userDate']) {
  # code...

    $day = $_REQUEST['userDate'];
    $rawFile = fopen("values/".$day."-axatech-red.txt", "r") or die("Unable to open file!");
    $rawData = fread($rawFile, filesize("values/".$day."-axatech-red.txt"));
    fclose($rawFile);
    $rawDataArray = explode("\n", $rawData);
    $avg = 0;
    foreach ( $rawDataArray as $value) {
          $avg +=(float)$value;
    }
    echo $avg/count($rawDataArray);
}

?> -->


<script type="text/javascript">

var glbMap = {};

  var locations = [
    <?php
    $addressFile = fopen("latLong.csv", "r") or die("Unable to open file!");
    $latLng = fread($addressFile, filesize("latLong.csv"));
    fclose($addressFile);
    $addressArray = explode("\n", $latLng);

    foreach ($addressArray as $value) {
        $data = explode(",", $value);

      // ['<b>Banaswadi</b><br><br><p>57% loaded</p> ', 13.0119571,77.6471307,'<p>43% free</p>'],
      // ['<b>HOSUR ROAD</b><br><br><p style="color:red;">40% loaded</p> ', 12.915916, 77.638261, '<p style="color:green;">60% free</p>']
        try {
            
            // echo "<h1>".$printValue1."</h1>";
            echo "['<b>".$data[0]."</b><br><br><p></p> ', ".(float)$data[1].",".(float)$data[2].", '<p>43% free</p>','".$data[0]."'],";
        } catch (Exception $e) {
        }
    }

    ?>
  ];

  function initialize() {

    var myOptions = {
      center: new google.maps.LatLng(12.9716, 77.5946),
      zoom: 15,
      mapTypeId: google.maps.MapTypeId.ROADMAP

    };
    glbMap = new google.maps.Map(document.getElementById("default"),
      myOptions);

    setMarkers(glbMap,locations)

  }



  function setMarkers(map,locations){

    var marker, i

    for (i = 0; i < locations.length; i++)
    {  

     var area = locations[i][0]
     var lat = locations[i][1]
     var long = locations[i][2]
     var add =  locations[i][4]

     latlngset = new google.maps.LatLng(lat, long);

     var marker = new google.maps.Marker({  
      map: map, title: "Click Here for data" , position: latlngset  
    });
     map.setCenter(marker.getPosition())


     var content = area  + "<form id='form-map' action = 'prediction.php' method = 'GET'>  <p>Select Date <input style='align:right' type='datetime-local' name='userDate'><input type='hidden' name='locName' value='"+add+"'><br><br><input type='submit' onclick='calculate(this,event)' value='Submit'/><input type='reset' value='Clear'/><span style='display:block' ></span></p></form>" 
     marker.name = add;
     var infowindow = new google.maps.InfoWindow()

     google.maps.event.addListener(marker,'click', (function(marker,content,infowindow){

      return function() {

       infowindow.setContent(content);
       infowindow.open(map,marker);
     };
   })(marker,content,infowindow)); 

   }
 }
 function calculate(btn,e){
  e.preventDefault();
  $form = $(btn).parent().parent();
   $.get($form.attr('action') + "?"+ $form.serialize(),function( data ){
    $span = $form.find('span');
   $span[0].innerHTML = data;
  });
 }

 $( function() {
    function log( message ) {
      $( "<div>" ).text( message ).prependTo( "#log" );
      $( "#log" ).scrollTop( 0 );
    }
    var tags = // <![CDATA[
                <?php echo search(); ?>;
                // ]]>
    $( "#countries" ).autocomplete({
      source: tags,
      minLength: 2,
      select: function( event, ui ) {
        // console.log( "Selected: " + ui.item.value + " aka " + ui.item.id );
        console.log(ui);
        var latlng = new google.maps.LatLng(ui.item.latlong.lat, ui.item.latlong.long);

        glbMap.setCenter(latlng);
      }
    });
  } );
  
  </script>
</head>
<body onload="initialize()">
  <div id="wrapper"><div id="default" style="width:100%; height:100%"></div></div>
  <div id="over_map">
  <input type="text" name="" id="countries" value="" placeholder="">
   </div>
</body>
</html>