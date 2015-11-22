<?php
require("includes/common-functions.php");
$ldap = ensure_auth("show-snippet.php");
require("includes/header.php");
if(!isset($_GET['id']) || $_GET['id'] == ""){
  echo "<br><br><div class='container'><div class='alert alert-danger'>Can not get snippet details without an ID. I give up.</div></div>";
  require("includes/footer.php");
  die();
}
else{
  $snippet = json_decode(file_get_contents(FQDN."/api/snippet/from-id?id=".$_GET['id']),true);
  if($snippet['status'] == "success"){
    $snippet = $snippet['snippet'];
  }
  else{
    echo "<br><br><div class='container'><div class='alert alert-danger'>Could not get snippet ".$snippet['message']."</div></div>";
    require("includes/footer.php");
    die();
  }
}
?>
<br><br>
<div class="container">
  <h2>Code Snippet Details</h2>
  <h4 id="code-title"><?php echo $snippet['name']?></h4>
  <div class="container" id="code-image-div">
    <h3>Code</h3><hr><img class="codeimg" src="<?php echo $snippet['image_data']?>"></img><hr>
    <?php
      if($snippet['notes'] != ""){
        echo "<h3>Notes</h3><div class='notesdiv'>";
        echo $snippet['notes'];
        echo "</div>";
      }
    ?>
    <h3>Tagged With</h3><span class="tags"><?php foreach($snippet['tags'] as $t){echo "$t<br>";}?></span><br>
    <h3>Citing This Code</h3><span class="citation-information">To cite this code, include the owner and where you retrieved the code from inline with your code and in a readme or bibliography. e.g. shown below</span><br><br><span class="citation-example">/*<br>algorithm inspired by <?php echo $snippet['owner']?><br>as retrieved from https://vandenberk.me/codeimg/show-snippet.php?id=<?php echo $snippet['id']?><br>*/</span>
  </div>
</div>
<?php
require("includes/footer.php");
?>
</body>
</html>
