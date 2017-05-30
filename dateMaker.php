<?php  
require_once 'dbconfig.php';
$addressFile = fopen("easyinfra.csv", "r") or die("Unable to open file!");
$latLng = fread($addressFile,filesize("easyinfra.csv"));
fclose($addressFile);
$addressArray = explode("\n", $latLng);

foreach ($addressArray as $value) 
{
	$data = explode(",", $value);

// echo $data[1];
// var_dump($data[1]);
	$x = $data[1];
	$y = explode('"', $x);
// var_dump($y);
	$z = $y[1];
// var_dump($z);
	$ut1 = explode("_", $z);

// var_dump($ut1);
	$timeNow = $ut1[0].' '.$ut1[1];
// var_dump($timeNow);
	$timeThen = strtotime($timeNow);
// var_dump($timeThen);
	$dt = date ("Y-m-d H:i:s", $timeThen);
	echo "<br>$value  = $dt<br>";
	$qry = "UPDATE dailyData1 SET time = '$timeNow' WHERE id = $x;";
	if(!(mysqli_query($con, $qry)))
	{
		echo "Sorry didn't succeed in submission!".mysqli_error($con);
	}
	else
	{

	}   

	
}

?>