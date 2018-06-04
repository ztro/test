<?php

//user_action.php

include('database_connection.php');

if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'Add')
	{
		$query = "
		INSERT INTO loginx (login, username, password, level) 
		VALUES (:login, :username, :password, :level)
		";	
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':login'		=>	$_POST["login"],
				':password'	=>	md5($_POST["password"]),
				':username'		=>	$_POST["username"],
				':level'		=>	$_POST["level"]
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'New User Added';
		}
	}
	if($_POST['btn_action'] == 'fetch_single')
	{
		$query = "
		SELECT * FROM loginx WHERE id = :id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':id'	=>	$_POST["id"]
			)
		);
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$output['login'] = $row['login'];
			$output['username'] = $row['username'];
			$output['level'] = $row['level'];
		}
		echo json_encode($output);
	}
	if($_POST['btn_action'] == 'Edit')
	{
		if($_POST['password'] != '')
		{
			$query = "
			UPDATE loginx SET 
				username = '".$_POST["username"]."', 
				login = '".$_POST["login"]."',
				password = '".md5($_POST["password"])."',
				level = '".$_POST["level"]."' 
				WHERE id = '".$_POST["id"]."'
			";
		}
		else
		{
			$query = "
			UPDATE loginx SET 
				username = '".$_POST["username"]."', 
				login = '".$_POST["login"]."',
				level = '".$_POST["level"]."' 
				WHERE id = '".$_POST["id"]."'
			";
		}
		$statement = $connect->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'User Details Edited';
		}
	}
	if($_POST['btn_action'] == 'delete')
	{
		
		$query = "
		DELETE from loginx 
		WHERE id = :id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':id'		=>	$_POST["id"]
			)
		);	
		$result = $statement->fetchAll();	
		if(isset($result))
		{
			echo 'User <'.$_POST["username"].'> has Deleted';
		}
	}
}

?>