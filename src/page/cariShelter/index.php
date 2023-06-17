<?php
    if (!$control->getStatusLogin()) exit;
    $akun  = $control->getDataAkun();
    $dir = (explode(DIRECTORY_SEPARATOR,dirname(__FILE__))[count(explode(DIRECTORY_SEPARATOR,dirname(__FILE__)))-1]);
    $pageInfo = $control->getPageInfo($dir);
    $control->setCallPage($pageInfo['title'], $dir, "", $pageInfo['focus']);
    
    
    $response->setContent(
                $control->view->getDivRow($control->view->getDivSub("12","<iframe style='width: 100%; height: 700px; border: none;' src='optimasi/index.php'></iframe>")));
    $response->send();
?>
