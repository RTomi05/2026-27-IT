<?php
    /*
    $file = file("forgalom.txt");
    for($i = 0;$i < sizeof($file);$i++)
        {
            echo $file[$i] . "<br>";
        }

    //var_dump($file);
    */

    class EgyAdat{
        public $ora;
        public $perc;
        public $masodperc;
        public $ido;
        public $varos;
		public $sebesseg;

        public function __construct($sor) {
            $adatok = explode(" ",$sor);
            $this->ora = $adatok[0];
            $this->perc = $adatok[1];
            $this->masodperc = $adatok[2];
            $this->ido = $adatok[3];
            $this->varos = $adatok[4];
			$this->sebesseg = 1000/$this->ido;
        }
    }

    function adatBetolt()
    {
    $adatok = array_slice(explode(PHP_EOL,trim(file_get_contents("forgalom.txt"))),1);

    $vissza = [];
    for($i = 0; $i < sizeof($adatok); $i++)
        {
            $vissza[] = new EgyAdat($adatok[$i]);
        }
        return $vissza;
    }
?>