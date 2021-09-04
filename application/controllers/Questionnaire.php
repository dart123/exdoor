<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 06.07.16
 * Time: 23:36
 */
class Questionnaire extends CI_Controller
{
    private $auth_user = true;

    public function __construct()
    {
        parent::__construct();
        if ( $this->User_model->is_auth_user() ) {
            if ($this->input->get('logout')) {
                $this->User_model->user_logout();
                redirect( '/', 'refresh', 302);
            }
            $this->User_model->online_checker( $this->session->user );
        }
    }

    public function index() {

        if( $this->router->user_lang == 'ru' ){
            $this->lang->load('main', 'russian');
        } elseif ( $this->router->user_lang == 'en' ) {
            $this->lang->load('main', 'english');
        }

        if ( $this->User_model->is_auth_user() ) {
            $data_head['is_home_page']          = true;
            $data_head['meta_data']             = array(
                'title'         => '',
                'keywords'      => '',
                'description'   => ''
            );
            $data_header = array(
                'usd'       => $this->Option_model->get_option("cbr_usd"),
                'eur'       => $this->Option_model->get_option("cbr_eur"),
            );
            $data_footer = array(
                'notifications' => $this->Notification_model->get_notifications( $this->session->user )
            );
            $data_content = array(
                'menu'          => array(
                    'selected'          => 'main',
                    'new_messages'      => $this->Message_model->count_unread_dialogs($this->session->user),
                    'new_partners'      => $this->Partner_model->get_inbox_partners_count($this->session->user),
                    'active_requests'   => $this->Request_model->count_active_requests($this->session->user),
                )
            );

            $user   = $this->User_model->get_user_by_id( $this->session->user );
            if( $user->company_id )
                if ( $user->id == $this->Company_model->get_company_director_id( $user->company_id ) ) {
                    $data_content['menu']['new_employers']  = $this->Company_model->count_company_candidats( $user->company_id );
                }


            $this->load->view('desktop/main/head',      $data_head);
            $this->load->view('desktop/user/header',    $data_header);
            $this->load->view('desktop/user/profile',   $data_content);
            $this->load->view('desktop/user/footer',    $data_footer);
        } else {
            redirect('/', 'refresh', 302);
        }
    }
}