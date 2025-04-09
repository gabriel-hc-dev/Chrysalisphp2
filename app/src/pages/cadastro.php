<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="../../public/assets/images/White_Butterfly.png" />
    <title>Chrysalis - Criar conta</title>
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
    <?php include('../backend/conexao.php'); ?> <?php include('header.php'); ?>

    <main>
        <section class="block min-h-screen justify-center bg-gray-50 p-4">
            <form class="mt-8 space-y-6 mx-6 my-4 bg-white px-10 py-16 rounded-lg shadow-lg" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <div class="block">
                    <h1 class="text-center text-2xl font-bold text-gray-900">Cadastro de Usuário</h1>
                    <p class="mt-2 text-center text-sm text-gray-500">Já tem uma conta? <a href="login.php" class="font-semibold text-black hover:underline">Entrar</a></p>
                </div>
                <!-- Informações Pessoais -->
                <div class="flex flex-col space-y-4 sm:flex-row sm:space-x-4 sm:space-y-0">
                    <div class="flex-1">
                        <label for="nome" class="block text-sm font-medium text-gray-900">Nome Completo</label>
                        <input type="text" name="nome" id="usuarioNome" class="bg-gray-50 border transition-all border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 hover:bg-white focus:my-1" placeholder="Ex.: João Cunha" required />
                    </div>
                    <div class="flex-1">
                        <label for="cpf" class="block text-sm font-medium text-gray-900">CPF</label>
                        <input type="text" name="cpf" id="cpf" class="bg-gray-50 border transition-all border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 hover:bg-white focus:my-1" placeholder="000.000.000-00" maxlength="14" required oninput="formatarCPF(this);buscarDadosPorCPF(this.value)" />
                    </div>
                </div>
                <!-- Contato -->
                <div class="flex flex-col space-y-4 sm:flex-row sm:space-x-4 sm:space-y-0">
                    <div class="flex-1">
                        <label for="telefone" class="block text-sm font-medium text-gray-900">Telefone</label>
                        <input type="text" name="telefone" id="telefone" maxlength="14" class="bg-gray-50 border transition-all border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 hover:bg-white focus:my-1" placeholder="(00) 00000-0000" oninput="formatarTelefone(this)" required />
                    </div>
                    <div class="flex-1">
                        <label for="email" class="block text-sm font-medium text-gray-900">E-mail</label>
                        <input type="email" name="email" id="email" class="bg-gray-50 border transition-all border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 hover:bg-white focus:my-1" placeholder="exemplo@gmail.com" required />
                    </div>
                </div>

                <!-- Endereço -->
                <div class="flex flex-col space-y-4 sm:flex-row sm:flex-wrap sm:space-x-4 sm:space-y-0">
                    <div>
                        <label for="cep" class="block text-sm font-medium text-gray-900">CEP</label>
                        <input type="text" name="cep" id="cep" maxlength="9"
                            class="bg-gray-50 border transition-all border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 hover:bg-white focus:my-1"
                            placeholder="00000-000" required onblur="buscarEndereco()">
                    </div>
                    <div class="flex-1">
                        <label for="rua" class="block text-sm font-medium text-gray-900">Rua</label>
                        <input type="text" name="rua" id="rua" class="bg-gray-50 border transition-all border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 hover:bg-white focus:my-1" placeholder="Ex.: Rua das Flores" required />
                    </div>
                    <div class="flex-1">
                        <label for="numero" class="block text-sm font-medium text-gray-900">Nº Res.</label>
                        <input type="text" name="numero" id="numero" class="bg-gray-50 border transition-all border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 hover:bg-white focus:my-1" placeholder="Ex.: 123" required />
                    </div>
                    <div class="flex-2">
                        <label for="bairro" class="block text-sm font-medium text-gray-900">Bairro</label>
                        <input type="text" name="bairro" id="bairro" class="bg-gray-50 border transition-all border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 hover:bg-white focus:my-1" placeholder="Ex.: Jardim Primavera" required />
                    </div>
                    <div class="flex-1">
                        <label for="cidade" class="block text-sm font-medium text-gray-900">Cidade</label>
                        <input type="text" name="cidade" id="cidade" class="bg-gray-50 border transition-all border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 hover:bg-white focus:my-1" placeholder="Ex.: São Paulo" required />
                    </div>
                    <div class="flex-1">
                        <label for="estado" class="block text-sm font-medium text-gray-900">Estado</label>
                        <input type="text" name="estado" id="estado" maxlength="2" class="bg-gray-50 border transition-all border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 hover:bg-white focus:my-1" placeholder="Ex.: SP" required />
                    </div>
                </div>

                <!-- Outras Informações -->
                <div class="flex flex-col space-y-4 sm:flex-row sm:space-x-4 sm:space-y-0">
                    <div class="flex-1">
                        <label for="dataNascimento" class="block text-sm font-medium text-gray-900">Data de Nascimento</label>
                        <input type="date" name="dataNascimento" id="dataNascimento" class="bg-gray-50 border transition-all border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 hover:bg-white focus:my-1" required />
                    </div>
                    <div class="flex-1">
                        <label for="sexo" class="block text-sm font-medium text-gray-900">Sexo</label>
                        <select name="sexo" id="sexo" class="bg-gray-50 border transition-all border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 hover:bg-white focus:my-1" required>
                            <option value="">Selecione seu gênero</option>
                            <option value="M">Masculino</option>
                            <option value="F">Feminino</option>
                            <option value="P">Outro/Prefiro não responder</option>
                        </select>
                    </div>
                </div>

                <!-- Login do Usuário -->
                <div class="flex flex-col space-y-4 sm:flex-row sm:space-x-4 sm:space-y-0">
                    <div class="flex-1">
                        <label for="password" class="block text-sm font-medium text-gray-900">Senha</label>
                        <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border transition-all border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 hover:bg-white focus:my-1" required />
                    </div>
                    <div class="flex-1">
                        <label for="confirmPassword" class="block text-sm font-medium text-gray-900">Confirmar Senha</label>
                        <input type="password" name="confirmPassword" id="confirmPassword" placeholder="••••••••" class="bg-gray-50 border transition-all border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 hover:bg-white focus:my-1" required />
                    </div>
                </div>
                <div class="flex items-center justify-center">
                    <div class="flex items-center h-5 transition-all focus:scale-105 ">
                        <input id="terms" aria-describedby="terms" type="checkbox"
                            class="w-4 h-4 border transition-all border-gray-300 rounded bg-gray-50 checked:bg-orange-500 focus:ring-3 focus:ring-orange-500"
                            required>
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="terms" class="font-light text-gray-500" required>Eu aceito os <a
                                class="font-medium text-orange-500 hover:underline" required
                                href="">Termos e Condições</a></label>
                    </div>
                </div>
                <div class="mt-6 flex items-center justify-center">
                    <button type="submit" class="w-1/2 text-white bg-orange-500 focus:ring-2 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center hover:bg-orange-600 transition-all hover:scale-105" onclick="window.open('login.php');">Cadastrar</button>
                </div>
            </form>
        </section>
    </main>

    <?php include('footer.php'); ?>
    <?php
    function cadastrarUsuario($data)
    {
        global $conexao; // Usando a conexão estabelecida
        $nome = $conexao->real_escape_string($data['nome']);
        $cpf = $conexao->real_escape_string($data['cpf']);
        $telefone = $conexao->real_escape_string($data['telefone']);
        $email = $conexao->real_escape_string($data['email']);
        $cep = $conexao->real_escape_string($data['cep']);
        $rua = $conexao->real_escape_string($data['rua']);
        $numero = $conexao->real_escape_string($data['numero']);
        $bairro = $conexao->real_escape_string($data['bairro']);
        $cidade = $conexao->real_escape_string($data['cidade']);
        $estado = $conexao->real_escape_string($data['estado']);
        $dataNascimento = $conexao->real_escape_string($data['dataNascimento']);
        $sexo = $conexao->real_escape_string($data['sexo']);
        $senha = password_hash($conexao->real_escape_string($data['password']), PASSWORD_BCRYPT); // Hashing da senha
        // Início da transação
        $conexao->begin_transaction();
        try {
            // Inserindo na tabela Endereco
            $queryEndereco = "INSERT INTO Endereco (cep, rua, bairro, estado, cidade) VALUES ('$cep', '$rua', '$bairro', '$estado', '$cidade')";
            if (!$conexao->query($queryEndereco)) {
                throw new Exception("Erro ao inserir endereço: " . $conexao->error);
            }

            // Inserindo na tabela Pessoa
            $queryPessoa = "INSERT INTO Pessoa (cpf, numResidencia, numTelefone, nome, cep, email, dataNascimento, sexo) 
                                VALUES ('$cpf', '$numero', '$telefone', '$nome', '$cep', '$email', '$dataNascimento', '$sexo')";
            if (!$conexao->query($queryPessoa)) {
                throw new Exception("Erro ao inserir pessoa: " . $conexao->error);
            }

            // Recuperar o id da última pessoa inserida
            $idPessoa = $conexao->insert_id;

            // Inserindo na tabela Usuario
            $queryUsuario = "INSERT INTO Usuario (loginUsuario, senha, idPessoa) 
                                VALUES ('$email', '$senha', $idPessoa)";
            if (!$conexao->query($queryUsuario)) {
                throw new Exception("Erro ao inserir usuário: " . $conexao->error);
            }

            // Commit da transação
            $conexao->commit();
            return true; // Cadastro realizado com sucesso
        } catch (Exception $e) {
            // Rollback da transação em caso de erro
            $conexao->rollback();
            echo $e->getMessage();
            return false; // Falha no cadastro
        }
    }
    // Para utilizar a função, você pode chamar assim, após o formulário ser enviado
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $result = cadastrarUsuario($_POST);
        if ($result) {
            // Redirecionar ou mostrar mensagem de sucesso
            echo "Usuário cadastrado com sucesso!
            <script>
                window.location.replace('login.php');
            </script>";
            header('Location:login.php');
        } else {
            // Mostrar mensagem de erro
            echo "Erro ao cadastrar usuário.";
        }
    }
    ?>
    <script>
        async function buscarEndereco() {
            const cep = document.getElementById("cep").value.replace(/\D/g, '');
            if (cep.length === 8) {
                try {
                    const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
                    if (!response.ok) throw new Error("Erro ao buscar o CEP");
                    const data = await response.json();
                    if (data.erro) throw new Error("CEP não encontrado");

                    document.getElementById("rua").value = data.logradouro;
                    document.getElementById("bairro").value = data.bairro;
                    document.getElementById("cidade").value = data.localidade;
                    document.getElementById("estado").value = data.uf;

                    console.log('Dados preenchidos via CEP')
                } catch (error) {
                    console.log("Erro: " + error.message);
                }
            } else {
                console.log('CEP INVÁLIDO')
            }
        }

        function formatarTelefone(telefone) {
            // Adicione a implementação da formatação aqui
        }

        // Verifica se as senhas coincidem
        document.querySelector('form').addEventListener('submit', function(event) {
            const password = document.getElementById("password").value;
            const confirmPassword = document.getElementById("confirmPassword").value;
            if (password !== confirmPassword) {
                event.preventDefault();
                alert("As senhas não coincidem.");
            }
        });

        function formatarCPF(input) {
            let numero = input.value.replace(/\D/g, '')
            if (numero.length <= 11) {
                numero = numero.replace(/^(\d{3})(\d{3})(\d{3})(\d{1})/, "$1.$2.$3-$4");
            }
            input.value = numero;
        }
        async function buscarDadosPorCpf(cpf) {
            // Verifica se o CPF está completo
            if (cpf.length === 14) { // O CPF formatado terá 14 caracteres (com pontos e traço)
                try {
                    const response = await fetch(`https://www.receitaws.com.br/v1/cpf/${cpf.replace(/\D/g, '')}`);
                    const data = await response.json();

                    if (data.status === "OK") {
                        // Preencher os campos com as informações retornadas pela API
                        document.getElementById('usuarioNome').innerText = data.nome;
                        document.getElementById('dataNascimento').value = data.nascimento;
                        document.getElementById('sexo').value = data.sexo; // Certifique-se que o valor retornado é compatível com os valores do select
                    } else {
                        alert("CPF não encontrado ou inválido.");
                    }
                } catch (error) {
                    console.error("Erro ao buscar dados:", error);
                    alert("Erro ao buscar dados. Tente novamente.");
                }
            }
        }
        function formatarTelefone(input) {
            let numero = input.value.replace(/\D/g, '')
            if (numero.length <= 10) {
                numero = numero.replace(/^(\d{2})(\d{4})(\d{0,4})/, "($1)$2-$3");
            } else {
                numero = numero.replace(/^(\d{2})(\d{5})(\d{0,4})/, "($1)$2-$3");
            }
        }
    </script>
</body>

</html>