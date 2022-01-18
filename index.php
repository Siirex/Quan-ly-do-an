<?php

//https://www.youtube.com/watch?v=q3yIjme2_8M

require_once ('database.php'); //nhúng các thiết lập của các câu thao tác truy-xuất với CSDL!
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>HoangDepTrai</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

</head>


<body>
	
	<!-- Container được sử dụng để thiết lập lề (margin) cho nội dung, giúp nội dung thích ứng với bố cục. Container chứa phần tử row và row là container của column (còn được gọi là hệ thống lưới). Container để bao gói các phần nội dung trên website hay tạo các hộp nội dung. -->

	<div class="container">

		<!-- Các panel primary, heading, title, body là các class bối cảnh.  -->

		<div class="panel panel-primary">

			<div class="panel-heading">
				<h3 class="panel-title">Quản lý Đồ án Sinh viên!</h3>
			</div>

			<div class="panel-body"> 

				<table class="table table-bordered table-hover"> <!-- thẻ *table tạo 1 bảng  -->
					
					<thead>
						<tr> <!-- thẻ *tr tạo 1 hàng trong bảng đó, với các cột tiêu đề (in đậm) dùng thẻ *th, và đối với các cột chứa dữ liệu thì dùng thẻ *td (ở dưới)  -->
							<th>STT</th>
							<th>Tên đồ án</th>
							<th>Mô tả</th>
							<th>SV thực hiện</th>
							<th>GVHD</th>
							<th width="200px">File pdf</th>
							<th width="200px">File Zip</th>
							<th width="60px"></th>
							<th width="60px"></th>
						</tr>
					</thead>

					<tbody> <!-- nơi hiển thị dữ liệu được truy-xuất từ CSDL -->

<?php

//đây là bước show kết quả ra từ CSDL!!!!!!

$sql = 'select * from doan'; //khai báo câu truy vấn select!
$doanList = executeResult($sql); //khai báo 1 giá trị trả về từ hàm thực thi executeResult (ở bên add-doan.php) với câu truy vấn $sql!

$index = 1;
foreach ($doanList as $std) // Vòng lặp foreach dùng để lặp các phần tử $std trong mảng $doanList.
{
	
	echo

		'<tr>
			<td>'.($index++).'</td>
			<td>'.$std['tendoan'].'</td>
			<td>'.$std['mota'].'</td>
			<td>'.$std['sinhvien'].'</td>
			<td>'.$std['gvhd'].'</td>
			<td>'.$std['filepdf'].'</td>
			<td>'.$std['filezip'].'</td>

			<td>
			<button class="btn btn-success"
			onclick=\'window.open("add-doan.php?id='.$std['id'].'","_self")\'>Sửa Đồ án!</button>
			</td>

			<td>
			<button class="btn btn-success" onclick="deletedoan('.$std['id'].')">Xóa Đồ án!</button>
			</td>

		</tr>';

		//chú ý, khi nhấn vào 2button ở trên, chương trình sẽ có 2 luồng thực thi:
			//1 là direct đến page "Sửa ĐA" tương ứng với [add-doan.php?id=X] với X là số id của hàng muốn sửa!
				//Chú ý, path page [add-doan.php?id=X] vẫn được kế thừa từ page "Thêm ĐA" [add-doan.php]
			//2 là 

}
?>
					</tbody>

				</table>
			
				<!--<button class="btn btn-success" onclick="window.open('add-doan.php', '_self')">
				Thêm Đồ án!</button> -->
				<!-- Sử dụng JS (thay vì thẻ <a>) với sự kiện onlick -->

				<button class="btn btn-warning">
					<a href="add-doan.php" target="_self">Thêm Đồ án!</a>
				</button>

				<!-- Thuộc tính target: _seft giúp mở add-doan.php (ở đây là pages mới) trong pages hiện tại -->

			</div>
		</div>

	</div>

	

	<script language="javascript">
		function deletedoan(id) //id của ĐA cần xóa (user trỏ đến nhấp vào)
		{
			
			option = confirm('Bắt đầu xóa?')
			if(!option) {return;}

			//sử dụng giao thức POST với file delete.php, dữ liệu đẩy lên là id, dữ liệu trả về sau khi hoàn thành!
			$.post('delete.php', {
				'id': id //truyền vào id cần xóa!
			}, function(data) {
				location.reload() //request lại page!
			})
		}
	</script>

</body>

</html>