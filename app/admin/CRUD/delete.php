<!DOCTYPE html>
<html lang="pt-br">

<head>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="/assets/images/White_Butterfly.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <link href="./output.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../../public/assets/images/White_Butterfly.png">
    <title>Chrysalis - Sua loja preferida</title>
    <style>
        @keyframes butterfly-flying {
            0% {
                transform: scaleX(1);
            }

            50% {
                transform: scaleX(0.6);
            }

            100% {
                transform: scaleX(1);
            }
        }

        #butterfly_img {
            transition: all 2s ease;
        }

        #butterfly_img:hover {
            animation-name: butterfly-flying;
            animation-duration: 0.8s;
            animation-iteration-count: infinite;
        }
    </style>
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