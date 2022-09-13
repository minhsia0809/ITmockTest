<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

	<link rel="icon" href="/itmocktest/image/logo.ico" type="image/x-icon">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<link href="des.css" rel="stylesheet" type="text/css">

	<?php include("utility_functions.php"); ?>
	<?php top_menu(); ?>

	<title>資訊能力檢定模擬測驗</title>
</head>

<body>

	<div class="padding">

		<h2 align="center" style="font-weight: bold;">後臺數據統計分析</h2>
		<h4 align="center" style="padding-bottom: 32px;">分析正式測驗中使用者的分數分布&emsp;以利了解網站的使用狀況</h4>

		<?php

		$con=db_link();
		$result=mysqli_query($con, "SELECT high_score, last_score FROM user");

		$high_count=array_fill(0, 51, 0);
		$last_count=array_fill(0, 51, 0);

		$high_score_total=0;
		$last_score_total=0;

		while($row=mysqli_fetch_assoc($result))
		{
			$high_count[($row["high_score"]/2)]++;
			$last_count[($row["last_score"]/2)]++;

			$high_score_total+=$row["high_score"];
			$last_score_total+=$row["last_score"];
		}

		$high_score_average=$high_score_total/mysqli_num_rows($result);
		$last_score_average=$last_score_total/mysqli_num_rows($result);

		$high_score_SDM_total=0;
		$last_score_SDM_total=0;

		mysqli_data_seek($result, 0);
		while($row=mysqli_fetch_assoc($result))
		{
			$high_score_SDM_total+=pow($row["high_score"]-$high_score_average, 2);
			$last_score_SDM_total+=pow($row["last_score"]-$last_score_average, 2);
		}

		$high_score_SD=sqrt($high_score_SDM_total/mysqli_num_rows($result));
		$last_score_SD=sqrt($last_score_SDM_total/mysqli_num_rows($result));

		?>

		<script type="text/javascript">

			google.charts.load("current", {"packages": ["bar"]});
			google.charts.setOnLoadCallback(drawStuff);

			function drawStuff()
			{
				var data=new google.visualization.arrayToDataTable
				([
				["yeah", "最高測驗分數", "前次測驗分數"],

				<?php

				for($i=0 ; $i<=50 ; $i++)
					echo "['".($i*2)."', ".$high_count[$i].", ".$last_count[$i]."],";

				?>

				]);

				var options=
				{
					title: "product",
					width: $(window).width()*0.64,
					legend: {position: "none"},
					chart: {title: "測驗成績統計分析", subtitle: "分析分數分布"},
					colors: ["#73C6B6", "#E59866"],
					bars: "vertical",
					axes:
					{
						x:
						{
							0: {side: "bottom", label: "分數"},
						}
					},
					bar: {groupWidth: "90%"}
				};

				var chart = new google.charts.Bar(document.getElementById('top_x_div'));
				chart.draw(data, options);
			};

		</script>

		<div id="top_x_div" style="width: 100vw; height: 500px;"></div>

		<?php

		echo "最高成績平均值：".round($high_score_average, 4)."<br/>";
		echo "前次成績平均值：".round($last_score_average, 4)."<br/><br/>";
		echo "最高成績標準差：".round($high_score_SD, 4)."<br/>";
		echo "前次成績標準差：".round($last_score_SD, 4)."<br/>";

		?>

	</div>

</body>

</html>