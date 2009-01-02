<?php

require "/var/www/dropbox/core/conf.php";

if ( $_POST ) {
	if ( is_uploaded_file( $_FILES['image']['tmp_name'] ) ) {
		$data = file_get_contents( $_FILES['image']['tmp_name'] );
		$img = getimagesize( $_FILES['image']['tmp_name'] );
		$title = strval( $_POST['title'] );
		$size = filesize( $_FILES['image']['tmp_name'] );
		$width = 100;
		$height = 100;
		$width_orig = $img[0];
		$height_orig = $img[1];
		$password = strval( $_POST['password'] );
		$host = gethostbyaddr( $_SERVER['REMOTE_ADDR'] ) . ' (' . $_SERVER['REMOTE_ADDR'] . ')';
		if ( $_POST['tags'] ) {
			$tags = explode( ',', strval( $_POST['tags'] ) );
			$tag_count = count( $tags );
		} else {
			$tags[] = 'none';
			$tag_count = 1;
		}

		$ratio_orig = $width_orig/$height_orig;

		if ( $width/$height > $ratio_orig) {
			$width = $height * $ratio_orig;
		} else {
			$height = $width / $ratio_orig;
		}

		$image_p = imagecreatetruecolor( floor( $width ), floor( $height ) );
		$image = imagecreatefromstring( $data );


		imagecopyresampled( $image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig );

		ob_start();
		imagejpeg($image_p, "", 100);
		$thumb = ob_get_contents();
		ob_end_clean();
 if ($password == 'Prit@Kavi@wht@up')
            {
		$sql = sprintf( "insert into entries (title,type,thumb,size,width,height,ip,password,views,date) 
						values ('%s',%d,'%s', %d, %d, %d, '%s', '%s', 0, UNIX_TIMESTAMP())",
				 	$db->real_escape_string( $title ),
					$img[2],
					$db->real_escape_string( $thumb ),
					$size,
					$width_orig,
					$height_orig,
					$db->real_escape_string( $host ),
					$db->real_escape_string( $password )
					);
                    } else {
                            die('Sorry buddy U don have my password GET OUT');
                             }
		if ( !$db->query( $sql ) )
			die('error in query');
		$id = $db->insert_id;	

		$fp = fopen( $_FILES['image']['tmp_name'], 'rb' );
		while ( !feof( $fp ) ) {
			$sql = sprintf( "insert into data (entryid, filedata) values (%d, '%s')",
					$id,
					$db->real_escape_string( fread( $fp, 65535 ) ) );
			if ( !$db->query( $sql ) ) die("error!!!");
		}
		fclose( $fp );


		for ( $i = 0; $i < $tag_count; $i++ ) {
			$cur = strtolower( $tags[$i] );
			$sql = sprintf( "select id from tags where name='%s'", $cur );
			$result = $db->query( $sql );
			if ( $result->num_rows < 1 ) {
				$sql = sprintf( "insert into tags (name) values ('%s')", $cur );
				$db->query( $sql );
				$tag_id = $db->insert_id;
			} else {
				$row = $result->fetch_array();
				$tag_id = $row[0];
			}
			$sql = sprintf( "insert into tagmap (tag,entry) values (%d,%d)", $tag_id, $id );
			$db->query( $sql );
		}
	}


}

header("location: $loc/view/" . $id . "/");

$db->close();


?>
