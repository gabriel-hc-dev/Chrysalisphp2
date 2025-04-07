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

<body class="bg-gray-100">
    <?php
    session_start();
    include("headerCRUD.php");

    if (!isset($_SESSION['usuario_email']) || !isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
        // Se o usuário não estiver logado ou não for o administrador, redireciona para a página inicial
        echo "<script>
                window.location.replace('../../src/pages/index.php');
              </script>";
        exit();
    }
    ?>

    <div class="p-8">
        <h1 class="text-3xl font-semibold mb-8">Produtos Cadastrados</h1>

        <div class="relative overflow-x-auto shadow-md w-full">
            <?php
            require('../../src/backend/conexao.php');
            $sqlSelect = "SELECT idProduto, valorProduto, descricao, grupo, subGrupo, genero, imagem FROM Produto;";
            $result = $conexao->query($sqlSelect);

            if ($result) {
                echo <<<HTML
                    <table class='w-full min-w-full text-sm text-left text-gray-600'>
                        <thead class='bg-gray-100 text-gray-700'>
                            <tr>
                                <th class='px-6 py-4 border-b' scope='col'>CÓDIGO</th>
                                <th class='px-6 py-4 border-b' scope='col'>PREÇO</th>
                                <th class='px-6 py-4 border-b' scope='col'>DESCRIÇÃO</th>
                                <th class='px-6 py-4 border-b' scope='col'>GRUPO</th>
                                <th class='px-6 py-4 border-b' scope='col'>SUBGRUPO</th>
                                <th class='px-6 py-4 border-b' scope='col'>GÊNERO</th>
                                <th class='px-6 py-4 border-b' scope='col'>IMAGEM</th>
                                <th class='px-6 py-4 border-b' scope='col'>AÇÕES</th>
                            </tr>
                        </thead>
                        <tbody>
                    HTML;

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Lógica para converter o valor do gênero
                        switch (trim($row['genero'])) {
                            case "M":
                                $genero = "Masculino(a)";
                                break;
                            case "F":
                                $genero = "Feminino(a)";
                                break;
                            default:
                                $genero = "Unissex";
                                break;
                        }

                        echo <<<HTML
                        <tr class='bg-white border-b hover:bg-gray-50'>
                            <th scope='row' class='px-6 py-4 font-medium text-gray-900'>{$row['idProduto']}</th>
                    HTML;

                        // Saída do valor formatado fora do heredoc
                        echo "<td class='px-6 py-4 cursor-default transition-all'>R$ " . number_format($row['valorProduto'], 2, ',', '.') . "</td>";
                        echo <<<HTML
                            <td class='px-6 py-4 cursor-default transition-all'>{$row['descricao']}</td>
                            <td class='px-6 py-4 cursor-default transition-all'>{$row['grupo']}</td>
                            <td class='px-6 py-4 cursor-default transition-all'>{$row['subGrupo']}</td>
                            <td class='px-6 py-4 cursor-default transition-all'>{$genero}</td>
                            <td class='px-6 py-4 cursor-default transition-all'>
                    HTML;
                        // Saída da imagem em PHP
                        echo '<img src="data:image/jpeg;base64,' . base64_encode($row['imagem']) . '" alt="Imagem do produto" class="w-32 h-32 object-cover rounded-md">';
                        echo <<<HTML
                            </td>
                            <td class='px-6 py-14 flex flex-nowrap justify-center space-x-4'>
                                <a href='update.php?idProduto={$row['idProduto']}' class='transition-all bg-blue-500 text-white ease-in-out py-2 px-4 rounded hover:shadow-md hover:bg-blue-600 duration-300'>Editar</a>
                                <a href='delete.php?idProduto={$row['idProduto']}' class='transition-all bg-red-500 text-white ease-in-out py-2 px-4 rounded hover:shadow-md hover:bg-red-700 duration-300'>Deletar</a>
                            </td>
                        </tr>
                    HTML;
                    }
                } else {
                    echo "<tr>
                            <td colspan='8' class='px-6 py-4 text-center text-gray-500'>Nenhum registro encontrado.</td>
                        </tr>";
                }
                echo "</tbody></table>";
            } else {
                die("Não foi possível executar $sqlSelect. " . $conexao->error);
            }
            ?>
        </div>
    </div>

    <?php include('../../src/pages/footer.php'); ?>
</body>

</html>