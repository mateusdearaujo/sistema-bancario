<?php
session_start();
require('config.php');
if(isset($_POST['agencia']) && !empty($_POST['agencia'])) {
    $agencia = addslashes($_POST['agencia']);
}

if(isset($_POST['conta']) && !empty($_POST['conta'])) {
    $conta = addslashes($_POST['conta']);
}

if(isset($_POST['senha']) && !empty($_POST['senha'])) {
    $senha = addslashes($_POST['senha']);

    $sql = $pdo->prepare("SELECT * FROM contas WHERE agencia = :agencia AND conta = :conta AND senha = :senha");

    $sql->bindValue(":agencia", $agencia);
    $sql->bindValue(":conta", $conta);
    $sql->bindValue(":senha", md5($senha));
    $sql->execute();

    if($sql->rowCount() > 0) {
        $sql = $sql->fetch();

        $_SESSION['banco'] = $sql['id'];

        header("Location: index.php");
            }
}
    

?>
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
                <h1>Faça seu login</h1>
            </div>
            <div>
                <form method="POST">            
                    <input type="text" name="agencia" placeholder="Agência:" class="form-control">              
                    <input type="text" name="conta" placeholder="Conta:" class="form-control">
                    <input type="password" name="senha" placeholder="Senha:" class="form-control">
                    <button type="submit" class="btn">Entrar</button>
                </form>
            </div>
        </div>
    </body>
</html>
