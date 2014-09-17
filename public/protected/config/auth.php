<?php
/**
 * Created by JetBrains PhpStorm.
 * User: User
 * Date: 25.10.13
 * Time: 11:10
 * To change this template use File | Settings | File Templates.
 */

return array(
    'guest' => array(
        'type'        => CAuthItem::TYPE_ROLE,
        'description' => 'Guest',
        'bizRule'     => null,
        'data'        => null
    ),
    'user' => array(
        'type'        => CAuthItem::TYPE_ROLE,
        'description' => 'user',
        'children'    => array(
            'guest', // унаследуемся от гостя
        ),
        'bizRule'     => null,
        'data'        => null
    ),
    'author' => array(
        'type'        => CAuthItem::TYPE_ROLE,
        'description' => 'author',
        'children'    => array(
            'user', // унаследуемся от гостя
        ),
        'bizRule'     => null,
        'data'        => null
    ),
    'moderator' => array(
        'type'        => CAuthItem::TYPE_ROLE,
        'description' => 'moderator',
        'children'    => array(
            'author', // унаследуемся от гостя
        ),
        'bizRule'     => null,
        'data'        => null
    ),
    'admin' => array(
        'type'        => CAuthItem::TYPE_ROLE,
        'description' => 'admin',
        'children'    => array(
            'moderator',          // позволим модератору всё, что позволено пользователю
        ),
        'bizRule'     => null,
        'data'        => null
    ),
    'superAdmin' => array(
        'type'        => CAuthItem::TYPE_ROLE,
        'description' => 'superAdmin',
        'children'    => array(
            'admin',         // позволим админу всё, что позволено модератору
        ),
        'bizRule'     => null,
        'data'        => null
    ),
);