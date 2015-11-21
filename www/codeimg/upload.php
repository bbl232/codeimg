<?php
require("includes/common-functions.php");
$ldap = ensure_auth('upload.php');
require('includes/header.php');

if(isset($_GET['id']) && $_GET['id'] != ""){
  $snippet = json_decode(file_get_contents("https://vandenberk.me/codeimg/api/snippet/from-id?id=".$_GET['id']."&for_edit=true"),true);
  if($snippet['status'] == "success"){
    $snippet = $snippet['snippet'];

    if($snippet['owner'] != $_SESSION['username']){
      echo "<br><br><br><br><div class='container'><div class='alert alert-danger'>Refusing to proceed because you do not own this snippet</div></div>";
      require("includes/footer.php");
      die();
    }
  }
  else{
    echo "<br><br><br><br><div class='container'><div class='alert alert-danger'>Could not get snippet ".$snippet['message']."</div></div>";
    require("includes/footer.php");
    die();
  }
}
?>
<link href="/codeimg/includes/css/autocomplete-jquery-bootstrap.css" rel="stylesheet">
<link href="/codeimg/includes/css/jquery-ui.min.css" rel="stylesheet">

<style>
  .ui-autocomplete {
    max-height: 100px;
    overflow-y: auto;
    overflow-x: hidden;
  }
  * html .ui-autocomplete {
    height: 100px;
  }
</style>
<br><br>
<div class='container' id='main'>
  <div class='title'><h1>Code Imgifier</h1><br></div>
  <div class='contentpane'><div id='instructions'><p>Paste code in the text area below and click the 'Imgify!' button to add code to the repository.</p></div>
  <div class='main_form'>
      <?php
        if($snippet){
          echo "<input id='id' type='text' value='".$snippet['id']."' hidden disabled>";
        }
      ?>
      <div class='input-group' id='namegroup'>
        <span class='input-group-addon'>Name:</span>
        <input type='text' class='form-control' id="name" placeholder="Name..." <?php if($snippet){ echo 'value="'.$snippet['name'].'"'; } ?>>
      </div>
      <div id="codegroupdiv">
        <div class="input-group" id='codegroup'>
          <span class="input-group-addon">Code:</span>
          <textarea id='code' placeholder='Paste code here...' rows='20' class='form-control custom-control'><?php if($snippet){ echo $snippet['code']; } ?></textarea>
        </div>
      </div>
      <div class='input-group' id='tagsgroup'>
        <span class="input-group-addon">Tags:&nbsp;</span>
        <input type="text" class='form-control' id="tags" size="50" placeholder="Tags" value="<?php echo implode(", ", $snippet['tags']) ?>">
      </div>
      <div class="input-group" id='notesgroup'>
        <span class="input-group-addon">Notes:</span>
        <textarea id='notes' class="form-control" placeholder='Notes about this code...'><?php echo $snippet['notes']?></textarea>
      </div>
      <button onclick="imgify()" id='imgify' name='imgify' class='btn btn-primary' type='button'>
        <?php
          if($snippet){
            echo "Update";
          }
          else {
            echo "Imgify!";
          }
        ?>
      </button>
  </div>
  <div id='message'>
  </div>
</div>
</div>

<?php
require('includes/footer.php');
?>
<script src="/codeimg/includes/javascript/jquery-ui.min.js"></script>
<script src="/codeimg/includes/javascript/jquery.ui.autocomplete.html.js"></script>
<script src="/codeimg/includes/javascript/tag-autocomplete.js"></script>
<script src="/codeimg/includes/javascript/custom-imgify.js"></script>
</body>
</html>
