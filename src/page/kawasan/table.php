<?php
    if (!$control->getStatusLogin()) exit;
    $dir = (explode(DIRECTORY_SEPARATOR,dirname(__FILE__))[count(explode(DIRECTORY_SEPARATOR,dirname(__FILE__)))-1]);
    
    $pageInfo = $control->getPageInfo($dir);
    
    $aColumns = ["id","namaKawasan","jenis","aktif"];
    $arrColumns = ["id","namaKawasan","jenis","aktif"];
    $sIndexColumn = "id";
    $sTable = "kawasan";
    $sWhere = "";
    $sJoin = "";
    $sOrder = "ORDER BY id ASC";
    require_once './src/Inc/dataTableSource.php';
    for ($i=0;$i<count($aRow);$i++){
        $row = array();
        $aktif = ($aRow[$i]->aktif=="1")
                  ? "<span class='badge badge-success bg-success'>Aktif</span>"
                  : "<span class='badge badge-danger bg-danger'>Tidak Aktif</span>";
        $row[] = $control->view->getCheckBoxTable("id_".$i, "id_".$i, $aRow[$i]->id); 
        $row[] = $aRow[$i]->namaKawasan;
        $row[] = $aRow[$i]->jenis;
        $row[] = $aktif;
        $row[] = $control->view->getDivCenter($control->view->getButtonEdit($dir, $aRow[$i]->id, $pageInfo['title'], $pageInfo['focus'], $control).
                                              $control->view->getButtonDelete($dir, $aRow[$i]->id));
        $output['aaData'][] = $row;
    } 
    $control->setSession("row", count($aRow));
    $response->setContent(json_encode( $output ));
    $response->send();
?> 
