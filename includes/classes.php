<?php session_start();
require 'rb.php';
require 'config.php';
$connection=new connection();
R::setup("mysql:host=$connection->host;dbname=$connection->db", "$connection->db_user", "$connection->pass_phrase");
/*
 * CONSTRUCTION OF CLASSES
 * */
//item object
class item {
	public $menu;
	public $name;
	public $price;
	public $description;
	public $itemList = null;
	public function listItems($name, $price) {
		$this -> itemList = R::getAll("SELECT * FROM item WHERE name LIKE '%$name%' AND price <= '$price' ");
		$this -> fetch($name, null, $price);
		return $this -> itemList;
	}

	public function fetch($name, $menu, $price) {
		$response = array();
		$response['result'] = array();
		if (isset($menu) && isset($price)) {
			$items = R::getAll("SELECT id,name,price,description,menu FROM item WHERE menu='$menu' AND price <='$price'");

		} else if (isset($menu) && !isset($price)) {
			$items = R::getAll("SELECT id,name,price,description,menu FROM item WHERE menu='$menu'");

		} else if (!isset($menu) && isset($price) && !isset($name)) {
			$items = R::getAll("SELECT id,name,price,description,menu FROM item WHERE price<='$price'");

		} else if (isset($name) && isset($price)) {
			$items = R::getAll("SELECT * FROM item WHERE name LIKE '%$name%' AND price <= $price ");
		}
		//response structuring
		if (count($items) == 0) {
			$result = array('error_code' => 101, 'error_text' => "no result");
			array_push($response['result'], $result);
		} else {
			$this -> itemList = $items;
			$result = array('error_code' => 0, 'error_text' => "success", 'items' => $items);
			array_push($response['result'], $result);
		}
		return $response;
	}

	public function add($menu, $name, $price, $description) {
		$item = R::dispense("item");
		$item -> menu = $menu;
		$item -> name = $name;
		$item -> price = $price;
		$item -> description = $description;
		$id = R::store($item);
		if (isset($id)) {
			echo "1" . "|" . "Item successfully added";
		}
	}

	public function sortItems($itemName, $price, $longitude, $latitude, $distance) {
		//initialization
		$response = array();
		$menuList = array();
		$businessList = array();
		$menuKey = new menu(FALSE);
		$businessKey = new business();
		//getting items
		$item = $this -> listItems($itemName, $price);
		//getting menus
		for ($i = 0; $i < count($item); $i++) {
			$menuId = $item[$i]['menu'];
			$menu = $menuKey -> fetchById($menuId);
			$menuList[$i] = array("id" => $menu[0]['id'], "title" => $menu[0]['title'], "business" => $menu[0]['business']);
		}
		//getting businesses
		for ($j = 0; $j < count($menuList); $j++) {
			$businessId = $menuList[$j]['business'];
			$business = $businessKey -> fetchById($businessId);
			$businessList[$j] = array("id" => $business[0]['id'], "name" => $business[0]['name'], "latitude" => $business[0]['latitude'], "longitude" => $business[0]['longitude']);
		}

		$businessNear = $businessKey -> getNearest($businessList, $longitude, $latitude, $distance);

		//prepare response
		if (count($businessNear) > 0) {
			$response['result'] = array();
			$reply = array();
			$reply['error_code'] = 0;
			$reply['error_text'] = "success";
			$reply['businesses'] = array();
			for ($count = 0; $count < count($businessNear); $count++) {
				$bid = $businessNear[$count]['id'];
				//get menu for each business
				for ($countM = 0; $countM < count($menuList); $countM++) {
					if ($menuList[$countM]['business'] == $bid) {
						$mid = $menuList[$countM]['id'];
						//get items for the menu
						for ($countI = 0; $countI < count($item); $countI++) {
							if ($item[$countI]['menu'] == $mid) {
								$distance = $businessKey -> distanceCalculator($businessNear[$count]['latitude'], $latitude, $businessNear[$count]['longitude'], $longitude);
								$result = array('item' => $item[$countI]['name'], 'price' => $item[$countI]['price']." Rwf", 'menu' => $item[$countI]['name'], 'business' => $businessNear[$count]['name'], 'description' => $businessNear[$count]['description'], 'longitude' => $businessNear[$count]['longitude'], 'latitude' => $businessNear[$count]['latitude'], 'distance' => $distance);
								array_push($reply['businesses'], $result);
							}
						}
					}
				}
			}
			array_push($response['result'], $reply);
		} else {
			$result = array();
			$response['result'] = array();
			//build response
			$result['error_code'] = 101;
			$result['error_text'] = "No result";
			array_push($response['result'], $result);
		}
		return $response;
	}

}

//the class for searching items

//menu object
class menu {

	public $title;
	public $category;
	public $business ;
	private $display = FALSE;
	public function __construct($display) {
		$this -> display = $display;
	}

	public function fetchById($menuId) {
		$menu = R::getAll("SELECT id,title,business FROM menu WHERE id ='$menuId'");
		return $menu;
	}

	public function fetch($business) {
		$menu = array();
		$response = array();
		$response['result'] = array();
		if (isset($business)) {
			$menu = R::getAll("SELECT id,title FROM menu WHERE business='$business'");
		} else {
			$menu = R::getAll("SELECT id,title FROM menu");
		}
		if ($this -> display == TRUE) {
			for ($i = 0; $i < count($menu); $i++) {
				echo "<option value=" . $menu[$i]['id'] . ">" . $menu[$i]['title'] . "</option>";
			}
		} else {
			if (count($menu) == 0) {
				$result = array('error_code' => 101, 'error_text' => "no result");
				array_push($response['result'], $result);
			} else {
				$result = array('error_code' => 0, 'error_text' => "success", "menu" => $menu);
				array_push($response['result'], $result);
			}
		}
		return $response;
	}

	//this is the function to get the list of insurance
	public function fetchInsurance() {
		$response = array();
		$response['result'] = array();
		$insurance = R::getAll("SELECT DISTINCT title FROM menu WHERE category='INSURANCE'");
		if (isset($insurance) && count($insurance) > 0) {
			$result = array('error_code' => 0, 'error_text' => "success", "insurance" => $insurance);
			array_push($response['result'], $result);
		} else {
			$result = array('error_code' => 101, 'error_text' => "no result");
			array_push($response['result'], $result);
		}
		return $response;
	}

	public function add($title, $category, $business) {
		$menu = R::dispense("menu");
		$menu -> title = $title;
		$menu -> category = strtoupper($category);
		$menu -> business = $business;
		$id = R::store($menu);
		if (isset($id)) {
			if ($this -> display == TRUE) {
				echo "1" . "|" . "menu successfully added";
			}

		}
	}

	//getting menu categories
	public function getCategories() {
		$categories = R::getCol("SELECT DISTINCT category FROM menu");
		if ($this -> display == TRUE) {
			for ($i = 0; $i < count($categories); $i++) {
				echo "<option value=" . $categories[$i] . ">" . $categories[$i] . "</option>";
			}
		}
		return $categories;
	}

}

//business object
class business {
	public function fetchById($businessId) {
		$business = R::getAll("SELECT b.id,b.name,b.description,
									l.longitude,l.latitude,l.resident									
							FROM business AS b JOIN location AS l 
							WHERE b.id=l.resident AND b.id='$businessId'
							       ");
		return $business;
	}

	//setting boundaries
	private function locConverter($longitude, $latitude, $distance) {
		//distance in meters

		if (isset($distance)) {
			$lonVar = $distance / 111320;
			$latVar = $distance / 110570;
		} else {
			$lonVar = 1000 / 111320;
			$latVar = 1000 / 110570;
		}
		return array($lonVar, $latVar);
	}

	//calculate distance between two
	public function distanceCalculator($latitude, $latitude0, $longitude, $longitude0) {
		$degreeLen = 111320;
		$x = $latitude - $latitude0;//(x1-y1)
		$y = ($longitude - $longitude0) * cos($latitude0);
		$distance = $degreeLen * sqrt(($x * $x) + ($y * $y));
		$distance=round($distance,0)." m";
		return $distance;
	}

	//find those near
	public function getNearest($businessList, $longitude, $latitude, $distance) {
		$businessNear = array();
		//set variations
		$coordinateVariation = $this -> locConverter($longitude, $latitude, $distance);
		//set diameter
		$maxLon = $longitude + $coordinateVariation[0];
		$minLon = $longitude - $coordinateVariation[0];
		$maxLat = $latitude + $coordinateVariation[1];
		$minLat = $latitude - $coordinateVariation[1];
		//loop counter
		$i = 0;
		$j = 0;
		for (; $i < count($businessList); $i++) {
			if ((($businessList[$i]['longitude'] <= $maxLon) && ($businessList[$i]['longitude'] >= $minLon)) && (($businessList[$i]['latitude'] <= $maxLat) && ($businessList[$i]['latitude'] >= $minLat))) {

				$businessNear[$j] = $businessList[$i];
				$j++;
			}
		}
		return $businessNear;
	}

	//this is the the function to sort out the business
	public function fetch($longitude, $latitude, $sortBy) {
		//setting longitude and latitude variation
		$lonVar = 1000 / 111320;
		$latVar = 1000 / 110570;
		//setting variations
		$maxLon = $longitude + $lonVar;
		$mixLon = $longitude - $lonVar;
		$maxLat = $latitude + $latVar;
		$minLat = $latitude - $latVar;
		$business = array();
		$response = array();
		$response['result'] = array();
		if (isset($sortBy) && $sortBy == "location") {
			$business = R::getAll("SELECT b.id,b.logo,b.name,
									l.longitude,l.latitude,l.resident									
							FROM business AS b JOIN location AS l 
							WHERE b.id=l.resident
							      AND l.longitude <='$maxLon' AND l.longitude >='$mixLon'
							      AND l.latitude <='$maxLat' AND l.latitude >='$minLat'");
		} else {
			$business = R::getAll("SELECT b.id,b.logo,b.name,
									l.longitude,l.latitude,l.resident									
							FROM business AS b JOIN location AS l 
							WHERE b.id=l.resident");
		}
		if (count($business) == 0) {
			$result = array('error_code' => 101, 'error_text' => "no result");
			array_push($response['result'], $result);
		} else {
			$result = array('error_code' => 0, 'error_text' => "success", 'business' => $business);
			array_push($response['result'], $result);
		}
		return $response;
	}

	public function fetchPharmacy($longitude, $latitude, $assurance) {
		//setting longitude and latitude variation
		$lonVar = 1000 / 111320;
		$latVar = 1000 / 110570;
		//setting variations
		$maxLon = $longitude + $lonVar;
		$mixLon = $longitude - $lonVar;
		$maxLat = $latitude + $latVar;
		$minLat = $latitude - $latVar;
		$business = array();
		$response = array();
		$response['result'] = array();
		if (isset($assurance)) {
			$business = R::getAll("SELECT b.id,b.name,b.category,
									l.longitude,l.latitude,l.resident,
									m.business,m.title,m.category									
							FROM business AS b JOIN location AS l JOIN menu AS m
							WHERE b.id=l.resident AND m.title='$assurance' AND m.category='Insurance' AND b.category='Pharmacy'
							AND l.longitude <='$maxLon' AND l.longitude >='$mixLon'
							      AND l.latitude <='$maxLat' AND l.latitude >='$minLat'
							      ");
		}
		if (count($business) == 0) {
			$result = array('error_code' => 101, 'error_text' => "no result");
			array_push($response['result'], $result);
		} else {
			$result = array();
			$result['error_code']=0;
			$result['error_text']="success";
			$result['pharmacy']=array();						
			//arrange response
			$pharmacyList=array();
			for($counter=0;$counter< count($business);$counter++){
				$distance=$this->distanceCalculator($business[$counter]['latitude'], $latitude, $business[$counter]['longitude'], $longitude);
				$businessList=array('name'=>$business[$counter]['name'],'latitude'=>$business[$counter]['latitude'],'longitude'=>$business[$counter]['longitude'],'distance'=>$distance);
			    array_push($result['pharmacy'],$businessList);
			}
			array_push($response['result'], $result);
		}
		return $response;
	}

	public function add($name, $category, $description, $location_name, $longitude, $latitude) {
		if ($this -> validate_name($name)) {
			//save business details
			$business = R::dispense("business");
			$business -> name = $name;
			$business -> category = strtoupper($category);
			$business -> description = $description;
			$id = R::store($business);
			if (isset($id)) {
				//save location details
				$location = R::dispense("location");
				$location -> name = $location_name;
				$location -> longitude = $longitude;
				$location -> latitude = $latitude;
				$location -> resident = $id;
				R::store($location);
				echo "1" . "|" . "business successfully added";
			} else {
				echo "0" . "|" . "action failed";
			}
		} else {
			echo "0" . "|" . "Business name already exist!";
		}
	}

	//validating business name
	public function validate_name($name) {
		$business = R::getCol("SELECT name FROM business WHERE name='$name'");
		if (count($business) == 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	//business select list
	public function selectList() {
		$business = R::getAll("SELECT id,name FROM business");
		for ($i = 0; $i < count($business); $i++) {
			echo "<option value=" . $business[$i]['id'] . ">" . $business[$i]['name'] . "</option>";
		}
		return $business;
	}

	//getting business categories
	public function getCategories() {
		$categories = R::getCol("SELECT DISTINCT category FROM business");
		for ($i = 0; $i < count($categories); $i++) {
			echo "<option value=" . $categories[$i] . ">" . $categories[$i] . "</option>";
		}
		return $categories;
	}

}

//user object
class user {
	private $userType = [
        0 => "administrator",
        1 => "manager",
		2 => "staff",
		3 => "customer",
    ];
	private $test;
	//getting the user
	public function fetch() {

	}

	//getting add the user
	public function add($fname, $lname, $email, $tel, $address, $username, $password, $type, $business) {
		if (!$this -> validate($username)) {
			//saving user credentials
			$user_credentials = R::dispense("credentials");
			$user_credentials -> username = $username;
			$user_credentials -> password = md5($password);
			$user_credentials -> type = $type;
			$user_credentials -> status = 1;
			$id = R::store($user_credentials);
			//saving user details
			$user_details = R::dispense("user");
			$user_details -> id = $id;
			$user_details -> fname = $fname;
			$user_details -> lname = $lname;
			$user_details -> email = $email;
			$user_details -> phone = $tel;
			$user_details -> address = $address;
			$id = R::store($user_details);
			if (isset($id)) {
				echo "1" . "|" . "User successfully added";
			} else {
				echo "0" . "|" . "Failed to add user";
			}
		} else {
			echo "0" . "|" . "Username already exists!";
		}
	}

	//validate username
	private function validate($username) {
		$check = FALSE;
		$user = R::getCol("SELECT DISTINCT id FROM credentials WHERE username='$username'");
		if (isset($user) && count($user) > 0) {
			$check = TRUE;
		}
		return $check;
	}

	//evaluating logged in user
	private function evalLoggedUser($id, $u) {
		global $database;
		//getting the logged in user information
		$logged_user = R::getRow("SELECT id FROM credentials WHERE user_id = {$id} AND username ='{$u}'  AND user_status='1' LIMIT 1");
		if (isset($logged_user)) {
			return true;
		}
	}

	//checking if user is logged in
	public function checkLogin() {
		$user_ok = false;
		$user_id = "";
		$log_usename = "";
		$category = "";
		if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
			$user_id = preg_replace('#[^0-9]#', '', $_SESSION['user_id']);
			$log_usename = preg_replace('#[^a-z0-9]#i', '', $_SESSION['username']);
			// Verify the user
			$user_ok = $this -> evalLoggedUser($user_id, $log_usename);
		} else if (isset($_COOKIE["user_id"]) && isset($_COOKIE["username"]) && isset($_COOKIE["type"])) {
			$_SESSION['user_id'] = preg_replace('#[^0-9]#', '', $_COOKIE['user_id']);
			$_SESSION['username'] = preg_replace('#[^a-z0-9]#i', '', $_COOKIE['username']);
			$user_id = preg_replace('#[^0-9]#', '', $_SESSION['user_id']);
			$log_usename = preg_replace('#[^a-z0-9]#i', '', $_SESSION['username']);
			// Verify the user
			$user_ok = $this -> evalLoggedUser($user_id, $log_usename);
			if ($user_ok == true) {
				// Update their lastlogin datetime field
				R::exec("UPDATE credentials SET last_login = now() WHERE user_id = '$user_id' LIMIT 1");
			}
		}
		return $user_ok;
	}

	//login user
	public function login($username, $password) {
		$password = md5($password);
		$user = R::getRow("SELECT id,username,type FROM credentials WHERE username='$username' AND password='$password'");
		if (isset($user)) {
			// CREATE THEIR SESSIONS AND COOKIES
			$_SESSION['user_id'] = $db_id = $user['id'];
			$_SESSION['username'] = $db_username = $user['username'];
			$_SESSION['type'] = $db_type = $this->userType[$user['type']];
			if ($user['type'] == 'manager') {
				$this -> setBusiness($user['id']);
			}
			setcookie("user_id", $db_id, strtotime('+30 days'), "/", "", "", TRUE);
			setcookie("username", $db_username, strtotime('+30 days'), "/", "", "", TRUE);
			setcookie("type", $db_type, strtotime('+30 days'), "/", "", "", TRUE);
			// UPDATE THEIR "LASTLOGIN" FIELDS
			R::exec("UPDATE credentials SET last_login = now() WHERE id = '$db_id' LIMIT 1");
			echo "success";
		} else {
			echo "failed";
		}
	}

	//setting the relative business on a manager
	private function setBusiness($user) {
		$business = R::getCol("SELECT DISTINCT id FROM business WHERE manager='$user'");
		if (isset($business)) {
			//add business session
			$_SESSION['business'] = $biz_id = $business['id'];
			setcookie("business", $biz_id, strtotime('+30 days'), "/" . "", "", TRUE);
		}
	}

}