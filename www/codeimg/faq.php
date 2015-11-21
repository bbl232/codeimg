<?php
require("includes/common-functions.php");
maybe_logout();
require("includes/header.php");
?>
<br><br>
<div class="container" id="main"i data-spy="scroll" data-target="#faq-nav">
  <h1>FAQ</h1>
  <h3>Frequently Asked Questions</h3>
  <br>
  <ul id="faq">
    <li><h4>What is the purpose of this site?</h4><p>The purpose of this site is to enable novice programmers to find useful algorithms that other programmers have made available to the public while preventing plagiarism. The site aims to make it easy to credit users who uploaded code snippets if you plan on using them.</p></li>
    <li><h4>How do I share code?</h4><p>To share code, <a href="/login.php">log in</a> with your SoCS credentials and visit the share code page <a href="upload.php">here</a>. Once there, paste or type your code into the code box, tag the code with related categories and click the Imgify button.</p></li>
    <li><h4>How do I find code?</h4><p>To share code, <a href="/login.php">log in</a> with your uoguelph single sign on credentials and visit the find code page <a href="index.php">here</a>. Once there, you can toggle tags on and off to filter results.</p></li>
    <li><h4>Can I edit my existing code snippets?</h4><p>To edit snippets, <a href="/login.php">log in</a> with your SoCS credentials and click your username in the navbar. Once there choose which snippet you'd like to edit and click the 'Update' button. This will take you to a page with the snippet information filled in, change the snippet as you please and click 'Update'.</p></li>
  </ul>
  <h3>I got an error while trying to upload code. Help!</h3>
  <ul id="errors">
    <li><div class="alert alert-danger"><h4>Could not save snippet</h4></div><h5>What happened to my code?</h5><p>Your code snipped could not be saved.</p><h5>What does it mean?</h5><p>We attempted to save your code, but something went wrong while updating the database entry.</p><h5>What should I do now?</h5><p>Please wait a few minutes and try your upload again. If the problem persists, please contact the owner of this site.</p></li>
    <li><div class="alert alert-danger"><h4>Could not save tags</h4></div><h5>What happened to my code?</h5><p>Your code was saved but then discarded when we could not associate the tags with it.</p><h5>What does it mean?</h5><p>We managed to store your code, but something prevented the system from saving your tags. We then removed your code snippet.</p><h5>What should I do now?</h5><p>Please wait a few minutes and try your upload again. If this problem persists, please contact the owner of this site.</p></li>
    <li><div class="alert alert-danger"><h4>Supplied tag(s) too long</h4></div><h5>What happened to my code?</h5><p>Your code was not saved.</p><h5>What does it mean?</h5><p>One or more of the tags you supplied was over 25 characters. There is a limit of 25 characters on tags.</p><h5>What should I do now?</h5><p>Try your upload again, changing tags to be under 25 characters in length.</p></li>
    <li><div class="alert alert-danger"><h4>Code snippet too long</h4></div><h5>What happened to my code?</h5><p>Your code was not saved.</p><h5>What does it mean?</h5><p>The code you tried to upload generated an image that was too large. This site uses base64 encoded PNG images. Base64 encoded images have a restriction on length and your image went over that size.</p><h5>What should I do now?</h5><p>Try your upload again with a shorter section of code. This site is meant to be used as a sharing service for code snippets, not entire programs.</p></li>
  </ul>
<?php
require("includes/footer.php");
?>
