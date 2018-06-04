
	<link rel="stylesheet" href="css/datepicker.css">
	<script src="js/bootstrap-datepicker1.js"></script>
	
	<script>
	$(document).ready(function(){
		$('#absen_date').datepicker({
			format: 'yyyy-mm',
			viewMode: "months",
			minViewMode: "months",
			//format: "yyyy-mm-dd",
			autoclose: true
		});
	});
	</script>
	
		
		<div class="row">
			<div class="col-lg-12">
			<div class="panel panel-default">
                    <div class="panel-heading">
                    	<div class="row">
                        	<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                            	<h3 class="panel-title">List of attendance by Month</h3>
                            </div>
                            
                        </div>
                       
                        <div class="clear:both"></div>
                   	</div>
					<div class="panel-body">
						<form class="form-horizontal">
								<div class="col-md-12 col-sm-12 col-xs-12">
								<div id="pb_loading" style="height:10px;width: 150px;margin:0 auto;" >&nbsp;</div><br>
									<div class="col-md-1 col-sm-1 col-xs-1">
										<label style="margin-top:10px;">Period</label>
									</div>
									<div class="col-md-3 col-sm-3 col-xs-3">
										<input type="text" data-placeholder="Month.." name="absen_date" id="absen_date" class="form-control" style="margin-left:-30px;" readonly />
									</div>
									
									<div class="col-md-3 col-sm-3 col-xs-6 ">
										<select tabindex="1" data-placeholder="Departement.." class="form-control" id="dept" name="dept">
										<?php
												$query = "select * from departments order by DEPTname ASC";
												$statement = $connect->prepare($query);
												$statement->execute();
												$result = $statement->fetchAll();
												echo '<option value="0">Select Dept...</option>';
												foreach($result as $row) {
													echo '<option value="'.$row['DEPTID'].'">'.$row['DEPTNAME'].'</option>';
												}
										?>
										</select>
									</div>

									
									<div id="id_submit" class="btn btn-primary" style="width: 100px;"> Search </div>
								</div>
							

						  </form>
					</div>
			</div>
				<div class="panel panel-default">
                    <div class="panel-body">
                   		<div class="row"><div class="col-sm-12 table-responsive">
                   			<table id="user_data" class="table table-bordered table-striped">
                   				<thead>
									<tr>
											<th>Date</th>
											<th>Day</th>
											<th>BadgeID</th>
											<th>Name</th>
											<th>Time In</th>
											<th>Real In</th>
											<th>Time Out</th>
											<th>Real Out</th>
											<th>Update</th>
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
					<div id="pb_loading" style="height:10px;width: 150px;margin:0 auto;" >&nbsp;xxxxxxx</div>
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
	var userdataTable;
	$('#id_submit').click(function(){
		var tgl = $('#absen_date').val();
		var dept = $('#dept').val();
		
		$.ajax({
			url:"absensi_fetch1.php",
			method:"POST",
			data:{tgl:tgl, dept:dept},
			dataType:"json",
			success:function(datax)
			{
				
				$('#id_submit').html(' Search ');
				userdataTable = $('#user_data').DataTable({
					"destroy": true,
					"processing": true,
					"oLanguage": {
					"sLoadingRecords": "Please wait - loading..."
					},
					"data":datax,
					"columnDefs":[
						{
							"targets":[4,5,6,7,8],
							"orderable":false
						}
					],
					"pageLength": 10
				}); 
			}, beforeSend: function () {
					$('#id_submit').html('<img src="img/loading1.gif" style="width: 18px;height:18px;">');
			}
		})
	});

	$('#add_button').click(function(){
		$('#user_form')[0].reset();
		$('.modal-title').html("<i class='fa fa-plus'></i> Add User");
		$('#action').val("Add");
		$('#btn_action').val("Add");
	});

/*	var userdataTable = $('#user_data').DataTable({
		"processing": false,
		"serverSide": false,
		"order": [],
		"ajax":{
			url:"absensi_fetch1.php","dataSrc":""
		},
		"columnDefs":[
			{
				"targets":[4,5,6,7,8],
				"orderable":false
			}
		],
		"pageLength": 10
	}); */

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
			url:"user_action.php",
			method:"POST",
			data:{id:user_id, btn_action:btn_action},
			dataType:"json",
			success:function(data)
			{
				//alert(data.username);
				$('#userModal').modal('show');
				$('#user_name').val(data.username);
				$('#user_login').val(data.login);
				$('#user_level').val(data.level);
				$('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Employee");
				$('#user_id').val(user_id);
				$('#action').val('Edit');
				$('#btn_action').val('Edit');
				$('#user_password').attr('required', false); 
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
