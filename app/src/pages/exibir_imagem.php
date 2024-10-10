<?php
include_once('../backend/conexao.php'); // ajuste o caminho conforme a estrutura do seu projeto

// Verifique se o ID do produto foi passado
if (isset($_GET['id'])) {
    $idProduto = $_GET['id'];

    // Buscando a imagem no banco de dados
    $sql = "SELECT imagem FROM Produto WHERE idProduto = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $idProduto);
    $stmt->execute();
    $stmt->bind_result($imagem);
    $stmt->fetch();

    // Definindo o cabeçalho apropriado para imagens WEBP
    header("Content-Type: image/png");

    // Exibindo a imagem binária diretamente
    echo $imagem;

    $stmt->close();
} else {
    echo "ID do produto não fornecido!";
}
?>
