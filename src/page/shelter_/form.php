<?php
    if (!$control->getStatusLogin()) exit;
    $akun  = $control->getDataAkun();
    $dir = (explode(DIRECTORY_SEPARATOR,dirname(__FILE__))[count(explode(DIRECTORY_SEPARATOR,dirname(__FILE__)))-1]);
    $pageInfo = $control->getPageInfo($dir);
    
    $shelter = $control->getRowDataById('shelter', ['id','namaShelter','alamat','longitude','latitude'], 
                                      $request->get('id'), 'id'); 
    $content =  $control->view->getFormName("form".$dir,$control->view->getFormInputText("hidden", "act", $request->get('act'), "0", "", "").
                    $control->view->getFormInputText("hidden", "id", $request->get('id'), "0", "", "").
                    $control->view->getDivInput("Nama Shelter", 
                                                $control->view->getFormInputText("text", "namaShelter", $shelter[0]->namaShelter, "100", "", "required=true")).
                    $control->view->getDivInput("Alamat", 
                                                $control->view->getFormInputText("text", "alamat", $shelter[0]->alamat, "100", "", "required=true")).
                    $control->view->getDivInput("Latitude/Longitude", 
                                                $control->view->getDivRow(
                                                    $control->view->getDivSub("6",
                                                       $control->view->getFormInputText("text", "latitude", $shelter[0]->latitude, "100", "", "required=true")
                                                    ).
                                                    $control->view->getDivSub("6",
                                                       $control->view->getFormInputText("text", "longitude", $shelter[0]->longitude, "100", "", "required=true")
                                                    )                                                        
                                                )).
                    $control->view->getFormButtonSubmitBack("form".$dir, "Simpan", $control->getSession($control->_PAGE))
                    ,"./?d=".$dir."&f=update.php"); 
    $response->setContent(
                $control->view->getDivRow($control->view->getDivSub("6",  
                                            $control->view->getPanel("12", "", "", $content, "")).
                                          $control->view->getDivSub("6",
                                            $control->view->getPanel("12", "", "", "<div class='form-check'>
                                                                                    <input class='form-check-input' type='checkbox' value='' id='penentuanLokasi'>
                                                                                    <label class='form-check-label' for='penentuanLokasi'>
                                                                                        Aktifkan Penentuan Lokasi
                                                                                    </label>
                                                                                  </div>".
                                                                                "<div id='map' style='width: 100%; height: 600px;'></div>", ""))
            ));
    $response->send();
?>
