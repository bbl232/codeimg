<?php

  $db = new mysqli("127.0.0.1", "codeimg", "serpentineRaspberries47", "codeimg", 3306);
  if ($db->connect_errno) {
      echo json_encode(array("error"=>"Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error));
  }
?>
