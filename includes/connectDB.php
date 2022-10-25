<?php
$server = 'localhost';
$username = 'root';
$password = '12345';

try{
    $pdo = new PDO('mysql:host='.$server.';dbname=posinv_db',$username,$password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "connection successful";
    }catch(PDOException $e){ echo "Connection failed: " . $e->getMessage();}
?>