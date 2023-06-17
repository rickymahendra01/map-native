<?php
    if (!$control->getStatusLogin()) exit;
    $dir = (explode(DIRECTORY_SEPARATOR,dirname(__FILE__))[count(explode(DIRECTORY_SEPARATOR,dirname(__FILE__)))-1]);
    
    $pageInfo = $control->getPageInfo($dir);
    
    $aColumns = ["id","nama","email","noHp","username"];
    $arrColumns = ["id","nama","email","noHp","username"];
    $sIndexColumn = "id";
    $sTable = "akun";
    $sWhere = "";
    $sJoin = "";
    $sOrder = "ORDER BY id ASC";
    require_once './src/Inc/dataTableSource.php';
    for ($i=0;$i<count($aRow);$i++){
        $row = array();
        $row[] = $control->view->getCheckBoxTable("id_".$i, "id_".$i, $aRow[$i]->id); 
        $row[] = $aRow[$i]->nama;
        $row[] = $aRow[$i]->email;
        $row[] = $aRow[$i]->noHp;
        $row[] = $aRow[$i]->username; 
        $row[] = $control->view->getDivCenter($control->view->getButtonEdit($dir, $aRow[$i]->id, $pageInfo['title'], $pageInfo['focus'], $control).
                                              $control->view->getButtonDelete($dir, $aRow[$i]->id));
        $output['aaData'][] = $row;
    } 
    $control->setSession("row", count($aRow));
    $response->setContent(json_encode( $output ));
    $response->send();
?> 
