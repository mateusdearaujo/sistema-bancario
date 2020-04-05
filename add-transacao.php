<?php
session_start();
require('config.php');

if(isset($_SESSION['banco']) && !empty($_SESSION['banco'])) {

}   else {
    header("Location: login.php");
}

if(isset($_POST['tipo'])) {
    $tipo = $_POST['tipo'];
    $valor = str_replace(",",".", $_POST['valor']);
    $valor = floatval($valor);

    $sql = $pdo->prepare("INSERT INTO historico (id_conta, tipo, valor, data_operacao) VALUES (:id_conta, :tipo, :valor, NOW())");
    $sql->bindValue(":id_conta", $_SESSION['banco']);
    $sql->bindValue(":tipo", $tipo);
    $sql->bindValue(":valor", $valor);
    $sql->execute();
    header("Location: index.php");

    if($tipo == '0') {
        $sql = $pdo->prepare("UPDATE contas SET saldo = saldo + :valor WHERE id = :id");
        $sql->bindValue(":valor", $valor);
        $sql->bindValue(":id", $_SESSION['banco']);
        $sql->execute();
    } else {
        $sql = $pdo->prepare("UPDATE contas SET saldo = saldo - :valor WHERE id = :id");
        $sql->bindValue(":valor", $valor);
        $sql->bindValue(":id", $_SESSION['banco']);
        $sql->execute();
    }

}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Caixa Eletrônico</title>
        <meta description="Sistema de caixa eletrônico">
        <link rel="stylesheet" type="text/css" href="assets/css/styles.css">
        <link rel="shortcut icon" href="assets/images/fav.svg">
        <meta charset="utf-8">
    </head>
    <body>
        <div class="container">
            <img id="logo" src="assets/images/white.png" width="80" height="80">
            <div>
                <h1>Realizar Transação</h1>
            </div>
            <div>
                <form method="POST">            
                    Tipo de Transação:
                    <select name="tipo">
                        <option value="0">Depósito</option>
                        <option value="1">Retirada</option>
                    </select></br>
                    Valor:</br>
                    <input type="text" name="valor" pattern="[0-9.,]{1,}"/>
                    <input type="submit" class="btn" value="Adicionar"/> 
                </form>
            </div>
        </div>
    </body>
</html>
