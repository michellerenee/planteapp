<a href="./?page=min-profil" class="link-back"><i class="small material-icons">arrow_back</i>Tilbage</a>

<h1>Ret Profil</h1>

<?php
// hvis brugeren ikke er logget ind udskrives en besked om at de ikke er logget ind
if (!isset($_SESSION['bruger']) || $_SESSION['bruger'] == ''){
  echo 'Du er ikke logget ind';
}
// hvis de er logget ind, køres al koden
else{
  // brugerens id gemmes i variablen $bruger
  $bruger = $_SESSION['bruger'];

  // brugerens oplysninger hentes ud fra databasen, baseret på det id der er gemt i $bruger
  $query = "SELECT bruger_fornavn, bruger_efternavn, bruger_email, bruger_fodselsdag 
            FROM plant_brugere 
            WHERE bruger_id = $bruger";
  $result = mysqli_query($link, $query) or die($link);
  $row = mysqli_fetch_assoc($result);

  // oplysningerne gemmes i variabler, så de kan vises i formens input-felter
  $fornavn = $row['bruger_fornavn'];
  $efternavn = $row['bruger_efternavn'];
  $email = $row['bruger_email'];
  $fodselsdag = $row['bruger_fodselsdag'];
  $fejl = '';

  // hvis der trykkes på gem
  if (isset($_POST['submit'])){
    // tjekker om fornavn er tomt, hvis ja, udskrives en fejlbesked
    if (empty($_POST['fornavn'])){
      $fejl = 'Vi har brug for dit fornavn';
    }
    // hvis fornavn ikke er tomt, tjekkes der om efternavn er tomt, hvis ja, udskrives en fejlbesked
    elseif (empty($_POST['efternavn'])){
      $fejl = 'Vi har brugt for dit efternavn';
    }
    // hvis efternavn ikke er tomt, tjekkes email om den er tom, hvis ja, udskrives fejlbesked
    elseif (empty($_POST['email'])){
      $fejl = 'Din emailadresse er nødvendig';
    }
    // hvis email ikke er tom, tjekkes fødselsdag om den er tom, hvis ja, udskrives fejlbesked
    elseif (empty($_POST['fodselsdag'])){
      $fejl = 'Du bliver nødt til at oplyse din fødselsdag';
    }
    // hvis fodselsdag heller ikke er tom
    else{
      // fødselsdagen hakkes ud i små stykker, og gemmes i varaibler for år, måned og dag (for at vi kan sikre os det
      // rette format)
      list($year, $month, $day) = explode('-', $_POST['fodselsdag']);

      // der tjekkes for om det er en rigtig dato, er det ikke, udskrives der en fejlbesked
      if (checkdate($month, $day, $year) == false){
        $fejl = 'Det var ikke en rigtig dato';
      }
      // hvis alt er udfyldt, kan der fortsættes
      else{
        // oplysningerne gemmes i variabler og sikres til database med escape_string (mod ' og ")
        $fornavn = mysqli_real_escape_string($link, $_POST['fornavn']);
        $efternavn = mysqli_real_escape_string($link, $_POST['efternavn']);
        $email = mysqli_real_escape_string($link, $_POST['email']);
        $fodselsdag = mysqli_real_escape_string($link, $year .'-'. $month .'-'. $day);
        // adgangskode er tom, da der muligvis ikke bliver ændret andgangskode
        $pass_query = '';

        // tjekker om der er indtastet noget i adgangskode
        if (!empty($_POST['password'])){
          // tjekker om adgangskode og gentag adgangskode er ens, er de ikke, udskrives fejlbesked
          if ($_POST['password'] != $_POST['gentag-password']){
            $fejl = 'Adgangskoderne er ikke ens';
          }
          // er de ens, hashes (sikre adgangskoden til database (laver den om til en hel masse mærkelige tegn))
          else{
            $password = mysqli_real_escape_string($link, $_POST['password']);
            $hash = password_hash($password, PASSWORD_DEFAULT);
            // der gemmes en forlængelse af database forspørgslen, til hvis der ér indtastet en ny kode
            $pass_query = ", bruger_password = '$hash'";
          }
        }

        // oplysningerne opdateres i databasen
        $query = "UPDATE plant_brugere 
                  SET  bruger_fornavn = '$fornavn', bruger_efternavn = '$efternavn', bruger_email = '$email', bruger_fodselsdag = '$fodselsdag'" . $pass_query . " 
                  WHERE bruger_id = $bruger";
        mysqli_query($link, $query) or die($link);

        // brugeren sendes til deres profil
        header('Location: ./?page=min-profil');
      }
    }
  }

  echo '<p class="fejlbesked">'.$fejl.'</p>';
  ?>

  <form method="post" class="login">
    <div class="input-field col s12">
      <label for="fornavn">Fornavn</label>
      <input type="text" id="fornavn" name="fornavn" value="<?php echo $fornavn ?>">
    </div><!-- input-field end -->
    <div class="input-field col s12">
      <label for="efternavn">Efternavn</label>
      <input type="text" id="efternavn" name="efternavn" value="<?php echo $efternavn ?>">
    </div><!-- input-field end -->
    <div class="input-field col s12">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" value="<?php echo $email ?>">
    </div><!-- input-field end -->
    <div class="input-field col s12">
      <label for="password">Adgangskode</label>
      <input type="password" id="password" name="password">
    </div><!-- input-field end -->
    <div class="input-field col s12">
      <label for="gentag-password">Gentag adgangskode</label>
      <input type="password" id="gentag-password" name="gentag-password">
    </div><!-- input-field end -->
    <div class="input-field col s12">
      <label for="fodselsdag">Fødselsdag</label>
      <input type="text" id="fodselsdag" name="fodselsdag" class="datepicker" value="<?php echo $fodselsdag ?>">
    </div><!-- input-field end -->

    <input type="submit" name="submit" value="Gem" class="knap bg-gradient-1">
  </form>
  <?php
}

