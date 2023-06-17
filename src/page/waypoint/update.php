<?php
    if (!$control->getStatusLogin()) exit;
    $dir = (explode(DIRECTORY_SEPARATOR,dirname(__FILE__))[count(explode(DIRECTORY_SEPARATOR,dirname(__FILE__)))-1]);
    
    $control->model->setStartTransaction();
    
    $arrFieldUnit = ["jenis","kode","longitude","latitude"];
    $arrDataUnit = ["waypoint",$request->get('kode'),$request->get('longitude'),$request->get('latitude')];
    
    $checkUpdate = $control->getInsertData("waypoint", $arrFieldUnit, $arrDataUnit);
    
    if ($checkUpdate){
        $r = explode(";", $request->get("link"));
        for ($i=0;$i<count($r);$i++){
            $check = $control->getRowDataById("waypoint",['kode'],$r[$i], "kode");
            if (count($check)>0){
                $checkUpdate = $control->getInsertData("link", ['kode_1','kode_2'], [$request->get('kode'),$r[$i]]);
            }
            if (!$checkUpdate) break;
        }
    }
    if ($checkUpdate){
        $control->model->setCommit();
        $control->view->setJs("top.".$control->view->getNotificationFloat("success","Data berhasil diperbaharui !").
                              "top.".$control->getSession($control->_PAGE));
    }else{
        $control->model->setRollBack();
        $control->view->setJs("top.".$control->view->getNotification("danger","Data gagal diperbaharui !", "pesan"));
    }
?>
