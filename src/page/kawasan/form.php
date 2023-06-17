<?php
    if (!$control->getStatusLogin()) exit;
    $akun  = $control->getDataAkun();
    $dir = (explode(DIRECTORY_SEPARATOR,dirname(__FILE__))[count(explode(DIRECTORY_SEPARATOR,dirname(__FILE__)))-1]);
    $pageInfo = $control->getPageInfo($dir);
    
    $kawasan = $control->getRowDataById('kawasan', ['id','namaKawasan','jenis','file','aktif'], 
                                      $request->get('id'), 'id'); 
    $listJenis = [(object) ['value'=>'Banjir','title'=>'Banjir'],
                  (object) ['value'=>'Kebakaran','title'=>'Kebakaran'],
                  (object) ['value'=>'Angin','title'=>'Angin'],
                  (object) ['value'=>'Tsunami','title'=>'Tsunami'],
                  (object) ['value'=>'Gempa Bumi','title'=>'Gempa Bumi']];
    $listAktif = [(object) ['value'=>'1','title'=>'Ya'],
                  (object) ['value'=>'0','title'=>'Tidak']];
    $content =  $control->view->getFormName("form".$dir,$control->view->getFormInputText("hidden", "act", $request->get('act'), "0", "", "").
                    $control->view->getFormInputText("hidden", "id", $request->get('id'), "0", "", "").
                    "<input type='text' style='display:none;' id='fileKml' value='".$kawasan[0]->file."'>".
                    $control->view->getDivInput("Nama Kawasan", 
                                                $control->view->getFormInputText("text", "namaKawasan", $kawasan[0]->namaKawasan, "100", "", "required=true")).
                    $control->view->getDivInput("Jenis", 
                                                $control->view->getFormSelect("jenis", "", "select2", $listJenis, $kawasan[0]->jenis)).
                    $control->view->getDivInput("file Peta Kawasan (KML File)", 
                                                $control->view->getFormInputText("file", "file", "", "", "", "required=true")).
                    $control->view->getDivInput("Aktif", 
                                                $control->view->getFormSelect("aktif", "", "select2", $listAktif, $kawasan[0]->aktif)).
                    $control->view->getFormButtonSubmitBack("form".$dir, "Simpan", $control->getSession($control->_PAGE))
                    ,"./?d=".$dir."&f=update.php"); 
    $response->setContent(
                $control->view->getDivRow($control->view->getPanel("6", "", "", $content, "").
                                          $control->view->getPanel("6", "", "", "<h6>Layout Peta Kawasan</h6><div id='map' style='width: 100%; height: 500px;'></div>", ""))
            );
    $response->send();
?>
