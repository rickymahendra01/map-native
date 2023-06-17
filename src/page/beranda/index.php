<?php
    $dir = (explode(DIRECTORY_SEPARATOR,dirname(__FILE__))[count(explode(DIRECTORY_SEPARATOR,dirname(__FILE__)))-1]);
    $pageInfo = $control->getPageInfo($dir);
    $control->setCallPage($pageInfo['title'], $dir, "table".$dir, $pageInfo['focus']);
    $akun = $control->getDataAkun();
    $content = $control->view->getDivRow(
                $control->view->getDivSub("3 mx-auto","<div class='beranda-text'>Selamat Datang,<br><strong>".$akun->nama.
                                                      "</strong></div><img src='assets/img/beranda.png' style='width:100%;'>".
                                                      "<div class='beranda-subtext text-danger'>Panel Pengelolaan Konten </div>")
            );
    $response->setContent($content);
    $response->send();
    
    