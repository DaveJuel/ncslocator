<?php
//THIS IS THE FILE THAT CALLS CLASSES
require 'classes.php';

//getting caller details
if (!isset($_REQUEST['action']) || !isset($_REQUEST['caller'])) {
	echo "System error, please restart the action";
	exit ;
} else {
	$action = $_REQUEST['action'];
	$caller = $_REQUEST['caller'];
}
switch ($action) {
	//admin functionalities
	case 'log_in' :
		//getting the required values to log in
		$username = $_REQUEST['username'];
		$password = $_REQUEST['password'];
		$key = new user();
		$key -> login($username, $password);
		break;
	case 'add_business' :
		$name = $_REQUEST['name'];
		$category = $_REQUEST['category'];
		$description = $_REQUEST['description'];
		$location = $_REQUEST['location'];
		$longitude = $_REQUEST['longitude'];
		$latitude = $_REQUEST['latitude'];
		$key = new business();
		$key -> add($name, $category, $description, $location, $longitude, $latitude);
		break;
	case 'add_menu' :
		$title = $_REQUEST['title'];
		$category = $_REQUEST['category'];
		$business = $_REQUEST['business'];
		$key = new menu(TRUE);
		$key -> add($title, $category, $business);
		break;
	case 'add_item' :
		$menu = $_REQUEST['menu'];
		$name = $_REQUEST['name'];
		$price = $_REQUEST['price'];
		$description = $_REQUEST['description'];
		$key = new item;
		$key -> add($menu, $name, $price, $description);
		break;
	case 'add_user' :
		$fname = $_REQUEST['fname'];
		$lname = $_REQUEST['lname'];
		$email = $_REQUEST['email'];
		$tel = $_REQUEST['tel'];
		$address = $_REQUEST['address'];
		$username = $_REQUEST['username'];
		$password = $_REQUEST['password'];
		$userType = $_REQUEST['type'];
		$key = new user;
		$key -> add($fname, $lname, $email, $tel, $address, $username, $password, $userType, null);
		break;
	case 'get_menu' :
		$business = $_REQUEST['business'];
		$key = new menu(TRUE);
		$key -> fetch($business);
		break;
	case 'get_business' :
		$longitude = $_REQUEST['longitude'];
		$latitude = $_REQUEST['latitude'];
		$sortBy = $_REQUEST['sort'];
		//calling the business
		$key = new business();
		$response = $key -> fetch($longitude, $latitude, $sortBy);
		if ($caller == "app") {
			echo json_encode($response);
		}
		break;
	case 'locate_pharmacy' :
		$longitude = $_REQUEST['longitude'];
		$latitude = $_REQUEST['latitude'];
		$assurance = $_REQUEST['assurance'];
		$key = new business();
		$response = $key -> fetchPharmacy($longitude, $latitude,$assurance);
		if ($caller == "app") {
			echo json_encode($response);
		}
		break;
	case 'get_insurance' :
	    $key =new menu(FALSE);
		$response=$key->fetchInsurance();
		if($caller=="app"){
			echo json_encode($response);
		}
		break;

	case 'locate_item' :
		$item = $_REQUEST['item'];
		$price = $_REQUEST['price'];
		$longitude = $_REQUEST['longitude'];
		$latitude = $_REQUEST['latitude'];
		$distance=$_REQUEST['distance'];
		$key = new item();
		$response = $key -> sortItems($item, $price, $longitude, $latitude,$distance);
		if ($caller == "app") {
			echo json_encode($response);
		}
		break;
	default :
		$response = array();
		$response['result'] = array();
		$result = array('error_code' => 101, 'error_text' => 'failed');
		array_push($response['result'], $result);
		if ($caller == "app") {
			echo json_encode($response);
		} else {
			echo "failed";
		}
		break;
}
?>