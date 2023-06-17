<?php
    if (!$control->getStatusLogin()) exit;
    $control->model->setStartTransaction();
    
    $id = $control->getText($request->get("id"));
    
    $r = $control->model->getListQuery("SELECT file FROM kawasan WHERE id='".$id."'",['file']);
    if (is_file("./assets/kawasan/".$r[0]->file)) unlink(("./assets/kawasan/".$r[0]->file));
            
    $checkUpdate = $control->getDeleteData("kawasan", "id", $id);
    if ($checkUpdate){
        $control->model->setCommit();
        $control->view->setJs("top.".$control->view->getNotificationFloat("success","Data telah dihapus !").
                              "top.".$control->getSession($control->_PAGE));
    }else{
        $control->model->setRollBack();
        $control->view->setJs("top.".$control->view->getNotification("danger","Data gagal dihapus !", "pesan"));
    }
    
    
?>
