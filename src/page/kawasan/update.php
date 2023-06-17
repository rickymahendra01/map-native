<?php
    if (!$control->getStatusLogin()) exit;
    $dir = (explode(DIRECTORY_SEPARATOR,dirname(__FILE__))[count(explode(DIRECTORY_SEPARATOR,dirname(__FILE__)))-1]);
    
    $id = $control->getText($request->get("id"));
    $r = $control->model->getListQuery("SELECT file FROM kawasan WHERE id='".$id."'",['file']);
    
    $file = $control->uploadFile($_FILES['file']['tmp_name'], $_FILES['file']['name'], 
                                 ['kml'], $request->get("act"), $r[0]->file, "pesan");
    
    $control->model->setStartTransaction();
    
    $checkUpdate = TRUE;
    if ($request->get("aktif")=="1"){
        $checkUpdate = $control->model->getExeQuery("UPDATE kawasan SET aktif='0'");
    }
    if ($checkUpdate){
        $arrFieldUnit = ["namaKawasan","jenis","file","aktif"];
        $arrDataUnit = [$request->get('namaKawasan'),$request->get('jenis'),$file,$request->get('aktif')];
        if ($request->get('act')=="add"){
            $checkUpdate = $control->getInsertData("kawasan", $arrFieldUnit, $arrDataUnit);
            $r = $control->model->getListQuery("SELECT id FROM kawasan WHERE file='".$file."' ORDER BY id DESC",['id']);
            $id = $r[0]->id;
        }else{
            $checkUpdate = $control->getUpdateData("kawasan", $arrFieldUnit, $arrDataUnit, $request->get("id"), "id");
        }
    }
    if ($checkUpdate){
        $control->model->setCommit();
        $control->view->setJs("top.".$control->view->getNotificationFloat("success","Data berhasil diperbaharui !").
                              "top.".$control->getPageForm("Peta Kawasan Terdampak", "edit&id=".$id, $dir, ""));
    }else{
        $control->model->setRollBack();
        $control->view->setJs("top.".$control->view->getNotification("danger","Data gagal diperbaharui !", "pesan"));
    }
?>
