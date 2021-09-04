<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 17.08.17
 * Time: 21:28
 */
require_once 'composer/vendor/autoload.php';

use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;

class Socket extends Client
{

    function __construct()
    {
        parent::__construct(new Version2X( 'https://exdor.ru' ));
    }
}
