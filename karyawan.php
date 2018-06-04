
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
                    <div class="panel-heading">
                    	<div class="row">
                        	<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                            	<h3 class="panel-title">Employee List</h3>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6" align="right">
                            	<button type="button" name="add" id="add_button" data-toggle="modal" data-target="#userModal" class="btn btn-success btn-xs">Add</button>
                        	</div>
                        </div>
                       
                        <div class="clear:both"></div>
                   	</div>
                   	<div class="panel-body">
                   		<div class="row"><div class="col-sm-12 table-responsive">
                   			<table id="user_data" class="table table-bordered table-striped">
                   				<thead>
									<tr>
										<th>BadgeID</th>
										<th>Nama</th>
										<th>Dept</th>
										<th>Team</th>
										<th>Edit</th>
										<th>Delete</th>
									</tr>
								</thead>
                   			</table>
                   		</div>
                   	</div>
               	</div>
           	</div>
        </div>
        <div id="userModal" class="modal fade">
        	<div class="modal-dialog">
        		<form method="post" id="user_form">
        			<div class="modal-content">
        			<div class="modal-header">
        				<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-plus"></i> Add Employee</h4>
        			</div>
        			<div class="modal-body">
        				<div class="form-group">
							<label>Enter BadgeID</label>
							<input type="text" name="badgeid" id="badgeid" class="form-control" required />
						</div>
						<div class="form-group">
							<label>Enter Name</label>
							<input type="password" name="password" id="user_password" class="form-control" required />
						</div>
						<div class="form-group">
							<label>Select Dept</label>
							<select name="level" id="user_level" class="form-control">
								<?php
										$qry = "select * from departments ORDER BY DEPTNAME"; 
										$statement = $connect->prepare($qry);
										$statement->execute();
										$result = $statement->fetchAll();
										echo '<option value="0">Select Dept...</option>';
										foreach($result as $row)
										{
										echo '<option value="'.$row['DEPTID'].'">'.$row['DEPTNAME'].'</option>';
										}
								?>
								</select>
						</div>
						<div class="form-group">
							<label>Select Team</label>
							<select name="level" id="user_level" class="form-control">
								<?php
										$qry = "select * from team order by team_name"; 
										$statement = $connect->prepare($qry);
										$statement->execute();
										$result = $statement->fetchAll();
										echo '<option value="0">Select Team...</option>';
										foreach($result as $row)
										{
										echo '<option value="'.$row['id'].'">'.$row['team_name'].'</option>';
										}
								?>
								</select>
						</div>
        			</div>
        			<div class="modal-footer">
        				<input type="hidden" name="id" id="user_id" />
        				<input type="hidden" name="btn_action" id="btn_action" />
        				<input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
        				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        			</div>
        		</div>
        		</form>

        	</div>
        </div>
	</div>
<script>
$(document).ready(function(){

	$('#add_button').click(function(){
		$('#user_form')[0].reset();
		$('.modal-title').html("<i class='fa fa-plus'></i> Add User");
		$('#action').val("Add");
		$('#btn_action').val("Add");
	});

	var userdataTable = $('#user_data').DataTable({
		"processing": false,
		"serverSide": false,
		"order": [],
		"ajax":{
			url:"karyawan_fetch.php","dataSrc":""
		},
		"columnDefs":[
			{
				"targets":[4,5],
				"orderable":false
			}
		],
		"pageLength": 10
	});

	$(document).on('submit', '#user_form', function(event){
		event.preventDefault();
		$('#action').attr('disabled','disabled');
		var form_data = $(this).serialize();
		$.ajax({
			url:"karyawan_action.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{
				$('#user_form')[0].reset();
				$('#userModal').modal('hide');
				$('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
				$('#action').attr('disabled', false);
				userdataTable.ajax.reload();
			}
		})
	});

	$(document).on('click', '.update', function(){
		var user_id = $(this).attr("id");
		var btn_action = 'fetch_single';
		$.ajax({
			url:"karyawan_action.php",
			method:"POST",
			data:{id:user_id, btn_action:btn_action},
			dataType:"json",
			success:function(data)
			{
				alert('testtt');/*
				$('#userModal').modal('show');
				$('#user_name').val(data.username);
				$('#user_login').val(data.login);
				$('#user_level').val(data.level);
				$('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Employee");
				$('#user_id').val(user_id);
				$('#action').val('Edit');
				$('#btn_action').val('Edit');
				$('#user_password').attr('required', false); */
			}
		})
	});

	$(document).on('click', '.delete', function(){
		var user_id = $(this).attr("id");
		var username = $(this).data('status');
		var btn_action = "delete";
		if(confirm("Are you sure you want to change status?"))
		{
			$.ajax({
				url:"user_action.php",
				method:"POST",
				data:{id:user_id, username:username, btn_action:btn_action},
				success:function(data)
				{
					$('#alert_action').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
					userdataTable.ajax.reload();
				}
			})
		}
		else
		{
			return false;
		}
	});

});
</script>

<?php
include('footer.php');
?>
