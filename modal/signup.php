<form action="/itmocktest/user/signup_check.php" method="POST">

	<div class="modal-header">
		<button class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">申請帳號</h4>
	</div>

	<div class="modal-body">
		使用者名稱<br/>
		<input type="text" name="username" pattern="^[a-zA-Z]\w+" minlength="6" maxlength="30" required="required"><br/>
		<font size="1" color="gray">請輸入6至30個英數字元，需以英文字母為開頭</font><br/><br/>
		密碼<br/>
		<input type="password" name="password" pattern="[\w !%*+,-/:?]+" minlength="8" maxlength="20" required="required"><br/>
		<font size="1" color="gray">請輸入8至20個英數字元，可使用以下特殊符號_!%*+,-/:?</font><br/><br/>
		確認密碼<br/>
		<input type="password" name="password_check" pattern="[\w !%*+,-/:?]+" minlength="8" maxlength="20" required="required"><br/>
		<font size="1" color="gray">密碼與確認密碼需一致</font><br/><br/>
		已經有帳號了嗎？
		<a href="/itmocktest/modal/login.php" data-toggle="modal" data-target="#login" onclick="$('#signup').modal('hide');">會員登入</a><br/><br/>
	</div>
				
	<div class="modal-footer">
		<button class="btn btn-default" data-dismiss="modal">取消</button>
		<input type="submit" value="申請" class="btn btn-default">
	</div>

</form>