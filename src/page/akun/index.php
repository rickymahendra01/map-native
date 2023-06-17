<?php
    if (!$control->getStatusLogin()) exit;
    $dir = (explode(DIRECTORY_SEPARATOR,dirname(__FILE__))[count(explode(DIRECTORY_SEPARATOR,dirname(__FILE__)))-1]);
    
    $pageInfo = $control->getPageInfo($dir);
    $control->setCallPage($pageInfo['title'], $dir, "table".$dir, $pageInfo['focus']);
    
    $account = $control->getDataAkun();
    $akses = $control->getSession($control->_STATUS_);
     
    $contentFormAkun =  $control->view->getFormNameMessage("formAkun",
                            $control->view->getDivRow(
                                $control->view->getDivSub("6",
                                    $control->view->getDivInput("Nama", 
                                                                $control->view->getFormInputText("text", "nama", $account->nama, "", "", "readonly disabled")).
                                    $control->view->getDivInput("Email", 
                                                                $control->view->getFormInputText("text", "email", $account->email, "", "", "readonly disabled")).
                                    $control->view->getDivInput("No.Hp", 
                                                                $control->view->getFormInputText("text", "noHp", $account->noHp, "", "", "readonly disabled"))
                                ).
                                $control->view->getDivSub("6",
                                    $control->view->getDivInput("Username", 
                                                                $control->view->getFormInputText("text", "username", $account->username, "", "", "required=true")).
                                    $control->view->getDivInput("Passsword Saat Ini", 
                                                                 $control->view->getFormInputText("password", "passwordLama", "", "", "", "required=true")).
                                    $control->view->getDivInput("Password Baru", 
                                                                 $control->view->getFormInputText("password", "password", "", "", "", "required=true")).
                                    $control->view->getDivInput("Konfirmasi Password Baru", 
                                                                 $control->view->getFormInputText("password", "konfirmasiPassword", "", "", "", "required=true")).
                                    $control->view->getFormButtonSubmitMessage("formAkun", "Simpan", "pesanAkun")
                                )
                            ),
                            "./?d=".$dir."&f=edit.php","pesanAkun");
    
    $content =  $control->view->getPanel("8 offset-md-2 mb-3 mt-4", "", "", $contentFormAkun, "");
    $response->setContent($content);
    $response->send();
