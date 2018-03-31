 <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

            <div class="menu_section">
            <h3>Navigation</h3>	             
              <ul class="nav side-menu">
                <li><a><i class="fa fa-edit"></i>Add new <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                  	<?php 
                  	  //getting the type of user
                  	  if($_SESSION['type']=='administrator'){ 
                  	?>
                    <li><a href="add_business.php">Business</a>                    	
                    </li>
                    <?php
					  }
                    ?>
                    <li><a href="add_menu.php">Product type</a>
                    </li>
                    <li><a href="add_item.php">Product</a>
                    </li>
                    <li><a href="add_user.php">User</a>
                    </li>                    
                  </ul>
                </li>
                <li><a><i class="fa fa-eye"></i> View <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                  	<?php 
                  	  //getting the type of user
                  	  if($_SESSION['type']=='administrator'){ 
                  	?>                    
                    <li><a href="view_business.php">Business</a>
                    </li>
                    <?php
					  }
                    ?>
                    <li><a href="view_menu.php">Product type</a>
                    </li>
                    <li><a href="view_item.php">Product</a>
                    </li>
                    <li><a href="view_user.php">User</a>
                    </li>                    
                  </ul>
                </li>
                <li><a><i class="fa fa-cog"></i> Settings <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    <li><a href="user_profile.php">Profile</a>
                    </li>
                    <li><a href="security.php">Security</a>
                    </li>                                       
                  </ul>
                </li>
              </ul>
            </div>
          </div>