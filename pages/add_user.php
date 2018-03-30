<?php
require '../includes/classes.php';
 ?>
<?php $title="NCSLocator |Add user" ?>
<?php ob_start(); ?>
<h1>Register new user</h1>
<!--Adding user form-->
<div class="col-md-8">
	<form role="form" onsubmit="return false">
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon">First name</span>
				<input type="text" id="add_user_fname" required class="form-control">
			</div>
		</div>
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon">Last name</span>
				<input type="text" id="add_user_lname" required class="form-control">
			</div>
		</div>
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon">email</span>
				<input type="email" id="add_user_email" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon">Tel</span>
				<input type="text" id="add_user_tel" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon">Address</span>
				<input type="text" id="add_user_address" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon">Username</span>
				<input type="text" id="add_user_username" required class="form-control">
			</div>
		</div>
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon">Password</span>
				<input type="password" id="add_user_password" required class="form-control">
			</div>
		</div>
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon">Confirm password</span>
				<input type="password" id="add_user_password_confirmed" required class="form-control">
			</div>
		</div>
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon">Type</span>
				<select id="add_user_type" class="form-control">
					<option value="0">Administrator</option>
					<option value="1">Manager</option>
					<option value="2">Staff</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<div class="input-group">
				<input type="submit" class="btn btn-info" onclick="addUser();" value="Save"/>
			</div>
		</div>
		<div class="form-group">
			<div id="add_user_status">

			</div>
		</div>
	</form>
</div>
<?php $content = ob_get_clean(); ?>
<?php
	include '../layout/layout_main.php';
?>