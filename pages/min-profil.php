<?php
// Hvis der ikke er deffineret en session med navnet 'bruger', eller denne session er tom
if (!isset($_SESSION['bruger']) || $_SESSION['bruger'] == ''){
  // Overskriften vises, og en besked om at man ikke er logget ind
  echo '<h1>Min profil</h1>';
  echo 'Du er ikke logget ind';
}
else{
  // Hvis man er logget ind, vises alt indholdet

  //brugerens id (fra session) gemmes i variablen $bruger
  $bruger = $_SESSION['bruger'];

  // forespørgsel på brugerens oplysninger
  $query = "SELECT bruger_fornavn, bruger_efternavn, bruger_email, bruger_fodselsdag 
            FROM plant_brugere 
            WHERE bruger_id = $bruger";
  // forespørgsel sendes afsted og gemmes
  $result = mysqli_query($link, $query) or die($link);
  $row = mysqli_fetch_assoc($result);
  ?>

  <h1 class="ret-link">Min profil</h1>
  <a class="ret-link" href="./?page=ret-profil">
    <i class="material-icons tiny">create</i> Ret profil
  </a>


  <div class="profil">
    <div class="profil-oplysning">
      <p class="label">Fornavn</p>
      <p class="oplysing-indhold"><?php echo $row['bruger_fornavn'] ?></p>
    </div><!-- profil-oplysning end -->

    <div class="profil-oplysning">
      <p class="label">Efternavn</p>
      <p class="oplysing-indhold"><?php echo $row['bruger_efternavn'] ?></p>
    </div><!-- profil-oplysning end -->

    <div class="profil-oplysning">
      <p class="label">Email</p>
      <p class="oplysing-indhold"><?php echo $row['bruger_email'] ?></p>
    </div><!-- profil-oplysning end -->

    <div class="profil-oplysning">
      <p class="label">Fødselsdag</p>
      <p class="oplysing-indhold"><?php echo $row['bruger_fodselsdag'] ?></p>
    </div><!-- profil-oplysning end -->
  </div><!-- profil end -->
<?php
}


