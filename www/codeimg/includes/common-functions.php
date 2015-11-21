<?php
  include_once("../../config/config.php");

  function clean_tags(&$array){
    #Thanks http://stackoverflow.com/users/58088/tyler-carter
    #From http://stackoverflow.com/questions/2216052/how-to-tell-if-a-php-array-is-empty
    global $db;
    foreach($array as $key => &$value){
      if(strlen(trim($value)) > 25){
        $array = False;
        return;
      }
      if(empty($value)){
        unset($array[$key]);
      }
      else{
        $value = mysqli_real_escape_string($db,trim($value));
      }
    }
  }

  function get_session(){
    if(!isset($_SESSION)){
      session_start();
    }
  }
  
  function maybe_logout(){
    get_session();
    if(isset($_GET['logout'])){
        unset($_SESSION['lastaction'], $_SESSION['username'], $_SESSION['password']);
        header("Location: pleaseLogin.php?next_page=".$next_page);
        exit;
    }
  }

  //Thank you to http://stackoverflow.com/questions/10549279/sessions-and-ldap
  //Answer by DaveRandom
  //http://stackoverflow.com/users/889949/daverandom
  function ensure_auth($next_page='index.php') {
    $timeout = 3600;
    $server = LDAP_SERVER;
    $port = LDAP_PORT;

    get_session();

    if(!empty($_SESSION['lastaction']) && ($_SESSION['lastaction'] > (time() - $timeout)) && !isset($_GET['logout'])){
      //session is still good!
      $ldap = ldap_connect($server, $port);
      ldap_start_tls($ldap);
      if(ldap_bind($ldap, "uid=".$_SESSION['username'].",ou=People,dc=socs,dc=uoguelph,dc=ca", $_SESSION['password'])){
        //if session username and password are valid
        $_SESSION['lastaction'] = time();
        return $ldap;
      }
      else{
        //otherwise end the session
        unset($_SESSION['lastaction'], $_SESSION['username'], $_SESSION['password']);
        header("Location: pleaseLogin.php?next_page=".$next_page);
        exit;
      }
    }
    else if(isset($_POST['username'], $_POST['password'])){
      //this is a new login
      $ldap = ldap_connect($server, $port);
      ldap_start_tls($ldap);
      if(ldap_bind($ldap, "uid=".$_POST['username'].",ou=People,dc=socs,dc=uoguelph,dc=ca", $_POST['password'])){
        //if password username and password are valid
        $_SESSION['lastaction'] = time();
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['password'] = $_POST['password'];
        return $ldap;
      }
      else{
        //invalid login info
        header("Location: pleaseLogin.php?next_page=".$next_page);
        exit;
      }
    }
    else{
      //session has or is being expired
      unset($_SESSION['lastaction'], $_SESSION['username'], $_SESSION['password']);
      header("Location: pleaseLogin.php?next_page=".$next_page);
      exit;
    }
  }

  function maybe_login($next_page){
    if(isset($_POST['username'])){
      ensure_auth($next_page);
    }
  }
?>
