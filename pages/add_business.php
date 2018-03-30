<?php require '../includes/classes.php'; ?>
<?php $title="NCSLocator |Add business" ?>
<?php ob_start(); ?>
<h1>Register business</h1>
<!--Adding business form-->
<div class="col-md-8">
	<form role="form" onsubmit="return false">
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon">Name</span>
				<input type="text" id="add_business_name" required class="form-control">
			</div>
		</div>
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon">Category</span>				
				<select id="add_business_category" onchange="specifyCategory(this);" class="form-control">
					<option value="">Select category</option>
					<?php
					 $key=new business();
					 $key->getCategories();
					?>
					<option value="0">Other</option>
				</select>
			</div>
		</div>
		<div id='spec_category'>
			
		</div>
					
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon">Location</span>
				<input type="text" id="add_business_location" required class="form-control">
			</div>
		</div>
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon">Longitude</span>
				<input type="text" id="add_business_longitude" required class="form-control">
			</div>
		</div>
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon">Latitude</span>
				<input type="text" id="add_business_latitude" required class="form-control">
			</div>
		</div>
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon">Logo</span>
				<input type="file" id="add_business_logo" >
			</div>
		</div>
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon">Description</span>
				<textarea class="form-control" id="add_business_description"></textarea>
			</div>
		</div>
		<div class="form-group">
			<div class="input-group">				
				<input type="submit" class="btn btn-info" onclick="addBusiness();" value="Save"/>
			</div>
		</div>
		<div class="form-group">
			<div id="add_business_status">
				
			</div>
		</div>		
	</form>
</div>
<?php $content = ob_get_clean(); ?>
<?php
	include '../layout/layout_main.php';
?>