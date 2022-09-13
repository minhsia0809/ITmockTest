<form action="/itmocktest/user/changecheck.php" method="POST" enctype="multipart/form-data">

	<div class="modal-header">
		<button class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">更改大頭貼</h4>
	</div>

	<div class="modal-body">
		請選擇圖片<br/>
		<input type="file" name="photo" accept="image/*"><br/><br/>
	</div>
				
	<div class="modal-footer">
		<button class="btn btn-default" data-dismiss="modal">取消</button>
		<input type="submit" value="更改" class="btn btn-default">
	</div>

</form>