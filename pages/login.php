<a href="./" class="link-back"><i class="small material-icons">arrow_back</i>Tilbage</a>

<h1>Log ind</h1>

<?php
$email = '';
$fejl = '';

// Hvis der er trykket log ind, køres denne kode
if (isset($_POST['submit'])){
  // Hvis email eller password er tomt, bliver en fejlbesked vist
  if (empty($_POST['email']) || empty($_POST['password'])){
    $fejl = 'Fejl i email eller adgangskode';
  }
  else{
    // ellers gemmes det indtastede i variabler
    $email = $_POST['email'];
    $password = $_POST['password'];

    // laver en forespørgsel på brugeren, ud fra den indtastede email
    $query = "SELECT bruger_id, bruger_password 
              FROM plant_brugere 
              WHERE bruger_email = '$email'";
    // forespørgslen sendes afsted og gemmes i $result og $row
    $result = mysqli_query($link, $query) or die($link);
    $row = mysqli_fetch_assoc($result);

    // tjekker om det indtastede password er det samme som det der hentes fra databasen
    if(password_verify($password, $row['bruger_password'])){
      // der oprettes en session 'bruger' med brugerens id, der viser at brugeren er logget ind
      $_SESSION['bruger'] = $row['bruger_id'];
      // Når man er logget ind sendes man til forsiden
      header('Location: ./');
    }
    else{
      // hvis log ind er forkert, gives en fejlbesked
      $fejl = 'Fejl i email eller adgangskode';
    }
  }
}

// fejlbeskeden bliver udskrivet. Hvis der ikke er nogle fejl, bliver p-tagget stadig vist, men uden indhold
echo '<p class="fejlbesked">' . $fejl . '</p>';
?>

<form method="post" class="login">
  <div class="input-field col s12">
    <label for="email">Email</label>
    <input type="email" id="email" name="email" value="<?php echo $email; ?>">
  </div><!-- input-field end -->

  <div class="input-field col s12">
    <label for="password">Adgangskode</label>
    <input type="password" id="password" name="password">
  </div><!-- input-field end -->

  <input type="submit" name="submit" value="Log ind" class="knap bg-gradient-1">
</form>

<a href="#" class="login-link">Glemt adgangskode?</a>

<a href="./?page=opret-profil" class="login-link">Har du ikke en bruger endnu? <span>Opret dig her!</span></a>
