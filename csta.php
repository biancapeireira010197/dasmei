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

        if (isset($dados['status']) && $dados['status'] == "ERROR") {
            header("Location: index.php");
        } else {
            $nome = $dados['nome'] ?? "Não disponível";
            $cnpj_formatado = $dados['cnpj'] ?? "Não disponível";

            session_start();
            $_SESSION["nome"] = $nome;
            $_SESSION["cnpj"] = $cnpj_formatado; 

        }
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
                                    <a href="SimplesNacional/Aplicacoes/ATSPO/pgmei.app/home/sair"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Sair</a>
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
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-body">
                    <p class="text-center">
                        A contagem da carência (quantidade de contribuições necessárias para ter direito aos benefícios previdenciários) inicia-se 
                a partir do <strong>PRIMEIRO PAGAMENTO EM DIA</strong>.
                    </p>
                    <p class="text-center">O MEI, mesmo sem faturamento, deve pagar mensalmente o DAS (Guia de pagamento).</p>
                    <p class="text-center">Caso o DAS não tenha sido pago até a data de vencimento, o MEI deve emitir e pagar o novo DAS (Guia de Pagamento) com acréscimos legais (multa e juros). </p>
                    <p class="text-center">Caso tenha dúvidas sobre o PGMEI, clique em "Ajuda".</p>
       
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


    <form id="frmPagarOnline" target="_top" name="frmPagarOnline" method="post"></form>

    

    <!-- 
        False,18/06/2024 00:00:00,
    -->
</body>
</html>


