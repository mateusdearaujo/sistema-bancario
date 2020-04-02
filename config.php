<?php
try {
    $pdo = new PDO("mysql:dbname=projetos;host=localhost", "root", "");
} catch(PDOException $e) {
    echo "ERRO: ".$e->getMessage();
}
?>