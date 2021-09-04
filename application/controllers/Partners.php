<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 07.07.16
 * Time: 13:41
 */

class Partners extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ( $this->User_model->is_auth_user() ) {
            if ($this->input->get('logout')) {
                $this->User_model->user_logout();
                redirect( '/', 'refresh', 302);
            }
            $this->User_model->online_checker( $this->session->user );
            $this->Partner_model->erase_undone_requests( $this->session->user );
        }
    }

    public function index( $partner_id = '' ) {

        if( $this->router->user_lang == 'ru' ){
            $this->lang->load('main', 'russian');
        } elseif ( $this->router->user_lang == 'en' ) {
            $this->lang->load('main', 'english');
        }

        if ( $this->User_model->is_auth_user() ) {
            $data_head['is_home_page']          = false;

            if( $partner_id ) {

                $data_head['meta_data']             = array(
                    'title'         => 'Мои партнеры',
                    'keywords'      => '',
                    'description'   => ''
                );
                $data_header = array(
                    'usd'           => $this->Option_model->get_option("cbr_usd"),
                    'eur'           => $this->Option_model->get_option("cbr_eur"),
                    'body_class'    => 'js--news js--news-user',
                    'search_or_link'    => array(
                        'type'          => 'search',
                        'target'        => 'partners',
                        'title'         => 'Поиск по партнерам и компаниям'
                    ),
                );
                $data_footer = array(
                    'notifications' => $this->Notification_model->get_notifications( $this->session->user )
                );
                $data_content = array(
                    'menu'          => array(
                        'selected'          => '',
                        'new_messages'      => $this->Message_model->count_unread_dialogs($this->session->user),
                        'new_partners'      => $this->Partner_model->get_inbox_partners_count($this->session->user),
                        'active_requests'   => $this->Request_model->count_active_requests($this->session->user),
                    ),
                    'sub_menu'      => array(
                        'selected'      => 'partners',
                        'inbox_count'   => $this->Partner_model->get_inbox_partners_count($this->session->user),
                        'outbox_count'  => $this->Partner_model->get_outbox_partners_count($this->session->user),
                    )
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
                $data_content['this_user']  = false;

                if( $partner_id === $this->session->user) {

                    // Собираем данные
                    $data_head['is_home_page']          = false;
                    $data_head['meta_data']             = array(
                        'title'         => $user->name.' '.$user->last_name,
                        'keywords'      => '',
                        'description'   => ''
                    );
                    $data_header = array(
                        'usd'           => $this->Option_model->get_option("cbr_usd"),
                        'eur'           => $this->Option_model->get_option("cbr_eur"),
                        'body_class'    => 'js--news js--news-user js--news-edit',
                        'search_or_link'    => array(
                            'type'          => 'search',
                            'target'        => 'partners',
                            'title'         => 'Поиск по партнерам и компаниям'
                        ),
                    );

                    $data_content = array(
                        'menu'          => array(
                            'selected'          => 'main',
                            'new_messages'      => $this->Message_model->count_unread_dialogs($this->session->user),
                            'new_partners'      => $this->Partner_model->get_inbox_partners_count($this->session->user),
                            'active_requests'   => $this->Request_model->count_active_requests($this->session->user),
                        ),
                        'user'                  => $user,
                        'this_user'             => true,
                        'all__brands'           => $this->Option_model->get_directory('brand', true),
                        'user_brands'           => $this->User_model->get_user_brands( $this->session->user ),
                        'all__offer_categories' => $this->Option_model->get_directory('offer_category', true),

                    );

                    $user   = $this->User_model->get_user_by_id( $this->session->user );
                    if( $user->company_id )
                        if ( $user->id == $this->Company_model->get_company_director_id( $user->company_id ) ) {
                            $data_content['menu']['new_employers']  = $this->Company_model->count_company_candidats( $user->company_id );
                        }

                    $data_content['user']   = $user;

                    $data_content['company']                = $this->Company_model->get_company_by_id( $data_content['user']->company_id );
                    $data_content['offers__pinned']         = $this->Offers_model->get_offers( array('user_id'   => $this->session->user, 'pinned' => 'yes', 'sort_by' => 'pin_date') );
                    $data_content['partners']               = $this->Partner_model->get_partners( $this->session->user, array( 'limit' => 6, 'sort' => 'RAND') );


                    $data_content['users__offers_and_news']     = $this->User_model->get_user_content( array('user_id' => $this->session->user) );
                    $data_content['users__requests']            = $this->Request_model->get_users_requests( $this->session->user , array('limit' => 5 ));

                    $data_content['relationship']           = 'owner';

                    $data_content['view_mode']              = 'owner';
                    $data_content['count_user_partners']    = $this->Partner_model->count_user_partners( $this->session->user );
                    $data_content['count_user_news']        = $this->News_model->count_user_news( $partner_id );
                    $data_content['count_user_offers']      = $this->Offers_model->count_user_offers( $partner_id );

                    $data_content['count_user_requests']    = $this->Request_model->count_requests( $partner_id );




                    $ads_filter         = array(
                        'user_id'   => $partner_id,
                        'pinned'    => 'no',
                        'from'      => 0,
                        'limit'     => 10,
                        'inverse'   => false
                    );
                    $news_filter        = array(
                        'user_id'   => $partner_id,
                        'type'      => 'solo',
                        'from'      => 0,
                        'limit'     => 10,
                        'inverse'   => false
                    );

                    $data_content['users__news']    = $this->News_model->get_news( $news_filter );
                    $data_content['users__offers']  = $this->Offers_model->get_offers( $ads_filter);


                    if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                        $this->load->view('mobile/user/head',      $data_head);

                        // Профиль с именем, фамилией и городом считается заполненным
                        if($user->name && $user->city):
                            $this->load->view('mobile/user/user',      array( 'page_header'  => $data_header, 'page_content' => $data_content ) );
                        else:
                            $this->load->view('mobile/user/main',      array( 'page_header'  => $data_header, 'page_content' => $data_content ) );
                        endif;

                        $this->load->view('mobile/user/footer',        $data_footer);

                    else:

                        $this->load->view('desktop/user/head',      $data_head);
                        $this->load->view('desktop/user/header',    $data_header);

                        // Профиль с именем, фамилией и городом считается заполненным
                        if($user->name && $user->city):
                            $this->load->view('desktop/user/user',      $data_content);
                        else:
                            $this->load->view('desktop/user/main',      $data_content);
                        endif;

                        $this->load->view('desktop/user/footer',        $data_footer);

                    endif;



                }





                else {

                    if( $partner_id == 1)
                        redirect( '/', 'refresh', 302);

                    $data_content['partner']            = $this->User_model->get_user_by_id(intval($partner_id));

                    if( !$data_content['partner'] ) {
                        show_404();
                        return;
                    }

                    $data_content['is_dialog_exist']    = $this->Message_model->is_dialog_exist(array($this->session->user, $partner_id));
                    $data_content['company']            = $this->Company_model->get_company_by_id($data_content['partner']->company_id);
                    $data_content['partners__offers_and_news'] = $this->User_model->get_user_content(array('user_id' => $partner_id));
                    $data_content['offers__pinned']     = $this->Offers_model->get_offers(array('user_id' => $partner_id, 'pinned' => 'yes'));
                    $data_content['relationship']       = $this->Partner_model->check_relationship($this->session->user, $partner_id);


                    $data_content['partners']           = $this->Partner_model->get_partners( $partner_id );
                    $data_head['meta_data']['title']    = $data_content['partner']->name . ' ' . $data_content['partner']->last_name;

                    $data_content['count_user_news']        = $this->News_model->count_user_news( $partner_id );
                    $data_content['count_user_offers']      = $this->Offers_model->count_user_offers( $partner_id );


                    if ($data_content['relationship']) {
                        $data_content['user_request'] = $this->Partner_model->get_request($this->session->user, $partner_id);
                    } else {
                        $data_content{'user_request'} = false;
                    }

                    $data_content['view_mode']              = 'partner';        // для того, чтобы понять от кого смотреть
                    $data_content['count_user_partners']    = $this->Partner_model->count_user_partners( $partner_id );


                    if( $data_content['partner']->removed == 1 ) {

                        if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                            $this->load->view('mobile/user/head',      $data_head);
                            $this->load->view('mobile/partners/page__user_removed',      array( 'page_header'  => $data_header, 'page_content' => $data_content ) );
                            $this->load->view('mobile/user/footer',        $data_footer);

                        else:

                            $this->load->view('desktop/user/head', $data_head);
                            $this->load->view('desktop/user/header', $data_header);
                            $this->load->view('desktop/partners/page__user_removed', $data_content);
                            $this->load->view('desktop/user/footer',    $data_footer);

                        endif;

                    }
                    elseif ($data_content['relationship'] == 'partner') {

                        if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                            $this->load->view('mobile/user/head',      $data_head);
                            $this->load->view('mobile/partners/page__user_friend',      array( 'page_header'  => $data_header, 'page_content' => $data_content ) );
                            $this->load->view('mobile/user/footer',        $data_footer);

                        else:

                            $this->load->view('desktop/user/head', $data_head);
                            $this->load->view('desktop/user/header', $data_header);
                            $this->load->view('desktop/partners/page__user_friend', $data_content);
                            $this->load->view('desktop/user/footer',    $data_footer);

                        endif;



                    }
                    else {

                        if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                            $this->load->view('mobile/user/head',      $data_head);
                            $this->load->view('mobile/partners/page__user_unfriend',      array( 'page_header'  => $data_header, 'page_content' => $data_content ) );
                            $this->load->view('mobile/user/footer',        $data_footer);

                        else:

                            $this->load->view('desktop/user/head', $data_head);
                            $this->load->view('desktop/user/header', $data_header);
                            $this->load->view('desktop/partners/page__user_unfriend', $data_content);
                            $this->load->view('desktop/user/footer',    $data_footer);

                        endif;


                    }

                }

            }

            else {

                $data_head['meta_data']             = array(
                    'title'         => 'Мои партнеры',
                    'keywords'      => '',
                    'description'   => ''
                );
                $data_header = array(
                    'usd'           => $this->Option_model->get_option("cbr_usd"),
                    'eur'           => $this->Option_model->get_option("cbr_eur"),
                    'body_class'    => '',
                    'search_or_link'    => array(
                        'type'          => 'search',
                        'target'        => 'partners',
                        'title'         => 'Поиск по партнерам и компаниям'
                    ),
                );
                $data_footer = array(
                    'notifications' => $this->Notification_model->get_notifications( $this->session->user )
                );
                $data_content = array(
                    'menu'          => array(
                        'selected'          => 'partners',
                        'new_messages'      => $this->Message_model->count_unread_dialogs($this->session->user),
                        'new_partners'      => $this->Partner_model->get_inbox_partners_count($this->session->user),
                        'active_requests'   => $this->Request_model->count_active_requests($this->session->user),
                    ),
                    'sub_menu'      => array(
                        'selected'      => 'partners',
                        'inbox_count'   => $this->Partner_model->get_inbox_partners_count($this->session->user),
                        'outbox_count'  => $this->Partner_model->get_outbox_partners_count($this->session->user),
                    )
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
                $data_content['this_user']  = false;
                $data_content['partners'] = $this->Partner_model->get_partners( $this->session->user );

                // Убираем тех, кто у нас в друзьях и нас самих
                $filter                     = array();
                $exclude                    = array();

                $f_partners                 = $this->Partner_model->get_partners_ids( $this->session->user );
                if( is_array( $f_partners ))
                    $exclude                = array_merge($exclude, $f_partners);

                $f_potencial_partners       = $this->Partner_model->get_potencial_partners_ids( $this->session->user );
                if( is_array( $f_potencial_partners))
                    $exclude                = array_merge($exclude, $f_potencial_partners);

                $exclude[]                  = $this->session->user;
                $filter['exclude_users']    = $exclude;
                $filter['sortby']           = 'RAND';
                $filter['limit']            = 5;
                $data_content['potencial_partners']     = $this->User_model->get_users( $filter );


                if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                    $this->load->view('mobile/user/head',       $data_head);
                    $this->load->view('mobile/partners/page',   array("page_header"  => $data_header, "page_content" => $data_content ) );
                    $this->load->view('mobile/user/footer',     $data_footer);

                else:

                    $this->load->view('desktop/user/head',      $data_head);
                    $this->load->view('desktop/user/header',    $data_header);
                    $this->load->view('desktop/partners/page',  $data_content);
                    $this->load->view('desktop/user/footer',    $data_footer);

                endif;

            }


        } else {
            redirect('/', 'refresh', 302);
        }
    }

    /*  Входящие заявки заявки */
    public function inbox () {

        if( $this->router->user_lang == 'ru' ){
            $this->lang->load('main', 'russian');
        } elseif ( $this->router->user_lang == 'en' ) {
            $this->lang->load('main', 'english');
        }

        $data_head['is_home_page']          = false;
        $data_head['meta_data']             = array(
            'title'         => 'Партнеры',
            'keywords'      => '',
            'description'   => ''
        );
        $data_header = array(
            'usd'       => $this->Option_model->get_option("cbr_usd"),
            'eur'       => $this->Option_model->get_option("cbr_eur"),
            'search_or_link'    => array(
                'type'          => 'search',
                'target'        => 'partners',
                'title'         => 'Поиск по партнерам и компаниям'
            ),
        );
        $data_footer = array(
            'notifications' => $this->Notification_model->get_notifications( $this->session->user )
        );
        $data_content = array(
            'menu'          => array(
                'selected'          => 'partners',
                'new_messages'      => $this->Message_model->count_unread_dialogs($this->session->user),
                'new_partners'      => $this->Partner_model->get_inbox_partners_count($this->session->user),
                'active_requests'   => $this->Request_model->count_active_requests($this->session->user),
            ),
            'sub_menu'      => array(
                'selected'      => 'inbox',
                'inbox_count'   => $this->Partner_model->get_inbox_partners_count($this->session->user),
                'outbox_count'  => $this->Partner_model->get_outbox_partners_count($this->session->user),
            )
        );

        // Убираем тех, кто у нас в друзьях и нас самих
        //$exclude  = array($this->session->user);
        $exclude    = $this->Partner_model->get_partners_ids( $this->session->user );
        $exclude[]  = $this->session->user;

        $filter = array();
        $filter['exclude_users']    = $exclude;
        $filter['sortby']           = 'RAND';
        $filter['limit']            = 10;

        $data_content['users'] = $this->User_model->get_users( $filter );

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
        $data_content['partners']   = $this->Partner_model->get_inbox_partners( $this->session->user  );


        if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

            $this->load->view('mobile/user/head',      $data_head);
            $this->load->view('mobile/partners/page__list_inbox',      array( 'page_header'  => $data_header, 'page_content' => $data_content ) );
            $this->load->view('mobile/user/footer',        $data_footer);

        else:

            $this->load->view('desktop/user/head', $data_head);
            $this->load->view('desktop/user/header', $data_header);
            $this->load->view('desktop/partners/page__list_inbox', $data_content);
            $this->load->view('desktop/user/footer',    $data_footer);

        endif;

    }

    /*  Исходящие заявки */
    public function outbox () {

        if( $this->router->user_lang == 'ru' ){
            $this->lang->load('main', 'russian');
        } elseif ( $this->router->user_lang == 'en' ) {
            $this->lang->load('main', 'english');
        }

        $data_head['is_home_page']          = false;
        $data_head['meta_data']             = array(
            'title'         => 'Партнеры',
            'keywords'      => '',
            'description'   => ''
        );
        $data_header = array(
            'usd'       => $this->Option_model->get_option("cbr_usd"),
            'eur'       => $this->Option_model->get_option("cbr_eur"),
            'search_or_link'    => array(
                'type'          => 'search',
                'target'        => 'partners',
                'title'         => 'Поиск по партнерам и компаниям'
            ),
        );
        $data_footer = array(
            'notifications' => $this->Notification_model->get_notifications( $this->session->user )
        );
        $data_content = array(
            'menu'          => array(
                'selected'          => 'partners',
                'new_messages'      => $this->Message_model->count_unread_dialogs($this->session->user),
                'new_partners'      => $this->Partner_model->get_inbox_partners_count($this->session->user),
                'active_requests'   => $this->Request_model->count_active_requests($this->session->user),
            ),
            'sub_menu'      => array(
                'selected'      => 'outbox',
                'inbox_count'   => $this->Partner_model->get_inbox_partners_count($this->session->user),
                'outbox_count'  => $this->Partner_model->get_outbox_partners_count($this->session->user),
            )
        );

        $filter                     = array();
        $exclude                    = array();

        $f_partners                 = $this->Partner_model->get_partners_ids( $this->session->user );
        if( is_array( $f_partners ))
            $exclude                = array_merge($exclude, $f_partners);

        $f_potencial_partners       = $this->Partner_model->get_potencial_partners_ids( $this->session->user );
        if( is_array( $f_potencial_partners))
            $exclude                = array_merge($exclude, $f_potencial_partners);

        $exclude[]                  = $this->session->user;
        $filter['exclude_users']    = $exclude;
        $filter['sortby']           = 'RAND';
        $filter['limit']            = 5;
        $data_content['potencial_partners']     = $this->User_model->get_users( $filter );

        $data_content['partners']               = $this->Partner_model->get_outbox_partners( $this->session->user  );

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

        if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

            $this->load->view('mobile/user/head',      $data_head);
            $this->load->view('mobile/partners/page__list_outbox',      array( 'page_header'  => $data_header, 'page_content' => $data_content ) );
            $this->load->view('mobile/user/footer',        $data_footer);

        else:

            $this->load->view('desktop/user/head', $data_head);
            $this->load->view('desktop/user/header', $data_header);
            $this->load->view('desktop/partners/page__list_outbox', $data_content);
            $this->load->view('desktop/user/footer',    $data_footer);

        endif;
    }

    public function find( ) {

        if( $this->router->user_lang == 'ru' ){
            $this->lang->load('main', 'russian');
        } elseif ( $this->router->user_lang == 'en' ) {
            $this->lang->load('main', 'english');
        }

        $data_head['is_home_page']          = false;
        $data_head['meta_data']             = array(
            'title'         => 'Поиск партнеров',
            'keywords'      => '',
            'description'   => ''
        );
        $data_header = array(
            'usd'       => $this->Option_model->get_option("cbr_usd"),
            'eur'       => $this->Option_model->get_option("cbr_eur"),
            'search_or_link'    => array(
                'type'          => 'search',
                'target'        => 'partners',
                'title'         => 'Поиск по партнерам и компаниям'
            ),
        );
        $data_footer = array(
            'notifications' => $this->Notification_model->get_notifications( $this->session->user )
        );
        $data_content = array(
            'menu'          => array(
                'selected'          => 'partners',
                'new_messages'      => $this->Message_model->count_unread_dialogs($this->session->user),
                'new_partners'      => $this->Partner_model->get_inbox_partners_count($this->session->user),
                'active_requests'   => $this->Request_model->count_active_requests($this->session->user),
            ),
            'sub_menu'      => array(
                'selected'      => '',
                'inbox_count'   => $this->Partner_model->get_inbox_partners_count($this->session->user),
                'outbox_count'  => $this->Partner_model->get_outbox_partners_count($this->session->user),
            )
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
        $data_content['keyword']    = $this->input->get('query');

        if( $data_content['keyword'] ) {

            $data_content['users']      = $this->User_model->search_users( $data_content['keyword'], 0 );
            $data_content['friends']    = $this->User_model->search_friends( $data_content['keyword'], 0 );
            $data_content['companies']  = $this->Company_model->search_companies( $data_content['keyword'], 0 );

            $data_content['found__users']       = $this->User_model->count_search_users( $data_content['keyword'] );
            $data_content['found__friends']     = $this->User_model->count_search_friends( $data_content['keyword'] );
            $data_content['found__companies']   = $this->Company_model->count_search_companies( $data_content['keyword'] );
        }
        else {
            $data_content['users']      = false;
            $data_content['companies']  = false;

            $data_content['found__partners']    = 0;
            $data_content['found__companies']   = 0;
        }


        if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

            $this->load->view('mobile/user/head',      $data_head);
            $this->load->view('mobile/partners/page__list_find',      array( 'page_header'  => $data_header, 'page_content' => $data_content ) );
            $this->load->view('mobile/user/footer',        $data_footer);

        else:

            $this->load->view('desktop/user/head', $data_head);
            $this->load->view('desktop/user/header', $data_header);
            $this->load->view('desktop/partners/page__list_find', $data_content);
            $this->load->view('desktop/user/footer',    $data_footer);

        endif;

    }

}
