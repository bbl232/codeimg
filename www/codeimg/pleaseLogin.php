<?php
require("includes/header.php");
?>
  <br><br>
  <div class="container" id="main">
    <div class="contentpane">
      <h2>Please Log In</h2>
      <h3>Log in using your SoCS login information.</h3>
      <h4>If you need to reset your password or attain an account, email <a href="mailto:help@socs.uoguelph.ca">help@socs.uoguelph.ca</a>.</h4>
      <form action="<?php if(isset($_GET['next_page']) && $_GET['next_page'] != ''){echo $_GET['next_page'];}else{echo 'index.php';} ?>" method="post">
        <div class="input-group"><span class="input-group-addon">Username</span><input type="text" name="username" id="username" class="form-control"></div>
        <div class="input-group"><span class="input-group-addon">Password</span><input type="password" name="password" id="password" class="form-control"></div>
        <input type="submit" class="btn btn-default" value="Log In">
      </form>
    </div>
  </div>
<?php
require("includes/footer.php");
?>
