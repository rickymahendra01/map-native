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
        <style>
            body {
            margin: 0;
            padding: 0;
            }

            .btn:disabled,
            .btn.disabled,
            fieldset:disabled .btn {
            pointer-events: none;
            opacity: 0.65;
            }

            .btn-primary1 {
            color: #FFFEFE;
            font-family: "Poppins", sans-serif;
            background-color: #0199f1;
            border-color: #0199f1;
            border-radius: 10px;
            width: 140px; /* Atur lebar sesuai kebutuhan */
            height: 40px; /* Atur tinggi sesuai kebutuhan */
            display: flex;
            align-items: center;
            justify-content: center;
            }

            .btn-primary1:hover {
            color: #FFFEFE;
            background-color: #0199f1;
            border-color: #0199f1;
            }

            .fixed-button {
            position: fixed;
            bottom: 20px;
            left: 20px;
            padding: 10px;
            font-size: 18px;
            text-decoration: none;
            background-color: #0199f1;
            color: #FFFEFE;
            border: none;
            border-radius: 10px;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease-in-out;
            }

            .fixed-button i {
            margin-right: 5px;
            }

            .fixed-button:hover {
            transform: scale(1.1);
            }

            .scroll-div {
            position: fixed;
            top: 20px;
            right: 20px;
            width: 300px; /* Atur lebar sesuai kebutuhan */
            height: 200px; /* Atur tinggi sesuai kebutuhan */
            overflow: scroll;
            border: 1px solid #333;
            background-color: #fff; /* Atur warna latar belakang solid */
            }

            .scroll-div1 {
            position: fixed;
            top: 20px;
            right: 20px;
            width: 300px; /* Atur lebar sesuai kebutuhan */
            height: 200px; /* Atur tinggi sesuai kebutuhan */
            overflow: scroll;
            border: 1px solid #333;
            background-color: #fff; /* Atur warna latar belakang solid */
            }

            .result {
            position: fixed;
            bottom: 20px;
            right: 20px;
            height: 380px; /* Atur tinggi sesuai kebutuhan */
            background-color: #f2f2f2; /* Warna latar belakang untuk result */
            }

            .directions-panel {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #e6e6e6; /* Warna latar belakang untuk directions-panel */
            }

            .placeholder {
            color: #999; /* Warna teks placeholder */
            }
        </style>
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
        <div id="map" style="width: 100%; height: 800px; display: inline-block;"></div>
        <a href="#" onclick="setShowData();" class="btn btn-primary1 btn-lg me-md-4 mb-3 mb-md-0 border-0 primary-btn-shadow fixed-button" role="button">
            <i class="fa fa-share"></i>&nbsp;<span class="font-poppins">Cari Rute</span>
        </a>
        <div id="result" class="scroll-div1 result" placeholder="Result"></div>
        <script src="./script.js"></script>
    </body>
</html>