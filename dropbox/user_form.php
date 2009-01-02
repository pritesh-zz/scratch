<?php
require "/var/www/dropbox/core/conf.php";
require "/var/www/dropbox/core/header_prikav.php";
?>
	<div id="user_form">

<h2>Sign Up</h2>
<form action="<?=$loc;?>/create/" enctype="multipart/form-data" method="post">
<table id="form_table1">
	<tr>
		<td>First Name</td>
		<td><input type="text" name="first name" /></td>
	</tr>
	<tr>
		<td>Last Name</td>
		<td><input type="text"last name="tags" /></td>
	</tr>
	<tr>
		<td>Email (only user name)</td>
		<td><input type="text" name="email" /></td>
	</tr>
	<tr>
		<td>password ()</td>
		<td><input type="password" name="password" /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><input type="submit" value="Create" /></td>
	</tr>
</table>
</form>
	</div>
<?php
require "/var/www/dropbox/core/footer.php";
?>
