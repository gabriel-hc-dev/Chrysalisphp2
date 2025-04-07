<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link rel="stylesheet" href="../styles/butterfly.css">
    <link rel="icon" type="image/x-icon" href="../../public/assets/images/White_Butterfly.png">
    <title>Chrysalis - Sua Loja Preferida</title>
    <style>
        body::-webkit-scrollbar {
            width: 10px;
            /* width of the entire scrollbar */
        }

        body::-webkit-scrollbar-track {
            background-color: rgb(249, 250, 251);
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
        #backToTop {
            background-color: rgb(249, 115, 22);
        }
        #backToTop:hover {
            background-color: rgb(234, 88, 12);
        }
    </style>
</head>

<body>
    <?php
    include('header.php'); // Inclui o cabeçalho para usuários comuns
    ?>
    <main>

        <?php
        include('carousel.php');
        ?>

        <div class="container mx-auto">
            <h2 class="text-4xl mt-16 mb-8 mx-16 font-semibold cursor-default"><span
                    class="text-black transition-all hover:text-yellow-600">Nossos Produtos</span></h2>
        </div>
        <section class="container mx-auto px-16 my-4 aos-init aos-animate" data-aos="zoom-in">
            <section class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <?php
                include('card.php');
                ?>
            </section>
        </section>
        <button id="backToTop"
            class="animate-bounce fixed bottom-5 right-5 text-white p-3 rounded-full shadow-l transition-colors ease-in-out duration-300 opacity-0 pointer-events-none">
            <img src="../../public/assets/images/icons/arrow-up.svg" class="invert">
        </button>


    </main>
    <?php
    include("footer.php");
    ?>
    <script>
        const backToTopButton = document.getElementById("backToTop");

        // Exibe o botão quando a página é rolada
        window.addEventListener("scroll", () => {
            if (window.scrollY > 300) {
                backToTopButton.classList.add("opacity-100", "pointer-events-auto");
                backToTopButton.classList.remove("opacity-0", "pointer-events-none");
            } else {
                backToTopButton.classList.add("opacity-0", "pointer-events-none");
                backToTopButton.classList.remove("opacity-100", "pointer-events-auto");
            }
        });

        // Rola para o topo da página ao clicar no botão
        backToTopButton.addEventListener("click", () => {
            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });
        });
    </script>
    <script>
        AOS.init();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>

</body>

</html>