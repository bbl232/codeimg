<?php
require("includes/common-functions.php");
maybe_login();
get_session();
maybe_logout();
require("includes/header.php");
?>
<div class="container">
  <h2><br>Welcome to the Codeimg system.</h2>
  <h5>Check out our help section for more info about this project.</h5>
  <br>
  <p>To get started, click on the nav links above to find or upload code.</p><br>
  <div class="row">
    <div class="col-xs-6">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3>Finding Code</h3>
        </div>
        <div class="panel-body">
          <ol id="findcodesteps">
            <li><h4>Click 'Find Code' in the navbar</h4></li>
            <li><h4>Log in</h4><img class="stepimg" src="screenshots/login.png"><br><p>Log in to the site using your SoCS username and password.</p><br><br></li>
            <li><h4>Toggle popular tags</h4><img class="stepimg" src="screenshots/toggles.png"><br><p>At the top of the find code page there are several large buttons. You can toggle these buttons to filter by the most used tags.</p><br><br></li>
            <li><h4>Filter less popular tags</h4><img class="stepimg" src="screenshots/dropdown.png"><br><p>You can filter using less popular tags by adding them to the dropdown text field on the page.</p><br><br></li>
            <li><h4>Click search</h4><img class="stepimg" src="screenshots/searchbutton.png"><br><p>The page does its best to update whenever you make a change to your tags, but sometimes this functionality is not perfect. Clicking search is a sure fire way to update the search.</p><br><br></li>
            <li><h4>Select code snippet</h4><img class="stepimg" src="screenshots/completedsearch.png"><br><p>Select which code snippet you'd like to inspect further and click on the image of the code to enlarge it. The next page will give you suggestions on how to cite the code.</p><br><br></li>
            <li><h4>Cite snippet</h4><img class="stepimg" src="screenshots/cite.png"><br><p>When you use and ideas from the code snippet, be sure to follow the citation suggestions to give proper credit to the author of that code.</p><br><br></li>
          </ol>
        </div>
      </div>
    </div>
    <div class="col-xs-6">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3>Sharing Code</h3>
        </div>
        <div class="panel-body">
          <ol id="sharecodesteps">
            <li><h4>Click 'Upload Code' in the navbar</h4></li>
            <li><h4>Give your code snippet a title.</h4><img class="stepimg" src="screenshots/name.png"><br><p>Enter your title in the title box.</p><br><br></li>
            <li><h4>Type or paste your code.</h4><img class="stepimg" src="screenshots/code.png"><br><p>Enter your code in the text area.</p><br><br></li>
            <li><h4>Tag your image.</h4><img class="stepimg" src="screenshots/uploadready.png"><br><p>Select or create new tags for your code.</p><br><br></li>
            <li><h4>Click 'Imgify!'</h4><img class="stepimg" src="screenshots/imgify.png"><br><p>The code will be uploaded and availible immediately on the find code page.</p><br><br></li>
          </ol>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
require("includes/footer.php");
?>
