<?php

include __DIR__ . './connect.php';

@session_start();
session_unset();
session_destroy();

header('location:../');

?>