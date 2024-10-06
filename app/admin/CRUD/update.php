<!DOCTYPE html>
<html lang="pt-br">

<head>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="/assets/images/White_Butterfly.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <link href="./output.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../../../public/assets/images/White_Butterfly.png">
    <title>Chrysalis - Editar Produto</title>
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

        #tamanho:hover {
            background-color: #FE980A;
        }

        #btn_carrinho {
            background-color: rgb(232, 128, 13)
        }

        #btn_carrinho:hover {
            background-color: #f97316;
        }

        #btn_avaliar {
            background-color: #E8800D;
        }

        #btn_avaliar:hover {
            background-color: #f97316;
        }
    </style>
</head>

<body>
    <?php
    include("../headerAdmin.php");
    ?>
    <main>
        <div class="container m-auto sm:px-12">
            <h1 class="text-2xl font-semibold my-8">Editar Produtos</h1>

            <?php
            require('../../../backend/conexao.php');

            if (isset($_GET['idProduto'])) {
                $idProduto = $_GET['idProduto'];
                $sqlSelect = "SELECT idProduto, valorProduto, descricao, grupo, subGrupo, genero FROM Produto WHERE idProduto = ?";
                $stmt = $conexao->prepare($sqlSelect);

                if ($stmt) {
                    $stmt->bind_param("i", $idProduto);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows == 1) {
                        $row = $result->fetch_assoc();
                        ?>
                        <form action="update.php?idProduto=<?php echo $idProduto; ?>" method="post">
                            <div class="mb-4">
                                <div class="mb-4">
                                    <label for="preco">Preço</label>
                                    <input type="text" name="preco" id="preco"
                                        class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded"
                                        value="<?php echo htmlspecialchars($row['valorProduto']); ?>" required>
                                </div>
                                <div class="mb-6">
                                    <label for="nome">Nome</label>
                                    <input type="text" name="nome" id="nome"
                                        class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded"
                                        value="<?php echo htmlspecialchars($row['descricao']); ?>" required>
                                </div>
                                <div class="mb-6">
                                    <label for="grupo">Grupo</label>
                                    <input type="text" name="grupo" id="grupo"
                                        class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded"
                                        value="<?php echo htmlspecialchars($row['grupo']); ?>" required>
                                </div>
                                <div class="mb-6">
                                    <label for="subgrupo">Subgrupo</label>
                                    <input type="subgrupo" name="subgrupo" id="subgrupo"
                                        class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded"
                                        value="<?php echo htmlspecialchars($row['subGrupo']); ?>" required>
                                </div>
                                <div class="mb-6">
                                    <label for="genero">Gênero</label>
                                    <input type="text" name="genero" id="genero"
                                        class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded"
                                        value="<?php echo htmlspecialchars($row['genero']); ?>" required>
                                </div>
                            <button
                                class="transition px-8 py-2 text-md font-medium text-white bg-blue-500 hover:bg-blue-600 rounded-lg text-center">Atualizar</button>
                        </form>
                    </div>
                    <?php
                    } else {
                        echo "Registro não encontrado.";
                    }

                    $stmt->close();
                } else {
                    die("Erro na preparação da query: " . $conexao->error);
                }
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['idProduto'])) {
                $id = $_GET['idProduto'];
                $precoNovo = $_POST['preco'];
                $nomeNovo = $_POST['nome'];
                $grupoNovo = $_POST['grupo'];
                $subgrupoNovo = $_POST['subgrupo'];
                $generoNovo = $_POST['genero'];
                $sqlUpdate = "UPDATE Produto SET valorProduto = ?, descricao = ?, grupo = ?, subgrupo = ?, genero = ? WHERE idProduto = ?";

                $stmt = $conexao->prepare($sqlUpdate);

                if ($stmt) {
                    $stmt->bind_param("sssssi", $precoNovo, $nomeNovo, $grupoNovo, $subgrupoNovo, $generoNovo, $id);

                    if ($stmt->execute()) {
                        echo "<script>alert('Dados alterados com sucesso!');</script>";
                        header("Location: read.php");
                        exit;
                    } else {
                        die("ERRO NO UPDATE: " . $stmt->error);
                    }

                } else {
                    die("Erro na preparação da query: " . $conexao->error);
                }
            }
            ?>
        <?php
        include('../../pages/footer.php');
        ?>
    </main>
</body>
</html>