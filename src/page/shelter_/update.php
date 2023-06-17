<?php
    if (!$control->getStatusLogin()) exit;
    $dir = (explode(DIRECTORY_SEPARATOR,dirname(__FILE__))[count(explode(DIRECTORY_SEPARATOR,dirname(__FILE__)))-1]);
    
    $id = $control->getText($request->get("id"));
     
    $control->model->setStartTransaction();
    
    $arrFieldUnit = ["namaShelter","alamat","longitude","latitude"];
    $arrDataUnit = [$request->get('namaShelter'),$request->get('alamat'),$request->get('longitude'),$request->get('latitude')];
    if ($request->get('act')=="add"){
        $checkUpdate = $control->getInsertData("shelter", $arrFieldUnit, $arrDataUnit);
    }else{
        $checkUpdate = $control->getUpdateData("shelter", $arrFieldUnit, $arrDataUnit, $request->get("id"), "id");
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
