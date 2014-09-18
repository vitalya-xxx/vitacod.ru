<?php
return array(
    'adminEmail' => 'vitalya-xxx2@yandex.ru',
    'accessDeniedPage' => array(
        '7'     => array(),                // superAdmin
        '5'     => array(                  // admin
            '/admin/default/list_admins',
        ),
        '4'     => array(                  // moderator
            '/admin/default/list_admins',
            '/admin/default/list_users',
        ),
        '3'     => array(                  // author
            '/admin/default/list_admins',
            '/admin/default/list_users',
        ),
        '2'     => array(                  // user
            '/admin/default/list_admins',
            '/admin/default/list_users',
        ),
        'guest' => array(
            '/admin/default/list_admins',
            '/admin/default/list_users',
        ),
    ),
    'adminRoles' => array(
        '7' => 'Супер админ',
        '5' => 'Админ',
        '4' => 'Модератор',
        '3' => 'Автор',
    ),
    'positionMenu' => array(
        1   => '1',
        2   => '2',
        3   => '3',
        4   => '4',
        5   => '5',
        6   => '6',
        7   => '7',
        8   => '8',
        9   => '9',
        10  => '10',
        11  => '11',
        12  => '12',
        13  => '13',
        14  => '14',
        15  => '15',
        16  => '16',
        17  => '17',
        18  => '18',
        19  => '19',
        20  => '20',
    ),
    'typeMeny' => array(
        'top'    => 'верхнее',
        'middle' => 'среднее',
        'bottom' => 'нижнее'
    ),
    'partSite' => array(
        'site'  => 'На сайте',
        'admin' => 'В админке',
    ),
    'permission' => array(
        '1' => 'viewAdmin',
        '2' => 'moderation',
        '3' => 'users',
    ),
    'parameter' => array(
        'chat' => 'chatOnOff',
    ),
);