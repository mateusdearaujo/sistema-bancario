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
        <link rel="shortcut icon" href="assets/images/nubank-logo.png" >
        <meta charset="utf-8">
</head>
<body>
    <div class="container">
        <img id="logo" src="assets/images/white.png" width="80" height="80">
        <h1>Informações da Conta</h1>
        <p><b>Titular:</b> <?php echo $info['titular'] ?></p>
        <p><b>Agência:</b> <?php echo $info['agencia'] ?></p>
        <p><b>Conta:</b> <?php echo $info['conta'] ?></p>
        <p><b>Saldo:</b> <?php echo 'R$ ' . number_format($info['saldo'], 2, ',', '.');?></p>
        <a href="sair.php">Sair</a>
        <hr>
        <h2>Extrato</h2>
        <a href="add-transacao.php">Adicionar Transação</a></br></br>
        <table>
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody class='historic-table'>
                <?php
                    $sql = $pdo->prepare("SELECT * FROM historico WHERE id_conta = :id_conta");
                    $sql->bindValue(':id_conta', $id);
                    $sql->execute();

                    if($sql->rowCount() > 0) {
                        foreach($sql->fetchAll() as $item) {
                            echo "<tr>";
                            echo "<td>";
                            echo date('d/m/Y H:i', strtotime($item['data_operacao']))."</td>";
                            
                            if($item['tipo'] == 0) {
                                echo "<td><span style='color: green;'> R$ ".number_format($item['valor'], 2, ',', '.')."</span></td>";
                            } else {
                                echo "<td><span style='color: red;'> - R$ ".number_format($item['valor'], 2, ',', '.')."</span></td>";
                            }

                            echo "</tr>";
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>