<?php
// hvis plante ikke er deffineret eller er tom i url'en
if (!isset($_GET['plante']) || $_GET['plante'] == ''){
  // plante id er tom, og du sendes til biblioteket
  $plante_id = '';
  header('Location: ./?page=bibliotek');
}
else{
  // ellers gemmes plantes id i variablen $plante_id og en url forlængelse $plante_url
  $plante_id = $_GET['plante'];
  $plante_url = '&plante=' . $plante_id;
}

// hvis kat (kategori) er deffineret i url, og ikke er tom
if (isset($_GET['kat']) && $_GET['kat'] != ''){
  // kategoriens id gemmes i variablen $kat_id
  $kat_id = $_GET['kat'];

  // kategoriens id gemmes sammen med anden tekst, som en del af url, der bruges senere
  $kat_url = '&kat=' . $kat_id;
  // tilføjelse til database forspørgslen, baseret på om kategori er deffineret
  $where_kategori = " WHERE $kat_id = fk_kategori_id";

  ?>
  <a href="./?page=planter&kat=<?php echo $kat_id ?>" class="link-back"><i class="small
  material-icons">arrow_back</i>Tilbage</a>
  <?php
}
else{
  // hvis kat ikke er deffineret i url, gemmes variablerne tomme
  $kategori_id = "";
  $where_kategori = "";
  $kat_url = '';
}

// database forspørgsel efter planteinformationerne
$query = "SELECT plante_navn, plante_billede, plante_info, plante_pris, plante_svarhed_icon, plante_spiselig_icon, 
          plante_vanding, plante_vigtig, plante_spiselighed, plante_godning, plante_solskygge, plante_svarhedsgrad, 
          plante_indeude, plante_temperatur
          FROM plant_planter 
          WHERE plante_id = $plante_id";
// forspørgslen gemmes i $resultat og i $row som array
$result = mysqli_query($link, $query) or die($link);
$row = mysqli_fetch_assoc($result);


// hvis en bruger er logget ind, køres denne kode
if (isset($_SESSION['bruger'])){
  // brugerens id gemmes fra session
  $bruger = $_SESSION['bruger'];

  // db forespørgsel efter plante id, hvor plante_id'et passer til den plante brugeren kigger på, og bruger_id'et
  // passer til den bruger der kigger på det
  $query_favorite = "SELECT fk_plante_id 
                    FROM plant_mine_planter 
                    WHERE fk_plante_id = '$plante_id' 
                    AND fk_bruger_id = '$bruger'";
  $result_favorite = mysqli_query($link, $query_favorite) or die($link);
  $row_favorite = mysqli_fetch_assoc($result_favorite);
  // hvis der kommer et resultat tilbage, vil det sige at brugeren har tilføjet planten til deres planter

  // hvis der kommer resultater tilbage, vises et fuldt hjerte, så man har mulighed for at fjerne det igen
  if ($row_favorite > 0){
    $favorite_link =  $kat_url . '&plante=' . $plante_id . '&fjern';
    $favorite_icon = 'favorite';
  }
  // hvis der ikke kommer resultater tilbage, er det et tomt hjerte, så man har mulighed for at tilføje planten
  else{
    $favorite_link = $kat_url . '&plante=' . $plante_id . '&tilfoj';
    $favorite_icon = 'favorite_border';
  }

  // der tjekkes for om plantens id står i url'en, og gør det, gemmes det i variablen $plante_id
  if(isset($_GET['plante']) && $_GET['plante'] != ''){
    $plante_id = $_GET['plante'];

    // hvis der også står tilføj i url'en køres denne kode
    if (isset($_GET['tilfoj'])){
      // plantens id og brugerens id, gemmes i tabellen 'mine planter' i databasen
      $query = "INSERT INTO plant_mine_planter (fk_plante_id, fk_bruger_id) VALUES ($plante_id, $bruger)";
      mysqli_query($link, $query) or die(mysqli_error($link));
      // siden genopfriskes
      header('Location: ./?page=plante-info'.$plante_url.$kat_url);
    }

    // hvis der står fjern i url'en, køres denne kode
    if (isset($_GET['fjern'])){
      // forbindelsen mellem planten og brugeren slettes fra tabellen 'mine planter' i databasen
      $query = "DELETE FROM plant_mine_planter WHERE fk_plante_id = $plante_id";
      mysqli_query($link, $query) or die(mysqli_error($link));
      // siden genopfriskes
      header('Location: ./?page=plante-info'.$plante_url.$kat_url);
    }
  }
}
?>









<section class="info no-padding">
  <div>
    <img src="img/<?php echo $row['plante_billede'] ?>">
  </div>

  <div class="short-info">
    <h1><?php echo $row['plante_navn'] ?></h1>
    <p class="pris"><?php if ($row['plante_pris'] == null) { echo '-'; } else {echo $row['plante_pris'];} ?> kr.</p>

    <a href="./?page=plante-info<?php echo $favorite_link ?>" class="info-ikon switch-box"><i class="material-icons"><?php echo $favorite_icon ?></i></a>

    <p><?php echo $row['plante_info'] ?></p>
  </div><!-- short-info end -->
</section>















<section>
  <h2 class="more-margin">Plantens behov</h2>

  <div class="behov">
    <span><img src="img/vandekande.png"></span>
    <p><?php echo $row['plante_vanding'] ?></p>
  </div><!-- behov end -->

  <hr>

  <div class="behov">
    <span><img src="img/sol-skygge.png"></span>
    <p><?php echo $row['plante_solskygge'] ?></p>
  </div><!-- behov end -->

  <hr>

  <div class="behov">
    <span><img src="img/svarhed<?php echo $row['plante_svarhed_icon'] ?>.png"></span>
    <p><?php echo $row['plante_svarhedsgrad'] ?></p>
  </div><!-- behov end -->

  <hr>

  <div class="behov">
    <span><img src="img/inde-ude.png"></span>
    <p><?php echo $row['plante_indeude'] ?></p>
  </div><!-- behov end -->

  <hr>

  <div class="behov">
    <span><img src="img/temp.png"></span>
    <p><?php echo $row['plante_temperatur'] ?></p>
  </div><!-- behov end -->

  <hr>

  <div class="behov">
    <span><img src="img/godning.png"></span>
    <p><?php echo $row['plante_godning'] ?></p>
  </div><!-- behov end -->

  <hr>

  <div class="behov">
    <span><img src="img/spis<?php echo $row['plante_spiselig_icon'] ?>.png"></span>
    <p><?php echo $row['plante_spiselighed'] ?></p>
  </div><!-- behov end -->
</section>

<section>
  <h2>Info om planten</h2>
  <p><?php echo $row['plante_info'] ?></p>
</section>

<section>
  <h2>Vigtigt at vide</h2>
  <p><?php echo $row['plante_vigtig'] ?></p>
</section>

<?php
