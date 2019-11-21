
<?php

class ModKlantenScore {

  public function select($id){

     $db = JFactory::getDbo();
     $query = $db->getQuery(true);
     $query->select('*');
     $query->from($db->quoteName('#__klantenscore'));
     $query->where($db->quoteName('id')." = ".$db->quote($id));

     $db->setQuery($query);
     $result = $db->loadRow();

     if ($result) {
        return new Data($result[0], $result[1], $result[2], $result[3], $result[4], $result[5], true);
     } else {
        return new Data(0,'','','','','','',false);
     }
  }


  public function update($id, $values = ['','','','','']){

     $db = JFactory::getDbo();

     $query = $db->getQuery(true);

     $fields = array(
        $db->quoteName('rating') . ' = ' . $db->quote($values[0]),
        $db->quoteName('review') . ' = ' . $db->quote($values[1]),
        $db->quoteName('naam') . ' = ' . $db->quote($values[2]),
        $db->quoteName('gem') . ' = ' . $db->quote($values[3]),
        $db->quoteName('aantal') . ' = ' . $db->quote($values[4]),
        $db->quoteName('id') . ' = ' . $id
     );

     $conditions = array(
        $db->quoteName('id') . ' = ' . $id
     );

     $query->update($db->quoteName('#__klantenscore'))->set($fields)->where($conditions);

     $db->setQuery($query);

     $result = $db->execute();
  }

  function insertxml($url){
    $urll = "https://www.klantenvertellen.nl/v1/review/feed.xml?hash=".$url;
    $helper = new ModKlantenScore();
    $xml = simpleXML_load_file($urll,"SimpleXMLElement",LIBXML_NOCDATA);

    if (($response_xml_data = file_get_contents($urll))===false){
      echo "Error bij het verkrijgen van de XML\n";
    }
    else {
     libxml_use_internal_errors(true);
     $data = simplexml_load_string($response_xml_data);
     if (!$data) {
         echo "Error bij het laden van de XML\n";
         foreach(libxml_get_errors() as $error) {
           echo "\t", $error->message;
         }
     }
     else {
       $score = $data->{'last12MonthAverageRating'}; // de average van de laastste 12 maanden
       $aantal = $data->{'numberReviews'};//totaal aantal reviews
       $rond = round($score,0,PHP_ROUND_HALF_EVEN);

       for($i=1; $i<=20; $i++){
          $naam = $data->{'reviews'}->{'reviews'}[$i-1]->{'reviewAuthor'};//naam van een random klant
          $klantscore = $data->{'reviews'}->{'reviews'}[$i-1]->{'reviewContent'}->{'reviewContent'}->{'rating'}; //de rating van de klant
          $klantreview = $data->{'reviews'}->{'reviews'}[$i-1]->{'reviewContent'}->{'reviewContent'}[1]->{'rating'};// de review van de klant
          $updateval = [$klantscore,$klantreview,$naam,$score,$aantal];
          $helper->update($i,$updateval);
       }
     }
    }
  }

}

class Data {
   public $id;
   public $rating;
   public $review;
   public $naam;
   public $gem;
   public $aantal;
   public $succes;

   public function __construct($id, $rating = "", $review = "", $naam = "", $gem = "", $aantal = "", $succes = false) {
      $this->id = $id;
      $this->rating = $rating;
      $this->review = $review;
      $this->naam = $naam;
      $this->gem = $gem;
      $this->aantal = $aantal;
      $this->succes = $succes;
   }
}
 ?>
