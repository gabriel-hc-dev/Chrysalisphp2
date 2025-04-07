<?php
include_once('../backend/conexao.php');
if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
}

// Busca os dados do banco
$sql = 'SELECT * FROM Produto';
$result = $conexao->query($sql);

// Função para gerar o HTML das estrelas
function renderStar($filled)
{
    if ($filled == 1) {
        return '<svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="#FACA15" viewBox="0 0 22 20">
                    <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                </svg>';
    } elseif ($filled == 0.5) {
        return '<svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 20">
                    <defs>
                        <linearGradient id="grad1" x1="0%" y1="0%" x2="100%" y2="0%">
                            <stop offset="50%" style="stop-color:#FACA15;stop-opacity:1" />
                            <stop offset="50%" style="stop-color:#D1D5DB;stop-opacity:1" />
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
    $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);

    // Gerar HTML das estrelas
    $starsHTML = '';
    for ($i = 0; $i < $fullStars; $i++) {
        $starsHTML .= renderStar(1);
    }
    if ($halfStar) {
        $starsHTML .= renderStar(0.5);
    }
    for ($i = 0; $i < $emptyStars; $i++) {
        $starsHTML .= renderStar(0);
    }

    echo ('
    <div class="w-full sm:max-w-xs md:max-w-sm lg:max-w-md bg-white shadow-t shadow-b flex flex-col justify-between">
        <a href="produto.php?id=' . $user_data['idProduto'] . '" class="relative group">
            <img class="w-full shadow hover:blur-sm transition ease-in-out duration-200 h-64 sm:h-72 md:h-80 object-cover object-center rounded-t-md" src="exibir_imagem.php?id=' . $user_data['idProduto'] . '" alt="Imagem do Produto">
            <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition duration-300 rounded-t-lg">
                <img src="../../public/assets/images/icons/expand.svg" alt="Ver Detalhes" class="animate-[bounce_0.7s_ease-in-out_infinite] w-8 h-8 invert">
            </div>
        </a>
        <div class="px-0 sm:px-0 pb-4 sm:pb-5 flex flex-col flex-grow justify-between">
            <a href="produto.php?id=' . $user_data['idProduto'] . '">
                <h5 class="text-lg sm:text-xl font-semibold tracking-tight mt-4 sm:mt-6 text-gray-900 line-clamp-2">' . $user_data['grupo'] . ' ' . $user_data['subGrupo'] . ' ' . $user_data['descricao'] . ' ' . $genero . '</h5>
            </a>
            <div class="flex items-center mt-2 sm:mt-2.5 mb-4 sm:mb-5">
                <div class="flex items-center space-x-1 rtl:space-x-reverse">
                    ' . $starsHTML . '
                </div>
                <span class="text-xs sm:text-sm font-semibold px-2.5 py-1 rounded">' . ($numAvaliacoes > 0 ? '(' . $numAvaliacoes . ')' : '(0)') . '</span>
                <span class="bg-orange-100 text-orange-800 text-xs sm:text-sm font-semibold px-2.5 py-0.5 rounded">' . number_format($mediaAvaliacoes, 1) . '</span>
            </div>
            <div class="flex items-center justify-between mt-auto md:flex-row flex-col gap-4">
                <span class="text-2xl sm:text-3xl font-bold text-gray-900">R$' . number_format($user_data['valorProduto'], 2, ',', '.') . '</span>
            </div>
        </div>
        <!-- Botão de adicionar ao carrinho, ocupa toda a largura do card -->
        <div class="px-0 pb-4 w-full">
            <a href="adicionar_carrinho.php?idProduto=' . $user_data['idProduto'] . '" 
            class="w-full flex justify-center items-center text-white bg-orange-600 hover:bg-orange-700 hover:scale-105 duration-300 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-sm px-4 py-3 text-center">
                <img src="../../public/assets/images/icons/cart.svg" alt="Carrinho" class="invert mr-2" />
            </a>
        </div>
    </div>
    ');
    
}
?>