<?php
error_reporting(0);
session_start();
include('database_connection.php');
if(!isset($_SESSION["id"])) {header("location:login.php");}
	$extensions = array("dat", "DAT"); // file extensions to be checked
	$fileTypes = array("application/octet-stream","application/octet-stream"); // file types to be checked
	$file = $_FILES["file"];
	$file_extension = strtolower(end(explode(".", $file["name"])));
	if (in_array($file["type"],$fileTypes) && in_array($file_extension, $extensions)) {

		$filename=$_FILES["file"]["tmp_name"];
		if (empty($filename)){
		 echo "Invalid File:Please Upload DAT File (TAB).";		 
		 }
		 else
		 {
			 
			$t_item = 0;
			
		  	$file = fopen($filename, "r");
	         while (($emapData = fgetcsv($file, 0, "\t")) !== FALSE)
	         {
				 $vcek = get_total_all($connect,"select * from absensi where badgeid='$emapData[0]' and tanggal = '$emapData[1]' limit 1 ");
				 if ($vcek <= 0) {
					 $tgl = $emapData[1];
					 $sql = "INSERT into absensi (`badgeid`, 
												`tanggal`, 
												`status`, 
												`tipe`,
												`v1`, 
												`v2`) 
											values('$emapData[0]',
												'$tgl',
												'$emapData[2]',
												'$emapData[3]',
												'$emapData[4]',
												'$emapData[5]')";
				 
				  $statement = $connect->prepare($sql);
				  $statement->execute();
					if(! $statement )
					{
						echo "Error on process";
					exit();
					}
					$t_item++;
				}
	         }
	         fclose($file);
	        
	         echo "CSV File telah berhasil di Import ke Database. Total Item = ". $t_item ;
						
		 }
	}
	else
	{
		echo "***Invalid file Size or Type***";
	}

function get_total_all($connect,$qry)
{
	$statement = $connect->prepare($qry);
	$statement->execute();
	return $statement->rowCount();
}	
?>		 