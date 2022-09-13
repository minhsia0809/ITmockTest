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

			$username=$_POST["username"];
			$password=$_POST["password"];

			$reg_time=time();

			$con=db_link();
			$result=mysqli_query($con, "SELECT * FROM user WHERE username='$username'");

			if(mysqli_fetch_assoc($result))
			{
				echo "<h3 style='font-weight: bold;'>申請失敗</h3>";
				echo "使用者名稱已被使用</br>";
				echo "<button class='btn_hint' onclick='javascript: location.href=\"/itmocktest/homepage.php\"'>確認</button>";
			}
			else if($_POST["password_check"]!=$password)
			{
				echo "<h3 style='font-weight: bold;'>申請失敗</h3>";
				echo "密碼不相符</br>";
				echo "<button class='btn_hint' onclick='javascript: location.href=\"/itmocktest/homepage.php\"'>確認</button>";
			}
			else
			{
				$avatar=imagecreatefrompng("../image/default_avatar.png");

				do
				{
					$R=rand(0, 255);
					$G=rand(0, 255);
					$B=rand(0, 255);
					$brightness=0.3*$R+0.6*$G+0.1*$B;
				}
				while($brightness>31);

				imagefilter($avatar, IMG_FILTER_COLORIZE, $R, $G, $B);
				imagepng($avatar, "../image/avatar/".$username.".png");
				imagedestroy($avatar);

				$password=password_hash($_POST["password"], PASSWORD_DEFAULT);

				mysqli_query($con, "INSERT INTO user(username, password, reg_time) VALUES('$username', '$password', '$reg_time')");

				echo "<h3 style='font-weight: bold;'>申請成功</h3>";
				echo "回到首頁並登入</br>";
				echo "<button class='btn_hint' onclick='javascript: location.href=\"/itmocktest/homepage.php\"'>確認</button>";
			}

			?>

		</div>

	</div>

</body>

</html>