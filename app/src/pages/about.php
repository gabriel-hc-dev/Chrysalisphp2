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

<body class="overflow-x-hidden">
    <?php
    include('../backend/conexao.php');
    include('header.php');
    ?>
    <main class="container mx-auto h-dvh w-dvw text-pretty ">
        <div class="container mx-auto">
            <h2 class="text-5xl mt-16 mb-8 ml-6 font-semibold cursor-default"><span class="text-black transition-all hover:text-yellow-600">Sobre nós</span></h2>
        </div>
        
    </main>
    <?php
    include("footer.php");
    ?>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</body>

</html>