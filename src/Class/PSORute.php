<?php

class PSORute{
    var $distance;
    var $duration;
    var $durationInTrafic;
    var $velocity;
    var $position;
    var $destination;
    //cDimension adalah jumlah waypoint + destination dengan urutan D0, D1, D2 dst
    var $cDimensi;
    var $iterasi = 0;
    var $pBest = [];
    var $GBest = [];
    //cPartikel adalah jumlah posisi
    const cPartikel = 100;
    const p = 0.9;
    const r1 = 0.4;
    const r2 = 0.6;
    const maxIterasi = 100;

    function __construct($inCDimensi, $inDistance, $inDuration, $inDurationInTrafic) {
        $this->setDistance($inDistance);
        $this->setDuration($inDuration);
        $this->setDurationInTrafic($inDurationInTrafic);
        $this->cDimensi = $inCDimensi;
        $this->setInitVelocity();
        $this->setInitPosition();
        $this->setPBest();
        $this->setGBest();
        $this->iterasi = 1;
        $this->setIteration();
    }
    function setDestination($inDestination){
        //Example : {D10,D11,D12}
        $this->destination = json_encode($inDestination);
    }
    function setDistance($inDistance){
        //example: {"S":{"D0":10,"D1":5},
        //          "D0":{"D1":10,"D2":5},
        //          "D1":{"D0":10,"D2":15}}
        //S adalah titik awal; D0, D1, dst adalah waypoint+destination
        $this->distance = json_encode($inDistance);
    }
    function setDuration($inDuration){
        //example: {"S":{"D0":10,"D1":5},
        //          "D0":{"D1":10,"D2":5},
        //          "D1":{"D0":10,"D2":15}}
        //S adalah titik awal; D0, D1, dst adalah waypoint+destination
        $this->duration = json_encode($inDuration);
    }
    function setDurationInTrafic($inDurationInTrafic){
        //example: {"S":{"D0":10,"D1":5},
        //          "D0":{"D1":10,"D2":5},
        //          "D1":{"D0":10,"D2":15}}
        //S adalah titik awal; D0, D1, dst adalah waypoint+destination
        $this->durationInTrafic = json_encode($inDurationInTrafic);
    }
    function setBobot($inBobot){
        //example: {"D0":0.5,"D1":0.9,"D2":0}        
        //D0, D1, dst adalah waypoint+destination
        $this->bobot = json_encode($inBobot);
    }
    
    //Fungsi Tujuan
    function getObjFunction($Dn, $Dt, $n1, $x){
        //$Dn Duration
        //$Dt Duration In Trafic
        //n1  Bobot Ruas Jalan Terdampak
        //$x  Distance  
        
        //Perhitungan Waktu Tempuh
        $n2 = ($Dn - ($Dt - $Dn))/$Dn;
        //perhitungan bobot ruas jalan terdampak dan waktu tempuh
        $y = 1 / (($n1+$n2)/2);
        //hasil perhitungan bobot dan panjang setiap ruas jalan
        $h = $y * $x;
        //Fungsi Tujuan
        $f = 1 / ((rand(0,100)/100)*$h);
    }    
    function setInitVelocity(){
        $this->velocity = [];
        for ($i=0;$i<PSORute::cPartikel;$i++){
            $this->velocity[$i] = [];
            for($j=0;$j<$this->cDimensi;$j++){
                $this->velocity[$i][$j] = 0.1;
            }
        }
    }
    function setInitPosition(){
        //Random 
        $this->position = [];
        for ($i=0;$i<PSORute::cPartikel;$i++){
            $this->position[$i] = [];
            for($j=0;$j<$this->cDimensi;$j++){
                $rand = rand(0, 1000)/1000;
                $index = "D".$j;
                $this->position[$i][$index] = $rand;
            }
        }
    }
    function setGBest(){
        for ($i=0;$i<count($this->position);$i++){
            if (count($this->GBest)==0){
                $this->GBest = $this->position[$i];
            }else{
                if ($this->getCalObjFunction($this->position[$i]) > $this->getCalObjFunction($this->GBest)){
                    $this->GBest = $this->position[$i];
                }
            }
        }
    }
    function setPBest(){
        for ($i=0;$i<count($this->position);$i++){
            if ($i==0){
                $this->PBest = $this->position[$i];
            }elseif ($this->getCalObjFunction($this->position[$i]) > $this->getCalObjFunction($this->pBest)){
                $this->PBest = $this->position[$i];
            }
        }
    }
    function getCalObjFunction($partikel){
        asort($partikel);
        $val = 0;
        $in = "";
        foreach ($partikel as $key => $value) {
            if ($in==""){
                $Dn = $this->duration['S'][$key];
                $Dt = $this->durationInTrafic['S'][$key];
                $n1 = $this->bobot[$key];
                $x = $this->distance['S'][$key];
                $val += $this->getObjFunction($Dn, $Dt, $n1, $x);
            }else{
                $Dn = $this->duration[$in][$key];
                $Dt = $this->durationInTrafic[$in][$key];
                $n1 = $this->bobot[$key];
                $x = $this->distance[$in][$key];
                $val += $this->getObjFunction($Dn, $Dt, $n1, $x);
                if (in_array($key, $this->destination)) break;
            }
            $in = $key;
        }    
        return $val;
    }
    
    function setUpdateVelocity(){
        //pv0+r1(Pbest-xi)+r2(Gbest-xi)
        for ($i=0;$i<count($this->velocity);$i++){
            $b1 = [];
            $b2 = [];
            $b3 = [];
            for ($j=0;$j<count($this->velocity[$i]);$j++){
                $index = "D".$j;
                //pv0->b1
                $b1[$j] = self::p * $this->velocity[$i]; 
                //r1(Pbest-xi)->b2
                $b2[$j] = self::r1*($this->pBest[$index] - $this->position[$i][$index]);
                //r2(Gbest-xi)->b3
                $b3[$j] = self::r2*($this->GBest[$index] - $this->position[$i][$index]);
            }
            //pv0+r1(Pbest-xi)+r2(Gbest-xi)->b1+b2+b3
            for($j=0;$j<count($b1);$j++){
                $this->velocity[$i][$j] = $b1[$j]+$b2[$j]+$b3[$j];
            }
        }
    }
    function setUpdatePosition(){
        for($i=0;$i<count($this->velocity);$i++){
            $tot = 0;
            for($j=0;$j<count($this->velocity[$i]);$j++){
                $index = "D".$j;
                $this->position[$i][$index] = $this->velocity[$i][$j] + $this->position[$i][$index];
                $tot += $this->position[$i][$index];
            }
            for($j=0;$j<count($this->velocity[$i]);$j++){
                $index = "D".$j;
                $this->position[$i][$index] = $this->position[$i][$index]/$tot;
            }
        }
    }
    function setIteration(){
        while ($this->iterasi < self::maxIterasi){
            $this->setUpdateVelocity();
            $this->setUpdatePosition();
            $this->setPBest();
            $this->setGBest();
            $this->iterasi++;
        }
    }
    function getOptimalRoute(){
        asort($this->GBest);
        $return = [];
        foreach ($this->GBest as $key=>$value){
            array_push($return, $key);
        }
        return $return;
    }
}

