<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../styles/butterfly.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link rel="icon" type="image/x-icon" href="../../public/assets/images/White_Butterfly.png">
    <title>Chrysalis - Sua Loja Preferida</title>
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

<body class="overflow-x-hidden bg-gray-50">
    <?php
    include('header.php');
    include('../backend/conexao.php');
    ?>
    <main>
        <!--Texto de Sobre Nós-->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-semibold mt-14 text-center">Sobre Nós</h1>
            <div class="w-44 h-1 bg-orange-400 mx-auto"></div>
        </div>
        <section class="px-4 md:px-16">
            <div class="max-w-7xl mx-auto">
                <div class="text-xl font-extralight text-justify pb-10">
                    <p class="w-full bg-white rounded-lg p-6 text-gray-700 leading-relaxed">
                        <span class="font-semibold text-gray-900">Na <b class="font-medium text-orange-600">Chrysalis</b>, acreditamos que <u class="text-gray-900">a moda vai muito além do ato de se vestir</u>.</span><br> Para
                        nós,
                        cada peça de roupa é uma expressão de personalidade, uma extensão da alma e um meio de
                        transformação. Aqui, oferecemos uma experiência única de moda, onde estilo, qualidade e
                        acessibilidade caminham juntos.
                        <br><br>
                        <span class="block mt-4 font-semibold text-gray-900">Nosso compromisso é <u class="text-orange-600">democratizar a moda</u>, tornando-a acessível para todos os
                            públicos.</span> Acreditamos que o direito de se expressar por meio da moda deve estar ao
                        alcance de todos, sem abrir mão de qualidade ou estilo.
                        <br><br>
                        <span class="block mt-4 font-semibold text-gray-900">Cada coleção é cuidadosamente elaborada com
                            <u class="text-orange-600">materiais de alta qualidade. </u></span> Com atenção aos mínimos
                        detalhes para garantir que você tenha em mãos peças duráveis, confortáveis e sempre em sintonia
                        com as tendências mais atuais. Além disso, buscamos sempre oferecer preços justos, pois
                        acreditamos que estilo não deve ser um privilégio.
                        <br><br>
                        <span class="block mt-4 font-semibold text-gray-900">Na <b class="text-orange-600 font-medium">Chrysalis</b>, você encontrará muito mais do que
                            roupas;
                            encontrará uma nova forma de se conectar com quem você realmente é.</span> Estamos aqui para
                        te inspirar e celebrar a moda em sua forma mais inclusiva e autêntica. Seja bem-vindo à <b class="text-orange-600 font-normal">Chrysalis</b>, onde cada transformação é <u class="text-orange-600 font-normal">única</u>!
                    </p>
                </div>
            </div>
        </section>
        
        <section class="mt-8 aos-init aos-animate" data-aos="zoom-in">
            <!-- Missão com linha decorativa -->
            <div class="text-center mb-4">
                <h2 class="text-3xl font-semibold text-gray-800">Missão</h2>
                <div class="w-24 h-1 bg-orange-400 mx-auto"></div>
            </div>
            <!-- Texto MISSÃO -->
            <div class="max-w-7xl mx-auto mb-8 flex justify-center items-center ">
                <p class="text-center bg-white shadow-sm p-4 rounded-lg text-justify text-xl">Democratizar a
                    indústria da moda em todo o país, através, principalmente, do e-commerce têxtil.</p>
            </div>

            <!-- Visão com linha decorativa -->
            <div class="text-center mb-4">
                <h2 class="text-3xl font-semibold text-gray-800">Visão</h2>
                <div class="w-24 h-1 bg-orange-400 mx-auto"></div>
            </div>
            <!-- Texto VISÃO -->
            <div class="max-w-7xl mx-auto mb-8 flex justify-center items-center ">
                <p class="text-center bg-white p-4 rounded-lg shadow-sm text-justify text-xl">Alcançar todo o
                    mercado nacional e levar nosso legado acessível à toda
                    população, independente da classe.</p>
            </div>

            <!-- Valores com linha decorativa -->
            <div class="text-center mb-4">
                <h2 class="text-3xl font-semibold text-gray-800">Valores</h2>
                <div class="w-24 h-1 bg-orange-400 mx-auto"></div>
            </div>
            <!-- Texto VALORES -->
            <div class="max-w-7xl mx-auto mb-8 flex justify-center items-center ">
                <p class="text-center bg-white p-4 rounded-lg shadow-sm text-justify text-xl">Liberdade,
                    Democracia, Gentileza, Paciência, Cooperação e Amizade.</p>
            </div>
        </section>
    </main>
    <?php
    include('footer.php');
    ?>
    <script>
        AOS.init();
    </script>
</body>

</html>
