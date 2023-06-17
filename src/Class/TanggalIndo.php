<?php
    class TanggalIndo{
        function setTanggal($tgl,$bln,$thn,$d,$m,$y,$awal){
            //tanggal
            echo "<select name='$tgl' id='$tgl' class='text' style='width:50px;'>";
            for ($i=1;$i<=31;$i++){
                if ($i==$d){
                    echo "<option value='$i' selected>$i</option>";
                }else{
                    echo "<option value='$i'>$i</option>";
                }
            }
            echo "</select>";

            //bulan
            $isi = array("Bulan","Januari","Februari","Maret","April","Mei","Juni","Juli",
                         "Agustus","September","Oktober","November","Desember");
            echo "<select name='$bln' id='$bln' class='text' style='width:100px;'>";
            for ($i=1;$i<=12;$i++){
                if ($i==$m){
                    echo "<option value='$i' selected>$isi[$i]</option>";
                }else{
                    echo "<option value='$i'>$isi[$i]</option>";
                }
            }
            echo "</select>";

            //Tahun
            echo "<select name='$thn' id='$thn' class='text' style='width:80px;'>";
            $x = date("Y")+5;
            for ($i=$awal;$i<=$x;$i++){
                if ($i==$y){
                    echo "<option value='$i' selected>$i</option>";
                }else{
                    echo "<option value='$i'>$i</option>";
                }
            }
            echo "</select>";
        }

        //Komponen tanggal format Indonesia
        function getTanggalIndo($data){
            list($thn,$getbln,$tgl) = explode("-",$data);
            switch ($getbln){
                case "1" : $bln = "Januari";
                            break;
                case "2" : $bln = "Februari";
                            break;
                case "3" : $bln = "Maret";
                            break;
                case "4" : $bln = "April";
                            break;
                case "5" : $bln = "Mei";
                            break;
                case "6" : $bln = "Juni";
                            break;
                case "7" : $bln = "Juli";
                            break;
                case "8" : $bln = "Agustus";
                            break;
                case "9" : $bln = "September";
                            break;
                case "10" : $bln = "Oktober";
                            break;
                case "11" : $bln = "November";
                            break;
                case "12" : $bln = "Desember";
                            break;
            }
            return $tgl." ".$bln." ".$thn;
        }
    }
?>