<?php
include_once('../backend/conexao.php');
if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
}

// Busca os dados do banco
$sql = 'SELECT * FROM Produto';
$result = $conexao->query($sql);

// Função para gerar o HTML das estrelas
function renderStar($filled) {
    if ($filled == 1) {
        return '<svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="#FACA15" viewBox="0 0 22 20">
                    <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                </svg>';
    } elseif ($filled == 0.5) {
        return '<svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 20">
                    <defs>
                        <linearGradient id="grad1" x1="0%" y1="0%" x2="100%" y2="0%">
                            <stop offset="50%" style="stop-color:#FACA15;stop-opacity:1" /> <!-- Amarelo da meia estrela -->
                            <stop offset="50%" style="stop-color:#D1D5DB;stop-opacity:1" /> <!-- Cinza da meia estrela -->
                        </linearGradient>
                    </defs>
                    <path fill="url(#grad1)" d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                </svg>';
    } elseif ($filled == 0) {
        return '<svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="#D1D5DB" viewBox="0 0 22 20">
                    <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                </svg>';
    }
    return '';
}

// Supondo que você já tenha uma conexão estabelecida com o MySQL via mysqli
while ($user_data = mysqli_fetch_assoc($result)) {
    $idProduto = $user_data['idProduto'];

    // Contar avaliações para o produto atual
    $sqlFeedbackCount = 'SELECT COUNT(idFeedback) AS NumAvaliações, AVG(nota) AS MediaAvaliacoes FROM Feedback WHERE idProduto = ' . $idProduto;
    $resultFeedback = $conexao->query($sqlFeedbackCount);
    $numAvaliacoes = 0;
    $mediaAvaliacoes = 0;
    if ($resultFeedback->num_rows > 0) {
        $rowFeedback = $resultFeedback->fetch_assoc();
        $numAvaliacoes = $rowFeedback['NumAvaliações'];
        $mediaAvaliacoes = $rowFeedback['MediaAvaliacoes'];
    }

    $genero = $user_data['genero'];

    switch (trim($genero)) {
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

    // Calcular número de estrelas cheias, médias e vazias
    $fullStars = floor($mediaAvaliacoes);
    $halfStar = ($mediaAvaliacoes - $fullStars >= 0.5) ? 0.5 : 0;
    $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0); // Total de 5 estrelas

    // Gerar HTML das estrelas
    $starsHTML = '';
    for ($i = 0; $i < $fullStars; $i++) {
        $starsHTML .= renderStar(1); // Estrela cheia
    }
    if ($halfStar) {
        $starsHTML .= renderStar(0.5); // Estrela meia
    }
    for ($i = 0; $i < $emptyStars; $i++) {
        $starsHTML .= renderStar(0); // Estrela vazia
    }

    echo ('<div class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow">
    <a href="produto.php?id=' . $user_data['idProduto'] . '">
        <img class="p-8 rounded-t-lg" src="exibir_imagem.php?id=' . $user_data['idProduto'] . '" alt="Imagem do Produto" style="max-height:500px"/>
    </a>
    <div class="px-5 pb-5">
        <a href="produto.php?id=' . $user_data['idProduto'] . '">
            <h5 class="text-xl font-semibold tracking-tight text-gray-900">' . $user_data['grupo'] . ' ' . $user_data['subGrupo'] . ' ' . $user_data['descricao'] . ' ' . $genero . '</h5>
        </a>
        <div class="flex items-center mt-2.5 mb-5">
            <div class="flex items-center space-x-1 rtl:space-x-reverse">
                ' . $starsHTML . '
            </div>
            <span class="text-xs font-semibold px-2.5 py-1 rounded">' . ($numAvaliacoes > 0 ? '(' . $numAvaliacoes . ')' : '(0)') . '</span>
            <span class="bg-orange-100 text-orange-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-orange-200 dark:text-orange-800 ms-3">' . number_format($mediaAvaliacoes, 1) . '</span>
        </div>
        <div class="flex items-center justify-between">           
            <span class="text-3xl font-bold text-gray-900">R$' . $user_data['valorProduto'] . '</span>
            <a href="adicionar_carrinho.php?idProduto=' . $user_data['idProduto'] . '" 
                class="text-white bg-orange-700 transition-colors hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                <img src="../../public/assets/images/icons/cart.svg" alt="Carrinho" style="filter: invert(100%)">
            </a>
        </div>
    </div>
</div>
');
}
?>
