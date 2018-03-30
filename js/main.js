//log function
function logIn() {
	var username = document.getElementById("log_username").value;
	var password = document.getElementById("log_password").value;
	var status = document.getElementById("log_status");
	if (username == "" || password == "") {
		notifier(0, "Fill all fields please", status);
	} else {
		notifier(2, "Please wait", status);
		var xmlhttp = new XMLHttpRequest;
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.status == 200 && xmlhttp.readyState == 4) {
				var response = xmlhttp.responseText;
				if (response == 'success') {
					notifier(1, "Log in successful", status);
					window.location = "home.php";
				} else {
					notifier(0, "Authentication failed", status);
				}
			}
		};
		xmlhttp.open("GET", "../includes/interface.php?caller=site&action=log_in&username=" + username + "&password=" + password, true);
		xmlhttp.send();
	}
}

//this is the function to notify
function notifier(status, text, holder) {
	/*
	 *0=failure
	 *1=success
	 *2=pending
	 * */
	if (status == 0) {
		holder.innerHTML = "<span class='alert alert-danger'>" + text + "</span>";
	} else if (status == 1) {
		holder.innerHTML = "<span class='alert alert-success'>" + text + "</span>";
	} else {
		holder.innerHTML = "<span class='alert alert-info'>" + text + "<i class='fa fa-spinner fa-pulse'></i></span>";
	}
}

//adding business
function addBusiness() {
	var name = document.getElementById("add_business_name").value;
	var category = document.getElementById("add_business_category").value;
	if (category == 0 || category == "") {
		category = document.getElementById("add_business_category_other").value;
	}
	var description = document.getElementById("add_business_description").value;
	var location = document.getElementById("add_business_location").value;
	var longitude = document.getElementById("add_business_longitude").value;
	var latitude = document.getElementById("add_business_latitude").value;
	//sending data to server
	notifier(2, "Please wait", document.getElementById("add_business_status"));
	var xmlhttp = new XMLHttpRequest;
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.status == 200 && xmlhttp.readyState == 4) {
			var response = xmlhttp.responseText.split("|");
			notifier(response[0], response[1], document.getElementById("add_business_status"));
			if (response[0] == 1) {
				window.location.reload();
			}
		}
	};
	xmlhttp.open("GET", "../includes/interface.php?caller=site&action=add_business&name=" + name + "&category=" + category + "&description=" + description + "&location=" + location + "&longitude=" + longitude + "&latitude=" + latitude, true);
	xmlhttp.send();
}

//getting the business category
function specifyCategory(obj) {
	var displayHolder = document.getElementById("spec_category");
	var elementId = obj.id.split("_");
	elementIdSet = elementId[0] + "_" + elementId[1];
	if (obj.value == 0) {
		displayHolder.innerHTML = "<div class='form-group'><div class='input-group'>" + "<span class='input-group-addon'>Other specify</span>" + "<input type='text' class='form-control' required id='" + elementIdSet + "_category_other'>" + "</div></div>";
	} else {
		displayHolder.innerHTML = "";
	}
}

//adding a menu
function addMenu() {
	var title = document.getElementById("add_menu_title").value;
	var category = document.getElementById("add_menu_category").value;
	if (category == 0 || category == "") {
		category = document.getElementById("add_menu_category_other").value;
	}
	var business = document.getElementById("add_menu_business").value;
	//sending data to server
	notifier(2, "Please wait", document.getElementById("add_menu_status"));
	var xmlhttp = new XMLHttpRequest;
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.status == 200 && xmlhttp.readyState == 4) {
			var response = xmlhttp.responseText.split("|");
			notifier(response[0], response[1], document.getElementById("add_menu_status"));
			if (response[0] == 1) {
				window.location.reload();
			}
		}
	};
	xmlhttp.open("GET", "../includes/interface.php?caller=site&action=add_menu&title=" + title + "&category=" + category + "&business=" + business, true);
	xmlhttp.send();
}

//getting business menu
function specifyMenu(obj) {
	var business = obj.value;
	var holder = obj.id.split("_");
	holder = document.getElementById(holder[0] + "_" + holder[1] + "_menu");
	var xmlhttp = new XMLHttpRequest;
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			var response = xmlhttp.responseText;
			holder.innerHTML = response;
		}
	};
	xmlhttp.open("GET", "../includes/interface.php?caller=site&action=get_menu&business=" + business, true);
	xmlhttp.send();
}

//adding item
function addItem() {
	var menu = document.getElementById("add_item_menu").value;
	var name = document.getElementById("add_item_name").value;
	var price = document.getElementById("add_item_price").value;
	var description = document.getElementById("add_item_description").value;
	notifier(2, "Adding item ", document.getElementById("add_item_status"));
	//notifier(1, "Item added succefully ", document.getElementById("add_item_status"));
	if (name == "" && price == "") {
		notifier(0, "Fill all fields please!", document.getElementById("add_item_status"));
	} else {
		var xmlhttp = new XMLHttpRequest;
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.status == 200 && xmlhttp.readyState == 4) {
				var response = xmlhttp.responseText.split("|");
				notifier(response[0], response[1], document.getElementById("add_item_status"));
			}
		};
		xmlhttp.open("GET", "../includes/interface.php?caller=site&action=add_item&menu=" + menu + "&name=" + name + "&price=" + price + "&description=" + description, true);
		xmlhttp.send();
	}
}

//adding the user
function addUser() {
	var fname = document.getElementById("add_user_fname").value;
	var lname = document.getElementById("add_user_lname").value;
	var tel = document.getElementById("add_user_tel").value;
	var email = document.getElementById("add_user_email").value;
	var address = document.getElementById("add_user_address").value;
	var username = document.getElementById("add_user_username").value;
	var password = document.getElementById("add_user_password").value;
	var confirmed_pass = document.getElementById("add_user_password_confirmed").value;
	var userType = document.getElementById("add_user_type").value;
	if (password != confirmed_pass) {
		notifier(0, "Passwords do not match", document.getElementById("add_user_status"));
	} else {
		notifier(2, "Adding user", document.getElementById("add_user_status"));
		var xmlhttp = new XMLHttpRequest;
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.status == 200 && xmlhttp.readyState == 4) {
				var response = xmlhttp.responseText.split("|");
				notifier(response[0], response[1], document.getElementById("add_user_status"));
			}
		};
		xmlhttp.open("GET", "../includes/interface.php?caller=site&action=add_user&fname=" + fname + "&lname=" + lname + "&tel=" + tel + "&email=" + email + "&address=" + address + "&username=" + username + "&password=" + password + "&type=" + userType, true);
		xmlhttp.send();
	}
}

//this is the function to show the map

function initMap() {
	// Create a map object and specify the DOM element for display.
	var map = new google.maps.Map(document.getElementById('map-display'), {
		center : {
			lat : -34.397,
			lng : 150.644
		},
		scrollwheel : false,
		zoom : 8
	});
}

