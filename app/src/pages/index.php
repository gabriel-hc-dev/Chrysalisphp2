<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../styles/butterfly.css">
    <link rel="icon" type="image/x-icon" href="../../public/assets/images/White_Butterfly.png">
    <title>Chrysalis - Sua Loja Preferida</title>
</head>

<body>
    <?php
    include('header.php'); // Inclui o cabeçalho para usuários comuns
    ?>
    <main>
        <div id="alerts" class="text-white mx-auto text-center py-4 w-vw" style="background-color: rgb(24, 24, 24);">
            <span class="mx-4 transition-all hover:scale-125 text-nowrap">DESCONTOS IMPERDÍVEIS</span>
            <span class="mx-4 transition-all hover:scale-125 text-nowrap">ROUPAS DE QUALIDADE</span>
        </div>
        <?php
        include('carousel.php');
        ?>

        <div class="container mx-auto">
            <h2 class="text-5xl mt-16 mb-8 ml-8 font-semibold cursor-default"><span class="text-black transition-all hover:text-yellow-600">Nossos Produtos</span></h2>
        </div>
        <section class="container mx-auto px-8 my-4">
            <section class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <?php
                include('card.php');
                ?>
            </section>
        </section>
    </main>
    <?php
    include("footer.php");
    ?>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</body>

</html>
