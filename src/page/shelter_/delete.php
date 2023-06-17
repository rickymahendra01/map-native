<?php
    if (!$control->getStatusLogin()) exit;
    $control->model->setStartTransaction();
    
    $id = $control->getText($request->get("id"));
    
    $checkUpdate = $control->getDeleteData("shelter", "id", $id);
    if ($checkUpdate){
        $control->model->setCommit();
        $control->view->setJs("top.".$control->view->getNotificationFloat("success","Data telah dihapus !").
                              "top.".$control->getSession($control->_PAGE));
    }else{
        $control->model->setRollBack();
        $control->view->setJs("top.".$control->view->getNotification("danger","Data gagal dihapus !", "pesan"));
    }
    
    
?>
