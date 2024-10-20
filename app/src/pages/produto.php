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
    include("../backend/conexao.php");

    // Inicializa o carrinho se não existir
    if (!isset($_SESSION['carrinho'])) {
        $_SESSION['carrinho'] = [];
    }

    // Lógica para adicionar produto ao carrinho
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['adicionar_ao_carrinho'])) {
        $idProduto = $_POST['idProduto'];
        $produto = [
            'id' => $idProduto,
            'descricao' => $descricao,
            'valorProduto' => $valorProduto,
            'quantidade' => 1
        ];

        // Verifica se o produto já está no carrinho
        $produtoExiste = false;
        foreach ($_SESSION['carrinho'] as &$item) {
            if ($item['id'] == $idProduto) {
                $item['quantidade']++; // Incrementa a quantidade se já existir
                $produtoExiste = true;
                break;
            }
        }

        // Se o produto não existir, adiciona ao carrinho
        if (!$produtoExiste) {
            $_SESSION['carrinho'][] = $produto;
        }

        // Redireciona para evitar reenvio de formulário
        header("Location: produto.php?id=" . $idProduto);
        exit();
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

        // Consulta para buscar os comentários e unir com a tabela Usuario
        $sqlComentarios = "SELECT U.loginUsuario, F.nota, F.descricaoFeedback FROM Feedback F JOIN Usuario U ON F.idUsuario = U.idUsuario WHERE F.idProduto = ?";
        $stmt = $conexao->prepare($sqlComentarios);
        $stmt->bind_param("i", $idProduto);
        $stmt->execute();
        $comentarios = $stmt->get_result();
    } else {
        echo "<p>Produto não encontrado.</p>";
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nota = $_POST['avaliacao'];
        $comentario = $_POST['comentario'];
        $idUsuario = 1; // Aqui você deve capturar o ID do usuário logado

        // Insere o feedback no banco de dados
        $sqlInsert = "INSERT INTO Feedback (nota, descricaoFeedback, idUsuario, idProduto) VALUES (?, ?, ?, ?)";
        $stmtInsert = $conexao->prepare($sqlInsert);

        // Verifica se a preparação foi bem-sucedida
        if ($stmtInsert) {
            $stmtInsert->bind_param("isii", $nota, $comentario, $idUsuario, $idProduto);
            $stmtInsert->execute(); // Executa a inserção
            $stmtInsert->close(); // Fecha a declaração
        } else {
            echo "Erro ao preparar a declaração: " . $conexao->error; // Tratamento de erro
        }
    }




    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deletar_feedback'])) {
        $idFeedback = $_POST['idFeedback'];
        $idUsuario = 1; // Capturar o ID do usuário logado aqui

        // Verifica se o feedback pertence ao usuário logado
        $sqlVerifica = "SELECT idUsuario FROM Feedback WHERE idFeedback = ?";
        $stmtVerifica = $conexao->prepare($sqlVerifica);
        $stmtVerifica->bind_param("i", $idFeedback);
        $stmtVerifica->execute();
        $stmtVerifica->bind_result($idFeedbackUsuario);
        $stmtVerifica->fetch();
        $stmtVerifica->close();

        // Se o usuário logado for o autor do feedback, realiza a exclusão
        if ($idFeedbackUsuario === $idUsuario) {
            $sqlDelete = "DELETE FROM Feedback WHERE idFeedback = ?";
            $stmtDelete = $conexao->prepare($sqlDelete);
            $stmtDelete->bind_param("i", $idFeedback);
            $stmtDelete->execute();
            $stmtDelete->close();
            // Você pode adicionar uma mensagem de sucesso aqui, se desejar
        } else {
            // Se o usuário não for o autor do feedback, você pode adicionar uma mensagem de erro
        }
    }


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
                    <h1 class="text-3xl font-bold"><?php echo "$descricao $grupo $subgrupo $genero"; ?></h1>
                    <p class="text-4xl font-bold mt-4">R$ <?php echo number_format($valorProduto, 2, ',', '.'); ?></p>
                    <form method="POST" action="produto.php?id=<?php echo $idProduto; ?>">
                        <input type="hidden" name="idProduto" value="<?php echo $idProduto; ?>">
                        <button type="submit" name="adicionar_carrinho" class="w-full py-4 bg-orange-500 text-white font-bold rounded-lg hover:bg-orange-600 transition duration-300 mt-6">
                            Adicionar ao Carrinho
                        </button>
                    </form>
                </div>
            </div>

            <div class="mt-12">
                <h2 class="text-2xl font-bold text-center">Adicionar Avaliação</h2>
                <form method="POST" class="flex flex-col items-center space-y-4 mt-4">
                    <input type="hidden" name="avaliacao" id="avaliacao" value="0">
                    <!-- Atualização no código das estrelas -->
                    <div class="flex space-x-2">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <svg class="estrela w-10 h-10 cursor-pointer text-gray-400" data-valor="<?php echo $i; ?>" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                            </svg>
                        <?php endfor; ?>
                    </div>

                    <textarea class="w-full md:w-1/2 p-4 border border-gray-300 rounded-lg focus:border-orange-500" name="comentario" placeholder="Adicione um comentário (opcional)"></textarea>
                    <button type="submit" class="py-2 px-6 bg-orange-500 text-white font-bold rounded-lg hover:bg-orange-600 transition duration-300">Enviar Avaliação</button>
                </form>
            </div>

            <div class="mt-12">
                <h2 class="text-2xl font-bold text-center">Comentários</h2>

                <!-- Botões de filtro -->
                <div class="flex justify-center space-x-2 mt-4">
                    <button onclick="filtrarComentarios(0)" class="py-2 px-4 bg-gray-200 rounded-lg hover:bg-gray-300">Todas</button>
                    <button onclick="filtrarComentarios(5)" class="py-2 px-4 bg-gray-200 rounded-lg hover:bg-gray-300">5 Estrelas</button>
                    <button onclick="filtrarComentarios(4)" class="py-2 px-4 bg-gray-200 rounded-lg hover:bg-gray-300">4 Estrelas</button>
                    <button onclick="filtrarComentarios(3)" class="py-2 px-4 bg-gray-200 rounded-lg hover:bg-gray-300">3 Estrelas</button>
                    <button onclick="filtrarComentarios(2)" class="py-2 px-4 bg-gray-200 rounded-lg hover:bg-gray-300">2 Estrelas</button>
                    <button onclick="filtrarComentarios(1)" class="py-2 px-4 bg-gray-200 rounded-lg hover:bg-gray-300">1 Estrela</button>
                </div>

                <div id="comentarios" class="mt-6">
                    <div id="mensagem" class="hidden mt-4 p-4 text-orange-700 bg-orange-100 rounded-lg" role="alert">
                        Nenhum comentário encontrado com a nota equivalente a <span id="nota-mensagem"></span> estrela(s).
                    </div>

                    <?php while ($comentario = $comentarios->fetch_assoc()) { ?>
                        <div class="comentario p-4 border-b border-gray-300" data-estrelas="<?php echo $comentario['nota']; ?>">
                            <div class="flex justify-between">
                                <div>
                                    <h3 class="font-bold"><?php echo $comentario['loginUsuario']; ?></h3>
                                </div>
                                <div class="flex">
                                    <?php for ($i = 1; $i <= 5; $i++) { ?>
                                        <svg class="w-4 h-4 <?php echo $i <= $comentario['nota'] ? 'text-yellow-300' : 'text-gray-300'; ?>" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                            <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.848l-5.051.734a1.523 1.523 0 0 0-.841 2.601l3.646 3.604-.861 5.049a1.524 1.524 0 0 0 2.212 1.605l4.507-2.366 4.508 2.366a1.524 1.524 0 0 0 2.212-1.605l-.861-5.049 3.646-3.604a1.523 1.523 0 0 0 .313-1.567z" />
                                        </svg>
                                    <?php } ?>
                                </div>
                            </div>
                            <p class="mt-2"><?php echo $comentario['descricaoFeedback']; ?></p>
                            <?php if (isset($_SESSION['usuario_logado']) && $comentario['loginUsuario'] === $_SESSION['usuario_logado']): ?>
                                <form method="POST" action="produto.php?id=<?php echo $idProduto; ?>" class="mt-2">
                                    <input type="hidden" name="idFeedback" value="<?php echo $comentario['idFeedback']; ?>">
                                    <button type="submit" name="deletar_feedback" class="py-1 px-2 bg-red-500 text-white rounded hover:bg-red-600">Excluir</button>
                                </form>
                            <?php endif; ?>

                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    </section>

    <script>
        // Configurações das estrelas
        const estrelas = document.querySelectorAll('.estrela');
        let notaSelecionada = 0;

        // Evento para o mouse sobre as estrelas
        estrelas.forEach(estrela => {
            estrela.addEventListener('mouseover', () => {
                const valor = parseInt(estrela.getAttribute('data-valor'));
                atualizarEstrelas(valor);
            });

            estrela.addEventListener('mouseout', () => {
                atualizarEstrelas(notaSelecionada);
            });

            estrela.addEventListener('click', () => {
                notaSelecionada = parseInt(estrela.getAttribute('data-valor'));
                document.getElementById('avaliacao').value = notaSelecionada;
                atualizarEstrelas(notaSelecionada);
            });
        });

        function atualizarEstrelas(valor) {
            estrelas.forEach(estrela => {
                const valorEstrela = parseInt(estrela.getAttribute('data-valor'));
                estrela.classList.toggle('text-yellow-300', valorEstrela <= valor);
                estrela.classList.toggle('text-gray-400', valorEstrela > valor);
            });
        }

        // Função para filtrar comentários
        function filtrarComentarios(nota) {
            const comentarios = document.querySelectorAll('.comentario');
            const mensagem = document.getElementById('mensagem');
            const notaMensagem = document.getElementById('nota-mensagem');
            let nenhumComentarioEncontrado = true; // Variável para rastrear se nenhum comentário foi encontrado

            comentarios.forEach(comentario => {
                const notaComentario = parseInt(comentario.getAttribute('data-estrelas'));
                if (nota === 0 || notaComentario === nota) {
                    comentario.style.display = 'block';
                    nenhumComentarioEncontrado = false; // Comentário encontrado, altera o valor da variável
                } else {
                    comentario.style.display = 'none';
                }
            });

            // Atualiza a mensagem se nenhum comentário foi encontrado
            if (nenhumComentarioEncontrado) {
                notaMensagem.textContent = nota; // Atualiza a nota na mensagem
                mensagem.classList.remove('hidden'); // Mostra a mensagem
            } else {
                mensagem.classList.add('hidden'); // Esconde a mensagem se comentários foram encontrados
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script> <!-- Script do Flowbite -->
</body>

</html>