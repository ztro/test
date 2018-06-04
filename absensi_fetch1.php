<?php
error_reporting(1);
//user_fetch.php

include('database_connection.php');
$Period = explode('-',$_POST['tgl']);
$bulan = $Period[1];
$tahun = $Period[0];
$dept = $_POST['dept'];
$team = $_POST['team'];
//echo $bulan.'>'.$tahun.'>'.$dept;
//exit();

$query = "select * from v_absensi where month(tgl) = '$bulan' and year(tgl) = '$tahun' order by nama DESC";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

$response = array();

$filtered_rows = $statement->rowCount();
foreach($result as $row){
	$hari = date_format(date_create($row['tgl']),"l");
	if ($row['masuk']=='-') {
		$masuk = '<button type="button" class="btn btn-danger btn-xs update"> - null - </button>';
	}
	else {
		$masuk = $row['masuk'];
	}
	if ($row['keluar']=='-') {
		$keluar = '<button type="button" class="btn btn-danger btn-xs update"> - null - </button>';
	}
	else {
		$keluar = $row['keluar'];
	}
                array_push($response,
                    array(
							$row['tgl'],
							$hari,
							$row['badgeid'],
							$row['nama'],
							$masuk,
							$row['real_in'],
							$keluar,
							$row['real_out'],
							'<button type="button" name="update" id="'.$row["badgeid"].'" class="btn btn-warning btn-xs update">Update</button>'
						)
                    );
            }

echo json_encode($response);


?>