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