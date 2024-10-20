<?php
include_once('../backend/conexao.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    // Usuário não está logado, redirecionar ou mostrar mensagem de erro
    header("Location: login.php"); // Redirecione para a página de login
    exit();
}
$idProduto = $_GET['idProduto'];
$idUsuario = $_SESSION['usuario_id']; // Aqui, mudamos para usar o id correto

// Verifica se o carrinho já existe para o usuário
$sqlCarrinho = "SELECT idCarrinho FROM Carrinho WHERE idUsuario = ?";
$stmt = $conexao->prepare($sqlCarrinho);
$stmt->bind_param("i", $idUsuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Carrinho existente
    $row = $result->fetch_assoc();
    $idCarrinho = $row['idCarrinho'];
} else {
    // Cria um novo carrinho
    $valorCarrinho = 0; // Você pode definir um valor inicial
    $sqlCriarCarrinho = "INSERT INTO Carrinho (idUsuario, tamanhoCarrinho, valorCarrinho) VALUES (?, 0, ?)";
    $stmt = $conexao->prepare($sqlCriarCarrinho);
    $stmt->bind_param("id", $idUsuario, $valorCarrinho);
    $stmt->execute();
    $idCarrinho = $stmt->insert_id;
}

// Adiciona o produto ao CarrinhoXProduto
$sqlAdicionarProduto = "INSERT INTO CarrinhoXProduto (idCarrinho, idProduto) VALUES (?, ?)";
$stmt = $conexao->prepare($sqlAdicionarProduto);
$stmt->bind_param("ii", $idCarrinho, $idProduto);
$stmt->execute();

// Atualiza o tamanho do carrinho (opcional)
$tamanhoCarrinho = $result->num_rows + 1; // Aumenta o tamanho do carrinho
$sqlAtualizaTamanho = "UPDATE Carrinho SET tamanhoCarrinho = ? WHERE idCarrinho = ?";
$stmt = $conexao->prepare($sqlAtualizaTamanho);
$stmt->bind_param("ii", $tamanhoCarrinho, $idCarrinho);
$stmt->execute();

exit();
