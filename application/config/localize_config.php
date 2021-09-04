<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 06.05.16
 * Time: 13:42
 *
 * Настройки локализации сайта.
 *
 *     default_key => язык сайта по умолчанию
 *     list        => список доступных языков
 *
 * @author Sergey Makhlenko
 * @version 1.0
 *
 */

defined('BASEPATH') OR exit('No direct script access allowed');

$config['ROUTE_LOCALIZE'] = array(
    'default_key' => 0, // Язык по-умолчанию, указывается ключ из массива "list" (0 -> ru, 1 -> en)
    'list'        => array('ru', 'en'), // Доступные языки для сайта
);