<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <title>Chrysalis - Entrar como cliente</title>
</head>

<body>
    <?php
    include('../backend/conexao.php');
    ?>
    <?php
    include('header.php');
    ?>
    <main>
        <section class="flex justify-center p-4 bg-gray-50">
            <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0" style="width: 50%">
                <div
                    class="w-dvw bg-white rounded-lg md:mt-0 sm:max-w-md xl:p-0 transition-all shadow">
                    <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                        <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                            Entrar como cliente
                        </h1>
                        <p class="text-sm font-light text-gray-500">
                            Ainda não possui login? <a href="cadastro.php"
                                class="font-medium text-orange-500 hover:underline">Entrar</a>
                        </p>
                        <form class="space-y-4 md:space-y-6" action="#">
                            <div>
                                <label for="email"
                                    class="block mb-2 text-sm font-medium text-gray-900">E-mail</label>
                                <input type="email" name="email" id="email" placeholder="exemplo@gmail.com"
                                    class="bg-gray-50 border transition-all focus:scale-105 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 hover:bg-white"
                                    required>
                            </div>
                            <div>
                                <label for="password"
                                    class="block mb-2 text-sm font-medium text-gray-900">Senha</label>
                                <input type="password" name="password" id="password"
                                    placeholder="••••••••"
                                    class="bg-gray-50 border transition-all focus:scale-105 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 hover:bg-white"
                                    required>
                            </div>
                            <div class="flex items-start">
                                <div class="flex items-center h-5 transition-all focus:scale-105 ">
                                    <input id="terms" aria-describedby="terms" type="checkbox"
                                        class="w-4 h-4 border transition-all border-gray-300 rounded bg-gray-50 checked:bg-orange-500 focus:ring-3 focus:ring-orange-500"
                                        required>
                                </div>

                                <div class="ml-3 text-sm">
                                    <label for="terms" class="font-light text-gray-500">Eu aceito os <a
                                            class="font-medium text-orange-500 hover:underline"
                                            href="">Termos e Condições</a></label>
                                </div>
                            </div>
                            <button type="submit"
                                class="w-full text-white bg-orange-500 focus:ring-2 focus:outline-none focus:ring-orange-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center hover:bg-orange-500 transition-all hover:scale-105">Criar conta</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php
    include("footer.php");
    ?>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</body>

</html>