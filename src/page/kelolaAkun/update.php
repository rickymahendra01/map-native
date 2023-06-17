<?php
    if (!$control->getStatusLogin()) exit;
    $dir = (explode(DIRECTORY_SEPARATOR,dirname(__FILE__))[count(explode(DIRECTORY_SEPARATOR,dirname(__FILE__)))-1]);
    
    if ($request->get("act")=="add"){
        $password = md5($request->get("password"));
    }else{
        if ($request->get('password')==""){
            $r = $control->model->getListQuery("SELECT password FROM akun WHERE id='".$control->getText($request->get("id"))."'",
                                            ['password']);
            $password = $r[0]->password;
        }else{
            $password = md5($request->get("password"));
        }
    }
    
    $control->model->setStartTransaction();
    
    $arrFieldAdmin = ['nama','email','noHp','username','password'];
    $arrDataAdmin = [$request->get('nama'), $request->get('noHp'),
                     $request->get('email'), $request->get('username'),$password];
    if ($request->get('act')=="add"){
        $checkUpdate = $control->getInsertData("akun", $arrFieldAdmin, $arrDataAdmin);
    }else{
        $checkUpdate = $control->getUpdateData("akun", $arrFieldAdmin, $arrDataAdmin, $request->get("id"), "id");
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
