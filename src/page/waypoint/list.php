<?php
    if (!$control->getStatusLogin()) exit;
    $akun  = $control->getDataAkun();
    $dir = (explode(DIRECTORY_SEPARATOR,dirname(__FILE__))[count(explode(DIRECTORY_SEPARATOR,dirname(__FILE__)))-1]);
    $pageInfo = $control->getPageInfo($dir);
    
    $r = $control->model->getListQuery("select kode, longitude, latitude from waypoint WHERE jenis='waypoint' ORDER BY id DESC",['kode','longitude','latitude']);
    $content = "<button class='btn btn-primary' onclick=\"createWaypoint = true;
                                                          callSingle('waypoint', 'form.php', '', 'formWaypoint');\">Buat Point</button><hr>
                <ol style='list-style: none; margin-left: 0px; padding-left: 0px;'>";
    for($i=0;$i<count($r);$i++){
        $link = $control->model->getListQuery("SELECT kode_1, kode_2 FROM link WHERE (kode_1 = '".$r[$i]->kode."') OR (kode_2 = '".$r[$i]->kode."')",
                                             ['kode_1','kode_2']);
        $listLink = [];
        for ($j=0;$j<count($link);$j++){
            if ($r[$i]->kode==$link[$j]->kode_1) array_push($listLink, $link[$j]->kode_2);
            else array_push($listLink, $link[$j]->kode_1);
        }
        $content .= "<li style='border-bottom: 1px dotted #ccc;'>".$control->view->getButtonDelete($dir, $r[$i]->kode)."  
                         <a href='#' onclick=\"setZoom([".$r[$i]->longitude.",".$r[$i]->latitude."]);\"><i class='fas fa-eye'></i></a> 
                         <div style='display: inline; font-size: 0.9em; padding-left: 15px;'><strong>".$r[$i]->kode."</strong> | Link : ". implode(", ", $listLink)."</div></li>";
    }
    $content .= "</ol>";
    $control->setShow($content);