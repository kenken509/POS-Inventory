<?php
include_once('./includes/functions.php');


session_start();
session_destroy();

Redirect_to('index.php');


?>