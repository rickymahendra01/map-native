<?php
    if (!$control->getStatusLogin()) exit;
    $akun  = $control->getDataAkun();
    $dir = (explode(DIRECTORY_SEPARATOR,dirname(__FILE__))[count(explode(DIRECTORY_SEPARATOR,dirname(__FILE__)))-1]);
    
    $pageInfo = $control->getPageInfo($dir);
    $control->setCallPage($pageInfo['title'], $dir, "table".$dir, $pageInfo['focus']);
    
    $r = $control->model->getListQuery("select kode, longitude, latitude from waypoint WHERE (jenis = 'waypoint')",['kode','longitude','latitude']);
    $point = [];
    for($i=0;$i<count($r);$i++){
        $point[] = $r[$i]->longitude.";".$r[$i]->latitude.";".$r[$i]->kode;
    }
    $cPoint = implode("#", $point);
    
    $r1 = $control->model->getListQuery("select kode, longitude, latitude from waypoint WHERE (jenis = 'shelter')",['kode','longitude','latitude']);
    $point1 = [];
    for($i=0;$i<count($r1);$i++){
        $point1[] = $r1[$i]->longitude.";".$r1[$i]->latitude.";".$r1[$i]->kode;
    }
    $cPoint1 = implode("#", $point1);
    
    $kawasan = $control->getRowData('kawasan',['file'],['aktif'],['1'],"","","");
    
    $response->setContent(
                $control->view->getDivRow($control->view->getDivSub("7",
                                            $control->view->getPanel("12", "", "", "<div id='map' style='width: 100%; height: 600px;'></div>", "")).
                                          $control->view->getDivSub("5",  
                                            $control->view->getPanel("12", "", "", "<input type='hidden' name='petaKml' id='petaKml' value='".$kawasan[0]->file."'> <input type='text' id='inWaypoint' style='display:none;' value='".$cPoint."'> <input type='text' id='inShelter' style='display:none;' value='".$cPoint1."'>".
                                                                     "<div id='formWaypoint' style='max-height: 500px; overflow: auto;'></div>", ""))
            ));
    $response->send();
?>
