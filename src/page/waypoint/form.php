<?php
    if (!$control->getStatusLogin()) exit;
    $akun  = $control->getDataAkun();
    $dir = (explode(DIRECTORY_SEPARATOR,dirname(__FILE__))[count(explode(DIRECTORY_SEPARATOR,dirname(__FILE__)))-1]);
    $pageInfo = $control->getPageInfo($dir);
    
    $r = $control->model->getListQuery("SELECT kode FROM waypoint WHERE (jenis='waypoint') ORDER BY id DESC LIMIT 0,1",['kode']);
    
    $content =  $control->view->getFormName("form".$dir,
                    $control->view->getDivInput("*<small>Kode Terakhir ".$r[0]->kode."</small><br>Kode", 
                                                $control->view->getFormInputText("text", "kode", "", "5", "", "required=true style='width: 100px;'")).
                    $control->view->getDivInput("*<small>Silahkan tentukan point pada map</small><br>Longitude", 
                                                $control->view->getFormInputText("text", "longitude", "", "", "", "readonly style='background: #eee;'")).
                    $control->view->getDivInput("Latitude", 
                                                $control->view->getFormInputText("text", "latitude", "", "", "", "readonly style='background: #eee;'")).
                    $control->view->getDivInput("Link (Kode) *<small>Gunakan ; untuk pemisah</small>", 
                                                $control->view->getFormInputText("text", "link", "", "", "", "required=true")).
                    $control->view->getFormButtonSubmitBack("form".$dir, "Simpan", $control->getSession($control->_PAGE))
                    ,"./?d=".$dir."&f=update.php"); 
    $response->setContent($control->view->getPanel("12", "", "", $content, ""));
    $response->send();
?>
