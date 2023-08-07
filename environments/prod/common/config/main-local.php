<?php

return [
    'components' => [
        'db' => [
            'class' => '\yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;dbname=db_inventaris',
            'username' => 'root',
            'password' => 'mdb124',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@common/mail',
        ],
    ],
];
