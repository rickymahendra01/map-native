<?php
    if (!$control->getStatusLogin()) exit;
    $dir = (explode(DIRECTORY_SEPARATOR,dirname(__FILE__))[count(explode(DIRECTORY_SEPARATOR,dirname(__FILE__)))-1]);

    $account = $control->getDataAkun();
    $akses = $control->getSession($control->_STATUS_);
    
    //Check Username dan Password
    if ($request->get('password')!=$request->get('konfirmasiPassword')){
        $control->view->setJs("top.".$control->view->getNotification("danger","Konfirmasi Password tidak sesuai !", "pesanAkun"));
        exit;
    } 
    if (md5($request->get("passwordLama"))!=$account->password){
        $control->view->setJs("top.".$control->view->getNotification("danger","Password Saat Ini tidak sesuai !", "pesanAkun"));
        exit;
    }
    
    $control->model->setStartTransaction();
    
    $arrFieldAkun = ['username','password'];
    $arrDataAkun = [$request->get('username'),md5($request->get('password'))];
    $checkUpdate = $control->getUpdateData('akun', $arrFieldAkun, $arrDataAkun, $account->id, "id");
    
    if ($checkUpdate){
        $control->model->setCommit();
        $control->view->setJs("top.$('#passwordLama').val(''); top.$('#password').val(''); top.$('#konfirmasiPassword').val('');
                               top.".$control->view->getNotification("success","Data berhasil diperbaharui !", "pesanAkun"));
    }else{
        $control->model->setRollBack();
        $control->view->setJs("top.".$control->view->getNotification("danger","Data gagal diperbaharui !", "pesanAkun"));
    }
?>
