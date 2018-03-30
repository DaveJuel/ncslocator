<?php $title = 'NCSLocator |login' ?>

 <?php ob_start() ?>
  <div class="login-page">
  <div class="form">
    <form class="register-form" action="">
      <input type="text" placeholder="name"/>
      <input type="password" placeholder="password"/>
      <input type="text" placeholder="email address"/>
      <button>create</button>
      <p class="message">Already registered? <a href="#">Sign In</a></p>
    </form>
    <form class="login-form" action="" onsubmit="return false">
      <input type="text" id="log_username" placeholder="username"/>
      <input type="password" id="log_password" placeholder="password"/>
      <input class="btn btn-info" type="submit" onclick="logIn();" value="login"/>
      <div id="log_status"></div>
      <p class="message">Not registered? <a href="#">Create an account</a></p>
    </form>    
  </div>
</div>
 <?php $content = ob_get_clean() ?>
 <?php include '../layout/layout_login.php' ?>