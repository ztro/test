<?php

//user_fetch.php

include('database_connection.php');
$output = array();
$query = '';
$query .= "select loginx.id AS id,loginx.login AS login,loginx.username AS username,level.level_name AS level_name,
	loginx.password AS password,loginx.level AS level 
	from loginx left join level on loginx.level = level.level_id ";

if(isset($_POST["search"]["value"]))
{
	$query .= 'where (loginx.login LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR loginx.username LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR level.level_name LIKE "%'.$_POST["search"]["value"].'%") ';
}
$columns = array( 
	0 =>'loginx.login', 
	1 => 'loginx.username',
	2=> 'level.level_name'
);
if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$columns[$_POST['order'][0]['column']].' '.$_POST['order'][0]['dir'].' ';
}
else
{
	$query .= 'ORDER BY login ASC ';
}

if($_POST["length"] != -1)
{
	$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

$data = array();

$filtered_rows = $statement->rowCount();

foreach($result as $row)
{
	
	$sub_array = array();
	$sub_array[] = $row['login'];
	$sub_array[] = $row['username'];
	$sub_array[] = $row['level_name'];
	$sub_array[] = '<button type="button" name="update" id="'.$row["id"].'" class="btn btn-warning btn-xs update">Update</button>';
	$sub_array[] = '<button type="button" name="delete" id="'.$row["id"].'" class="btn btn-danger btn-xs delete" data-status="'.$row["username"].'">Delete</button>';
	$data[] = $sub_array;
}

$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"recordsTotal"  	=>  $filtered_rows,
	"recordsFiltered" 	=> 	get_total_all_records($connect),
	"data"    			=> 	$data
);
echo json_encode($output);

function get_total_all_records($connect)
{
	$statement = $connect->prepare("select loginx.id AS id,loginx.login AS login,loginx.username AS username,level.level_name AS level_name,
	loginx.password AS password,loginx.level AS level 
	from loginx left join level on loginx.level = level.level_id");
	$statement->execute();
	return $statement->rowCount();
}

?>