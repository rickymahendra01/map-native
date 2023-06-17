<?php
    if (!$control->getStatusLogin()) exit;
    $dir = (explode(DIRECTORY_SEPARATOR,dirname(__FILE__))[count(explode(DIRECTORY_SEPARATOR,dirname(__FILE__)))-1]);
    
    $control->model->setStartTransaction();
    $checkUpdate = TRUE;
    $n = 0;
    for ($i=0;$i< intval($control->getSession("row"));$i++){
        $index = 'id_'.$i;
        if ($request->get($index)!=NULL){
            $n++;
            $id = $control->getText($request->get($index));
            
            $r = $control->model->getListQuery("SELECT file FROM kawasan WHERE id='".$id."'",['file']);
            if (is_file("./assets/kawasan/".$r[0]->file)) unlink(("./assets/kawasan/".$r[0]->file));
            
            $checkUpdate = $control->getDeleteData("kawasan", "id", $id);
            if (!$checkUpdate) break;
        }
    }
    if($n==0){
        $control->model->setRollBack();
        $control->view->setJs("top.".$control->view->getNotification("danger","Pilih Data terlebih dahulu !", "pesan"));
    }elseif ($checkUpdate){
        $control->model->setCommit();
        $control->view->setJs("top.".$control->view->getNotificationFloat("success","Data telah dihapus !").
                              "top.".$control->getSession($control->_PAGE));
    }else{
        $control->model->setRollBack();
        $control->view->setJs("top.".$control->view->getNotification("danger","Data gagal dihapus !", "pesan"));
    }
?>
