<?php
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    class Application{
        public function handle(Request $request, Response $response, Control $control){
            if ($control->getStatusLogin()){
                if ($request->get("d")){
                    if (is_file("./src/page/".$request->get("d")."/".$request->get("f")))
                        require_once ("./src/page/".$request->get("d")."/".$request->get("f"));
                    else
                        require_once ("./src/page/404.html");
                }else{
                    $page = file_get_contents("./src/page/index.html");
                    $account = $control->getDataAkun();
                    
                    if (!$control->getIssetSession($control->_PAGE))
                        $control->setSession($control->_PAGE, $control->getPage("Beranda", "beranda", "tableberanda", "null"));
                    
                    $notifScript = "";
                    $account = $control->getDataAkun();  
                    
                    $script = $notifScript. 
                              "$('#statusLogin').html('Akun Anda');
                               $('#namaLogin').html('".$account->nama."');
                               ".$control->getSession($control->_PAGE)."
                               callSingle('menu', 'menu.html', '', 'menu', false);";
                    $response->setContent($page.$control->view->getJs($script));
                    $response->send();
                }
            }else{
                if ($request->get("d")){
                    require_once ("./src/page/".$request->get("d")."/".$request->get("f"));
                }else{
                    $page = file_get_contents("./src/page/login.html");
                    $response->setContent($page);
                    $response->send();
                }
            }
        }
    }