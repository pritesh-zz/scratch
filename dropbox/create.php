<?php

require "/var/www/dropbox/core/conf.php";

if ( $_POST ) {
		$fname = strval( $_POST['First Name'] );
		$lname = strval( $_POST['Last Name'] );
                $password = strval( $_POST['password'] );
	 $host = gethostbyaddr( $_SERVER['REMOTE_ADDR'] ) . ' (' . $_SERVER['REMOTE_ADDR'] . ')';	
		$sql = sprintf( "insert into users (fname,lname,ip,password,date_time) 
						values ('%s','%s', '%s', '%s',UNIX_TIMESTAMP())",
				 	$db->real_escape_string( $fname ),
					$db->real_escape_string( $lname ),
					$db->real_escape_string( $host ),
					$db->real_escape_string( $password )
					);
                             }
		if ( !$db->query( $sql ) )
			die('error in query   '.$sql);
		$id = $db->insert_id;	



$db->close();


?>
