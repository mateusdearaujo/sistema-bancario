<?php
session_start();
require('config.php');
if(isset($_SESSION['banco']) && !empty($_SESSION['banco'])) {
    $id = $_SESSION['banco'];

    $sql = $pdo->prepare("SELECT * FROM contas WHERE id = :id");
    $sql->bindValue(":id", $id);
    $sql->execute();

    if($sql->rowCount() > 0) {
        $info = $sql->fetch();
    } else {
        header("Location: login.php");
    }

} else {
    header("Location: login.php");
    exit;
}
?>
<html>
    <head>
        <title>Caixa Eletrônico</title>
        <meta description="Sistema de caixa eletrônico">
        <link rel="stylesheet" type="text/css" href="assets/css/styles.css">
        <link rel="shortcut icon" href="assets/images/fav.svg" >
    </head>
    </head>
    <body>
        <div class="container">
            <img id="logo" src="assets/images/white.svg">
            <h1>Informações da Conta</h1>
            <p><b>Titular:</b> <?php echo $info['titular'] ?></p>
            <p><b>Agência:</b> <?php echo $info['agencia'] ?></p>
            <p><b>Conta:</b> <?php echo $info['conta'] ?></p>
            <p><b>Saldo:</b> <?php echo 'R$ ' . number_format($info['saldo'], 2, ',', '.');?></p>
            <hr>
            <a href="sair.php">Sair</a>
        </div>
    </body>
</html>