<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Turns code in to images">
    <meta name="author" content="Bill Vandenberk">

    <title>Code Imgifier</title>

    <!-- Bootstrap core CSS -->
    <link href="/includes/css/bootstrap.css" rel="stylesheet">
    <link href="/includes/css/custom-imgify.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="../../assets/js/html5shiv.js"></script>
      <script src="../../assets/js/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <a class="navbar-brand" href="index.php">Codeimg</a>
        <ul class="nav navbar-nav navbar-left">
          <li><a href="find.php">Find Code</a></li>
          <li><a href="upload.php">Upload Code</a></li>
        </ul>
        <?php
          if(isset($_SESSION['username'])){
            echo '<a class="btn btn-default navbar-btn navbar-right" href="'.basename($_SERVER['SCRIPT_NAME']).'?logout=true">Logout</a><p class="navbar-text navbar-right">Signed in as <a href="user-snippets.php">'.$_SESSION['username'].'</a>&nbsp;</p>';
          }
          else if(strpos($_SERVER['REQUEST_URI'],'pleaseLogin.php') === false){
            echo '<a class="btn btn-default navbar-btn navbar-right" href="pleaseLogin.php">Log In</a>';
          }
        ?>
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown"><a data-toggle="dropdown" href="#" class="dropdown-toggle" role="button" aria-haspopup="true" aria-expanded="false">Help <span class="caret"></span></a>
            <ul class="dropdown-menu">
            <li><a href="faq.php">FAQ</a></li>
            <li><a href="about.php">About</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
