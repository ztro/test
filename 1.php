<script src="js/jquery-1.10.2.min.js"></script>
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<script src="js/jquery.dataTables.min.js"></script>
		<script src="js/dataTables.bootstrap.min.js"></script>		
		<link rel="stylesheet" href="css/dataTables.bootstrap.min.css" />
		<script src="js/bootstrap.min.js"></script>

	<span id="msg" style="color:red">xxx</span><br/>
							<form id="file-upload" class="form-horizontal well" action="1mp0rt.php" method="post" name="upload_excel" enctype="multipart/form-data">
								<label>CSV File:</label>
								<input type="file" name="file" id="file" class="input-large"></br>
								<button type="submit" id="submit" name="Import" class="btn btn-primary button-loading" data-loading-text="Loading...">Upload</button>
							</form>
  <script type="text/javascript" src="jquery-3.2.1.min.js"></script>
  <script type="text/javascript">
    var formData = new FormData($("#file-upload")[0]);
$.ajax({
    url: "imp0rt1.php",
    type: "POST",
    data : formData,
    processData: false,
    contentType: false,
    beforeSend: function() {
		$('#msg').val("Loadiinng.....");
    },
    success: function(data){
		$('#msg').val("Okeyyyyyy");



    },
    error: function(xhr, ajaxOptions, thrownError) {
       console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
});
  </script>