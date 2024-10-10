<link rel="stylesheet" href="../styles/butterfly.css">
<header class="bg-orange-400">
    <nav class="border-gray-200 bg-orange-400">
        <div class="max-w-screen-xl grid grid-cols-1 lg:grid-cols-2 items-center mx-auto p-4 gap-4 bg-orange-400">
            <!-- Logo Section -->
            <div class="flex items-center space-x-3 rtl:space-x-reverse lg:col-span-1">
                <a href="../../src/pages/index.php" class="flex items-center space-x-3 rtl:space-x-reverse transition-all">
                    <img id="butterfly_img" src="../../public/assets/images/White_Butterfly.png" class="h-8"
                        alt="Chrysalis Logo Borboleta" />
                </a>
                <a href="../../src/pages/index.php" class="flex items-center space-x-3 rtl:space-x-reverse transition-all hover:scale-105">
                    <img src="../../public/assets/images/White_Chrysalis.png" class="h-8" alt="Chrysalis Logo Texto" />
                </a>
            </div>

            <!-- Menu Button for Small Screens -->
            <button data-collapse-toggle="navbar-default" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-700 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 lg:col-span-1"
                aria-controls="navbar-default" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>

            <!-- Menu Section -->
            <div class="hidden w-full md:block md:w-auto bg-orange-400 float-left"
                id="navbar-default">
                <ul class="bg-orange-400 font-medium flex flex-col justify-end flex p-4 md:p-0 mt-4 border border-gray-100 rounded-lg md:flex-row md:space-x-8 md:mt-0 md:border-0 bg-orange-400">
    
                    <li>
                        <a href="read.php"
                            class="block py-2 px-3 rounded md:hover:bg-transparent md:border-0 md:p-0 d: text-white hover:underline hover:scale-125 active:scale-150 transition-all duration-300">Listar</a>
                    </li>
                    <li>
                        <a href="create.php"
                            class="block py-2 px-3 rounded md:hover:bg-transparent md:border-0 md:p-0 text-white hover:underline hover:scale-125 active:scale-150 transition-all duration-300">Cadastrar</a>
                    </li>
                    <li>
                        <a href="login.php"
                            class="block py-2 px-3 rounded md:hover:bg-transparent md:border-0 md:p-0 hover:scale-125 transition-all"><img
                                src="../../public/assets/images/icons/account.svg" alt="Perfil"
                                style="filter: invert(100%)"></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>