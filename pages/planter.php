<a href="./?page=bibliotek" class="link-back"><i class="small material-icons">arrow_back</i>Tilbage</a>

<?php
// der tjekkes om brugeren er logget ind, og hvis brugeren er det, gemmes deres id i variablen $bruger
if (isset($_SESSION['bruger'])){
  $bruger = $_SESSION['bruger'];
}

// variabel der skal bruges senere
$kat_url = '';

// hvis der står kat (kategori) i url'en køres denne kode
if (isset($_GET['kat'])){
  // kategoriens id gemmes i en variabel
  $kategori_id = $_GET['kat'];

  // der gemmes et ekstra stykke til url'en og til en database forspørgsel
  $kat_url = '&kat=' . $kategori_id;
  $where_kategori = " WHERE $kategori_id = fk_kategori_id";

  // kategoriens overskrift hentes og gemmes i en variabel $overskrift
  $query = "SELECT kategori_navn FROM plant_kategorier WHERE kategori_id = $kategori_id";
  $result = mysqli_query($link, $query) or die(mysqli_error($link));
  $row = mysqli_fetch_assoc($result);

  $overskrift = $row['kategori_navn'];
}
else{
  // hvis der ikke står kat (kategori) i url'en, gemmes variablerne også, men tomme
  $kategori_id = "";
  $where_kategori = "";
  $kat_url = '';

  // overskriften vil så i stedet være alle planter
  $overskrift = "Alle planter";
}


?>

<h1><?php echo $overskrift ?></h1>

<div class="row plante-row">
  <div class="sorter col s5">
      <select class="browser-default" onchange="">
        <option value="" disabled selected>Sortér efter</option>
        <option value="1">Navn</option>
        <option value="2">Pris</option>
        <option value="3">Sværhedsgrad</option>
      </select>
  </div><!-- sorter end -->

  <div class="sog col s6 offset-s1">
    <form method="get">
      <input type="hidden" name="page" value="planter">
      <input placeholder="Søg..." id="sog" name="sog" type="text" value="">

      <button name="submit" id="submit" value="submit"><i class="material-icons">search</i></button>
    </form>
  </div><!-- sog end -->
</div><!-- row end -->

<?php
// planteinformationerne hentes fra databasen
$query = "SELECT plante_id, plante_navn, plante_pris, plante_info, plante_billede 
          FROM plant_planter" . $where_kategori;
$result = mysqli_query($link, $query) or die(mysqli_error($link));

// tomme variabler der forhindre fejl i koden (forhindre fejl på ikke deffinerede variabler)
$favorite_icon = '';
$favorite_link = '';

// for hvert resultat fra databasen (hver plante) køres denne kode
while($row = mysqli_fetch_assoc($result)){
  // plantes id gemmes i en variabel
  $plante_id = $row['plante_id'];

  // hvis brugeren er logget ind
  if (isset($_SESSION['bruger'])){
    // der tjekkes om der findes en forbindelse mellem brugeren og denne plante der er ved at blive hentet ud
    $query_favorite = "SELECT fk_plante_id FROM plant_mine_planter WHERE fk_plante_id = '$plante_id' AND fk_bruger_id = '$bruger'";
    $result_favorite = mysqli_query($link, $query_favorite) or die($link);
    $row_favorite = mysqli_fetch_assoc($result_favorite);

    // er der resultater, betyder det planten er tilføjet til 'mine planter', og skal derfor have fjern linket
    if ($row_favorite > 0){
      $favorite_link =  $kat_url . '&plante=' . $row['plante_id'] . '&fjern';
      $favorite_icon = 'favorite';
    }
    // er der ingen resultater, betyder det at planten ikke er tilføjet, og derfor skal have et link så man kan
    // tilføje den
    else{
      $favorite_link = $kat_url . '&plante=' . $row['plante_id'] . '&tilfoj';
      $favorite_icon = 'favorite_border';
    }
  }

  ?>
  <section class="info no-padding">
    <div>
      <a href="./?page=plante-info&plante=<?php echo $row['plante_id'] . $kat_url ?>" class="flex-img">
        <img src="img/<?php echo $row['plante_billede'] ?>" alt="Billede af <?php echo $row['plante_navn'] ?>">
      </a>
    </div>

    <div class="short-info">
      <a href="./?page=plante-info&plante=<?php echo $row['plante_id'] . $kat_url ?>"><h1><?php echo $row['plante_navn']
          ?></h1></a>
      <p class="pris"><?php echo $row['plante_pris'] ?> kr.</p>

      <a href="./?page=planter<?php echo $favorite_link ?>" class="info-ikon switch-box"><i class="material-icons"><?php echo $favorite_icon ?></i></a>

      <a href="./?page=plante-info&plante=<?php echo $row['plante_id'] . $kat_url ?>"><p><?php echo $row['plante_info']
          ?></p></a>
    </div><!-- short-info end -->
  </section><!-- section.info end -->
  <?php
}

// hvis plantens id står i url'en og ikke er tom gemmes id'et i variablen $plante_id
if(isset($_GET['plante']) && $_GET['plante'] != ''){
  $plante_id = $_GET['plante'];

  // står der også tilføj, køres denne kode
  if (isset($_GET['tilfoj'])){
    // forspørgsel til databasen om at indsætte forbindelsen mellem brugeren og den plante der er klikket på
    $query = "INSERT INTO plant_mine_planter (fk_plante_id, fk_bruger_id) VALUES ($plante_id, $bruger)";
  }

  // står der fjern i url'en, køres denne kode
  if (isset($_GET['fjern'])){
    // forspørgsel til databasen om at slette forbindelsen mellem brugeren og den plante der er trykket på
    $query = "DELETE FROM plant_mine_planter WHERE fk_plante_id = $plante_id";
  }
  // sender forspørgselen afsted. Hvilken afhænger af hvad der er trykket på
  mysqli_query($link, $query) or die(mysqli_error($link));
  // siden genopfriskes
  header('Location: ./?page=planter'.$kat_url);
}
?>
