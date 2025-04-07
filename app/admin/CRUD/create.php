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
    <style>
        body::-webkit-scrollbar {
            width: 10px;
            /* width of the entire scrollbar */
        }

        body::-webkit-scrollbar-track {
            background-color: rgb(249 250 251);
            /* color of the tracking area */
        }

        body::-webkit-scrollbar-thumb {
            background-color: rgba(203, 213, 225, 0.8);
            /* color of the scroll thumb */
            border-radius: 20px;
            /* roundness of the scroll thumb */
            border: 3px solid rgb(249 250 251);
            /* creates padding around scroll thumb */
        }
    </style>
</head>

<body>
    <?php
    session_start();
    include("headerCRUD.php");
    
    // Verificação se o usuário é administrador
    if (!isset($_SESSION['usuario_email']) || !isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
        // Se o usuário não estiver logado ou não for o administrador, redireciona para a página inicial
        echo "<script>
                window.location.replace('../../src/pages/index.php');
              </script>";
        exit();
    }
    ?>
    <main>
        <div id="alerts" class="text-white mx-auto text-center py-3 font-semibold"
            style="background-color: rgb(51, 44, 36);">
            <span class="mx-4 font-normal">PÁGINA PARA ADMINISTRADORES</span>
        </div>
        <div class="container mx-auto sm:px-12">
            <div class="mx-24">
                <h1 class="text-3xl font-semibold my-8">Adicione um Produto</h1>
                <form action="create.php" method="post" enctype="multipart/form-data">
                    <div class="mb-4">
                        <div class="mb-4">
                            <label for="preco">Preço</label>
                            <input type="text" name="preco" id="preco" placeholder="Ex: 197.90"
                                class="border transition-all focus:scale-105 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 hover:bg-white"
                                required>
                        </div>
                        <div class="mb-6">
                            <label for="nome">Cor, detalhes</label>
                            <input type="text" name="nome" id="nome" placeholder="Ex: Azul, reta..."
                                class="border transition-all focus:scale-105 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 hover:bg-white"
                                required>
                        </div>
                        <div class="mb-6">
                            <label for="grupo">Grupo</label>
                            <input type="text" name="grupo" id="grupo" placeholder="Ex: Calça, camiseta..."
                                class="border transition-all focus:scale-105 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 hover:bg-white"
                                required>
                        </div>
                        <div class="mb-6">
                            <label for="subgrupo">Subgrupo</label>
                            <input type="text" name="subgrupo" id="subgrupo" placeholder="Ex: Jeans, moletom..."
                                class="border transition-all focus:scale-105 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 hover:bg-white"
                                >
                        </div>
                        <div class="mb-6">
                            <label for="genero">Gênero</label>
                            <select id="genero" name="genero"
                                class="border transition-all focus:scale-105 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 hover:bg-white"
                                required>
                                <option value="U">Unissex</option>
                                <option value="M">Masculino</option>
                                <option value="F">Feminino</option>
                            </select>
                        </div>
                        <!-- Imagem -->
                        <div class="mb-6">
                            <!-- Input de imagem escondido -->
                            <input type="file" name="imagem" id="imagem" accept="image/*" class="hidden"
                                onchange="mostrarNomeArquivo()">

                            <!-- Label estilizada que funciona como botão -->
                            <label for="imagem"
                                class="cursor-pointer border border-gray-300 bg-transparent text-gray-800 hover:text-white hover:bg-orange-500 py-2 px-8 rounded-lg transition-all">
                                Adicionar Imagem
                            </label>

                            <!-- Espaço para mostrar o nome do arquivo -->
                            <span id="file-name" class="ml-4 text-gray-700">Nenhum arquivo selecionado</span>
                        </div>

                        <script>
                            function mostrarNomeArquivo() {
                                const input = document.getElementById('imagem');
                                const fileName = document.getElementById('file-name');

                                // Se um arquivo foi selecionado, exibe o nome dele. Caso contrário, exibe o texto padrão.
                                fileName.textContent = input.files.length > 0 ? input.files[0].name : 'Nenhum arquivo selecionado';
                            }
                        </script>

                    </div>
                    <button
                        class="transition ease-in-out duration-300 px-8 py-2 mb-6 text-md font-medium text-white hover:text-white bg-orange-400 hover:bg-orange-500 rounded-lg text-center hover:scale-105">Cadastrar
                        produto</button>
                </form>
            </div>
        </div>
    </main>
    <?php
    require("../../src/backend/conexao.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $preco = isset($_POST['preco']) ? $_POST['preco'] : "CAMPO VAZIO!";
        $nome = isset($_POST['nome']) ? $_POST['nome'] : "CAMPO VAZIO!";
        $grupo = isset($_POST['grupo']) ? $_POST['grupo'] : "CAMPO VAZIO!";
        $subgrupo = isset($_POST['subgrupo']) ? $_POST['subgrupo'] : "CAMPO VAZIO!";
        $genero = isset($_POST['genero']) ? $_POST['genero'] : "CAMPO VAZIO!";

        // Verificando se o arquivo de imagem foi enviado
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
            $imagemTemp = $_FILES['imagem']['tmp_name']; // Caminho temporário do arquivo no servidor
            $imagemBinaria = file_get_contents($imagemTemp); // Conteúdo binário da imagem
        } else {
            $imagemBinaria = null;
        }

        $sqlInsert = "INSERT INTO Produto (valorProduto, descricao, grupo, subGrupo, genero, imagem) VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $conexao->prepare($sqlInsert);

        if ($stmt) {
            $null = null; // Placeholder para a imagem binária
    
            // Ajustando o bind_param com os tipos corretos, incluindo "b" para binário
            $stmt->bind_param("sssssb", $preco, $nome, $grupo, $subgrupo, $genero, $null);

            // Enviando os dados binários da imagem
            if ($imagemBinaria !== null) {
                $stmt->send_long_data(5, $imagemBinaria); // O índice "5" refere-se ao sexto parâmetro (imagem)
            }

            if ($stmt->execute()) {
                echo "<script>alert('Produto cadastrado com sucesso!');
                        window.location.replace('read.php');
                      </script>";
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

    <?php include("../../src/pages/footer.php"); ?>

</body>