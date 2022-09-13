<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

	<link rel="icon" href="/itmocktest/image/logo.ico" type="image/x-icon">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<link href="des.css" rel="stylesheet" type="text/css">

	<?php include("utility_functions.php"); ?>
	<?php top_menu(); ?>

	<title>排行榜 | 資訊能力檢定模擬測驗</title>
</head>

<body>

	<div class="padding">

		<h2 align="center" style="font-weight: bold;">排行榜</h2>
		<h4 align="center" style="padding-bottom: 32px;">顯示目前排名狀況&emsp;幫助自我督促&emsp;提升競爭力</h4>

		<?php

		echo "<center style='padding-bottom: 32px;'>";
		echo "<button class='btn_s green' ".($_GET["type"]=="last_score" ? "disabled='disabled'" : NULL)." onclick='javascript:location.href=\"?type=last_score\"'>即時排行</button>";
		echo "<button class='btn_s green' ".($_GET["type"]=="high_score" ? "disabled='disabled'" : NULL)." onclick='javascript:location.href=\"?type=high_score\"'>總排行</button>";
		echo "</center>";

		?>

		<table border="0" align="center">

			<tr align="center" valign="bottom">

				<?php

				if($_GET["type"]!="last_score" && $_GET["type"]!="high_score")
					header("location: /itmocktest/leaderboard.php?type=last_score");

				$type=$_GET["type"];

				$con=db_link();
				$result=mysqli_query($con, "SELECT * FROM user ORDER BY $type DESC");

				for($i=0; $i<3; $i++)
				{
					mysqli_data_seek($result, $i);
					$row_top[$i]=mysqli_fetch_assoc($result);
				}

				echo "<td width='220'>";
				echo "<p style='font-size: 24px; padding-bottom: 8px;'>2</p>";
				echo "<a href='/itmocktest/user/profile.php?id=".$row_top[1]["identity"]."'>";
				echo "<img src='/itmocktest/image/avatar/".$row_top[1]["username"].".png' width='135' class='rounded' style='border: 6px #D5D8DC outset'>";
				echo "</a><br/>";
				echo "<font size='4'><b>".$row_top[1]["username"]."</b></font><br/>";
				echo "<font size='3' color='#9E9E9E'><b>".identity_code($row_top[1]["identity"])."</b></font><br/>";
				echo "<div>".$row_top[1][$type]."</div>";
				echo "</td>";

				echo "<td width='240'>";
				echo "<p style='font-size: 24px; padding-bottom: 8px;'>1</p>";
				echo "<a href='/itmocktest/user/profile.php?id=".$row_top[0]["identity"]."'>";
				echo "<img src='/itmocktest/image/avatar/".$row_top[0]["username"].".png' width='180' class='rounded' style='border: 8px #F7DC6F outset'>";
				echo "</a><br/>";
				echo "<font size='4'><b>".$row_top[0]["username"]."</b></font><br/>";
				echo "<font size='3' color='#9E9E9E'><b>".identity_code($row_top[0]["identity"])."</b></font><br/>";
				echo "<div>".$row_top[0][$type]."</div>";
				echo "</td>";

				echo "<td width='220'>";
				echo "<p style='font-size: 24px; padding-bottom: 8px;'>3</p>";
				echo "<a href='/itmocktest/user/profile.php?id=".$row_top[2]["identity"]."'>";
				echo "<img src='/itmocktest/image/avatar/".$row_top[2]["username"].".png' width='135' class='rounded' style='border: 6px #E59866 outset'>";
				echo "</a><br/>";
				echo "<font size='4'><b>".$row_top[2]["username"]."</b></font><br/>";
				echo "<font size='3' color='#9E9E9E'><b>".identity_code($row_top[2]["identity"])."</b></font><br/>";
				echo "<div>".$row_top[2][$type]."</div>";
				echo "</td>";

				?>

			</tr>
			
		</table>

		<table border="0" align="center" style="margin-top: 32px;">

			<tr height="40" align="center" bgcolor="#EBF5FB">
				<td width="80">
					<h4><b>排名</b></h4>
				</td>
				<td colspan="2" width="350">
					<h4><b>用戶</b></h4>
				</td>
				<td width="80">
					<h4><b>分數</b></h4>
				</td>
			</tr>

		<?php

		$result=mysqli_query($con, "SELECT * FROM user ORDER BY $type DESC LIMIT 3, 7");
		$i=4;

		while($row=mysqli_fetch_assoc($result))
		{
			if(isset($_COOKIE["member_ID"]) && $_COOKIE["member_ID"]==$row["identity"])
				echo "<tr height='105' bgcolor='#FDEDEC' class='top_line'>";
			else
				echo "<tr height='105' class='top_line'>";

			echo "<td align='center' style='font-size: 20px;'>";
			echo $i++;
			echo "</td>";

			echo "<td width='100' align='center'>";
			echo "<a href='/itmocktest/user/profile.php?id=".$row["identity"]."'>";
			echo "<img src='/itmocktest/image/avatar/".$row["username"].".png' width='85' class='rounded'><br/>";
			echo "</a>";
			echo "</td>";

			echo "<td>";
			echo "<font size='4'><b>".$row["username"]."</b></font><br/>";
			echo "<font color='#9E9E9E'><b>".identity_code($row["identity"])."</b></font><br/>";
			echo "</td>";

			echo "<td align='center'>";
			echo $row[$type]."<br/>";
			echo "</td>";

			echo "</tr>";
		}

		if(isset($_COOKIE["member_ID"]) && ranking($_COOKIE["member_ID"], $type)>10)
		{
			echo "<tr height='105' class='top_line'>";
			echo "<td colspan='4' align='center'>";
			echo "︙<br/>繼續努力，往排行榜內邁進！<br/>︙";
			echo "</td>";
			echo "</tr>";

			echo "<tr height='105' bgcolor='#FDEDEC' class='top_line'>";

			echo "<td align='center' style='font-size: 20px;'>";
			echo ranking($_COOKIE["member_ID"], $type);
			echo "</td>";

			$result=mysqli_query($con, "SELECT * FROM user WHERE identity='{$_COOKIE["member_ID"]}'");
			$row=mysqli_fetch_assoc($result);

			echo "<td width='100' align='center'>";
			echo "<a href='/itmocktest/user/profile.php?id=".$row["identity"]."'>";
			echo "<img src='/itmocktest/image/avatar/".$row["username"].".png' width='85' class='rounded'><br/>";
			echo "</a>";
			echo "</td>";

			echo "<td>";
			echo "<font size='4'><b>".$row["username"]."</b></font><br/>";
			echo "<font color='#9E9E9E'><b>".identity_code($row["identity"])."</b></font><br/>";
			echo "</td>";

			echo "<td align='center'>";
			echo $row[$type]."<br/>";
			echo "</td>";
			
			echo "</tr>";
		}

		?>

		</table>

	</div>

</body>

</html>