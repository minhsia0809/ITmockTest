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
	<?php role_require(); ?>

	<title>資訊能力檢定模擬測驗</title>
</head>

<body>

	<div class="padding">

		<h2 align="center" style="font-weight: bold;">選擇應試類型</h2>
		<h4 align="center" style="padding-bottom: 32px;">協助您在考試前多加磨練&emsp;敬祝各位考試順利</h4>

		<center>
			<button data-target="#mode_0" data-toggle="collapse" onclick="$('#mode_1').collapse('hide');" class="button_big og">模擬測驗</button>
			<button data-target="#mode_1" data-toggle="collapse" onclick="$('#mode_0').collapse('hide');" class="button_big og">練習測驗</button>
		</center>

		<div id="mode_0" class="collapse" style="border: 2px #DDDDDD solid; width: 49%; float: left; margin: 32px 0; padding: 16px;">

			<h3 align="center" style="font-weight: bold;">模擬測驗</h3>

			<p>本模擬測驗為更有效地檢視學習成效，題目共50題，測驗時間共60分鐘，比照正式測驗的給予使用者相同的環境。</p>

			<form action="loading.php?mode=formal" method="POST">

				<input type="hidden" name="amount" value="50">

				<input type="hidden" value="0" name="type[]">
				<input type="hidden" value="1" name="type[]">
				<input type="hidden" value="2" name="type[]">
				<input type="hidden" value="3" name="type[]">
				<input type="hidden" value="4" name="type[]">

				<center>
					<input class="btn_hint" type="submit" value="開始測驗">
				</center>

			</form>

		</div>

		<div id="mode_1" class="collapse" style="border: 2px #DDDDDD solid; width: 49%; float: right; margin: 32px 0; padding: 16px;">

			<form action="loading.php?mode=practice" method="POST">

				<h3 align="center" style="font-weight: bold;">練習測驗</h3>

				<p>能夠自行選擇應考題數，也可針對自身不熟悉的題型來做練習，讓學習過程更有效率。</p>

				<p class="about_subheading">請選擇測驗題數</p>

				<input type="radio" name="amount" value="10" id="amount_10">
				<label for="amount_10">10題</label><br/>
				<input type="radio" name="amount" value="25" id="amount_25">
				<label for="amount_25">25題</label><br/>		
				<input type="radio" name="amount" value="50" id="amount_50" checked="checked">
				<label for="amount_50">50題</label><br/><br/>

				<p class="about_subheading">請選擇測驗題庫</p>

				<input type="checkbox" value="0" name="type[]" id="type_0" checked="checked">
				<label for="type_0">計算機概論</label><br/>
				<input type="checkbox" value="1" name="type[]" id="type_1" checked="checked">
				<label for="type_1">網際網路概論</label><br/>
				<input type="checkbox" value="2" name="type[]" id="type_2" checked="checked">
				<label for="type_2">網路資訊安全</label><br/>
				<input type="checkbox" value="3" name="type[]" id="type_3" checked="checked">
				<label for="type_3">資訊素養與倫理</label><br/>
				<input type="checkbox" value="4" name="type[]" id="type_4" checked="checked">
				<label for="type_4">office</label><br/><br/>

				<p style="background-color: #FDEDEC; border: 2px #CD6155 dashed; padding: 16px; border-radius: 4px;">
					<span style="font-weight: bold; font-size: 18px; color: #CD6155;">注意！</span><br/>
					在練習測驗模式之下，測驗紀錄將並不會被伺服端保留下來，使用者於練習測驗結束後，記得馬上進行考後檢討與複習 ！
				</p>

				<center>
					<input class="btn_hint" type="submit" value="開始測驗">
				</center>

			</form>

		</div>

	</div>

</body>

</html>