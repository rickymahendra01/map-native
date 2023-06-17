<?php
    $username = $control->getText($request->get("username"));
    $password = $request->get("password");
    $status = $request->get("status");
    
    if ($control->getLogin($username,md5($password))){
        $response->setContent($control->view->getJs("top.location.href='./'"));
    }else{
        $response->setContent($control->view->setJs("top.$('#username').val('');
                                                     top.$('#password').val('');
                                                     top.$('#username').focus();
                                                     top.$('#pesanLogin').html('');
                                                     top.".$control->view->getNotification("danger", "Username atau Password salah !","pesanLogin")));
    }
    $response->send();
?>
