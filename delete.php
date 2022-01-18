<?php

//chú ý, trong lập trình không được xóa dữ liệu bằng phương thức GET!!!!

$getid = '';
if (isset($_POST['id'])) //kiểm tra xem dữ liệu về id có được đẩy lên không?
{
 
	$getid = $_POST['id'];

	require_once ('database.php');

	$sql = 'delete from doan where id = '.$getid;
	execute($sql);

	echo 'Đã xóa!';
}