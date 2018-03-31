<?php require '../includes/classes.php'; ?>
<?php $title="NCSLocator |Add item" ?>
<?php ob_start(); ?>
<h1>Add new product</h1>
<!--Adding Item form-->
<div class="col-md-8">
	<form role="form" onsubmit="return false">
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon">Related business</span>
				<select id="add_item_business" onchange="specifyMenu(this);" class="form-control">
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
				<span class="input-group-addon">Product type</span>				
				<select id="add_item_menu" class="form-control">
					<option value="0">None</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon">Name</span>
				<input type="text" id="add_item_name" required class="form-control">
			</div>
		</div>	
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon">Price</span>
				<input type="number" id="add_item_price" required class="form-control">
			</div>
		</div>
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon">Description</span>
				<textarea class="form-control" id="add_item_description">
					
				</textarea>
			</div>
		</div>	
		<div class="form-group">
			<div class="input-group">				
				<input type="submit" class="btn btn-info" onclick="addItem();" value="Save"/>
			</div>
		</div>
		<div class="form-group">
			<div id="add_item_status">
				
			</div>
		</div>		
	</form>
</div>
<?php $content=ob_get_clean();?>
<?php include '../layout/layout_main.php'; ?>