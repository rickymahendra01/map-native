<?php
    $control->setLogout();
    $script = $control->view->getJs("location.href='./';");
    $response->setContent($script);
    $response->send();
?>
