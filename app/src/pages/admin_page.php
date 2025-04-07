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

<body>
    <?php
    session_start();
    if (!isset($_SESSION['usuario_id']) || !$_SESSION['is_admin']) {
        header("Location: index.php"); // Redireciona para uma página de erro se não for admin
        exit();
    }
    ?>

    <body>
        <?php
        include('../../admin/headerAdmin.php');
        ?>
        <main>
            <div id="alerts" class="text-white mx-auto text-center py-3 font-semibold"
                style="background-color: rgb(24, 24, 24);">
                <span class="mx-4 font-normal">PÁGINA PARA ADMINISTRADORES</span>
            </div>
            <div class="text-xl font-extralight text-justify pb-10">
                <p class="w-full bg-white rounded-lg p-6 text-gray-700 leading-relaxed">
                    <span class="font-semibold text-gray-900">Bem-vindo à página de administração!</span>
                    <br>
                    Aqui você, como administrador, tem acesso às ferramentas necessárias para gerenciar os produtos do
                    site.
                    <br><br> 
                    <span class="font-semibold"><b class="font-medium text-orange-600"><u>Nesta área, é possível:</u></b></span>
                    <br>
                    <span class="font-semibold">Adicionar
                            produtos:</span> Cadastre novos itens para serem exibidos na loja.
                    <br>
                    <span class="font-semibold">Visualizar
                    produtos:</span> Consulte a lista de produtos já cadastrados, verificando as informações deles.
                    <br>
                    <span class="font-semibold">Editar
                    produtos:</span> atualize detalhes dos produtos sempre que necessário.
                    <br>
                    <span class="font-semibold">Excluir
                    produtos:</span> remova itens que não estarão mais disponíveis para os usuários.
                    <br><br>
                    Utilize essas funcionalidades com responsabilidade para manter o site sempre organizado e
                    atualizado.
            </div>
            </div>
        </main>
        <?php include("footer.php"); ?>
    </body>

</html>