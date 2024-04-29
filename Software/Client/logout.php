<?php

session_start();
session_destroy();

header('Location: landingpages.php');

?>