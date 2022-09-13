<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

	<link rel="icon" href="/itmocktest/image/logo.ico" type="image/x-icon">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<link href="../des.css" rel="stylesheet" type="text/css">

	<?php include("../utility_functions.php"); ?>
	<?php top_menu(); ?>
	
	<title>個人主頁 | 資訊能力檢定模擬測驗</title>
</head>

<body>

	<div class="padding">

		<h2 align="center" style="font-weight: bold;">個人主頁</h2>
		<h4 align="center" style="padding-bottom: 32px;">管理您的資訊&emsp;致力於為您提供更好的服務</h4>

		<center>

			<?php

			if(isset($_GET["id"]))
			{
				$con=db_link();
				$profile_ID=(int)$_GET["id"];
				$result=mysqli_query($con, "SELECT * FROM user WHERE identity='$profile_ID'");

				$self=(isset($_COOKIE["member_ID"]) && $profile_ID==$_COOKIE["member_ID"] ? true : false);

				if($row=mysqli_fetch_assoc($result))
				{
					if($self)
					{
						echo "<a href='/itmocktest/modal/change_avatar.php' data-toggle='modal' data-target='#change_avatar'>";
						echo "<img src='/itmocktest/image/avatar/".$row["username"].".png' width='160' class='rounded self'>";
						echo "</a><br/>";
					}
					else
					{
						echo "<img src='/itmocktest/image/avatar/".$row["username"].".png' width='160' class='rounded'><br/>";
					}

					echo "<font size='5'><b>".$row["username"]."</b></font><br/>";
					echo "<font size='4' color='#9E9E9E'><b>".identity_code($row["identity"])."</b></font><br/>";

					echo "<table width='60%' align='center' border='0' style='margin-top: 32px;'>";

					echo "<tr height='40' align='center' bgcolor='#EBF5FB'>";
					echo "<td colspan='2'><h4><b>帳戶資訊</b></h4></td>";
					echo "</tr>";

					echo "<tr class='top_line'>";
					echo "<td><div style='padding: 16px 8px;'>使用者名稱</div></td>";
					echo "<td>".$row["username"]."</td>";
					echo "</tr>";

					echo "<tr class='top_line'>";
					echo "<td><div style='padding: 16px 8px;'>使用者編號</div></td>";
					echo "<td>".identity_code($row["identity"])."</td>";
					echo "</tr>";

					echo "<tr class='top_line'>";
					echo "<td><div style='padding: 16px 8px;'>身分</div></td>";
					echo "<td>".role_name($row["role"])."</td>";
					echo "</tr>";

					if($self)
					{
						echo "<tr>";
						echo "<td colspan='2' align='right' style='padding: 8px'>";
						echo "<button class='btn_s green' href='/itmocktest/modal/change_password.php' data-toggle='modal' data-target='#change_password'>修改密碼</button>";
						echo "</td>";
						echo "</tr>";
					}

					echo "</table>";

					echo "<table width='60%' align='center' border='0' style='margin-top: 32px;'>";

					echo "<tr height='40' align='center' bgcolor='#EBF5FB'>";
					echo "<td colspan='2'><h4><b>學習狀況</b></h4></td>";
					echo "</tr>";

					echo "<tr class='top_line'>";
					echo "<td><div style='padding: 16px 8px;'>正式測驗最高分紀錄</div></td>";
					echo "<td>".$row["high_score"]."分</td>";
					echo "</tr>";

					echo "<tr class='top_line'>";
					echo "<td><div style='padding: 16px 8px;'>總排行</div></td>";
					echo "<td>".ranking($row["identity"], "high_score")."</td>";
					echo "</tr>";

					echo "<tr class='top_line'>";
					echo "<td><div style='padding: 16px 8px;'>上次正式測驗成績</div></td>";
					echo "<td>".$row["last_score"]."分</td>";
					echo "</tr>";

					echo "<tr class='top_line'>";
					echo "<td><div style='padding: 16px 8px;'>即時排行</div></td>";
					echo "<td>".ranking($row["identity"], "last_score")."</td>";
					echo "</tr>";

					if($self)
					{
						echo "<tr>";
						echo "<td colspan='2' align='right' style='padding: 8px'>";
						echo "<button class='btn_s blue' onclick='javascript:location.href=\"/itmocktest/user/transcript.php\"'>查看測驗成績單</button>";
						echo "</td>";
						echo "</tr>";
					}

					echo "</table>";
				}
				else
					header("location:profile.php");

			}
			else
			{
				echo "<img src='/itmocktest/image/avatar/default_guest.png' width='160' class='rounded'><br/>";
				echo "<font size='5'><b>- - 用戶不存在 - -</b></font><br/>";
				echo "<font color='#9E9E9E'><b>#NULL</b></font><br/>";
			}

			?>

		</center>

	</div>

	<div class="modal fade" id="change_avatar" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
			</div>
		</div>
	</div>

	<div class="modal fade" id="change_password" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
			</div>
		</div>
	</div>

</body>

</html>