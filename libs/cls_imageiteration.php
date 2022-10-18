<?php
  /* ****************************************************************************************************************
     ImageIteration

     Frequenz der Einzelbildaufnahmen und dazu passende Multiplikatoren fuer die Filmerstellung
     Diese Klasse muss nicht instantiiert werden, da sie aus statischen Methoden und Variablen besteht
  **************************************************************************************************************** */
  class ImageIteration {
    public static $iterations = array ( '-'    => array(1,'alle 20 Sek','',18,20),
                                        '+'    => array(1,'alle 30 Sek','',28,30),
                                        '*'    => array(1,'jede Minute','',58,60),
                                        '*/2'  => array(2,'alle 2 Min','',90,120),
                                        '*/3'  => array(3,'alle 3 Min','',180,180),
                                        '*/4'  => array(4,'alle 4 Min','',220,240),
                                        '*/5'  => array(5,'alle 5 Min','',280,300),
                                        '*/10' => array(10,'alle 10 Min',' -filter:v "setpts=2.0*PTS"',580,600),
                                        '*/15' => array(15,'alle 15 Min',' -filter:v "setpts=3.0*PTS"',580,900),
                                        '*/20' => array(20,'alle 20 Min',' -filter:v "setpts=4.0*PTS"',580,1200),
                                        '*/30' => array(30,'alle 30 Min',' -filter:v "setpts=6.0*PTS"',580,1800),
                                        '0'    => array(60,'st&uuml;ndlich',' -filter:v "setpts=12.0*PTS"',580,3600)
                                      );

    public static function filter($key) {
      return self::$iterations[$key][2];
    }

    public static function minute($key) {
      return self::$iterations[$key][0];
    }

    public static function description($key) {
      return self::$iterations[$key][1];
    }

    public static function max_time_out($key) {
      return self::$iterations[$key][3];
    }

    public static function interval($key) {
      return self::$iterations[$key][4];
    }
    
    public static function connect_time_out($key) {
      return round(self::$iterations[$key][3]/2);
    }

  }

?>