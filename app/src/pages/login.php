<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="../../public/assets/images/White_Butterfly.png">
    <title>Chrysalis - Entrar</title>
    <style>
        body::-webkit-scrollbar {
            width: 10px;
            /* width of the entire scrollbar */
        }

        body::-webkit-scrollbar-track {
            background-color: rgb(249 250 251);
            /* color of the tracking area */
        }

        body::-webkit-scrollbar-thumb {
            background-color: rgba(203, 213, 225, 0.8);
            /* color of the scroll thumb */
            border-radius: 20px;
            /* roundness of the scroll thumb */
            border: 3px solid rgb(249 250 251);
            /* creates padding around scroll thumb */
        }
    </style>
</head>

<body>
    <?php
    session_start();
    include('../backend/conexao.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $conexao->prepare("SELECT * FROM Usuario WHERE loginUsuario = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $usuario = $result->fetch_assoc();

            if (password_verify($password, $usuario['senha'])) {
                $_SESSION['usuario_id'] = $usuario['idPessoa'];
                $_SESSION['usuario_email'] = $usuario['loginUsuario'];
                $_SESSION['is_admin'] = ($usuario['loginUsuario'] === 'administradorchrysalis@gmail.com');

                if ($_SESSION['is_admin']) {
                    header("Location: admin_page.php");
                } else {
                    header("Location: index.php");
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
        <section class="flex justify-center items-center min-h-screen p-4 bg-gray-50">
            <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-6">
                <h1 class="text-2xl font-bold  text-gray-900 mb-4">Entrar</h1>
                <p class="text-sm text-gray-500 mb-4">
                    Ainda não possui login? 
                    <a href="cadastro.php" class="text-orange-500 hover:underline">Cadastre-se</a>
                </p>

                <?php if (isset($erro)): ?>
                    <div class="mb-4 text-red-500 text-center">
                        <?php echo htmlspecialchars($erro); ?>
                    </div>
                <?php endif; ?>

                <form action="" method="POST" class="space-y-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-900">E-mail</label>
                        <input type="email" name="email" id="email" placeholder="exemplo@gmail.com"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 w-full p-2.5"
                            required>
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-900">Senha</label>
                        <input type="password" name="password" id="password" placeholder="••••••••"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 w-full p-2.5"
                            required>
                    </div>
                    <button type="submit"
                        class="w-full bg-orange-500 text-white font-medium rounded-lg text-sm px-5 py-2.5 hover:bg-orange-700 focus:ring-2 focus:ring-orange-500 transition">
                        Entrar
                    </button>
                </form>
            </div>
        </section>
    </main>

    <?php include("footer.php"); ?>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</body>

</html>
