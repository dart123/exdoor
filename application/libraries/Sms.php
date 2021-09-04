<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 09.06.16
 * Time: 22:32
 */

require_once 'Smsru.php';

class Sms extends Smsru
{

    function __construct()
    {
        //  parent::__construct('D8294A3F-791D-3871-6315-71BE54A86697'); // Мой АПИ
        parent::__construct('A28BA445-AD7B-3B59-B234-8130AD1BEC5B'); // Павел
    }

}