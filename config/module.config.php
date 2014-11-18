<?php
return [
    'service_manager' => [
        'invokables' => [
            'KmbPmProxy\Http\Client' => 'Zend\Http\Client',
            'KmbPmProxy\Hydrator\EnvironmentHydrator' => 'KmbPmProxy\Hydrator\EnvironmentHydrator',
            'KmbPmProxy\Hydrator\GroupParameterHydrator' => 'KmbPmProxy\Hydrator\GroupParameterHydrator',
            'KmbPmProxy\Validator\PuppetClassValidator' => 'KmbPmProxy\Validator\PuppetClassValidator',
        ],
        'factories' => [
            'KmbPmProxy\Client' => 'KmbPmProxy\ClientFactory',
            'KmbPmProxy\Options\ModuleOptions' => 'KmbPmProxy\Options\ModuleOptionsFactory',
            'KmbPmProxy\Service\Environment' => 'KmbPmProxy\Service\EnvironmentFactory',
            'KmbPmProxy\Service\PuppetModule' => 'KmbPmProxy\Service\PuppetModuleFactory',
            'KmbPmProxy\Service\PuppetClass' => 'KmbPmProxy\Service\PuppetClassFactory',
            'KmbPmProxy\Hydrator\GroupClassHydrator' => 'KmbPmProxy\Hydrator\GroupClassHydratorFactory',
            'KmbPmProxy\Hydrator\GroupHydrator' => 'KmbPmProxy\Hydrator\GroupHydratorFactory',
            'KmbPmProxy\Hydrator\RevisionHydrator' => 'KmbPmProxy\Hydrator\RevisionHydratorFactory',
        ],
        'abstract_factories' => [
            'Zend\Log\LoggerAbstractServiceFactory',
        ],
        'aliases' => [
            'pmProxyPuppetModuleService' => 'KmbPmProxy\Service\PuppetModule',
            'pmProxyPuppetClassService' => 'KmbPmProxy\Service\PuppetClass',
            'pmProxyGroupParameterHydrator' => 'KmbPmProxy\Hydrator\GroupParameterHydrator',
            'pmProxyGroupClassHydrator' => 'KmbPmProxy\Hydrator\GroupClassHydrator',
            'pmProxyGroupHydrator' => 'KmbPmProxy\Hydrator\GroupHydrator',
            'pmProxyRevisionHydrator' => 'KmbPmProxy\Hydrator\RevisionHydrator',
        ],
        'shared' => [
            'KmbPmProxy\Validator\PuppetClassValidator' => false,
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
