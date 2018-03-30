<?php
include '../includes/classes.php';
if (isset($_POST['call'])) {
	$distance = $_REQUEST['distance'];
	$item = $_REQUEST['item'];
	$price = $_REQUEST['price'];
	$longitude = $_REQUEST['longitude'];
	$latitude = $_REQUEST['latitude'];
	$key = new business();
	$response = $key -> fetchPharmacy($longitude, $latitude, $item);
	/*$key = new item();
	 $response = $key -> sortItems($item, $price, $longitude, $latitude,$distance);*/
	echo json_encode($response);
}
?>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<input type="text" name="distance" placeholder="distance">
	<br/>
	<input type="text" name="item" placeholder="item">
	<br/>
	<input type="text" name="price" placeholder="price">
	<br/>
	<input type="text" name="longitude" placeholder="longitude">
	<br/>
	<input type="text" name="latitude" placeholder="latitude">
	<br/>
	<input type="submit" name="call" value="call">
</form>

