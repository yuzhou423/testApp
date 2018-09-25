<?php
return [
    'application'=>[
        'directory'  => APP_PATH,
        'bootstrap'  => APP_PATH .'/Bootstrap.php',
        'library'    => CORES_PATH .'/library',
        'system'     => ['use_spl_autoload'=>true],
        'view'       => ['autoRender'=>false,'ext'=>'html'],
        'modules'    => 'Api,Home,Index,V1,Test',
        'dispatcher' => ['catchException'=>false,'throwException'=>false],
        'routes'     => require('Routes.php'),
        'db'         => require('Db.php'),
        'redis'      => require('Redis.php'),
    ]
];