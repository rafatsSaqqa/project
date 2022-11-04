<?php
include 'connection.php';

include 'template/header.php';
include 'template/navbar.php';


if($_SESSION["rank"] === "user") {
    header("Location: index.php");
    exit;
} 
?>

<?php

include 'template/footer.php';

?>