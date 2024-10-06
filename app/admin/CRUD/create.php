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
    <title>Chrysalis - Adicionar Produto</title>
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
        <div id="alerts" class="text-white mx-auto text-center py-3 font-semibold"
            style="background-color: rgb(51, 44, 36);">
            <span class="mx-4 font-normal">PÁGINA PARA ADMINISTRADORES</span>
        </div>
        <div class="container mx-auto sm:px-12">
            <div class="mx-24">
                <h1 class="text-3xl font-semibold my-8">Adicione um Produto</h1>
                <form action="create.php" method="post">
                    <div class="mb-4">
                        <div class="mb-4">
                            <label for="preco">Preço</label>
                            <input type="text" name="preco" id="preco"
                                class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded"
                                required>
                        </div>
                        <div class="mb-6">
                            <label for="nome">Nome</label>
                            <input type="text" name="nome" id="nome"
                                class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded"
                                required>
                        </div>
                        <div class="mb-6">
                            <label for="grupo">Grupo</label>
                            <input type="text" name="grupo" id="grupo"
                                class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded"
                                required>
                        </div>
                        <div class="mb-6">
                            <label for="subgrupo">Subgrupo</label>
                            <input type="text" name="subgrupo" id="subgrupo"
                                class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded"
                                required>
                        </div>
                        <div class="mb-6">
                            <label for="genero">Gênero</label>
                            <input type="text" name="genero" id="genero"
                                class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded"
                                required>
                        </div>
                    </div>
                    <button class="transition ease-in-out duration-300 px-8 py-2 mb-6 text-md font-medium text-white bg-yellow-700 hover:bg-yellow-900 rounded-lg text-center">Cadastrar</button>
                </form>
            </div>
        </div>
    </main>
    <?php
    require("../../../backend/conexao.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $preco = isset($_POST['preco']) ? $_POST['preco'] : "CAMPO VAZIO!";
        $nome = isset($_POST['nome']) ? $_POST['nome'] : "CAMPO VAZIO!";
        $grupo = isset($_POST['grupo']) ? $_POST['grupo'] : "CAMPO VAZIO!";
        $subgrupo = isset($_POST['subgrupo']) ? $_POST['subgrupo'] : "CAMPO VAZIO!";
        $genero = isset($_POST['genero']) ? $_POST['genero'] : "CAMPO VAZIO!";

        $sqlInsert = "INSERT INTO Produto (valorProduto, descricao, grupo, subGrupo, genero) VALUES (?, ?, ?, ?, ?)";

        $stmt = $conexao->prepare($sqlInsert);

        if ($stmt) {
            $stmt->bind_param("sssss", $preco, $nome, $grupo, $subgrupo, $genero);
            if ($stmt->execute()) {
                echo "<script>alert('Dados inseridos!');</script>";
            } else {
                die("Erro ao executar a query: " . $stmt->error);
            }
            $stmt->close();
        } else {
            die("Erro ao preparar a query: " . $conexao->error);
        }

        $conexao->close();
    }
    ?>

    <?php include("../../pages/footer.php"); ?>

</body>