<?php
    if (!$control->getStatusLogin()) exit;
    $dir = (explode(DIRECTORY_SEPARATOR,dirname(__FILE__))[count(explode(DIRECTORY_SEPARATOR,dirname(__FILE__)))-1]);
    
    $pageInfo = $control->getPageInfo($dir);
    $control->setCallPage($pageInfo['title'], $dir, "table".$dir, $pageInfo['focus']);
    
    $data = ['folder'=> $dir, 'title'=>$pageInfo['title'], 'table'=>"table". $dir, 
             'focus'=>$pageInfo['focus'], 'page_session'=>$control->getSession($control->_PAGE)];
    $field = ['Nama Kawasan','Jenis','Status'];
    $contentTable = $control->view->getPanel("12 mb-3", "", "", 
            "<div class='alert alert-info'>Setiap kawasan memiliki attribut keterangan yang terdiri atas Sangat Aman, Aman, Rawan, Sangat Rawan, Waspada</div>".
            $control->view->getDivContentTableSimple($data, $field, $control), "");
    $response->setContent($contentTable);
    $response->send();
?>
 