<form action="/itmocktest/user/login_check.php" method="POST">

	<div class="modal-header">
		<button class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">會員登入</h4>
	</div>

	<div class="modal-body">
		輸入帳號<br/>
		<input type="text" name="username" required="required"><br/><br/>
		輸入密碼<br/>
		<input type="password" name="password" required="required"><br/><br/>
		<input type="checkbox" name="keep_login" id="keep_login">
		<label for="keep_login">保持登入狀態</label><br/><br/>
		還沒有帳號嗎？
		<a href="/itmocktest/modal/signup.php" data-toggle="modal" data-target="#signup" onclick="$('#login').modal('hide');">申請帳號</a><br/><br/>
	</div>
				
	<div class="modal-footer">
		<button class="btn btn-default" data-dismiss="modal">取消</button>
		<input type="submit" value="登入" class="btn btn-default">
	</div>

</form>