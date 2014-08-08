<?php
return [
    'service_manager' => [
        'invokables' => [
            'KmbPmProxy\Http\Client' => 'Zend\Http\Client',
            'KmbPmProxy\Model\EnvironmentHydrator' => 'KmbPmProxy\Model\EnvironmentHydrator',
        ],
        'factories' => [
            'KmbPmProxy\Client' => 'KmbPmProxy\ClientFactory',
            'KmbPmProxy\Options\ModuleOptions' => 'KmbPmProxy\Options\ModuleOptionsFactory',
            'KmbPmProxy\Service\Environment' => 'KmbPmProxy\Service\EnvironmentFactory',
            'KmbPmProxy\Service\Module' => 'KmbPmProxy\Service\ModuleFactory',
        ],
        'abstract_factories' => [
            'Zend\Log\LoggerAbstractServiceFactory',
        ],
    ],
];
