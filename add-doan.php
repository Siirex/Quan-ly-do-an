
<?php
	
	require_once ('database.php');

	//----------------------Thực hiện lấy dữ liệu và đưa lên CSDL bằng phương thức POST-------------------------

	$xid = $xtendoan = $xmota = $xsinhvien = $xgvhd = $xfilepdf = $xfilezip = '';

	//hàm !empty() giúp kiểm tra giá trị POST: có tồn tại && có dữ liệu - hay k?

	if(!empty($_POST)) {
		
		//hàm isset() kiểm tra giá trị POST (chính là dữ liệu được user nhập vào ở thuộc tính "name") đã được khởi tạo hay chưa? Nếu đã tồn tại, trả về giá trị true.
		// Vì thế, ở dưới là quá trinh lấy ra các thông tin (id, tendoan, mota, ...) trong POST và kiểm tra xem nó đã có && chứa dữ liệu chưa. Nếu có thì isset() trả về TRUE giúp chạy lệnh trong if: gán dữ liệu vào biến mới $x...

		if(isset($_POST['tendoan']))	{ $xtendoan = $_POST['tendoan']; }
		if(isset($_POST['mota']))		{ $xmota = $_POST['mota']; }
		if(isset($_POST['sinhvien']))	{ $xsinhvien = $_POST['sinhvien']; }
		if(isset($_POST['gvhd']))		{ $xgvhd = $_POST['gvhd']; }
		if(isset($_POST['filepdf']))	{ $xfilepdf = $_POST['filepdf']; }
		if(isset($_POST['filezip']))	{ $xfilezip = $_POST['filezip']; }
		if(isset($_POST['id']))			{ $xid = $_POST['id']; }

		if ($xid != '')
		{
			//update
			$sql = "update doan set tendoan = '$xtendoan', mota = '$xmota', sinhvien = '$xsinhvien', 
			gvhd = '$xgvhd', filepdf = '$xfilepdf', filezip = '$xfilezip' where id = ".$xid;

		} else {
			//insert
			//trong quá trinh thực hiện thêm ĐA, id lúc này có giá trị rỗng (vì không được nhập).
			$sql = "insert into doan(tendoan, mota, sinhvien, gvhd, filepdf, filezip)
			values ('$xtendoan','$xmota','$xsinhvien','$xgvhd','$xfilepdf','$xfilezip')";
		}

		execute($sql);

		header('Location: index.php'); //quay về trang chủ index.php!
		die();

	}

	//---------------------------Thực hiện lấy dữ liệu từ CSDL bằng phương thức GET------------------------------

	//Sau khi direct đến pages "Sửa ĐA"" với path [add-doan.php?id=X], lệnh sau sẽ vẫn sổ ra dữ liệu cũ trước đó:

	$getid = ''; //khởi tạo 1 biến id trung gian!

	if (isset($_GET['id'])) //nếu giá trị id được lấy ra tồn tại! (trường hợp Thêm ĐA thì id không tồn tại)
	{
		$getid = $_GET['id']; //..thì lấy dữ liệu id đó ra (hay là gán dữ liệu được lấy ra vào 1 giá trị $id mới)

		$sql = 'select * from doan where id = '.$getid; //sổ ra dữ liệu có id mà vừa lấy ra băng câu truy vấn select.

		$doanList = executeResult($sql); //bắt các dữ liệu mà $sql vừa lấy được!

		//Lưu ý, giá trị $doanList chỉ trả về được thông tin 1 ĐA thôi!
		//thực hiện gán giá trị:
		$std = $doanList[0]; //lây ra dữ liệu ĐA đó (với vị trí index=0)
		$xtendoan = $std['tendoan'];
		$xmota = $std['mota'];
		$xsinhvien = $std['sinhvien'];
		$xgvhd = $std['gvhd'];
		$xfilepdf = $std['filepdf'];
		$xfilezip = $std['filezip'];
	}

?>


<!DOCTYPE html>
<html>

<head>
	
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>UpdateData</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

</head>

<body>
	<div class="container">
		<div class="panel panel-primary">
			
			<div class="panel-heading">
				<h2 class="text-center">ĐỒ ÁN MỚI</h2>
			</div>

			<div class="panel-body">
				
				<!-- Sử dụng phương thức POST để đẩy dữ liệu (update) lên Database. -->

				<!-- Cụ thể tại bước này, nó muốn tiến hành đẩy các dữ liệu được user nhập vào trong thẻ *input với thuộc tính "name" như: id, tendoan, mota, ... lên Database. -->
				
				<!-- Đối với trường hợp chức năng Sửa, phương thức *values sẽ show ra các giá trị $x... được gán cho trước đó (dòng 60-67)-->

				<form method="post">
				<!-- Không có thuộc tính action, nó sẽ chỉ định dữ liệu sẽ được gửi với phương thứ POST đến xử lý tại đây (add-doan.php) -->

					<div class="form-group"> 

					  <!-- style="display: none;" -->
					  <label for="name">Tên đồ án:</label>
					  <input type="number" name="id" value="<?=$getid?>">
					  <input type="text" class="form-control" id="name" name="tendoan" value="<?=$xtendoan?>">
					</div>

					<div class="form-group">
					  <label for="readme">Mô tả đồ án:</label>
					  <input type="text" class="form-control" id="readme" name="mota" value="<?=$xmota?>">
					</div>

					<div class="form-group">
					  <label for="sva">Sinh viên thực hiện:</label>
					  <input type="text" class="form-control" id="sv" name="sinhvien" value="<?=$xsinhvien?>">
					</div>

					<div class="form-group">
					  <label for="gv">Giáo viên hướng dẫn:</label>
					  <input type="text" class="form-control" id="gv" name="gvhd" value="<?=$xgvhd?>">
					</div>

					<div class="form-group">
					  <label for="pdf">Tệp PDF đồ án:</label>
					  <input type="text" class="form-control" id="pdf" name="filepdf" value="<?=$xfilepdf?>">
					</div>

					<div class="form-group">
					  <label for="zip">Tệp Zip source code:</label>
					  <input type="text" class="form-control" id="zip" name="filezip" value="<?=$xfilezip?>">
					</div>

					<button class="btn btn-success">Lưu đồ án!</button>

					<!-- Khi nhấn vào Button này, dữ liệu nhận được từ các thẻ *input sẽ đưa vào Database. -->

					<!-- Button ở đây là một nút để user kết thúc nhập liệu, chuyển sang gửi dữ liệu -->

				</form>

			</div>

		</div>
	</div>
</body>

</html>