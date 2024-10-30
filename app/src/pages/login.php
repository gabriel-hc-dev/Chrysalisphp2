<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="../../public/assets/images/White_Butterfly.png">
    <title>Chrysalis - Entrar</title>
</head>

<body>
    <?php
    session_start(); // Iniciar a sessão
    include('../backend/conexao.php');

    // Verifica se o formulário foi enviado
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Consulta para obter o usuário com o e-mail fornecido (usando prepared statements)
        $stmt = $conexao->prepare("SELECT * FROM Usuario WHERE loginUsuario = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $usuario = $result->fetch_assoc();

            // Verifica se a senha fornecida corresponde à senha armazenada
            if (password_verify($password, $usuario['senha'])) {
                // Autenticação bem-sucedida, armazena o ID do usuário e informações na sessão
                $_SESSION['usuario_id'] = $usuario['idPessoa'];
                $_SESSION['usuario_email'] = $usuario['loginUsuario'];
                $_SESSION['is_admin'] = ($usuario['loginUsuario'] === 'administradorchrysalis@gmail.com');

                // Redireciona para a página adequada com base no papel do usuário
                if ($_SESSION['is_admin']) {
                    header("Location: admin_page.php"); // Página de administração para admin
                } else {
                    header("Location: index.php"); // Página inicial para usuários comuns
                }
                exit();
            } else {
                $erro = "E-mail ou senha incorretos.";
            }
        } else {
            $erro = "E-mail ou senha incorretos.";
        }
    }
    ?>

    <?php include('header.php'); ?>

    <main>
        <section class="flex justify-center p-4 bg-gray-50">
            <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0" style="width: 50%">
                <div class="w-dvw bg-white rounded-lg md:mt-0 sm:max-w-md xl:p-0 transition-all shadow scale-125">
                    <div class="p-6 md:space-y-4 sm:p-8">
                        <h1 class="text-2xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">Entrar</h1>
                        <p class="text-sm font-light text-gray-500">
                            Ainda não possui login? <a href="cadastro.php" class="font-medium text-orange-500 hover:underline">Cadastre-se</a>
                        </p>

                        <?php if (isset($erro)): ?>
                            <div class="mb-4 text-red-500">
                                <?php echo htmlspecialchars($erro); ?>
                            </div>
                        <?php endif; ?>

                        <form class="space-y-4 md:space-y-6" action="" method="POST">
                            <div>
                                <label for="email" class="block mb-2 text-sm font-medium text-gray-900">E-mail</label>
                                <input type="email" name="email" id="email" placeholder="exemplo@gmail.com"
                                    class="bg-gray-50 border transition-all border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 hover:bg-white focus:my-1"
                                    required>
                            </div>
                            <div>
                                <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Senha</label>
                                <input type="password" name="password" id="password" placeholder="••••••••"
                                    class="bg-gray-50 border transition-all border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 hover:bg-white focus:my-1"
                                    required>
                            </div>
                            <button type="submit"
                                class="w-full text-white bg-orange-500 focus:ring-2 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center hover:bg-orange-700 transition-all hover:scale-105">Entrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php include("footer.php"); ?>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>

</body>

</html>