<?php

include 'connection.php';

include 'template/header.php';
include 'template/navbar.php';

if($_SESSION["loggedIn"] = !true){
    echo 'not logged in';
    header("Location: login.php");
    exit;
  }


?>
 



<?php

include 'template/footer.php';


?>