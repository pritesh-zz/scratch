<?php
require "/var/www/dropbox/core/conf.php";
require "/var/www/dropbox/core/header.php";
?>
	<div id="form">

<h2>Upload</h2>
<form action="<?=$loc;?>/submit/" enctype="multipart/form-data" method="post">
<table id="form_table">
	<tr>
		<td>title</td>
		<td><input type="text" name="title" /></td>
	</tr>
	<tr>
		<td>tags</td>
		<td><input type="text" name="tags" /></td>
	</tr>
	<tr>
		<td>file</td>
		<td><input type="file" name="image" /></td>
	</tr>
	<tr>
		<td>password (to make changes)</td>
		<td><input type="password" name="password" /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><input type="submit" value="Upload" /></td>
	</tr>
</table>
</form>
	</div>
<?php
require "/var/www/dropbox/core/footer.php";
?>
