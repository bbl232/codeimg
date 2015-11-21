<?php
require("../../../../Connect.php");
require("../../includes/common-functions.php");

function get_tags(&$r){
  global $db;
  $query="
    SELECT tag FROM snippets_to_tags
    WHERE snippet=".$r['id']."
  ";
  $result = $db->query($query);

  $result_array = $result->fetch_all($resulttype=MYSQLI_NUM);

  foreach($result_array as &$v){
    $v = $v[0];
  }

  $r['tags'] = $result_array;
}

function get_snippet($id, $for_edit){
  global $db;
  if($for_edit){
    $query="
      SELECT id,image_data,owner,name,notes,code FROM snippets 
      WHERE id=".$id.";
    ";
  }
  else{
    $query="
      SELECT id,image_data,owner,name,notes FROM snippets 
      WHERE id=".$id.";
    ";
  }
  $result = $db->query($query);

  $result_array = $result->fetch_all($resulttype=MYSQLI_ASSOC);
  
  if(empty($result_array)){
    return false;
  }

  $result_array = $result_array[0];
  get_tags($result_array);

  return $result_array;
}

function main(){
  if($_SERVER['REMOTE_ADDR'] != "127.0.0.1" && $_SERVER['REMOTE_ADDR'] != "192.241.183.27"){
    echo json_encode(array("status" => "error", "message" => "This is a private API endpoint... Your ip: ".$_SERVER['REMOTE_ADDR']));
    die();
  }
  $id = (int) $_REQUEST['id'];
  
  if(0 == $id){
    echo json_encode(array("status" => "error", "message" => "No id supplied!"));
    die();
  }
  
  $snippet = get_snippet($id,isset($_GET['for_edit']));

  if($snippet !== false){
    echo json_encode(array("status" => "success", "snippet" => $snippet));
  }
  else{
    echo json_encode(array("status" => "error", "message" => "No snippet found with that id"));
  }
}
main();

?>
