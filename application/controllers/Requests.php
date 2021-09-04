<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 07.07.16
 * Time: 13:46
 */

class Requests extends CI_Controller
{
    private $auth_user = true;

    public function __construct()
    {


        parent::__construct();
        if ( $this->User_model->is_auth_user() ) {


            if ($this->input->get('logout')) {
                $this->User_model->user_logout();
                redirect( '/', 'refresh', 302);
            } else {

                /*
                 *
                 *  Обновляем инфу по заявкам!
                 *  Ищем завершенные или отмененные заявки,
                 *  и если с момента их last_update прошло уже 7 дней,
                 *  ставим им статус архивных. Не зависимо от авторов и исполнителей
                 *
                 */

                $this->User_model->online_checker( $this->session->user );
            }
        }
    }

    public function test() {

        $this->load->library('Socket');

        $socket     = new Socket();

        $socket->initialize();

        $informer__request__in_list = array(
            'type'          => 'outbox',
            'user'          => 108,
            'request_id'    => 136,
            'request'       => $this->Request_model->get_outbox_requests( 108, array('request_id' => 136))
        );

        $socket->emit('send', [ 'channel' => 'channel_108', 'type' => 'requests__list__update', 'content' => json_encode($informer__request__in_list)]);

        $socket->close();

        echo "123";
        die();
    }

    public function index( $id = 0, $compare = '' ) {
        if( $this->router->user_lang == 'ru' ){
            $this->lang->load('main', 'russian');
        } elseif ( $this->router->user_lang == 'en' ) {
            $this->lang->load('main', 'english');
        }

        if ( $this->User_model->is_auth_user() ) {

            $data_head['is_home_page']          = false;

            $data_head['meta_data']             = array(
                'title'         => 'Заявки',
                'keywords'      => '',
                'description'   => ''
            );

            $data_header = array(
                'usd'               => $this->Option_model->get_option("cbr_usd"),
                'eur'               => $this->Option_model->get_option("cbr_eur"),
                'search_or_link'    => array(
                    'type'          => 'search',
                    'target'        => 'requests',
                    'title'         => 'Поиск по заявкам'
                )
            );

            $data_footer = array(
                'notifications' => $this->Notification_model->get_notifications( $this->session->user )
            );

            $data_content = array(
                'menu'          => array(
                    'selected'          => 'requests',
                    'new_messages'      => $this->Message_model->count_unread_dialogs($this->session->user),
                    'new_partners'      => $this->Partner_model->get_inbox_partners_count($this->session->user),
                    'active_requests'   => $this->Request_model->count_active_requests($this->session->user),
                ),

            );

            $this->load->library('Socket');
            $socket     = new Socket();
            $socket_connection  = true;
            try {
                $socket->initialize();
            }
            catch(Exception $e) {
                $socket_connection  = false;
            }

            $user   = $this->User_model->get_user_by_id( $this->session->user );
            if( $user->company_id )
                if ( $user->id == $this->Company_model->get_company_director_id( $user->company_id ) ) {
                    $data_content['menu']['new_employers']  = $this->Company_model->count_company_candidats( $user->company_id );
                }

            $data_content['user']   = $user;


            /*      Обновляем статус заявки, когда она в работе и информируем автора    */
            if( $this->input->post('action') == 'update_request_status') {

                $post_request_id    = $this->input->post('request_id');
                $temp__request_data = $this->Request_model->get_request( $post_request_id );

                if ( is_object($temp__request_data) && $temp__request_data->status != 'canceled' && $temp__request_data->status != 'done' ) {


                    $status             = 'in_process';

                    if ( $this->input->post('request_status__done') ) {
                        $status         = 'done';
                    } elseif ( $this->input->post('request_status__payed') && $this->input->post('request_status__delivered')) {
                        $status         = 'payed_delivered';
                    } elseif ( $this->input->post('request_status__delivered') ) {
                        $status         = 'delivered';
                    } elseif ( $this->input->post('request_status__payed') ) {
                        $status         = 'payed';
                    }

                    $update_data = array(
                        'status'    => $status,
                    );

                    if( $status == 'done')
                        $update_data['is_marked'] = 1;

                    $this->Request_model->update_request( $post_request_id, $update_data);
                    $this->Request_model->change_partners_request_data_by_request_id( $this->session->user, $post_request_id, $update_data);


                    // Уведомляем автора(?) о изменении статуса заявки

                    $updated_request = $this->Request_model->get_request( $post_request_id );

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


                    if( $socket_connection ) {
                        // Отправляем нотификацию
                        $noty_data = array(
                            'user_id'       => $updated_request->author,
                            'from_id'       => $updated_request->executor,
                            'from_company'  => 0,
                            'title'         => 'Заявка #'.$post_request_id,
                            //Партнер установил статус:
                            'content'       => $updated_request->status_text,
                            'url'           => '/requests/'.$updated_request->id
                        );

                        $noty    = $this->Notification_model->form_notification( $noty_data );
                        $socket->emit('send', [ 'channel' => 'channel_'.$updated_request->author, 'type' => 'notification', 'content' => json_encode($noty)]);

                        // Обновляем заявку в списке заявок автора
                        $informer__request  = array (
                            'type'          => 'outbox',
                            'user'          => $updated_request->author,
                            'request_id'    => $post_request_id,
                            'request'       => $this->Request_model->get_outbox_requests( $updated_request->author, array('request_id' => $post_request_id))
                        );

                        $socket->emit('send', [ 'channel' => 'channel_'.$updated_request->author, 'type' => 'requests__list__update', 'content' => json_encode($informer__request)]);

                    }



                    redirect($_SERVER['REQUEST_URI'], 'refresh');

                }

            }

            if( $this->input->post('action') == 'set_executor') {

                $post_request_id    = $this->input->post('request_id');
                $post_executor_id   = $this->input->post('executor_id');

                $all_partners   = $this->Request_model->get_request_partners_ids( $post_request_id );


                $this->Request_model->set_executor( $post_request_id, $post_executor_id );

                if( is_array( $all_partners ) && !empty( $all_partners) ) {

                    foreach ( $all_partners as $partner__not_executor ) {

                        if( $partner__not_executor != $post_executor_id ) {

                            if( $socket_connection ) {

                                $noty_data = array(
                                    'total' => $this->Request_model->count_active_requests($partner__not_executor),
                                    'inbox' => $this->Request_model->count_inbox_active_requests($partner__not_executor),
                                    'outbox' => $this->Request_model->count_outbox_active_requests($partner__not_executor),
                                );

                                $socket->emit('send', ['channel' => 'channel_' . $partner__not_executor, 'type' => 'informer__request', 'content' => json_encode($noty_data)]);


                                $noty_data = array(
                                    'type' => 'inbox',
                                    'user' => $partner__not_executor,
                                    'request_id' => $post_request_id,
                                    'request' => $this->Request_model->get_inbox_requests($partner__not_executor, array('request_id' => $post_request_id))
                                );

                                $socket->emit('send', ['channel' => 'channel_' . $partner__not_executor, 'type' => 'requests__list__update', 'content' => json_encode($noty_data)]);


                                $noty_data = array(
                                    'user_id' => $partner__not_executor,
                                    'from_id' => $this->session->user,
                                    'from_company' => 0,
                                    'title' => 'Заявка #' . $post_request_id,
                                    'content' => 'К сожалению, для данной заявки был выбран другой исполнитель',
                                    'url' => '/requests/' . $post_request_id
                                );

                                $noty = $this->Notification_model->form_notification($noty_data);

                                $socket->emit('send', ['channel' => 'channel_' . $partner__not_executor, 'type' => 'notification', 'content' => json_encode($noty)]);

                            }

                        }

                    }

                }








                // уведомляем автора о заявке
                if( $socket_connection ) {

                    $noty_data = array(
                        'user_id' => $post_executor_id,
                        'from_id' => $this->session->user,
                        'from_company' => 0,
                        'title' => 'Заявка #' . $post_request_id,
                        'content' => $data_content['user']->name . ' ' . $data_content['user']->second_name . ' ' . $data_content['user']->last_name . ' заявки выбрал Вас исполнителем',
                        'url' => '/requests/' . $post_request_id
                    );

                    $noty = $this->Notification_model->form_notification($noty_data);

                    $socket->emit('send', ['channel' => 'channel_' . $this->input->post('executor_id'), 'type' => 'notification', 'content' => json_encode($noty)]);


                    $this->Request_model->change_partners_request_data_by_request_id($post_executor_id, $post_request_id, array('is_marked' => 1));


                    $noty_data = array(
                        'total' => $this->Request_model->count_active_requests($post_executor_id),
                        'inbox' => $this->Request_model->count_inbox_active_requests($post_executor_id),
                        'outbox' => $this->Request_model->count_outbox_active_requests($post_executor_id),
                    );

                    $socket->emit('send', ['channel' => 'channel_' . $post_executor_id, 'type' => 'informer__request', 'content' => json_encode($noty_data)]);


                    $noty_data = array(
                        'type' => 'inbox',
                        'user' => $post_executor_id,
                        'request_id' => $post_request_id,
                        'request' => $this->Request_model->get_inbox_requests($post_executor_id, array('request_id' => $post_request_id))
                    );
                    $socket->emit('send', ['channel' => 'channel_' . $post_executor_id, 'type' => 'requests__list__update', 'content' => json_encode($noty_data)]);

                }

            }




            if( $id != 0 )  {

                $data_footer['notifications'] = $this->Notification_model->get_notifications( $this->session->user );

                $data_content['request_data']           = $this->Request_model->get_request( $id );
                $data_content['menu']["go_back_url"]    = "/requests/inbox/";

                if( $data_content['request_data']->archived ) {
                    $data_content['menu']["go_back_url"]    = "/requests/archive/";
                } else if( $data_content['request_data']->is_author ) {
                    $data_content['menu']["go_back_url"]    = "/requests/outbox/";
                }


                if( !$data_content['request_data'] ) {
                    show_404();
                    return;
                }

                $data_content['request_positions']      = $this->Request_model->get_request_positions( $id );
                $data_content['request_partners']       = $this->Request_model->get_request_partners( $id );
                $data_content['request_partners_count'] = $this->Request_model->get_request_partners_count( $id );
                $data_content['request_author']         = $this->User_model->get_user_by_id( $data_content['request_data']->author );

                $current_user       = $this->User_model->get_user_by_id( $this->session->user );


                if( $this->input->get('view') == 'b' && $this->input->get('employer') ) {

                    $employer_id    = $this->input->get('employer');
                    $view_mode      = $this->Permissions_model->if_user_can('request__read_mode_from_user', $this->session->user, $id, array('from' => $employer_id));

                    if( $view_mode ) {
                        switch ($view_mode) {
                            case 'author_view':
                                if( $compare == 'compare' ) {
                                    $data_content['menu']["compare_page"]   = true;

                                    $data_content['request_partners_count'] = $this->Request_model->get_request_partners_count__last_status( $id );
                                    $data_header['search_or_link']  = array(
                                        'type'      => 'link',
                                        'url'       => '/requests/'.$id.'?view=b&employer='.$employer_id,
                                        'title'     => 'К описанию заявки'
                                    );

                                    if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                                        $this->load->view('mobile/user/head',       $data_head);
                                        $this->load->view('mobile/requests/page__single__compare__read_mode',   array("page_header"  => $data_header, "page_content" => $data_content ) );
                                        $this->load->view('mobile/user/footer',     $data_footer);

                                    else:

                                        $this->load->view('desktop/user/head',              $data_head);
                                        $this->load->view('desktop/user/header',            $data_header);
                                        $this->load->view('desktop/requests/page__single__compare__read_mode',    $data_content);
                                        $this->load->view('desktop/user/footer',            $data_footer);

                                    endif;


                                    return;

                                } else {

                                    if ( $data_content['request_data']->executor != 0 ) {
                                        $data_content['request_executor'] = $this->Request_model->get_request_executor($id, $data_content['request_data']->executor);
                                        $data_header['body_class'] = 'page-content-form__wrap';

                                        if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                                            $this->load->view('mobile/user/head',       $data_head);
                                            $this->load->view('mobile/requests/page__single__in_proccess__read_mode',   array("page_header"  => $data_header, "page_content" => $data_content ) );
                                            $this->load->view('mobile/user/footer',     $data_footer);

                                        else:

                                            $this->load->view('desktop/user/head', $data_head);
                                            $this->load->view('desktop/user/header', $data_header);
                                            $this->load->view('desktop/requests/page__single__in_proccess__read_mode', $data_content);
                                            $this->load->view('desktop/user/footer', $data_footer);

                                        endif;
                                        return;
                                    } else {
                                        $data_header['body_class'] = 'page-content-form__wrap';

                                        if( $data_content['request_data']->status == 'answered' && $data_content['request_partners_count']['total'] != 0 ) {
                                            $this->load->helper('morphem');
                                            $answered_text  = morphem( $data_content['request_partners_count']['total'], 'ответ', 'ответа', 'ответов');
                                            $data_content['request_data']->answered_text = 'Сформирована (есть '.$data_content['request_partners_count']['total'].' '.$answered_text.')';
                                        }

                                        if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                                            $this->load->view('mobile/user/head',       $data_head);
                                            $this->load->view('mobile/requests/page__single__owner__read_mode',   array("page_header"  => $data_header, "page_content" => $data_content ) );
                                            $this->load->view('mobile/user/footer',     $data_footer);

                                        else:

                                            $this->load->view('desktop/user/head', $data_head);
                                            $this->load->view('desktop/user/header', $data_header);
                                            $this->load->view('desktop/requests/page__single__owner__read_mode', $data_content);
                                            $this->load->view('desktop/user/footer', $data_footer);

                                        endif;

                                        return;
                                    }
                                }
                                break;
                            case 'executor_view':
                                if( $compare == 'compare') redirect('/requests/' . $id, 'refresh', 301);
                                $data_content['user_relation']          = $this->Request_model->get_user_request_relation($id, $employer_id);

                                $data_content['request_executor'] = $this->Request_model->get_request_executor($id, $data_content['request_data']->executor);
                                $data_header['body_class'] = 'page-content-form__wrap';

                                if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                                    $this->load->view('mobile/user/head',       $data_head);
                                    $this->load->view('mobile/requests/page__single__in_proccess__read_mode',   array("page_header"  => $data_header, "page_content" => $data_content ) );
                                    $this->load->view('mobile/user/footer',     $data_footer);

                                else:

                                    $this->load->view('desktop/user/head', $data_head);
                                    $this->load->view('desktop/user/header', $data_header);
                                    $this->load->view('desktop/requests/page__single__in_proccess__read_mode', $data_content);
                                    $this->load->view('desktop/user/footer', $data_footer);

                                endif;

                                return;
                                break;
                            case 'partner_view':

                                if( $compare == 'compare') redirect('/requests/' . $id, 'refresh', 301);

                                $data_content['user_relation']          = $this->Request_model->get_user_request_relation($id, $employer_id);
                                $data_content['responses']              = $this->Request_model->get_request_responses($id, $employer_id);

                                $data_header['body_class']      = 'page-content-form__wrap';


                                if ( $data_content['request_data']->executor != 0 ) {
                                    if ($this->agent->is_mobile()):

                                        $this->load->view('mobile/user/head', $data_head);
                                        $this->load->view('mobile/requests/page__single__in_proccess__read_mode', array("page_header" => $data_header, "page_content" => $data_content));
                                        $this->load->view('mobile/user/footer', $data_footer);

                                    else:

                                        $this->load->view('desktop/user/head', $data_head);
                                        $this->load->view('desktop/user/header', $data_header);
                                        $this->load->view('desktop/requests/page__single__in_proccess__read_mode', $data_content);
                                        $this->load->view('desktop/user/footer', $data_footer);

                                    endif;
                                }
                                else {

                                    if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                                        $this->load->view('mobile/user/head',       $data_head);
                                        $this->load->view('mobile/requests/page__single__no_executor__read_mode',   array("page_header"  => $data_header, "page_content" => $data_content ) );
                                        $this->load->view('mobile/user/footer',     $data_footer);

                                    else:

                                        $this->load->view('desktop/user/head', $data_head);
                                        $this->load->view('desktop/user/header', $data_header);
                                        $this->load->view('desktop/requests/page__single__no_executor__read_mode', $data_content);
                                        $this->load->view('desktop/user/footer', $data_footer);

                                    endif;
                                }


                                return;
                                break;
                            default:
                                redirect('/requests/', 'refresh', 301);
                        }
                    }
                    else
                        redirect('/requests/', 'refresh', 301);
                }



                $data_content['user_relation']          = $this->Request_model->get_user_request_relation($id, $this->session->user );

                if( $data_content['request_data']->is_marked == '1' && $data_content['request_data']->author == $this->session->user  ) {
                    $this->Request_model->update_request( $id, array('is_marked' => 0) );     // Автор просмотрел заявку
                }


                if( $data_content['request_data']->status == 'answered' && $data_content['request_partners_count']['total'] != 0 ) {
                    $this->load->helper('morphem');
                    $answered_text  = morphem( $data_content['request_partners_count']['total'], 'ответ', 'ответа', 'ответов');
                    $data_content['request_data']->answered_text = 'Сформирована (есть '.$data_content['request_partners_count']['total'].' '.$answered_text.')';
                }



                if ( $this->session->user == $data_content['request_data']->author ) {


                    if( $data_content['request_data']->company_id && $this->Company_model->is_ex_employer( $this->session->user, $data_content['request_data']->company_id) ){
                        redirect('/requests/', 'refresh', 301);
                    }





                    $data_content['menu']['menu__outbox_page_link']   = true;

                    if( $compare == 'compare' ) {

                        $data_content['menu']["go_back_url"]    = '/requests/'.$id; // для мобильной версии
                        $data_content['menu']["compare_page"]   = true;

                        $data_header['search_or_link']  = array(
                            'type'      => 'link',
                            'url'       => '/requests/'.$id,
                            'title'     => 'К описанию заявки'
                        );


                        if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                            $this->load->view('mobile/user/head',       $data_head);

                            if( $data_content['request_data']->executor == 0  ) {
                                $this->load->view('mobile/requests/page__single__compare',   array("page_header"  => $data_header, "page_content" => $data_content ) );
                            }
                            else {
                                $data_content['request_partners_count'] = $this->Request_model->get_request_partners_count__last_status( $id );
                                $this->load->view('mobile/requests/page__single__compare__read_mode',   array("page_header"  => $data_header, "page_content" => $data_content ) );
                            }

                            $this->load->view('mobile/user/footer',     $data_footer);


                        else:

                            $this->load->view('desktop/user/head',              $data_head);
                            $this->load->view('desktop/user/header',            $data_header);

                            if( $data_content['request_data']->executor == 0  ) {
                                $this->load->view('desktop/requests/page__single__compare',    $data_content);
                            }
                            else {
                                $data_content['request_partners_count'] = $this->Request_model->get_request_partners_count__last_status( $id );
                                $this->load->view('desktop/requests/page__single__compare__read_mode',    $data_content);
                            }

                            $this->load->view('desktop/user/footer',            $data_footer);
                        endif;

                        return;

                    }

                    else {

                        if( $data_content['request_data']->archived != 1 ){
                            $data_header['search_or_link']  = array(
                                'type'      => 'link',
                                'url'       => '/requests/',
                                'title'     => 'К исходящим заявкам'
                            );
                        } else {
                            $data_header['search_or_link']  = array(
                                'type'      => 'link',
                                'url'       => '/requests/archive',
                                'title'     => 'К архивным заявкам'
                            );
                            $data_content['menu']['menu__archive_page_link']   = true;
                        }


                        if( $data_content['request_data']->executor != 0 ) {

                            if( $data_content['request_data']->status == 'done' || $data_content['request_data']->status == 'finished'  || $data_content['request_data']->status == 'canceled' ) {

                                $now                    = new DateTime();
                                $last_up                = new DateTime($data_content['request_data']->last_update);
                                $last_up->modify('+7 day');

                                if( $last_up->format('U') > $now->format('U'))
                                    $data_content['request_data']->can__set_rating   = true;
                                else
                                    $data_content['request_data']->can__set_rating   = false;

                            } else
                                $data_content['request_data']->can__set_rating   = true;

                            $data_content['request_executor']   = $this->Request_model->get_request_executor( $id, $data_content['request_data']->executor );
                            $data_header['body_class']          = 'page-content-form__wrap';

                            $data_footer['noty_to_hide']        = array('re_response');

                            if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                                $this->load->view('mobile/user/head',       $data_head);
                                $this->load->view('mobile/requests/page__single__in_proccess',   array("page_header"  => $data_header, "page_content" => $data_content ) );
                                $this->load->view('mobile/user/footer',     $data_footer);

                            else:

                                $this->load->view('desktop/user/head',              $data_head);
                                $this->load->view('desktop/user/header',            $data_header);
                                $this->load->view('desktop/requests/page__single__in_proccess',    $data_content);
                                $this->load->view('desktop/user/footer',            $data_footer);

                            endif;

                            return;
                        }
                        else {

                            $data_header['body_class']          = 'page-content-form__wrap';

                            if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                                $this->load->view('mobile/user/head',       $data_head);
                                $this->load->view('mobile/requests/page__single__owner',   array("page_header"  => $data_header, "page_content" => $data_content ) );
                                $this->load->view('mobile/user/footer',     $data_footer);

                            else:

                                $this->load->view('desktop/user/head',              $data_head);
                                $this->load->view('desktop/user/header',            $data_header);
                                $this->load->view('desktop/requests/page__single__owner',    $data_content);
                                $this->load->view('desktop/user/footer',            $data_footer);

                            endif;

                            return;

                        }
                    }

                }


                /*
                 *  Если пользователь - один из потенциальных исполнителей
                 */
                elseif( $data_content['user_relation'] ) {

                    if( $data_content['user_relation']->company_id && $this->Company_model->is_ex_employer( $this->session->user, $data_content['user_relation']->company_id) ){
                        redirect('/requests/', 'refresh', 301);
                    }



                    if ($compare == 'compare')
                        redirect('/requests/' . $id, 'refresh', 301);

                    if ( $data_content['user_relation']->archived != 1 ){
                        $data_header['search_or_link']  = array(
                            'type'      => 'link',
                            'url'       => '/requests/inbox',
                            'title'     => 'Ко входящим заявкам'
                        );
                        $data_content['menu']['menu__inbox_page_link']   = true;
                    } else {
                        $data_header['search_or_link']  = array(
                            'type'      => 'link',
                            'url'       => '/requests/archive',
                            'title'     => 'К архивным заявкам'
                        );
                        $data_content['menu']['menu__archive_page_link']   = true;
                    }


                    if ($data_content['request_data']->executor != 0 && $this->session->user == $data_content['request_data']->executor) {



                        if( $data_content['request_data']->status == 'done' || $data_content['request_data']->status == 'finished'  || $data_content['request_data']->status == 'canceled' ) {

                            $now                    = new DateTime();
                            $last_up                = new DateTime($data_content['user_relation']->last_update);
                            $last_up->modify('+7 day');

                            if( $last_up->format('U') > $now->format('U'))
                                $data_content['request_data']->can__set_rating   = true;
                            else
                                $data_content['request_data']->can__set_rating   = false;

                        } else
                            $data_content['request_data']->can__set_rating   = true;

                        $data_content['request_executor'] = $this->Request_model->get_request_executor($id, $data_content['request_data']->executor);
                        $data_header['body_class'] = 'page-content-form__wrap';

                        if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                            $this->load->view('mobile/user/head',       $data_head);
                            $this->load->view('mobile/requests/page__single__in_proccess',   array("page_header"  => $data_header, "page_content" => $data_content ) );
                            $this->load->view('mobile/user/footer',     $data_footer);

                        else:

                            $this->load->view('desktop/user/head', $data_head);
                            $this->load->view('desktop/user/header', $data_header);
                            $this->load->view('desktop/requests/page__single__in_proccess', $data_content);
                            $this->load->view('desktop/user/footer', $data_footer);

                        endif;

                        return;
                    } else {
                        $data_header['body_class'] = 'page-content-form__wrap';

                        if ($this->input->post('action') == 'update_response' && !$data_content['user_relation']->disable) {

                            $response_insert_data = array(); // Глобальный массив для обновления данных

                            $request_id = $id;
                            $response_id = $this->input->post('response_id');
                            $price = $this->input->post('price');
                            $shipping = $this->input->post('shipping');
                            $currency = $this->input->post('currency');
                            $in_stock = $this->input->post('in_stock');
                            $actual = $this->input->post('actual');
                            $comment = $this->input->post('comment');

                            $now    = new DateTime();
                            $actual = new DateTime($actual);

                            if( $actual <= $now )
                                redirect('/requests/' . $id, 'refresh', 301);


                            $actual = $actual->format('Y-m-d');

                            if (is_array($in_stock) && !empty($in_stock)) {

                                foreach ($in_stock as $response_key => $response_value) {
                                    if (array_key_exists($response_key, $price) && $price[$response_key]) {

                                        $position_response = array(
                                            'id' => '',
                                            'user_id' => $this->session->user,
                                            'position_id' => $response_key,
                                            'request_id' => $request_id,
                                            'price' => $price[$response_key],
                                            'currency' => $currency[$response_key],
                                            'in_stock' => $in_stock[$response_key],
                                            'shipping' => $shipping[$response_key],
                                        );

                                        if (is_array($response_id) && array_key_exists($response_key, $response_id)) {
                                            $position_response['id'] = intval($response_id[$response_key]);
                                        } else {
                                            unset($position_response['id']);
                                        }


                                        $response_insert_data[] = $position_response;

                                    }
                                }

                                $this->Request_model->update_request_responses($response_insert_data);
                                $this->Request_model->change_partners_request_data($data_content['user_relation']->id, array('status' => 'answered', 'last_status' => 'answered', 'actual' => $actual, 'comment' => $comment, 'is_marked' => 0));
                                $this->Request_model->update_request($id, array('status' => 'answered', 'is_marked' => 1));

                                //  Убираем нотификацию о необходимости обновить данные
                                $this->Notification_model->target_complete($this->session->user, 're_response__'.$request_id);
                                $data_footer = array(
                                    'notifications' => $this->Notification_model->get_notifications( $this->session->user )
                                );

                                // Уведомляем автора о заявке
                                if( $socket_connection ) {

                                    $noty_data = array(
                                        'user_id' => $data_content['request_data']->author,
                                        'from_id' => $this->session->user,
                                        'from_company' => 0,
                                        'title' => 'Заявка #' . $data_content['request_data']->id,
                                        'content' => $data_content['user']->name . ' ' . $data_content['user']->last_name . ' ответил(а) на Вашу заявку',
                                        'url' => '/requests/' . $data_content['request_data']->id . '/compare'
                                    );

                                    $noty = $this->Notification_model->form_notification($noty_data);

                                    $socket->emit('send', [ 'channel' => 'channel_'.$data_content['request_data']->author, 'type' => 'notification', 'content' => json_encode($noty)]);



                                    $informer__request = array(
                                        'total' => $this->Request_model->count_active_requests($data_content['request_data']->author),
                                        'inbox' => $this->Request_model->count_inbox_active_requests($data_content['request_data']->author),
                                        'outbox' => $this->Request_model->count_outbox_active_requests($data_content['request_data']->author),
                                    );

                                    $socket->emit('send', [ 'channel' => 'channel_'.$data_content['request_data']->author, 'type' => 'informer__request', 'content' => json_encode($informer__request)]);



                                    $informer__request__in_list = array(
                                        'type' => 'outbox',
                                        'user' => $data_content['request_data']->author,
                                        'request_id' => $data_content['request_data']->id,
                                        'request' => $this->Request_model->get_outbox_requests($data_content['request_data']->author, array('request_id' => $data_content['request_data']->id))
                                    );

                                    $socket->emit('send', [ 'channel' => 'channel_'.$data_content['request_data']->author, 'type' => 'requests__list__update', 'content' => json_encode($informer__request__in_list)]);

                                }

                                redirect($_SERVER['REQUEST_URI'], 'refresh');

                            }


                        }

                        $data_content['responses'] = $this->Request_model->get_request_responses($id, $this->session->user);

                        if ($data_content['user_relation']->status == 'send') {
                            $this->Request_model->change_partners_request_data($data_content['user_relation']->id, array('status' => 'read', 'last_status' => 'read'));
                        }

                        if ($data_content['request_data']->status == 'send') {
                            $this->Request_model->update_request($id, array('status' => 'read'));
                            $data_content['request_data'] = $this->Request_model->get_request($id);
                        }

                        $data_content['request_executor']               = false;
                        $data_content['request_data']->can__set_rating  = false;

                        if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                            $this->load->view('mobile/user/head',       $data_head);
                            $this->load->view('mobile/requests/page__single__no_executor',   array("page_header"  => $data_header, "page_content" => $data_content ) );
                            $this->load->view('mobile/user/footer',     $data_footer);

                        else:

                            $this->load->view('desktop/user/head', $data_head);
                            $this->load->view('desktop/user/header', $data_header);
                            $this->load->view('desktop/requests/page__single__no_executor', $data_content);
                            $this->load->view('desktop/user/footer', $data_footer);

                        endif;

                        return;
                    }

                }
                else {

                    redirect('/requests/', 'refresh', 301);

                }

            }

            else {

                $data_content['menu']['menu__outbox_page_link_']   = true;

                $data_content['equipment']      = $this->Equipment_model->get_items( $this->session->user );

                $filter_saved                   = $this->Request_model->get_user_filter( $this->session->user, 'outbox');
                $data_content['user']->requests = $this->Request_model->get_outbox_requests( $this->session->user, get_object_vars($filter_saved) );

                // По умолчанию статусы заявок недоступны все
                $current_filter = array(
                    'formed'        => false,
                    'in_proccess'   => false,
                    'done'          => false,
                    'canceled'      => false,
                );

                $current_filter = $this->Request_model->update_avalible_filter_options( $current_filter, $this->session->user, 'outbox', true);

                if ( is_object( $data_content['user']->company ) &&  $data_content['user']->company->is_manager ) {

                    $employers = $this->Company_model->get_company_employers( $data_content['user']->company->id, false, true );

                    $data_content['employers']  = array();

                    if( is_array($employers) && !empty( $employers) ) {
                        foreach ($employers as $em_key => $employer) {
                            if($employer->id == $this->session->user) {
                                unset( $employers[$em_key] );
                            }
                            else {
                                $employer->requests_count   = $this->Request_model->count_outbox_requests($employer->id);
                                $employer->requests  = $this->Request_model->get_outbox_requests( $employer->id, get_object_vars($filter_saved), false, $data_content['user']->company->id );

                                $current_filter = $this->Request_model->update_avalible_filter_options( $current_filter, $employer->id, 'outbox', $data_content['user']->company->id);

                                $data_content['employers'][]    = $employer;
                            }
                        }
                    }

                    $ex_employers   = $this->Company_model->get_company_employers( $data_content['user']->company->id, true, true );


                    if( is_array($ex_employers) && !empty( $ex_employers) ) {
                        foreach ($ex_employers as $ex_em_key => $ex_employer) {
                            if($ex_employer->id == $this->session->user) {
                                unset( $ex_employers[$em_key] );
                            }
                            else {
                                $ex_employer->requests_count   = false;
                                $ex_employer->requests  = $this->Request_model->get_outbox_requests( $ex_employer->id, get_object_vars($filter_saved), false, $data_content['user']->company->id );

                                $current_filter = $this->Request_model->update_avalible_filter_options( $current_filter, $ex_employer->id, 'outbox', $data_content['user']->company->id);

                                $data_content['employers'][]    = $ex_employer;
                            }
                        }
                    }
                } else {
                    $data_content['employers'] = false;
                }

                $data_content['filter__avalible_options'] = $current_filter;

                $data_content['sub_menu'] = array (
                    'selected'      => 'outbox',
                    'outbox_count'  => $this->Request_model->count_outbox_active_requests($this->session->user),
                    'inbox_count'   => $this->Request_model->count_inbox_active_requests($this->session->user),
                );

                $data_content['filter_saved'] = $filter_saved;
                $data_header['body_class']  = 'page-requests';


                if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                    $this->load->view('mobile/user/head',       $data_head);
                    $this->load->view('mobile/requests/page__list',array("page_header"  => $data_header, "page_content" => $data_content ) );
                    $this->load->view('mobile/user/footer',     $data_footer);

                else:

                    $this->load->view('desktop/user/head',      $data_head);
                    $this->load->view('desktop/user/header',    $data_header);
                    $this->load->view('desktop/requests/page__list',  $data_content);
                    $this->load->view('desktop/user/footer',    $data_footer);

                endif;


            }


            $socket->close();

        } else {
            redirect('/', 'refresh', 302);
        }
    }

    public function inbox() {

        if( $this->router->user_lang == 'ru' ){
            $this->lang->load('main', 'russian');
        } elseif ( $this->router->user_lang == 'en' ) {
            $this->lang->load('main', 'english');
        }

        if ( $this->User_model->is_auth_user() ) {
            $data_head['is_home_page']          = false;
            $data_head['meta_data']             = array(
                'title'         => 'Входящие заявки',
                'keywords'      => '',
                'description'   => ''
            );
            $data_header = array(
                'usd'       => $this->Option_model->get_option("cbr_usd"),
                'eur'       => $this->Option_model->get_option("cbr_eur"),
                'body_class'=> 'page-requests',
                'search_or_link'    => array(
                    'type'          => 'search',
                    'target'        => 'requests',
                    'title'         => 'Поиск по заявкам'
                )
            );
            $data_footer = array(
                'notifications' => $this->Notification_model->get_notifications( $this->session->user )
            );

            $data_content = array(
                'menu'          => array(
                    'selected'          => 'requests',
                    'new_messages'      => $this->Message_model->count_unread_dialogs($this->session->user),
                    'new_partners'      => $this->Partner_model->get_inbox_partners_count($this->session->user),
                    'active_requests'   => $this->Request_model->count_active_requests($this->session->user),
                    'menu__inbox_link'  => true,
                ),
                'sub_menu'      => array(
                    'selected'      => 'inbox',
                    'outbox_count'  => $this->Request_model->count_outbox_active_requests($this->session->user),
                    'inbox_count'   => $this->Request_model->count_inbox_active_requests($this->session->user),
                ),
                'equipment'     => $this->Equipment_model->get_items( $this->session->user )
            );

            $user   = $this->User_model->get_user_by_id( $this->session->user );
            if( $user->company_id )
                if ( $user->id == $this->Company_model->get_company_director_id( $user->company_id ) ) {
                    $data_content['menu']['new_employers']  = $this->Company_model->count_company_candidats( $user->company_id );
                }

            $data_content['user']   = $user;

            $filter_saved = $this->Request_model->get_user_filter( $this->session->user, 'inbox');

            $data_content['user']->requests = $this->Request_model->get_inbox_requests( $this->session->user, get_object_vars($filter_saved)  );

            // По умолчанию статусы заявок недоступны все
            $current_filter = array(
                'formed'        => false,
                'in_proccess'   => false,
                'done'          => false,
                'canceled'      => false,
            );
            $current_filter = $this->Request_model->update_avalible_filter_options( $current_filter, $this->session->user, 'inbox', true);

            // Список исходящих заявок сотрудников
            if ( is_object( $data_content['user']->company ) &&  $data_content['user']->company->is_manager ) {
                $employers = $this->Company_model->get_company_employers( $data_content['user']->company->id );

                $data_content['employers']  = array();

                if( is_array($employers) && !empty( $employers) ) {
                    foreach ($employers as $em_key => $employer) {
                        if($employer->id == $this->session->user) {
                            unset( $employers[$em_key] );
                        }
                        else {
                            $employer->requests_count   = $this->Request_model->count_inbox_requests($employer->id);
                            $employer->requests  = $this->Request_model->get_inbox_requests( $employer->id, get_object_vars($filter_saved), false, $data_content['user']->company->id );

                            $current_filter = $this->Request_model->update_avalible_filter_options( $current_filter, $employer->id, 'inbox', $data_content['user']->company->id);

                            $data_content['employers'][]    = $employer;
                        }
                    }
                }

                $ex_employers   = $this->Company_model->get_company_employers( $data_content['user']->company->id, true );


                if( is_array($ex_employers) && !empty( $ex_employers) ) {
                    foreach ($ex_employers as $ex_em_key => $ex_employer) {
                        if($ex_employer->id == $this->session->user) {
                            unset( $ex_employers[$em_key] );
                        }
                        else {
                            $employer->requests_count   = false;
                            $ex_employer->requests  = $this->Request_model->get_inbox_requests( $ex_employer->id, get_object_vars($filter_saved), false, $data_content['user']->company->id );

                            $current_filter = $this->Request_model->update_avalible_filter_options( $current_filter, $ex_employer->id, 'inbox', $data_content['user']->company->id);

                            $data_content['employers'][]    = $ex_employer;
                        }
                    }
                }
            } else {
                $data_content['employers'] = false;
            }

            $data_content['filter__avalible_options'] = $current_filter;
            $data_content['filter_saved'] = $filter_saved;


            if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                $this->load->view('mobile/user/head',       $data_head);
                $this->load->view('mobile/requests/page__list',array("page_header"  => $data_header, "page_content" => $data_content ) );
                $this->load->view('mobile/user/footer',     $data_footer);

            else:

                $this->load->view('desktop/user/head',              $data_head);
                $this->load->view('desktop/user/header',            $data_header);
                $this->load->view('desktop/requests/page__list',    $data_content);
                $this->load->view('desktop/user/footer',            $data_footer);

            endif;


        } else {
            redirect('/', 'refresh', 302);
        }
    }

    public function outbox() {
        redirect( '/requests/', 'refresh', 302);
    }

    public function archive () {

        if( $this->router->user_lang == 'ru' ){
            $this->lang->load('main', 'russian');
        } elseif ( $this->router->user_lang == 'en' ) {
            $this->lang->load('main', 'english');
        }

        if ( $this->User_model->is_auth_user() ) {
            $data_head['is_home_page']          = false;
            $data_head['meta_data']             = array(
                'title'         => 'Архив заявок',
                'keywords'      => '',
                'description'   => ''
            );
            $data_header = array(
                'usd'       => $this->Option_model->get_option("cbr_usd"),
                'eur'       => $this->Option_model->get_option("cbr_eur"),
                'body_class'=> 'page-requests',
                'search_or_link'    => array(
                    'type'          => 'search',
                    'target'        => 'requests',
                    'title'         => 'Поиск по заявкам'
                )
            );

            $data_footer = array(
                'notifications' => $this->Notification_model->get_notifications( $this->session->user )
            );

            $data_content = array(
                'menu'          => array(
                    'selected'          => 'requests',
                    'new_messages'      => $this->Message_model->count_unread_dialogs($this->session->user),
                    'new_partners'      => $this->Partner_model->get_inbox_partners_count($this->session->user),
                    'active_requests'   => $this->Request_model->count_active_requests($this->session->user),
                    'menu__archive_link'    => true,
                ),
                'sub_menu'      => array(
                    'selected'      => 'archive',
                    'outbox_count'  => $this->Request_model->count_outbox_active_requests($this->session->user),
                    'inbox_count'   => $this->Request_model->count_inbox_active_requests($this->session->user),
                ),

                'equipment'     => $this->Equipment_model->get_items( $this->session->user )

            );

            $user   = $this->User_model->get_user_by_id( $this->session->user );
            if( $user->company_id )
                if ( $user->id == $this->Company_model->get_company_director_id( $user->company_id ) ) {
                    $data_content['menu']['new_employers']  = $this->Company_model->count_company_candidats( $user->company_id );
                }

            $data_content['user']   = $user;

            $filter_saved       = $this->Request_model->get_user_filter( $this->session->user, 'archive');
            $data_content['filter_saved'] = $filter_saved;

            $data_content['user']->requests = $this->Request_model->get_archived_requests($this->session->user, get_object_vars($filter_saved), false, false  );


            // По умолчанию статусы заявок недоступны все
            $current_filter = array(
                'formed'        => false,
                'in_proccess'   => false,
                'done'          => false,
                'canceled'      => false,
            );
            $current_filter = $this->Request_model->update_avalible_filter_options( $current_filter, $this->session->user, 'archive', true);


            // Список исходящих заявок сотрудников
            if ( is_object( $data_content['user']->company ) &&  $data_content['user']->company->is_manager ) {
                $employers      = $this->Company_model->get_company_employers( $data_content['user']->company->id );

                $data_content['employers']  = array();

                if( is_array($employers) && !empty( $employers) ) {
                    foreach ($employers as $em_key => $employer) {
                        if($employer->id == $this->session->user) {
                            unset( $employers[$em_key] );
                        }
                        else {
                            $employer->requests_count   = $this->Request_model->count_inbox_requests($employer->id);
                            $employer->requests  = $this->Request_model->get_archived_requests( $employer->id, get_object_vars($filter_saved), false, $data_content['user']->company->id );

                            $current_filter = $this->Request_model->update_avalible_filter_options( $current_filter, $employer->id, 'archive', $data_content['user']->company->id);

                            $data_content['employers'][]    = $employer;
                        }
                    }
                }

                $ex_employers   = $this->Company_model->get_company_employers( $data_content['user']->company->id, true );


                if( is_array($ex_employers) && !empty( $ex_employers) ) {
                    foreach ($ex_employers as $ex_em_key => $ex_employer) {
                        if($ex_employer->id == $this->session->user) {
                            unset( $ex_employers[$em_key] );
                        }
                        else {
                            $ex_employer->requests_count    = false;
                            $ex_employer->requests  = $this->Request_model->get_archived_requests( $ex_employer->id, get_object_vars($filter_saved), false, $data_content['user']->company->id );

                            $current_filter = $this->Request_model->update_avalible_filter_options( $current_filter, $ex_employer->id, 'archive', $data_content['user']->company->id);

                            $data_content['employers'][]    = $ex_employer;
                        }
                    }
                }

            } else {
                $data_content['employers'] = false;
            }

            $data_content['filter__avalible_options'] = $current_filter;


            if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                $this->load->view('mobile/user/head',       $data_head);
                $this->load->view('mobile/requests/page__list',array("page_header"  => $data_header, "page_content" => $data_content ) );
                $this->load->view('mobile/user/footer',     $data_footer);

            else:

                $this->load->view('desktop/user/head',                  $data_head);
                $this->load->view('desktop/user/header',                $data_header);
                $this->load->view('desktop/requests/page__list',        $data_content);
                $this->load->view('desktop/user/footer',                $data_footer);

            endif;

        } else {
            redirect('/', 'refresh', 302);
        }
    }

    public function add () {

        if( $this->router->user_lang == 'ru' ){
            $this->lang->load('main', 'russian');
        } elseif ( $this->router->user_lang == 'en' ) {
            $this->lang->load('main', 'english');
        }

        if ( $this->User_model->is_auth_user() ) {
            $data_head['is_home_page']          = false;
            $data_head['meta_data']             = array(
                'title'         => 'Добавить заявку',
                'keywords'      => '',
                'description'   => ''
            );
            $data_header = array(
                'usd'           => $this->Option_model->get_option("cbr_usd"),
                'eur'           => $this->Option_model->get_option("cbr_eur"),
                'body_class'    => 'page-content-form__wrap',
                'search_or_link'    => array(
                    'type'          => 'link',
                    'url'           => '/requests/',
                    'title'         => 'К списку заявок'
                )
            );
            $data_footer = array(
                'notifications' => $this->Notification_model->get_notifications( $this->session->user )
            );
            $data_content = array(
                'menu'          => array(
                    'selected'          => 'requests',
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

            $data_content['user']   = $user;


            if ( $undone_request = $this->Request_model->get_undone_requests( $this->session->user) ) {

                $this->session->set_userdata('request_id', $undone_request->id);

                $request            = $this->Request_model->get_request( $undone_request->id );

                if( $request && $request->step != 4 ):
                    $request_positions  = $this->Request_model->get_request_positions($request->id);
                    $request_equipment  = $this->Equipment_model->get_item($request->eq_id);
                    // Если у заявки небыло картинки, но к парку техники мы ее потом добавили
                    if( !$request->eq_images && $request_equipment->thumbnail ) :
                        $this->Request_model->update_request( $request->id, array('eq_images' => json_encode($request_equipment->images)));
                        $request            = $this->Request_model->get_request( $request->id );
                    endif;
                else:
                    $this->session->unset_userdata('request_id');
                    $request            = false;
                    $request_positions  = false;
                endif;

            }
            else {
                $this->session->unset_userdata('request_id');
                $request            = false;
                $request_positions  = false;
            }


/*
            if( isset( $this->session->request_id ) )
            {
                $request            = $this->Request_model->get_request( $this->session->request_id );

                if( $request && $request->step != 4 ):

                    $request_positions  = $this->Request_model->get_request_positions($request->id);
                    $request_equipment  = $this->Equipment_model->get_item($request->eq_id);

                    // Если у заявки небыло картинки, но к парку техники мы ее потом добавили
                    if( !$request->eq_images && $request_equipment->thumbnail ) :
                        $this->Request_model->update_request( $request->id, array('eq_images' => json_encode($request_equipment->images)));
                        $request            = $this->Request_model->get_request( $request->id );
                    endif;

                else:
                    $this->session->unset_userdata('request_id');
                    $request            = false;
                    $request_positions  = false;
                endif;

            }

            else if ( $undone_request = $this->Request_model->get_undone_requests( $this->session->user) ) {

                $this->session->request_id = $undone_request->id;
                $request            = $this->Request_model->get_request( $undone_request->id );
                $request_positions  = $this->Request_model->get_request_positions($request->id);
                $request_equipment  = $this->Equipment_model->get_item($request->eq_id);

                // Если у заявки небыло картинки, но к парку техники мы ее потом добавили
                if( !$request->eq_images && $request_equipment->thumbnail ) {
                    $this->Request_model->update_request( $request->id, array('eq_images' => json_encode($request_equipment->images)));
                    $request            = $this->Request_model->get_request( $request->id );
                }
            }
            else {
                $request            = false;
                $request_positions  = false;
            }
*/
            // Редактируем первый шаг
            if( $request && $this->input->get('action') == 'edit_equipment') {

                $data_content['request_data']           = $request;
                $data_content['equipment_selected']     = $this->Equipment_model->get_item( $request->eq_id );
                $data_content['brands']                 = $this->Option_model->get_directory('brand', true);
                $data_content['equipment_appointment']  = $this->Option_model->get_directory('equipment_appointment', true);
                $data_content['equipment']              = $this->Equipment_model->get_items( $this->session->user );




                if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                    $this->load->view('mobile/user/head',       $data_head);
                    $this->load->view('mobile/requests/page__add__step_1',array("page_header"  => $data_header, "page_content" => $data_content ) );
                    $this->load->view('mobile/user/footer',     $data_footer);

                else:

                    $this->load->view('desktop/user/head',                      $data_head);
                    $this->load->view('desktop/user/header',                    $data_header);
                    $this->load->view('desktop/requests/page__add__step_1',     $data_content);
                    $this->load->view('desktop/user/footer',                    $data_footer);

                endif;


                return true;
            }

            // Редактируем второй шаг
            if( $request && $this->input->get('action') == 'edit_positions') {


                $data_content['equipment']              = $this->Equipment_model->get_item( $request->eq_id );
                $data_content['request_data']           = $request;
                $data_content['request_positions']      = $request_positions;


                if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                    $this->load->view('mobile/user/head',       $data_head);
                    $this->load->view('mobile/requests/page__add__step_2',array("page_header"  => $data_header, "page_content" => $data_content ) );
                    $this->load->view('mobile/user/footer',     $data_footer);

                else:

                    $this->load->view('desktop/user/head',                      $data_head);
                    $this->load->view('desktop/user/header',                    $data_header);
                    $this->load->view('desktop/requests/page__add__step_2',     $data_content);
                    $this->load->view('desktop/user/footer',                    $data_footer);

                endif;

                return true;
            }

            // Если нет заявки и мы добавляем единицу из парка техники
            if( !$request && $this->input->get('action') == 'create_request_from_park' && $this->input->get('equipment_id') ) {
                // Создаем копию единицы парка техники с неизменяемыми параметрами

                $equipment      = $this->Equipment_model->get_item( $this->input->get('equipment_id') );

                $request_equipment = array(
                    'eq_id'             => $equipment->id,
                    'eq_brand'          => $equipment->brand,
                    'eq_appointment'    => $equipment->appointment,
                    'eq_model'          => $equipment->model,
                    'eq_serial_number'  => $equipment->serial_number,
                    'eq_engine'         => $equipment->engine,
                    'eq_year'           => $equipment->year,
                    'eq_section'        => $equipment->section,
                    'eq_images'         => json_encode($equipment->images),
                );

                $rqst = array(
                    'author'            => $this->session->user,
                    'eq_id'             => $equipment->id, // родитель копии парка (для фильтра)
                    'step'              => 2
                );

                $author_info            = $this->User_model->get_user_by_id( $this->session->user );
                if( $author_info->company_id && $author_info->company_status == 'accepted' && !$author_info->company->is_manager )
                    $rqst['company_id']     = $author_info->company_id;

                $this->session->request_id = $this->Request_model->create_request( $rqst );

                $this->Request_model->update_request( $this->session->request_id, $request_equipment );

                $request            = $this->Request_model->get_request( $this->session->request_id );
            }

            // Отправляем POST с первой страницы
            if ( $this->input->post('action') == 'select_equipment' ) {

                // Редактируем единицу парка техники

                if( $request && $this->input->post('request_id') && $this->input->post('request_id') == $request->id ) {

                    $edit_item = array();

                    if( $this->input->post('brand') ) {
                        $edit_item['brand']     = $this->input->post('brand');
                    }

                    if( $this->input->post('appointment') ) {
                        $edit_item['appointment']     = $this->input->post('appointment');
                    }

                    if( $this->input->post('model') ) {
                        $edit_item['model']     = $this->input->post('model');
                    }

                    if( $this->input->post('serial_number') ) {
                        $edit_item['serial_number']     = $this->input->post('serial_number');
                    }

                    if( $this->input->post('engine') ) {
                        $edit_item['engine']     = $this->input->post('engine');
                    }
                    if( $this->input->post('year') ) {
                        $edit_item['year']     = $this->input->post('year');
                    }

                    if( $this->input->post('section') ) {
                        $edit_item['section']     = $this->input->post('section');
                    }

                    if( $this->input->post('existing_images') ) {
                        $edit_item['existing_images']     = $this->input->post('existing_images');
                    }

                    if ( $this->input->post('show_in_park') == 'on' ) {
                        $add_item['show_in_park']   = 1;
                    }

                    $this->Equipment_model->edit_item( $request->eq_id, $edit_item);

                    $equipment      = $this->Equipment_model->get_item( $request->eq_id );
                    $request_equipment = array(
                        'eq_id'             => $equipment->id,
                        'eq_brand'          => $equipment->brand,
                        'eq_appointment'    => $equipment->appointment,
                        'eq_model'          => $equipment->model,
                        'eq_serial_number'  => $equipment->serial_number,
                        'eq_engine'         => $equipment->engine,
                        'eq_year'           => $equipment->year,
                        'eq_section'        => $equipment->section,
                    );

                    $this->Request_model->update_request( $this->session->request_id, $request_equipment );

                    $request    = $this->Request_model->get_request( $this->session->request_id );

                }

                // Добавляем единицу парка из полей

                elseif ( !$request ) {

                    $add_item = array(
                        'owner'         => $this->session->user,
                        'brand'         => $this->input->post('brand'),
                        'appointment'   => $this->input->post('appointment'),
                        'model'         => $this->input->post('model'),
                        'serial_number' => $this->input->post('serial_number'),
                        'engine'        => $this->input->post('engine'),
                        'year'          => $this->input->post('year'),
                        'section'       => $this->input->post('section'),
                        'show_in_park'  => 0,
                    );

                    $add_item__images   = $this->input->post('images');

                    if ( $this->input->post('show_in_park') == 'on' ) {
                        $add_item['show_in_park']   = 1;
                    }

                    $equipment_id = $this->Equipment_model->add_item($add_item, $add_item__images);

                    $equipment      = $this->Equipment_model->get_item( $equipment_id );
                    $request_equipment = array(
                        'eq_id'             => $equipment->id,
                        'eq_brand'          => $equipment->brand,
                        'eq_appointment'    => $equipment->appointment,
                        'eq_model'          => $equipment->model,
                        'eq_serial_number'  => $equipment->serial_number,
                        'eq_engine'         => $equipment->engine,
                        'eq_year'           => $equipment->year,
                        'eq_section'        => $equipment->section,
                        'eq_images'         => json_encode($equipment->images),
                        'eq_editable'       => true
                    );

                    $this->session->request_step = 2;
                    $this->session->request_equipment_id = $equipment_id;

                    $rqst = array(
                        'author'            => $this->session->user,
                        'eq_id'             => $equipment_id,
                        'step'              => 2
                    );
                    $this->session->request_id = $this->Request_model->create_request( $rqst );

                    $this->Request_model->update_request( $this->session->request_id, $request_equipment );

                    $request            = $this->Request_model->get_request( $this->session->request_id );

                }

            }

            if( $request && $this->input->post('action') == 'add_positions') {

                $this->Request_model->remove_positions( $this->session->request_id );

                $post_details   =   $this->input->post('detail');
                $post_cat_num   =   $this->input->post('catalog_num');
                $post_amount    =   $this->input->post('amount');
                $post_images    =   $this->input->post('images');

                foreach ( $post_details as $d_key => $d_value ) {

                    if( $post_cat_num[ $d_key ] != '' || $d_value != '') {

                        if( !$post_amount[$d_key] || intval( $post_amount[$d_key] ) < 1 ) {
                            $post_amount[$d_key] = 1;
                        }
                        $row = array(
                            'request_id'        => $this->session->request_id,
                            'detail'            => $d_value,
                            'catalog_num'       => $post_cat_num[ $d_key ],
                            'amount'            => intval( $post_amount[$d_key] ),
                        );

                        if( array_key_exists( $d_key, $post_images) && $post_images[ $d_key ] != '' ) {
                            $row['images'] = $post_images[$d_key];

                            $images_array = json_decode( $post_images[$d_key] );

                            $user_dir = './uploads/requests/'.$request->id;
                            if( !is_dir($user_dir) )
                                mkdir($user_dir);

                            $prefixies = array(
                                '',
                                '158x158_',
                                'lg1000_'
                            );
                            foreach ( $images_array as $image ) {

                                foreach ( $prefixies as $prefix ) {

                                    $file       = './uploads/equipment/'.$request->eq_id.'/'.$prefix.$image;
                                    $newfile    = './uploads/requests/'.$request->id.'/'.$prefix.$image;


                                    if (!copy($file, $newfile)) {
                                        echo "не удалось скопировать $file...\n";
                                        echo "<pre>";
                                        var_dump( $file );
                                        var_dump( $newfile );
                                        die();
                                    }

                                }

                            }

                        }



                        $this->Request_model->add_positions( $row );
                    }
                }



                $this->Request_model->update_request( $this->session->request_id, array('step' => 3) );

                $request            = $this->Request_model->get_request( $this->session->request_id );

            }


            if(  $this->input->post('action') ) {
                header("Cache-Control: no-store,no-cache,mustrevalidate");
                header("Location: ".$this->config->item('base_url')."/requests/add");
            }


            if ($request && $request->step != 1 && $request->step != 4) {
                switch ($request->step){
                    case 2:
                        if( $request->eq_id )
                        {
                            $data_content['equipment']          = $this->Equipment_model->get_item( $request->eq_id );
                            $data_content['request_data']       = $request;
                            $data_content['request_positions']  = $this->Request_model->get_request_positions($request->id);

                            if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                                $this->load->view('mobile/user/head',       $data_head);
                                $this->load->view('mobile/requests/page__add__step_2',array("page_header"  => $data_header, "page_content" => $data_content ) );
                                $this->load->view('mobile/user/footer',     $data_footer);

                            else:

                                $this->load->view('desktop/user/head',                      $data_head);
                                $this->load->view('desktop/user/header',                    $data_header);
                                $this->load->view('desktop/requests/page__add__step_2',     $data_content);
                                $this->load->view('desktop/user/footer',                    $data_footer);

                            endif;
                        }

                        break;
                    case 3:

                        $data_content['equipment']                      = $this->Equipment_model->get_item( $request->eq_id );

                        $partners_filter        = array(
                            'exclude_users'     => $this->Partner_model->get_partners_ids( $this->session->user ),
                            'brand'             => $data_content['equipment']->brand
                        );

                        $partners_filter['exclude_users'][]             = $this->session->user;
                        //$data_content['request_suggestion_partners']    = $this->User_model->get_users( $partners_filter );
                        $data_content['request_suggestion_partners']    = $this->Partner_model->get_partners_for_request( $partners_filter );
                        if( empty( $data_content['request_suggestion_partners'] ) ) {
                            $partners_filter['exclude_users'] = array($this->session->user);        // @Удалить
                            $data_content['request_suggestion_partners'] = $this->Partner_model->get_partners_for_request($partners_filter);
                        }
                        $data_content['request_data']                   = $request;
                        $data_content['request_positions']              = $this->Request_model->get_request_positions($request->id);
                        $data_content['request_partners']               = $this->Partner_model->get_partners( $this->session->user );

                        $position_progress__detail      = 0;
                        $position_progress__catalog_num = 0;

                        foreach ( $data_content['request_positions'] as $position ) {
                            if( $position->detail != '' )
                                $position_progress__detail      = 25;
                            if( $position->catalog_num != '' )
                                $position_progress__catalog_num = 25;
                        }

                        $data_content['total_progress'] = $data_content['request_data']->progress + $position_progress__detail + $position_progress__catalog_num;


                        if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                            $this->load->view('mobile/user/head',       $data_head);
                            $this->load->view('mobile/requests/page__add__step_3',array("page_header"  => $data_header, "page_content" => $data_content ) );
                            $this->load->view('mobile/user/footer',     $data_footer);

                        else:

                            $this->load->view('desktop/user/head',                      $data_head);
                            $this->load->view('desktop/user/header',                    $data_header);
                            $this->load->view('desktop/requests/page__add__step_3',     $data_content);
                            $this->load->view('desktop/user/footer',                    $data_footer);

                        endif;
                        break;

                }
            }
            else {
                $data_content['request_data']           = false;
                $data_content['brands']                 = $this->Option_model->get_directory('brand', true);
                $data_content['equipment_appointment']  = $this->Option_model->get_directory('equipment_appointment', true);
                $data_content['equipment']              = $this->Equipment_model->get_items( $this->session->user );

                if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                    $this->load->view('mobile/user/head',       $data_head);
                    $this->load->view('mobile/requests/page__add__step_1',array("page_header"  => $data_header, "page_content" => $data_content ) );
                    $this->load->view('mobile/user/footer',     $data_footer);

                else:

                    $this->load->view('desktop/user/head',                      $data_head);
                    $this->load->view('desktop/user/header',                    $data_header);
                    $this->load->view('desktop/requests/page__add__step_1',     $data_content);
                    $this->load->view('desktop/user/footer',                    $data_footer);

                endif;
            }


        } else {
            redirect('/', 'refresh', 302);
        }
    }

}
