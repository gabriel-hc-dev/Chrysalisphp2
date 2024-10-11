<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="../../public/assets/images/White_Butterfly.png">
    <title>Chrysalis - Produto</title>
</head>

<body class="bg-white text-gray-900">
<?php
include("header.php");
include("../backend/conexao.php"); // Inclua sua conexão ao banco de dados

// Verifica se o ID do produto foi passado na URL
if (isset($_GET['id'])) {
    $idProduto = $_GET['id'];

    // Prepara a consulta para buscar os dados do produto pelo ID
    $sql = "SELECT idProduto, valorProduto, descricao, grupo, subGrupo, genero, imagem FROM Produto WHERE idProduto = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $idProduto);
    $stmt->execute();
    $stmt->bind_result($idProduto, $valorProduto, $descricao, $grupo, $subgrupo, $genero, $imagem);
    $stmt->fetch();
    $stmt->close();

    // Prepara a consulta para buscar o número de avaliações
    $sql = "SELECT count(idFeedback) FROM Feedback WHERE idProduto = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $idProduto);
    $stmt->execute();
    $stmt->bind_result($numeroAvaliacoes);
    $stmt->fetch();
    $stmt->close();
} else {
    echo "<p>Produto não encontrado.</p>";
    exit;
}
?>


    <section class="flex items-center justify-center min-h-screen">
        <div class="container mx-auto p-6">
            <div class="flex flex-col items-center justify-center md:flex-row md:justify-center md:space-x-12 gap-8 mb-8">

                <!-- Imagem do produto -->
                <?php
                if ($imagem) {
                    echo '<img class="w-5/6 m-4 rounded-lg object-contain" src="data:image/png;base64,' . base64_encode($imagem) . '" alt="' . $grupo . ' ' . $subgrupo . ' ' . $descricao . '" style="height:500px; width: 500px;">';
                } else {
                    echo '<img class="w-5/6 m-4 rounded-lg object-contain" src="https://via.placeholder.com/500" alt="Imagem não disponível" style="height:500px; width: 500px;">';
                }
                ?>

                <!-- Detalhes do produto -->
                <div class="md:w-1/2 mt-6 md:mt-0">
                    <h1 class="text-3xl font-bold text-start md:text-left"><?php echo $grupo . ' ' . $subgrupo . ' ' . $descricao; ?></h1>
                    <span class="text-zinc-400 text-lg mt-4 text-start md:text-left flex items-center justify-start"><svg class="w-4 h-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 22 20">
                            <path
                                d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                        </svg>&nbsp; $numeroAvaliacoes Avaliações</span>
                    <p class="text-4xl font-bold mt-4 text-start md:text-left">R$ <?php echo number_format($valorProduto, 2, ',', '.'); ?></p>

                    <p class="mt-6 text-start md:text-left"><?php echo $grupo . ' ' . $subgrupo . ' ' . $descricao; ?></p>

                    <!-- Tamanhos Disponíveis, Opções de Entrega, Botão de Adicionar ao Carrinho podem permanecer fixos ou ser dinâmicos, conforme necessário -->

                    <div class="mt-6">
                        <button class="w-full py-4 bg-orange-500 text-white font-bold rounded-lg hover:bg-orange-500 transition-all duration-300">Adicionar ao Carrinho</button>
                    </div>
                </div>
            </div>

            <!-- Seção de comentários, avaliações, etc. -->
            <!-- Adicionar Avaliação -->
            <div class="mt-12 mb-8">
                <h2 class="text-2xl font-bold text-center">Adicionar Avaliação</h2>
                <div class="flex flex-col items-center space-y-4 mt-4">
                    <!-- Avaliação por Estrelas -->
                    <div class="flex space-x-1">
                        <button class="text-gray-400 hover:text-orange-500"><i class="fas fa-star"></i></button>
                        <button class="text-gray-400 hover:text-orange-500"><i class="fas fa-star"></i></button>
                        <button class="text-gray-400 hover:text-orange-500"><i class="fas fa-star"></i></button>
                        <button class="text-gray-400 hover:text-orange-500"><i class="fas fa-star"></i></button>
                        <button class="text-gray-400 hover:text-orange-500"><i class="fas fa-star"></i></button>
                    </div>

                    <!-- Caixa de Comentário -->
                    <textarea class="w-full md:w-1/2 p-4 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500" placeholder="Adicione um comentário (opcional)"></textarea>

                    <!-- Botão de Enviar Avaliação -->
                    <button class="py-2 px-6 bg-orange-500 text-white font-bold rounded-lg hover:bg-orange-500 transition-all duration-300">Enviar Avaliação</button>
                </div>
            </div>

            <!-- Aba de comentários -->
            <div class="mt-12">
                <h2 class="text-2xl font-bold text-center">Comentários</h2>

                <!-- Botões de Filtro -->
                <div class="flex justify-center space-x-2 mt-4">
                    <button class="py-2 px-4 bg-gray-200 rounded-lg hover:bg-gray-300">Todas</button>
                    <button class="py-2 px-4 bg-gray-200 rounded-lg hover:bg-gray-300">5 Estrelas</button>
                    <button class="py-2 px-4 bg-gray-200 rounded-lg hover:bg-gray-300">4 Estrelas</button>
                    <button class="py-2 px-4 bg-gray-200 rounded-lg hover:bg-gray-300">3 Estrelas</button>
                    <button class="py-2 px-4 bg-gray-200 rounded-lg hover:bg-gray-300">2 Estrelas</button>
                    <button class="py-2 px-4 bg-gray-200 rounded-lg hover:bg-gray-300">1 Estrela</button>
                </div>

                <!-- Exemplo de Comentário -->
                <div class="mt-6">
                    <div class="p-4 border-b border-gray-300">
                        <div class="flex justify-between">
                            <div>
                                <h3 class="font-bold">Cliente Exemplo</h3>
                                <p class="text-sm text-gray-500">Publicado em 24/09/2024</p>
                            </div>
                            <div class="flex">
                                <span class="text-orange-500">⭐️⭐️⭐️⭐️⭐️</span>
                            </div>
                        </div>
                        <p class="mt-2 text-gray-700">Produto excelente! Chegou rápido e a qualidade é ótima. Recomendo!</p>
                    </div>

                    <div class="p-4 border-b border-gray-300">
                        <div class="flex justify-between">
                            <div>
                                <h3 class="font-bold">Outro Cliente</h3>
                                <p class="text-sm text-gray-500">Publicado em 20/09/2024</p>
                            </div>
                            <div class="flex">
                                <span class="text-orange-500">⭐️⭐️⭐️⭐️</span>
                            </div>
                        </div>
                        <p class="mt-2 text-gray-700">Bom produto, mas demorou um pouco para chegar.</p>
                    </div>
                </div>
            </div>
    </section>

    <?php include("footer.php"); ?>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</body>

</html>