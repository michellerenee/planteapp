<a href="./?page=login" class="link-back"><i class="small material-icons">arrow_back</i>Tilbage</a>

<h1>Opret bruger</h1>
<?php
// variabler der skal bruges, gemmes tomme for at forhindre fejl i koden
$fejl = '';
$fornavn = '';
$efternavn = '';
$email = '';
$password = '';
$fodselsdag = '';


// hvis der er trykket opret, køres denne kode
if (isset($_POST['submit'])){
  // der tjekkes for, om enten fornavn, efternavn, email, adgangskode og fødselsdag skulle være tomme
  if (empty($_POST['fornavn']) || empty($_POST['efternavn']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['fodselsdag'])){
    // Er en af felterne tomme, udskrives en fejlbesked
    $fejl = 'Alle felter skal udfyldes';
  }
  else{
    // hvis alle felterne er udfyldt, gemmes den indtastede email i variablen $email
    /*
     * mysqli_real_escape_string sørger for, at der ikke kommer "farlige" tegn med i databasen. Er der fx et navn med
     *  ' som O'Brien, tages denne pling som den afslutter et tekstfelt. Med escapestring sætter den \ (backslash), så tegnet bliver ignoreret
    */
    $email = mysqli_real_escape_string($link, $_POST['email']);

    // forspørgsel på email adressen der er indtastet
    $query = "SELECT bruger_email FROM plant_brugere WHERE bruger_email = '$email'";
    $result = mysqli_query($link, $query) or die($link);
    $row = mysqli_fetch_assoc($result);

    // Der tjekkes på, om der kommer nogle resultater tilbage
    if ($row > 0){
      // hvis der kommer resultater tilbage, betyder det mailadressen allerede er i brug, og det for brugeren besked om
      $fejl = 'Der findes allerede en bruger med denne mailadresse';
    }
    else{
      // hvis der ikke kommer noget tilbage, bliver der som næste step, tjekket om adgangskoderne er ens
      if ($_POST['password'] != $_POST['gentag-password']){
        // er de ikke det, får brugeren en fejlbesked
        $fejl = 'Adgangskoderne er ikke ens';
      }
      // er de ens, køres dette
      else{
        // dataen fra fødseldags feltet bliver hakket i stykker, så man har dag, måned og år for sig. Så sikre vi os,
        // at det bliver sat op i det format vi skal bruge
        list($month, $day, $year) = explode('-', $_POST['fodselsdag']);

        // der bliver tjekket om det er en rigtig dato brugeren har indtastet
        if (checkdate($month, $day, $year) == false){
          $fejl = 'Det var ikke en rigtig dato';
        }
        else{
          // er det rigtigt, gemmes alle informationerne i variabler (sikret med escape_string)
          $fornavn = mysqli_real_escape_string($link, $_POST['fornavn']);
          $efternavn = mysqli_real_escape_string($link, $_POST['efternavn']);
          $email = mysqli_real_escape_string($link, $_POST['email']);
          $password = mysqli_real_escape_string($link, $_POST['password']);
          $hash = mysqli_real_escape_string($link, password_hash($password, PASSWORD_DEFAULT));
          $fodselsdag = mysqli_real_escape_string($link, $year.'-'.$month.'-'.$day);

          // brugeren bliver oprettet i databasen
          $query = "INSERT INTO plant_brugere (bruger_fornavn, bruger_efternavn, bruger_email, bruger_password, 
bruger_fodselsdag) 
                  VALUES ('$fornavn', '$efternavn', '$email', '$hash', '$fodselsdag')";
          mysqli_query($link, $query) or die($link);

          // for at brugeren bliver logget ind med det samme, hentes den nye brugeres id ud af databasen
          $query = "SELECT bruger_id FROM plant_brugere WHERE bruger_email = '$email'";
          $result = mysqli_query($link, $query) or die($link);
          $row = mysqli_fetch_assoc($result);

          // den nye brugers id gemmes i sessionen 'bruger'
          $_SESSION['bruger'] = $row['bruger_id'];
          // brugeren sendes til forsiden
          header('Location: ./');
        }
      }
    }
  }
}

echo '<p class="fejlbesked">' . $fejl . '</p>';
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

  <input type="submit" name="submit" value="Opret" class="knap bg-gradient-1">
</form>

<p class="opret-tekst">Registre dig med</p>
<div class="opret-social-box">
  <a href="#" class="knap opret-social facebook">Facebook</a>
  <a href="#" class="knap opret-social google">Google+</a>
</div><!-- opret-social-box end -->

<?php

