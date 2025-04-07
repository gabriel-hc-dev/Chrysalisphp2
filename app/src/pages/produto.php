<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chrysalis - Sua Loja Preferida</title>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../../public/assets/images/White_Butterfly.png">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
</head>

<body>
    <?php
    session_start();
    include("header.php");
    include("../backend/conexao.php");

    // Inicializa o carrinho se não existir
    if (!isset($_SESSION['carrinho'])) {
        $_SESSION['carrinho'] = [];
    }

    // Lógica para adicionar produto ao carrinho
    $produtoExiste = false;

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['adicionar_carrinho'])) {
        $idProduto = $_POST['idProduto'];

        // Obtenha o produto do banco de dados
        $sql = "SELECT descricao, valorProduto FROM Produto WHERE idProduto = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("i", $idProduto);
        $stmt->execute();
        $stmt->bind_result($descricao, $valorProduto);
        $stmt->fetch();
        $stmt->close();

        if (!$descricao || !$valorProduto) {
            echo "Produto não encontrado.";
            exit;
        }

        $produto = [
            'id' => $idProduto,
            'descricao' => $descricao,
            'valorProduto' => $valorProduto,
            'quantidade' => 1
        ];

        foreach ($_SESSION['carrinho'] as &$item) {
            if ($item['id'] == $idProduto) {
                $item['quantidade']++;
                $produtoExiste = true;
                break;
            }
        }

        if (!$produtoExiste) {
            $_SESSION['carrinho'][] = $produto;
        }

        echo "<script>
                alert('Produto adicionado ao carrinho com sucesso!');
            </script>";
    }

    if (isset($_GET['id'])) {
        $idProduto = $_GET['id'];

        // Consulta SQL para buscar os detalhes do produto
        $sql = "SELECT idProduto, valorProduto, descricao, grupo, subGrupo, genero, imagem 
                FROM Produto 
                WHERE idProduto = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("i", $idProduto);
        $stmt->execute();
        $stmt->bind_result($idProduto, $valorProduto, $descricao, $grupo, $subgrupo, $genero, $imagem);
        $stmt->fetch();
        $stmt->close();

        // Lógica para processar o envio de um novo comentário
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['avaliacao'], $_POST['comentario'], $_SESSION['usuario_id'])) {
            $nota = $_POST['avaliacao'];
            $comentario = $_POST['comentario'];
            $idUsuario = $_SESSION['usuario_id']; // ID do usuário logado
    

            // Inserir o feedback no banco de dados
            $sqlInsert = "INSERT INTO Feedback (nota, descricaoFeedback, idUsuario, idProduto) VALUES (?, ?, ?, ?)";
            $stmtInsert = $conexao->prepare($sqlInsert);
            if ($stmtInsert) {
                $stmtInsert->bind_param("isii", $nota, $comentario, $idUsuario, $idProduto);
                $stmtInsert->execute();
                $stmtInsert->close();

                // Redirecionar para evitar reenvio do formulário
                echo '
                <script>
                    window.location.replace("produto.php?id=' . $idProduto . '");
                </script>';
                exit;
            } else {
                echo "Erro ao preparar a declaração: " . $conexao->error;
            }
        }

        // Consulta para buscar os comentários
        $sqlComentarios = "SELECT U.loginUsuario, F.nota, F.descricaoFeedback FROM Feedback F JOIN Usuario U ON F.idUsuario = U.idUsuario WHERE F.idProduto = ?";
        $stmt = $conexao->prepare($sqlComentarios);
        $stmt->bind_param("i", $idProduto);
        $stmt->execute();
        $comentarios = $stmt->get_result();
    } else {
        echo "<p>Produto não encontrado.</p>";
        exit;
    }

    // Lógica para deletar feedback
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deletar_feedback'])) {
        $idFeedback = $_POST['idFeedback'];
        $idUsuario = $_SESSION['usuario_id']; // Capturar o ID do usuário logado aqui
    
        // Verifica se o feedback pertence ao usuário logado
        $sqlVerifica = "SELECT idUsuario FROM Feedback WHERE idFeedback = ?";
        $stmtVerifica = $conexao->prepare($sqlVerifica);
        $stmtVerifica->bind_param("i", $idFeedback);
        $stmtVerifica->execute();
        $stmtVerifica->bind_result($idFeedbackUsuario);
        $stmtVerifica->fetch();
        $stmtVerifica->close();

        if ($idFeedbackUsuario === $idUsuario) {
            $sqlDelete = "DELETE FROM Feedback WHERE idFeedback = ?";
            $stmtDelete = $conexao->prepare($sqlDelete);
            $stmtDelete->bind_param("i", $idFeedback);
            $stmtDelete->execute();
            $stmtDelete->close();
        }
    }

    // Lógica para exibir o gênero
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
    ?>


<div class="container mx-auto px-4 md:px-12 py-6 space-y-12">

    <!-- Produto -->
    <div class="bg-white shadow-lg rounded-2xl p-6 md:p-12 flex flex-col md:flex-row gap-10">
        
        <!-- Imagem -->
        <div class="flex justify-center md:block">
            <?php if ($imagem): ?>
                <img class="w-full max-w-xs md:max-w-sm rounded-xl object-cover shadow-md"
                    src="data:image/png;base64,<?= base64_encode($imagem) ?>" alt="Imagem do produto">
            <?php else: ?>
                <img class="w-full max-w-xs md:max-w-sm rounded-xl object-cover shadow-md"
                    src="https://via.placeholder.com/300" alt="Imagem não disponível">
            <?php endif; ?>
        </div>

        <!-- Informações do Produto -->
        <div class="flex-1 flex flex-col text-center md:text-left">
            <div class="space-y-4 mb-10">
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-800 leading-tight">
                    <?= "$grupo $subgrupo $descricao $genero"; ?>
                </h1>
                <p class="text-3xl text-orange-500 font-bold">
                    R$ <?= number_format($valorProduto, 2, ',', '.'); ?>
                </p>
            </div>

            <!-- Botão de Carrinho -->
            <form method="GET" action="adicionar_carrinho.php" class="mt-10 w-full">
                <input type="hidden" name="idProduto" value="<?= $idProduto; ?>">
                <button type="submit"
                    class="w-full flex justify-center items-center text-white bg-orange-500 hover:bg-orange-700 hover:scale-105 transition-transform duration-300 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-base px-4 py-3">
                    Adicionar ao Carrinho
                </button>
            </form>
        </div>
    </div>

    <!-- Avaliação -->
    <div class="bg-white shadow-lg rounded-2xl p-10 md:p-10">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Avalie este produto</h2>
        <form method="POST" class="space-y-6">
            <!-- Estrelas -->
            <div class="flex justify-center gap-2">
                <input type="hidden" name="avaliacao" id="avaliacao" value="0">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <svg class="estrela w-10 h-10 text-gray-300 hover:text-orange-500 cursor-pointer transition-colors duration-200"
                        data-valor="<?= $i; ?>" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        fill="currentColor">
                        <path
                            d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                    </svg>
                <?php endfor; ?>
            </div>

            <!-- Comentário -->
            <div class="flex justify-center">
                <textarea name="comentario"
                    class="w-full md:w-4/5 border border-gray-300 rounded-lg p-4 focus:outline-none focus:border-orange-500"
                    rows="4" placeholder="Adicione um comentário (opcional)"></textarea>
            </div>

            <!-- Botão Avaliar -->
            <div class="flex justify-center">
                <button id="btnAvaliar"
                    class="w-full md:w-2/5 py-3 bg-orange-500 text-white text-lg font-semibold rounded-lg shadow hover:scale-105 hover:bg-orange-700 transition-transform duration-200">
                    Enviar Avaliação
                </button>
            </div>
        </form>
    </div>

    <!-- Comentários -->
    <div class="bg-white shadow-lg rounded-2xl p-6 md:p-10">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Comentários</h2>

        <!-- Filtros -->
        <div class="flex flex-wrap gap-3 mb-6">
            <button onclick="filtrarComentarios(0)"
                class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 text-gray-700 shadow transition-all duration-300">
                Todas as notas
            </button>
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <button onclick="filtrarComentarios(<?= $i; ?>)"
                    class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 text-gray-700 shadow transition-all duration-300">
                    <?= $i; ?> Estrela<?= $i > 1 ? 's' : ''; ?>
                </button>
            <?php endfor; ?>
        </div>

        <!-- Lista de Comentários -->
        <div id="comentarios" class="space-y-6">
            <?php while ($comentario = $comentarios->fetch_assoc()): ?>
                <div class="border-b border-gray-200 pb-4">
                    <p class="font-bold text-gray-700"><?= $comentario['loginUsuario']; ?></p>
                    <div class="flex mb-2">
                        <?php for ($i = 0; $i < 5; $i++): ?>
                            <svg class="w-5 h-5 <?= $i < $comentario['nota'] ? 'text-orange-500' : 'text-gray-300'; ?>"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                            </svg>
                        <?php endfor; ?>
                    </div>
                    <p class="text-gray-600"><?= $comentario['descricaoFeedback']; ?></p>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>


        <script>
            const estrelas = document.querySelectorAll('.estrela');
            const inputAvaliacao = document.getElementById('avaliacao');

            estrelas.forEach((estrela, index) => {
                estrela.addEventListener('click', () => {
                    const valor = parseInt(estrela.dataset.valor);
                    inputAvaliacao.value = valor;

                    estrelas.forEach((e, i) => {
                        e.classList.toggle('text-orange-500', i < valor);
                        e.classList.toggle('text-gray-400', i >= valor);
                    });
                });
            });

            function filtrarComentarios(nota) {
                const comentarios = document.querySelectorAll('#comentarios > div');

                comentarios.forEach((comentario) => {
                    const estrelas = comentario.querySelectorAll('svg.text-orange-500').length;
                    comentario.style.display = (nota === 0 || estrelas === nota) ? 'block' : 'none';
                });
            }
        </script>
        <?php
        include('footer.php');
        ?>
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
        <script>
            AOS.init();
        </script>
</body>

</html>