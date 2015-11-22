<?php
require("includes/common-functions.php");
$ldap = ensure_auth("user-snippets.php");
require("includes/header.php");
?>

<br><br><br><br>
<div class="container">
<h1>Your Snippets</h1>

<?php
if(isset($_SESSION['username']) && $_SESSION['username'] != ""){
  $snippet = json_decode(file_get_contents(FQDN."/api/snippet/from-owner?owner=".$_SESSION['username']),true);
  if($snippet['status'] == "success"){
    $snippet = $snippet['snippets'];
    
    foreach($snippet as $s){
      echo "<div class='panel panel-default'>
              <div class='panel-heading'>
              ".$s['name']."
              </div>
              <div class='panel-body'>
                <div class='row'>
                  <div class='col-xs-6'>
                    <img class='code-image img-thumbnail' src='".$s['image_data']."'>
                  </div>
                  <div class='col-xs-6'>
                    <span class='tagsspan'>Tags:".implode(", ", $s['tags'])."</span><br>
                    <div class='viewdiv'>
                      <a type='button' class='btn btn-primary' href='upload.php?id=".$s['id']."'>Update</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>";
    }
  }
  else{
    echo "<div class='container'><div class='alert alert-danger'>Could not get snippets ".$snippet['message']."</div></div>";
    require("includes/footer.php");
    die();
  }
}
else{
  echo "<div class='container'><div class='alert alert-danger'>No owner supplied</div></div>";
  require("includes/footer.php");
  die();
}
?>
</div>

<?php
require("includes/footer.php");
?>
<script src='/includes/javascript/custom-user-snippets.js' type='text/javascript'></script>
