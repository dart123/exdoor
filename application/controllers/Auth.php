<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 09.06.16
 * Time: 22:10
 */

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {

        if ($this->input->post('action') == 'auth-reg') {
            $this->load->library('sms');

            if( !$this->input->post('phone') ) {
                $phone_code     = preg_replace("/[^0-9]/", '', $this->input->post('phone-code'));
                $phone_number   = preg_replace("/[^0-9]/", '', $this->input->post('phone-number'));
                $phone          = $phone_code.$phone_number;
            } else {
                $phone = $this->input->post('phone');
            }

            // Имеем номер телефона. Пробуем получить пользователя, есть ли он в базе?
            if( $this->User_model->if_user_register($phone) ) {
                //  Пользователь зарегистрирован, авторизуем
                if( $this->input->post('password') ){

                    $password = $this->input->post('password');

                    if ($this->User_model->user_auth($phone, $password)) {
                        /*

                        $to         = $phone;
                        //$to         = '79250920086';
                        // $to         = '79216501003';
                        $message    = 'Логин - '.$phone.': Успешная авторизация';
                        $this->sms->send($to, $message);

                         */

                        header('Location:/');

                    } else {

                        /*
                            $to         = '79250920086';
                            // $to         = '79216501003';
                            $message    = 'Логин - '.$phone.': Авторизация не удалась';
                            $this->sms->send($to, $message);

                        */
                    }

                    $data_auth = array(
                        'phone'     => $phone,
                        'error'     => 'Авторизация не удалась'
                    );
                    $this->load->view('desktop/main/auth',   $data_auth);

                } else {
                    $data_auth = array(
                        'phone'     => $phone,
                        'error'     => ''
                    );
                    $this->load->view('desktop/main/auth',   $data_auth);
                }

            } else {
                //  Пользователь не зарегистрирован - регистрируем
                $generated_password = $this->User_model->add_user($phone);

                $to         = $phone;
                //  $to         = '79216501003';
                $message    = 'Логин - '.$phone.'  пароль - '.$generated_password;

                $this->sms->send($to, $message);

                $data_auth = array(
                    'phone'     => $phone
                );

                $this->load->view('desktop/main/auth-send-message',  $data_auth);


            }

        }

    }
}