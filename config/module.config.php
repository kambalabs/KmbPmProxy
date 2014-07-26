<?php
return [
    'service_manager' => [
        'invokables' => [
            'KmbPmProxy\Http\Client' => 'Zend\Http\Client',
            'KmbPmProxy\Model\EnvironmentHydrator' => 'KmbPmProxy\Model\EnvironmentHydrator',
        ],
        'factories' => [
            'KmbPmProxy\Service\PmProxy' => 'KmbPmProxy\Service\PmProxyFactory',
        ],
        'abstract_factories' => [
            'Zend\Log\LoggerAbstractServiceFactory',
        ],
    ],
];
