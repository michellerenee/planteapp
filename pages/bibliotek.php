
<h1>Plante bibliotek</h1>

<div class="flex">

  <?php
  // i $query vælges der hvad der skal hentes fra databasen
  $query = "SELECT kategori_navn, kategori_id, kategori_billede FROM plant_kategorier";
  // forespørgslen sendes afsted til databasen, og resultatet gemmes i $result
  $result = mysqli_query($link, $query) or die(mysqli_error($link));

  // $row gemmer indholdet fra $result som et array
  // For hvert resultat der hentes ud fra databasen, køres denne løkke
  while($row = mysqli_fetch_assoc($result)){
    ?>
    <a href="./?page=planter&kat=<?php echo $row['kategori_id'] ?>" class="bib-kat">
      <figure>
        <img src="img/<?php echo $row['kategori_billede'] ?>" alt="Billede af <?php echo $row['kategori_navn'] ?>">
      </figure>
      <div>
        <p><?php echo $row['kategori_navn']; ?></p>
      </div>
    </a>
    <?php
  }
  ?>

  <a href="./?page=planter" class="bib-kat">
    <figure><img src="img/krassula.jpg" alt="Billede af en krassula"></figure>
    <p>Alle</p>
  </a>
</div><!-- flex end -->


