    <?php
    require('../../src/backend/conexao.php');
    if ($_SERVER["REQUEST_METHOD"] == 'GET' && isset($_GET['idProduto'])) {
        $idProduto = $_GET['idProduto'];
        $sqlDelete = "DELETE FROM Produto WHERE idProduto = ?";
        $stmt = $conexao->prepare($sqlDelete);
        if ($stmt) {
            $stmt->bind_param("i", $idProduto);
            if ($stmt->execute()) {
                echo "<script>alert('Registro Deletado.');</script>";
                header('Location: read.php');
                exit;
            } else {
                die("ERRO: Não foi possível deletar: " . $stmt->error);
            }
        } else {
            die("ERRO: Não foi possível preparar a query: " . $conexao->error);
        }
    }

    ?>