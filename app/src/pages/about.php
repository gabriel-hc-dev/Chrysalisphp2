<!DOCTYPE html>
<html lang="pt-br">

<head>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/assets/images/White_Butterfly.png" type="image/x-icon">
    <link rel="icon" type="image/x-icon" href="../../public/assets/images/White_Butterfly.png">
    <title>Chrysalis - Sua loja preferida</title>
</head>
<?php
include("header.php");
?>

<body>
    <main class="mx-auto px-16">
        <!--Texto de Sobre Nós-->
        <h1 class="text-4xl font-semibold mt-14 mb-8">Sobre nós</h1>
        <div class="text-xl font-extralight text-justify">
            <p class="w-full bg-white border p-8 border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700"
                style="background-color: rgb(255, 251, 250);">
                Na <b class="font-medium">Chrysalis</b>, acreditamos que <u>a moda vai muito além do ato de se
                    vestir</u>.
                Para nós, cada peça de roupa é uma expressão de personalidade, uma extensão da alma e um meio de
                transformação. Aqui, oferecemos uma experiência única de moda, onde estilo, qualidade e acessibilidade
                caminham juntos.
                <br><br>
                Nosso compromisso é <u>democratizar a moda</u>, tornando-a acessível para todos os públicos.
                Acreditamos que o direito de se expressar por meio da moda deve estar ao alcance de todos,
                sem abrir mão de qualidade ou estilo.
                <br><br>
                Cada coleção é cuidadosamente elaborada com <u>materiais de alta qualidade</u>, com atenção aos mínimos
                detalhes para garantir que você tenha em mãos peças duráveis, confortáveis e sempre em sintonia com as
                tendências mais atuais. Além disso, buscamos sempre oferecer preços justos, pois acreditamos que estilo
                não deve ser um privilégio.
                <br><br>
                Na <b class="font-medium">Chrysalis</b>, você encontrará muito mais do que roupas; encontrará uma nova
                forma de se conectar com quem você realmente é. Estamos aqui para te inspirar e celebrar a moda
                em sua forma mais inclusiva e autêntica. Seja bem-vindo à <b class="font-medium">Chrysalis</b>,
                onde cada transformação é <u>única</u>!
            </p>
        </div>
        <!--Cards de Missão, Visão e Valores-->
        <div class="mx-auto py-8 px-6 mt-14 border rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700 mb-8"
            style="background-color: rgb(255, 251, 250);">
            <section class="container mx-auto">
                <section class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                    <div id="missao" class="w-full border p-8 border-gray-300 rounded-lg shadow duration-700">
                        <button id="missao-btn"
                            class="w-full text-3xl text-gray-900 font-semibold text-center">MISSÃO</button>
                        <div id="missao-content" class="hidden mt-4 text-justify card-content">
                            <p>Nossa missão é democratizar a indústria da moda em todo o país, através, principalmente,
                                do e-commerce têxtil.</p>
                        </div>
                    </div>

                    <div id="visao" class="w-full border p-8 border-gray-300 rounded-lg shadow duration-700">
                        <button id="visao-btn"
                            class="w-full text-3xl text-gray-900 font-semibold text-center">VISÃO</button>
                        <div id="visao-content" class="hidden mt-4 text-justify card-content">
                            <p>Nossa visão é alcançar todo o mercado nacional e levar nosso legado acessível à toda
                                população, independente da classe.</p>
                        </div>
                    </div>

                    <div id="valores" class="w-full border p-8 border-gray-300 rounded-lg shadow duration-700">
                        <button id="valores-btn"
                            class="w-full text-3xl text-gray-900 font-semibold text-center">VALORES</button>
                        <div id="valores-content" class="hidden mt-4 text-justify card-content">
                            <p>Nossos valores são: Liberdade, Democracia, Gentileza, Paciência, Cooperação e Amizade.
                            </p>
                        </div>
                    </div>
                </section>
            </section>
        </div>
    </main>
    <?php
    include("footer.php");
    ?>
    <script>
        // Função para fechar todos os conteúdos dos cards
        function closeAllContents() {
            const contents = document.querySelectorAll('.card-content');
            contents.forEach(content => {
                content.classList.add('hidden');
            });
        }

        // Função para alternar a exibição do conteúdo de um card
        function toggleContent(btnId, contentId) {
            const content = document.getElementById(contentId);
            if (content.classList.contains('hidden')) {
                closeAllContents();  // Fechar todos os conteúdos antes de abrir o novo
                content.classList.remove('hidden');  // Mostrar conteúdo
            } else {
                content.classList.add('hidden');  // Esconder conteúdo
            }
        }

        // Atribuindo os eventos de clique a cada botão
        document.getElementById('missao-btn').addEventListener('click', function () {
            toggleContent('missao-btn', 'missao-content');
        });

        document.getElementById('visao-btn').addEventListener('click', function () {
            toggleContent('visao-btn', 'visao-content');
        });

        document.getElementById('valores-btn').addEventListener('click', function () {
            toggleContent('valores-btn', 'valores-content');
        });

    </script>
</body>

</html>