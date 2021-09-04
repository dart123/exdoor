<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 05.07.16
 * Time: 23:41
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        echo 'ajax api v0.1';
    }

    public function show_mobile_version() {
        $this->session->unset_userdata('pc_view');
        echo 1;
    }
    public function show_pc_version() {
        $this->session->set_userdata('pc_view', true);
        echo 1;
    }

    public function enter()
    {
        if ( $this->input->post('lang') == 'en' ) $this->lang->load('auth', 'english');
        else $this->lang->load('auth', 'russian');

        $response = array(
            'code'      => '',
            'title'     => '',
            'message'   => ''
        );

        $this->load->library('sms');
        $phone = $this->input->post('phone');

        if( $this->User_model->is_register_phone($phone) ) {

            $password = $this->input->post('password' );
            if( $password != '' ) {
                if ($this->User_model->user_auth($phone, sha1($password))) {

                    $this->User_model->confirm_user_phone( $phone );
                    $response['code']       = 'auth_success';
                    $response['title']      = $this->lang->line('auth');
                    $response['message']    = $this->lang->line('auth_success');
                }
                else
                {
                    $user_id                = $this->User_model->get_user_by_phone( $phone );
                    $is_user_removed        = $this->User_model->is_user_removed( $user_id->id );

                    if ( $is_user_removed ) {
                        $response['code']       = 'auth_user_inactive';
                        $response['title']      = $this->lang->line('auth_unable');
                        $response['message']    = $this->lang->line('auth_user_deactivated').'. <a class="is-or-link fancybox" href="#report"><span>'.$this->lang->line('auth_report_us').'</span></a> '.$this->lang->line('auth_for_recover_access').'.';
                    }
                    else {
                        $response['code']       = 'auth_fail';
                        $response['title']      = $this->lang->line('auth_error');
                        $response['message']    = $this->lang->line('auth_wrong_login_or_pass');
                    }
                }
            }
            else
            {
                $response['code']       = 'auth_no_password';
                $response['title']      = $this->lang->line('auth');
                $response['message']    = $this->lang->line('auth').'. '.$this->lang->line('auth_password_input');
            }

        } else {

            if( $phone ) {
                $user_id        = $this->User_model->add_user( $phone );
                $sms_code       = $this->User_model->password_generator();
                if( $this->User_model->update_user_info( $user_id, array('password' => sha1( $sms_code ) ) ) )
                {
                    $to             = $phone;
                    $message        = 'Пароль для входа на exdor.ru: '.$sms_code;
                    $this->sms->send($to, $message);
                }
                $response['code']       = 'phone_not_registered';
                $response['title']      = $this->lang->line('reg');
                $response['message']    = $this->lang->line('reg_phone_approve');
            }

        }
        echo json_encode($response);
    }

    public function change_password()
    {
        if ( $this->input->post('lang') == 'en' ) $this->lang->load('auth', 'english');
        else $this->lang->load('auth', 'russian');

        $response = array(
            'code'      => '',
            'title'     => '',
            'message'   => ''
        );
        $this->load->library('sms');
        $phone = $this->input->post('phone');
        if( $user       = $this->User_model->get_user_by_phone($phone) )
        {
            $sms_code   = $this->User_model->password_generator();
            if( $this->User_model->update_user_info( $user->id, array('password' => sha1( $sms_code ) ) ) )
            {
                $to             = $phone;
                $message        = $this->lang->line('reg_your_new_pass').$sms_code;
                $this->session->set_userdata( 'time', ( time() ));
                $response['time']       = intval( time() );
                $this->session->set_userdata( 'unblock', ( intval( time() ) + 90 ));
                $response['unblock']    = intval( time() ) + 90;
                $this->sms->send($to, $message);

                if( $this->input->post('process') == 'auth')
                {
                    $response['code']       = 'password_reset';
                    $response['title']      = $this->lang->line('reg_pass_success_reset');
                    $response['message']    = $this->lang->line('reg_new_pass_in_sms');
                }
                elseif( $this->input->post('process') == 'reg')
                {
                    $response['code']       = 'password_reset';
                    $response['title']      = $this->lang->line('reg_code_success_send');
                    $response['message']    = $this->lang->line('reg_code_success_send_sms');
                };
                echo json_encode($response);
            }
        }
    }

    public function change_login__send_code () {

        if ( $this->input->post('lang') == 'en' ) $this->lang->load('auth', 'english');
        else $this->lang->load('auth', 'russian');

        $user       = $this->User_model->get_user_by_id( $this->session->user );
        $phone      = $user->phone;
        $code       = $this->User_model->change_login__code( $this->session->user );
        $message    = $this->lang->line('reg_code_for_change_sms').$code.'.';

        if( $this->session->userdata('unblock') ):
            $block      = intval( $this->session->userdata('unblock') );
            $now        = time();
            if( $block > $now ) {
                echo json_encode('block');
                die();
            } else {
                $this->session->unset_userdata('unblock');
            }

        endif;

        if( $phone && $code ) {

            $this->load->library('sms');

            if( $this->sms->send( $phone, $message  )  ) {
                $this->session->set_userdata( 'unblock', ( intval( time() ) + 5*60 ));
                echo json_encode('true');
            } else {
                echo json_encode( 'error');
            }
        }
    }

    public function change_login__check_code () {

        $code           = $this->input->post('code');
        $user           = $this->User_model->get_user_change_login_data( $this->session->user );

        if( is_object($user) && property_exists($user, 'change_login__code') && $user->change_login__code != '') {
            if( $user->change_login__code == $code ) {
                echo json_encode('true');
            } else echo json_encode('false');
        } else echo json_encode('false');

    }

    public function change_login__new_phone () {

        if( $this->router->user_lang == 'ru' ) $this->lang->load('auth', 'russian');
        elseif ( $this->router->user_lang == 'en') $this->lang->load('auth', 'english');

        $phone              = $this->input->post('phone');
        $new_password       = $this->User_model->password_generator();

        if( $this->User_model->is_register_phone( $phone ) ) {
            echo json_encode('false');
            return;
        }

        if ( $new_password && $phone ) {

            $update_data = array(
                'change_login__phone'       => $phone,
                'change_login__password'    => $new_password
            );

            if( $this->User_model->update_user_info( $this->session->user, $update_data) ) {

                $message = $this->lang->line('reg_new_pass_sms').$new_password;

                $this->load->library('sms');

                if ( $this->sms->send( $phone, $message ) ) {
                    echo json_encode('true');
                } else {
                    echo json_encode('false');
                    return;
                }
            }
            else echo json_encode('false');

        } else {
            echo json_encode('false');
            return;
        }

    }

    public function change_login__check_pass () {

        $password       = $this->input->post('pass');
        $user           = $this->User_model->get_user_change_login_data( $this->session->user );

        if( is_object($user) && property_exists($user, 'change_login__code') && $user->change_login__password != '' && $user->change_login__phone != '' && $user->change_login__password == $password ) {

            $update_data        = array(
                'phone'                     => $user->change_login__phone,
                'password'                  => sha1( $user->change_login__password ),
                'change_login__code'        => '',
                'change_login__phone'       => '',
                'change_login__password'    => '',
            );

            if( $this->User_model->update_user_info( $this->session->user, $update_data) ) {

                $this->User_model->user_logout();
                $this->User_model->user_auth( $user->change_login__phone, sha1( $user->change_login__password ) );

                echo json_encode('true');
            }
            else echo json_encode('false');

        } else echo  json_encode('false');

        return;

    }






    public function close_notification() {
        $this->Notification_model->remove_notification( $this->input->post('id') );
        echo 'true';
    }

    public function sts_user_update() {
        $type           = $this->input->post('type');
        $value          = $this->input->post('value');

        if( $type == 'notice_popup_time' ){

            $user           = $this->User_model->get_user_by_id( $this->session->user );

            switch( $value ) {
                case 'name':
                    $data   = array( 'notice_popup_count_name' => $user->notice_popup_count_name + 1 );
                    break;
                case 'last_name':
                    $data   = array( 'notice_popup_count_lastname' => $user->notice_popup_count_lastname + 1 );
                    break;
                case 'second_name':
                    $data   = array( 'notice_popup_count_secondname' => $user->notice_popup_count_secondname + 1 );
                    break;
                case 'city':
                    $data   = array( 'notice_popup_count_city' => $user->notice_popup_count_city + 1 );
                    break;
                case 'email':
                    $data   = array( 'notice_popup_count_email' => $user->notice_popup_count_email + 1 );
                    break;
                case 'brand[]':
                    $data   = array( 'notice_popup_count_brands' => $user->notice_popup_count_brands + 1 );
                    break;
                case 'direction[]':
                    $data   = array( 'notice_popup_count_direction' => $user->notice_popup_count_direction + 1 );
                    break;
            }

        } else {

            if( $type == 'brand[]' ) {

                if( is_array( $value ) && !empty( $value ) ){
                    $data       = array(
                        'brands'    => $value
                    );
                }

            } elseif ($type == 'direction[]' ) {

                if( in_array( 'sell', $value) && in_array('buy', $value))
                    $data       = array( 'direction' => 'all' );
                elseif ( in_array( 'sell', $value) )
                    $data       = array( 'direction' => 'sell' );
                elseif ( in_array( 'buy', $value) )
                    $data       = array( 'direction' => 'buy' );

            } else {
                $data           = array( $type => $value );
            }

        }



        if ( $this->User_model->update_user_info( $this->session->user, $data ) ) {
            $user   = $this->User_model->get_user_by_id( $this->session->user );

            $user->this_user    = true;

            if( $user->name || $user->last_name || $user->second_name )
                $user->show_name    = true;
            else $user->show_name   = false;

            if ( $user->name && $user->city ) {
                $user->template     = 'user';
            }
            else $user->template    = 'main';

            echo json_encode( $user );
        } else echo json_encode( false );

    }

    /* Партнеры */

    public function partners__send_request()
    {
        $user_id    = intval( $this->input->post('user_id') );
        $partner_id = intval( $this->input->post('partner_id') );
        if( $user_id && $partner_id)
        {
            if (!$this->Partner_model->check_relationship($user_id, $partner_id))
            {
                if ($this->Partner_model->send_request($user_id, $partner_id))
                {
                    $about_me   = $this->User_model->get_user_by_id( $user_id );

                    $this->load->library('Socket');
                    $socket     = new Socket();
                    $socket->initialize();

                    $informer_partner   = array(
                        'result_in'     => $this->Partner_model->get_inbox_partners_count( $partner_id ),
                        'result_out'    => $this->Partner_model->get_outbox_partners_count( $partner_id )
                    );
                    $socket->emit('send', [ 'channel' => 'channel_'.$partner_id, 'type' => 'informer__partner', 'content' => json_encode($informer_partner)]);

                    $informer_partner   = array(
                        'result_in'     => $this->Partner_model->get_inbox_partners_count( $user_id ),
                        'result_out'    => $this->Partner_model->get_outbox_partners_count( $user_id )
                    );
                    $socket->emit('send', [ 'channel' => 'channel_'.$user_id, 'type' => 'informer__partner', 'content' => json_encode($informer_partner)]);

                    $socket->emit('send', [ 'channel' => 'channel_'.$partner_id, 'type' => 'informer__partner__new_inbox_request', 'content' => json_encode(array('user' => $about_me ))]);




                    $noty_data = array(
                        'user_id'       => $partner_id,
                        'from_id'       => $user_id,
                        'from_company'  => 0,
                        'title'         => $about_me->name.' '.$about_me->last_name.' хочет стать Вашим партнером',
                        'content'       => 'Нажмите чтобы принять заявку, либо отклонить ее',
                        'url'           => '/partners/inbox'
                    );

                    $noty       = $this->Notification_model->form_notification( $noty_data );

                    $socket->emit('send', [ 'channel' => 'channel_'.$partner_id, 'type' => 'notification', 'content' => json_encode($noty)]);

                    $socket->close();

                    echo json_encode('true');
                }
                else echo json_encode('false');
            }
            else echo json_encode('false');
        }
        else echo json_encode('false');
    }

    public function partners__add_user()
    {
        $user_id        = intval( $this->input->post('user_id') );
        $partner_id     = intval( $this->input->post('partner_id') );
        $undo           = intval( $this->input->post('undo') );


        if( $user_id && $partner_id)
        {
            if ($this->Partner_model->check_relationship($user_id, $partner_id))
            {
                if ($this->Partner_model->add_partner($user_id, $partner_id, $undo))
                {

                    $about_me   = $this->User_model->get_user_by_id( $user_id );

                    $this->load->library('Socket');
                    $socket     = new Socket();
                    $socket->initialize();

                    $informer_partner   = array(
                        'result_in'     => $this->Partner_model->get_inbox_partners_count( $partner_id ),
                        'result_out'    => $this->Partner_model->get_outbox_partners_count( $partner_id )
                    );
                    $socket->emit('send', [ 'channel' => 'channel_'.$partner_id, 'type' => 'informer__partner', 'content' => json_encode($informer_partner)]);

                    $informer_partner   = array(
                        'result_in'     => $this->Partner_model->get_inbox_partners_count( $user_id ),
                        'result_out'    => $this->Partner_model->get_outbox_partners_count( $user_id )
                    );
                    $socket->emit('send', [ 'channel' => 'channel_'.$user_id, 'type' => 'informer__partner', 'content' => json_encode($informer_partner)]);


                    if( $undo != 1 )
                        $socket->emit('send', [ 'channel' => 'channel_'.$partner_id, 'type' => 'informer__partner__new_partner', 'content' => json_encode($about_me )]);

                    else
                        $socket->emit('send', [ 'channel' => 'channel_'.$partner_id, 'type' => 'informer__partner__new_partner__undo', 'content' => json_encode($user_id)]);

                    $socket->close();

                    echo json_encode('true');
                }
                else echo json_encode('false');
            }
            else echo json_encode('false');
        }
        else echo json_encode('false');
    }

    public function partners__remove_user()
    {
        $user_id        = intval( $this->input->post('user_id') );
        $partner_id     = intval( $this->input->post('partner_id') );

        if( $user_id && $partner_id)
        {
            if ($this->Partner_model->check_relationship($user_id, $partner_id))
            {

                if ($this->Partner_model->remove_partner($user_id, $partner_id))
                {
                    $this->load->library('Socket');
                    $socket     = new Socket();
                    $socket->initialize();

                    $informer_partner   = array(
                        'result_in'     => $this->Partner_model->get_inbox_partners_count( $partner_id ),
                        'result_out'    => $this->Partner_model->get_outbox_partners_count( $partner_id )
                    );
                    $socket->emit('send', [ 'channel' => 'channel_'.$partner_id, 'type' => 'informer__partner', 'content' => json_encode($informer_partner)]);

                    $informer_partner   = array(
                        'result_in'     => $this->Partner_model->get_inbox_partners_count( $user_id ),
                        'result_out'    => $this->Partner_model->get_outbox_partners_count( $user_id )
                    );
                    $socket->emit('send', [ 'channel' => 'channel_'.$user_id, 'type' => 'informer__partner', 'content' => json_encode($informer_partner)]);

                    $socket->emit('send', [ 'channel' => 'channel_'.$partner_id, 'type' => 'informer__partner__new_partner__undo', 'content' => json_encode($user_id)]);

                    $socket->close();

                    echo json_encode('true');
                }
                else echo json_encode('false');
            }
            else echo json_encode('false');
        }
        else echo json_encode('false');
    }

    public function partners__undo_remove_user()
    {
        $user_id        = intval( $this->input->post('user_id') );
        $partner_id     = intval( $this->input->post('partner_id') );

        if( $user_id && $partner_id)
        {
            if ($this->Partner_model->undo_remove_partner($user_id, $partner_id))
            {
                $about_me   = $this->User_model->get_user_by_id( $user_id );
                $this->load->library('Socket');
                $socket     = new Socket();
                $socket->initialize();

                $informer_partner   = array(
                    'result_in'     => $this->Partner_model->get_inbox_partners_count( $partner_id ),
                    'result_out'    => $this->Partner_model->get_outbox_partners_count( $partner_id )
                );
                $socket->emit('send', [ 'channel' => 'channel_'.$partner_id, 'type' => 'informer__partner', 'content' => json_encode($informer_partner)]);

                $informer_partner   = array(
                    'result_in'     => $this->Partner_model->get_inbox_partners_count( $user_id ),
                    'result_out'    => $this->Partner_model->get_outbox_partners_count( $user_id )
                );
                $socket->emit('send', [ 'channel' => 'channel_'.$user_id, 'type' => 'informer__partner', 'content' => json_encode($informer_partner)]);


                $socket->emit('send', [ 'channel' => 'channel_'.$partner_id, 'type' => 'informer__partner__new_partner', 'content' => json_encode( $about_me )]);

                $socket->close();

                echo json_encode('true');
            }
            else echo json_encode('false');
        }
        else echo json_encode('false');
    }

    public function partners__cancel_request ()
    {
        $user_id        = intval( $this->input->post('user_id') );
        $partner_id     = intval( $this->input->post('partner_id') );
        $undo           = intval( $this->input->post('undo') );

        if( $user_id && $partner_id)
        {
            $this->load->library('Socket');
            $socket     = new Socket();
            $socket->initialize();

            if ( $this->Partner_model->check_relationship($user_id, $partner_id) && $undo == 0 )
            {
                if ($this->Partner_model->cancel_request($user_id, $partner_id))
                {
                    $about_me   = $this->User_model->get_user_by_id( $user_id );

                    $informer_partner   = array(
                        'result_in'     => $this->Partner_model->get_inbox_partners_count( $partner_id ),
                        'result_out'    => $this->Partner_model->get_outbox_partners_count( $partner_id )
                    );
                    $socket->emit('send', [ 'channel' => 'channel_'.$partner_id, 'type' => 'informer__partner', 'content' => json_encode($informer_partner)]);

                    $informer_partner   = array(
                        'result_in'     => $this->Partner_model->get_inbox_partners_count( $user_id ),
                        'result_out'    => $this->Partner_model->get_outbox_partners_count( $user_id )
                    );
                    $socket->emit('send', [ 'channel' => 'channel_'.$user_id, 'type' => 'informer__partner', 'content' => json_encode($informer_partner)]);


                    if( $undo != 1 )
                        $socket->emit('send', [ 'channel' => 'channel_'.$partner_id, 'type' => 'informer__partner__cancel_request', 'content' => json_encode( array('user_id' => $user_id))]);

                    else
                        $socket->emit('send', [ 'channel' => 'channel_'.$partner_id, 'type' => 'informer__partner__cancel_request__undo', 'content' => json_encode( array('user' => $about_me ) )]);

                    echo json_encode('true');
                }
                else echo json_encode('false');
            }
            elseif ( !$this->Partner_model->check_relationship($user_id, $partner_id) && $undo == 1 ) {
                if ($this->Partner_model->send_request($partner_id, $user_id))
                {
                    $informer_partner   = array(
                        'result_in'     => $this->Partner_model->get_inbox_partners_count( $partner_id ),
                        'result_out'    => $this->Partner_model->get_outbox_partners_count( $partner_id )
                    );
                    $socket->emit('send', [ 'channel' => 'channel_'.$partner_id, 'type' => 'informer__partner', 'content' => json_encode($informer_partner)]);

                    $informer_partner   = array(
                        'result_in'     => $this->Partner_model->get_inbox_partners_count( $user_id ),
                        'result_out'    => $this->Partner_model->get_outbox_partners_count( $user_id )
                    );
                    $socket->emit('send', [ 'channel' => 'channel_'.$user_id, 'type' => 'informer__partner', 'content' => json_encode($informer_partner)]);

                    echo json_encode('true');
                }
                else echo json_encode('false');
            }

            $socket->close();
        }
        else echo json_encode('false');
    }

    public function partners__company_add_all () {

        $user_id        = $this->session->user;
        $company_id     = intval( $this->input->post('company_id') );

        $company_partners = $this->Company_model->get_company_employers_ids( $company_id );

        $this->load->library('Socket');
        $socket     = new Socket();
        $socket->initialize();

        $count_new_partners     = 0;

        foreach( $company_partners as $c_partner ):

            if ($this->Partner_model->send_request($user_id, $c_partner) && $user_id != $c_partner):

                $about_me   = $this->User_model->get_user_by_id( $user_id );

                $informer_partner   = array(
                    'result_in'     => $this->Partner_model->get_inbox_partners_count( $c_partner ),
                    'result_out'    => $this->Partner_model->get_outbox_partners_count( $c_partner )
                );
                $socket->emit('send', [ 'channel' => 'channel_'.$c_partner, 'type' => 'informer__partner', 'content' => json_encode($informer_partner)]);

                $informer_partner   = array(
                    'result_in'     => $this->Partner_model->get_inbox_partners_count( $user_id ),
                    'result_out'    => $this->Partner_model->get_outbox_partners_count( $user_id )
                );
                $socket->emit('send', [ 'channel' => 'channel_'.$user_id, 'type' => 'informer__partner', 'content' => json_encode($informer_partner)]);

                $socket->emit('send', [ 'channel' => 'channel_'.$c_partner, 'type' => 'informer__partner__new_inbox_request', 'content' => json_encode(array('user' => $about_me ))]);

                $noty_data = array(
                    'user_id'       => $c_partner,
                    'from_id'       => $user_id,
                    'from_company'  => 0,
                    'title'         => $about_me->name.' '.$about_me->last_name.' хочет стать Вашим партнером',
                    'content'       => 'Нажмите чтобы принять заявку, либо отклонить ее',
                    'url'           => '/partners/inbox'
                );

                $noty       = $this->Notification_model->form_notification( $noty_data );

                $socket->emit('send', [ 'channel' => 'channel_'.$c_partner, 'type' => 'notification', 'content' => json_encode($noty)]);

                $count_new_partners++;

            endif;

        endforeach;

        $socket->close();

        echo json_encode($count_new_partners);

    }

    public function partners__open_chat ()
    {
        $user_id        = intval( $this->input->post('user_id') );
        $partner_id     = intval( $this->input->post('partner_id') );
        $offer_id       = intval( $this->input->post('offer_id') );
        $message        = $this->input->post('message');

        $dialog         = $this->Message_model->is_dialog_exist( array($user_id, $partner_id) );
        if($dialog)
        {
            if ( $message ) {
                if( $this->Message_model->send_message( $user_id, $dialog, $message) ) {

                    //$this->informer_update('informer__message', $partner_id);
                    //$result = true;
                };

            } else
                $result = '/messages/'.$dialog;
        }
        else
        {
            $new_dialog = $this->Message_model->new_dialog( array($user_id, $partner_id) );
            if( $message ) {
                if( $this->Message_model->send_message( $user_id, $new_dialog, $message) ){
                    //$this->informer_update('informer__message', $partner_id);
                    //$result = true;
                };
            } else
                $result = '/messages/'.$new_dialog;
        }

        if( $offer_id ) {
            $this->Offers_model->add_offers_contact( $offer_id );
        }
        echo json_encode($result);
    }

    public function partners__request__add_message () {
        $user_id        = $this->input->post('user_id');
        $partner_id     = $this->input->post('partner_id');
        $message        = $this->input->post('message');

        if( $this->Partner_model->request__add_message($user_id, $partner_id, $message)){
            echo json_encode('true');
        }
        else echo json_encode('false');
    }

    /* Отправка писем и смс */

    public function send_email()
    {
        $this->load->library('email');
        $this->email->from(     'robot@exdor.ru', 'Exdor'   );
        $this->email->to(       $this->input->post('email') );
        $this->email->subject(  $this->input->post('subject')  );
        $this->email->message(  $this->input->post('message') );
        if( $this->email->send() )
            echo json_encode('true');
        else
            echo json_encode('false');
    }

    public function send_sms()
    {
        $message    = $this->input->post('message');
        $phone      = $this->input->post('phone');

        $user       = $this->User_model->get_user_by_id( $this->session->user );

        if( $user->sms_limit ) {
            $current_date       = new DateTime('now' );
            $sms_limit          = new DateTime( $user->sms_limit );

            $interval           = $current_date->getTimestamp() - $sms_limit->getTimestamp();

            if( $interval > 0 ) {

                $this->load->library('sms');

                if(  $this->sms->send($phone, $message)  ) {

                    // Следующая отправка смс только через 5 минут
                    $sms_limit          = $current_date->getTimestamp() + 60*5;
                    date_timestamp_set($current_date, $sms_limit);
                    $data['sms_limit']  = date_format($current_date, 'Y-m-d H:i:s') ;

                    $this->User_model->update_user_info( $this->session->user, $data );
                    echo json_encode('true');
                } else {
                    echo json_encode( 'error');
                }


            } else {

                $interval       = $sms_limit->diff($current_date);
                $result         = $interval->format("%I:%S");
                echo json_encode( $result);
            }

        }
        else echo json_encode('false');

    }

    public function bug_reporter( ) {

        $system_email       = $this->Option_model->get_option( 'system_email' );

        $this->load->library('email');

        $this->email->from(     'robot@exdor.ru', 'Exdor'   );
        $this->email->to(       $system_email );
        $this->email->subject(  'Пользователь сообщил об ошибке'  );
        $this->email->message(  $this->input->post('message') );
        if( $this->email->send() )
            echo json_encode('true');
        else
            echo json_encode('false');

    }


    /*
     *
     *
     * Загрузка аватара
     *
     * Коды ошибок:
     * 1 - Успешно
     * 2 - Не удалось обновление базы данных
     *
     */

    public function avatar_upload(){

        $response       = array();
        $update_data    = array();

        $this->load->library('upload');             // Библиотека для загрузки аватара

        // Создаем директорию для пользователя
        $user_dir = './uploads/users/'.$this->session->user;
        if( !is_dir($user_dir) ) {
            mkdir($user_dir);
            mkdir($user_dir.'/avatar');
            mkdir($user_dir.'/park');
            mkdir($user_dir.'/others');
            mkdir($user_dir.'/ads');
        }

        $config_upload['upload_path'] = $user_dir.'/avatar';
        $config_upload['allowed_types'] = 'gif|jpg|png';
        $config_upload['max_size'] = '8000';
        $config_upload['max_width'] = '5000';
        $config_upload['max_height'] = '5000';

        $this->upload->initialize($config_upload);

        if ( $this->upload->do_upload('img')) {
            $this->load->library('image_moo');

            $uploaded_image = $this->upload->data();

            $this->image_moo->load($uploaded_image['full_path']);
            $this->image_moo->resize_crop(180, 180);
            $this->image_moo->set_jpeg_quality(85);
            $this->image_moo->save($uploaded_image['file_path'] . '/' . '180x180_'.$uploaded_image['file_name'], TRUE);
            $this->image_moo->resize_crop(80, 80);
            $this->image_moo->set_jpeg_quality(85);
            $this->image_moo->save($uploaded_image['file_path'] . '/' . '80x80_'.$uploaded_image['file_name'], TRUE);

            $update_data['avatar'] = $uploaded_image['file_name'];
            //  Храним в БД только имя файла. Директория  /uploads/users/$user_id/avatar/$size_avatar


            // обновляем данные о пользователе. ID берем из сессии, чтобы БД лишний раз не дергать
            if ($this->User_model->update_user_info( intval($this->session->user), $update_data ) ){

                $user_data      = $this->User_model->get_user_by_id( intval($this->session->user) );

                $response['status']     = 'success';
                $response['code']       = '1';
                $response['title']      = 'Отлично!';
                $response['text']       = 'Аватар успешно обновлен!';
                $response['image']      = $user_data->avatar;
                $response['id']         = $user_data->id;
            }
            else {
                $response['status']     = 'alert';
                $response['code']       = '2';
                $response['title']      = 'Ошибка!';
                $response['text']       = 'Не удалось обновить данные в базе!';
            }
        } else {
            $response['status']     = 'alert';
            $response['code']       = '3';
            $response['title']      = 'Ошибка!';
            $response['text']       = $this->upload->display_errors("", "");;
        }



        echo json_encode($response);
    }

    public function avatar_remove(){
        $user_id    = intval( $this->input->post('user_id') );

        if( $user_id == intval( $this->session->user ) ) {
            if( $this->User_model->update_user_info( $user_id, array('avatar' => '') ) ){
                echo json_encode(true);
            } else echo json_encode('1');
        } else
            echo json_encode( $_POST );
    }



    /*
     *
     *
     *  Сообщения
     *
     *
     *
     */

    public function send_message( ) {

        $author         = $this->input->post('author');
        $chatroom       = $this->input->post('chatroom');
        $message        = $this->input->post('message');
        $images         = $this->input->post('images');

        if ( $this->security->xss_clean($message, true) === FALSE  ) {
            echo json_encode('XSSerror');
            return;
        }

        if( $author && $chatroom && ( $message != '' || !empty($images) ) )
            $message_id = $this->Message_model->send_message( $author, $chatroom, $message, $images);
        else
            $message_id = false;


        if( $message_id ) {

            $this->load->library('Socket');
            $socket     = new Socket();
            $socket->initialize();

            if( is_array($message_id) && !empty($message_id) ) {

                $opponent_id    = $this->Message_model->get_opponent_id( $chatroom, $author);

                foreach( $message_id as $ms_id ) {

                    $msg            = $this->Message_model->get_message_by_id($ms_id);

                    $data = array(
                        'id'                => $msg->id,
                        'message'           => $msg->message,
                        'message_preview'   => $msg->message_preview,
                        'author_id'         => $msg->author_id,
                        'editable'          => $msg->editable,
                        'is_author'         => $msg->is_author,
                        'name'              => $msg->name,
                        'last_name'         => $msg->last_name,
                        'avatar'            => $msg->avatar,
                        'date'              => $msg->date,
                        'images'            => $msg->images,
                        'chatroom_id'       => $chatroom
                    );



                    $socket->emit('send', [ 'channel' => 'channel_'.$this->session->user, 'type' => 'message', 'content' => json_encode($data)]);

                    $data['editable']   = false;
                    $data['removable']  = false;
                    $data['is_author']  = false;

                    $socket->emit('send', [ 'channel' => 'channel_'.$opponent_id, 'type' => 'message', 'content' => json_encode($data)]);

                    $data['typing_text']    = $msg->name.' печатает...';
                    $socket->emit('send', [ 'channel' => 'channel_'.$opponent_id, 'type' => 'message__dialog_update', 'content' => json_encode($data)]);


                    $options['unread_dialogs']      = $this->Message_model->count_unread_dialogs( $opponent_id );
                    $socket->emit('send', [ 'channel' => 'channel_'.$opponent_id, 'type' => 'informer__message', 'content' => json_encode($options)]);


                    $noty_data = array(
                        'user_id'       => $opponent_id,
                        'from_id'       => $this->session->user,
                        'from_company'  => 0,
                        'target'        => 'new_message',
                        'title'         => 'Новое сообщение',
                        'content'       => $msg->message_preview,
                        'url'           => '/messages/'.$chatroom,
                    );

                    $noty    = $this->Notification_model->form_notification( $noty_data );

                    $socket->emit('send', [ 'channel' => 'channel_'.$opponent_id, 'type' => 'notification', 'content' => json_encode($noty)]);


                }


            } else {

                $msg            = $this->Message_model->get_message_by_id($message_id);
                $opponent_id    = $this->Message_model->get_opponent_id( $chatroom, $author);

                $data = array(
                    'id'                => $msg->id,
                    'message'           => $msg->message,
                    'message_preview'   => $msg->message_preview,
                    'author_id'         => $msg->author_id,
                    'editable'          => $msg->editable,
                    'is_author'         => $msg->is_author,
                    'name'              => $msg->name,
                    'last_name'         => $msg->last_name,
                    'avatar'            => $msg->avatar,
                    'date'              => $msg->date,
                    'images'            => $msg->images,
                    'chatroom_id'       => $chatroom
                );



                $socket->emit('send', [ 'channel' => 'channel_'.$this->session->user, 'type' => 'message', 'content' => json_encode($data)]);

                $data['editable']   = false;
                $data['removable']  = false;
                $data['is_author']  = false;

                $socket->emit('send', [ 'channel' => 'channel_'.$opponent_id, 'type' => 'message', 'content' => json_encode($data)]);

                $data['typing_text']    = $msg->name.' печатает...';
                $socket->emit('send', [ 'channel' => 'channel_'.$opponent_id, 'type' => 'message__dialog_update', 'content' => json_encode($data)]);

                $options['unread_dialogs']      = $this->Message_model->count_unread_dialogs( $opponent_id );
                $socket->emit('send', [ 'channel' => 'channel_'.$opponent_id, 'type' => 'informer__message', 'content' => json_encode($options)]);


                $noty_data = array(
                    'user_id'       => $opponent_id,
                    'from_id'       => $this->session->user,
                    'from_company'  => 0,
                    'target'        => 'new_message',
                    'title'         => 'Новое сообщение',
                    'content'       => $msg->message_preview,
                    'url'           => '/messages/'.$chatroom
                );

                $noty    = $this->Notification_model->form_notification( $noty_data );

                $socket->emit('send', [ 'channel' => 'channel_'.$opponent_id, 'type' => 'notification', 'content' => json_encode($noty)]);





            }

            $socket->close();
            echo json_encode( $message_id );


        }

    }

    public function message_typing() {

        $author         = $this->input->post('author');
        $chatroom       = $this->input->post('chatroom');
        $action         = $this->input->post('action');

        $opponent_id    = $this->Message_model->get_opponent_id( $chatroom, $author);

        $this->load->library('Socket');
        $socket     = new Socket();
        $socket->initialize();

        $socket->emit('send', [ 'channel' => 'channel_'.$opponent_id, 'type' => 'informer__message_typing', 'content' => json_encode(array( 'chatroom_id' => $chatroom, 'action' => $action))]);
        $socket->close();

    }

    public function read_messages () {
        $chatroom           = $this->input->post('chatroom');
        $user               = $this->session->user;

        $result             = $this->Message_model->read_messages($chatroom, $user);

        $this->Message_model->mark_read_dialog( $chatroom, $user );

        $opponent_id    = $this->Message_model->get_opponent_id( $chatroom, $user);

        $this->load->library('Socket');
        $socket     = new Socket();
        $socket->initialize();

        $socket->emit('send', [ 'channel' => 'channel_'.$opponent_id, 'type' => 'informer__dialog_read', 'content' => json_encode(array( 'chatroom_id' => $chatroom ))]);

        $options['unread_dialogs']      = $this->Message_model->count_unread_dialogs( $opponent_id );
        $socket->emit('send', [ 'channel' => 'channel_'.$opponent_id, 'type' => 'informer__message', 'content' => json_encode($options)]);

        $options['unread_dialogs']      = $this->Message_model->count_unread_dialogs( $user );
        $socket->emit('send', [ 'channel' => 'channel_'.$user, 'type' => 'informer__message', 'content' => json_encode($options)]);

        $socket->close();


        echo json_encode( $result );
    }

    public function load_messages () {
        $chatroom               = $this->input->post('chatroom');
        $last_loaded_message    = $this->input->post('last_loaded_message');

        $result = $this->Message_model->get_messages( $chatroom, 15, $last_loaded_message, true);

        echo json_encode( $result );
    }

    public function get_message_item() {
        $message_id             = $this->input->post('message_id');

        $result = $this->Message_model->get_message_by_id( $message_id );
        echo json_encode( $result );
    }

    public function edit_message () {

        $chatroom_id            = $this->input->post('chatroom_id');
        $message_id             = $this->input->post('message_id');

        if ( $this->security->xss_clean($this->input->post('message'), true) === FALSE  ) {
            echo json_encode('XSSerror');
            return;
        }

        $update_data            = array(
                                    'message'           => $this->input->post('message'),
                                    'post_images'       => $this->input->post('post_images'),
                                    'existing_images'   => $this->input->post('existing_images'),
                                );



        $result = $this->Message_model->edit_message( $chatroom_id, $message_id, $update_data );

        if( $result ) {
            $msg        = $this->Message_model->get_message_by_id($message_id);
            //  Создание сообщения и отправка его APE серверу для автора
            $options  = array(
                'id'        => $msg->id,
                'message'   => $msg->message,
                'author_id' => $msg->author_id,
                'name'      => $msg->name,
                'last_name' => $msg->last_name,
                'avatar'    => $msg->avatar,
                'date'      => $msg->date,
                'images'    => $msg->images,
                'unread'    => $msg->unread,
                'is_author' => true,
                'editable'  => true,
                'removable' => true,
                'chatroom'  => $chatroom_id
            );

            $this->load->library('Socket');
            $socket     = new Socket();
            $socket->initialize();

            $socket->emit('send', [ 'channel' => 'channel_'.$this->session->user, 'type' => 'message__edit', 'content' => json_encode($options)]);
            $socket->close();

            echo json_encode( $message_id );
        }
        else
            echo json_encode(false);

    }

    public function remove_message () {
        $message_id                 = $this->input->post('message_id');
        $chatroom_id                = $this->input->post('chatroom_id');

        if( $this->Message_model->is_unread_message( $message_id ) ) {

            $this->Message_model->delete_message( $message_id );

            echo json_encode( 'deleted' );

        } else {

            if ( $this->Message_model->is_message_author( $this->session->user, $message_id ) ) {

                $this->Message_model->remove_message( $message_id );
                echo json_encode( 'removed' );

            } else {

                $this->Message_model->remove_message_by_oponent( $message_id );
                echo json_encode( 'removed' );

            }


        }


    }

    public function restore_message () {
        $message_id                 = $this->input->post('message_id');
        $chatroom_id                = $this->input->post('chatroom_id');

        $result = $this->Message_model->restore_message( $message_id );
        echo json_encode( $result );
    }


    /*
     *
     *
     *  Руководитель компании - Принять и отклонить заявки потенциальных сотрудников
     *
     *
     */

    public function company_logo_upload(){

        $response       = array();
        $update_data    = array();

        $user       = $this->User_model->get_user_by_id( $this->session->user );

        $this->load->library('upload');             // Библиотека для загрузки аватара

        // Создаем директорию для пользователя
        $user_dir = './uploads/companies/'.$user->company_id;
        if( !is_dir($user_dir) ) {
            mkdir($user_dir);
            mkdir($user_dir.'/logo');
        }

        $config_upload['upload_path'] = $user_dir.'/logo';
        $config_upload['allowed_types'] = 'gif|jpg|png';
        $config_upload['max_size'] = '8000';
        $config_upload['max_width'] = '5000';
        $config_upload['max_height'] = '5000';

        $this->upload->initialize($config_upload);

        if ( $this->upload->do_upload('img')) {
            $this->load->library('image_moo');

            $uploaded_image = $this->upload->data();

            $this->image_moo->load($uploaded_image['full_path']);
            $this->image_moo->resize(180, 300);
            $this->image_moo->set_jpeg_quality(100);
            $this->image_moo->save($uploaded_image['file_path'] . '/' . '180_'.$uploaded_image['file_name'], TRUE);
            $this->image_moo->resize_crop(80, 80);
            $this->image_moo->set_jpeg_quality(100);
            $this->image_moo->save($uploaded_image['file_path'] . '/' . '80x80_'.$uploaded_image['file_name'], TRUE);

            $update_data['logo'] = $uploaded_image['file_name'];
            //  Храним в БД только имя файла. Директория  /uploads/users/$user_id/avatar/$size_avatar



            // обновляем данные о пользователе. ID берем из сессии, чтобы БД лишний раз не дергать
            if ($this->Company_model->update_company( intval($user->company_id), $update_data ) ){

                $company      = $this->Company_model->get_company_by_id( $user->company_id );

                $response['status']     = 'success';
                $response['code']       = '1';
                $response['title']      = 'Отлично!';
                $response['text']       = 'Логотип Вашей компании успешно обновлен!';
                $response['image']      = $company->logo;
                $response['id']         = $company->id;
            }
            else {
                $response['status']     = 'alert';
                $response['code']       = '2';
                $response['title']      = 'Ошибка!';
                $response['text']       = 'Не удалось обновить данные в базе!';
            }


        }
        else {

            $response['status']     = 'alert';
            $response['code']       = '3';
            $response['title']      = 'Ошибка!';
            $response['text']       = $this->upload->display_errors("", "");

        }

        echo json_encode($response);
    }

    public function company_logo_remove(){
        $company_id    = intval( $this->input->post('company_id') );


        if( $this->Company_model->update_company( $company_id, array('logo' => '') ) ){
                echo json_encode(true);
            } else echo json_encode('1');

    }

    public function reload_company_news () {

        $user               = $this->User_model->get_user_by_id( $this->session->user );
        $company_news       = $this->News_model->get_news( array('company_id' => $user->company_id, 'type' => 'lenta') );

        echo json_encode( $company_news );
    }

    public function reload_company_requests () {

        $user               = $this->User_model->get_user_by_id( $this->session->user );
        $requests           = $this->Request_model->get_company_requests( $user->company_id  );

        echo json_encode( $requests );
    }

    public function candidat_employer () {

        $user_id        = $this->input->post('candidat');
        $role           = $this->input->post('role');
        $profession     = $this->input->post('profession');

        $result = $this->User_model->update_user_info($user_id, array('company_status' => 'accepted', 'company_role' => $role, 'company_profession' => $profession));
        if($result){
            $new_employer = $this->User_model->get_user_by_id($user_id);


            $this->load->library('Socket');
            $socket     = new Socket();
            $socket->initialize();

            $socket->emit('send', [ 'channel' => 'channel_'.$this->session->user, 'type' => 'new_employer', 'content' => json_encode($new_employer)]);
            $socket->emit('send', [ 'channel' => 'channel_'.$this->session->user, 'type' => 'employers_count', 'content' => json_encode($this->Company_model->count_company_employers($new_employer->company_id))]);

            $noty_data = array(
                'user_id'       => $new_employer->id,
                'from_id'       => $new_employer->company_id,
                'from_company'  => 1,
                'title'         => 'Ваша заявка принята!',
                'content'       => 'Руководитель рассмотрел и принял Вашу заявку, теперь вы являетесь сотрудником!',
                'url'           => '/company/id'.$new_employer->company_id,
                'target'        => 'company'
            );

            $noty_id    = $this->Notification_model->save_notification( $noty_data );
            $noty       = $this->Notification_model->get_notification( $noty_id );

            $socket->emit('send', [ 'channel' => 'channel_'.$new_employer->id, 'type' => 'notification', 'content' => json_encode($noty)]);



            $company_id         = $this->Company_model->get_company_id_by_director_id( $this->session->user );
            $candidats_count    = $this->Company_model->count_company_candidats( $company_id );
            $socket->emit('send', [ 'channel' => 'channel_'.$this->session->user, 'type' => 'informer__company_employers__count', 'content' => json_encode($candidats_count)]);

            $socket->close();

            echo 'true';
        }

        else
            echo 'false';
    }

    public function candidat_noemployer () {
        $user_id    = $this->input->post('candidat');

        $result = $this->User_model->update_user_info($user_id, array('company_id' => '0'));

        if($result) {

            $noty_data = array(
                'user_id'       => $user_id,
                'from_id'       => $this->session->user,
                'from_company'  => 0,
                'title'         => 'Руководитель отклонил Вашу заявку',
                'content'       => 'Руководитель не смог подтвердить, что Вы являетесь сотрудником организации',
                'url'           => false
            );

            $noty    = $this->Notification_model->form_notification( $noty_data );

            $this->load->library('Socket');
            $socket     = new Socket();
            $socket->initialize();

            $socket->emit('send', [ 'channel' => 'channel_'.$user_id, 'type' => 'notification', 'content' => json_encode($noty)]);

            $company_id         = $this->Company_model->get_company_id_by_director_id( $this->session->user );
            $candidats_count    = $this->Company_model->count_company_candidats( $company_id );
            $socket->emit('send', [ 'channel' => 'channel_'.$this->session->user, 'type' => 'informer__company_employers__count', 'content' => json_encode($candidats_count)]);
            $socket->close();

            echo 'true';
        }

        else
            echo 'false';
    }

    public function update_employer_status(  ){
        $employer_id    = $this->input->post('employer_id');
        $type           = $this->input->post('type');
        $data           = $this->input->post('data');

        switch( $type ):
            case 'role':
                $result = $this->User_model->update_user_info($employer_id, array('company_role' => $data));
                break;
            case 'profession':
                $result = $this->User_model->update_user_info($employer_id, array('company_profession' => $data));
                break;
            default:
                $result = false;
                break;
        endswitch;


        if($result)
            echo 'true';
        else
            echo 'false';
    }

    public function remove_employer()
    {
        $employer_id    = $this->input->post('employer_id');

        $update_data = array(
            'company_status'        => 'not accepted',
            'company_id'            => 0
        );

        $director   = $this->User_model->get_user_by_id( $this->session->user );

        if( $this->User_model->update_user_info($employer_id, $update_data) ) {
             $this->Company_model->set_ex_employer( $employer_id, $director->company_id );
        };



        $noty_data = array(
            'user_id'       => $employer_id,
            'from_id'       => $this->session->user,
            'from_company'  => 0,
            'title'         => 'Вас исключили из компании',
            'content'       => 'Директор исключил Вас из сотрудников компании',
            'url'           => false
        );

        $noty    = $this->Notification_model->form_notification( $noty_data );

        $this->load->library('Socket');
        $socket     = new Socket();
        $socket->initialize();

        $socket->emit('send', [ 'channel' => 'channel_'.$employer_id, 'type' => 'notification', 'content' => json_encode($noty)]);


        $company_id         = $this->Company_model->get_company_id_by_director_id( $this->session->user );
        $candidats_count    = $this->Company_model->count_company_candidats( $company_id );
        $socket->emit('send', [ 'channel' => 'channel_'.$this->session->user, 'type' => 'informer__company_employers__count', 'content' => json_encode($candidats_count)]);

        $socket->close();


        echo json_encode('removed');

    }

    public function get_city() {

        $keyword    = $this->input->get('query');

        header("Content-type: application/json; charset=UTF-8");
        header("Cache-Control: must-revalidate");
        header("Pragma: no-cache");
        header("Expires: -1");

        $result     = $this->Option_model->get_city( $keyword );

        $res = new stdClass;
        $res->query = $keyword;
        $res->suggestions = $result;

        echo json_encode( $res );
    }

    public function get_partners() {

        $keyword    = $this->input->get('query');

        header("Content-type: application/json; charset=UTF-8");
        header("Cache-Control: must-revalidate");
        header("Pragma: no-cache");
        header("Expires: -1");

        $result     = $this->Option_model->get_interlocutors( $keyword, $this->session->user );

        $res = new stdClass;
        $res->query = $keyword;
        $res->suggestions = $result;

        echo json_encode( $res );
    }



    public function add_news () {
        $author_id          = $this->input->post('author_id');
        $content            = $this->input->post('content');
        $images             = $this->input->post('images');
        $is_company_news    = $this->input->post('company_news');

        if ( $this->security->xss_clean($content, true) === FALSE  ) {
            echo json_encode('XSSerror');
            return;
        }

        $content    = mb_convert_encoding ( $content, "UTF-8");

        if( $is_company_news == '1' )
            $news_id            = $this->News_model->add_news( $author_id, $content, $images, true );
        else
            $news_id            = $this->News_model->add_news( $author_id, $content, $images );

        $new_news_item      = $this->News_model->get_news_item( $news_id );

        $this->load->library('Socket');
        $socket     = new Socket();
        $socket->initialize();

        $socket->emit('send', [ 'channel' => 'channel_'.$this->session->user, 'type' => 'new_news', 'content' => json_encode($new_news_item)]);

        $socket->close();

        echo json_encode( $new_news_item );

    }

    public function get_news_item () {
        $news_id                = $this->input->post('news_id');

        $result = $this->News_model->get_news_item( $news_id );
        echo json_encode( $result );
    }

    public function edit_news () {
        $id                 = $this->input->post('news_id');
        $is_company_news    = $this->input->post('company_news');

        if( $is_company_news    == 1 )
            $company_news = true;
        else
            $company_news = false;

        $update_data    = array(
            'content'           => $this->input->post('content'),
            'post_images'       => $this->input->post('post_images'),
            'existing_images'   => $this->input->post('existing_images'),
        );

        if ( $this->security->xss_clean($update_data["content"], true) === FALSE  ) {
            echo json_encode('XSSerror');
            return;
        }

        if( $this->Permissions_model->if_user_can('news__edit', $this->session->user, $id ) ) {

            if ( $this->News_model->edit_news( $id, $update_data ) )
            {
                $result = $this->News_model->get_news_item( $id );

                $result_for_all         = clone $result;

                if( is_object($result) ) {
                    $result_for_all->is_author      = false;
                    $result_for_all->editable       = false;
                    $result_for_all->date          .= ' (недавно изменена)';
                }
                $users_online   = $this->User_model->online_users();

                if( is_array($users_online) ) {
                    $this->load->library('Socket');
                    $socket     = new Socket();
                    $socket->initialize();



                    foreach ($users_online as $user_online) {

                        if( $user_online->id != $this->session->user )
                            $socket->emit('send', [ 'channel' => 'channel_'.$user_online->id, 'type' => 'informer__news_edit', 'content' => json_encode($result_for_all)]);

                    }
                    $socket->close();
                }
            }
            else
            {
                $result = false;
            };

        } else $result = 'no_permissions';

        echo json_encode( $result );

    }

    public function remove_news () {
        $id        = $this->input->post('id');

        if( $this->Permissions_model->if_user_can( 'news__remove', $this->session->user, $id ) ) {

            if ($this->News_model->remove_item($id))
                echo json_encode(true);

        } else echo json_encode('no_permissions');
    }

    public function undo_remove_news() {
        $id             = $this->input->post('id');

        if ( $this->News_model->undo_remove_item( $id ) )
            echo json_encode( 'true' );
    }

    public function get_comment () {
        $id             = $this->input->post('comment_id');
        if ( $comment = $this->News_model->get_comment( $id ) )
        {
            echo json_encode( $comment );
        }
        else
        {
            echo json_encode( false );
        }
    }

    public function edit_comment () {
        $id             = $this->input->post('id');
        $comment        = $this->input->post('comment');

        $update_data    = array(
            'comment'   => $comment,
        );
        if ( $this->Permissions_model->if_user_can('news_comment__edit', $this->session->user, $id ) ) {

            if ( $this->News_model->edit_comment( $id, $update_data ) )
            {

                $users_online   = $this->User_model->online_users();

                if( is_array($users_online) ) {

                    $comment        = $this->News_model->get_comment( $id );
                    $news           = $this->News_model->get_news_item( $comment->news_id );
                    $author         = $this->User_model->get_user_by_id( $comment->user_id );

                    $options = array(
                        'comment_id'    => $comment->id,
                        'news_id'       => $news->id,
                        'user_id'       => $author->id,
                        'comment'       => $comment->comment
                    );
                    $options['name']                = $author->name;
                    $options['last_name']           = $author->last_name;
                    $options['avatar']              = $author->avatar;
                    $options['date']                = 'Комментарий недавно изменен';
                    $options['editable']            = false;
                    $options['is_author']           = false;







                    $this->load->library('Socket');
                    $socket     = new Socket();
                    $socket->initialize();
                    foreach ($users_online as $user_online) {

                        if( $user_online->id != $this->session->user ) {

                            if( $this->Permissions_model->if_user_can('news_comment__remove', $user_online->id, $comment->id ) )
                                $options['removable']       = true;
                            else
                                $options['removable']       = false;

                            $socket->emit('send', [ 'channel' => 'channel_'.$user_online->id, 'type' => 'informer__news_comments__edit', 'content' => json_encode($options)]);
                        }

                    }
                    $socket->close();
                }

                echo json_encode( true );
            }
            else
            {
                echo json_encode( false );
            }

        } else echo json_encode('no_permissions');


    }

    public function remove_news_comment () {
        $id        = $this->input->post('id');

        if ( $this->Permissions_model->if_user_can('news_comment__remove', $this->session->user, $id ) ) {
            if ($this->News_model->remove_comment($id)) {

                echo json_encode('true');

                $users_online = $this->User_model->online_users();;
                if (is_array($users_online)) {

                    $this->load->library('Socket');
                    $socket     = new Socket();
                    $socket->initialize();

                    foreach ($users_online as $user_online) {
                        if ($user_online->id != $this->session->user)
                            $socket->emit('send', [ 'channel' => 'channel_'.$user_online->id, 'type' => 'informer__news_comments__remove', 'content' => json_encode($id)]);
                    }

                    $socket->close();
                }
            }
        } else echo json_encode('no_permissions');

    }

    public function undo_remove_news_comment () {
        $id             = $this->input->post('id');

        if ( $this->News_model->undo_remove_comment( $id ) ) {
            echo json_encode( 'true' );
            $users_online   = $this->User_model->online_users();
            if( is_array($users_online) ) {

                $this->load->library('Socket');
                $socket     = new Socket();
                $socket->initialize();

                foreach ($users_online as $user_online) {
                    if( $user_online->id != $this->session->user )
                        $socket->emit('send', [ 'channel' => 'channel_'.$user_online->id, 'type' => 'informer__news_comments__remove_undo', 'content' => json_encode($id)]);

                }
                $socket->close();
            }
        }

    }

    public function load_news () {

        if( $this->input->post('last_loaded_news') )
            $options['from'] = $this->input->post('last_loaded_news');

        if( $this->input->post('keyword') ):

            $options['keyword']     = $this->input->post('keyword');
            $result                 = $this->News_model->get_news( $options );

        else:

            $options    = array(
                'user_id'           => false,
                'type'              => 'lenta',
                'company_id'        => false,
                'employers_only'    => 0,
                'limit'             => 10,
            );

            if( $this->input->post('user_id') )
                $options['user_id'] = $this->input->post('user_id');

            if( $this->input->post('type') )
                $options['type'] = $this->input->post('type');

            if( $this->input->post('company_id') )
                $options['company_id'] = $this->input->post('company_id');

            if( $this->input->post('employers_only') )
                $options['employers_only'] = $this->input->post('employers_only');

            if( $this->input->post('limit') )
                $options['limit'] = $this->input->post('limit');

            if( $options['user_id'] == 1 && $this->input->post('taxonomy') != '' )
                $options['taxonomy']    = $this->input->post('taxonomy');

            if( $this->input->post('last_loaded_news') )
                $options['from'] = $this->input->post('last_loaded_news');

            $result = $this->News_model->get_news( $options );

        endif;


        echo json_encode( $result );

    }

    public function news_add_comment() {
        $data = array(
            'news_id'   => $this->input->post('news_id'),
            'user_id'   => $this->input->post('user_id'),
            'comment'   => $this->input->post('comment'),
        );
        if( $comment_id = $this->News_model->add_comment( $data ) ){

            $comment_source = $this->News_model->get_comment( $comment_id );
            $current_news   = $this->News_model->get_news_item( $data['news_id'] );

            $options = array(
                'comment_id'    => $comment_id,
                'news_id'       => $this->input->post('news_id'),
                'user_id'       => $this->input->post('user_id'),
                'comment'       => $this->input->post('comment')
            );

            $author                         = $this->User_model->get_user_by_id($this->session->user);
            $options['name']                = $author->name;
            $options['last_name']           = $author->last_name;
            $options['avatar']              = $author->avatar;
            $options['date']                = 'Только что';
            $options['editable']            = $comment_source->editable;
            $options['removable']           = $comment_source->removable;
            $options['is_author']           = $comment_source->is_author;;
            $options['total_news_comments'] = $this->News_model->count_comments( $options['news_id'] );

            $this->load->helper('morphem');
            if ($options['total_news_comments'] != 0)
                $options['total_news_comments__text']   = morphem( $options['total_news_comments'], 'комментарий', 'комментария', 'комментариев');
            else
                $options['total_news_comments__text']   = 'Нет комментариев';


            $this->load->library('Socket');
            $socket     = new Socket();
            $socket->initialize();

            $socket->emit('send', [ 'channel' => 'channel_'.$this->session->user, 'type' => 'informer__news_comments', 'content' => json_encode($options)]);



            $users_online   = $this->User_model->online_users( );
            if( is_array($users_online) ) {

                $options['editable']    = false;
                foreach ($users_online as $user_online) {
                    if( $user_online->id != $this->session->user ) {

                        if( $this->Permissions_model->if_user_can('news_comment__remove', $user_online->id, $comment_id ) )
                            $options['removable']       = true;
                        else
                            $options['removable']       = false;

                        $socket->emit('send', [ 'channel' => 'channel_'.$user_online->id, 'type' => 'informer__news_comments', 'content' => json_encode($options)]);

                    }

                }


            }

            $socket->close();

            echo json_encode( 'true' );
        }
        else
        {
            echo json_encode( 'false' );
        };
    }

    public function news_likes() {

        $action         = '';

        $data = array(
            'news_id'       => $this->input->post('news_id'),
            'author_id'     => $this->input->post('author_id'),
        );

        if ( $this->News_model->is_liked( $data['news_id'], $data['author_id']) ) {
            $this->News_model->remove_like($data);
            $action     = 'removed';
        } else {
            $this->News_model->add_like($data);
            $action     = 'added';
        }

        $options = array(
            'likes'         => $this->News_model->count_likes( $data['news_id'] ),
            'news_id'       => $data['news_id'],
            'action'        => $action
        );
        /*
        $users_online   = $this->User_model->online_users( );
        if( is_array($users_online) ) {

            $this->load->library('Socket');
            $socket     = new Socket();
            $socket->initialize();

            foreach ($users_online as $user_online) {
                $socket->emit('send', [ 'channel' => 'channel_'. $user_online->id, 'type' => 'informer__news_likes', 'content' => json_encode($options)]);
            }

            $socket->close();
        }
        */

        echo json_encode( $options );

    }

    public function load_all_comments() {
        $news_id = $this->input->post('news_id');

        $comments = $this->News_model->get_comments( $news_id, 5, 100, true);
        echo json_encode( $comments );
    }



    public function add_offer ()
    {
        $author_id      = $this->input->post('author_id');
        $type           = $this->input->post('type');
        $category       = $this->input->post('category');
        $brand          = $this->input->post('brand');
        $title          = $this->input->post('title');
        $keywords       = $this->input->post('keywords');
        $content        = $this->input->post('content');
        $price          = $this->input->post('price');
        $max_price      = $this->input->post('max_price');
        $barter         = $this->input->post('barter');
        $barter_text    = $this->input->post('barter_text');
        $images         = $this->input->post('images');
        $options = array(
            'author_id'     => $author_id,
            'type'          => $type,
            'category'      => $category,
            'brand'         => $brand,
            'title'         => $title,
            'keywords'      => $keywords,
            'content'       => $content,
            'price'         => $price,
            'max_price'     => $max_price,
            'barter'        => $barter,
            'barter_text'   => $barter_text
        );

        $ads_id            = $this->Offers_model->add_offer( $options, $images );
        $new_ads_item      = $this->Offers_model->get_offer_item( $ads_id );

        $this->load->library('Socket');
        $socket     = new Socket();
        $socket->initialize();

        $socket->emit('send', [ 'channel' => 'channel_'.$author_id, 'type' => 'new_ads', 'content' => json_encode($new_ads_item)]);

        $socket->close();

        echo json_encode( $new_ads_item );
    }

    public function get_offers () {
        $filter = array(
            'type'          => $this->input->post('type'),
            'offset'        => $this->input->post('offset'),
            'category'      => $this->input->post('category'),
            'brand'         => $this->input->post('brand'),
            'price'         => $this->input->post('price'),
            'max_price'     => $this->input->post('max_price'),
            'sort_by'       => $this->input->post('sort_by'),
            'barter'        => $this->input->post('barter'),
            'keyword'       => $this->input->post('keyword'),
        );

        $filter_ads         = $this->Offers_model->get_offers( $filter );

        echo json_encode( $filter_ads );
    }

    public function get_offer_item () {
        $id             = $this->input->post('id');
        $item           = $this->Offers_model->get_offer_item( $id );

        echo json_encode( $item );
    }

    public function edit_offer () {
        $id             = $this->input->post('offer_id');

        $update_data    = array(
            'type'              => $this->input->post('type'),
            'category'          => $this->input->post('category'),
            'brand'             => $this->input->post('brand'),
            'title'             => $this->input->post('title'),
            'keywords'          => $this->input->post('keywords'),
            'content'           => $this->input->post('content'),
            'price'             => $this->input->post('price'),
            'max_price'         => $this->input->post('max_price'),
            'barter'            => $this->input->post('barter'),
            'barter_text'       => $this->input->post('barter_text'),
            'post_images'       => $this->input->post('post_images'),
            'existing_images'   => $this->input->post('existing_images'),
        );

        if ( $this->Offers_model->edit_offer( $id, $update_data ) )
        {
            $result = $this->Offers_model->get_offer_item( $id );
        }
        else
        {
            $result = false;
        };

        echo json_encode( $result );

    }

    public function remove_offer () {
        $offer_id        = $this->input->post('id');

        $result         = $this->Offers_model->remove_item( $offer_id );
        /*
        $opponent_id = $this->Message_model->get_opponent_id( $chatroom_id, $this->session->user);
        $this->informer_update('informer__message__remove', $opponent_id, array('message_id' => $message_id));
        */
        echo json_encode( $result );
    }

    public function undo_remove_offer () {
        $offer_id       = $this->input->post('id');
        $result         = $this->Offers_model->undo_remove_item( $offer_id );
        echo json_encode( $result );
    }

    public function pin_offer() {
        $offer_id       = $this->input->post('id');
        $is_pinned      = $this->input->post('is_pinned');
        $content        = array();

        if( $this->Offers_model->if__user_can_edit( $this->session->user, $offer_id ) ) {

            if( $is_pinned == 'true' )
            {
                $content['pinned']      = 0;       // Если прикреплено объявление, то открепляем
                $content['pin_date']    = '';
            }
            elseif( $is_pinned == 'false' )
            {
                $now                    = new DateTime();
                $content['pinned']      = 1;       // Если не прикреплено объявление, то прикрепляем
                $content['pin_date']    = $now->format('Y-m-d H:i:s');
            }
            $result         = $this->Offers_model->edit_offer( $offer_id, $content );

            if ( $result )
            {
                $offer = $this->Offers_model->get_offer_item( $offer_id );
                if( $content['pinned'] == 0 )
                    echo '{ "result": true, "is_pinned": false, "offer": '.json_encode($offer).'}';
                else
                    echo '{ "result": true, "is_pinned": true, "offer": '.json_encode($offer).'}';
            }
            else {
                echo 'false';
            }
        }
        else
        {
            echo 'false';
        }
    }

    public function load_user_content() {
        $user_id                = $this->input->post('user_id');
        $last_loaded_news       = $this->input->post('last_loaded_news');
        $last_loaded_offers     = $this->input->post('last_loaded_offers');
        $limit                  = $this->input->post('limit');

        $filter     = array(
                        'user_id'           => $user_id,
                        'type'              => 'solo',
                        'last_loaded_news'  => $last_loaded_news,
                        'last_loaded_offers'=> $last_loaded_offers,
                        'limit'             => $limit,
                    );

        $result = $this->User_model->get_user_content( $filter );

        echo json_encode( $result );
    }

    public function load_user_content__pinned_offers() {
        $user_id                = $this->input->post('user_id');

        $filter         = array(
            'user_id'   => $user_id,
            'pinned'    => 'yes',
            'sort_by'   => 'pin_date'
        );

        $result = $this->Offers_model->get_offers( $filter);

        echo json_encode( $result );
    }



    public function get_equipment() {
        $filter = array(
            'brand'         => $this->input->post('brand'),
        );

        $filter_eq      = $this->Equipment_model->get_items( $this->session->user, $filter );

        echo json_encode( $filter_eq );
    }

    public function add_equipment() {

        $owner          = $this->input->post('owner');
        $appointment    = $this->input->post('appointment');
        $brand          = $this->input->post('brand');
        $model          = $this->input->post('model');
        $serial_number  = $this->input->post('serial_number');
        $engine         = $this->input->post('engine');
        $year           = $this->input->post('year');
        $section        = $this->input->post('section');
        $filter_brands  = $this->input->post('filter_brands');

        $images         = $this->input->post('images');

        $options = array(
            'owner'         => $owner,
            'appointment'   => $appointment,
            'brand'         => $brand,
            'model'         => $model,
            'serial_number' => $serial_number,
            'engine'        => $engine,
            'year'          => $year,
            'section'       => $section,
            'removed'       => 0
        );

        $equipment_id       = $this->Equipment_model->add_item( $options, $images );
        $new_equipment_item = $this->Equipment_model->get_item( $equipment_id );


        // обновляем фильтр

        $filter['filter_brands']    = $this->Equipment_model->get_equipment_brands( $this->session->user ); // Обновленные данные о брендах
        if( !empty($filter_brands))
            $filter['filter']['brand']  = array( $filter_brands );
        else
            $filter['filter']['brand']  = array();
        $html_filter_data           = $this->load->view('desktop/equipment/page__filter', $filter, TRUE);           // Текущее значение фильтра

        $result                     = array(
            'item'      => $new_equipment_item,
            'filter'    => $html_filter_data
        );

        echo json_encode( $result );
    }

    public function update_equipment() {

        $id             = $this->input->post('id');

        $owner          = $this->input->post('owner');
        $appointment    = $this->input->post('appointment');
        $brand          = $this->input->post('brand');
        $model          = $this->input->post('model');
        $serial_number  = $this->input->post('serial_number');
        $engine         = $this->input->post('engine');
        $year           = $this->input->post('year');
        $section        = $this->input->post('section');
        $filter_brands  = $this->input->post('filter_brands');

        $images             = $this->input->post('images');
        $existing_images    = $this->input->post('existing_images');

        $options = array(
            'owner'             => $owner,
            'appointment'       => $appointment,
            'brand'             => $brand,
            'model'             => $model,
            'serial_number'     => $serial_number,
            'engine'            => $engine,
            'year'              => $year,
            'section'           => $section,
            'post_images'       => $images,
            'existing_images'   => $existing_images
        );

        $this->Equipment_model->edit_item( $id, $options );

        $new_equipment_item = $this->Equipment_model->get_item( $id );


        // обновляем фильтр

        $filter['filter_brands']    = $this->Equipment_model->get_equipment_brands( $this->session->user ); // Обновленные данные о брендах
        if( !empty($filter_brands))
            $filter['filter']['brand']  = array( $filter_brands );
        else
            $filter['filter']['brand']  = array();
        $html_filter_data           = $this->load->view('desktop/equipment/page__filter', $filter, TRUE);           // Текущее значение фильтра

        $result                     = array(
                                        'item'      => $new_equipment_item,
                                        'filter'    => $html_filter_data
        );

        echo json_encode( $result );
    }

    public function get_equipment_item () {
        $id             = $this->input->post('id');
        $item           = $this->Equipment_model->get_item( $id );

        echo json_encode( $item );
    }

    public function remove_equipment() {
        $id             = $this->input->post('id');

        if ( $this->Equipment_model->remove_item( $id ) )
            echo json_encode( 'true' );
    }

    public function undo_remove_equipment() {
        $id             = $this->input->post('id');

        if ( $this->Equipment_model->undo_remove_item( $id ) )
            echo json_encode( 'true' );
    }

    public function save_edit_image() {
        $image              = $this->input->post('image');
        $name               = $this->input->post('name');
        $equipment_id       = $this->input->post('equipment_id');

        if ( $this->Equipment_model->save_edit_image( $image, $name, $equipment_id) ){
            echo json_encode( 'true' );
        };
    }

    public function user_change_status() {
        $user       = $this->input->post('user');
        $status     = $this->input->post('status');

        $this_user  = $this->User_model->get_user_by_id( $user );

        if( $status == $this_user->status ) {
            echo json_encode('not_changed');
        } else {
            if( $this->User_model->update_user_info($user, array('status' => $status)) )
            {
                echo json_encode('changed');
            }
            else
            {
                echo json_encode('error');
            }
        }


    }

    public function offers__view() {
        $offer_id       = $this->input->post('offer_id');

        $offer          = $this->Offers_model->get_offer_item( $offer_id );

        if( $offer && ($offer->author_id != $this->session->user ) ){
            $this->Offers_model->edit_offer($offer_id, array('views' => $offer->views + 1) );
            echo json_encode( '+1' );
        }
        else
        {
            echo json_encode('err');
        }

    }





    public function profile__save() {

        $update_data = array();

        if($this->input->post('name')){
            $update_data['name'] = $this->input->post('name');
        }
        if($this->input->post('last_name')){
            $update_data['last_name'] = $this->input->post('last_name');
        }
        if($this->input->post('second_name')){
            $update_data['second_name'] = $this->input->post('second_name');
        }
        if($this->input->post('profession_id')){
            $update_data['profession'] = $this->input->post('profession_id');
        }
        if($this->input->post('city')){
            $update_data['city'] = $this->input->post('city');
        }
        if($this->input->post('contact_phone')){
            $update_data['contact_phone'] = $this->input->post('contact_phone');
        }
        if($this->input->post('show_phone') == 1){
            $update_data['show_phone'] = 1;
        } else {
            $update_data['show_phone'] = 0;
        }

        if($this->input->post('direction_sell') == 'sell' && $this->input->post('direction_buy') == 'buy'){
            $update_data['direction'] = 'all';
        } elseif( $this->input->post('direction_buy') == 'buy' ) {
            $update_data['direction'] = 'buy';
        } elseif( $this->input->post('direction_sell') == 'sell' ) {
            $update_data['direction'] = 'sell';
        } else {
            $update_data['direction'] = 'none';
        }

        if( $this->input->post('brand') )
            $update_data['brands'] = $this->input->post('brand');

        if( $this->input->post('email') )
            $update_data['email'] = $this->input->post('email');

        // обновляем данные о пользователе. ID берем из сессии, чтобы БД лишний раз не дергать
        if( $this->User_model->update_user_info( intval($this->session->user), $update_data ) )
            echo json_encode(true);
        else
            echo json_encode(false);

    }

    public function profile__save__security() {

        $update_data = array();
        if  (
            $this->input->post('security_page') && (
                ($this->input->post('security_page') == 'partners') ||
                ($this->input->post('security_page') == 'all') ||
                ($this->input->post('security_page') == 'me')
            )
        )
        {
            $update_data['security_page'] = $this->input->post('security_page');
        }
        if  (
            $this->input->post('security_contacts') && (
                ($this->input->post('security_contacts') == 'partners') ||
                ($this->input->post('security_contacts') == 'all') ||
                ($this->input->post('security_contacts') == 'me')
            )
        )
        {
            $update_data['security_contacts'] = $this->input->post('security_contacts');
        }
        if  (
            $this->input->post('security_partners') && (
                ($this->input->post('security_partners') == 'all') ||
                ($this->input->post('security_partners') == 'me')
            )
        )
        {
            $update_data['security_partners'] = $this->input->post('security_partners');
        }
        if($this->input->post('email')){
            $update_data['email'] = $this->input->post('email');
        }

        // обновляем данные о пользователе. ID берем из сессии, чтобы БД лишний раз не дергать
        if( $this->User_model->update_user_info( intval($this->session->user), $update_data ) )
            echo json_encode(true);
        else
            echo json_encode(false);

    }

    public function company__join() {
        $company_id     = $this->input->post('company_id');

        $company    = $this->Company_model->get_company_by_id( intval( $company_id ) );
        $user       = $this->User_model->get_user_by_id( intval( $this->session->user ) );

        if( $company && $user ) {

            $this->Company_model->enter_company( $this->session->user, $company_id );

            $this->load->library('Socket');
            $socket     = new Socket();
            $socket->initialize();

            $noty_data = array(
                'user_id'       => $company->director,
                'from_id'       => $this->session->user,
                'from_company'  => 0,
                'title'         => $user->name.' '.$user->last_name,
                //Партнер установил статус:
                'content'       => 'Пользователь отправил запрос на присоединение к Вашей компании',
                'url'           => '/company/edit'
            );

            $noty    =  $this->Notification_model->form_notification( $noty_data );

            $socket->emit('send', [ 'channel' => 'channel_'.$company->director, 'type' => 'notification', 'content' => json_encode($noty)]);

            $candidats_count    = $this->Company_model->count_company_candidats( $company->id );
            $socket->emit('send', [ 'channel' => 'channel_'.$company->director, 'type' => 'informer__company_employers__count', 'content' => json_encode($candidats_count)]);
            $socket->emit('send', [ 'channel' => 'channel_'.$company->director, 'type' => 'informer__company_new__employer_modal', 'content' => json_encode($user)]);
            $socket->close();

            echo json_encode(true);
        } else {
            echo json_encode(false);
        }

    }

    public function profile__company__approvment () {
        $code           = $this->input->post('code');


        if ( $this->Company_model->make_company_active( $this->session->user, $code ) ) {
            echo json_encode('success');
        } else {
            echo json_encode('wrong');
        }

    }












    public function get_requests()
    {
        $filter = array(
            'type'                  => $this->input->post('type'),
            'sort'                  => $this->input->post('sort'),
            'employers'             => $this->input->post('employers'),
            'employers__to_show'    => $this->input->post('employers__to_show'), // Только для сохранения настроек фильтра
            'equipment'             => $this->input->post('equipment'),
            'date_from'             => '',
            'date_to'               => ''
        );

        $user   = $this->User_model->get_user_by_id( $this->session->user );

        if( $this->input->post('date_from')) {
            $date_from              = new DateTime( $this->input->post('date_from') );
            $filter['date_from']    = $date_from->format('Y-m-d');
        }

        if( $this->input->post('date_to')) {
            $date_to                = new DateTime( $this->input->post('date_to') );
            $filter['date_to']      = $date_to->format('Y-m-d');
        }

        if (is_array($this->input->post('status')) && !empty($this->input->post('status'))){

            $status_array = array();
            foreach ($this->input->post('status') as $status) {
                switch ($status) {
                    case 'formed':
                        $status_array[] = 'send';
                        $status_array[] = 'read';
                        $status_array[] = 'answered';
                        break;
                    case 'in_proccess':
                        $status_array[] = 'payed_delivered';
                        $status_array[] = 'in_process';
                        $status_array[] = 'payed';
                        $status_array[] = 'delivered';
                        break;
                    case 'done':
                        $status_array[] = 'done';
                        $status_array[] = 'finished';
                        break;
                    case 'canceled':
                        $status_array[] = 'canceled';
                        break;
                }
            }
            $filter['status'] = $status_array;
        }


        if ( $filter['type'] == 'outbox' ){
            $result[] = array(
                'user'      => $this->session->user,
                'requests'  => $this->Request_model->get_outbox_requests( $this->session->user, $filter )
            );

            $this->Request_model->update_user_filter( $this->session->user, 'outbox', $filter );

            if( is_array( $filter['employers'] ) && !empty( $filter['employers'] ) ) {
                foreach ( $filter['employers'] as $employer ) {
                    $result[] = array(
                        'user'      => $employer,
                        'requests'  => $this->Request_model->get_outbox_requests( $employer, $filter, false, $user->company_id  )
                    );
                }
            }
        }

        elseif( $filter['type'] == 'inbox' ){
            $result[] = array(
                'user'      => $this->session->user,
                'requests'  => $this->Request_model->get_inbox_requests( $this->session->user, $filter )
            );

            $this->Request_model->update_user_filter( $this->session->user, 'inbox', $filter );

            if( is_array( $filter['employers'] ) && !empty( $filter['employers'] ) ) {
                foreach ( $filter['employers'] as $employer ) {
                    $result[] = array(
                        'user'      => $employer,
                        'requests'  => $this->Request_model->get_inbox_requests( $employer, $filter, false, $user->company_id )
                    );
                }
            }
        }

        elseif( $filter['type'] == 'archive' ) {
            $result[] = array(
                'user'      => $this->session->user,
                'requests'  => $this->Request_model->get_archived_requests( $this->session->user, $filter )
            );

            $this->Request_model->update_user_filter( $this->session->user, 'archive', $filter );

            if( is_array( $filter['employers'] ) && !empty( $filter['employers'] ) ) {
                foreach ( $filter['employers'] as $employer ) {
                    $result[] = array(
                        'user'      => $employer,
                        'requests'  => $this->Request_model->get_archived_requests( $employer, $filter, false, $user->company_id )
                    );
                }
            }
        }

        echo json_encode( $result );
    }

    //  Отправляем заявку партнерам на третьем шаге добавления заявки
    public function requests__add_partners() {

        $insert_data        = array();
        $request_id         = $this->session->request_id;
        $partners_post      = $this->input->post('partners');

        $request            = $this->Request_model->get_request( $request_id );

        if( $request && is_object($request) && property_exists($request, 'step' ) && $request->step == 4) {
            echo json_encode('already send');
            die();
        }

        if( $request && is_array($partners_post) )
        {
            foreach ( $partners_post as $partner ) {

                $partner_data = array(
                     'request_id'   => $request_id,
                     'user_id'      => $partner,
                     'status'       => 'send',
                     'is_marked'    => 1
                );
                $partner_info   = $this->User_model->get_user_by_id( $partner );

                if( $partner_info->company_id && $partner_info->company_status == 'accepted' && $partner_info->company && is_object($partner_info->company) && $partner_info->company->director != $partner  )
                    $partner_data['company_id']     = $partner_info->company_id;

                $insert_data[]      = $partner_data;

            }

            if( $this->Request_model->add_partners ( $insert_data ) ) {

                $request_author  = $this->User_model->get_user_by_id(intval($this->session->user));

                $this->load->library('Socket');
                $socket     = new Socket();

                try {
                    $socket->initialize();
                }
                catch(Exception $e) {
                    exit( json_encode('no connection') );
                }


                foreach ($insert_data as $i_d) {
                    $noty_data = array(
                        'user_id'       => $i_d['user_id'],
                        'from_id'       => $this->session->user,
                        'from_company'  => 0,
                        'title'         => $request_author->name.' '.$request_author->second_name.' '.$request_author->last_name.' отправил(а) Вам заявку',
                        'content'       => 'Можете ответить на нее, либо отменить',
                        'url'           => '/requests/'.$request_id
                    );

                    $noty       = $this->Notification_model->form_notification( $noty_data );

                    $socket->emit('send', [ 'channel' => 'channel_'.$i_d['user_id'], 'type' => 'notification', 'content' => json_encode($noty)]);




                    $informer__request  = array (
                        'new'       => true,
                        'total'     => $this->Request_model->count_active_requests( $i_d['user_id'] ),
                        'inbox'     => $this->Request_model->count_inbox_active_requests( $i_d['user_id'] ),
                        'outbox'    => $this->Request_model->count_outbox_active_requests( $i_d['user_id'] ),
                    );

                    $socket->emit('send', [ 'channel' => 'channel_'.$i_d['user_id'], 'type' => 'informer__request', 'content' => json_encode($informer__request)]);


                    $informer__request  = array (
                        'type'      => 'inbox',
                        'user'      => $i_d['user_id'],
                        'request'   => $this->Request_model->get_inbox_requests( $i_d['user_id'], array('request_id' => $request_id))
                    );

                    $socket->emit('send', [ 'channel' => 'channel_'.$i_d['user_id'], 'type' => 'requests__list__new', 'content' => json_encode($informer__request)]);

                }

                $socket->close();

                $now                    = new DateTime();

                $data__request_update   = array(
                    'date'      => $now->format('Y-m-d H:i:s'),
                    'step'      => 4,
                );
                $this->Request_model->update_request( $request_id, $data__request_update );

                $this->session->unset_userdata('request_id');
                echo json_encode( '/requests/'.$request_id );
            }

            else echo json_encode('not added');
        }
        else echo json_encode('not array');
    }


    public function request__save_temp_data ()
    {
        $user_id = $this->session->user;
        $request_id = $this->input->post('request_id');
        $position_id = $this->input->post('position_id');
        $value = $this->input->post('value');
        $field = $this->input->post('field');

        $rel = $this->Request_model->get_user_request_relation( $request_id, $user_id);

        if( $rel ) {

            if (($field == 'actual' || $field == 'comment') && $user_id && $request_id) {

                switch ($field) {
                    case 'actual':
                        $value = new DateTime($value);
                        $value = $value->format('Y-m-d');
                        $this->Request_model->change_partners_request_data_by_request_id($user_id, $request_id, array('saved_actual' => $value, 'last_update' => $rel->last_update));
                        echo json_encode( $value );
                        break;
                    case 'comment':
                        $this->Request_model->change_partners_request_data_by_request_id($user_id, $request_id, array('saved_comment' => $value, 'last_update' => $rel->last_update));
                        break;
                }
            } elseif ($user_id && $request_id && $position_id) {


                switch ($field) {
                    case 'in_stock':
                        $current_response = $this->Request_model->get_request_response($request_id, $user_id, $position_id);

                        if( $current_response ){
                            $current_response   = get_object_vars($current_response);
                            $current_response['saved_in_stock']    = 1;
                            $this->Request_model->update_request_responses(array($current_response));
                        } else {
                            $data = array(
                                'position_id' => $position_id,
                                'request_id' => $request_id,
                                'user_id' => $user_id,
                                'saved_in_stock' => 1
                            );
                            $this->Request_model->update_request_responses(array($data));
                        }
                        break;
                    case 'not_in_stock':
                        $current_response = $this->Request_model->get_request_response($request_id, $user_id, $position_id);

                        if( $current_response ){
                            $current_response   = get_object_vars($current_response);
                            $current_response['saved_in_stock']    = 0;
                            $this->Request_model->update_request_responses(array($current_response));
                        } else {
                            $data = array(
                                'position_id' => $position_id,
                                'request_id' => $request_id,
                                'user_id' => $user_id,
                                'saved_in_stock' => 0
                            );
                            $this->Request_model->update_request_responses(array($data));
                        }
                        break;
                    case 'shipping':
                        $current_response = $this->Request_model->get_request_response($request_id, $user_id, $position_id);

                        if( $current_response ){
                            $current_response   = get_object_vars($current_response);
                            $current_response['saved_shipping']    = $value;
                            $this->Request_model->update_request_responses(array($current_response));
                        } else {
                            $data = array(
                                'position_id' => $position_id,
                                'request_id' => $request_id,
                                'user_id' => $user_id,
                                'saved_shipping' => $value
                            );
                            $this->Request_model->update_request_responses(array($data));
                        }
                        break;
                    case 'currency':
                        $current_response = $this->Request_model->get_request_response($request_id, $user_id, $position_id);

                        if( $current_response ){
                            $current_response   = get_object_vars($current_response);
                            $current_response['saved_currency']    = $value;
                            $this->Request_model->update_request_responses(array($current_response));
                        } else {
                            $data = array(
                                'position_id' => $position_id,
                                'request_id' => $request_id,
                                'user_id' => $user_id,
                                'saved_currency' => $value
                            );
                            $this->Request_model->update_request_responses(array($data));
                        }
                        break;
                    case 'price':
                        $current_response = $this->Request_model->get_request_response($request_id, $user_id, $position_id);

                        if( $current_response ){
                            $current_response   = get_object_vars($current_response);
                            $current_response['saved_price']    = $value;
                            $this->Request_model->update_request_responses(array($current_response));
                        } else {
                            $data = array(
                                'position_id' => $position_id,
                                'request_id' => $request_id,
                                'user_id' => $user_id,
                                'saved_price' => $value
                            );
                            $this->Request_model->update_request_responses(array($data));
                        }
                        break;
                }
            }


        }



    }
    //  Удаление заявки
    public function request__remove () {

        $request_id     = $this->input->post('request_id');

        $this->Request_model->remove_request( $request_id );

        echo json_encode('true');
    }

    //  Отклонение заявки менеджером
    public function request__partner_denied () {
        // Когда отказывает партнер
        $request_id     = $this->input->post('request_id');
        $request_data   = $this->Request_model->get_request( $request_id );

        $this->Request_model->change_partners_request_data_by_request_id($this->session->user, $request_id, array('status' => 'canceled', 'is_marked' => '0', 'viewed' => 0) );

        //  Убираем нотификацию о необходимости обновить данные
        $this->Notification_model->target_complete($this->session->user, 're_response__'.$request_id);

        $this->load->library('Socket');
        $socket     = new Socket();
        $socket->initialize();

        if( $this->Request_model->is_full_request_denied( $request_id ) ) {
            $noty_data = array(
                'user_id'       => $request_data->author,
                'from_id'       => $this->session->user,
                'from_company'  => 0,
                'title'         => 'Исходящая заявка #' . $request_data->id,
                'content'       => 'Все партнеры отклонили Вашу заявку',
                'url'           => '/requests/' . $request_data->id
            );

            $noty = $this->Notification_model->form_notification($noty_data);

            $socket->emit('send', [ 'channel' => 'channel_'.$request_data->author, 'type' => 'notification', 'content' => json_encode($noty)]);



        }    // Отклоняем заявку, если все отказались

        $informer__request__in_list  = array (
            'type'          => 'inbox',
            'user'          => $this->session->user,
            'request_id'    => $request_data->id,
            'request'       => $this->Request_model->get_inbox_requests( $this->session->user, array('request_id' => $request_data->id))
        );

        $socket->emit('send', [ 'channel' => 'channel_'.$this->session->user, 'type' => 'requests__list__update', 'content' => json_encode($informer__request__in_list)]);
        $socket->close();

        echo json_encode('true');
    }

    //  Отмена заявки автором
    public function request__author_denied () {

        // Когда заявку отклоняет автор, заявка имеет статус "Завершена", и все остальные статусы становятся отменены
        $request_id     = $this->input->post('request_id');
        $request_data   = $this->Request_model->get_request( $request_id );
        $partners       = $this->Request_model->get_request_partners_ids( $request_id );

        if( $this->Request_model->request_denied( $request_id ) ) {

            $this->load->library('Socket');
            $socket     = new Socket();
            $socket->initialize();


            if( is_array( $partners) && !empty( $partners)) {

                foreach( $partners as $partner ) {
                    $noty_data = array(
                        'user_id'       => $partner,
                        'from_id'       => $request_data->author,
                        'from_company'  => 0,
                        'title'         => 'Входящая заявка #' . $request_data->id,
                        'content'       => 'Автор отменил данную заявку',
                        'url'           => '/requests/' . $request_data->id
                    );

                    $noty = $this->Notification_model->form_notification($noty_data);

                    $socket->emit('send', [ 'channel' => 'channel_'.$partner, 'type' => 'notification', 'content' => json_encode($noty)]);


                    $informer__request__in_list  = array (
                        'type'          => 'inbox',
                        'user'          => $partner,
                        'request_id'    => $request_data->id,
                        'request'       => $this->Request_model->get_inbox_requests( $partner, array('request_id' => $request_data->id))
                    );

                    $socket->emit('send', [ 'channel' => 'channel_'.$partner, 'type' => 'requests__list__update', 'content' => json_encode($informer__request__in_list)]);




                    $informer__request  = array (
                        'new'       => false,
                        'total'     => $this->Request_model->count_active_requests( $partner ),
                        'inbox'     => $this->Request_model->count_inbox_active_requests( $partner ),
                        'outbox'    => $this->Request_model->count_outbox_active_requests( $partner ),
                    );

                    $socket->emit('send', [ 'channel' => 'channel_'.$partner, 'type' => 'informer__request', 'content' => json_encode($informer__request)]);


                }

            }


            $informer__request__in_list  = array (
                'type'          => 'outbox',
                'user'          => $this->session->user,
                'request_id'    => $request_data->id,
                'request'       => $this->Request_model->get_outbox_requests( $this->session->user, array('request_id' => $request_data->id))
            );

            $socket->emit('send', [ 'channel' => 'channel_'.$this->session->user, 'type' => 'requests__list__update', 'content' => json_encode($informer__request__in_list)]);

            $socket->close();

        };

        echo json_encode('true');
    }

    //  Подтверждение завершения заявки
    public function request__confirm_finishing () {

        $request_id     = $this->input->post('request_id');
        $executor_id    = $this->input->post('executor_id');

        if( $executor_id == $this->session->user ) {
            $this->Request_model->update_request( $request_id, array('status' => 'done'));
            $this->Request_model->change_partners_request_data_by_request_id ( $executor_id, $request_id, array('status' => 'finished', 'is_marked' => 0));

            $updated_request = $this->Request_model->get_request( $request_id );

            switch( $updated_request->status ) {
                case 'send':
                    $updated_request->status_text   = 'Сформирована (отправлена)';
                    $updated_request->html_class    = 'request__status--answered';
                    break;
                case 'read':
                    $updated_request->status_text   = 'Сформирована (прочитана)';
                    $updated_request->html_class    = 'request__status--answered';
                    break;
                case 'answered':
                    $updated_request->status_text   = 'Сформирована (есть ответ)';
                    $updated_request->html_class    = 'request__status--answered';
                    break;
                case 'in_process':
                    $updated_request->status_text   = 'В работе (ожидает оплаты)';
                    $updated_request->html_class    = 'request__status--active';
                    break;
                case 'payed':
                    $updated_request->status_text   = 'В работе (оплачено)';
                    $updated_request->html_class    = 'request__status--active';
                    break;
                case 'delivered':
                    $updated_request->status_text   = 'В работе (отгружено)';
                    $updated_request->html_class    = 'request__status--active';
                    break;
                case 'payed_delivered':
                    $updated_request->status_text   = 'В работе (оплачено и отгружено)';
                    $updated_request->html_class    = 'request__status--active';
                    break;
                case 'done':
                    $updated_request->status_text   = 'Завершена (требует подтверждения)';
                    $updated_request->html_class    = 'request__status--active';
                    break;
                case 'finished':
                    $updated_request->status_text   = 'Завершена';
                    $updated_request->html_class    = 'request__status--done';
                    break;
                case 'canceled':
                default:
                    $updated_request->status_text   = 'Отменена';
                    $updated_request->html_class    = 'request__status--canceled';
                    break;
            }

            // Отправляем нотификацию
            $noty_data = array(
                'user_id'       => $updated_request->author,
                'from_id'       => $updated_request->executor,
                'from_company'  => 0,
                'title'         => 'Заявка #'.$request_id,
                //Партнер установил статус:
                'content'       => $updated_request->status_text,
                'url'           => '/requests/'.$updated_request->id
            );

            // Обновляем заявку в списке заявок автора
            $informer__request  = array (
                'type'          => 'outbox',
                'user'          => $updated_request->author,
                'request_id'    => $request_id,
                'request'       => $this->Request_model->get_outbox_requests( $updated_request->author, array('request_id' => $request_id))
            );


            $this->load->library('Socket');
            $socket     = new Socket();
            $socket->initialize();

            $noty    = $this->Notification_model->form_notification( $noty_data );
            $socket->emit('send', [ 'channel' => 'channel_'.$updated_request->author, 'type' => 'notification', 'content' => json_encode($noty)]);

            $socket->emit('send', [ 'channel' => 'channel_'.$updated_request->author, 'type' => 'requests__list__update', 'content' => json_encode($informer__request)]);

            $informer__request  = array (
                'new'       => false,
                'total'     => $this->Request_model->count_active_requests( $this->session->user ),
                'inbox'     => $this->Request_model->count_inbox_active_requests( $this->session->user ),
                'outbox'    => $this->Request_model->count_outbox_active_requests( $this->session->user ),
            );

            $socket->emit('send', [ 'channel' => 'channel_'.$this->session->user, 'type' => 'informer__request', 'content' => json_encode($informer__request)]);

            $socket->close();


        } else {
            // Значит автор завершает заявку
            $this->Request_model->update_request( $request_id, array('status' => 'finished'));

        }

        echo json_encode( 'true' );
    }

    public function request__send_re_response () {
        $request_id     = $this->input->post('request_id');
        $partner_id     = $this->input->post('partner_id');
        $update_data    = array('can_re_response' => 0);

        $user_relation  = $this->Request_model->get_user_request_relation( $request_id, $partner_id );

        if( is_object($user_relation) ) {

            if ($user_relation->status == 'answered' && $user_relation->can_re_response == 1 && $user_relation->disable == false) {

                if( $this->Request_model->change_partners_request_data_by_request_id($partner_id, $request_id, $update_data) ){

                    $this->load->library('Socket');
                    $socket     = new Socket();
                    $socket->initialize();

                    $noty_data = array(
                        'user_id'       => $partner_id,
                        'from_id'       => $this->session->user,
                        'from_company'  => 0,
                        'title'         => 'Обновите свой ответ!',
                        'content'       => 'Автор заявки просит прислать актуальные данные по заявке #'.$request_id,
                        'url'           => '/requests/'.$request_id,
                        'target'        => 're_response__'.$request_id,
                        'type'          => 're_response'
                    );

                    $noty_id    = $this->Notification_model->save_notification( $noty_data );
                    $noty       = $this->Notification_model->get_notification( $noty_id );

                    $socket->emit('send', [ 'channel' => 'channel_'.$partner_id, 'type' => 'notification', 'content' => json_encode($noty)]);

                    $socket->close();

                    echo json_encode(true);
                } else
                    echo json_encode(false);
            }
            else
                echo json_encode(false);
        } else {

            echo json_encode(false);

        }



    }
    //  Простановка рейтинга
    public function request__set_rating ( ) {

        $request_id     = $this->input->post('request_id');
        $rating         = $this->input->post('rating');

        $request            = $this->Request_model->get_request( $request_id );

        if( is_object($request) ) {

            switch ($this->session->user) {

                case $request->author:

                    $updated_user       = $this->User_model->get_user_by_id( $request->executor );

                    $update_data = array(
                        'rating_executor'   => $rating
                    );

                    if( $request->rating_executor ) {

                        $update_user_data   = array(
                            'rating_points'     => $updated_user->rating_points - $request->rating_executor + $rating,
                            'rating_counts'     => $updated_user->rating_counts,
                        );

                        if( $updated_user->company_id != 0 && $updated_user->company_status == 'accepted') {

                            $company        = $this->Company_model->get_company_by_id( $updated_user->company_id );

                            if( $company ) {
                                $update_company_data   = array(
                                    'rating_points'     => $company->rating_points - $request->rating_executor + $rating,
                                    'rating_counts'     => $company->rating_counts,
                                );
                                $this->Company_model->update_company( $updated_user->company_id, $update_company_data );
                            }

                        }

                    } else {

                        $update_user_data   = array(
                            'rating_points'     => $updated_user->rating_points + $rating,
                            'rating_counts'     => $updated_user->rating_counts + 1,
                        );

                        if( $updated_user->company_id != 0 && $updated_user->company_status == 'accepted') {

                            $company        = $this->Company_model->get_company_by_id( $updated_user->company_id );

                            if( $company ) {
                                $update_company_data   = array(
                                    'rating_points'     => $company->rating_points + $rating,
                                    'rating_counts'     => $company->rating_counts + 1,
                                );
                                $this->Company_model->update_company( $updated_user->company_id, $update_company_data );
                            }

                        }

                    }

                    $this->User_model->update_user_info( $request->executor, $update_user_data );

                    if( isset( $update_data ) ) {
                        $this->Request_model->update_request( $request_id, $update_data, false );
                        echo json_encode('true');
                    } else {
                        echo json_encode('false');
                    }

                    break;



                case $request->executor:

                    $updated_user       = $this->User_model->get_user_by_id( $request->author );

                    $update_data = array(
                        'rating_author'   => $rating
                    );

                    if( $request->rating_author ) {

                        $update_user_data   = array(
                            'rating_points'     => $updated_user->rating_points - $request->rating_author + $rating,
                            'rating_counts'     => $updated_user->rating_counts,
                        );

                        if( $updated_user->company_id != 0 && $updated_user->company_status == 'accepted') {

                            $company        = $this->Company_model->get_company_by_id( $updated_user->company_id );

                            if( $company ) {
                                $update_company_data   = array(
                                    'rating_points'     => $company->rating_points - $request->rating_author + $rating,
                                    'rating_counts'     => $company->rating_counts,
                                );
                                $this->Company_model->update_company( $updated_user->company_id, $update_company_data );
                            }

                        }

                    } else {

                        $update_user_data   = array(
                            'rating_points'     => $updated_user->rating_points + $rating,
                            'rating_counts'     => $updated_user->rating_counts + 1,
                        );

                        if( $updated_user->company_id != 0 && $updated_user->company_status == 'accepted') {

                            $company        = $this->Company_model->get_company_by_id( $updated_user->company_id );

                            if( $company ) {
                                $update_company_data   = array(
                                    'rating_points'     => $company->rating_points + $rating,
                                    'rating_counts'     => $company->rating_counts + 1,
                                );
                                $this->Company_model->update_company( $updated_user->company_id, $update_company_data );
                            }

                        }

                    }

                    $this->User_model->update_user_info( $request->author, $update_user_data );

                    if( isset( $update_data ) ) {
                        $this->Request_model->update_request( $request_id, $update_data, false );
                        echo json_encode('true');
                    } else {
                        echo json_encode('false');
                    }

                    break;
            }

        }
        else
            echo json_encode('false');

    }

    public function request__copy () {

        $request_id     = $this->input->post('request_id');

        if( $this->Permissions_model->if_user_can('request__copy', $this->session->user, $request_id) ) {

            if( $this->Request_model->copy_request( $request_id ) )
                echo json_encode( 'true');
            else
                echo json_encode('error');
        } else echo json_encode( 'no_permissions');

    }

    public function request__compare_sort () {
        $sorted_response    = $this->input->post('sorted_response');

        if( is_array($sorted_response) && !empty($sorted_response) ) {
            foreach ( $sorted_response as $sort_index => $response_id ) {
                $update_data    = array(
                    'sort_index'    => $sort_index,
                );
                $this->Request_model->change_partners_request_data( $response_id, $update_data, true );

            }

        }
        echo json_encode( $sorted_response );

    }

    public function request__send_to_archive () {

        $request_id     = $this->input->post('request_id');
        $request_data   = $this->Request_model->get_request( $request_id );

        if( $request_data->author == $this->session->user ){
            $this->Request_model->update_request( $request_id, array('archived' => 1, 'is_marked' => 0), false);
            echo json_encode( 'true' );
            return;
        }
        elseif( $partner_relation = $this->Request_model->get_user_request_relation( $request_id, $this->session->user ) ) {

            if( $partner_relation->status == 'finished' || $partner_relation->status == 'canceled' ) {
                $this->Request_model->change_partners_request_data( $partner_relation->id, array('archived' => 1, 'is_marked' => 0), true );
                echo json_encode( 'true' );
                return;
            } else {
                echo json_encode( 'false' );
                return;
            }
        } else {
            echo json_encode( 'false' );
            return;
        }

    }
    //  Загрузка фотографий в библиотеку
    public function upload_to_library() {
        $id                 = $this->input->post( 'equipment_id' );
        $uploaded_images    = $this->input->post( 'uploaded_images' );
        $existing_images    = $this->input->post( 'existing_images' );

        $options = array(
            'post_images'       => $uploaded_images,
            'existing_images'   => $existing_images
        );

        $this->Equipment_model->edit_item( $id, $options );

        echo json_encode( $this->Equipment_model->get_item( $id ) );
    }









    public function search_users () {

        $keyword    = $this->input->get('query');

        header("Content-type: application/json; charset=UTF-8");
        header("Cache-Control: must-revalidate");
        header("Pragma: no-cache");
        header("Expires: -1");

        $result                 = array();

        $friends        = $this->User_model->search_friends( $keyword, 10 );
        $users          = $this->User_model->search_users( $keyword, 10 );
        $companies      = $this->Company_model->search_companies( $keyword, 10 );

        if( $friends ):
            $delimiter  = array( array( 'type' => 'delimiter', 'name' => 'Партнеры', 'value' => '') );
            $result     = array_merge( $result, $delimiter, $friends);
        endif;

        if( $users ):
            $delimiter  = array( array( 'type' => 'delimiter', 'name' => 'Потенциальные партнеры', 'value' => '' ) );
            $result     = array_merge( $result, $delimiter, $users);
        endif;

        if( $companies ):
            $delimiter  = array( array( 'type' => 'delimiter', 'name' => 'Компании', 'value' => '' ) );
            $result     = array_merge( $result, $delimiter, $companies);
        endif;

        $res = new stdClass;
        $res->query = $keyword;
        $res->suggestions = $result;

        echo json_encode( $res );
    }

    public function search_news () {

        $keyword    = $this->input->get('query');

        header("Content-type: application/json; charset=UTF-8");
        header("Cache-Control: must-revalidate");
        header("Pragma: no-cache");
        header("Expires: -1");

        $result     = $this->News_model->search_news( $keyword, 10 );

        if( count($result) == 0 ) {
            $result[]   = array(
                'type'          => 'not_found',
                'value'         => 'Совпадений не найдено',
            );
        } elseif( count($result) == 10 ) {
            $result[]   = array(
                'type'          => 'show_all',
                'value'         => 'Показать все результаты',
                'url'           => '/news/find?query='.$keyword
            );
        }

        $res = new stdClass;
        $res->query = $keyword;
        $res->suggestions = $result;

        echo json_encode( $res );
    }

    public function search_offers () {

        $keyword    = $this->input->get('query');

        header("Content-type: application/json; charset=UTF-8");
        header("Cache-Control: must-revalidate");
        header("Pragma: no-cache");
        header("Expires: -1");

        $result     = $this->Offers_model->search_offers( $keyword, 10 );

        if( count($result) == 0 ) {
            $result[]   = array(
                'type'          => 'not_found',
                'value'         => 'Совпадений не найдено',
            );
        } elseif( count($result) == 10 ) {
            $result[]   = array(
                'type'          => 'show_all',
                'value'         => 'Показать все результаты',
                'url'           => '/offers/find?query='.$keyword
            );
        }

        $res = new stdClass;
        $res->query = $keyword;
        $res->suggestions = $result;

        echo json_encode( $res );
    }

    public function search_requests () {

        $keyword    = $this->input->get('query');

        header("Content-type: application/json; charset=UTF-8");
        header("Cache-Control: must-revalidate");
        header("Pragma: no-cache");
        header("Expires: -1");

        $result     = $this->Request_model->search_request( $keyword, 100 );

        $in_keys = array();

        $final_result = array();

        foreach( $result as $r ) {

            if( array_key_exists('request_id', $r) && !in_array($r['request_id'], $in_keys) ) {
                $in_keys[]      = $r['request_id'];
                $final_result[] = $r;
            }

        }

        if( count($final_result) == 0 ) {
            $result[]   = array(
                'type'          => 'not_found',
                'value'         => 'Совпадений не найдено',
            );
        }

        $res = new stdClass;
        $res->query = $keyword;
        $res->suggestions = $final_result;

        echo json_encode( $res );
    }


    function change_plan__check( ) {

        $type           = $this->input->post( 'type' );
        $period         = $this->input->post( 'period' );

        $result = "error";
        $user   = $this->User_model->get_user_by_id( $this->session->user );

        switch ( $period ) {
            case "mounthly":

                if( $type == 'user' && $user->balance < 1000 ) {
                    $result     = "not_enouth_money";
                } else if( $type == 'company' && $user->balance < 2000 ) {
                    $result     = "not_enouth_money";
                } else {
                    $result     = "ok";
                }

                break;
            case "yearly":

                if( $type == 'user' && $user->balance < 10000 ) {
                    $result     = "not_enouth_money";
                } else if( $type == 'company' && $user->balance < 20000 ) {
                    $result     = "not_enouth_money";
                } else {
                    $result     = "ok";
                }
                break;
        }

        if( $type == "company" && !$user->tarif == "premium_company" ) {
            $result     = "error";
        }
        if( $type == "user" && !$user->tarif == "premium_user" ) {
            $result     = "error";
        }


        echo json_encode( $result );

    }



    function change_plan( ) {

        $type       = $this->input->post( 'type' );
        $period     = $this->input->post( 'period' );

        $result     = "";
        $user       = $this->User_model->get_user_by_id( $this->session->user );

        $now        = new DateTime();

        switch ( $period ) {
            case "mounthly":

                if( $type == 'user' ) {

                    $mounth     = new DateTime();
                    $mounth->add(new DateInterval('P1M'));

                    $balance    = intval( $user->balance ) - 1000;

                    if ($balance < 0) {
                        json_encode("error");
                        die();
                    }

                    $this->User_model->update_user_tarif( $this->session->user, 'premium_user', $mounth->format( 'Y-m-d'), $balance);
                    $result = "ok";

                } else if( $type == 'company' ) {

                    $mounth     = new DateTime();
                    $mounth->add(new DateInterval('P1M'));

                    $balance    = intval( $user->balance ) - 2000;

                    if ($balance < 0) {
                        json_encode("error");
                        die();
                    }

                    $this->User_model->update_user_tarif( $this->session->user, 'premium_company', $mounth->format( 'Y-m-d'), $balance);
                    $result = "ok";
                } else {
                    $result = "error";
                }

                break;
            case "yearly":

                if( $type == 'user' ) {

                    $mounth     = new DateTime();
                    $mounth->add(new DateInterval('P1Y'));

                    $balance    = intval( $user->balance ) - 10000;

                    if ($balance < 0) {
                        json_encode("error");
                        die();
                    }

                    $this->User_model->update_user_tarif( $this->session->user, 'premium_user', $mounth->format( 'Y-m-d'), $balance);
                    $result = "ok";

                } else if( $type == 'company' ) {

                    $mounth     = new DateTime();
                    $mounth->add(new DateInterval('P1Y'));

                    $balance    = intval( $user->balance ) - 20000;

                    if ($balance < 0) {
                        json_encode("error");
                        die();
                    }

                    $this->User_model->update_user_tarif( $this->session->user, 'premium_company', $mounth->format( 'Y-m-d'), $balance);
                    $result = "ok";
                }
                else {
                    $result = "error";
                }
                break;
            default:
                $result = "error";
                break;
        }



        echo json_encode( $result );



    }

}