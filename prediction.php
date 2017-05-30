<?php

// echo "$phpDate";
//set_time_limit(0);
require 'dbconfig.php';


$userDate = $_GET["userDate"];
$loc = $_GET["locName"];


$phpDate = strtotime($userDate);
if(!$phpDate){
	echo "Invalid date";
	exit;
}
$dayNum = date("w", $phpDate) ;
$day1 = $dayNum +1;
$userTime = date("H", $phpDate);

$qry = "SELECT AVG(greenPercent) AS green , AVG(redPercent) AS red, AVG(yellowPercent) AS yellow FROM (SELECT * FROM dailydata1 WHERE WEEKDAY(time) BETWEEN $dayNum AND $day1 AND location='$loc'  ORDER BY time desc LIMIT 1,4) averege_table";
$qry1 = "SELECT AVG(greenPercent) AS green , AVG(redPercent) AS red, AVG(yellowPercent) AS yellow FROM (SELECT * FROM dailydata1 WHERE WEEKDAY(time)  BETWEEN $dayNum AND $day1 AND location='$loc'  ORDER BY time desc LIMIT 4,8) averege_table1";

$result=mysqli_query($con,$qry);
$result1=mysqli_query($con,$qry1);

if($result || $result1){
$arr =  array();
$res = array();
// Associative array
while($row=mysqli_fetch_assoc($result))
{
	array_push($arr, $row);
	//print implode(",", $row);
}
while($row1=mysqli_fetch_assoc($result1))
{
	array_push($arr, $row1);
	//print implode(",", $row1);
}
$values = ["green", "red", "yellow"];

// var_dump($row1);
for($i=0;$i<=2;$i++)
{
	$res[$i] = $arr[0][$values[$i]]-$arr[1][$values[$i]];
}
$r = $arr[0][$values[2]];
$g = $arr[0][$values[1]];
$y = $arr[0][$values[0]];
$finalRes =[$r, $g, $y];
implode(",", $res);
$x = max($finalRes)*100;
// var_dump($r);
echo "<h3>".round($x, 2)."% Traffic Predicted</h3>";
// echo $qry;
// var_dump($res);
// echo $res[0]+$res[1]+$res[2];
echo "Error rate shall be displayed here";

}
else{
	echo "No data found for this location";
}
?>