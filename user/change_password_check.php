<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="icon" href="/itmocktest/image/logo.ico" type="image/x-icon">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<link href="../des.css" rel="stylesheet" type="text/css">

	<?php include("../utility_functions.php"); ?>

	<title>資訊能力檢定模擬測驗</title>
</head>

<body>

	<div class="newpadding">

		<div class="hint">

			<?php

			$member_ID=$_COOKIE["member_ID"];

			$con=db_link();
			$result=mysqli_query($con, "SELECT password FROM user WHERE identity='$member_ID'");
			$row=mysqli_fetch_assoc($result);

			if(password_verify($_POST["old"], $row["password"]) && $_POST["new"]==$_POST["newcheck"])
			{
				$password=password_hash($_POST["new"], PASSWORD_DEFAULT);
				$result=mysqli_query($con, "UPDATE user SET password='$password' WHERE identity='$member_ID'");

				echo "<h3 style='font-weight: bold;'>更改成功</h3>";
				echo "返回個人主頁</br>";
				echo "<button class='btn_hint' onclick='javascript: location.href=\"/itmocktest/user/profile.php?id=".$member_ID."\"'>確認</button>";
			}
			else
			{		
				echo "<h3 style='font-weight: bold;'>更改失敗</h3>";
				echo "密碼不相符</br>";
				echo "<button class='btn_hint' onclick='javascript: location.href=\"/itmocktest/user/profile.php?id=".$member_ID."\"'>確認</button>";
			}
				
			?>

		</div>

	</div>

</body>

</html>