<?php
require("includes/common-functions.php");
maybe_logout();
require("includes/header.php");
?>
<br><br>
<div class="container" id="mainabout">
  <h1>About Codeimg</h1>
  <h3>General</h3>
  <p>This system has been written as a CIS4910 project with Judi McCuiag by Bill Vandenberk with the help of Rozita Dara.</p>
  <p>The general idea of the project is to make it easier for students to use proven algorithms without plagiarising code examples. Users will upload code snippets to the service, categorizing them using a tag system, and the service will store the raw code in a database along with the selected tags. Other users of the service will be able to search the database using the tags provided by the user who uploaded the code. The system will display code snippets related to the user’s search as an image to prevent copy and paste from the system to a finished program. The system will also display how to properly credit the owner of the code in their program.</p>
  <h3>Purpose</h3>
  <p>The purpose of the service is to allow users to reference code snippets to gain an understanding of an algorithm, prevent them from copying code directly in to their programs, and encourage them to credit the owner of the code when they use the algorithm.</p>
</div>

<?php
require("includes/footer.php");
?>
