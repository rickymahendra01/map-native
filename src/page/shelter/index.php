<?php
    if (!$control->getStatusLogin()) exit;
    $akun  = $control->getDataAkun();
    $dir = (explode(DIRECTORY_SEPARATOR,dirname(__FILE__))[count(explode(DIRECTORY_SEPARATOR,dirname(__FILE__)))-1]);
    
    $pageInfo = $control->getPageInfo($dir);
    $control->setCallPage($pageInfo['title'], $dir, "table".$dir, $pageInfo['focus']);
    
    $r1 = $control->model->getListQuery("select kode, longitude, latitude from waypoint WHERE (jenis = 'shelter')",['kode','longitude','latitude']);
    $point1 = [];
    for($i=0;$i<count($r1);$i++){
        $point1[] = $r1[$i]->longitude.";".$r1[$i]->latitude.";".$r1[$i]->kode;
    }
    $cPoint1 = implode("#", $point1);
    
    $r2 = $control->model->getListQuery("select kode, longitude, latitude from waypoint WHERE (jenis = 'waypoint')",['kode','longitude','latitude']);
    $point2 = [];
    for($i=0;$i<count($r2);$i++){
        $point2[] = $r2[$i]->longitude.";".$r2[$i]->latitude.";".$r2[$i]->kode;
    }
    $cPoint2 = implode("#", $point2);
    
    $kawasan = $control->getRowData('kawasan',['file'],['aktif'],['1'],"","","");
    
    $response->setContent(
                $control->view->getDivRow($control->view->getDivSub("7",
                                            $control->view->getPanel("12", "", "", "<div id='map' style='width: 100%; height: 600px;'></div>", "")).
                                          $control->view->getDivSub("5",  
                                            $control->view->getPanel("12", "", "", "<input type='hidden' name='petaKml' id='petaKml' value='".$kawasan[0]->file."'> <input type='text' id='inShelter' style='display:none;' value='".$cPoint1."'> <input type='text' id='inWaypoint' style='display:none;' value='".$cPoint2."'>".
                                                                     "<div id='formShelter' style='max-height: 500px; overflow: auto;'></div>", ""))
            ));
    $response->send();
?>
