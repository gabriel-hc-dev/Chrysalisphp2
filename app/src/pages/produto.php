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


    <section class="flex items-center justify-center min-h-screen">
        <div class="container mx-auto p-6">
            <div class="flex flex-col items-center md:flex-row md:space-x-12 gap-8 mb-8">
                <?php
                if ($imagem) {
                    echo '<img class="w-5/6 m-4 rounded-lg object-contain" src="data:image/png;base64,' . base64_encode($imagem) . '" alt="Imagem do produto" style="height:500px; width:500px;">';
                } else {
                    echo '<img class="w-5/6 m-4 rounded-lg object-contain" src="https://via.placeholder.com/500" alt="Imagem não disponível" style="height:500px; width:500px;">';
                }
                ?>
                <div class="md:w-1/2 mt-6">
                    <h1 class="text-3xl font-bold"><?php echo " $grupo $subgrupo $descricao $genero"; ?></h1>
                    <p class="text-4xl font-bold mt-4">R$ <?php echo number_format($valorProduto, 2, ',', '.'); ?></p>
                    <form method="POST" action="produto.php?id=<?php echo $idProduto; ?>">
                        <input type="hidden" name="idProduto" value="<?php echo $idProduto; ?>">
                        <button onclick="window.location.replace('carrinho.php');"  name="adicionar_carrinho"
                            class="w-full py-4 bg-orange-500 text-white font-bold rounded-lg hover:bg-orange-600 transition duration-300 mt-6">
                            Adicionar ao Carrinho
                        </button>
                    </form>
                </div>
            </div>

            <section>
                <!-- Formulário para adicionar avaliação -->
                <h2 class="text-2xl font-bold text-center">Adicionar Avaliação</h2>
                <form method="POST" class="flex flex-col items-center space-y-4 mt-4">
                    <input type="hidden" name="avaliacao" id="avaliacao" value="0">
                    <div class="flex space-x-2">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <svg class="estrela w-10 h-10 cursor-pointer text-gray-400" data-valor="<?php echo $i; ?>"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                            </svg>
                        <?php endfor; ?>
                    </div>

                    <textarea class="w-full md:w-1/2 p-4 border border-gray-300 rounded-lg focus:border-orange-500"
                        name="comentario" placeholder="Adicione um comentário (opcional)"></textarea>
                    <button type="submit"
                        class="py-2 px-6 bg-orange-500 text-white font-bold rounded-lg hover:bg-orange-600 transition duration-300">
                        Enviar Avaliação
                    </button>
                </form>
            </section> 

            <section class="mt-12">
                <h2 class="text-2xl font-bold text-center">Comentários</h2>

                <div class="flex justify-center space-x-2 mt-4">
                    <button onclick="filtrarComentarios(0)"
                        class="py-2 px-4 bg-gray-200 rounded-lg hover:bg-gray-300">Todas as notas</button>
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <button onclick="filtrarComentarios(<?php echo $i; ?>)"
                            class="py-2 px-4 bg-gray-200 rounded-lg hover:bg-gray-300"><?php echo $i; ?>
                            Estrela<?php echo $i > 1 ? 's' : ''; ?></button>
                    <?php endfor; ?>
                </div>

                <div id="comentarios" class="mt-8">
                    <?php while ($comentario = $comentarios->fetch_assoc()): ?>
                        <div class="p-4 border border-gray-300 rounded-lg mb-4">
                            <p class="font-bold"><?php echo $comentario['loginUsuario']; ?></p>
                            <div class="flex mb-2">
                                <?php for ($i = 0; $i < 5; $i++): ?>
                                    <svg class="w-6 h-6 text-<?php echo $i < $comentario['nota'] ? 'orange-500' : 'gray-400'; ?>"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                    </svg>
                                <?php endfor; ?>
                            </div>
                            <p><?php echo $comentario['descricaoFeedback']; ?></p>
                        </div>
                    <?php endwhile; ?>
                </div>
            </section>

            <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>

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
</body>

</html>