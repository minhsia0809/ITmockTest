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
	<?php role_require(2); ?>

	<title>會員管理系統 | 資訊能力檢定模擬測驗</title>
</head>

<body>

	<div class="padding">

		<h2 align="center" style="font-weight: bold;">會員管理系統</h2>
		<h4 align="center" style="padding-bottom: 32px;">保護個人隱私&emsp;為您提供更好的服務</h4>

		<?php

		$con=db_link();
		$result=mysqli_query($con, "SELECT * FROM user");

		$amount=10;
		$total=mysqli_num_rows($result);
		pagination($_GET["page"], ceil($total/$amount)); //分頁設計
		?>

		<table align="center" cellspacing="0" cellpadding="5" border="0">

			<tr height="40" align="center" bgcolor="#EBF5FB">
				<td colspan="2" width="350">
					<h4><b>基本資訊</b></h4>
				</td>
				<td width="180">
					<h4><b>申請時間</b></h4>
				</td>
				<td width="100">
					<h4><b>角色</b></h4>
				</td>
				<td width="200">
					<h4><b>設定</b></h4>
				</td>
			</tr>

		<?php

		date_default_timezone_set("Asia/Taipei");

		$offset=($_GET["page"]-1)*$amount;
		$result=mysqli_query($con, "SELECT * FROM user ORDER BY last_login DESC LIMIT $offset, $amount");

		while($row=mysqli_fetch_assoc($result))
		{
			echo "<tr height='105' class='top_line'>";

			echo "<td width='100' align='center'>";
			echo "<a href='/itmocktest/user/profile.php?id=".$row["identity"]."'>";
			echo "<img src='../image/avatar/".$row["username"].".png' width='85' class='rounded'>";
			echo "</a>";
			echo "</td>";

			$last_login=($row["last_login"]!=-1 ? "title='於 ".date("Y/m/d H:i:s", $row["last_login"])." 上線'" : NULL);
			echo "<td>";
			echo "<font size='4'><b>".$row["username"]."</b></font><br/>";
			echo "<font color='#9E9E9E'><b>".identity_code($row["identity"])."</b></font><br/>";
			echo "<span ".$last_login." style='display: inline-block; padding-top: 10px; cursor: pointer;'>".time_ago($row["last_login"])."</span>";
			echo "</td>";

			echo "<td align='center'>";
			echo date("Y/m/d H:i:s", $row["reg_time"]);
			echo "</td>";

			echo "<td align='center'>";
			echo role_name($row["role"]);
			echo "</td>";

			echo "<td align='center'>";
			$disabled=($row["identity"]==$_COOKIE["member_ID"] ? "disabled='disabled' title='您無法變更自己的身分'" : NULL);
			echo "<button ".$disabled." class='change_role btn_s blue' data-toggle='modal' data-id='".$row["identity"]."' data-role='".$row["role"]."' data-target='#change_role'>變更身分</button>";
			$disabled=($row["role"]!=0 ? "disabled='disabled' title='您無法刪除身為管理層級的用戶'" : NULL);
			echo "<button ".$disabled." class='delete btn_s red' data-toggle='modal' data-id='".$row["identity"]."' data-target='#delete'>刪除</button>";
			echo "</td>";

			echo "</tr>";
		}

		?>

		</table>

		<?php

		pagination($_GET["page"], ceil($total/$amount));

		?>

		<div class="modal fade" id="change_role">
			<div class="modal-dialog">
				<div class="modal-content">

					<form action="setting.php?change_role" method="POST">

						<div class="modal-header">
							<button class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">變更身分</h4>
						</div>

						<div class="modal-body">
							<input type="hidden" name="identity" id="iden">
							
							<input type="radio" name="role" value="0" id="role_0">
							<label for="role_0">學生</label><br/>
							<input type="radio" name="role" value="1" id="role_1">
							<label for="role_1">教師</label><br/>
							<input type="radio" name="role" value="2" id="role_2">
							<label for="role_2">管理者</label>
						</div>
				
						<div class="modal-footer">
							<button class="btn btn-default" data-dismiss="modal">取消</button>
							<input type="submit" value="變更" class="btn btn-default">
						</div>

					</form>

				</div>
			</div>
		</div>

		<div class="modal fade" id="delete">
			<div class="modal-dialog">
				<div class="modal-content">

					<form action="setting.php?delete" method="POST">

						<div class="modal-header">
							<button class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">刪除用戶</h4>
						</div>

						<div class="modal-body">
							<input type="hidden" name="identity" id="identity">
							確認刪除該用戶？該動作將無法復原！
						</div>
				
						<div class="modal-footer">
							<button class="btn btn-default" data-dismiss="modal">取消</button>
							<input type="submit" value="刪除" class="btn btn-default">
						</div>

					</form>

				</div>
			</div>
		</div>

		<script type="text/javascript">

			$(document).on("click", ".delete", function()
			{
				$("#identity").val($(this).data("id"));
			});

			$(document).on("click", ".change_role", function()
			{
				$("#iden").val($(this).data("id"));
				$("#role_"+$(this).data("role")).prop("checked", true);
			});

		</script>

	</div>

</body>

</html>
