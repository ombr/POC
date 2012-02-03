<?php
require_once __DIR__.'/lib/silex.phar'; 
$app = new Silex\Application(); 
$app['debug'] = true;

//Twig
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path'       => __DIR__.'//views',
    'twig.class_path' => __DIR__.'/lib/silex/vendor/twig/lib',
));
//Monolog
$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile'       => __DIR__.'/development.log',
    'monolog.class_path'    => __DIR__.'/lib/silex/vendor/monolog/src',
));

//UrlGeneratorServiceProvider
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());


//Authentification :
//!TODO Encapsulate in Silex ;-)
$app['autoloader']->registerNamespace('MultiAuth', __DIR__.'/lib/');
$app['MultiAuth']=function()use($app){

    require(__DIR__.'/configs/auth.php');

    return new MultiAuth\MultiAuth(
        array(
            //'loginPage'=>'/login',
            'hybridAuth'=>$hybridAuthConfigs,
            'loginPage'=>'/login',
            'loginProcess'=>'/loginProcess',
            'accountsFromProviderIdFunction'=>
            function($providerId,$userId) use($app){
                $query = $app['doctrine.orm.em']->createQuery('SELECT u
                    FROM \Models\User u LEFT JOIN u.providers p 
                    WHERE p.providerId = :providerId
                    AND p.userId = :userId');
                $query->setParameters(array(
                    'providerId' => $providerId,
                    'userId' => $userId,
                ));
                $array = $query->getResult();
                return $array;
            },
                'getAccountFunction'=> function($id) use($app){
                    if( isset( $id ) ){
                        return $app['doctrine.orm.em']->find('\Models\User',$id);
                    }
                    return null;
                },
                    'createAccountFunction'=>
                    function() use($app){
                        $user = new \Models\User();
                        $em = $app['doctrine.orm.em'];
                        $em->persist($user);
                        $em->flush();
                        return $user;
                    },
                        'addProviderToAccount'=>
                        function($account, $providerId, $userId, $datas)use($app){
                            $provider = new \Models\Provider();
                            $provider->setProviderId($providerId);
                            $provider->setDatas($datas);
                            $provider->setUserId($userId);
                            $em = $app['doctrine.orm.em'];
                            $em->persist($provider);
                            $account->addProvider($provider);
                            $em->flush();
                            return $user;
                        },
                        )
                    );

};

//Doctrine ORM :
require_once __DIR__.'/lib/silexextentions/silex_doctrine_extension.phar';
$app['autoloader']->registerNamespace('Models', __DIR__);
$app->register(new Knp\Silex\ServiceProvider\DoctrineServiceProvider(), array(
    'doctrine.dbal.connection_options' => array(
        'driver' => 'pdo_mysql',
        'dbname' => 'MultiAuth',
        'host' => 'localhost',
        'user'=>'root',
        'password'=>'root',
    ),
    'doctrine.orm' => true,
    'doctrine.orm.entities' => array(
        array(
            'type' => 'annotation',
            'path' => __DIR__.'/Models',
            'namespace' => 'Models'
        ),
    ),
    'doctrine.common.class_path'    => __DIR__.'/lib/doctrine/lib/vendor/doctrine-common/lib',
    'doctrine.dbal.class_path'    => __DIR__.'/lib/doctrine/lib/vendor/doctrine-dbal/lib',
    'doctrine.orm.class_path'    => __DIR__.'/lib/doctrine/lib/',
    //'doctrine.common.class_path'    => __DIR__.'/lib/silexextentions/vendor/doctrine-common/lib',
    //'doctrine.dbal.class_path'    => __DIR__.'/lib/silexextentions/vendor/doctrine-dbal/lib',
    //'doctrine.orm.class_path'    => __DIR__.'/lib/silexextentions/vendor/doctrine/lib',
));
use Doctrine\Common\Annotations\AnnotationRegistry;
AnnotationRegistry::registerLoader(function($class) use ($loader) {
$loader->loadClass($class);
    return class_exists($class, false);
});
AnnotationRegistry::registerFile(__DIR__.'/lib/doctrine/lib/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php');

//
//var_dump($app);
//var_dump($app['doctrine.orm.em']->getRepository('\Models\User'));

?>

