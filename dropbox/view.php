<?php
require "/var/www/dropbox/core/conf.php";

$id = intval( $_GET['id'] );

$sql = sprintf( "select title,width,height,size,date,views,ip from entries where id=%d", $id );

if ( ! $result = $db->query( $sql ) ) {
	die("Query Error");
}


$entry = $result->fetch_assoc();

if ( $entry['width'] > 800 ) {
	$ratio = $entry['width'] / $entry['height'];
	$width = 800;
	$height = $width / $ratio;
} else {
	$width = $entry['width'];
	$height = $entry['height'];
}


$sql = sprintf( "select t.name from tags t, tagmap m where m.entry=%d && t.id=m.tag", $id );

$info = $result->fetch_assoc();

if ( ! $result = $db->query( $sql ) ) {
	die( "Query Error" );
}

require "/var/www/dropbox/core/header.php";
?>
	<div id="content">
	<h2>View</h2>
	URL: http://local.prikav.com<?=$loc;?>/view/<?=$id;?>/
	<br/>
	Direct: http://local.prikav.com<?=$loc;?>/image/<?=$id;?>/
         <br/>
         <br/>
         Title: <?=$entry['title'];?>
          <br/>
	Tags: 
	<?
	for($i = 0; $row = $result->fetch_assoc(); $i++ ) {
		if ( $i > 0 ) print ', ';
		print '<a href="' . $loc . '/tags/' . urlencode( $row['name'] ) . '/">' . $row['name'] . '</a>';
	}
	?>
	<br/>
	Uploaded: <?=date('Y-m-d @ H:i:s', $entry['date']);?> UTC
	<br/>
	Views: <?=$entry['views']; ?>
	<br/>
	Dimentions: <?=$entry['width']?>x<?=$entry['height']?>
	<br/>
	Size: <?=floor($entry['size']/1024)?>kb
	<br/>
	Uploaded by: <?=$entry['ip'];?>
	<br/>
	<a href="<?=$loc;?>/image/<?=$id;?>/"><img alt="<?=$title;?>" width="<?=$width?>" height="<?=$height?>" src="<?=$loc;?>/image/<?=$id;?>/" /></a>
	</div>
<?php
require "/var/www/dropbox/core/footer.php";
?>
