<?php

/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace BugBuster\Visitors;

class ModuleVisitorCharts 
{
    private $name; // String or numeric
    private $name2; // String or numeric
    private $height; // Int
    private $width; // Int
    private $maxvalue_height; // Int
    private $x = array(); // Elements can be numeric or a string
    private $y = array(); // Elements are numeric (Visits)
    private $y2 = array(); // Elements are numeric (Hits)
    
        
    // Diagrammname setzen
    public function setName($name){
        if(!is_string($name) AND !is_numeric($name)){
            throw new \Exception("Falscher Dateityp (".gettype($name).") number or string expected!");
            //return false;
        }
        $this->name = $name;
    }
    public function setName2($name2){
        if(!is_string($name2) AND !is_numeric($name2)){
            throw new \Exception("Falscher Dateityp (".gettype($name2).") number or string expected!");
            //return false;
        }
        $this->name2 = $name2;
    }

    // Diagrammname auslesen
    public function getName(){
        return $this->name;
    }
    public function getName2(){
        return $this->name2;
    }

    // Höhe des Diagramms setzen
    public function setHeight($height){
        if(!is_int($height)){
            throw new \Exception("Falscher Dateityp (".gettype($height).") integer expected!");
            //return false;
        }
        $this->height = $height;
        return true;
    }

    // Höhe des Diagramms auslesen
    public function getHeight(){
        return $this->height;
    }

    // Breite des Diagramms setzen
    public function setWidth($width){
        if(!is_int($width)){
            throw new \Exception("Falscher Dateityp (".gettype($width).") integer expected!");
            //return false;
        }
        $this->width = $width;
        return true;
    }

    // Breite des Diagramms auslesen
    public function getWidth(){
        return $this->width;
    }

    // Balkenhöhe des Maximalwertes setzen
    public function setMaxvalueHeight($maxvalue_height){
        if(!is_int($maxvalue_height)){
            throw new \Exception("Falscher Dateityp (".gettype($maxvalue_height).") integer expected!");
            //return false;
        }
        $this->maxvalue_height = $maxvalue_height;
        return true;
    }

    // Balkenhöhe des Maximalwertes auslesen
    public function getMaxvalueHeight(){
        return $this->maxvalue_height;
    }

    // Fügt einen X-Wert hinzu
    public function addX($x){
        if(!is_numeric($x) AND !is_string($x)){
            throw new \Exception("Falscher Dateityp (".gettype($x).") number or string expected!");
            //return false;
        }
        $this->x[] = $x;
        return true;
    }

    // Fügt einen Y-Wert hinzu
    public function addY($y){
        if(!is_numeric($y)){
            throw new \Exception("Falscher Dateityp (".gettype($y).") number expected!");
            //return false;
        }
        $this->y[] = $y;
        return true;
    }
    // Fügt einen Y2-Wert hinzu
    public function addY2($y2){
        if(!is_numeric($y2)){
            throw new \Exception("Falscher Dateityp (".gettype($y2).") number expected!");
            //return false;
        }
        $this->y2[] = $y2;
        return true;
    }

    
    public function _checkValues(){
        if(!isset($this->name)){
            throw new \Exception("Kein Diagrammname 1 vorhanden!");
            //return false;
        }
        if(!isset($this->name2)){
            throw new \Exception("Kein Diagrammname 2 vorhanden!");
            //return false;
        }
        if(!isset($this->height)){
            throw new \Exception("Keine Höhe für das Diagramm vorhanden!");
            //return false;
        }
        if(!isset($this->width)){
            throw new \Exception("Keine Breite für das Diagramm vorhanden!");
            //return false;
        }
        if(!isset($this->maxvalue_height)){
            throw new \Exception("Keine Höhe für den Maximalwert vorhanden!");
            //return false;
        }
        if(!isset($this->x)){
            throw new \Exception("Keine X-Werte vorhanden!");
            //return false;
        }
        if(!isset($this->y)){
            throw new \Exception("Keine Y-Werte vorhanden!");
            //return false;
        }
        if(!isset($this->y2)){
            throw new \Exception("Keine Y2-Werte vorhanden!");
            //return false;
        }
        if(count($this->x)!=count($this->y)){
            throw new \Exception("Anzahl der X- und Y-Werte stimmt nicht überein!");
            //return false;
        }
        return true;
    }

    public function _getRelation(){
        $relation = array();
        foreach($this->y as $key => $wert)
            $relation[$key]['y'] = $wert/$this->_getMaxValue2();
        foreach($this->y2 as $key => $wert)
            $relation[$key]['y2'] = $wert/$this->_getMaxValue2();
        return $relation;
    }

    public function _getMaxValue(){
        return max($this->y); //y
    }
    public function _getMaxValue2(){
        return max($this->y2); //y
    }
	
    public function _getDataNumber(){
        return count($this->y); //y
    }

    public function display($echo = false) {
    	$output = '';
        if(!$this->_checkValues())
            return $output;

        // Verhältnis aller Daten zum Maximalwert berechnen
        // Jeder Wert erhält dann als Höhe einen Bruchteil der
        // maximalen Balkenhöhe
        $relation = $this->_getRelation();

        // Tabelle erzeugen
        $output .= "<table cellpadding=\"0\" style=\"width:".$this->getWidth()."px; height:".$this->getHeight()."px; text-align:center; border:solid 1px #E9E9E9; font-size:10px; margin:0px auto\">\n";
        // Diagrammname ausgeben
        $output .= "<tr>\n".
                   "<td colspan=\"".$this->_getDataNumber()."\" class=\"tl_folder_tlist\">".$this->getName()."</td>".
                   "<td colspan=\"".$this->_getDataNumber()."\" class=\"tl_folder_tlist\">".$this->getName2()."</td>\n".
                   "</tr>\n";

        $output .= " <tr>\n";
        // Werte - also Balken - ausgeben
        foreach($relation as $key => $wert){
             // Breite einer Zelle und Höhe eines Balkens berechnen
             $output .= "  <td style=\"vertical-align:bottom; height:200px; width:".floor($this->getWidth()/($this->_getDataNumber()*2))."px;\">".
                        "   <div style=\"margin:auto 0 auto auto; background-color:red; height:".floor($this->getMaxvalueHeight()*$wert['y'])."px; width:".floor(($this->getWidth()/2)/($this->_getDataNumber()*2))."px\" title=\"".$this->y[$key]."\">".
                        "&nbsp;".
                        "   </div>".
                        "  </td>\n";
             $output .= "  <td style=\"vertical-align:bottom; height:200px; width:".floor($this->getWidth()/($this->_getDataNumber()*2))."px;\">".
                        "   <div style=\"margin:auto auto auto 0; background-color:green; height:".floor($this->getMaxvalueHeight()*$wert['y2'])."px; width:".floor(($this->getWidth()/2)/($this->_getDataNumber()*2))."px\" title=\"".$this->y2[$key]."\">".
                        "&nbsp;".
                        "   </div>".
                        "  </td>\n";
        }
        $output .= " </tr>\n";

        $output .= " <tr>\n";
        // Stellen - also Balkenzuordnung - ausgeben
        foreach($this->x as $stelle){
             //$output .= "  <td colspan=\"2\" style=\"vertical-align:middle; border:solid 1px #E9E9E9; border-width:1px 1px 0px 1px; height:20px; background-color:#F6F6F6;\">";
             $output .= "  <td colspan=\"2\" style=\"vertical-align:middle; text-align: center;\" class=\"tl_file_list\">";
             $output .= $stelle;
             $output .= "  </td>\n";
        }

        $output .= " </tr>\n";
        $output .= "</table>\n";
        if($echo) {
            echo $output;
            return true;
        } else {
            return $output;
        }
    } 
}
/**
  // Neues Objekt erzeugen
  $a = new Diagramm();
  // 'Versuche', die Konfiguration zu durchzuführen
  try{
      // Name setzen
      $a->setName("Besucherzahlen");
      // Höhe setzen
      $a->setHeight(300);
      // Breite setzen
      $a->setWidth(280);
      // Balkenhöhe setzen
      $a->setMaxvalueHeight(190);
      // X- und Y-Werte definieren
      $x = array('01', '20', '03', '04', '05', '06');
      $y = array(    5500,     6800,    5200,    4800,  7000,   5900);
      // Werte im Diagrammobjekt speichern
      foreach($x as $key => $value){
          $a->addX($value);
          $a->addY($y[$key]);
      }
      // Diagramm ausgeben
      $mix = $a->display(false); // true gibt direkt aus
  }
  // Geworfene Exceptions auswerten
  catch(Exception $e){ 
      echo '<strong>Fehler: </strong>'.$e->getMessage();
  }
  var_dump($mix);
**/
?>