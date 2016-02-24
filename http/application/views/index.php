<!DOCTYPE html> 
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>test task</title>
		<script type="text/javascript"  src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"> </script>
		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		<script src="https://code.highcharts.com/stock/highstock.js"></script>
		<script src="https://code.highcharts.com/stock/highcharts-more.js"></script>
		<script src="https://code.highcharts.com/highcharts-3d.js"></script>
		<script src="https://code.highcharts.com/stock/modules/exporting.js"></script>
		<script type="text/javascript" src="js/charts.js"></script>
		<script type="text/javascript" src="js/main.js"></script>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css"/>
		<link href='css/main.css' rel="stylesheet"/>
	</head> 
<body>
	<div id="settings">
		<div name='chart1'>
			<label>За день: </label>
			<input type="text" id="range-day">
        </div>
		<div name='chart2' style='display: none'>
			<label>За месяц: </label>
			<input type="text" id="range-month">
        </div>
	</div>
	<div id="chart1"></div>
	<script src="script.js"></script>
</body>
</html>