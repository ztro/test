		<span id="alert_action"></span>
		<div class="row">
			<div class="col-lg-12">
			<div class="panel panel-default">
                    <div class="panel-heading">
                    	<div class="row">
                        	<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                            	<h3 class="panel-title">Upload Data</h3>
                            </div>
                            
                        </div>
                       
                        <div class="clear:both"></div>
                   	</div>
					<div class="panel-body">
						<div  id="form-login">
							<form id = "form_upload" class="form-inline" action="1mp0rt.php" method="post" name="upload_excel" enctype="multipart/form-data">
							<div class="input-group">
									<label class="input-group-btn">
										<span class="btn btn-danger btn-md">
											Browse&hellip; <input type="file" id="media" name="file" style="display: none;" required>
										</span>
									</label>
									<input type="text" id="nm_file" class="form-control input-md" style="border:1px solid #ff0;max-width:300px;"readonly required>
								</div>
								<div class="input-group">
									<input type="submit" class="btn btn-md btn-primary" value="Start upload"><div id="v_loading" style="float:right;"></div>
								</div>
							</form>
						</div>
					</div>
			</div>
			
        </div>
        
	</div>
<script>
$(document).ready(function () {
	
	$("#form_upload").on('submit',(function(e) {
		e.preventDefault();
		$("#v_loading").html('<img src="img/loading1.gif" style="width: 40px;height:40px;">');
		$.ajax({
			url: "1mp0rt.php",        // Url to which the request is send
			type: "POST",             // Type of request to be send, called as method
			data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
			contentType: false,       // The content type used when sending data to the server.
			cache: false,             // To unable request pages to be cached
			processData:false,        // To send DOMDocument or non processed data file it is set to false
			success: function(data)   // A function to be called if request succeeds
			{
				$('#alert_action').fadeIn(1000).html('<div class="alert alert-success">'+data+'</div>');
				$("#v_loading").html('');
				
			}
		});
	}
));
});
</script>

<script>
	$(function() {
	  $(document).on('change', ':file', function() {
		var input = $(this),
			numFiles = input.get(0).files ? input.get(0).files.length : 1,
			label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
		input.trigger('fileselect', [numFiles, label]);
	  });

	  $(document).ready( function() {
		  $(':file').on('fileselect', function(event, numFiles, label) {

			  var input = $(this).parents('.input-group').find(':text'),
				  log = numFiles > 1 ? numFiles + ' files selected' : label;

			  if( input.length ) {
				  input.val(log);
			  } else {
				  if( log ) alert(log);
			  }

		  });
	  });
	  
	});
	</script>
<?php
include('footer.php');
?>
