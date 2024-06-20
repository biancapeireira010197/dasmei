<?php
if (isset($_POST['cnpj'])) {
    function consultaCNPJ($cnpj) {
        $url = "https://www.receitaws.com.br/v1/cnpj/$cnpj";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }

    $cnpj = preg_replace('/[^0-9]/', '', $_POST['cnpj']);
    $dados = consultaCNPJ($cnpj);

    session_start();

    if (isset($dados['status']) && $dados['status'] == "ERROR") {
        header("Location: index.php");
        exit();
    } else {
        $nome = $dados['nome'] ?? "Não disponível";
        $cnpj_formatado = $dados['cnpj'] ?? "Não disponível";

        $_SESSION["nome"] = $nome;
        $_SESSION["cnpj"] = $cnpj_formatado;

        header("Location: csta.php");
        exit();
    }
}
?>
