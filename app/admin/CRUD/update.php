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
        <div class="container m-auto sm:px-12">
            <h1 class="text-2xl font-semibold my-8">Editar Produtos</h1>

            <?php
            require('../../src/backend/conexao.php');

            if (isset($_GET['idProduto'])) {
                $idProduto = $_GET['idProduto'];
                $sqlSelect = "SELECT idProduto, valorProduto, descricao, grupo, subGrupo, genero, imagem FROM Produto WHERE idProduto = ?";
                $stmt = $conexao->prepare($sqlSelect);

                if ($stmt) {
                    $stmt->bind_param("i", $idProduto);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows == 1) {
                        $row = $result->fetch_assoc();
            ?>
                        <form action="update.php?idProduto=<?php echo $idProduto; ?>" method="post" enctype="multipart/form-data">
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
                                    <input type="text" name="subgrupo" id="subgrupo"
                                        class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded"
                                        value="<?php echo htmlspecialchars($row['subGrupo']); ?>" required>
                                </div>
                                <div class="mb-6">
                                    <label for="genero">Gênero</label>
                                    <input type="text" name="genero" id="genero"
                                        class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded"
                                        value="<?php echo htmlspecialchars($row['genero']); ?>" required>
                                </div>
                                <!-- Imagem -->
                                <div class="mb-6">
                                    <label for="imagem">Alterar Imagem</label>
                                    <!-- Campo para upload de nova imagem -->
                                    <input type="file" name="imagem" id="imagem"
                                        class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded"
                                        accept="image/*"> <!-- permite selecionar apenas arquivos de imagem -->
                                    <label for="imagem">Imagem Atual</label><!-- Exibe a imagem atual -->
                                    <div class="mb-4">
                                        <img src="data:image/jpeg;base64,<?php echo base64_encode($row['imagem']); ?>" alt="Imagem do produto" class="w-32 h-32 object-cover">
                                    </div>
                                </div>
                                <button type="submit"
                                    class="transition px-8 py-2 text-md font-medium text-white bg-orange-500 hover:bg-orange-600 rounded-lg text-center">Atualizar</button>
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

            // Processo de update
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['idProduto'])) {
                $id = $_GET['idProduto'];
                $precoNovo = $_POST['preco'];
                $nomeNovo = $_POST['nome'];
                $grupoNovo = $_POST['grupo'];
                $subgrupoNovo = $_POST['subgrupo'];
                $generoNovo = $_POST['genero'];

                // Se uma nova imagem for enviada, processa o upload
                if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
                    $imagemNovo = file_get_contents($_FILES['imagem']['tmp_name']); // Lê o conteúdo do arquivo
                    $sqlUpdate = "UPDATE Produto SET valorProduto = ?, descricao = ?, grupo = ?, subGrupo = ?, genero = ?, imagem = ? WHERE idProduto = ?";
                    $stmt = $conexao->prepare($sqlUpdate);
                    $stmt->bind_param("ssssssi", $precoNovo, $nomeNovo, $grupoNovo, $subgrupoNovo, $generoNovo, $imagemNovo, $id);
                } else {
                    // Se não houver upload de imagem, atualiza sem modificar a imagem
                    $sqlUpdate = "UPDATE Produto SET valorProduto = ?, descricao = ?, grupo = ?, subGrupo = ?, genero = ? WHERE idProduto = ?";
                    $stmt = $conexao->prepare($sqlUpdate);
                    $stmt->bind_param("sssssi", $precoNovo, $nomeNovo, $grupoNovo, $subgrupoNovo, $generoNovo, $id);
                }

                if ($stmt->execute()) {
                    echo "<script>alert('Dados alterados com sucesso!');
                    window.location.replace('read.php');
                    </script>";
                } else {
                    die("ERRO NO UPDATE: " . $stmt->error);
                }
                $stmt->close();
            }
?>
    </main>
    <?php
    include('../../src/pages/footer.php');
    ?>
</body>

</html>
