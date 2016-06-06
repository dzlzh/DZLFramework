<?php
$config = array(
    'dir'        => dirname(__FILE__),
    'paths'      => array(
        'libs/function/function.php',
    ),

    'controller' => 'index',
    'method'     => 'index',

    'dbtype'     => 'mysql',

    'dbconfig'   => array(
        'dbhost'    => '',
        'dbport'    => '3306',
        'dbuser'    => '',
        'dbpwd'     => '',
        'dbname'    => '',
        'dbcharset' => 'utf8',
        'dbdebug'   => true,
    ),

    'viewconfig' => array(
        'left_delimiter'  => '{',
        'right_delimiter' => '}',
        'template_dir'    => 'tpl',
    ),
);
