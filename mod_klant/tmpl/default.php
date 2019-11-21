
<?php
  //params
  $url = $params->get('Locatie');
  $achtergrond = $params->get('background');
  $sterkleur = $params->get('kleurster');
  $sterspacing = $params->get('spacingster');
  $sterfont = $params->get('fontster');
  $postie = $params->get('moduleleft');
  $textkleur = $params->get('textkleur');
  $border = $params->get('borderbreed');
  $borderkleur = $params->get('borderkleur');
  $borderadius = $params->get('borderradius');
  $randomcheck = $params->get('random');
  $updatecheck = $params->get('updatedata');

  $helper = new ModKlantenScore();

  $random = (rand(1,19));

  if($randomcheck){
    $review = $random;
  }
  else{
    $review = 1;
  }

  $data = $helper->select($review);

  if($updatecheck){
    $helper->insertxml($url);
  }

  $ratingDB = $data->rating;
  $reviewDB = $data->review;
  $naamDB = $data->naam;
  $gemDB = $data->gem;
  $aantalDB = $data->aantal;

  $doc = JFactory::getDocument();
  $modulePath = JURI::base() . 'modules/mod_klant/';
  $doc->addStyleSheet($modulePath.'css/style.css');

  $css = "
    .Klanten_score_{
      background-color:".$achtergrond.";
      left:".$postie."vw;
      border:".$border."px solid ".$borderkleur.";
      border-radius:".$borderadius."px;
    }
    .Klanten_Ster_{
      font-size:".$sterfont."px;
      margin-left:".$sterspacing."px;
    }
    .Klanten_Ster2_ , .Klanten_Ster_{
      color:".$sterkleur.";
    }
    .Klanten_naam_ , .Klanten_score_text_ , .Klanten_laatste_ , .Klanten_totaal_ , .Klant_kleur_{
      color:".$textkleur.";
    }";

  $doc->addStyleDeclaration($css);//add de css aan style.css

  $klantscore = round($ratingDB)/2;
  $klantscore2 = intval($klantscore);
  $rating = round(floatval($gemDB))/2;
  $rating2 = intval($rating);

 ?>

  <div class="Klanten_score_ g-grid">
    <div class="g-block box1 size-50-3">
       <div class="Klanten_naam_">
         <h1>
           <?php echo $naamDB;?>
         </h1>
       </div>
       <div class="Klanten_laatste_">
         <h2>
           "<?php echo $reviewDB;?>"
         </h2>
       </div>
       <div class="Klanten_score_random_">
         <h2><span class="Klant_kleur_">Rating:</span>
           <?php
             for($i=1; $i<=$klantscore2; $i++){
               echo"<i class='fa fa-star Klanten_Ster2_'></i>";
             }
             if($klantscore > $klantscore2){
               echo "<i class='fa fa-star-half Klanten_Ster2_'></i>";
             }
            ?>
          </h2>
      </div>
    </div>
    <div class="g-block box2 size-50-3">
      <div class="Klanten_score_text_">
        <h1>Klantscore : <?php echo $gemDB;?></h1>
      </div>

      <div class="Klanten_sterren_">
        <?php
          for($i=1; $i<=$rating2; $i++){
            echo"<i class='fa fa-star Klanten_Ster_'></i>";
          }
          if($rating > $rating2){
            echo "<i class='fa fa-star-half Klanten_Ster_'></i>";
          }
         ?>
       </div>
       <h2>
          <?php echo $aantalDB;?>
          Reviews
       </h2>
     </div>
   </div>
