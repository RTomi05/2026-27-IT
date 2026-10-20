<?php

    class EgyAdat
    {
        public $ora;
        public $perc;
        public $masodperc;
        public $ido;
        public $varos;

        public function __construct($sor)
        {
            $adatok = explode(" ",$sor);
            $this->ora = $adatok[0];
            $this->perc = $adatok[1];
            $this->masodperc = $adatok[2];
            $this->ido = $adatok[3];
            $this->varos = $adatok[4];
        }
    }

    $vissza = [];
    $adatok = array_slice(explode(PHP_EOL,trim(file_get_contents("forgalom.txt"))),1);
    for($i = 0; $i < sizeof($adatok); $i++)
        {
            $vissza[] = new EgyAdat($adatok[$i]);
        }
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($vissza);
?>