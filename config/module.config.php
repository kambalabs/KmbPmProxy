<?php
return [
    'service_manager' => [
        'invokables' => [
            'KmbPmProxy\Http\Client' => 'Zend\Http\Client',
            'KmbPmProxy\Model\EnvironmentHydrator' => 'KmbPmProxy\Model\EnvironmentHydrator',
            'KmbPmProxy\Model\PuppetClassValidator' => 'KmbPmProxy\Model\PuppetClassValidator',
        ],
        'factories' => [
            'KmbPmProxy\Client' => 'KmbPmProxy\ClientFactory',
            'KmbPmProxy\Options\ModuleOptions' => 'KmbPmProxy\Options\ModuleOptionsFactory',
            'KmbPmProxy\Service\Environment' => 'KmbPmProxy\Service\EnvironmentFactory',
            'KmbPmProxy\Service\PuppetModule' => 'KmbPmProxy\Service\PuppetModuleFactory',
            'KmbPmProxy\Service\PuppetClass' => 'KmbPmProxy\Service\PuppetClassFactory',
        ],
        'abstract_factories' => [
            'Zend\Log\LoggerAbstractServiceFactory',
        ],
        'aliases' => [
            'pmProxyPuppetModuleService' => 'KmbPmProxy\Service\PuppetModule',
            'pmProxyPuppetClassService' => 'KmbPmProxy\Service\PuppetClass',
        ],
        'shared' => [
            'KmbPmProxy\Model\PuppetClassValidator' => false,
        ],
    ],
    'translator' => [
        'translation_file_patterns' => [
            [
                'type' => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.mo',
            ],
        ],
    ],
];
