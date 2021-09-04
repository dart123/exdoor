<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if ( $this->User_model->is_auth_user() ) {
            if ($this->input->get('logout')) {
                $this->User_model->user_logout();
                redirect( '/', 'refresh', 302);
            }

            $this->User_model->online_checker( $this->session->user );
        }
        if( $this->session->userdata('unblock') &&  $this->session->userdata('unblock') <= intval( time() )) {
            $this->session->unset_userdata('unblock');
        }

    }

	public function index( )
	{
        // Если пользователь авторизован
        if ( $this->User_model->is_auth_user() ) {

            // Если он авторизован, но при попытке получить данные о нем возвращается false - выкидываем
            $user = $this->User_model->get_user_by_id( intval( $this->session->user ) );

            if(!$user){
                $this->User_model->user_logout();
                redirect('/', 'refresh');
            } else {
                redirect('/id'.$user->id);
            }

        }
        // Если пользователь не зарегистрирован
        else {
            $data_head['is_home_page']          = true;

            if( $this->router->user_lang == 'ru' ){
                $data_head['meta_data']             = array(
                    'title'         => $this->Option_model->get_option('home_meta_title_ru'),
                    'keywords'      => $this->Option_model->get_option('home_meta_keywords_ru'),
                    'description'   => $this->Option_model->get_option('home_meta_description_ru')
                );
                $data_head['video_id']      = $this->Option_model->get_option('video_id_ru');
                $data_head['video_source']  = $this->Option_model->get_option('video_source_ru');

                $data_index['slides']       = json_decode($this->Option_model->get_option('slides_ru'));

                $this->lang->load('main', 'russian');

            } elseif ( $this->router->user_lang == 'en' ) {
                $data_head['meta_data']             = array(
                    'title'         => $this->Option_model->get_option('home_meta_title_en'),
                    'keywords'      => $this->Option_model->get_option('home_meta_keywords_en'),
                    'description'   => $this->Option_model->get_option('home_meta_description_en')
                );
                $data_head['video_id']      = $this->Option_model->get_option('video_id_en');
                $data_head['video_source']  = $this->Option_model->get_option('video_source_en');

                $data_index['slides']       = json_decode($this->Option_model->get_option('slides_en'));

                $this->lang->load('main', 'english');
            }



            $data_header['is_home_page']        = true;
            $data_header['menu']                = array('selected' => 'none');
            $data_header['usd']                 = $this->Option_model->get_option("cbr_usd");
            $data_header['eur']                 = $this->Option_model->get_option("cbr_eur");

            $data_footer['is_home_page']        = true;
            $data_footer['language_switcher']   = $this->Page_model->get_language_switcher();        // Получаем переключатель языка
            $data_footer['footer_menu']         = $this->Page_model->get_footer_menu();              // Получаем меню навигации

            if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):


                $this->load->view('mobile/user/head',       $data_head);
                $this->load->view('mobile/main/header',     array("page_head" => $data_head, "page_header"  => $data_header, "page_content" => $data_index, "page_footer" => $data_footer ));
                $this->load->view('mobile/main/index',      array("page_header"  => $data_header, "page_content" => $data_index, "page_footer" => $data_footer ));
                //$this->load->view('mobile/main/all_test_page');
            else:
                $this->load->view('desktop/main/head',      $data_head);
                $this->load->view('desktop/main/header',    $data_header);
                $this->load->view('desktop/main/index',     $data_index);
                $this->load->view('desktop/main/footer',    $data_footer);
            endif;
        }

	}

    public function page($slug)
    {
        if( $this->router->user_lang == 'ru' ){
            $this->lang->load('main', 'russian');
        } elseif ( $this->router->user_lang == 'en' ) {
            $this->lang->load('main', 'english');
        }
        $page_data = $this->Page_model->get_page_by_slug($slug);

        if( !$page_data )
            show_404();

        $data_head['is_home_page']          = false;
        $data_head['meta_data']             = array(
                                                'title'         => $page_data['meta_title'],
                                                'keywords'      => $page_data['meta_keywords'],
                                                'description'   => $page_data['meta_description'],
                                            );

        $data_content['content']            = array(
                                                'id'        => $page_data['id'],
                                                'title'     => $page_data['title'],
                                                'content'   => $page_data['content'],
                                                'date'      => $page_data['date']
                                            );
        $data_content['go_back_url']        = $this->Page_model->home_page_link();


        $data_footer['is_home_page']        = false;
        $data_footer['language_switcher']   = $this->Page_model->get_language_switcher($slug);   // Получаем переключатель языка
        $data_footer['footer_menu']         = $this->Page_model->get_footer_menu();              // Получаем меню навигации

        $data_header = array(
            'usd'       => $this->Option_model->get_option("cbr_usd"),
            'eur'       => $this->Option_model->get_option("cbr_eur"),
        );

        if ( $this->User_model->is_auth_user() ) {

            if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                $this->load->view('mobile/user/head',       $data_head);
                $this->load->view('mobile/main/header',     array("page_header"  => $data_header, "page_content" => $data_content, "page_footer" => $data_footer ));
                $this->load->view('mobile/main/content',    $data_content);

            else:

                $this->load->view('desktop/user/head',      $data_head);
                $this->load->view('desktop/user/header',    $data_header);
                $this->load->view('desktop/main/content',   $data_content);
                $this->load->view('desktop/main/footer',    $data_footer);
            endif;
        }
        else {
            // Получаем меню навигации
            $data_header['sidebar_menu']        = $this->Page_model->get_sidebar_menu();

            if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                $this->load->view('mobile/user/head',       $data_head);
                $this->load->view('mobile/main/header',     array("page_header"  => $data_header, "page_content" => $data_content, "page_footer" => $data_footer ));
                $this->load->view('mobile/main/content',      $data_content);

            else:

                $this->load->view('desktop/main/head',      $data_head);
                $this->load->view('desktop/main/header',    $data_header);
                $this->load->view('desktop/main/content',   $data_content);
                $this->load->view('desktop/main/footer',    $data_footer);
            endif;
        }
    }

}
