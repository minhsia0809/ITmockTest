<form action="/itmocktest/user/change_password_check.php" method="POST" enctype="multipart/form-data">

	<div class="modal-header">
		<button class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">修改密碼</h4>
	</div>

	<div class="modal-body">
		輸入舊密碼<br/>
		<input type="password" name="old" pattern="[\w !%*+,-/:?]+" minlength="8" maxlength="20" required="required"><br/><br/>
		輸入新密碼<br/>
		<input type="password" name="new" pattern="[\w !%*+,-/:?]+" minlength="8" maxlength="20" required="required"><br/>
		<font size="1" color="gray">請輸入8至20個英數字元，可使用以下特殊符號_!%*+,-/:?</font><br/><br/>
		確認新密碼<br/>
		<input type="password" name="newcheck" pattern="[\w !%*+,-/:?]+" minlength="8" maxlength="20" required="required"><br/>
		<font size="1" color="gray">新密碼與確認新密碼需一致</font><br/><br/>
	</div>
				
	<div class="modal-footer">
		<button class="btn btn-default" data-dismiss="modal">取消</button>
		<input type="submit" value="修改" class="btn btn-default">
	</div>

</form>