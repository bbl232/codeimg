<?php
require("../../../../Connect.php");
require("../../includes/common-functions.php");

function get_tags(&$r){
  global $db;
  foreach($r as &$v){
    $query="
      SELECT tag FROM snippets_to_tags
      WHERE snippet=".$v['id']."
    ";
    $result = $db->query($query);

    $result_array = $result->fetch_all($resulttype=MYSQLI_NUM);

    foreach($result_array as &$t){
      $t = $t[0];
    }
    $v['tags'] = $result_array;
  }
}

function get_snippets($owner){
  global $db;
  $query="
    SELECT id,image_data,owner,name,notes FROM snippets 
    WHERE owner='".mysqli_real_escape_string($db,$owner)."'
  ";
  $result = $db->query($query);

  $result_array = $result->fetch_all($resulttype=MYSQLI_ASSOC);
  
  if(empty($result_array)){
    return false;
  }

  get_tags($result_array);

  return $result_array;
}

function main(){
  if($_SERVER['REMOTE_ADDR'] != "127.0.0.1" && $_SERVER['REMOTE_ADDR'] != $_SERVER['SERVER_ADDR']){
    echo json_encode(array("status" => "error", "message" => "This is a private API endpoint... Your ip: ".$_SERVER['REMOTE_ADDR']));
    die();
  }
  if(isset($_REQUEST['owner']) && $_REQUEST['owner'] != ""){
    $owner = $_REQUEST['owner'];
  }
  else{
    echo json_encode(array("status" => "error", "message" => "No owner supplied!"));
    die();
  }
  
  $snippets = get_snippets($owner);

  if($snippets !== false){
    echo json_encode(array("status" => "success", "snippets" => $snippets));
  }
  else{
    echo json_encode(array("status" => "error", "message" => "No snippet found with that id"));
  }
}
main();

?>
