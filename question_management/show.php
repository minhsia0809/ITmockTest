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
	<?php role_require(1); ?>

	<title>題庫管理系統 | 資訊能力檢定模擬測驗</title>
</head>

<body>

	<div class="padding">

		<h2 align="center" style="font-weight: bold;">題庫管理系統</h2>
		<h4 align="center" style="padding-bottom: 32px;">協助後端分析各題的答題情況</h4>

		<?php

		if(is_null($_GET["type"]) || $_GET["type"]<0 || $_GET["type"]>4)
			header("location: ?type=0&page=1");

		echo "<center style='padding-bottom: 32px;'>";
		for($i=0; $i<=4; $i++)
		{
			$question_db_name=question_db_name($i);
			echo "<button class='btn_s green' ".($_GET["type"]==$i ? "disabled='disabled'" : NULL)." onclick='javascript:location.href=\"?type=".$i."&page=1\"'>".$question_db_name[2]."</button>";
		}
		echo "</center>";

		$con=db_link();
		$question_db_name=question_db_name($_GET["type"]);

		$result=mysqli_query($con, "SELECT * FROM $question_db_name[0]");
		$total=mysqli_num_rows($result);

		$result=mysqli_query($con, "SELECT MAX(no) FROM $question_db_name[0]");
		$row=mysqli_fetch_assoc($result);

		echo "<table width='60%' align='center' border='0'>";

		echo "<tr>";
		echo "<td colspan='2'><h3 style='padding-left: 8px; font-weight: bold;'>".$question_db_name[2]."&nbsp;".$question_db_name[1]."</h3></td>";
		echo "</tr>";

		echo "<tr height='40' align='center' bgcolor='#EBF5FB'>";
		echo "<td colspan='2'><h4><b>題庫資訊</b></h4></td>";
		echo "</tr>";

		echo "<tr class='top_line'>";
		echo "<td><div style='padding: 8px;'>題庫內現有總題目數</div></td>";
		echo "<td>".$total."</td>";
		echo "</tr>";

		echo "<tr class='top_line'>";
		echo "<td><div style='padding: 8px;'>題庫內最大題號</div></td>";
		echo "<td>".$row["MAX(no)"]."</td>";
		echo "</tr>";

		echo "<tr class='top_line'>";
		echo "<td><div style='padding: 8px;'>缺少題數</div></td>";
		echo "<td>".($row["MAX(no)"]-$total)."題</td>";
		echo "</tr>";

		echo "<tr>";
		echo "<td colspan='2' align='right' style='padding: 8px'>";
		echo "<button class='btn_s blue' data-toggle='modal' data-target='#add'>新增題目</button>";
		echo "</td>";
		echo "</tr>";

		echo "</table>";

		$amount=10;
		$other_url_value["type"]=$_GET["type"];
		pagination($_GET["page"], ceil($total/$amount), $other_url_value);

		?>

		<table width="100%" align="center" cellpadding="5" border="0">

			<tr style="visibility: hidden;">
				<td width="50"></td>
				<td>a</td>
				<td width="75"></td>
				<td width="100"></td>
			</tr>

			<?php

			$offset=($_GET["page"]-1)*$amount;
			$result=mysqli_query($con, "SELECT * FROM $question_db_name[0] LIMIT $offset, $amount");

			while($row=mysqli_fetch_assoc($result))
			{
				echo "<tr>";
				echo "<td colspan='4'>";
				echo "<div style='font-size: 16px; font-weight: bold; color: #9E9E9E; padding-bottom: 8px;'>".$question_db_name[1]."_".str_pad($row["no"], 3, "0", STR_PAD_LEFT)."</div>";
				echo "</td>";
				echo "</tr>";

				echo "<tr>";
				echo "<td align='center' valign='bottom'>選項</td>";
				echo "<td><font size='3'><b>".$row["question"]."</b></font></td>";
				echo "<td align='center' valign='bottom'>正解</td>";
				echo "<td align='center' valign='bottom'>答對率</td>";
				echo "</tr>";

				$all_time=$row["A_time"]+$row["B_time"]+$row["C_time"]+$row["D_time"];
				$correct_time=$row[$row["answer"]."_time"];
				$correct_rate=($all_time==0 ? "NAN" : round(100*$correct_time/$all_time, 2))."%";

				echo "<tr class='top_line'>";
				echo "<td align='center'><b>(A)</b></td>";
				echo "<td ".correct_color($row["answer"], "A")."><div style='padding: 4px;'>".$row["A"]."</div></td>";
				echo "<td align='center' rowspan='4'>".$row["answer"]."</td>";
				echo "<td align='center' rowspan='4'>";
				echo $correct_rate."<br/>";
				echo "<font color='#9E9E9E'>(".$correct_time."/".$all_time.")</font>";
				echo "</td>";
				echo "</tr>";

				echo "<tr class='top_line'>";
				echo "<td align='center'><b>(B)</b></td>";
				echo "<td ".correct_color($row["answer"], "B")."><div style='padding: 4px;'>".$row["B"]."</div></td>";
				echo "</tr>";

				echo "<tr class='top_line'>";
				echo "<td align='center'><b>(C)</b></td>";
				echo "<td ".correct_color($row["answer"], "C")."><div style='padding: 4px;'>".$row["C"]."</div></td>";
				echo "</tr>";

				echo "<tr class='top_line'>";
				echo "<td align='center'><b>(D)</b></td>";
				echo "<td ".correct_color($row["answer"], "D")."><div style='padding: 4px;'>".$row["D"]."</div></td>";
				echo "</tr>";

				echo "<tr>";
				echo "<td colspan='5' align='right' style='padding: 8px'>";
				echo "<button class='btn_s blue' data-toggle='modal' data-target='#edit_".$row["no"]."'>編輯</button>";
				echo "<button class='btn_s red' data-toggle='modal' data-target='#delete_".$row["no"]."'>刪除</button>";
				echo "</td>";
				echo "</tr>";
			}

			?>

		</table>

		<?php

		pagination($_GET["page"], ceil($total/$amount), $other_url_value);

		?>

	</div>

	<?php

	$result=mysqli_query($con, "SELECT * FROM $question_db_name[0] LIMIT $offset, $amount");
	
	while($row=mysqli_fetch_assoc($result))
	{
		/*DELETE MODAL*/
		echo "<div class='modal fade' id='delete_".$row["no"]."'>";
		echo "<div class='modal-dialog'>";
		echo "<div class='modal-content'>";

		echo "<form action='setting.php?delete' method='POST'>";

		echo "<div class='modal-header'>";
		echo "<button class='close' data-dismiss='modal'>&times;</button>";
		echo "<h4 class='modal-title'>刪除題目</h4>";
		echo "</div>";

		echo "<div class='modal-body'>";

		echo "<input type='hidden' name='type' value='".$_GET["type"]."'>";
		echo "<input type='hidden' name='page' value='".$_GET["page"]."'>";
		echo "<input type='hidden' name='no' value='".$row["no"]."'>";

		echo "即將刪除第".$row["no"]."題<br/>";
		echo "是否確認刪除該題目？該動作將無法復原！";

		echo "</div>";

		echo "<div class='modal-footer'>";
		echo "<button class='btn btn-default' data-dismiss='modal'>取消</button>";
		echo "<input type='submit' value='刪除' class='btn btn-default'>";
		echo "</div>";

		echo "</form>";

		echo "</div>";
		echo "</div>";
		echo "</div>";

		/*EDIT MODAL*/
		echo "<div class='modal fade' id='edit_".$row["no"]."'>";
		echo "<div class='modal-dialog'>";
		echo "<div class='modal-content'>";

		echo "<form action='setting.php?edit' method='POST'>";

		echo "<div class='modal-header'>";
		echo "<button class='close' data-dismiss='modal'>&times;</button>";
		echo "<h4 class='modal-title'>編輯題目內容</h4>";
		echo "</div>";

		echo "<div class='modal-body'>";

		echo "<input type='hidden' name='type' value='".$_GET["type"]."'>";
		echo "<input type='hidden' name='page' value='".$_GET["page"]."'>";
		echo "<input type='hidden' name='no' value='".$row["no"]."'>";

		echo "第".$row["no"]."題編輯<br/><br/>";

		echo "題目敘述<br/>";
		echo "<textarea name='question' style='min-height: 128px; width: 100%; resize: vertical; overflow: hidden;'>".$row["question"]."</textarea><br/><br/>";

		for($i="A"; $i<="D"; $i++)
		{
			echo "(".$i.")選項<br/>";
			echo "<textarea name='".$i."' style='min-height: 32px; width: 100%; resize: vertical; overflow: hidden;'>".$row[$i]."</textarea><br/><br/>";
		}

		echo "正解<br/>";
		echo "<select name='answer'>";
		for($i="A"; $i<="D"; $i++)
			echo "<option value='".$i."' ".($row["answer"]==$i ? "selected='selected'" : NULL).">".$i."</option>";
		echo "</select>";

		echo "</div>";

		echo "<div class='modal-footer'>";
		echo "<button class='btn btn-default' data-dismiss='modal'>取消</button>";
		echo "<input type='submit' value='確認' class='btn btn-default'>";
		echo "</div>";

		echo "</form>";

		echo "</div>";
		echo "</div>";
		echo "</div>";
	}

	/*ADD MODAL*/
	echo "<div class='modal fade' id='add'>";
	echo "<div class='modal-dialog'>";
	echo "<div class='modal-content'>";

	echo "<form action='setting.php?add' method='POST'>";

	echo "<div class='modal-header'>";
	echo "<button class='close' data-dismiss='modal'>&times;</button>";
	echo "<h4 class='modal-title'>新增題目</h4>";
	echo "</div>";

	echo "<div class='modal-body'>";

	echo "<input type='hidden' name='type' value='".$_GET["type"]."'>";
	echo "<input type='hidden' name='page' value='".$_GET["page"]."'>";

	$count=0;
	for($i=1; $i<=$total+10 && $count<5; $i++)
	{
		$result=mysqli_query($con, "SELECT no FROM $question_db_name[0] WHERE no='$i'");

		if(!$row=mysqli_fetch_assoc($result))
			$missing_number[$count++]=$i;
	}

	echo "題目編號<br/>";
	echo $question_db_name[1]."_<select name='no'>";
	foreach($missing_number as $value)
		echo "<option value='".$value."'>".str_pad($value, 3, "0", STR_PAD_LEFT)."</option>";
	echo "</select><br/><br/>";

	echo "題目敘述<br/>";
	echo "<textarea name='question' style='min-height: 128px; width: 100%; resize: vertical; overflow: hidden;'></textarea><br/><br/>";

	for($i="A"; $i<="D"; $i++)
	{
		echo "(".$i.")選項<br/>";
		echo "<textarea name='".$i."' style='min-height: 32px; width: 100%; resize: vertical; overflow: hidden;'></textarea><br/><br/>";
	}

	echo "正解<br/>";
	echo "<select name='answer'>";
	for($i="A"; $i<="D"; $i++)
		echo "<option value='".$i."'>".$i."</option>";
	echo "</select>";

	echo "</div>";

	echo "<div class='modal-footer'>";
	echo "<button class='btn btn-default' data-dismiss='modal'>取消</button>";
	echo "<input type='submit' value='確認' class='btn btn-default'>";
	echo "</div>";

	echo "</form>";

	echo "</div>";
	echo "</div>";
	echo "</div>";

	?>

</body>

</html>