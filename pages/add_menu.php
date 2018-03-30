<?php require '../includes/classes.php'; ?>
<?php $title="NCSLocator |Add menu" ?>
<?php ob_start(); ?>
<h1>Add new menu</h1>
<!--Adding Menu form-->
<div class="col-md-8">
	<form role="form" onsubmit="return false">
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon">Related business</span>
				<select id="add_menu_business" class="form-control">
					<option value="">Select business</option>
					<?php
					$key=new business;
					$key->selectList();
					?>					
				</select>
			</div>
		</div>
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon">Title</span>
				<input type="text" id="add_menu_title" required class="form-control">
			</div>
		</div>
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon">Category</span>				
				<select id="add_menu_category" onchange="specifyCategory(this);" class="form-control">
					<option value="">Select category</option>	
					<?php
					$key=new menu();
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
				<input type="submit" class="btn btn-info" onclick="addMenu();" value="Save"/>
			</div>
		</div>
		<div class="form-group">
			<div id="add_menu_status">
				
			</div>
		</div>		
	</form>
</div>
<?php $content=ob_get_clean();?>
<?php include '../layout/layout_main.php'; ?>