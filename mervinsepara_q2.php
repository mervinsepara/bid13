<?php
/* This code is for question 2 answer for BID13
*
* Written by 
* 
* Mervin Separa
* Winnipeg MB Canada
* 204 479 5461
* mervsepara@hotmail.com
* www.linkedin.com/in/mervinsepara
*/

$file = "q2.csv";
$csv = array_map('str_getcsv', file($file));
array_walk($csv, function(&$a) use ($csv) {
  $a = array_combine($csv[0], $a);
});
array_shift($csv);
?>

<!DOCTYPE HTML>
<html>
<head>  
<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	exportEnabled: true,
	theme: "light1", 
	title:{
		text: "BID13 question 2 answer by MERVIN SEPARA"
	},
	axisX:{
		title: "X",
	},
	axisY:{
		title: "Y",
	},
	data: [{
		type: "scatter",
		markerType: "square",
		markerSize: 10,
		toolTipContent: "Y: {y}<br>X: {x}",
		dataPoints: <?php echo json_encode($csv, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
}
</script>
</head>
<body>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</body>
</html> 

