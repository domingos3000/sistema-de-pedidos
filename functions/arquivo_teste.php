<?php

include_once __DIR__ . "./../components/connect.php";


$stmt = $conn->prepare("
    SELECT * FROM pedidos,
    SELECT * FROM usuario
");
$stmt->execute();

echo "<pre>";
    print_r($stmt->fetchAll());
echo "</pre>";