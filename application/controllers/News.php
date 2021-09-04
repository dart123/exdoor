<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 07.07.16
 * Time: 13:39
 */

class News extends CI_Controller
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

    public function index( $id = 0 ) {

        if( $this->router->user_lang == 'ru' ){
            $this->lang->load('main', 'russian');
        } elseif ( $this->router->user_lang == 'en' ) {
            $this->lang->load('main', 'english');
        }

        if ( $this->User_model->is_auth_user() ) {

            // Если он авторизован, но при попытке получить данные о нем возвращается false - выкидываем
            $user = $this->User_model->get_user_by_id( intval( $this->session->user ) );
            if(!$user){
                $this->User_model->user_logout();
                redirect('/', 'refresh');
            }
            $data_head['is_home_page']          = false;
            $data_head['meta_data']             = array(
                'title'                 => $this->Option_model->get_option( 'meta__news_title' ),
                'keywords'              => $this->Option_model->get_option( 'meta__news_keywords' ),
                'description'           => $this->Option_model->get_option( 'meta__news_description' ),
            );
            $data_header = array(
                'usd'           => $this->Option_model->get_option("cbr_usd"),
                'eur'           => $this->Option_model->get_option("cbr_eur"),
                'body_class'    => 'js--news js--news-edit',
                'search_or_link'    => array(
                    'type'          => 'search',
                    'target'        => 'news',
                    'title'         => 'Поиск по новостям'
                ),
            );
            $data_footer = array(
                'notifications' => $this->Notification_model->get_notifications( $this->session->user )
            );
            $data_content = array(
                'menu'          => array(
                    'selected'          => 'news',
                    'new_messages'      => $this->Message_model->count_unread_dialogs($this->session->user),
                    'new_partners'      => $this->Partner_model->get_inbox_partners_count($this->session->user),
                    'active_requests'   => $this->Request_model->count_active_requests($this->session->user),
                ),
                'project_news'      => false,
                'user'              => $user
            );

            if( $user->company_id )
                if ( $user->id == $this->Company_model->get_company_director_id( $user->company_id ) ) {
                    $data_content['menu']['new_employers']  = $this->Company_model->count_company_candidats( $user->company_id );
                }


            if( $id && $id != 0) {

                $data_header['search_or_link']  = array(
                    'type'      => 'link',
                    'url'       => '/news/',
                    'title'     => 'К списку новостей'
                );

                $data_content['news']   = $this->News_model->get_news_item( $id );

                if( !$data_content['news'] ) {
                    show_404();
                    return;
                }

                if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                    $this->load->view('mobile/user/head',          $data_head);
                    $this->load->view('mobile/news/page__single',  array("page_header"  => $data_header, "page_content" => $data_content ) );
                    $this->load->view('mobile/user/footer',        $data_footer);

                else:

                    $this->load->view('desktop/user/head',          $data_head);
                    $this->load->view('desktop/user/header',        $data_header);
                    $this->load->view('desktop/news/page__single',  $data_content);
                    $this->load->view('desktop/user/footer',        $data_footer);

                endif;


            }
            else {

                if( $user->company_id ){
                    $data_content['news']   = $this->News_model->get_news( array('user_id' => $this->session->user, 'type' => 'lenta', 'user_company_id' => $user->company_id )  );
                } else {
                    $data_content['news']   = $this->News_model->get_news( array('user_id' => $this->session->user, 'type' => 'lenta' )  );
                }

                if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                    $this->load->view('mobile/user/head',       $data_head);
                    $this->load->view('mobile/news/page',       array("page_header"  => $data_header, "page_content" => $data_content ) );
                    $this->load->view('mobile/user/footer',     $data_footer);

                else:

                    $this->load->view('desktop/user/head',      $data_head);
                    $this->load->view('desktop/user/header',    $data_header);
                    $this->load->view('desktop/news/page',      $data_content);
                    $this->load->view('desktop/user/footer',    $data_footer);

                endif;
            }


        } else {

            /*
             *
             *      Гостевой просмотр новостей от exdor
             *
             */

            $data_head['meta_data']             = array(
                'title'                 => $this->Option_model->get_option( 'meta__project_news_title' ),
                'keywords'              => $this->Option_model->get_option( 'meta__project_news_keywords' ),
                'description'           => $this->Option_model->get_option( 'meta__project_news_description' ),
            );
            $data_content = array(
                'menu'          => array(
                    'selected'          => 'news'
                ),
                'news'              => $this->News_model->get_news( array( 'user_id' => 1) ),
            );

            $user       = $this->User_model->get_user_by_id( $this->session->user );

            if( is_object($user) && $user->company_id )
                if ( $user->id == $this->Company_model->get_company_director_id( $user->company_id ) ) {
                    $data_content['menu']['new_employers']  = $this->Company_model->count_company_candidats( $user->company_id );
                }

            if( $id && $id != 0)
            {
                $data_content['current_news']       = $this->News_model->get_news_item( $id );
                $data_content['current_news_id']    = $id;
            }
            else
            {
                $data_content['current_news']       = false;
                $data_content['current_news_id']    = 0;
            }


            $data_content['go_back_url']        = $this->Page_model->home_page_link();


            $data_footer['is_home_page']        = false;
            //$data_footer['language_switcher']   = $this->Page_model->get_language_switcher("ru");   // Получаем переключатель языка
            $data_footer['footer_menu']         = $this->Page_model->get_footer_menu();              // Получаем меню навигации

            $data_header = array(
                'usd'       => $this->Option_model->get_option("cbr_usd"),
                'eur'       => $this->Option_model->get_option("cbr_eur"),
            );



            if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                $this->load->view('mobile/user/head',       $data_head);
                $this->load->view('mobile/main/header',     array("page_header"  => $data_header, "page_content" => $data_content, "page_footer" => $data_footer ));
                $this->load->view('mobile/news/guest__page', array( "page_content" => $data_content ) );
                $this->load->view('mobile/main/footer');

            else:

                $this->load->view('desktop/user/head',      $data_head);
                $this->load->view('desktop/misc/guest__html__header');
                $this->load->view('desktop/news/guest__page',      $data_content);
                $this->load->view('desktop/misc/guest__html__footer');

            endif;

        }
    }

    public function exdor() {

        if( $this->router->user_lang == 'ru' ){
            $this->lang->load('main', 'russian');
        } elseif ( $this->router->user_lang == 'en' ) {
            $this->lang->load('main', 'english');
        }

        if ( $this->User_model->is_auth_user() ) {
            $data_head['is_home_page']          = false;
            $data_head['meta_data']             = array(
                'title'                 => $this->Option_model->get_option( 'meta__project_news_title' ),
                'keywords'              => $this->Option_model->get_option( 'meta__project_news_keywords' ),
                'description'           => $this->Option_model->get_option( 'meta__project_news_description' ),
            );
            $data_header = array(
                'usd'           => $this->Option_model->get_option("cbr_usd"),
                'eur'           => $this->Option_model->get_option("cbr_eur"),
                'body_class'    => 'js--news js--news-edit',
                'search_or_link'    => array(
                    'type'          => 'search',
                    'target'        => 'news',
                    'title'         => 'Поиск по новостям'
                ),
            );
            $data_footer = array(
                'notifications' => $this->Notification_model->get_notifications( $this->session->user )
            );
            $data_content = array(
                'menu'          => array(
                    'selected'          => 'news',
                    'new_messages'      => $this->Message_model->count_unread_dialogs($this->session->user),
                    'new_partners'      => $this->Partner_model->get_inbox_partners_count($this->session->user),
                    'active_requests'   => $this->Request_model->count_active_requests($this->session->user),
                ),
                'news'              => $this->News_model->get_news( array( 'user_id' => 1 ) ),
                'project_news'      => true,
                'taxonomy'          => array(
                    'page'      => false,
                    'slug'      => 'user',
                    'name'      => 'Новости проекта'
                ),
            );

            // Если он авторизован, но при попытке получить данные о нем возвращается false - выкидываем
            $user = $this->User_model->get_user_by_id( intval( $this->session->user ) );
            if(!$user){
                $this->User_model->user_logout();
                redirect('/', 'refresh');
            }
            $data_content['user']       = $user;

            if( $user->company_id )
                if ( $user->id == $this->Company_model->get_company_director_id( $user->company_id ) ) {
                    $data_content['menu']['new_employers']  = $this->Company_model->count_company_candidats( $user->company_id );
                }

            if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                $this->load->view('mobile/user/head',       $data_head);
                $this->load->view('mobile/news/page',       array("page_header"  => $data_header, "page_content" => $data_content ) );
                $this->load->view('mobile/user/footer',     $data_footer);

            else:

                $this->load->view('desktop/user/head',      $data_head);
                $this->load->view('desktop/user/header',    $data_header);
                $this->load->view('desktop/news/page',      $data_content);
                $this->load->view('desktop/user/footer',    $data_footer);

            endif;
        } else {
            redirect('/', 'refresh', 302);
        }
    }

    public function technology() {

        if( $this->router->user_lang == 'ru' ){
            $this->lang->load('main', 'russian');
        } elseif ( $this->router->user_lang == 'en' ) {
            $this->lang->load('main', 'english');
        }

        if ( $this->User_model->is_auth_user() ) {
            $data_head['is_home_page']          = false;
            $data_head['meta_data']             = array(
                'title'                 => $this->Option_model->get_option( 'meta__project_news_title' ),
                'keywords'              => $this->Option_model->get_option( 'meta__project_news_keywords' ),
                'description'           => $this->Option_model->get_option( 'meta__project_news_description' ),
            );
            $data_header = array(
                'usd'           => $this->Option_model->get_option("cbr_usd"),
                'eur'           => $this->Option_model->get_option("cbr_eur"),
                'body_class'    => 'js--news',
                'search_or_link'   => array(
                    'type'      => 'link',
                    'url'       => '/news/',
                    'title'     => 'К списку новостей'
                ),
            );
            $data_footer = array(
                'notifications' => $this->Notification_model->get_notifications( $this->session->user )
            );
            $data_content = array(
                'menu'          => array(
                    'selected'          => 'news',
                    'new_messages'      => $this->Message_model->count_unread_dialogs($this->session->user),
                    'new_partners'      => $this->Partner_model->get_inbox_partners_count($this->session->user),
                    'active_requests'   => $this->Request_model->count_active_requests($this->session->user),
                ),
                'news'              => $this->News_model->get_news( array( 'user_id' => 1, 'taxonomy' => 'technology') ),
                'project_news'      => true,
                'taxonomy'          => array(
                    'page'      => true,
                    'slug'      => 'technology',
                    'name'      => 'Технологии'
                ),
            );


            // Если он авторизован, но при попытке получить данные о нем возвращается false - выкидываем
            $user = $this->User_model->get_user_by_id( intval( $this->session->user ) );
            if(!$user){
                $this->User_model->user_logout();
                redirect('/', 'refresh');
            }
            $data_content['user']       = $user;

            if( $user->company_id )
                if ( $user->id == $this->Company_model->get_company_director_id( $user->company_id ) ) {
                    $data_content['menu']['new_employers']  = $this->Company_model->count_company_candidats( $user->company_id );
                }



            if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                $this->load->view('mobile/user/head',       $data_head);
                $this->load->view('mobile/news/page',       array("page_header"  => $data_header, "page_content" => $data_content ) );
                $this->load->view('mobile/user/footer',     $data_footer);

            else:

                $this->load->view('desktop/user/head',      $data_head);
                $this->load->view('desktop/user/header',    $data_header);
                $this->load->view('desktop/news/page',      $data_content);
                $this->load->view('desktop/user/footer',    $data_footer);

            endif;
        } else {
            redirect('/', 'refresh', 302);
        }
    }

    public function money() {

        if( $this->router->user_lang == 'ru' ){
            $this->lang->load('main', 'russian');
        } elseif ( $this->router->user_lang == 'en' ) {
            $this->lang->load('main', 'english');
        }

        if ( $this->User_model->is_auth_user() ) {
            $data_head['is_home_page']          = false;
            $data_head['meta_data']             = array(
                'title'                 => $this->Option_model->get_option( 'meta__project_news_title' ),
                'keywords'              => $this->Option_model->get_option( 'meta__project_news_keywords' ),
                'description'           => $this->Option_model->get_option( 'meta__project_news_description' ),
            );
            $data_header = array(
                'usd'           => $this->Option_model->get_option("cbr_usd"),
                'eur'           => $this->Option_model->get_option("cbr_eur"),
                'body_class'    => 'js--news',
                'search_or_link'   => array(
                    'type'      => 'link',
                    'url'       => '/news/',
                    'title'     => 'К списку новостей'
                ),
            );
            $data_footer = array(
                'notifications' => $this->Notification_model->get_notifications( $this->session->user )
            );
            $data_content = array(
                'menu'          => array(
                    'selected'          => 'news',
                    'new_messages'      => $this->Message_model->count_unread_dialogs($this->session->user),
                    'new_partners'      => $this->Partner_model->get_inbox_partners_count($this->session->user),
                    'active_requests'   => $this->Request_model->count_active_requests($this->session->user),
                ),
                'news'              => $this->News_model->get_news( array( 'user_id' => 1, 'taxonomy' => 'money') ),
                'project_news'      => true,
                'taxonomy'          => array(
                    'page'      => true,
                    'slug'      => 'money',
                    'name'      => 'Деньги'
                ),
            );


            // Если он авторизован, но при попытке получить данные о нем возвращается false - выкидываем
            $user = $this->User_model->get_user_by_id( intval( $this->session->user ) );
            if(!$user){
                $this->User_model->user_logout();
                redirect('/', 'refresh');
            }
            $data_content['user']       = $user;

            if( $user->company_id )
                if ( $user->id == $this->Company_model->get_company_director_id( $user->company_id ) ) {
                    $data_content['menu']['new_employers']  = $this->Company_model->count_company_candidats( $user->company_id );
                }



            if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                $this->load->view('mobile/user/head',       $data_head);
                $this->load->view('mobile/news/page',       array("page_header"  => $data_header, "page_content" => $data_content ) );
                $this->load->view('mobile/user/footer',     $data_footer);

            else:

                $this->load->view('desktop/user/head',      $data_head);
                $this->load->view('desktop/user/header',    $data_header);
                $this->load->view('desktop/news/page',      $data_content);
                $this->load->view('desktop/user/footer',    $data_footer);

            endif;
        } else {
            redirect('/', 'refresh', 302);
        }
    }

    public function interview() {

        if( $this->router->user_lang == 'ru' ){
            $this->lang->load('main', 'russian');
        } elseif ( $this->router->user_lang == 'en' ) {
            $this->lang->load('main', 'english');
        }

        if ( $this->User_model->is_auth_user() ) {
            $data_head['is_home_page']          = false;
            $data_head['meta_data']             = array(
                'title'                 => $this->Option_model->get_option( 'meta__project_news_title' ),
                'keywords'              => $this->Option_model->get_option( 'meta__project_news_keywords' ),
                'description'           => $this->Option_model->get_option( 'meta__project_news_description' ),
            );
            $data_header = array(
                'usd'           => $this->Option_model->get_option("cbr_usd"),
                'eur'           => $this->Option_model->get_option("cbr_eur"),
                'body_class'    => 'js--news',
                'search_or_link'   => array(
                    'type'      => 'link',
                    'url'       => '/news/',
                    'title'     => 'К списку новостей'
                ),
            );
            $data_footer = array(
                'notifications' => $this->Notification_model->get_notifications( $this->session->user )
            );
            $data_content = array(
                'menu'          => array(
                    'selected'          => 'news',
                    'new_messages'      => $this->Message_model->count_unread_dialogs($this->session->user),
                    'new_partners'      => $this->Partner_model->get_inbox_partners_count($this->session->user),
                    'active_requests'   => $this->Request_model->count_active_requests($this->session->user),
                ),
                'news'              => $this->News_model->get_news( array( 'user_id' => 1, 'taxonomy' => 'interview') ),
                'project_news'      => true,
                'taxonomy'          => array(
                    'page'      => true,
                    'slug'      => 'interview',
                    'name'      => 'Интервью'
                ),
            );


            // Если он авторизован, но при попытке получить данные о нем возвращается false - выкидываем
            $user = $this->User_model->get_user_by_id( intval( $this->session->user ) );
            if(!$user){
                $this->User_model->user_logout();
                redirect('/', 'refresh');
            }
            $data_content['user']       = $user;

            if( $user->company_id )
                if ( $user->id == $this->Company_model->get_company_director_id( $user->company_id ) ) {
                    $data_content['menu']['new_employers']  = $this->Company_model->count_company_candidats( $user->company_id );
                }



            if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                $this->load->view('mobile/user/head',       $data_head);
                $this->load->view('mobile/news/page',       array("page_header"  => $data_header, "page_content" => $data_content ) );
                $this->load->view('mobile/user/footer',     $data_footer);

            else:

                $this->load->view('desktop/user/head',      $data_head);
                $this->load->view('desktop/user/header',    $data_header);
                $this->load->view('desktop/news/page',      $data_content);
                $this->load->view('desktop/user/footer',    $data_footer);

            endif;
        } else {
            redirect('/', 'refresh', 302);
        }
    }

    public function review() {

        if( $this->router->user_lang == 'ru' ){
            $this->lang->load('main', 'russian');
        } elseif ( $this->router->user_lang == 'en' ) {
            $this->lang->load('main', 'english');
        }

        if ( $this->User_model->is_auth_user() ) {
            $data_head['is_home_page']          = false;
            $data_head['meta_data']             = array(
                'title'                 => $this->Option_model->get_option( 'meta__project_news_title' ),
                'keywords'              => $this->Option_model->get_option( 'meta__project_news_keywords' ),
                'description'           => $this->Option_model->get_option( 'meta__project_news_description' ),
            );
            $data_header = array(
                'usd'       => $this->Option_model->get_option("cbr_usd"),
                'eur'       => $this->Option_model->get_option("cbr_eur"),
                'body_class'        => 'js--news',
                'search_or_link'   => array(
                    'type'      => 'link',
                    'url'       => '/news/',
                    'title'     => 'К списку новостей'
                ),
            );
            $data_footer = array(
                'notifications' => $this->Notification_model->get_notifications( $this->session->user )
            );
            $data_content = array(
                'menu'          => array(
                    'selected'          => 'news',
                    'new_messages'      => $this->Message_model->count_unread_dialogs($this->session->user),
                    'new_partners'      => $this->Partner_model->get_inbox_partners_count($this->session->user),
                    'active_requests'   => $this->Request_model->count_active_requests($this->session->user),
                ),
                'news'              => $this->News_model->get_news( array( 'user_id' => 1, 'taxonomy' => 'review') ),
                'project_news'      => true,
                'taxonomy'          => array(
                    'page'      => true,
                    'slug'      => 'humor',
                    'name'      => 'Обзоры'
                ),
            );


            // Если он авторизован, но при попытке получить данные о нем возвращается false - выкидываем
            $user = $this->User_model->get_user_by_id( intval( $this->session->user ) );
            if(!$user){
                $this->User_model->user_logout();
                redirect('/', 'refresh');
            }
            $data_content['user']       = $user;

            if( $user->company_id )
                if ( $user->id == $this->Company_model->get_company_director_id( $user->company_id ) ) {
                    $data_content['menu']['new_employers']  = $this->Company_model->count_company_candidats( $user->company_id );
                }



            if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                $this->load->view('mobile/user/head',       $data_head);
                $this->load->view('mobile/news/page',       array("page_header"  => $data_header, "page_content" => $data_content ) );
                $this->load->view('mobile/user/footer',     $data_footer);

            else:

                $this->load->view('desktop/user/head',      $data_head);
                $this->load->view('desktop/user/header',    $data_header);
                $this->load->view('desktop/news/page',      $data_content);
                $this->load->view('desktop/user/footer',    $data_footer);

            endif;
        } else {
            redirect('/', 'refresh', 302);
        }
    }

    public function humor() {

        if( $this->router->user_lang == 'ru' ){
            $this->lang->load('main', 'russian');
        } elseif ( $this->router->user_lang == 'en' ) {
            $this->lang->load('main', 'english');
        }

        if ( $this->User_model->is_auth_user() ) {
            $data_head['is_home_page']          = false;
            $data_head['meta_data']             = array(
                'title'                 => $this->Option_model->get_option( 'meta__project_news_title' ),
                'keywords'              => $this->Option_model->get_option( 'meta__project_news_keywords' ),
                'description'           => $this->Option_model->get_option( 'meta__project_news_description' ),
            );
            $data_header = array(
                'usd'           => $this->Option_model->get_option("cbr_usd"),
                'eur'           => $this->Option_model->get_option("cbr_eur"),
                'body_class'    => 'js--news',
                'search_or_link'   => array(
                    'type'      => 'link',
                    'url'       => '/news/',
                    'title'     => 'К списку новостей'
                ),
            );
            $data_footer = array(
                'notifications' => $this->Notification_model->get_notifications( $this->session->user )
            );
            $data_content = array(
                'menu'          => array(
                    'selected'          => 'news',
                    'new_messages'      => $this->Message_model->count_unread_dialogs($this->session->user),
                    'new_partners'      => $this->Partner_model->get_inbox_partners_count($this->session->user),
                    'active_requests'   => $this->Request_model->count_active_requests($this->session->user),
                ),
                'news'              => $this->News_model->get_news( array( 'user_id' => 1, 'taxonomy' => 'humor') ),
                'project_news'      => true,
                'taxonomy'          => array(
                    'page'      => true,
                    'slug'      => 'humor',
                    'name'      => 'Юмор'
                ),
            );


            // Если он авторизован, но при попытке получить данные о нем возвращается false - выкидываем
            $user = $this->User_model->get_user_by_id( intval( $this->session->user ) );
            if(!$user){
                $this->User_model->user_logout();
                redirect('/', 'refresh');
            }
            $data_content['user']       = $user;

            if( $user->company_id )
                if ( $user->id == $this->Company_model->get_company_director_id( $user->company_id ) ) {
                    $data_content['menu']['new_employers']  = $this->Company_model->count_company_candidats( $user->company_id );
                }



            if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                $this->load->view('mobile/user/head',       $data_head);
                $this->load->view('mobile/news/page',       array("page_header"  => $data_header, "page_content" => $data_content ) );
                $this->load->view('mobile/user/footer',     $data_footer);

            else:

                $this->load->view('desktop/user/head',      $data_head);
                $this->load->view('desktop/user/header',    $data_header);
                $this->load->view('desktop/news/page',      $data_content);
                $this->load->view('desktop/user/footer',    $data_footer);

            endif;
        } else {
            redirect('/', 'refresh', 302);
        }
    }

    public function find() {
        if( $this->router->user_lang == 'ru' ){
            $this->lang->load('main', 'russian');
        } elseif ( $this->router->user_lang == 'en' ) {
            $this->lang->load('main', 'english');
        }

        if ( $this->User_model->is_auth_user() ) {

            $data_head['is_home_page']  = false;
            $data_head['meta_data']     = [
                'title'         => $this->Option_model->get_option( 'meta__project_news_title' ),
                'keywords'      => $this->Option_model->get_option( 'meta__project_news_keywords' ),
                'description'   => $this->Option_model->get_option( 'meta__project_news_description' ),
            ];

            $data_header = [
                'usd'           => $this->Option_model->get_option("cbr_usd"),
                'eur'           => $this->Option_model->get_option("cbr_eur"),
                'body_class'    => 'js--news js--news-edit js--news-search',
                'search_or_link'    => [
                    'type'          => 'link',
                    'url'           => '/news/',
                    'title'         => 'К списку новостей'
                ],
            ];

            $data_footer = [
                'notifications' => $this->Notification_model->get_notifications( $this->session->user )
            ];

            $data_content = [
                'menu'          => [
                    'selected'          => 'news',
                    'new_messages'      => $this->Message_model->count_unread_dialogs($this->session->user),
                    'new_partners'      => $this->Partner_model->get_inbox_partners_count($this->session->user),
                    'active_requests'   => $this->Request_model->count_active_requests($this->session->user),
                ],
                'news'          => $this->News_model->get_news( array( 'user_id' => 1) ),
                'project_news'  => true,
            ];

            // Если он авторизован, но при попытке получить данные о нем возвращается false - выкидываем
            $user = $this->User_model->get_user_by_id( intval( $this->session->user ) );
            if(!$user){
                $this->User_model->user_logout();
                redirect('/', 'refresh');
            }

            $data_content['user']       = $user;
            $data_content['keyword']    = $this->input->get('query');

            if( $data_content['keyword'] ):
                $data_content['news']   = $this->News_model->get_news( array('keyword' => $data_content['keyword'] )  );
            else:
                $data_content['news']   = false;
            endif;


            if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                $this->load->view('mobile/user/head',       $data_head);
                $this->load->view('mobile/news/page__find', array("page_header"  => $data_header, "page_content" => $data_content ) );
                $this->load->view('mobile/user/footer',     $data_footer);

            else:

                $this->load->view('desktop/user/head',      $data_head);
                $this->load->view('desktop/user/header',    $data_header);
                $this->load->view('desktop/news/page__find',$data_content);
                $this->load->view('desktop/user/footer',    $data_footer);

            endif;
        } else {
            redirect('/', 'refresh', 302);
        }

    }

}
