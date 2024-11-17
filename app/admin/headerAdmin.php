<link rel="stylesheet" href="../styles/butterfly.css">
<header class="bg-orange-400">
    <nav class="border-gray-200 bg-orange-400">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4 gap-4">
            <!-- Botão Menu Hambúrguer -->
            <button data-collapse-toggle="navbar-default" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm rounded-lg lg:hidden hover:bg-gray-700 ease-in-out duration-300 invert focus:outline-none focus:ring-2 focus:ring-black"
                aria-controls="navbar-default" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>

            <!-- Logo -->
            <div class="flex items-center space-x-3">
                <a href="../../src/pages/admin_page.php" class="flex items-center">
                    <img id="butterfly_img" src="../../public/assets/images/White_Butterfly.png" class="h-8"
                        alt="Logo Borboleta" />
                </a>
                <a href="../../src/pages/admin_page.php" class="flex items-center hover:scale-105 transition-transform">
                    <img src="../../public/assets/images/White_Chrysalis.png" class="h-8" alt="Logo Texto" />
                </a>
            </div>

            <!-- Menu Responsivo -->
            <div class="hidden w-full lg:block md:w-auto" id="navbar-default">
                <ul class="font-medium flex flex-col lg:flex-row lg:space-x-8 mt-4 lg:mt-0">
                    <li>
                        <a href="../../admin/CRUD/read.php"
                            class="block py-2 px-3 rounded lg:hover:bg-transparent text-white hover:underline hover:scale-125 active:scale-150 transition-transform duration-300">Listar</a>
                    </li>
                    <li>
                        <a href="../../admin/CRUD/create.php"
                            class="block py-2 px-3 rounded lg:hover:bg-transparent text-white hover:underline hover:scale-125 active:scale-150 transition-transform duration-300">Cadastrar</a>
                    </li>
                    <div>
                            <img class="block py-2 px-3 rounded cursor-pointer hover:scale-125 transition-transform invert"
                                src="../../public/assets/images/icons/account.svg" alt="Perfil"
                                onclick="toggleModal()" />
                        </div>
                        <!-- Modal -->
                        <div id="userModal" class="hidden overflow-y-auto fixed inset-0 z-50"
                            aria-labelledby="modal-title" role="dialog" aria-modal="true">
                            <div class="flex items-center justify-center min-h-screen">
                                <div class="fixed inset-0 bg-black opacity-30"></div>
                                <div class="bg-white rounded-lg shadow-lg w-1/3 p-6 z-10">
                                    <div class="p-6 text-center">
                                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                                            Configurações do Usuário</h3>

                                        <!-- Condicional: Se estiver logado -->
                                        <?php if (isset($_SESSION['usuario_email'])): ?>
                                            <p class="font-semibold">Você está logado como:</p>
                                            <p>E-mail: <span class="font-semibold"
                                                    id="userEmail"><?= $_SESSION['usuario_email']; ?></span></p>

                                            <!-- Botões para usuário logado -->
                                            <div class="flex space-x-4 justify-center items-center mt-2">
                                                <button type="button" id="closeModal"
                                                    class="text-gray-700 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm py-2.5 px-6 inline-flex items-center mt-2 transition-all"
                                                    onclick="toggleModal()">
                                                    Fechar
                                                </button>
                                                <a href="logout.php"
                                                    class="text-red-700 bg-transparent hover:bg-red-200 hover:text-red-800 hover:underline rounded-lg text-sm py-2.5 px-6 inline-flex items-center mt-2 transition-all">
                                                    Sair
                                                </a>
                                            </div>

                                            <!-- Condicional: Se não estiver logado -->
                                        <?php else: ?>
                                            <p class="font-semibold text-gray-500">Você não está logado.</p>

                                            <!-- Botões para usuário não logado -->
                                            <div class="flex space-x-4 justify-center items-center mt-2">
                                                <button type="button" id="closeModal"
                                                    class="text-gray-700 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm py-2.5 px-6 inline-flex items-center mt-2 transition-all"
                                                    onclick="toggleModal()">
                                                    Fechar
                                                </button>
                                                <a href="login.php"
                                                    class="text-green-700 bg-transparent hover:bg-green-200 hover:text-green-800 hover:underline rounded-lg text-sm py-2.5 px-6 inline-flex items-center mt-2 transition-all">
                                                    Login
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                </ul>
            </div>
        </div>
    </nav>
</header>

<script defer>
    document.addEventListener("DOMContentLoaded", () => {
        const toggleButton = document.querySelector('[data-collapse-toggle="navbar-default"]');
        const menu = document.getElementById("navbar-default");

        if (toggleButton && menu) {
            toggleButton.addEventListener("click", () => {
                menu.classList.toggle("hidden");
            });
        }
    });
    function toggleModal() {
        const modal = document.getElementById("userModal");
        modal.classList.toggle("hidden");
    }
</script>

