<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 07.09.17
 * Time: 17:11
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Errors extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    function page_404( )  {

        $this->output->set_status_header('404');



        if( $this->router->user_lang == 'ru' ){
            $this->lang->load('main', 'russian');
            $this->lang->load('error', 'russian');
        } elseif ( $this->router->user_lang == 'en' ) {
            $this->lang->load('main', 'english');
            $this->lang->load('error', 'english');
        }


        $data_head['is_home_page']          = false;
        $data_head['meta_data']             = array(
            'title'         => 'Страница не найдена',
            'keywords'      => '',
            'description'   => '404 - Страница не найдена',
        );

        $data_content['content']            = array(
            'id'        => 'e_404',
            'title'     => 'Страница не найдена',
            'content'   => 'К сожалению, запрашиваемая Вами информация не найдена',
            'date'      => ''
        );
        $data_content['go_back_url']        = false;

        $data_footer['is_home_page']        = false;
        $data_footer['language_switcher']   = false;        // Получаем переключатель языка
        $data_footer['footer_menu']         = $this->Page_model->get_footer_menu();

        if ( $this->User_model->is_auth_user() ) {
            $data_header = array(
                'usd'       => $this->Option_model->get_option("cbr_usd"),
                'eur'       => $this->Option_model->get_option("cbr_eur"),
            );
            $this->load->view('desktop/user/head',      $data_head);
            $this->load->view('desktop/user/header',    $data_header);
            $this->load->view('desktop/main/error_404',   $data_content);
            $this->load->view('desktop/main/footer',    $data_footer);
        }
        else {

            // Получаем меню навигации
            $data_header['sidebar_menu']        = $this->Page_model->get_sidebar_menu();

            $this->load->view('desktop/main/head',      $data_head);
            $this->load->view('desktop/main/header',    $data_header);
            $this->load->view('desktop/main/error_404',   $data_content);
            $this->load->view('desktop/main/footer',    $data_footer);
        }


        echo $this->output->get_output();
        exit;



    }

}
