<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../styles/butterfly.css">
    <link rel="icon" type="image/x-icon" href="../../public/assets/images/White_Butterfly.png">
    <title>Chrysalis - Carrinho</title>

</head>
<?php
include('header.php');
include('../backend/conexao.php');
?>

<body class="bg-gray-50">
    <!-- Container Principal -->
    <div class="container mx-auto p-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Seção do Carrinho de Produtos -->
            <div class="md:col-span-2 bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-2xl font-semibold mb-4">Meu carrinho</h2>
                <div class="space-y-4">

                    <!-- Item do Produto 1 -->
                    <div class="flex items-center justify-between border-b pb-4">
                        <div class="flex items-center">
                            <img src="https://via.placeholder.com/100" alt="Produto" class="w-16 h-16 rounded-md">
                            <div class="ml-4">
                                <p class="text-lg font-semibold">Nome do produto</p>
                                <p class="text-gray-500">R$49,90</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <button class="px-2 py-1 bg-orange-500 text-white rounded-lg">-</button>
                            <span class="mx-2 text-lg">1</span>
                            <button class="px-2 py-1 bg-orange-500 text-white rounded-lg">+</button>
                        </div>
                    </div>

                    <!-- Item do Produto 2 -->
                    <div class="flex items-center justify-between border-b pb-4">
                        <div class="flex items-center">
                            <img src="https://via.placeholder.com/100" alt="Produto" class="w-16 h-16 rounded-md">
                            <div class="ml-4">
                                <p class="text-lg font-semibold">Nome do produto</p>
                                <p class="text-gray-500">R$49,90</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <button class="px-2 py-1 bg-orange-500 text-white rounded-lg">-</button>
                            <span class="mx-2 text-lg">1</span>
                            <button class="px-2 py-1 bg-orange-500 text-white rounded-lg">+</button>
                        </div>
                    </div>

                    <!-- Item do Produto 3 -->
                    <div class="flex items-center justify-between border-b pb-4">
                        <div class="flex items-center">
                            <img src="https://via.placeholder.com/100" alt="Produto" class="w-16 h-16 rounded-md">
                            <div class="ml-4">
                                <p class="text-lg font-semibold">Nome do produto</p>
                                <p class="text-gray-500">R$49,90</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <button class="px-2 py-1 bg-orange-500 text-white rounded-lg">-</button>
                            <span class="mx-2 text-lg">1</span>
                            <button class="px-2 py-1 bg-orange-500 text-white rounded-lg">+</button>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Resumo do Pedido -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-4">Resumo do Carrinho</h2>
                <div class="flex justify-between mb-2">
                    <span>Itens (4)</span>
                    <span>R$ 199,60</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span>Desconto</span>
                    <span>-</span>
                </div>
                <hr class="my-2">
                <div class="flex justify-between font-bold text-lg">
                    <span>Valor Total</span>
                    <span>R$ 199,60</span>
                </div>
                <button class="mt-4 w-full bg-orange-500 text-white py-2 rounded-lg hover:bg-orange-600">
                    Finalizar Compra
                </button>
            </div>

        </div>
    </div>
</body>
<?php
include('footer.php');
?>

</body>

</html>