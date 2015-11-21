<?php
require("../../../../Connect.php");
require("../../includes/common-functions.php");

function get_tags_from_snippet($id){
  global $db;
  $query="
    SELECT tag FROM snippets_to_tags
    WHERE snippet=".$id."
  ";
  $result = $db->query($query);

  $result_array = $result->fetch_all();
  return $result_array;
}

function get_snippets($tags, $offset=0){
  global $db;
  $query="
    SELECT t.tag,t.snippet,s.image_data,s.owner,s.name,COUNT(t.snippet) as n FROM snippets_to_tags t
    RIGHT JOIN snippets s ON s.id=t.snippet
    WHERE t.tag IN ('".implode("','", $tags)."')  GROUP BY t.snippet HAVING n=".count($tags)."
    LIMIT ".$offset.",10;
  ";
  $result = $db->query($query);

  $result_array = $result->fetch_all($resulttype=MYSQLI_ASSOC);

  foreach($result_array as &$s){
    $s['tags'] = get_tags_from_snippet($s['snippet']);
  }

  return $result_array;
}

function main(){
  $offset = (int) $_POST['offset'];
  $tags = explode(',', rtrim($_POST['tags'], ", "));
  clean_tags($tags);
  if(!empty($tags)){
    $snippets = get_snippets($tags,$offset);
    echo json_encode(array("status" => "success", "snippets" => $snippets));
  }
  else{
    echo json_encode(array("status" => "error", "message" => "You did not supply any tags!"));
  }
}
main();

?>
