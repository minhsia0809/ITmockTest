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

			session_start();
			$member_ID=$_COOKIE["member_ID"];

			$con=db_link();
			$result=mysqli_query($con, "SELECT * FROM user WHERE identity='$member_ID'");
			$row=mysqli_fetch_assoc($result);

			$original_image=imagecreatefromstring(file_get_contents($_FILES["photo"]["tmp_name"]));

			$src_width=imagesx($original_image);
			$src_height=imagesy($original_image);

			$length=($src_height<$src_width ? $src_height : $src_width);

			$newpc=imagecreatetruecolor($length, $length);

			imagecopy($newpc, $original_image, 0, 0, ($src_width-$length)/2, ($src_height-$length)/2, $length, $length);

			$final_avatar=imagecreatetruecolor(256, 256);

			imagecopyresampled($final_avatar, $newpc, 0, 0, 0, 0, 256, 256, $length, $length);

			imagepng($final_avatar, "../image/avatar/".$row["username"].".png");

			echo "<h3 style='font-weight: bold;'>更改成功</h3>";
			echo "返回個人主頁</br>";
			echo "<button class='btn_hint' onclick='javascript: location.href=\"/itmocktest/user/profile.php?id=".$member_ID."\"'>確認</button>";
			
			?>

		</div>

	</div>

</body>

</html>