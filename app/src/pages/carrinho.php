<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="../../public/assets/images/White_Butterfly.png" />
    <title>Chrysalis - Carrinho</title>
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

<?php
session_start();
include('../backend/conexao.php');
include('header.php');

// Inicializa o carrinho na sessão se ainda não existir
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

// Adiciona um produto ao carrinho
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['adicionar_carrinho'])) {
    $idProduto = $_POST['idProduto'];
    if (!isset($_SESSION['carrinho'][$idProduto])) {
        $_SESSION['carrinho'][$idProduto] = 1;
    } else {
        $_SESSION['carrinho'][$idProduto]++;
    }
    header('Location: carrinho.php'); // Redireciona para atualizar a página
    exit();
}

// Remove um produto do carrinho
if (isset($_GET['remove'])) {
    $idProduto = $_GET['remove'];
    if (isset($_SESSION['carrinho'][$idProduto])) {
        $_SESSION['carrinho'][$idProduto]--;
        if ($_SESSION['carrinho'][$idProduto] <= 0) {
            unset($_SESSION['carrinho'][$idProduto]);
        }
    }
}

// Adiciona um produto ao carrinho (incrementa a quantidade)
if (isset($_GET['add'])) {
    $idProduto = $_GET['add'];
    if (isset($_SESSION['carrinho'][$idProduto])) {
        $_SESSION['carrinho'][$idProduto]++;
    }
    echo ('<script>window.location.replace("carrinho.php");</script>');
    exit();
}


// Buscar produtos do banco de dados
$produtos = [];
$query = "SELECT idProduto, grupo, subGrupo, descricao, genero, valorProduto, imagem FROM Produto";
$result = $conexao->query($query);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $produtos[$row['idProduto']] = [
            'grupo' => $row['grupo'] ?? '',
            'subgrupo' => $row['subGrupo'] ?? '',
            'descricao' => $row['descricao'] ?? '',
            'genero' => $row['genero'] ?? '',
            'preco' => $row['valorProduto'] ?? 0,
            'imagem' => $row['imagem'] ?? null
        ];
    }
}
?>

<body class="bg-gray-50">
    <div class="container mx-auto p-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Seção do Carrinho de Produtos -->
            <div class="md:col-span-2 bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-2xl font-semibold mb-4">Meu carrinho</h2>
                <div class="space-y-4">
                    <?php if (!empty($_SESSION['carrinho'])): ?>
                        <?php foreach ($_SESSION['carrinho'] as $idProduto => $quantidade): ?>
                            <?php if (isset($produtos[$idProduto])): ?>
                                <div class="flex items-center justify-between border-b pb-4">
                                    <div class="flex items-center">
                                        <img src="data:image/jpeg;base64,<?= base64_encode($produtos[$idProduto]['imagem']) ?>"
                                            alt="Produto" class="w-16 h-16 rounded-md">
                                        <div class="ml-4">
                                            <p class="text-lg font-semibold">
                                                <?= htmlspecialchars(trim($produtos[$idProduto]['grupo'] . ' ' . $produtos[$idProduto]['subgrupo'] . ' ' . $produtos[$idProduto]['descricao'] . ' ' . $produtos[$idProduto]['genero'])) ?>
                                            </p>
                                            <p class="text-gray-500">R$
                                                <?= number_format($produtos[$idProduto]['preco'], 2, ',', '.') ?></p>
                                        </div>
                                    </div>

                                    <div class="flex items-center">
                                        <a href="carrinho.php?remove=<?= $idProduto ?>"
                                            class="px-2 py-1 bg-orange-500 text-white rounded-lg">-</a>
                                        <span class="mx-2 text-lg"></span>
                                        <a href="carrinho.php?add=<?= $idProduto ?>"
                                            class="px-2 py-1 bg-orange-500 text-white rounded-lg">+</a>
                                    </div>
                                </div>
                            <?php else: ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Seu carrinho está vazio.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Resumo do Pedido -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-4">Resumo do Carrinho</h2>
                <?php
                $total = 0;
                if (!empty($_SESSION['carrinho'])) {
                    foreach ($_SESSION['carrinho'] as $idProduto => $quantidade) {
                        if (isset($produtos[$idProduto])) {
                            $total += $produtos[$idProduto]['preco'] * $quantidade;
                        }
                    }
                }
                ?>
                <div class="flex justify-between mb-2">
                    <span>Itens (<?= array_sum($_SESSION['carrinho']) ?>)</span>
                    <span>R$ <?= number_format($total, 2, ',', '.') ?></span>
                </div>
                <hr class="my-2">
                <div class="flex justify-between font-bold text-lg">
                    <span>Valor Total</span>
                    <span>R$ <?= number_format($total, 2, ',', '.') ?></span>
                </div>
                <button
                    class="mt-4 w-full bg-orange-500 text-white py-2 rounded-lg hover:bg-orange-600 duration-300 hover:scale-105">
                    Finalizar Compra
                </button>
            </div>

        </div>
    </div>
</body>
<?php include('footer.php'); ?>

</html>