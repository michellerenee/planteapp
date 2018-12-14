<?php
// Hvis der ikke er deffineret en session med navnet 'bruger', eller denne session er tom
if (!isset($_SESSION['bruger']) || $_SESSION['bruger'] == ''){
  // variablen fyldes med en klasse der bliver sat på li elementer
  $help_hidden = 'class="help-hidden"';
}
else{
  // Hvis session er deffineret og med indhold, skal der ikke vises en class
  $help_hidden = '';
}
?>
<section>
  <h2>Har du brug for hjælp?</h2>
  <p>Forhåbentligt har vi alle de svar du leder efter. Men hvis der er noget du ikke kan få svar på, så kan du skrive en besked til so nederst på siden eller ring til os på tlf. 11223344. Vi hjælper dig hurtigst muligt.</p>
</section>

<ul class="collapsible">
  <li>
    <div class="collapsible-header">Hvad betyder ikonerne?
      <i class="material-icons mere">expand_more</i>
      <i class="material-icons mindre">expand_less</i>
    </div>
    <div class="collapsible-body">
      <div class="behov">
        <span><img src="img/vandekande.png"></span>
        <p>Fortæller hvor tit planterne skal vandes</p>
      </div><!-- behov end -->

      <hr>

      <div class="behov">
        <span><img src="img/sol-skygge.png"></span>
        <p>Fortæller om planten skal stå i sol eller skygge</p>
      </div><!-- behov end -->

      <hr>

      <div class="behov">
        <span><img src="img/svarhed2.png"></span>
        <p>Her kan du se hvor svær planten er at holde</p>
      </div><!-- behov end -->

      <hr>

      <div class="behov">
        <span><img src="img/inde-ude.png"></span>
        <p>Viser om planten skal placeres indenfor eller udendørs</p>
      </div><!-- behov end -->

      <hr>

      <div class="behov">
        <span><img src="img/temp.png"></span>
        <p>Fortæller hvilke temperaturer planten lever bedst ved</p>
      </div><!-- behov end -->

      <hr>

      <div class="behov">
        <span><img src="img/godning.png"></span>
        <p>Viser om planten skal gødes, og hvor ofte</p>
      </div><!-- behov end -->

      <hr>

      <div class="behov">
        <span><img src="img/spis1.png"></span>
        <p>Fortæller om planten kan spises eller ej</p>
      </div><!-- behov end -->
    </div>
  </li>
  <li>
    <div class="collapsible-header">Hvordan bruger jeg scanneren?
      <i class="material-icons mere">expand_more</i>
      <i class="material-icons mindre">expand_less</i>
    </div>
    <div class="collapsible-body">
      <p>Vi har lavet en lile video der viser dig, hvordan du skal bruge app'en. Se den her.</p>
      <!-- video her -->
    </div>
  </li>
  <li <?php echo $help_hidden ?>>
    <div class="collapsible-header">Hvordan får jeg en reminder?
      <i class="material-icons mere">expand_more</i>
      <i class="material-icons mindre">expand_less</i>
    </div>
    <div class="collapsible-body">
      <p>Når du har tilføjet en plante eller blomst til 'Mine planter', har du mulighed for at se dem på din liste.</p>
      <p>Den lille switch i øverste højre hjørne ved planten viser om du modtager reminders.</p>
      <p>Er den grøn modtager du reminders, er den grå gør du ikke.</p>
    </div>
  </li>
  <li>
    <div class="collapsible-header">Scanneren virker ikke
      <i class="material-icons mere">expand_more</i>
      <i class="material-icons mindre">expand_less</i>
    </div>
    <div class="collapsible-body">
      <p>Prøv at lukke app'en helt ned, og åben den igen. Virker den stadig ikke, kan du kontakte os, og vi vil hjælpe dig hurtigst muligt.</p>
    </div>
  </li>
  <li <?php echo $help_hidden ?>>
    <div class="collapsible-header">Hvordan fjerner jeg en plante?
      <i class="material-icons mere">expand_more</i>
      <i class="material-icons mindre">expand_less</i>
    </div>
    <div class="collapsible-body">
      <p>På din liste over dine planter, er der i højre hjørne i bunden, et lille rødt kryds med teksten 'Fjern plante'.</p>
      <p>Klikker du på denne, bliver planten slettet fra din liste.</p>
    </div>
  </li>
  <li <?php echo $help_hidden ?>>
    <div class="collapsible-header">Jeg kan ikke finde min plante
      <i class="material-icons mere">expand_more</i>
      <i class="material-icons mindre">expand_less</i>
    </div>
    <div class="collapsible-body">
      <p>Ind til videre har vi kun planter i app'en, som vi fører i butikkerne. Er din plante ikke fra Plantorama, kan det være grunden.</p>
      <p>Mener du det er en fejl, kan du kontakte os, og vi vender tilbage hurtigst muligt.</p>
      <p>På længere sigt er planen, at der tilføjes et meget bredt udvalg af planter i app'en.</p>
    </div>
  </li>
  <li>
    <div class="collapsible-header">Hvad er en plante??
      <i class="material-icons mere">expand_more</i>
      <i class="material-icons mindre">expand_less</i>
    </div>
    <div class="collapsible-body">
      <p>En plante defineres som en autotrof organisme, der kan formere sig med anisogameter. Herved adskiller planterne sig fra f.eks. både dyr og svampe der er heterotrofe.</p>
      <p>Andre væsentlige kendetegn er at plantecellerne har cellevægge, som består af cellulose og at (langt de fleste) planter er i stand til at udføre fotosyntese.</p>
      <p>Evnen til fotosyntese er en (af flere) væsentlige forudsætninger for planternes autotrofi.</p>
      <p>For de fleste mennesker er en plante et velkendt begreb omfattende urter, buske og træer med grønne blade, stængler eller stammer, og rødder.</p>
    </div>
  </li>
  <li>
    <div class="collapsible-header">Argh hjælp jeg bliver spist
      <i class="material-icons mere">expand_more</i>
      <i class="material-icons mindre">expand_less</i>
    </div>
    <div class="collapsible-body">
      <p>Bid igen. Det kan de ikke lide.</p>
    </div>
  </li>
</ul>

