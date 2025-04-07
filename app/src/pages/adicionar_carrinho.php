<?php
session_start();
include_once('../backend/conexao.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    echo ('<script>window.location.replace("carrinho.php");</script>'); // Redireciona para a página de login
    exit();
}

$idProduto = $_GET['idProduto'];
$idUsuario = $_SESSION['usuario_id']; // ID do usuário logado

// Verifica se o produto existe
$sqlVerificaProduto = "SELECT idProduto FROM Produto WHERE idProduto = ?";
$stmt = $conexao->prepare($sqlVerificaProduto);
$stmt->bind_param("i", $idProduto);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows === 0) {
    echo "<script>alert('Produto inválido.'); window.location.href='carrinho.php';</script>";
    exit();
}

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
    $tamanhoCarrinho = 0;
    $sqlCriarCarrinho = "INSERT INTO Carrinho (idUsuario, tamanhoCarrinho) VALUES (?, ?)";
    $stmt = $conexao->prepare($sqlCriarCarrinho);
    $stmt->bind_param("ii", $idUsuario, $tamanhoCarrinho);
    $stmt->execute();
    $idCarrinho = $stmt->insert_id;
}

// Adiciona o produto ao CarrinhoXProduto
$sqlAdicionarProduto = "INSERT INTO CarrinhoXProduto (idCarrinho, idProduto) VALUES (?, ?)";
$stmt = $conexao->prepare($sqlAdicionarProduto);
$stmt->bind_param("ii", $idCarrinho, $idProduto);
$stmt->execute();

// Atualiza a sessão
if (!isset($_SESSION['carrinho'][$idProduto])) {
    $_SESSION['carrinho'][$idProduto] = 1; // Adiciona o produto ao carrinho da sessão
} else {
    $_SESSION['carrinho'][$idProduto]++; // Incrementa a quantidade
}

// Atualiza o tamanho do carrinho
$tamanhoCarrinho = $result->num_rows + 1; // Aumenta o tamanho do carrinho
$sqlAtualizaTamanho = "UPDATE Carrinho SET tamanhoCarrinho = ? WHERE idCarrinho = ?";
$stmt = $conexao->prepare($sqlAtualizaTamanho);
$stmt->bind_param("ii", $tamanhoCarrinho, $idCarrinho);
$stmt->execute();

// Busca o preço pelo ID
$sqlPrecoProduto = "SELECT valorProduto FROM Produto WHERE idProduto = ?";
$stmt = $conexao->prepare($sqlPrecoProduto);
$stmt->bind_param("i", $idProduto);
$stmt->execute();
$result = $stmt->get_result();
$rowProduto = $result->fetch_assoc();
$valorProduto = $rowProduto['valorProduto'];

header('Location: carrinho.php');

exit();
?>