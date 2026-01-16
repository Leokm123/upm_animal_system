<?php

return [
    'defaults' => [
        // 默认用普通用户（upm_users）的 guard；你也可以改成你需要的默认角色
        'guard' => 'web',
        'passwords' => 'upm_users',
    ],

    'guards' => [
        // 普通用户
        'web' => [
            'driver' => 'session',
            'provider' => 'upm_users',
        ],
        // 管理员/经理
        'manager' => [
            'driver' => 'session',
            'provider' => 'managers',
        ],
        // 志愿者
        'volunteer' => [
            'driver' => 'session',
            'provider' => 'volunteers',
        ],
        // 如需 API，可继续添加相应 guard
    ],

    'providers' => [
        'upm_users' => [
            'driver' => 'eloquent',
            'model' => App\Models\UPMUser::class,
        ],
        'managers' => [
            'driver' => 'eloquent',
            'model' => App\Models\Manager::class,
        ],
        'volunteers' => [
            'driver' => 'eloquent',
            'model' => App\Models\Volunteer::class,
        ],
    ],

    'passwords' => [
        'upm_users' => [
            'provider' => 'upm_users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
        'managers' => [
            'provider' => 'managers',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
        'volunteers' => [
            'provider' => 'volunteers',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],
];