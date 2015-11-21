<?php
  require("../../../Connect.php");
  
  function get_tags($like, $limit){
    global $db;
    if(""!=$like){
      $res = $db->query("SELECT tag FROM snippets_to_tags WHERE tag LIKE '%".mysqli_real_escape_string($db,$like)."%' GROUP BY tag ORDER BY count(*) DESC LIMIT $limit;");
    }
    else{
      $res = $db->query("SELECT tag FROM snippets_to_tags GROUP BY tag ORDER BY count(*) DESC LIMIT $limit;");
    }

    $tags = $res->fetch_all($resulttype=MYSQLI_NUM);

    foreach($tags as &$t){
      $t = $t[0];
    }

    return $tags;
  }

  function send_response($tags){ 
    echo json_encode(array("success" => "true", "tags" => $tags));
  }

  function main(){
    if(isset($_POST['like'])){
      $like=$_POST['like'];
    }

    if(isset($_POST['limit'])){
      $limit=(int)$_POST['limit'];
    }
    else{
      $limit=50;
    }

    $tags=get_tags($like, (int)$limit);
    send_response($tags);
  }
  main();
?>
