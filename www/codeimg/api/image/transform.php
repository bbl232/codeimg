<?php
require("../../../../Connect.php");
require("../../includes/common-functions.php");

function get_id(){
  global $db;
  $db->query("INSERT INTO snippets(code) VALUES('INPROGRESS');");
  return $db->insert_id;
}

function create_watermark_image($id, $wm_size, $font, $font_size, $text, $background){
  $date = date('Y-m-d');
  $watermark = imagecreatetruecolor($wm_size['x'],$wm_size['y']);
  imagefilledrectangle($watermark, 0, 0, $wm_size['x'], $wm_size['y'], $text);
  imagefilledrectangle($watermark, 1, 1, $wm_size['x']-2, $wm_size['y']-2, $background);
  imagettftext($watermark, $font_size, 0, 2, $font_size+4, $text, $font, $_SESSION['username']);
  imagettftext($watermark, $font_size, 0, 2, $font_size*2+6, $text, $font, $id);
  imagettftext($watermark, $font_size, 0, 2, $font_size*3+8, $text, $font, $date);

  return $watermark;
}

function create_image_from_code($font, $font_size, $text, $background, $code, $final_size, $size){
  $img = imagecreatetruecolor($final_size['x'], $final_size['y']);
  imagefilledrectangle($img, 0, 0, $final_size['x'], $final_size['y'], $background);
  imagettftext($img, $font_size, 0, -1*$size[6], -1*$size[7], $text, $font, $code);

  return $img;
}

function watermark_image(&$img, $watermark, $final_size, $wm_size){
  imagecopymerge($img, $watermark, $final_size['x'] - $wm_size['x'] - 10, $final_size['y'] - $wm_size['y'] - 10, 0, 0,$wm_size['x'], $wm_size['y'], 50);
}

function get_image_data($img){
  ob_start();
  imagetruecolortopalette($img,true,4);
  imagepng($img);
  $contents =  ob_get_contents();
  ob_end_clean();
  
  $b64encoded='data:image/png;base64,'.base64_encode($contents);
  
  return $b64encoded;
}

function store_image($id, $base64_data, $code, $name, $notes){
  global $db;
  $query="
      UPDATE snippets
      SET code='".mysqli_real_escape_string($db,$code)."',
      image_data='".mysqli_real_escape_string($db,$base64_data)."',
      hash='".md5($code)."',
      name='".mysqli_real_escape_string($db,$name)."',
      owner='".mysqli_real_escape_string($db,$_SESSION['username'])."',
      notes='".mysqli_real_escape_string($db,$notes)."'
      WHERE id=$id
  ";
  return $db->query($query);
}

function store_tags($id,$tags){
  global $db;
  $db->query("DELETE FROM snippets_to_tags WHERE snippet=".$id);
  $values="VALUES";
  foreach($tags as $tag){
    if($tag[0] != '#'){
      $tag = "#".$tag;
    }
    $tag = mysqli_real_escape_string($db,$tag);
    $values .= "(".$id.",'".$tag."'),";
  }
  $query = "INSERT INTO snippets_to_tags(snippet,tag) ".$values;
  $query=rtrim($query,",");

  return $db->query($query);
}

function clean_up(&$img, &$watermark){
  imagedestroy($img);
  imagedestroy($watermark);
}

function remove_snippet($id){
  global $db;
  return $db->query("DELETE FROM snippets WHERE id=".$id);
}

function main(){
  $ldap = ensure_auth('upload.php');
  $font = getcwd().'/courier.ttf';
  $font_size = 12;

  #Colours
  $background = 0xFFFFFF;
  $text = 0x000000;
  $textRGB = array('red' => 0, 'green' => 0, 'blue' => 0);
  $backRGB = array('red' => 255, 'green' => 255, 'blue' => 255);

  #Get input and ensure it is sane
  $code = $_POST['code'];
  if($code == ""){
    echo json_encode(array("status" => "error", "message" => "no code was supplied"));
  }

  $name = $_POST['name'];
  if($name == ""){
    echo json_encode(array("status" => "error", "message" => "no name was supplied"));
  }

  $tags = explode(',', rtrim($_POST['tags'], ", "));
  clean_tags($tags);
  if ($tags === False){
    echo json_encode(array("status" => "error", "message" => "supplied tag(s) too long"));
    die();
  }
  
  $notes = "";
  if(isset($_POST['notes'])){
    $notes = $_POST['notes'];
  }

  $update = false;
  if(isset($_POST['id']) && $_POST['id'] != ''){
    $id = (int)$_POST['id'];
    
    #check for ownership of code snippet
    global $db;
    $query = "
      SELECT owner FROM snippets
      WHERE id=".$id."
    ";
    $result = $db->query($query);
    $result_array = $result->fetch_array(MYSQLI_NUM);
    if($result_array[0] != $_SESSION['username']){
      echo json_encode(array("status" => "error", "message" => "you do not own the code snippet you are attempting to update"));
      die();
    }
  }
  else {
    $id = get_id();
  }

  #Calculate Sizes
  $wm_size = array('x' => 135, 'y' => (($font_size+5)*3));
  $size = imagettfbbox($font_size, 0, $font, $code);
  $final_size = array('x' => $size[2] + $wm_size['x'] + 20, 'y' => $size[3] + $wm_size['y'] + $font_size + 20);

  #Create image
  $watermark = create_watermark_image($id, $wm_size, $font, $font_size, $text, $background);
  $img = create_image_from_code($font, $font_size, $text, $background, $code, $final_size, $size);
  watermark_image($img, $watermark, $final_size, $wm_size);
  $base64_data = get_image_data($img);


  if(strlen($base64_data) >= 120000){
        echo json_encode(array("status" => "error", "message" => "code snippet is too long"));
  }
  else{
    #Store snippet and tags
    $store_result = store_image($id,$base64_data,$code,$name,$notes);

    $tags_result=true;
    if(count($tags)!=0 && $store_result){
      $tags_result = store_tags($id,$tags);
    }

    if($store_result){
      if($tags_result){
        echo json_encode(array("status" => "success", "image_data" => $base64_data,"strlen"=>strlen($base64_data)));
      }
      else{
        remove_snippet($id);
        echo json_encode(array("status" => "error", "message" => "could not save tags"));
      }
    }
    else{
      remove_snippet($id);
      echo json_encode(array("status" => "error", "message" => "could not save snippet"));
    }
  }

  clean_up($img, $watermark);
}
main();

?>
