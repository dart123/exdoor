<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 28.07.17
 * Time: 11:19
 */

class Cron extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function requests_archivator () {

        $this->Request_model->archivator();
        echo 'done';

    }

    public function requests_actualizator () {

        $this->Request_model->actualizator();
        echo 'done';

    }

    public function cbr_course_updater () {

        $this->Cbr_model->course_update();
        echo 'done';

    }

    public function clear_re_response () {

        $this->Request_model->re_response_cleaner();
        echo 'done';

    }

    public function check_users_tarif() {
        $this->User_model->check_users_tarif();
        echo 'done';
    }

    public function clear_users() {
        $this->User_model->clear_users();
    }

}

