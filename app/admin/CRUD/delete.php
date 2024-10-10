<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../src/styles/butterfly.css">
    <link rel="icon" type="image/x-icon" href="../../public/assets/images/White_Butterfly.png">
    <title>Chrysalis - Sua Loja Preferida</title>
    
</head>
<body>
    <?php
    include("../headerAdmin.php");
    require('../../../backend/conexao.php');

    if ($_SERVER["REQUEST_METHOD"] == 'GET' && isset($_GET['idProduto'])) {
        $idProduto = $_GET['idProduto'];
        $sqlDelete = "DELETE FROM Produto WHERE idProduto = ?";

        $stmt = $conexao->prepare($sqlDelete);

        if ($stmt) {
            $stmt->bind_param("i", $idProduto);
            if ($stmt->execute()) {
                echo "<script>alert('Registro Deletado.');</script>";
                exit;
            } else {
                die("ERRO: Não foi possível deletar: " . $stmt->error);
            }
        } else {
            die("ERRO: Não foi possível preparar a query: " . $conexao->error);
        }
    }

    header("Location: read.php");
    include('../styles/footer.php');
    ?>
</body>
</html>