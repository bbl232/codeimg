<?php
require("includes/common-functions.php");
$ldap = ensure_auth('find.php');
require("includes/header.php");
?>
<link href="/includes/css/autocomplete-jquery-bootstrap.css" rel="stylesheet">
<link href="/includes/css/jquery-ui.min.css" rel="stylesheet">
<style>
  .ui-autocomplete {
    max-height: 100px;
    overflow-y: auto;
    /* prevent horizontal scrollbar */
    overflow-x: hidden;
  }
  /* IE 6 doesn't support max-height
   * we use height instead, but this forces the menu to always be this tall
   */
  * html .ui-autocomplete {
    height: 100px;
  }
</style>
<br><br>
<div class='title'>
  <h1>Code Imgifier</h1>
  <br>
</div>
<div class='container'>
  <div id='instructions'>
    <p>Search for Code Snippets</p>
    <h4>Toggle Popular Tags to Filter Snippet Results.</h4>
  </div>
  <div class='tags-div' id='tags-div'></div>
  <br>
  <br>
  <h4>Fill in less popular tags that are not shown above.</h4>
  <div class='input-group'>
    <span class="input-group-addon">Tags:&nbsp;</span>
    <input type="text" class='form-control' id="tags" size="50"><br>
  </div>
  <button class='btn btn-default' type="button" onclick="update_results()">Search</button>
  <div class='message' id='message'></div>
  <div class='results-div' id='results-div'></div>
</div>
<?php
require("includes/footer.php");
?>
<script src="/includes/javascript/jquery-ui.min.js"></script>
<script src="/includes/javascript/jquery.ui.autocomplete.html.js"></script>
<script src="/includes/javascript/tag-autocomplete.js"></script>
<script src="/includes/javascript/custom-imgify.js"></script>
<script src='/includes/javascript/custom-search.js' type='text/javascript'></script>
</body>
</html>
