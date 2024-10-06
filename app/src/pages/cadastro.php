<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <title>Cadastro</title>
</head>

<body>
    <?php
    include('../backend/conexao.php');
    ?>
    <?php
    include('header.php');
    ?>
    <main>
        <section class="flex justify-center p-4">
            <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0" style="width: 50%">
                <div
                    class="w-dvw bg-white rounded-lg shadow  md:mt-0 sm:max-w-md xl:p-0">
                    <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                        <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                            Cadastro de Usuário
                        </h1>
                        <p class="text-sm font-light text-gray-500">
                            Já tem uma conta? <a href="#"
                                class="font-medium text-orange-600 hover:underline">Cadastrar</a>
                        </p>
                        <form class="space-y-4 md:space-y-6" action="#">
                            <div>
                                <label for="nome"
                                    class="block mb-2 text-sm font-medium text-gray-900">Nome</label>
                                <input type="text" name="nome" id="nome"
                                    class="bg-gray-50 border transition-all focus:scale-105 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-600 focus:border-orange-600 block w-full p-2.5"
                                    placeholder="Ex.: João Cunha" required>
                            </div>
                            <div>
                                <label for="telefone"
                                    class="block mb-2 text-sm font-medium text-gray-900">Telefone</label>
                                <input type="text" maxlength="14" name="telefone" id="telefone"
                                    class="bg-gray-50 border transition-all focus:scale-105 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-600 focus:border-orange-600 block w-full p-2.5"
                                    placeholder="(00) 00000-0000" oninput="formatarTelefone(this)" onkeydown="ajustarBackspace(event, this)" required>
                            </div>
                            <div>
                                <label for="cep"
                                    class="block mb-2 text-sm font-medium text-gray-900">CEP</label>
                                <input type="text" name="cep" id="cep"
                                    class="bg-gray-50 border transition-all focus:scale-105 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-600 focus:border-orange-600 block w-full p-2.5"
                                    placeholder="00000-000" pattern="\d{5}-\d{3}" required>
                            </div>
                            <div>
                                <label for="email"
                                    class="block mb-2 text-sm font-medium text-gray-900">E-mail</label>
                                <input type="email" name="email" id="email" placeholder="exemplo@gmail.com"
                                    class="bg-gray-50 border transition-all focus:scale-105 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-600 focus:border-orange-600 block w-full p-2.5"
                                    required>
                            </div>
                            <div>
                                <label for="password"
                                    class="block mb-2 text-sm font-medium text-gray-900">Senha</label>
                                <input type="password" name="password" id="password"
                                    placeholder="••••••••"
                                    class="bg-gray-50 border transition-all focus:scale-105 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-600 focus:border-orange-600 block w-full p-2.5"
                                    required>
                            </div>
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="terms" aria-describedby="terms" type="checkbox"
                                        class="w-4 h-4 border transition-all focus:scale-105 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-orange-600"
                                        required>
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="terms" class="font-light text-gray-500">Eu aceito os <a
                                            class="font-medium text-orange-600 hover:underline0"
                                            href="">Termos e Condições</a></label>
                                </div>
                            </div>
                            <button type="submit"
                                class="w-full text-white bg-orange-500 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center hover:bg-orange-600 transition-all ">Criar
                                conta</button>
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
    <script>
        function formatarTelefone(input) {
            // Remove todos os caracteres que não são dígitos
            let numero = input.value.replace(/\D/g, '');

            // Formata o valor no padrão (00)00000-0000
            if (numero.length <= 10) {
                numero = numero.replace(/^(\d{2})(\d{4})(\d{0,4})/, "($1)$2-$3");
            } else {
                numero = numero.replace(/^(\d{2})(\d{5})(\d{0,4})/, "($1)$2-$3");
            }

            input.value = numero;
        }

        function ajustarBackspace(event, input) {
            const cursorPos = input.selectionStart;
            const valor = input.value;

            // Detecta se a tecla pressionada é o Backspace
            if (event.key === 'Backspace' && cursorPos > 0) {
                // Se o caractere antes do cursor for um separador, move o cursor para trás e apaga o caractere anterior
                if (valor[cursorPos - 1] === '-' || valor[cursorPos - 1] === ')' || valor[cursorPos - 1] === '(') {
                    event.preventDefault(); // Impede o comportamento padrão do backspace
                    input.setSelectionRange(cursorPos - 1, cursorPos - 1); // Move o cursor para a esquerda

                    // Remove o caractere anterior ao separador
                    input.value = valor.slice(0, cursorPos - 2) + valor.slice(cursorPos - 1);
                    input.setSelectionRange(cursorPos - 2, cursorPos - 2); // Ajusta o cursor para a posição correta
                }
            }
        }
    </script>
</body>

</html>