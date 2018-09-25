<?php
//http://php.net/manual/en/yaf-router.addconfig.php
return [
    'index' => [
        'type'  => 'regex', 'match' => '#^/(|index)$#', 
        'route' => [
            'module'     => 'Test', 
            'controller' => 'Index', 
            'action'     => 'index']
    ]
];

