<?php
require_once __DIR__.'/../bootstrap.php'; 
$app->get(
    '/', 
    function() use($app) { 
        return $app->redirect('home');
    }
)->bind('index'); 

$app->get(
    '/home', 
    function() use($app) { 
        return $app['twig']->render('index.twig', array());
    }
)->bind('home'); 

//Authentification :
$app->get(
    '/login', 
    function() use($app) { 
        //$app['MultiAuth']->login();
        return $app['twig']->render(
            'login.twig',
            array(
                'MultiAuth'=>$app['MultiAuth']
            )
        );
    }
)->bind('login'); 


$app->get(
    '/loginProcess/{providerName}', 
    function($providerName) use($app) { 
        $app['MultiAuth']->login(false,$providerName);
        return $app->redirect('/profile');
    }
)->bind('loginProcess'); 


$app->get(
    '/logout', 
    function() use($app) { 
        $app['MultiAuth']->logout();
        return $app->redirect('home');
    }
)->bind('logout'); 


$app->get(
    '/profile', 
    function() use($app) { 
        $app['MultiAuth']->login();
        return $app['twig']->render(
            'profile.twig',
            array(
                'MultiAuth'=>$app['MultiAuth']
            )
        );
    }
)->bind('profile'); 

$app->run();
?>

