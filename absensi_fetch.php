<?php

//user_fetch.php

include('database_connection.php');

$query = '';

$output = array();

$query .= "select * from v_absensi ";

if(isset($_POST["search"]["value"]))
{
	$query .= 'where (badgeid LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR nama LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR tgl LIKE "%'.$_POST["search"]["value"].'%") ';
	
}
$columns = array( 
// datatable column index  => database column name
	0 =>'tgl', 
	1 => 'tgl',
	2=> 'badgeid',
	3=> 'nama'
);
if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$columns[$_POST['order'][0]['column']].' '.$_POST['order'][0]['dir'].' ';
}
else
{
	$query .= 'ORDER BY nama ASC ';
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
//echo 'total : ' . $filtered_rows;
foreach($result as $row)
{
	
	$sub_array = array();
	$sub_array[] = $row['tgl'];
	$hari = date_format(date_create($row['tgl']),"l");
	$sub_array[] = $hari;
	$sub_array[] = $row['badgeid'];
	$sub_array[] = $row['nama'];
	if ($row['masuk']=='-') {
		$sub_array[] = '<button type="button" class="btn btn-danger btn-xs update"> - null - </button>';
	}
	else {
		$sub_array[] = $row['masuk'];
	}
	$sub_array[] = $row['real_in'];
	if ($row['keluar']=='-') {
		$sub_array[] = '<button type="button" class="btn btn-danger btn-xs update"> - null - </button>';
	}
	else {
		$sub_array[] = $row['keluar'];
	}
	$sub_array[] = $row['real_out'];
	$sub_array[] = '<button type="button" name="update" id="'.$row["badgeid"].'" class="btn btn-warning btn-xs update">Update</button>';
	$data[] = $sub_array;
}
$query1 = "";
$query1 .= "select * from v_absensi ";

if(isset($_POST["search"]["value"]))
{
	$query1 .= 'where (badgeid LIKE "%'.$_POST["search"]["value"].'%" ';
	$query1 .= 'OR nama LIKE "%'.$_POST["search"]["value"].'%" ';
	$query1 .= 'OR tgl LIKE "%'.$_POST["search"]["value"].'%") ';
	
}
$columns = array( 
// datatable column index  => database column name
	0 =>'tgl', 
	1 => 'tgl',
	2=> 'badgeid',
	3=> 'nama'
);
if(isset($_POST["order"]))
{
	$query1 .= 'ORDER BY '.$columns[$_POST['order'][0]['column']].' '.$_POST['order'][0]['dir'].' ';
}
else
{
	$query1 .= 'ORDER BY nama ASC ';
}
$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"recordsTotal"  	=>  $filtered_rows,
	"recordsFiltered" 	=> 	get_total_all_records($connect,$query1),
	"data"    			=> 	$data
);
echo json_encode($output);

function get_total_all_records($connect,$qry)
{
	$statement = $connect->prepare($qry);
	$statement->execute();
	return $statement->rowCount();
}

?>