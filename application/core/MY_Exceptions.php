<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 07.09.17
 * Time: 17:43
 */

class MY_Exceptions extends CI_Exceptions {

    public function __construct()
    {
        parent::__construct();
    }

    function show_404($page = '', $log_error = TRUE) {

        $CI =& get_instance();

        if( $CI->router->user_lang == 'ru' ){
            $CI->lang->load('main', 'russian');
            $CI->lang->load('error', 'russian');
        } elseif ( $CI->router->user_lang == 'en' ) {
            $CI->lang->load('main', 'english');
            $CI->lang->load('error', 'english');
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
        $data_footer['footer_menu']         = $CI->Page_model->get_footer_menu();

        if ( $CI->User_model->is_auth_user() ) {
            $data_header = array(
                'usd'       => $CI->Option_model->get_option("cbr_usd"),
                'eur'       => $CI->Option_model->get_option("cbr_eur"),
            );
            $CI->load->view('desktop/user/head',      $data_head);
            $CI->load->view('desktop/user/header',    $data_header);
            $CI->load->view('desktop/main/error_404',   $data_content);
            $CI->load->view('desktop/main/footer',    $data_footer);
        }
        else {

            // Получаем меню навигации
            $data_header['sidebar_menu']        = $CI->Page_model->get_sidebar_menu();

            $CI->load->view('main/head',      $data_head);
            $CI->load->view('main/header',    $data_header);
            $CI->load->view('main/error_404',   $data_content);
            $CI->load->view('main/footer',    $data_footer);
        }


        echo $CI->output->get_output();
        exit;
    }
}