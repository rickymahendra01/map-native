<?php

class PSORute{
    var $distance; 
    var $links; 
    var $velocity;
    var $position;
    var $destination;
    //cDimension adalah jumlah waypoint + destination dengan urutan D0, D1, D2 dst
    var $cDimensi;
    var $point;
    var $iterasi = 0;
    var $pBest = [];
    var $GBest = [];
    //cPartikel adalah jumlah posisi
    const cPartikel = 50;
    const p = 0.75;
    const r1 = 0.4;
    const r2 = 0.6;
    const maxIterasi = 100;

    function __construct($inCDimensi, $inPoint, $inDistance, $inLinks, $inDestination, $weight) { 
        $this->setDistance($inDistance);
        $this->setLinks($inLinks);
        $this->setBobot($weight);
        $this->setDestination($inDestination);
        $this->setPoint($inPoint);
        $this->cDimensi = $inCDimensi;
        $this->setInitVelocity();
        $this->setInitPosition();
        $this->setPBest();
        $this->setGBest();
        $this->iterasi = 1;
        $this->setIteration();
    }
    function setDestination($inDestination){
        //Example : [D10,D11,D12]
        $this->destination = json_decode($inDestination);
    }
    function setPoint($inPoint){
        //Example : [D1,D2,D3]
        $this->point = json_decode($inPoint);
    }
    function setDistance($inDistance){
        //example: {"S":{"D0":10,"D1":5},
        //          "D0":{"D1":10,"D2":5},
        //          "D1":{"D0":10,"D2":15}}
        //S adalah titik awal; D0, D1, dst adalah waypoint+destination
        $this->distance = $this->getArraySub((array) json_decode($inDistance));
    }
    function setLinks($inLinks){
        //example: {"S":['D0','D1'],
        //          "D0":['D1','D2',]}
        //S adalah titik awal; D0, D1, dst adalah waypoint+destination
        $this->links = $this->getArraySub((array) json_decode($inLinks));
    }
    function setBobot($inBobot){
        //example: {"D0":0.5,"D1":0.9,"D2":0}        
        //D0, D1, dst adalah waypoint+destination
        $this->bobot = (array) json_decode($inBobot);
    }
    
    //Fungsi Tujuan
    function getObjFunction($n, $x){
        //n  Bobot Ruas Jalan Terdampak
        //$x  Distance  
        
        //Perhitungan Waktu Tempuh
        //$n2 = ($Dn>0) ? (($Dn - ($Dt - $Dn))/$Dn) : 0;
        
        //perhitungan bobot ruas jalan terdampak dan waktu tempuh
        //$y = 1 / (($n1+$n2)/2);
        //hasil perhitungan bobot dan panjang setiap ruas jalan
        //$h = $y * $x;
        //Fungsi Tujuan
        
        //$f = ($h>0) ?  (1 / ((rand(1,100)/100)*$h)) : 0;
        $f = (1/$x)*$n;
        
        return $f;
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
                $rand = rand(1, 1000)/1000;
                if ($j==0){ 
                    $index = 'S';
                    $this->position[$i][$index] = 0;
                }else{ 
                    $index = $this->point[$j];
                    $this->position[$i][$index] = $rand;
                }
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
        /*$x = $this->GBest;
        asort($x);
        print_r($x); print($this->getCalObjFunction($this->GBest)."<hr>");*/
    }
    function setPBest(){
        for ($i=0;$i<count($this->position);$i++){
            if ($i==0){
                $this->pBest = $this->position[$i];
            }elseif ($this->getCalObjFunction($this->position[$i]) > $this->getCalObjFunction($this->pBest)){
                $this->pBest = $this->position[$i];
            }
        }
    }
    function getSort($partikel){
        asort($partikel);
        $result = [];
        $n=0;
        foreach ($partikel as $key=>$value){
            if ($n==0) array_push($result, $key);
            else{
                $nextKeys = $this->links[$result[count($result)-1]];
                $tmp = [];
                foreach($nextKeys as $a=>$b){
                    $tmp[$b] = $partikel[$b];
                }
                asort($tmp);
                $check = FALSE;
                foreach ($tmp as $a => $b) {
                    if (in_array($a, $this->destination)){
                        array_push($result, $a);
                        $check = true;
                        break;
                    }
                } 
                if (!$check){
                    foreach ($tmp as $a => $b) {
                        if (!in_array($a, $result)){
                            array_push($result, $a);
                            $check = true;
                            break;
                        }
                    } 
                    if (!$check){
                        foreach ($tmp as $a => $b) {
                            array_push($result, $a);
                            break;
                        } 
                    }
                }
            }
            if (count($result) == count($partikel)) break;
            $n++;
        }
        return $result;
    }    
    function getCalObjFunction($partikel){ 
        //asort($partikel);   
        $partikel = $this->getSort($partikel);
        $val = 0;
        $in = "";
        foreach ($partikel as $n => $key) {
            if ($in==""){
                $n1 = $this->bobot[$key];
                if (in_array($key,$this->links['S'])){
                    $x = $this->distance['S'][$key];
                    $val += $this->getObjFunction($n1, $x);
                }else{
                    $val = 0; break;
                }
            }else{
                $n1 = $this->bobot[$key];
                if (in_array($key,$this->links[$in])){
                    $x = $this->distance[$in][$key];
                    $val += $this->getObjFunction($n1, $x);
                }else{
                    $val = 0; break;
                }
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
                if ($j==0){
                    $index = 'S';
                }else{
                    $index = $this->point[$j];
                }    
                //pv0->b1
                $b1[$j] = self::p * $this->velocity[$i][$j]; 
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
                if ($j==0) $index = 'S';
                else $index = $this->point[$j];
                $this->position[$i][$index] = $this->velocity[$i][$j] + $this->position[$i][$index];
                $tot += $this->position[$i][$index];
            }
            for($j=0;$j<count($this->velocity[$i]);$j++){
                if ($j==0) $index = 'S';
                else $index = $this->point[$j];
                if ($j==0) $this->position[$i][$index] = 0;
                else $this->position[$i][$index] = $this->position[$i][$index]/$tot;
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
        $ret = $this->getSort($this->GBest);
        $return = [];
        foreach ($ret as $n=>$key){
            array_push($return, $key);
            if (in_array($key, $this->destination)) break;
        }
        return $return;
    }
    function getArraySub($r){
        $n = [];
        foreach($r as $key=>$value){
            $n[$key] = (array) $value;
        }
        return $n;
    }
}

