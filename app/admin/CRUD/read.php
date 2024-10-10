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
        <div class="container mx-auto p-12 px-36">
            <h1 class="text-3xl font-semibold mb-8">Produtos Cadastrados</h1>

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <?php
                require('../../src/backend/conexao.php');
                $sqlSelect = "SELECT idProduto, valorProduto, descricao, grupo, subGrupo, genero FROM Produto;";

                $result = $conexao->query($sqlSelect);

                if ($result) {
                    echo "<table class='min-w-full text-sm text-left text-gray-600'>
                    <thead class='bg-gray-100 text-gray-700'>
                        <tr>
                            <th class='px-6 py-4 border-b' scope='col'>CÓDIGO</th>
                            <th class='px-6 py-4 border-b' scope='col'>PREÇO</th>
                            <th class='px-6 py-4 border-b' scope='col'>DESCRIÇÃO</th>
                            <th class='px-6 py-4 border-b' scope='col'>GRUPO</th>
                            <th class='px-6 py-4 border-b' scope='col'>SUBGRUPO</th>
                            <th class='px-6 py-4 border-b' scope='col'>GÊNERO</th>
                            <th class='px-6 py-4 border-b' scope='col'>AÇÕES</th>
                        </tr>
                    </thead>
                    <tbody>";

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr class='bg-white border-b hover:bg-gray-50'>
                                <th scope='row' class='px-6 py-4 font-medium text-gray-900'>" . $row["idProduto"] . "</th>
                                <td class='px-6 py-4'>" . $row["valorProduto"] . "</td>
                                <td class='px-6 py-4'>" . $row["descricao"] . "</td>
                                <td class='px-6 py-4'>" . $row["grupo"] . "</td>
                                <td class='px-6 py-4'>" . $row["subGrupo"] . "</td>
                                <td class='px-6 py-4'>" . $row["genero"] . "</td>
                                <td class='px-6 py-4'>
                                    <a href='update.php?idProduto=" . $row["idProduto"] . "' class='transition bg-blue-500 text-white ease-in-out py-2 px-4 rounded hover hover:shadow-md hover:bg-blue-600 duration-300'>Editar</a>
                                    <a href='delete.php?idProduto=" . $row["idProduto"] . "' class='transition bg-yellow-500 text-white ease-in-out py-2 px-4 rounded hover hover:shadow-md hover:bg-yellow-700 duration-300 ml-4'>Deletar</a>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr>
                            <td colspan='7' class='px-6 py-4 text-center text-gray-500'>Nenhum registro encontrado.</td>
                        </tr>";
                    }
                    echo "</tbody></table>";
                } else {
                    die("Não foi possível executar $sqlSelect. " . $conexao->error);
                }
                ?>
            </div>
        </div>
        <?php include('../../src/pages/footer.php'); 
        ?>
        </main>
</body>