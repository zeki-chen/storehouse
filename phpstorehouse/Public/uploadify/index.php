<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>UploadiFive Test</title>
<script src="./jquery.min.js" type="text/javascript"></script>
<script src="jquery.uploadify.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="uploadify.css">
<style type="text/css">
body {
	font: 13px Arial, Helvetica, Sans-serif;
}
.uploadify{
	opacity: 0;	
}
</style>
</head>

<body>
	<h1>Uploadify Demo</h1>
	<form>
		<div id="queue"></div>
		<div style="position: relative;">
			<input id="file_upload" name="file_upload" type="file" multiple="true">
			<div style="width: 200px;height: 40px;background: none;position: absolute;top: 0;left: 0;z-index: 1;pointer-events: none;"></div>
		</div>
		<div id="upload_div">11</div>
	</form>

	<script type="text/javascript">
		<?php $timestamp = time();?>
		$(function() {
			$('#file_upload').uploadify({
				'formData'     : {
					'timestamp' : '<?php echo $timestamp;?>',
					'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
				},
				'swf'      : 'uploadify.swf',
				'uploader' : 'uploadify.php',
				 'onUploadSuccess' : function(file, data, response) {
		            //alert('The file ' + file.name + ' was successfully uploaded with a response of ' + response + ':' + data);
		            console.log(data);
		            var json=JSON.parse(data);
		            $("#upload_div").html(json.name);
		        }

			});
		});
	</script>
</body>
</html>