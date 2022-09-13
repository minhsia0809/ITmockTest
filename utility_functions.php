<?php

function db_link()
{
	return mysqli_connect("localhost", "root", "password", "php2020");
}

function top_menu()
{
	echo "<div class='top_bar top_title'>";
	echo "<a href='/itmocktest/homepage.php'>";
	echo "<img src='/itmocktest/image/logo.png' width='44'>&nbsp;資訊能力檢定模擬測驗";
	echo "</a>";
	echo "</div>";

	echo "<div class='top_bar top_menu'>";
	echo "<a class='bookmark' href='/itmocktest/homepage.php'>首頁</a>";
	echo "<a class='bookmark' href='/itmocktest/leaderboard.php'>排行榜</a>";
	echo "<a class='bookmark' href='/itmocktest/about.php'>關於</a>";

	if(isset($_COOKIE["member_ID"]))
	{
		$con=db_link();

		$member_ID=$_COOKIE["member_ID"];
		$result=mysqli_query($con, "SELECT * FROM user WHERE identity='$member_ID'");
		$row=mysqli_fetch_assoc($result);

		echo "<div style='float: right; margin-right: calc(18% + 110px);'>";

		echo "<div class='btn-group' style='width: 110px; position: fixed;'>";

		echo "<a class='bookmark' data-toggle='dropdown'><span class='caret'></span></a>";
		echo "<ul class='dropdown-menu'>";
		echo "<li><a href='/itmocktest/user/profile.php?id=".$row["identity"]."'><b>".$row["username"]."</b> (".identity_code($row["identity"]).")</a></li>";
		echo "<li class='divider'></li>";
		echo "<li><a href='/itmocktest/user/profile.php?id=".$row["identity"]."'>個人主頁</a></li>";
		echo "<li><a href='/itmocktest/user/transcript.php'>測驗成績單</a></li>";
		echo "<li><a>設定</a></li>";

		if($row["role"]==1 || $row["role"]==2)
		{
			echo "<li class='divider'></li>";
			echo "<li><a href='/itmocktest/question_management/show.php'>題庫管理系統</a></li>";

			if($row["role"]==2)
			{
				echo "<li><a href='/itmocktest/member_management/list.php'>會員管理系統</a></li>";
				echo "<li><a href='/itmocktest/statistical_charts.php'>統計數據</a></li>";
			}
		}
		
		echo "<li class='divider'></li>";
		echo "<li><a href='/itmocktest/modal/logout.php' data-toggle='modal' data-target='#logout'>登出</a></li>";
		echo "</ul>";

		echo "<a href='/itmocktest/user/profile.php?id=".$row["identity"]."'>";
		echo "<img src='/itmocktest/image/avatar/".$row["username"].".png' class='rounded on_bar'>";
		echo "</a>";

		echo "</div>";

		echo "</div>";
	}
	else
	{
		echo "<div style='float: right; margin-right: calc(18% + 110px);'>";

		echo "<a href='/itmocktest/modal/signup.php' class='bookmark' data-toggle='modal' data-target='#signup'>申請帳號</a>";
		echo "<a href='/itmocktest/modal/login.php' class='bookmark' data-toggle='modal' data-target='#login'>登入</a>";

		echo "<div class='btn-group' style='width: 110px; position: fixed;'>";

		echo "<a class='bookmark' data-toggle='dropdown'><span class='caret'></span></a>";
		echo "<ul class='dropdown-menu'>";
		echo "<li><a>尚未登入</a></li>";
		echo "<li class='divider'></li>";
		echo "<li><a>haha1</a></li>";
		echo "<li><a>haha2</a></li>";
		echo "<li class='divider'></li>";
		echo "<li><a>weed100</a></li>";
		echo "</ul>";

		echo "<a href='/itmocktest/modal/login.php' data-toggle='modal' data-target='#login'>";
		echo "<img src='/itmocktest/image/default_avatar.png' class='rounded on_bar'>";
		echo "</a>";

		echo "</div>";

		echo "</div>";
	}

	echo "</div>";

	echo "<div class='modal fade' id='login'>";
	echo "<div class='modal-dialog'>";
	echo "<div class='modal-content'>";
	echo "</div>";
	echo "</div>";
	echo "</div>";

	echo "<div class='modal fade' id='signup'>";
	echo "<div class='modal-dialog'>";
	echo "<div class='modal-content'>";
	echo "</div>";
	echo "</div>";
	echo "</div>";

	echo "<div class='modal fade' id='logout'>";
	echo "<div class='modal-dialog'>";
	echo "<div class='modal-content'>";
	echo "</div>";
	echo "</div>";
	echo "</div>";

	return;
}

function identity_code($identity)
{
	return "#".str_pad($identity, 4, "0", STR_PAD_LEFT);
}

function role_require($role=0)
{
	if(is_null($_COOKIE["member_ID"]))
		header("location: /itmocktest/homepage.php?login=-1");
	else
	{
		$con=db_link();
		
		$member_ID=$_COOKIE["member_ID"];
		$result=mysqli_query($con, "SELECT role FROM user WHERE identity='$member_ID'");
		$row=mysqli_fetch_assoc($result);

		if($row["role"]<$role)
			header("location: /itmocktest/homepage.php");
	}

	return;
}

function pagination($page, $max_page, $other_url_value=NULL)
{
	$url_value="?";

	if(isset($other_url_value))
		foreach($other_url_value as $key => $value)
			$url_value.=$key."=".$value."&";

	$url_value.="page=";

	if(is_null($page) || $page<1)
		header("location: ".$url_value."1");
	else if($page>$max_page)
		header("location: ".$url_value.$max_page);

	echo "<center>";

	if($page==1)
		echo "<button class='page' style='float: left;' disabled='disabled'>上一頁</button>";
	else
		echo "<button class='page' style='float: left;' onclick='javascript: location.href=\"".$url_value.($page-1)."\"'>上一頁</button>";

	if($page>=4)
		echo "<button class='page' onclick='javascript: location.href=\"".$url_value."1\"'>1</button> … ";

	for($i=$page-2; $i<=$page+2; $i++)
	{
		if($i<1 || $i>$max_page)
			continue;

		if($i!=$page)
			echo "<button class='page' onclick='javascript: location.href=\"".$url_value.$i."\"'>".$i."</button>";
		else
			echo "<button class='page active' disabled='disabled'>".$i."</button>";
	}

	if($page<=$max_page-3)
		echo " … <button class='page' onclick='javascript: location.href=\"".$url_value.$max_page."\"'>".$max_page."</button>";

	if($page==$max_page)
		echo "<button class='page' style='float: right;' disabled='disabled'>下一頁</button>";
	else
		echo "<button class='page' style='float: right;' onclick='javascript: location.href=\"".$url_value.($page+1)."\"'>下一頁</button>";

	echo "</center>";

	return;
}

function question_db_name($type)
{
	//[0] => table name
	//[1] => full name
	//[2] => chinese name

	switch($type)
	{
		case 0:
			return array("ex_compsci", "ComputerScience", "計算機概論");

		case 1:
			return array("ex_intro", "InternetIntroduction", "網際網路概論");

		case 2:
			return array("ex_security", "NetworkSecurity", "網路資訊安全");

		case 3:
			return array("ex_ethics", "InformationEthics", "資訊素養與倫理");

		case 4:
			return array("ex_office", "Office", "套裝軟體");
	}
}

function ranking($member_ID ,$type)
{
	$con=db_link();

	$result=mysqli_query($con, "SELECT * FROM user ORDER BY $type DESC");

	for($i=1; $row=mysqli_fetch_assoc($result); $i++)
		if($row["identity"]==$member_ID)
			return $i;
}

function test_data($transcript)
{
	$split=str_split($transcript, 5);

	for($i=0; $i<count($split); $i++)
	{
		$serial=intval(substr($split[$i], 0, -1));
		$test_data[$i+1]=array((int)floor($serial/1000), $serial%1000, substr($split[$i], -1));		
	}

	return $test_data;
}

function final_review($score)
{
	switch(true)
	{
		case ($score==100):
			return "你都對對，你棒棒，下次也要科吉霸！";

		case ($score>=90 && $score<100):
			return "快要全部都對對囉囉囉囉囉！";

		case ($score>=80 && $score<90):
			return "你已離全對的軌道已經太遠了喔。";;

		case ($score>=70 && $score<80):
			return "革命尚未成功，同志仍須努力！";

		case ($score>60 && $score<70):
			return "恭喜你完全偏離科吉霸星球，往不及格邁進gogogo！";	

		case ($score==60):
			return "你上輩子有燒香對吧？不然怎麼會剛好及格？";

		case ($score>=50 && $score<60):
			return "你想延畢，教授還不想看到你，趕快給我去把題庫刷100遍！";

		case ($score>=40 && $score<50):
			return "恭喜你大學讀4+1年，浪漫！";

		case ($score>=30 && $score<40):
			return "學妹都要畢業了你還不走，是想要當高大長青樹喔！";

		case ($score>=20 && $score<30):
			return "跟學弟一起畢業，一直魯，一直爽。";

		case ($score>=10 && $score<20):
			return "這種題目連我阿嬤都會，你這個小嫩逼！";

		case ($score>0 && $score<10):
			return "……你回去……重考大學……好了，……這樣就……不用考……資訊能力檢定測驗。";

		case ($score==0):
			return "我們懷念你(T~T)祝你平安喜樂，萬事如eeeeee~~";
	}
}

function correct_color($answer, $selection)
{
	if($answer==$selection)
		return "style='background: linear-gradient(to left, #FFFFFF 0%, #D5F5E3 100%);'";
	else
		return "style='background: linear-gradient(to left, #FFFFFF 0%, #FADBD8 100%);'";
}

function time_ago($last_login)
{
	if($last_login==-1)
		return "未曾上線";

	$ago=time()-$last_login;

	$time_str=array("天", "小時", "分鐘", "秒");
	$length=array(86400 ,3600, 60, 1);

	for($i=0; $i<4 && !floor($ago/$length[$i]); $i++);

	return floor($ago/$length[$i]).$time_str[$i]."前上線";
}

function role_name($role_ID)
{
	switch($role_ID)
	{
		case 0:
			return "學生";

		case 1:
			return "教師";

		case 2:
			return "管理者";
	}
}

?>