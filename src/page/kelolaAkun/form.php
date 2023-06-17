<?php
    if (!$control->getStatusLogin()) exit;
    $akun  = $control->getDataAkun();
    $dir = (explode(DIRECTORY_SEPARATOR,dirname(__FILE__))[count(explode(DIRECTORY_SEPARATOR,dirname(__FILE__)))-1]);
    $pageInfo = $control->getPageInfo($dir);
    
    $akun = $control->getRowDataById('akun', ['id','nama','email','noHp','username','password'], 
                                      $request->get('id'), 'id'); 
    $keterangan = (count($akun)) ? "<br><small>Kosongkan jika tidak mengubah password</small>" : "";
    $jk = [(object) ['value'=>'L','title'=>'L'],(object) ['value'=>'P','title'=>'P']];
    $content =  $control->view->getFormName("form".$dir,$control->view->getFormInputText("hidden", "act", $request->get('act'), "0", "", "").
                    $control->view->getFormInputText("hidden", "id", $request->get('id'), "0", "", "").
                    $control->view->getDivInput("Nama", 
                                                $control->view->getFormInputText("text", "nama", $akun[0]->nama, "50", "", "required=true")).
                    $control->view->getDivInput("Email", 
                                                $control->view->getFormInputText("email", "email", $akun[0]->email, "100", "", "required=true")).
                    $control->view->getDivInput("No.Hp", 
                                                $control->view->getFormInputText("text", "noHp", $akun[0]->noHp, "25", "", "required=true")).
                    $control->view->getDivInput("Username", 
                                                $control->view->getFormInputText("text", "username", $akun[0]->username, "25", "", "required=true")).
                    $control->view->getDivInput("Password ".$keterangan, 
                                                $control->view->getFormInputText("password", "password", "", "25", "", "required=true")).
                    $control->view->getDivInput("Konfirmasi Password", 
                                                $control->view->getFormInputText("password", "konfirmasiPassword", "", "25", "", "required=true")).
                    $control->view->getFormButtonSubmitBack("form".$dir, "Simpan", $control->getSession($control->_PAGE))
                    ,"./?d=".$dir."&f=update.php"); 
    $response->setContent($control->view->getPanel("6", "", "", $content, ""));
    $response->send();
?>
