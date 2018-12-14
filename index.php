<?php
// Henter informationerne til databaseforbindelsen fra filen config.php
require_once 'includes/db_config.php'; ?>
<!doctype html>
<html lang="da">
<?php
// hvis variablen 'page' er defineret i URL'en, gemmes den i variablen '$side' (det der kommer efter ? i URL'en)
if(isset($_GET['page'])){
  $side = $_GET['page'];
}
// hvis den ikke er defineret, er default 'velkommen'
else{
  $side = 'velkommen';
}
/* den fulde sti til filen gemmes i variablen $side_sti
    pages:      mappen filerne ligger i
    strtolower: sørger for at alle bogstaverne er små
*/
$side_sti = 'pages/' . strtolower($side) . '.php';

// link til forsiden ser sådan her ud: index.php?page=velkommen
?>
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Plantoramas Plante Guide</title>
  <!-- Compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link rel="stylesheet" href=" css/style.css">
  <!-- Henter material icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <!-- henter fonten Raleway fra google fonts -->
  <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
  <!-- Compiled and minified JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <link rel="icon" href="img/fav.jpg">
  <!-- Henter jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</head>

<body>
<nav>
  <a href="./?page=mine-planter"><img src="img/plantehaand.png" alt="" class="marg10"><p>Mine planter</p></a>
  <a href="./?page=scan"><img src="img/kamera.png" alt=""><p>Scan plante</p></a>
  <a href="./?page=bibliotek"><img src="img/biblo.png" alt=""><p>Plantebibliotek</p></a>
</nav>

<div class="container">
  <header>
    <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
    <a href="./" class="logo"><img src="img/plantorama-logo.png"></a>
    <a href="./?page=help" class="help-circle">?</a>
  </header>

  <ul class="sidenav" id="mobile-demo">
    <li><p>Menu</p></li>
    <?php
    // Hvis man ikke er logget ind vises denne menu
    if (!isset($_SESSION['bruger']) || $_SESSION['bruger'] == ''){
      ?>
      <li><a href="./?page=login">Log ind</a></li>
      <li><a href="./?page=scan">Scan plante</a></li>
      <li><a href="./?page=mine-planter">Mine planter</a></li>
      <li><a href="./?page=bibliotek">Plante bibliotek</a></li>
      <li><a href="./?page=opret-profil">Opret profil</a></li>
      <li><a href="./?page=help">Hjælp</a></li>
      <?php
    }
    // Hvis man er logget ind vises denne menu
    else{
      ?>
      <li><a href="./?page=scan">Scan plante</a></li>
      <li><a href="./?page=mine-planter">Mine planter</a></li>
      <li><a href="./?page=bibliotek">Plante bibliotek</a></li>
      <li><a href="./?page=min-profil">Min profil</a></li>
      <li><a href="./?page=help">Hjælp</a></li>
      <li><a href="./?logud">Log ud</a></li>
      <?php
    }
    ?>
  </ul>

  <?php
  // Hvis der er trykket log ud, står det i url'en. Denne tjekker på om det står der
  if (isset($_GET['logud'])){
    // Sletter alle sessions
    session_destroy();
    // Sender brugeren tilbage til forsiden
    header('Location: ./');
  }
  ?>

  <div class="main-container">
    <?php
    // hvis filen med navnet fra variablen 'page' eksisterer includeres indholdet fra siden
    if (file_exists($side_sti)){
      include $side_sti;
    }
    // ellers udskrives en fejlbesked
    else{
      echo 'Fejl. Siden findes ikke';
    }
    ?>
  </div><!-- main-container end -->
</div><!-- container end -->


<script>
    // JavaScript til burgermenu menuen
    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.sidenav');
        var instances = M.Sidenav.init(elems);
    });

    // JavaScript til acordions på hjælp siden
    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.collapsible');
        var instances = M.Collapsible.init(elems);
    });

    // Tillader at man kan vælge en dato fra en stor kalender i formene
    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.datepicker');
        var instances = M.Datepicker.init(elems, {format: 'mm-dd-yyyy', minDate: new Date(1919,1,1), maxDate: new Date(2019,12,31), yearRange: [1919, 2019]});
    });

    // Kræves for at select i biblioteket virker
    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('select');
        var instances = M.FormSelect.init(elems);
    });

</script>
</body>
</html>
<?php require_once 'includes/db_close.php'; ?>