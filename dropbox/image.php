<?php

require "/var/www/dropbox/core/conf.php";

switch ( $_GET['mode'] ) {
	case 'thumb':
		$mode = 'thumb';
		break;
	case 'image':
	default:
		$mode = 'image';
}

$id = strval( $_GET['id'] );

$sql = sprintf("SELECT date,size FROM entries WHERE id=%d", $id );
$result = $db->query( $sql );
$row = $result->fetch_assoc();
$date = $row['date'];
$size = $row['size'];

header('Last-Modified: ' . gmdate( 'D, d M Y H:i:s', $date ) . ' GMT', true, 200 );
header('Expires: ' . gmdate( 'D, d M Y H:i:s',  $date + 86400 ) . ' GMT', true, 200 );

$ar = apache_request_headers();

if ( isset( $ar['If-Modified-Since'] ) && 
	( $ar['If-Modified-Since'] != '' ) &&
	( strtotime( $ar['If-Modified-Since']) >= $date ) ) {
	header( 'Last-Modified: ' . gmdate('D, d M Y H:i:s' ) . ' GMT', true, 304 );
	exit();
}


if ( $mode == 'thumb' )
{
	$sql = sprintf( "SELECT thumb FROM entries WHERE id=%d", $id );

	if ( $result = $db->query( $sql ) ) {

		$row = $result->fetch_assoc();
		header( 'Content-Length: ' . strlen( $row[thumb] ) );
		header( "content-type: image/jpeg" );
		print $row[thumb];

	}

} else {
	$sql = sprintf( "UPDATE entries SET views=views+1 WHERE id=%d", $id );
	if ( !$db->query( $sql ) ) die( "Query Error" );

	$sql = sprintf( "SELECT id FROM data WHERE entryid=%d order by id", $id );
	$result = $db->query( $sql );
	header('Content-Length: ' . $size );
	header("content-type: image/jpeg");
	while ( $row = $result->fetch_array() )
		$chunks[] = $row[0];
	$size = count( $chunks );


	for( $i = 0; $i < $size; $i++ ) {
		$sql = sprintf( "select filedata from data where id=%d", $chunks[$i] );
		$result = $db->query( $sql );
		$row = $result->fetch_array();
		print $row[0];
	}

}


$db->close();


?>
