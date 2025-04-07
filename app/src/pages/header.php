<head>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
</head>

<?php
include_once('../backend/conexao.php');
if (!isset($_SESSION)) {
    session_start();
}
?>
<header>
    <nav class="border-gray-200 bg-stone-800">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto py-2 px-4">
            <!-- Botão do Menu para Telas Pequenas -->
            <button id="menuToggle" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm rounded-lg lg:hidden text-white hover:bg-zinc-800 ease-in-out duration-300 focus:ring-2 focus:ring-stone-700"
                aria-controls="navbar-default" aria-expanded="false">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>

            <!-- Seção do Logo -->
            <div id="logoSection" class="flex items-center space-x-3 transition-opacity duration-300">
                <a href="index.php">
                    <img id="butterfly_img" src="../../public/assets/images/White_Butterfly.png" class="h-8"
                        alt="Logo Borboleta" />
                </a>
                <a href="index.php" class="flex items-center hover:scale-105 transition duration-300">
                    <img src="../../public/assets/images/White_Chrysalis.png" class="h-8" alt="Logo Texto" />
                </a>
            </div>

            <!-- Menu Responsivo -->
            <div id="navbar-default" class="hidden w-full lg:flex lg:items-center lg:w-auto lg:justify-end">
                <ul
                    class="font-medium flex flex-col lg:flex-row lg:space-x-6 mt-4 lg:mt-0 items-center justify-center text-center">
                    <li>
                        <a href="index.php"
                            class="block text-xl py-2 px-3 rounded hover:text-amber-400 lg:hover:bg-transparent text-white hover:underline active:text-orange-400 transition ease-in-out duration-300">Início</a>
                    </li>
                    <li>
                        <a href="about.php"
                            class="block text-xl py-2 px-3 rounded hover:text-amber-400 lg:hover:bg-transparent text-white hover:underline active:text-orange-400 transition ease-in-out duration-300">Sobre</a>
                    </li>
                    <li>
                        <a href="carrinho.php"
                            class="block py-2 px-3 rounded lg:hover:bg-transparent text-white hover:scale-125 active:scale-150 transition duration-300">
                            <img src="../../public/assets/images/icons/cart.svg" alt="Carrinho" class="invert" />
                        </a>
                    </li>
                    <li>
                        <img class="block py-2 px-3 rounded lg:hover:bg-transparent text-white hover:scale-125 active:scale-150 transition duration-300 invert cursor-pointer"
                            src="../../public/assets/images/icons/account.svg" alt="Perfil" onclick="toggleModal()" />
                    </li>
                    <!-- Modal -->
                    <div id="userModal" class="hidden overflow-y-auto fixed inset-0 z-50" aria-labelledby="modal-title"
                        role="dialog" aria-modal="true">
                        <div class="flex items-center justify-center min-h-screen">
                            <!-- Fundo escuro -->
                            <div class="fixed inset-0 bg-black opacity-30"></div>

                            <!-- Conteúdo do Modal -->
                            <div
                                class="bg-white rounded-lg shadow-lg w-11/12 max-w-lg sm:w-3/4 md:w-2/3 lg:w-1/3 p-6 z-10">
                                <div class="p-6 text-center">
                                    <h3 class="mb-5 text-lg font-semibold text-gray-700 dark:text-gray-400">
                                        Configurações do Usuário
                                    </h3>

                                    <!-- Condicional: Se estiver logado -->
                                    <?php if (isset($_SESSION['usuario_email'])): ?>
                                        <p class="font-medium text-gray-600">Você está logado como:</p>
                                        <p class="mb-4 text-gray-800">
                                            E-mail: <span class="font-semibold"
                                                id="userEmail"><?= $_SESSION['usuario_email']; ?></span>
                                        </p>

                                        <!-- Botões para usuário logado -->
                                        <div class="flex flex-wrap space-y-2 sm:space-y-0 sm:space-x-4 justify-center mt-4">
                                            <button type="button" id="closeModal"
                                                class="text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm py-2 px-6 transition-all"
                                                onclick="toggleModal()">
                                                Fechar
                                            </button>
                                            <a href="logout.php"
                                                class="text-red-700 bg-red-100 hover:bg-red-200 hover:text-red-800 rounded-lg text-sm py-2 px-6 transition-all">
                                                Sair
                                            </a>
                                        </div>

                                    <?php else: ?>
                                        <!-- Caso não esteja logado -->
                                        <p class="mb-4 font-medium text-gray-600">Você não está logado.</p>

                                        <!-- Botões para usuário não logado -->
                                        <div class="flex flex-wrap space-y-2 sm:space-y-0 sm:space-x-4 justify-center mt-4">
                                            <button type="button" id="closeModal"
                                                class="text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm py-2 px-6 transition-all"
                                                onclick="toggleModal()">
                                                Fechar
                                            </button>
                                            <a href="login.php"
                                                class="text-orange-700 bg-orange-100 hover:bg-orange-200 hover:text-orange-800 rounded-lg text-sm py-2 px-6 transition-all">
                                                Login
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal End -->
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<script defer>
    const menuToggle = document.getElementById("menuToggle");
    const navbar = document.getElementById("navbar-default");
    const logoSection = document.getElementById("logoSection");

    // Controla a visibilidade do menu e do logo
    menuToggle.addEventListener("click", () => {
        navbar.classList.toggle("hidden");

        if (!navbar.classList.contains("hidden")) {
            logoSection.classList.add("opacity-0");
        } else {
            logoSection.classList.remove("opacity-0");
        }
    });

    // Restaura o logo quando a janela é redimensionada
    window.addEventListener("resize", () => {
        if (window.innerWidth >= 1024) {
            navbar.classList.add("hidden");
            logoSection.classList.remove("opacity-0");
        }
    });

    function toggleModal() {
        const modal = document.getElementById("userModal");
        modal.classList.toggle("hidden");
    }
</script>