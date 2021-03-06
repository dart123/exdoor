<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 28.08.16
 * Time: 18:07
 */

class Cbr_model extends CI_Model {

    const url = 'http://cbrates.rbc.ru/tsv/';
    const file = '.tsv';
    private $date = 0;


    public function __construct($date = null){
        if ($date == null){
            $date = time();
        }
        $this -> date = $date;
    }

    public function curs($currency_code){
        $url = self::url;
        $curs = 0;
        try{
            if (!is_numeric($currency_code)){
                throw new Exception('Передан неверный код валюты');
            }
            $url .= $currency_code . '/';
            if ($this -> date <= 0){
                throw new Exception('Передана неверная дата');
            }
            $url .= date('Y/m/d', $this -> date);
            $url .= self::file;

            $page = file_get_contents($url);
            $curs = $this->parse($page);
        }
        catch (Exception $e) {
            echo 'Не удалось получить курс валюты. ',  $e -> getMessage();
        }
        // Возвращаем округленный курс валюты
        return round($curs, 2);
    }
    private function parse($file){
        if (empty($file)){
            throw new Exception('Возможно указан неверный код валюты, также возможно на указанную дату еще не установлен курс валюты, либо сервер "cbrates.rbc.ru" недоступен.');
        }
        $curs = explode("\t", $file);
        if (!empty($curs[1])){
            return $curs[1];
        }
        else{
            throw new Exception('Сервер не выдал результатов по данной валюте на указнную дату');
        }
    }


    public function course_update() {
        $usd        = $this->Cbr_model->curs(840);
        $eur        = $this->Cbr_model->curs(978);

        $this->Option_model->update_option('cbr_usd', $usd);
        $this->Option_model->update_option('cbr_eur', $eur);


    }

}