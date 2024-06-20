<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta CNPJ</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        .title {
            font-size: 1.5em;
            margin-bottom: 10px;
        }
        .result {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #fafafa;
        }
        .error {
            color: red;
        }
        form {
            margin-bottom: 20px;
        }
        input[type="text"] {
            padding: 10px;
            width: calc(100% - 24px);
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            background-color: #28a745;
            color: white;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="title">Consulta de CNPJ</div>
        <form method="GET" action="">
            <input type="text" name="cnpj" placeholder="Digite o CNPJ" required>
            <input type="submit" value="Consultar">
        </form>

        <?php
        if (isset($_GET['cnpj'])) {
            function consultaCNPJ($cnpj) {
                $url = "https://www.receitaws.com.br/v1/cnpj/$cnpj";

                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                $response = curl_exec($ch);
                curl_close($ch);

                return json_decode($response, true);
            }

            $cnpj = preg_replace('/[^0-9]/', '', $_GET['cnpj']);
            $dados = consultaCNPJ($cnpj);

            if (isset($dados['status']) && $dados['status'] == "ERROR") {
                echo '<div class="result error">CNPJ inválido ou não encontrado</div>';
            } else {
                $nome = $dados['nome'] ?? "Não disponível";
                $cnpj_formatado = $dados['cnpj'] ?? "Não disponível";
                echo '<div class="result">';
                echo '<strong>Nome:</strong> ' . htmlspecialchars($nome) . '<br>';
                echo '<strong>CNPJ:</strong> ' . htmlspecialchars($cnpj_formatado);
                echo '</div>';
            }
        }
        ?>
    </div>
</body>
</html>
