    <?php
    function search(){
    	$addressFile = fopen("latLong.csv", "r") or die("Unable to open file!");
    $latLng = fread($addressFile, filesize("latLong.csv"));
    fclose($addressFile);
    $addressArray = explode("\n", $latLng);
    $arr = [];
    foreach ($addressArray as $value) {
        $data = explode(",", $value);
        $locArr = array(
            'label'=>$data[0],
        	'value'=>$data[0],
        	'latlong'=>[
        				'lat'=>$data[1],
        				'long'=>str_replace("\r", "", $data[2])
        				]
        			);
        array_push($arr, $locArr);
        unset($locArr);
    }
    return json_encode($arr);
    }
?>