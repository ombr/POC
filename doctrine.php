<?php
require_once('bootstrap.php');

echo  __DIR__.'/lib/silexextentions/vendor/';
$app['autoloader']->registerNamespace('Symfony', __DIR__.'/lib/doctrine/lib/vendor/');
$helpers = array(
    'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($app['doctrine.orm.em']->getConnection()),
    'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($app['doctrine.orm.em'])
);
$helperSet = new \Symfony\Component\Console\Helper\HelperSet();
foreach ($helpers as $name => $helper) {
    $helperSet->set($helper, $name);
}
\Doctrine\ORM\Tools\Console\ConsoleRunner::run($helperSet);
?>
