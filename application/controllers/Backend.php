<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 10.05.16
 * Time: 16:13
 *
 *  Функции:
 *  index               - главная страница бэкэнда
 *  logout              - выход из бекэнда
 *  page                - страницы
 *      add_page        - добавить страницы
 *      home_page       - настройки главной страницы сайта
 *
 *  users               - пользователи сайта
 */

class Backend extends CI_Controller
{
    private $auth_user = true;

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Backend_model');
        $this->load->model('Option_model');
        $this->load->model('Page_model');

        $this->load->helper('text');
        $this->load->helper('security');

        $this->load->library('upload');

        $is_auth_manager = $this->Backend_model->is_auth_manager();

        if ( !$is_auth_manager && $this->input->post('action') == 'login' ){
            $user_name      = $this->input->post('user_name');
            $user_pass      = $this->input->post('password');
            $login_result   = $this->Backend_model->login($user_name, $user_pass);
            if($login_result){
                redirect('/backend/page/', 'refresh', 302);
            } else {
                redirect('/backend/', 'refresh', 302);
            }

        } elseif (!$is_auth_manager){
            $this->load->view('backend/main/unauth_header');
            $this->load->view('backend/main/unauth');
            $this->load->view('backend/main/login');
            $this->load->view('backend/footer');
            $this->auth_user = false;
        }

    }

    public function index() {
        if($this->auth_user) {
            redirect('/backend/page/', 'refresh', 302);
        }
    }

    public function logout(){
        $this->Backend_model->logout();
        redirect('/backend/', 'refresh', 302);
    }

    public function page( $pageID = 0 ){

        // Авторизован ли пользователь?
        if($this->auth_user) {
            // Был ли отправлен запрос на удаление страницы из списка или с карточки?
            if($this->input->post('action') == 'page_delete'){
                $post_pageID     = $this->input->post('pageID');
                $this->Page_model->delete_page($post_pageID);
            }

            // Был ли запрос на активацию/деактивацию?
            if($this->input->post('action') == 'page_switch_active') {
                if($this->input->post('sub_action') == 'deactivate') {
                    $post_pageID     = $this->input->post('pageID');
                    $this->Page_model->deactivate_page($post_pageID);
                } elseif($this->input->post('sub_action') == 'activate') {
                    $post_pageID     = $this->input->post('pageID');
                    $this->Page_model->activate_page($post_pageID);
                }

            }
            // Был ли отправлен запрос на редактирование страницы?
            if($this->input->post('action') == 'page_update'){
                $post_pageID            = $this->input->post('pageID');
                $slug                   = convert_accented_characters( $this->input->post('slug') );
                $public                 = $this->input->post('public');
                $date_add               = $this->input->post('date_add');
                $title_ru               = $this->input->post('title_ru');
                $title_en               = $this->input->post('title_en');
                $content_ru             = $this->input->post('content_ru');
                $content_en             = $this->input->post('content_en');
                $meta_title_ru          = $this->input->post('meta_title_ru');
                $meta_title_en          = $this->input->post('meta_title_en');
                $meta_keywords_ru       = $this->input->post('meta_keywords_ru');
                $meta_keywords_en       = $this->input->post('meta_keywords_en');
                $meta_description_ru    = $this->input->post('meta_description_ru');
                $meta_description_en    = $this->input->post('meta_description_en');

                $this->Page_model->update_page(
                    $post_pageID,
                    $slug,
                    $public,
                    $date_add,
                    $title_ru,
                    $title_en,
                    $content_ru,
                    $content_en,
                    $meta_title_ru,
                    $meta_title_en,
                    $meta_keywords_ru,
                    $meta_keywords_en,
                    $meta_description_ru,
                    $meta_description_en
                );
            }


            if( $pageID == 0 || $pageID == "page" ) {

                $this->load->library('pagination');

                if( $this->uri->segment(4) )
                    $page   = $this->uri->segment(4);
                else
                    $page   = 1;

                $config['base_url'] 		    = base_url().'/backend/page/page/';
                $config['total_rows'] 		    = $this->Page_model->get_pages( array( 'count' => true ) );
                $config['per_page'] 		    = 10;
                $config['use_page_numbers']     = TRUE;
                $config['uri_segment'] 		    = 4;  // указываем, где в URL номер страниц

                $config['full_tag_open']        = '<div><ul class="pagination pagination-small pagination-centered">';
                $config['full_tag_close']       = '</ul></div>';
                $config['prev_link']            = '&lt; Назад';
                $config['prev_tag_open']        = '<li>';
                $config['prev_tag_close']       = '</li>';
                $config['next_link']            = 'Вперед &gt;';
                $config['next_tag_open']        = '<li>';
                $config['next_tag_close']       = '</li>';
                $config['cur_tag_open']         = '<li class="active"><a href="#">';
                $config['cur_tag_close']        = '</a></li>';
                $config['num_tag_open']         = '<li>';
                $config['num_tag_close']        = '</li>';
                $config['first_link']           = FALSE;
                $config['last_link']            = FALSE;


                $this->pagination->initialize($config);

                $data_page_list     = array (
                    'pages'             => $this->Page_model->get_pages( array( 'limit' => $config['per_page'], 'offset' => $config['per_page']*($page-1) )),
                    'pagination'        => $this->pagination->create_links(),
                );

                $this->load->view('backend/header');
                $this->load->view('backend/pages/list', $data_page_list);
                $this->load->view('backend/footer');
            }
            // Редактирование новости
            else {

                $data_page_single['page'] = $this->Page_model->get_edit_page_by_id( $pageID );

                $this->load->view('backend/header');
                $this->load->view('backend/pages/single', $data_page_single);
                $this->load->view('backend/footer');
            }
        }

    }

    public function add_page() {
        if ($this->auth_user) {
            if ($this->input->post('action') == 'page_add') {
                $slug = convert_accented_characters( $this->input->post('slug') );
                if ($this->input->post('public'))
                    $public = $this->input->post('public');
                else
                    $public = 0;
                $date_add = $this->input->post('date_add');
                $title_ru = $this->input->post('title_ru');
                $title_en = $this->input->post('title_en');
                $content_ru = $this->input->post('content_ru');
                $content_en = $this->input->post('content_en');
                $meta_title_ru = $this->input->post('meta_title_ru');
                $meta_title_en = $this->input->post('meta_title_en');
                $meta_keywords_ru = $this->input->post('meta_keywords_ru');
                $meta_keywords_en = $this->input->post('meta_keywords_en');
                $meta_description_ru = $this->input->post('meta_description_ru');
                $meta_description_en = $this->input->post('meta_description_en');

                $pageID = $this->Page_model->add_page(
                    $slug,
                    $public,
                    $date_add,
                    $title_ru,
                    $title_en,
                    $content_ru,
                    $content_en,
                    $meta_title_ru,
                    $meta_title_en,
                    $meta_keywords_ru,
                    $meta_keywords_en,
                    $meta_description_ru,
                    $meta_description_en
                );

                $data_page_single['page'] = $this->Page_model->get_edit_page_by_id($pageID);

                redirect('/backend/page/', 'refresh', 302);
            }
            $this->load->view('backend/header');
            $this->load->view('backend/pages/add');
            $this->load->view('backend/footer');
        }
    }

    public function home_page() {
        if ($this->auth_user) {
            if ($this->input->post('action') == 'update_options') {

                $meta_title_ru = $this->input->post('home_meta_title_ru');
                $meta_title_en = $this->input->post('home_meta_title_en');
                $meta_keywords_ru = $this->input->post('home_meta_keywords_ru');
                $meta_keywords_en = $this->input->post('home_meta_keywords_en');
                $meta_description_ru = $this->input->post('home_meta_description_ru');
                $meta_description_en = $this->input->post('home_meta_description_en');

                $video_source_ru = $this->input->post('video_source_ru');
                $video_source_en = $this->input->post('video_source_en');
                $video_id_ru = $this->input->post('video_id_ru');
                $video_id_en = $this->input->post('video_id_en');

                $this->Option_model->update_option('home_meta_title_ru', $meta_title_ru);
                $this->Option_model->update_option('home_meta_title_en', $meta_title_en);
                $this->Option_model->update_option('home_meta_keywords_ru', $meta_keywords_ru);
                $this->Option_model->update_option('home_meta_keywords_en', $meta_keywords_en);
                $this->Option_model->update_option('home_meta_description_ru', $meta_description_ru);
                $this->Option_model->update_option('home_meta_description_en', $meta_description_en);

                $this->Option_model->update_option('video_source_ru', $video_source_ru);
                $this->Option_model->update_option('video_source_en', $video_source_en);
                $this->Option_model->update_option('video_id_ru', $video_id_ru);
                $this->Option_model->update_option('video_id_en', $video_id_en);

                // если уже есть загруженные слайды
                if ( $this->input->post('json_slides_ru') ){
                    $images = json_decode( $this->input->post('json_slides_ru') );
                } else {
                    $images = array();
                }

                $config_upload['upload_path'] = './uploads/slides/';
                $config_upload['allowed_types'] = 'gif|jpg|png';
                $config_upload['max_size'] = '4000';
                $config_upload['max_width'] = '3000';
                $config_upload['max_height'] = '3000';

                $this->upload->initialize($config_upload);

                if ($this->upload->do_multi_upload('slides_ru')) {

                    $uploaded_images = $this->upload->get_multi_upload_data();

                    $this->load->library('image_moo');
                    foreach ($uploaded_images as $uploaded_image) {

                        $this->image_moo->load($uploaded_image['full_path']);
                        $this->image_moo->resize_crop(180, 120);
                        $this->image_moo->save($uploaded_image['file_path'] . '/thumb/' . '180x120_'.$uploaded_image['file_name'], TRUE);

                        $images[] = array(
                            'file_name' => $uploaded_image['file_name'],
                            'full_path' => $uploaded_image['full_path'],
                            'thumbnail' => '/uploads/slides/thumb/' . '180x120_'.$uploaded_image['file_name'],
                        );

                        $this->image_moo->clear();
                    }
                }

                $this->Option_model->update_option('slides_ru', json_encode($images));


                // если уже есть загруженные слайды
                if ( $this->input->post('json_slides_en') ){
                    $images = json_decode( $this->input->post('json_slides_en') );
                } else {
                    $images = array();
                }

                if ($this->upload->do_multi_upload('slides_en')) {

                    $uploaded_images = $this->upload->get_multi_upload_data();

                    $this->load->library('image_moo');
                    foreach ($uploaded_images as $uploaded_image) {

                        $this->image_moo->load($uploaded_image['full_path']);
                        $this->image_moo->resize_crop(180, 120);
                        $this->image_moo->save($uploaded_image['file_path'] . '/thumb/' . '180x120_'.$uploaded_image['file_name'], TRUE);

                        $images[] = array(
                            'file_name' => $uploaded_image['file_name'],
                            'full_path' => $uploaded_image['full_path'],
                            'thumbnail' => '/uploads/slides/thumb/' . '180x120_'.$uploaded_image['file_name'],
                        );

                        $this->image_moo->clear();
                    }

                }
                $this->Option_model->update_option('slides_en', json_encode($images));
            }

            $meta_title_ru = $this->Option_model->get_option('home_meta_title_ru');
            $meta_title_en = $this->Option_model->get_option('home_meta_title_en');
            $meta_keywords_ru = $this->Option_model->get_option('home_meta_keywords_ru');
            $meta_keywords_en = $this->Option_model->get_option('home_meta_keywords_en');
            $meta_description_ru = $this->Option_model->get_option('home_meta_description_ru');
            $meta_description_en = $this->Option_model->get_option('home_meta_description_en');

            $video_source_ru = $this->Option_model->get_option('video_source_ru');
            $video_source_en = $this->Option_model->get_option('video_source_en');
            $video_id_ru = $this->Option_model->get_option('video_id_ru');
            $video_id_en = $this->Option_model->get_option('video_id_en');

            $slides_ru          = json_decode($this->Option_model->get_option('slides_ru'));
            $json_slides_ru     = $this->Option_model->get_option('slides_ru');
            $slides_en          = json_decode($this->Option_model->get_option('slides_en'));
            $json_slides_en     = $this->Option_model->get_option('slides_en');

            $data_home_page = array(
                'meta_title_ru'         => $meta_title_ru,
                'meta_title_en'         => $meta_title_en,
                'meta_keywords_ru'      => $meta_keywords_ru,
                'meta_keywords_en'      => $meta_keywords_en,
                'meta_description_ru'   => $meta_description_ru,
                'meta_description_en'   => $meta_description_en,
                'video_source_ru'       => $video_source_ru,
                'video_source_en'       => $video_source_en,
                'video_id_ru'           => $video_id_ru,
                'video_id_en'           => $video_id_en,
                'slides_ru'             => $slides_ru,
                'json_slides_ru'        => $json_slides_ru,
                'slides_en'             => $slides_en,
                'json_slides_en'        => $json_slides_en

            );

            $this->load->view('backend/header');
            $this->load->view('backend/home', $data_home_page);
            $this->load->view('backend/footer');
        }
    }

    public function users( $user_id = false ){
        if ($this->auth_user) {


            // Был ли запрос на активацию/деактивацию?
            if($this->input->post('action') == 'user_switch_active') {
                if($this->input->post('sub_action') == 'deactivate') {

                    $userID     = $this->input->post('userID');
                    $this->User_model->update_user_info($userID, array("removed" => 1));

                } elseif($this->input->post('sub_action') == 'activate') {

                    $userID     = $this->input->post('userID');
                    $this->User_model->update_user_info($userID, array("removed" => 0));

                }

            }



            if( $user_id === false || $user_id == "page" ) {

                $keywords   = "";
                if( $this->input->post("keywords") != '' ) {
                    $keywords   = $this->input->post("keywords");
                    $keywords   = trim(preg_replace('/\t+/', '', $keywords));
                    $this->session->backend__search_users   = $keywords;
                }
                elseif( array_key_exists("keywords", $_POST) ) {
                    $this->session->unset_userdata('backend__search_users');
                }
                elseif( $this->session->backend__search_users ) {
                    $keywords   = $this->session->backend__search_users;
                }

                if( $this->input->post("clear") == "clear_keywords" ) {
                    $keywords = '';
                    $this->session->unset_userdata('backend__search_users');
                }


                $this->load->library('pagination');

                if( $this->uri->segment(4) )
                    $page   = $this->uri->segment(4);
                else
                    $page   = 1;

                $config['base_url'] 		    = base_url().'/backend/users/page/';
                $config['total_rows'] 		    = $this->User_model->get_users( array('keywords' => $keywords, 'editors_mod' => true, 'count' => true ) );
                $config['per_page'] 		    = 10;
                $config['use_page_numbers']     = TRUE;
                $config['uri_segment'] 		    = 4;  // указываем, где в URL номер страниц

                $config['full_tag_open']        = '<div><ul class="pagination pagination-small pagination-centered">';
                $config['full_tag_close']       = '</ul></div>';
                $config['prev_link']            = '&lt; Назад';
                $config['prev_tag_open']        = '<li>';
                $config['prev_tag_close']       = '</li>';
                $config['next_link']            = 'Вперед &gt;';
                $config['next_tag_open']        = '<li>';
                $config['next_tag_close']       = '</li>';
                $config['cur_tag_open']         = '<li class="active"><a href="#">';
                $config['cur_tag_close']        = '</a></li>';
                $config['num_tag_open']         = '<li>';
                $config['num_tag_close']        = '</li>';
                $config['first_link']           = FALSE;
                $config['last_link']            = FALSE;


                $this->pagination->initialize($config);

                $data_users = array(
                    'users'         => $this->User_model->get_users( array('keywords' => $keywords, 'editors_mod' => true, 'limit' => $config['per_page'], 'offset' => $config['per_page']*($page-1) ) ),
                    'pagination'    => $this->pagination->create_links(),
                    'online'        => $this->User_model->online_users(),
                );

                $this->load->view('backend/header');
                $this->load->view('backend/users/list', $data_users);
                $this->load->view('backend/footer');

            } else {

                if( $this->input->post('action') == "user_update") {

                    $update_data =  array(
                        "name"          => $this->input->post('name'),
                        "last_name"     => $this->input->post('last_name'),
                        "second_name"   => $this->input->post('second_name'),
                        "status"        => $this->input->post('status'),
                        "email"         => $this->input->post('email'),
                        "phone"         => $this->input->post('phone'),
                        "tarif"         => $this->input->post('tarif'),
                        "tarif_date_end"=> $this->input->post('tarif_date_end'),
                        "balance"       => $this->input->post('balance'),
                        "brands"        => $this->input->post('brands'),
                    );


                    if($this->input->post('direction_sell') == 'sell' && $this->input->post('direction_buy') == 'buy'){
                        $update_data['direction'] = 'all';
                    } elseif( $this->input->post('direction_buy') == 'buy' ) {
                        $update_data['direction'] = 'buy';
                    } elseif( $this->input->post('direction_sell') == 'sell' ) {
                        $update_data['direction'] = 'sell';
                    } else {
                        $update_data['direction'] = 'none';
                    }

                    if( $this->input->post('city') )
                        $update_data['city'] = $this->input->post('city');


                    if( $this->input->post('removed') )
                        $update_data['removed'] = '1';
                    else
                        $update_data['removed'] = '0';

                    $this->User_model->update_user_info( $user_id, $update_data );
                }

                $data_user = array(
                    'brands'                => $this->Option_model->get_directory('brand', true),

                    'user'                  => $this->User_model->get_user_by_id( $user_id ),
                    'user_partners'         => $this->Partner_model->get_partners( $user_id ),
                    'user_partners_inbox'   => $this->Partner_model->get_inbox_partners( $user_id ),
                    'user_partners_outbox'  => $this->Partner_model->get_outbox_partners( $user_id ),
                    'user_news'             => $this->News_model->get_news( array('user_id' => $user_id, 'type' => 'solo', 'removed' => 'all') ),
                    'user_offers'           => $this->Offers_model->get_offers( array('user_id' => $user_id, 'removed' => 'all') ),
                    'user_requests'         => $this->Request_model->get_outbox_requests( $user_id ),
                    'user_brands'           => $this->User_model->get_user_brands( $user_id ),

                    'count_news'            => $this->News_model->count_user_news( $user_id ),
                    'count_news_comments'   => $this->News_model->user_statistic__all_comments( $user_id ),
                    'count_news_likes'      => $this->News_model->user_statistic__all_likes( $user_id ),

                    'count_offers'          => $this->Offers_model->count_user_offers( $user_id ),
                    'count_offers_views'    => $this->Offers_model->count_user_offers_views( $user_id ),
                    'count_offers_contacts' => $this->Offers_model->count_user_offers_contacts( $user_id ),

                    'count_partners_all'    => $this->Partner_model->count_user_partners( $user_id ),
                    'count_partners_inbox'  => $this->Partner_model->get_inbox_partners_count( $user_id ),
                    'count_partners_outbox' => $this->Partner_model->get_outbox_partners_count( $user_id ),

                    'count_requests_inbox'  => $this->Request_model->count_inbox_requests( $user_id ),
                    'count_requests_outbox' => $this->Request_model->count_outbox_requests( $user_id ),
                    'count_requests_all'    => $this->Request_model->count_requests( $user_id ),
                    'count_requests'        => array(
                        'inbox'             => array(
                            'formed'        => $this->Request_model->count_inbox_requests_status( $user_id, 'formed' ),
                            'process'       => $this->Request_model->count_inbox_requests_status( $user_id, 'process' ),
                            'done'          => $this->Request_model->count_inbox_requests_status( $user_id, 'done' ),
                            'canceled'      => $this->Request_model->count_inbox_requests_status( $user_id, 'canceled' ),
                        ),
                        'outbox'             => array(
                            'formed'        => $this->Request_model->count_outbox_requests_status( $user_id, 'formed' ),
                            'process'       => $this->Request_model->count_outbox_requests_status( $user_id, 'process' ),
                            'done'          => $this->Request_model->count_outbox_requests_status( $user_id, 'done' ),
                            'canceled'      => $this->Request_model->count_outbox_requests_status( $user_id, 'canceled' ),
                        ),
                        'archived'          => $this->Request_model->count_archived_requests( $user_id )
                    ),

                );

                $this->load->view('backend/header');
                $this->load->view('backend/users/single', $data_user);
                $this->load->view('backend/footer');

            }


        }
    }

    public function companies( $company_id = false ){
        if ($this->auth_user) {


            // Был ли запрос на активацию/деактивацию?
            if($this->input->post('action') == 'company_switch_active') {
                if($this->input->post('sub_action') == 'deactivate') {

                    $companyID     = $this->input->post('companyID');
                    $this->Company_model->update_company($companyID, array("removed" => 1));

                } elseif($this->input->post('sub_action') == 'activate') {

                    $companyID     = $this->input->post('companyID');
                    $this->Company_model->update_company($companyID, array("removed" => 0));

                }

            }


            if( $company_id === false || $company_id == "page" ) {

                if( $this->input->post('action') && ( $this->input->post('action') == 'approve_company') ) {
                    $update_data = array(
                        'approved' => 'approved'
                    );
                    $this->Company_model->update_company( $this->input->post('company_id'),  $update_data );
                }


                $keywords   = "";
                if( $this->input->post("keywords") != '' ) {
                    $keywords   = $this->input->post("keywords");
                    $this->session->backend__search_companies   = $keywords;
                }
                elseif( array_key_exists("keywords", $_POST) ) {
                    $this->session->unset_userdata('backend__search_companies');
                }
                elseif( $this->session->backend__search_companies ) {
                    $keywords   = $this->session->backend__search_companies;
                }

                if( $this->input->post("clear") == "clear_keywords" ) {
                    $keywords = '';
                    $this->session->unset_userdata('backend__search_companies');
                }


                $this->load->library('pagination');

                if( $this->uri->segment(4) )
                    $page   = $this->uri->segment(4);
                else
                    $page   = 1;
                /*echo $_SESSION['backend__search_companies'];
                echo "<br>";
                echo $keywords;
                die();*/
                $config['base_url'] 		    = base_url().'/backend/companies/page/';
                $config['total_rows'] 		    = $this->Company_model->get_companies( array('keyword' => $keywords, 'count' => true ) );
                $config['per_page'] 		    = 10;
                $config['use_page_numbers']     = TRUE;
                $config['uri_segment'] 		    = 4;  // указываем, где в URL номер страниц

                $config['full_tag_open']        = '<div><ul class="pagination pagination-small pagination-centered">';
                $config['full_tag_close']       = '</ul></div>';
                $config['prev_link']            = '&lt; Назад';
                $config['prev_tag_open']        = '<li>';
                $config['prev_tag_close']       = '</li>';
                $config['next_link']            = 'Вперед &gt;';
                $config['next_tag_open']        = '<li>';
                $config['next_tag_close']       = '</li>';
                $config['cur_tag_open']         = '<li class="active"><a href="#">';
                $config['cur_tag_close']        = '</a></li>';
                $config['num_tag_open']         = '<li>';
                $config['num_tag_close']        = '</li>';
                $config['first_link']           = FALSE;
                $config['last_link']            = FALSE;


                $this->pagination->initialize($config);



                $data_companies = array(
                    'companies'     => $this->Company_model->get_companies( array('keyword' => $keywords, 'limit' => $config['per_page'], 'offset' => $config['per_page']*($page-1) ) ),
                    'pagination'    => $this->pagination->create_links(),
                );

                $this->load->view('backend/header');
                $this->load->view('backend/company/list', $data_companies);
                $this->load->view('backend/footer');

            } else {

                $data_company = array(
                    'company'       => $this->Company_model->get_company_by_id( $company_id ),
                    'employers'     => $this->Company_model->get_company_employers( $company_id ),
                );

                $this->load->view('backend/header');
                $this->load->view('backend/company/single', $data_company);
                $this->load->view('backend/footer');

            }
        }
    }

    public function lists() {
        if ($this->auth_user) {

            if($this->input->post()){

                if( $this->input->post('active') )
                    $post_active = $this->input->post('active');
                else
                    $post_active = array();

                if($this->input->post('profession')) {
                    foreach($this->input->post('profession') as $key => $post_prof) {
                        $data = array(
                            'value'     => $post_prof
                        );
                        if(array_key_exists($key, $post_active))
                            $data['active']     = 1;
                        else
                            $data['active']     = 0;
                        $this->Option_model->update_directory( $key, $data );
                    }
                }

                if($this->input->post('new_profession')) {
                    foreach ($this->input->post('new_profession') as $post_new_prof) {
                        if($post_new_prof != ''){
                            $data = array(
                                'value'     => $post_new_prof,
                                'type'      => 'profession',
                                'active'    => 1,
                            );
                            $this->Option_model->add_to_directory( $data );
                        }
                    }
                }

                if($this->input->post('role')) {
                    foreach($this->input->post('role') as $key => $post_role) {

                        $data = array(
                            'value'     => $post_role
                        );
                        if(array_key_exists($key, $post_active))
                            $data['active']     = 1;
                        else
                            $data['active']     = 0;
                        $this->Option_model->update_directory( $key, $data );
                    }
                }

                if($this->input->post('new_role')) {
                    foreach ($this->input->post('new_role') as $post_new_role) {
                        if($post_new_role != ''){
                            $data = array(
                                'value'     => $post_new_role,
                                'type'      => 'role',
                                'active'    => 1,
                            );
                            $this->Option_model->add_to_directory( $data );
                        }
                    }
                }

                if($this->input->post('brand')) {
                    foreach($this->input->post('brand') as $key => $post_brand) {
                        $data = array(
                            'value'     => $post_brand
                        );
                        if(array_key_exists($key, $post_active))
                            $data['active']     = 1;
                        else
                            $data['active']     = 0;
                        $this->Option_model->update_directory( $key, $data );
                    }
                }

                if($this->input->post('new_brand')) {
                    foreach ($this->input->post('new_brand') as $post_new_brand) {
                        if($post_new_brand != '') {
                            $data = array(
                                'value'     => $post_new_brand,
                                'type'      => 'brand',
                                'active'    => 1,
                            );
                            $this->Option_model->add_to_directory($data);
                        }
                    }
                }

                if($this->input->post('offer-category')) {
                    foreach($this->input->post('offer-category') as $key => $post_offer_category) {
                        $data = array(
                            'value'     => $post_offer_category
                        );
                        if(array_key_exists($key, $post_active))
                            $data['active']     = 1;
                        else
                            $data['active']     = 0;
                        $this->Option_model->update_directory( $key, $data );
                    }
                }

                if($this->input->post('new_offer-category')) {
                    foreach ($this->input->post('new_offer-category') as $post_new_offer_category) {
                        if($post_new_offer_category != '') {
                            $data = array(
                                'value'     => $post_new_offer_category,
                                'type'      => 'offer_category',
                                'active'    => 1,
                            );
                            $this->Option_model->add_to_directory($data);
                        }
                    }
                }

                if($this->input->post('eq_a')) {
                    foreach($this->input->post('eq_a') as $key => $post_eq_a) {
                        $data = array(
                            'value'     => $post_eq_a
                        );
                        if(array_key_exists($key, $post_active))
                            $data['active']     = 1;
                        else
                            $data['active']     = 0;
                        $this->Option_model->update_directory( $key, $data );
                    }
                }

                if($this->input->post('new_eq_a')) {
                    foreach ($this->input->post('new_eq_a') as $post_new_eq_a) {
                        if($post_new_eq_a != '') {
                            $data = array(
                                'value'     => $post_new_eq_a,
                                'type'      => 'equipment_appointment',
                                'active'    => 1,
                            );
                            $this->Option_model->add_to_directory($data);
                        }
                    }
                }

            }


            $data_lists = array(
                'users'             => $this->User_model->get_users(),
                'professions'       => $this->Option_model->get_directory('profession'),
                'brands'            => $this->Option_model->get_directory('brand'),
                'roles'             => $this->Option_model->get_directory('role'),
                'offer_catеgory'    => $this->Option_model->get_directory('offer_category'),
                'eq_appointment'    => $this->Option_model->get_directory('equipment_appointment'),
            );

            $this->load->view('backend/header');
            $this->load->view('backend/lists', $data_lists);
            $this->load->view('backend/footer');
        }
    }

    public function news( $news_id = false ){
        if ($this->auth_user) {

            if($this->input->post('action') == 'news_delete'){
                $post_newsID     = $this->input->post('newsID');
                $this->News_model->delete_news($post_newsID);
            }

            // Был ли запрос на активацию/деактивацию?
            if($this->input->post('action') == 'news_switch_active') {
                if($this->input->post('sub_action') == 'deactivate') {
                    $post_newsID     = $this->input->post('newsID');
                    $this->News_model->deactivate_news($post_newsID);
                } elseif($this->input->post('sub_action') == 'activate') {
                    $post_newsID     = $this->input->post('newsID');
                    $this->News_model->activate_news($post_newsID);
                }

            }

            if( $news_id === false || $news_id == 'page' ) {

                $keywords   = "";
                if( $this->input->post("keywords") != '' ) {
                    $keywords   = $this->input->post("keywords");
                    $this->session->backend__search_news   = $keywords;
                }
                elseif( array_key_exists("keywords", $_POST) ) {
                    $this->session->unset_userdata('backend__search_news');
                }
                elseif( $this->session->backend__search_news ) {
                    $keywords   = $this->session->backend__search_news;
                }

                if( $this->input->post("clear") == "clear_keywords" ) {
                    $keywords = '';
                    $this->session->unset_userdata('backend__search_news');
                }

                $this->load->library('pagination');

                if( $this->uri->segment(4) )
                    $page   = $this->uri->segment(4);
                else
                    $page   = 1;

                $config['base_url'] 		    = base_url().'/backend/news/page/';
                $config['total_rows'] 		    = $this->News_model->get_news( array('keyword' => $keywords, 'type' => 'lenta', 'user_id' => 1, 'removed' => 'all', 'count' => true ) ); // $row_count;
                $config['per_page'] 		    = 10;
                $config['use_page_numbers']     = TRUE;
                $config['uri_segment'] 		    = 4;  // указываем, где в URL номер страниц

                $config['full_tag_open']        = '<div><ul class="pagination pagination-small pagination-centered">';
                $config['full_tag_close']       = '</ul></div>';
                $config['prev_link']            = '&lt; Назад';
                $config['prev_tag_open']        = '<li>';
                $config['prev_tag_close']       = '</li>';
                $config['next_link']            = 'Вперед &gt;';
                $config['next_tag_open']        = '<li>';
                $config['next_tag_close']       = '</li>';
                $config['cur_tag_open']         = '<li class="active"><a href="#">';
                $config['cur_tag_close']        = '</a></li>';
                $config['num_tag_open']         = '<li>';
                $config['num_tag_close']        = '</li>';
                $config['first_link']           = FALSE;
                $config['last_link']            = FALSE;

                $this->pagination->initialize($config);

                $data_news = array(
                    'news'                  => $this->News_model->get_news( array('keyword' => $keywords, 'type' => 'lenta', 'user_id' => 1, 'removed' => 'all', 'limit' => $config['per_page'], 'offset' => $config['per_page']*($page-1) ) ),
                    'pagination'            => $this->pagination->create_links(),
                    'count_all_news'        => $this->News_model->count_all_news(),
                    'count_all_comments'    => $this->News_model->count_all_comments(),
                    'count_all_likes'       => $this->News_model->count_all_likes(),
                    'count_project_news'    => $this->News_model->count_all_project_news(),
                    'count_project_comments'=> $this->News_model->count_all_project_comments(),
                    'count_project_likes'   => $this->News_model->count_all_project_likes(),
                );

                $this->load->view('backend/header');
                $this->load->view('backend/news/page', $data_news);
                $this->load->view('backend/footer');

            } else {

                if( $this->input->post('action') == 'update_news' )
                {
                    $post__news_id                  = $this->input->post('news_id');
                    $post__news_content             = $this->input->post('content');
                    $post__news_images              = $this->input->post('images');
                    $post__news_taxonomy            = $this->input->post('taxonomy');
                    $post__news_existing_images     = $this->input->post('existings_images');

                    $update_data = array(
                        'content'           => $post__news_content,
                        'taxonomy'          => $post__news_taxonomy,
                        'post_images'       => $post__news_images,
                        'existing_images'   => $post__news_existing_images
                    );

                    $this->News_model->edit_news( $post__news_id, $update_data  );
                }

                $data_news = array(
                    'news'                  => $this->News_model->get_news_item( $news_id, true ),
                    'count_all_news'        => $this->News_model->count_all_news(),
                    'count_all_comments'    => $this->News_model->count_all_comments(),
                    'count_all_likes'       => $this->News_model->count_all_likes(),
                    'count_project_news'    => $this->News_model->count_all_project_news(),
                    'count_project_comments'=> $this->News_model->count_all_project_comments(),
                    'count_project_likes'   => $this->News_model->count_all_project_likes(),
                );

                $this->load->view('backend/header');
                $this->load->view('backend/news/single', $data_news);
                $this->load->view('backend/footer');

            }
        }
    }

    public function add_news () {
        if ($this->auth_user) {

            if($this->input->post('action') == 'add_news' && $this->input->post('content') != ''){

                $insert_data    = $this->input->post('content');
                $images         = $this->input->post('images');
                $taxonomy       = $this->input->post('taxonomy');

                $insert_id      = $this->News_model->add_news( $this->input->post('author_id'), $insert_data, $images, false, $taxonomy );

                if( $insert_id ) {
                    redirect('/backend/news/'.$insert_id, 'refresh', 302);
                }
            }

            $page_data = array(
                'count_all_news'        => $this->News_model->count_all_news(),
                'count_all_comments'    => $this->News_model->count_all_comments(),
                'count_all_likes'       => $this->News_model->count_all_likes(),
                'count_project_news'    => $this->News_model->count_all_project_news(),
                'count_project_comments'=> $this->News_model->count_all_project_comments(),
                'count_project_likes'   => $this->News_model->count_all_project_likes(),
            );

            $this->load->view('backend/header');
            $this->load->view('backend/news/page__add', $page_data);
            $this->load->view('backend/footer');
        }
    }

    public function news_settings() {
        if ($this->auth_user) {

            if( $this->input->post('action') == 'news__meta_update' )
            {
                $title         = $this->input->post('meta__news_title');
                $keywords      = $this->input->post('meta__news_keywords');
                $description   = $this->input->post('meta__news_description');

                $this->Option_model->update_option('meta__news_title', $title);
                $this->Option_model->update_option('meta__news_keywords', $keywords);
                $this->Option_model->update_option('meta__news_description', $description);

                $project_title         = $this->input->post('meta__project_news_title');
                $project_keywords      = $this->input->post('meta__project_news_keywords');
                $project_description   = $this->input->post('meta__project_news_description');

                $this->Option_model->update_option('meta__project_news_title', $project_title);
                $this->Option_model->update_option('meta__project_news_keywords', $project_keywords);
                $this->Option_model->update_option('meta__project_news_description', $project_description);

                $post_result = 'success';
            }
            else
            {
                $post_result = false;
            }

            $page_data = array(
                'title'                 => $this->Option_model->get_option( 'meta__news_title' ),
                'keywords'              => $this->Option_model->get_option( 'meta__news_keywords' ),
                'description'           => $this->Option_model->get_option( 'meta__news_description' ),

                'project_title'                 => $this->Option_model->get_option( 'meta__project_news_title' ),
                'project_keywords'              => $this->Option_model->get_option( 'meta__project_news_keywords' ),
                'project_description'           => $this->Option_model->get_option( 'meta__project_news_description' ),

                'count_all_news'        => $this->News_model->count_all_news(),
                'count_all_comments'    => $this->News_model->count_all_comments(),
                'count_all_likes'       => $this->News_model->count_all_likes(),
                'count_project_news'    => $this->News_model->count_all_project_news(),
                'count_project_comments'=> $this->News_model->count_all_project_comments(),
                'count_project_likes'   => $this->News_model->count_all_project_likes(),

                'post_result'           => $post_result
            );

            $this->load->view('backend/header');
            $this->load->view('backend/news/settings', $page_data);
            $this->load->view('backend/footer');
        }
    }

    public function offers( $offer_id = false ){
        if ($this->auth_user) {
            // Был ли запрос на активацию/деактивацию?
            if($this->input->post('action') == 'offer_switch_active') {
                if($this->input->post('sub_action') == 'deactivate') {
                    $post_offerID     = $this->input->post('offerID');
                    $this->Offers_model->deactivate_offer($post_offerID);
                } elseif($this->input->post('sub_action') == 'activate') {
                    $post_offerID     = $this->input->post('offerID');
                    $this->Offers_model->activate_offer($post_offerID);
                }

            }

            if( $offer_id === false || $offer_id == "page" ) {

                $keywords   = "";
                if( $this->input->post("keywords") != '' ) {
                    $keywords   = $this->input->post("keywords");
                    $keywords   = trim(preg_replace('/\t+/', ' ', $keywords));
                    $this->session->backend__search_offers   = $keywords;
                }
                elseif( array_key_exists("keywords", $_POST) ) {
                    $this->session->unset_userdata('backend__search_offers');
                }
                elseif( $this->session->backend__search_offers ) {
                    $keywords   = $this->session->backend__search_offers;
                }

                if( $this->input->post("clear") == "clear_keywords" ) {
                    $keywords = '';
                    $this->session->unset_userdata('backend__search_offers');
                }


                $this->load->library('pagination');

                if( $this->uri->segment(4) )
                    $page   = $this->uri->segment(4);
                else
                    $page   = 1;

                $config['base_url'] 		    = base_url().'/backend/offers/page/';
                $config['total_rows'] 		    = $this->Offers_model->get_offers( array('keyword' => $keywords, 'removed' => 'all', 'count' => true) );
                $config['per_page'] 		    = 10;
                $config['use_page_numbers']     = TRUE;
                $config['uri_segment'] 		    = 4;  // указываем, где в URL номер страниц

                $config['full_tag_open']        = '<div><ul class="pagination pagination-small pagination-centered">';
                $config['full_tag_close']       = '</ul></div>';
                $config['prev_link']            = '&lt; Назад';
                $config['prev_tag_open']        = '<li>';
                $config['prev_tag_close']       = '</li>';
                $config['next_link']            = 'Вперед &gt;';
                $config['next_tag_open']        = '<li>';
                $config['next_tag_close']       = '</li>';
                $config['cur_tag_open']         = '<li class="active"><a href="#">';
                $config['cur_tag_close']        = '</a></li>';
                $config['num_tag_open']         = '<li>';
                $config['num_tag_close']        = '</li>';
                $config['first_link']           = FALSE;
                $config['last_link']            = FALSE;

                $this->pagination->initialize($config);


                $data_offers = array(
                    'offers'                    => $this->Offers_model->get_offers( array('keyword' => $keywords, 'removed' => 'all', 'limit' => $config['per_page'], 'offset' => $config['per_page']*($page-1) ) ),
                    'pagination'                => $this->pagination->create_links(),
                    'count_all_offers'          => $this->Offers_model->count_all_offers(),
                    'count_all_offers_views'    => $this->Offers_model->count_all_offers_views(),
                    'count_all_offers_contacts' => $this->Offers_model->count_all_offers_contacts()
                );

                $this->load->view('backend/header');
                $this->load->view('backend/offers/page', $data_offers);
                $this->load->view('backend/footer');

            } else {


                if( $this->input->post('action') == 'update_offer' )
                {
                    $post__offer_id                 = $this->input->post('offer_id');
                    $post__offer_type               = $this->input->post('type');
                    $post__offer_brand              = $this->input->post('brand');
                    $post__offer_category           = $this->input->post('category');
                    $post__offer_barter_text        = $this->input->post('barter_text');
                    $post__offer_price              = $this->input->post('price');
                    $post__offer_max_price          = $this->input->post('max_price');
                    $post__offer_content            = $this->input->post('content');

                    if( $this->input->post('barter') == 1)
                        $barter     = 1;
                    else
                        $barter     = 0;

                    $update_data = array(
                        'type'           => $post__offer_type,
                        'brand'         => $post__offer_brand,
                        'category'      => $post__offer_category,
                        'barter'        => $barter,
                        'barter_text'   => $post__offer_barter_text,
                        'price'         => $post__offer_price,
                        'max_price'     => $post__offer_max_price,
                        'content'       => $post__offer_content,
                    );

                    $this->Offers_model->edit_offer( $post__offer_id, $update_data  );
                }


                $data_offers = array(
                    'offer'             => $this->Offers_model->get_offer_item( $offer_id ),
                    'brands'            => $this->Option_model->get_directory('brand'),
                    'offer_catеgory'    => $this->Option_model->get_directory('offer_category'),

                );

                $this->load->view('backend/header');
                $this->load->view('backend/offers/single', $data_offers);
                $this->load->view('backend/footer');

            }
        }
    }

    public function system_settings() {
        if ($this->auth_user) {

            if( $this->input->post('system_email') )
                $this->Option_model->update_option('system_email', $this->input->post('system_email') );


            $data_content = array(
                'system_email'  => $this->Option_model->get_option( 'system_email' ),
            );


            $this->load->view('backend/header');
            $this->load->view('backend/system/page', $data_content);
            $this->load->view('backend/footer');


        }
    }
}