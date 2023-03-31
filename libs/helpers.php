<?php
  if (!defined('_HELPERS_')) {
  	
  	// Diese Funktion wird zum Beispiel in der Model-Klasse verwendet, um
  	// große Arrays von Dateilistings erzeugen zu können, da sonst das
  	// Memory-Limit den Prozess beendet
  	function chunk_iterator(Iterator $it, int $n) {
      $chunk = [];

      for($i = 0; $it->valid(); $i++){
        $chunk[] = $it->current();
        $it->next();
        if(count($chunk) == $n){
            yield $chunk;
            $chunk = [];
        }
      }

      if(count($chunk)){
        yield $chunk;
      }
    }
  	
  } else define('_HELPERS_');
?>