<h1>Mine planter</h1>
<?php
// Hvis der ikke er deffineret en session med navnet 'bruger', eller denne session er tom
if (!isset($_SESSION['bruger']) || $_SESSION['bruger'] == ''){
  // der udskrives en besked om at man ikke er logget ind
  echo 'Du er ikke logget ind';
}
else{
  // hvis man er logget ind, vises alt indholdet, og brugerens id (fra session) gemmes i variablen $bruger
  $bruger = $_SESSION['bruger'];

  // teksten reminder skrives ud på siden
  echo '<p class="reminder">Reminder</p>';

  // forspørgsel til databasen om planteinformationerne
  $query = "SELECT plante_id, plante_billede, plante_navn, plante_pris, plante_info, mine_reminder
          FROM plant_mine_planter
          INNER JOIN plant_planter ON fk_plante_id = plant_planter.plante_id
          WHERE fk_bruger_id = $bruger";
  // sendes afsted og gemmes i $result og som array i $row
  $result = mysqli_query($link, $query) or die($link);

  // For hvert resultat fra databasen, køres al koden i while-løkken
  while ($row = mysqli_fetch_assoc($result)){
    ?>
    <section class="info no-padding">
      <div>
        <a href="./?page=plante-info&plante=<?php echo $row['plante_id'] ?>" class="flex-img">
          <img src="img/<?php echo $row['plante_billede'] ?>">
        </a>
      </div>

      <div class="short-info">
        <a href="./?page=plante-info&plante=<?php echo $row['plante_id'] ?>"><h1><?php echo $row['plante_navn'] ?></h1></a>
        <p class="pris"><?php echo $row['plante_pris'] ?> kr.</p>
        <?php
        $reminder = $row['mine_reminder'] == 1 ? 'ja' : 'nej';
        ?>
        <a href="./?page=mine-planter&switch=<?php echo $reminder . '&plante=' . $row['plante_id'] ?>" class="info-ikon switch-box"><img src="img/switch-<?php echo $reminder ?>.png"></a>

        <a href="./?page=plante-info&plante=<?php echo $row['plante_id'] ?>"><p><?php echo $row['plante_info'] ?></p></a>

        <a href="./?page=mine-planter&slet&plante=<?php echo $row['plante_id'] ?>" class="slet-min-plante">Fjern plante <i class="material-icons">highlight_off</i></a>
      </div><!-- short-info end -->
    </section><!-- section.info end -->
    <?php
  }

  // hvis der er trykket på switch, vil der enten stå switch=ja, eller switch=nej i url
  if(isset($_GET['switch']) && $_GET['switch'] != '') {
    // variablerne gemmes tomme
    $reminder = '';
    $plante_id = '';

    // hvis der står ja køres denne kode
    if ($_GET['switch'] == 'ja') {
      // Der trykkes på aktiveret switch, så den skal deaktiveres, og sættes derfor til 0
      $reminder = 0;
      // plantens id gemmes i variablen $plante_id
      $plante_id = $_GET['plante'];

      // hvis der står nej, køres denne kode
    } else if ($_GET['switch'] == 'nej') {
      // Der trykkes på deaktiveret switch, så den skal aktiveres, og sættes derfor til 1
      $reminder = 1;
      // plantens id gemmes i variablen $plante_id
      $plante_id = $_GET['plante'];
    }

    // databasen bliver opdateret med den nye info (switch ja/nej - 1/0)
    $query_switch = "UPDATE plant_mine_planter SET mine_reminder = $reminder WHERE fk_plante_id = $plante_id";
    mysqli_query($link, $query_switch) or die($link);

    // siden genopfriskes
    header('Location: ./?page=mine-planter');
  }


  // hvis der er blevet trykket slet, og plantens id står i url'en, køres denne kode
  if (isset($_GET['slet']) && isset($_GET['plante']) && $_GET['plante'] != ''){
    // plantens id gemmes fra url'en i variablen $plante
    $plante = $_GET['plante'];

    // forespørgsel om at slette planten formuleres og sendes til databasen
    $query_delete = "DELETE FROM plant_mine_planter WHERE fk_plante_id = $plante";
    mysqli_query($link, $query_delete) or die($link);

    // siden genopfriskes
    header('Location: ./?page=mine-planter');
  }
}
?>

