<?php
error_reporting(0);
include('database_connection.php');
$output = array();
$query = "select * from v_karyawan ";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
foreach($result as $row)
{
			array_push($output,
                    array(
						$row['badgenumber'],
						$row['name'],
						$row['DEPTNAME'],
						$row['team_name'],
						'<button type="button" name="update" id="'.$row["userid"].'" class="btn btn-warning btn-xs update">Update</button>',
						'<button type="button" name="delete" id="'.$row["userid"].'" class="btn btn-danger btn-xs delete" data-status="'.$row["name"].'">Delete</button>'
						)
					);
}
echo json_encode($output);

?>