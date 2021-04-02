<?php
// check if user is logged in
if($_SESSION['user_id'] && $_GET['logout']==1){
  // destroy session
  session_destroy();

  // destroy session
  setcookie("rememberme", "", time()-3600);
}
?>