<?php
    const USER_DB = 'root';
    const PASSWORD_DB = '';
    const NAME_DB = 'db_panduevakuasi';
    const HOST_DB = 'localhost';
    const PORT_DB = '3306';

    
    function getConnectionDb(){
        try{
            $conn = new PDO("mysql:host=".HOST_DB.";dbname=".NAME_DB,USER_DB,PASSWORD_DB);  
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        }catch(PDOException $ex){
            print("Terjadi kesalahan koneksi/akses database");
            die();
        }
    }
    
    $rKml = getConnectionDb()->prepare("SELECT file FROM kawasan WHERE (aktif='1')");
    $rKml->execute();
    $kml = $rKml->fetch();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>getData</title>
        <script src="../assets/openLayers/dist/ol.js"></script>
        <link rel="stylesheet" href="../assets/openLayers/ol.css" type="text/css">
        <script>
            var waypoints = new Array();
            var shelters = new Array();
            var _point_ = new Array();
            _point_.push('S');
            var petaKML = "../assets/kawasan/<?php print($kml['file']);?>";
            <?php
                $d = 0;
                $rWaypoints = getConnectionDb()->prepare("SELECT kode, latitude, longitude FROM waypoint WHERE (jenis='waypoint')");
                $rWaypoints->execute();
                while($waypoint = $rWaypoints->fetch()){
                    print("waypoints.push({'kode':'".$waypoint['kode']."','lat':".$waypoint['latitude'].",'lng':".$waypoint['longitude']."}); 
                          ");
                    $d++;
                }
                $rShelters = getConnectionDb()->prepare("SELECT kode, latitude, longitude FROM waypoint WHERE (jenis='shelter')");
                $rShelters->execute();
                while($shelter = $rShelters->fetch()){
                    print("waypoints.push({'kode':'".$shelter['kode']."','lat':".$shelter['latitude'].",'lng':".$shelter['longitude']."});
                          ");
                    print("shelters.push('".$shelter['kode']."');
                          ");
                    $d++;
                }
                $rWpLink = getConnectionDb()->prepare("SELECT kode FROM waypoint");
                $rWpLink->execute();
                print("var links_ = {'S' : [], ");
                while($wpLink = $rWpLink->fetch()){
                    print("'".$wpLink['kode']."' : [");
                    $rLink = getConnectionDb()->prepare("SELECT kode_1, kode_2 FROM link WHERE (kode_1 = :kode) OR (kode_2 = :kode) ");
                    $rLink->execute(['kode'=>$wpLink['kode']]);
                    $n = [];
                    while ($link = $rLink->fetch()){
                        if ($link['kode_1']==$wpLink['kode']) array_push($n,"'".$link['kode_2']."'");
                        else array_push($n,"'".$link['kode_1']."'");
                    }
                    print(implode(",", $n));
                    print("],
                          ");
                }
                print("};");
                $rPoints = getConnectionDb()->prepare("SELECT kode FROM waypoint");
                $rPoints->execute();
                while($points = $rPoints->fetch()){
                    print("_point_.push('".$points['kode']."'); 
                          ");
                    $d++;
                }
            ?>
        </script>
    </head>
    <body>
        <div id="map" style="width: 55%; height: 600px; display: inline-block;"></div>
        <div style="width:40%; display: inline-block; vertical-align: top;">
            <img src="waypoint.png"> waypoint | <img src="shelter.png"> shelter<br>
            <label>Silahkan pilih titik awal kemudian klik dapatkan data</label><br>
            Titik Awal : <label id='titikAwal'></label><br>
            <a href="#" onclick="setShowData();">Dapatkan Data dan Telusuri Rute Terbaik</a>
            <div id="result" style="width: 100%; height: 600px; overflow: scroll; border: 1px solid #333;"></div>
        </div>
        <script src="./script.js"></script>
    </body>
</html>