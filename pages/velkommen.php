<!--<a href="#" class="link-back"><i class="small material-icons">arrow_back</i>Tilbage</a>-->


<figure class="forside-fig">
  <img src="img/forside.jpg" alt="Der tages billede af blomster">
</figure>

<a href="./?page=scan" class="knap bg-gradient-1">Scan plante</a>

<?php
if (!isset($_SESSION['bruger']) || $_SESSION['bruger'] == ''){
  echo '<a href="./?page=login" class="knap bg-gradient-2">Log ind / opret bruger</a>';
}
?>
