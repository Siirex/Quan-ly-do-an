<?php

// File này có chức năng là 1 bộ cấu hình chung (các file khác sẽ gọi đến) giúp truy-xuất Database:



//Tạo phương thức kết nối cho Database gồm: tên Host,Database, thông tin xác thực username!
//require_once ('config.php');
define('HOST', 'localhost');
define('DATABASE', 'quanlydoan');
define('USERNAME', 'root');
define('PASSWORD', '');

// Với các chức năng insert, update, delete - sẽ sử dụng bộ thao tác *function với hàm thực thi *execute sau:
// Chú ý, 3 chắc năng trên chỉ có thao tác như: mở, đóng kết nối và truy vấn đến CSDL!

function execute($sql) { // truyền câu truy vấn $sql (insert, update, delete) vào hàm thực thi!
	
	//ở đây sử dụng bộ extensions *Mysqli để thực hiện việc truy-xuất Database!

	//tạo 1 connection kết nối đến database - sử dụng hàm *mysqli_connection với phương thức kết nối là: Host, thông tin xác thực Username, ... được lấy từ bộ config được nhúng bên trên:
	$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);

	//tạo 1 luồng truy vấn query đến database:
	mysqli_query($conn, $sql);

	//đóng conncetion
	mysqli_close($conn);

}


// Với chức năng select - sẽ sử dụng bộ thao tác *function với hàm thực thi *executeResult sau:
// Chú ý, đến chắc năng này thì lại có thao tác như: mở, đóng kết nối, truy vấn đến CSDL và CSDL reponse trả kết quả lại. Do đó tại đây, sẽ thêm thao tác trích xuất trả về - sử dụng hàm *mysqli_fetch_array!

function executeResult($sql) { // truyền câu truy vấn $sql (select) vào hàm thực thi!
	
	$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);

	// khai báo kết quả *resulset, kết quả này được lấy từ hàm query (được truyền vào với câu truy vấn $sql) trả về:
	$resultset = mysqli_query($conn, $sql);

	$list = []; //khai báo mảng để lấy dữ liệu từ CSDL!
	
	//quá trình lấy data từ CSDL (resultset):
	while ($row = mysqli_fetch_array($resultset, 1)) //hàm tìm và trả về kết quả của câu truy vấn $sql (được trích ra từ $resulset mà CSDL tìm được) dưới dạng mảng - chứa thông tin của hàng kết quả ($row).
	{

		$list[] = $row; // mảng list mỗi lần lấy xong dữ liệu từ database đổ ra, nó sẽ gán vào row!
	}

	mysqli_close($conn);

	return $list;
}