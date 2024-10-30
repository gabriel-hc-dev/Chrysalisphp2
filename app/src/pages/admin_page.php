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
    session_start();
    if (!isset($_SESSION['usuario_id']) || !$_SESSION['is_admin']) {
        header("Location: error.php"); // Redireciona para uma página de erro se não for admin
        exit();
    }
    ?>

    <body>
        <?php
        include('../../admin/headerAdmin.php');
        ?>
        <main>
            <div id="alerts" class="text-white mx-auto text-center py-3 font-semibold" style="background-color: rgb(24, 24, 24);">
                <span class="mx-4 font-normal">PÁGINA PARA ADMINISTRADORES</span>
            </div>
        </main>
        <?php include("footer.php"); ?>
    </body>

    </html>