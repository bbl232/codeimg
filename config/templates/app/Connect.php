<?php

  $db = new mysqli("<%= db_address %>", "<%= username %>", "<%= password %>", "<%= database %>", 3306);
  if ($db->connect_errno) {
      echo json_encode(array("error"=>"Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error));
  }
?>
