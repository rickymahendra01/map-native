<?php
    include_once './vendor/autoload.php';
    include_once './src/Class/Control.php';
    include_once './src/Class/excel_reader2.php';
    include_once './src/Application.php';
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    $response = new Response();
    $request = Request::createFromGlobals();
    $control = new Control();
    $app = new Application();
    $app->handle($request, $response, $control);
    
