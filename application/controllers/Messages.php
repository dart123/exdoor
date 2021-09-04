<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 07.07.16
 * Time: 13:41
 */


class Messages extends CI_Controller
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
        }
        $this->User_model->online_checker( $this->session->user );
    }

    public function index( $chatroom_id = false ) {

        if( $this->router->user_lang == 'ru' ){
            $this->lang->load('main', 'russian');
        } elseif ( $this->router->user_lang == 'en' ) {
            $this->lang->load('main', 'english');
        }

        if ( $this->User_model->is_auth_user() ) {
            $data_head['is_home_page']          = false;
            $data_head['meta_data']             = array(
                'title'         => 'Мои диалоги',
                'keywords'      => '',
                'description'   => ''
            );
            $data_header = array(
                'usd'           => $this->Option_model->get_option("cbr_usd"),
                'eur'           => $this->Option_model->get_option("cbr_eur")
            );
            $data_footer = array(
                'notifications'                 => $this->Notification_model->get_notifications( $this->session->user ),
            );
            $data_content = array(
                'menu'          => array(
                    'selected'          => 'messages',
                    'new_messages'      => $this->Message_model->count_unread_dialogs($this->session->user),
                    'new_partners'      => $this->Partner_model->get_inbox_partners_count($this->session->user),
                    'active_requests'   => $this->Request_model->count_active_requests($this->session->user),

                ),
            );


            // Если он авторизован, но при попытке получить данные о нем возвращается false - выкидываем
            $user = $this->User_model->get_user_by_id( intval( $this->session->user ) );
            if(!$user){
                $this->User_model->user_logout();
                redirect('/', 'refresh');
            }

            if( $user->company_id )
                if ( $user->id == $this->Company_model->get_company_director_id( $user->company_id ) ) {
                    $data_content['menu']['new_employers']  = $this->Company_model->count_company_candidats( $user->company_id );
                }

            $data_content['user']       = $user;

            if( $chatroom_id ){

                if( !$this->Permissions_model->if_user_can('chatroom_view', $this->session->user, $chatroom_id) )
                    redirect('/messages/', 'refresh');

                $data_header['search_or_link']  = array(
                    'type'      => 'link',
                    'url'       => '/messages/',
                    'title'     => 'К списку диалогов'
                );

                $data_header['body_class']      = 'dialog-page';

                $this->Message_model->mark_read_dialog( $chatroom_id, $this->session->user );
                $this->Message_model->read_messages( $chatroom_id, $this->session->user);

                $data_content['menu']['new_messages'] = $this->Message_model->count_unread_dialogs($this->session->user);

                $data_content['chatroom']       = $chatroom_id;
                $data_content['messages']       = $this->Message_model->get_messages( $chatroom_id );

                $data_content['user']           = $this->User_model->get_user_by_id( $this->session->user);

                $opponent_id                    = $opponent_id = $this->Message_model->get_opponent_id( $chatroom_id, $this->session->user);
                $data_content['opponent']       = $this->User_model->get_user_by_id( $opponent_id );

                //  Если мы открываем диалог, сообщаем опоненту, что мы все увидили и прочитали
                //  И обновляем у него количество непрочтенных диалогов
                $this->load->library('Socket');
                $socket     = new Socket();
                $socket->initialize();

                $socket->emit('send', [ 'channel' => 'channel_'.$opponent_id, 'type' => 'informer__dialog_read', 'content' => json_encode(array( 'chatroom_id' => $chatroom_id ))]);

                $options['unread_dialogs']      = $this->Message_model->count_unread_dialogs( $opponent_id );
                $socket->emit('send', [ 'channel' => 'channel_'.$opponent_id, 'type' => 'informer__message', 'content' => json_encode($options)]);


                $socket->close();

                if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                    $this->load->view('mobile/user/head',       $data_head);
                    $this->load->view('mobile/messages/page__dialog',   array("page_header"  => $data_header, "page_content" => $data_content ) );
                    $this->load->view('mobile/user/footer',     $data_footer);

                else:

                    $this->load->view('desktop/user/head',      $data_head);
                    $this->load->view('desktop/user/header',    $data_header);
                    $this->load->view('desktop/messages/page__dialog',  $data_content);
                    $this->load->view('desktop/user/footer',    $data_footer);

                endif;

            } else {

                $data_content['dialogs']    = $this->Message_model->get_dialogs(  $this->session->user );
                $data_content['partners']   = $this->Partner_model->get_partners( $this->session->user );

                $data_footer['notifications__no_messages']  = true;


                if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                    $this->load->view('mobile/user/head',       $data_head);
                    $this->load->view('mobile/messages/page',   array("page_header"  => $data_header, "page_content" => $data_content ) );
                    $this->load->view('mobile/user/footer',     $data_footer);

                else:

                    $this->load->view('desktop/user/head',      $data_head);
                    $this->load->view('desktop/user/header',    $data_header);
                    $this->load->view('desktop/messages/page',  $data_content);
                    $this->load->view('desktop/user/footer',    $data_footer);

                endif;


            }
        } else {
            redirect('/', 'refresh', 302);
        }
    }

    public function partners() {

        if( $this->router->user_lang == 'ru' ){
            $this->lang->load('main', 'russian');
        } elseif ( $this->router->user_lang == 'en' ) {
            $this->lang->load('main', 'english');
        }

        if ( $this->User_model->is_auth_user() ) {
            $data_head['is_home_page']          = false;
            $data_head['meta_data']             = array(
                'title'         => 'Мои собеседники',
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
                    'selected'          => 'messages',
                    'new_messages'      => $this->Message_model->count_unread_dialogs($this->session->user),
                    'new_partners'      => $this->Partner_model->get_inbox_partners_count($this->session->user),
                    'active_requests'   => $this->Request_model->count_active_requests($this->session->user),
                ),
            );
            // Если он авторизован, но при попытке получить данные о нем возвращается false - выкидываем
            $user = $this->User_model->get_user_by_id( intval( $this->session->user ) );
            if(!$user){
                $this->User_model->user_logout();
                redirect('/', 'refresh');
            }

            if( $user->company_id )
                if ( $user->id == $this->Company_model->get_company_director_id( $user->company_id ) ) {
                    $data_content['menu']['new_employers']  = $this->Company_model->count_company_candidats( $user->company_id );
                }

            $data_content['user']       = $user;

            $data_content['partners']   = $this->Partner_model->get_partners( $this->session->user, array('limit' => 5) );

            $this->load->view('desktop/user/head',      $data_head);
            $this->load->view('desktop/user/header',    $data_header);
            $this->load->view('desktop/messages/page__partners',  $data_content);
            $this->load->view('desktop/user/footer',    $data_footer);
        } else {
            redirect('/', 'refresh', 302);
        }
    }
}