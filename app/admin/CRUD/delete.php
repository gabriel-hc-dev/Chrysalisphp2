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
    <div class="container mx-auto flex items-center justify-center"><a href="read.php" class="px-4 py-2 bg-orange-500 text-white font-bold transtion-all hover:scale-125 hover:bg-orange-700 focus:ring-2 focus:ring-orange-500">Voltar</a></div>
    <?php
    include("../headerAdmin.php");
    require('../../src/backend/conexao.php');
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