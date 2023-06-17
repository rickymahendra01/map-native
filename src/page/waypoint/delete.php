<?php
    if (!$control->getStatusLogin()) exit;
    $control->model->setStartTransaction();
    
    $kode = $control->getText($request->get("id"));
    
    $checkUpdate = $control->getDeleteData("waypoint", "kode", $kode);
    
    if ($checkUpdate)
        $checkUpdate = $control->getDeleteData("link", "kode_1", $kode);
    if ($checkUpdate)
        $checkUpdate = $control->getDeleteData("link", "kode_2", $kode);
    
    if ($checkUpdate){
        $control->model->setCommit();
        $control->view->setJs("top.".$control->view->getNotificationFloat("success","Data telah dihapus !").
                              "top.".$control->getSession($control->_PAGE));
    }else{
        $control->model->setRollBack();
        $control->view->setJs("top.".$control->view->getNotification("danger","Data gagal dihapus !", "pesan"));
    }
    
    
?>
