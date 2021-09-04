<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 07.07.16
 * Time: 13:44
 */

class Offers extends CI_Controller
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

    public function index( $page_type = 'sell', $id = 0 )
    {

        if( $this->router->user_lang == 'ru' ){
            $this->lang->load('main', 'russian');
        } elseif ( $this->router->user_lang == 'en' ) {
            $this->lang->load('main', 'english');
        }


        if( $this->input->get('add') && $this->input->get('add') == 'success' && !$this->session->has_userdata('offer_add') ) {
            $this->session->set_userdata('offer_add', 'success');
            redirect( '/offers/'.$page_type, 'refresh', 302);
        }

        if( $this->input->get('edit') && $this->input->get('edit') == 'success' && !$this->session->has_userdata('offer_edit') ) {
            $this->session->set_userdata('offer_edit', 'success');
            redirect( '/offers/'.$page_type , 'refresh', 302);
        }


        $filter     = array();
        if( $this->input->get('filter') == 'true') {
            if( $this->input->get('type') )
                $filter['type'] = $this->input->get('type');
            else
                $filter['type'] = $page_type;
            if( $this->input->get('price') )
                $filter['price'] = $this->input->get('price');
            else
                $filter['price'] = '';
            if( $this->input->get('max_price') )
                $filter['max_price'] = $this->input->get('max_price');
            else
                $filter['max_price'] = '';
            if( $this->input->get('cat') && is_array($this->input->get('cat')) )
            {
                foreach ( $this->input->get('cat') as $cat)
                {
                    $filter['category'][] = $cat;
                }
            }
            else
            {
                $filter['category'] = array();
            }
            if( $this->input->get('brand') && is_array($this->input->get('brand')) )
            {
                foreach ( $this->input->get('brand') as $brand)
                {
                    $filter['brand'][] = $brand;
                }
            }
            else
            {
                $filter['brand'] = array();
            }
            if( $this->input->get('sort_by') )
                $filter['sort_by'] = $this->input->get('sort_by');

            if( $this->input->get('barter') && $this->input->get('barter') == 'yes' )
                $filter['barter'] = 'yes';

        } else {
            $filter = array(
                'type'      => $page_type,
                'price'     => '',
                'max_price' => '',
                'category'  => array(),
                'brand'     => array(),
                'barter'    => 'no'
            );
        }

        if ( $this->User_model->is_auth_user() ) {

            $data_head['is_home_page']          = true;

            switch ($page_type){
                case 'sell':
                    $data_head['meta_data']             = array(
                        'title'         => 'Объявления о продаже',
                        'keywords'      => '',
                        'description'   => ''
                    );
                    break;
                case 'buy':
                    $data_head['meta_data']             = array(
                        'title'         => 'Объявления о покупке',
                        'keywords'      => '',
                        'description'   => ''
                    );
                    break;
                case 'service':
                    $data_head['meta_data']             = array(
                        'title'         => 'Объявления об услугах',
                        'keywords'      => '',
                        'description'   => ''
                    );
                    break;
                default:
                    show_404();
                    return;
                    break;
            }

            $data_header = array(
                'usd'               => $this->Option_model->get_option("cbr_usd"),
                'eur'               => $this->Option_model->get_option("cbr_eur"),
                'search_or_link'    => array(
                    'type'          => 'search',
                    'target'        => 'offers',
                    'title'         => 'Поиск по объявлениям'
                ),
            );

            $data_footer = array(
                'notifications' => $this->Notification_model->get_notifications( $this->session->user )
            );

            $data_content = array(
                'menu'          => array(
                    'selected'          => 'offers',
                    'new_messages'      => $this->Message_model->count_unread_dialogs($this->session->user),
                    'new_partners'      => $this->Partner_model->get_inbox_partners_count($this->session->user),
                    'offers_filter_type'=> $page_type,
                    'active_requests'   => $this->Request_model->count_active_requests($this->session->user),
                ),
                'all__brands'           => $this->Option_model->get_directory('brand', true),
                'all__offer_categories' => $this->Option_model->get_directory('offer_category', true),
                'offers'                => $this->Offers_model->get_offers($filter),
                'offers_type'           => $page_type,
            );

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

            $data_content['brands']    = $data_content['all__brands'];
            foreach( $data_content['brands'] as $offer_b__key => $offer_b__val ) {
                if( !$this->Offers_model->has_brand_offers($offer_b__val->id, $page_type) ) {
                    unset( $data_content['brands'][$offer_b__key] );
                }
            }


            $data_content['offer_categories']    = $data_content['all__offer_categories'];
            foreach( $data_content['offer_categories'] as $offer_c__key => $offer_c__val ) {
                if( !$this->Offers_model->has_category_offers($offer_c__val->id, $page_type) ) {
                    unset( $data_content['offer_categories'][$offer_c__key] );
                }
            }

            if( $this->Offers_model->has_barter_offers( $page_type ) )
                $data_content['filter__barter_disable']     = false;
            else
                $data_content['filter__barter_disable']     = true;

            if( $this->session->has_userdata('offer_add') ){
                $data_content['offer__added']       = true;
                $this->session->unset_userdata( 'offer_add' );
            }

            if( $this->session->has_userdata('offer_edit') ){
                $data_content['offer__edited']       = true;
                $this->session->unset_userdata( 'offer_edit' );
            }


            if( $id && $id != 0) {

                $data_content['offer']  = $this->Offers_model->get_offer_item( $id );

                if( !$data_content['offer'] || !is_object($data_content['offer']) ) {
                    show_404();
                    return;
                }

                if( $data_content['offer']->removed == 1 ) {
                    show_404();
                    return;
                }

                switch ( $data_content['offer']->type ) {
                    case 'sell':
                        $data_header['search_or_link']  = array(
                            'type'      => 'link',
                            'url'       => '/offers/sell',
                            'title'     => 'К списку объявлений о продаже'
                        );
                        break;
                    case 'buy':
                        $data_header['search_or_link']  = array(
                            'type'      => 'link',
                            'url'       => '/offers/buy',
                            'title'     => 'К списку объявлений о покупке'
                        );
                        break;
                    case 'service':
                        $data_header['search_or_link']  = array(
                            'type'      => 'link',
                            'url'       => '/offers/service',
                            'title'     => 'К списку объявлений об услугах'
                        );
                        break;
                }





                if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                    $this->load->view('mobile/user/head',       $data_head);
                    $this->load->view('mobile/offers/page__single',     array("page_header"  => $data_header, "page_content" => $data_content ) );
                    $this->load->view('mobile/user/footer',     $data_footer);

                else:

                    $this->load->view('desktop/user/head',          $data_head);
                    $this->load->view('desktop/user/header',        $data_header);
                    $this->load->view('desktop/offers/page__single',  $data_content);
                    $this->load->view('desktop/user/footer',        $data_footer);

                endif;


                return;
            }


            if( $data_content['offers'] )  {
                foreach($data_content['offers'] as $offer){
                    $last_loaded_offer = $offer->id;
                };
                $data_content['last_loaded_offer']     = $last_loaded_offer;
            }
            else  {
                $data_content['last_loaded_offer']     = 0;
            }

            $data_content['filter']             = $filter;


            if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                $this->load->view('mobile/user/head',       $data_head);
                $this->load->view('mobile/offers/page',     array("page_header"  => $data_header, "page_content" => $data_content ) );
                $this->load->view('mobile/user/footer',     $data_footer);

            else:

                $this->load->view('desktop/user/head',      $data_head);
                $this->load->view('desktop/user/header',    $data_header);
                $this->load->view('desktop/offers/page',    $data_content);
                $this->load->view('desktop/user/footer',    $data_footer);

            endif;

        }
        else
        {


            $data_head['is_home_page']          = true;
            switch ($page_type){
                case 'sell':
                    $data_head['meta_data']             = array(
                        'title'         => 'Объявления о продаже',
                        'keywords'      => '',
                        'description'   => ''
                    );
                    break;
                case 'buy':
                    $data_head['meta_data']             = array(
                        'title'         => 'Объявления о покупке',
                        'keywords'      => '',
                        'description'   => ''
                    );
                    break;
                case 'service':
                    $data_head['meta_data']             = array(
                        'title'         => 'Объявления об услугах',
                        'keywords'      => '',
                        'description'   => ''
                    );
                    break;
                default:
                    break;
            }


            $data_content = array(
                'menu'          => array(
                    'selected'          => 'offers',
                    'new_messages'      => $this->Message_model->count_unread_dialogs($this->session->user),
                    'new_partners'      => $this->Partner_model->get_inbox_partners_count($this->session->user),
                    'ads_filter_type'   => $page_type,
                    'active_requests'   => $this->Request_model->count_active_requests($this->session->user),
                ),
                'brands'            => $this->Option_model->get_directory('brand', true),
                'offer_categories'  => $this->Option_model->get_directory('offer_category', true),
                'ads'               => $this->Offers_model->get_offers($filter), // устаревшее. Только в гостевом просмотре для ПК
                'ads_type'          => $page_type, // устаревшее. Только в гостевом просмотре для ПК,
                'offers'            => $this->Offers_model->get_offers($filter), // устаревшее. Только в гостевом просмотре для ПК
                'offers_type'       => $page_type, // устаревшее. Только в гостевом просмотре для ПК,

            );



            foreach( $data_content['brands'] as $offer_b__key => $offer_b__val ) {

                if( !$this->Offers_model->has_brand_offers($offer_b__val->id, $page_type) ) {
                    unset( $data_content['brands'][$offer_b__key] );
                }
            }

            foreach( $data_content['offer_categories'] as $offer_c__key => $offer_c__val ) {
                if( !$this->Offers_model->has_category_offers($offer_c__val->id, $page_type) ) {
                    unset( $data_content['offer_categories'][$offer_c__key] );
                }
            }

            if( $this->Offers_model->has_barter_offers( $page_type ) )
                $data_content['filter__barter_disable']     = false;
            else
                $data_content['filter__barter_disable']     = true;




            $data_header = array(
                'usd'       => $this->Option_model->get_option("cbr_usd"),
                'eur'       => $this->Option_model->get_option("cbr_eur"),
            );

            $data_footer['is_home_page']        = false;
            //$data_footer['language_switcher']   = $this->Page_model->get_language_switcher("ru");   // Получаем переключатель языка
            $data_footer['footer_menu']         = $this->Page_model->get_footer_menu();              // Получаем меню навигации



            if( $id && $id != 0) {
                /*
                    $data_content['current_offer']       = $this->Offers_model->get_offer_item( $id );
                    $data_content['current_offer_id']    = $id;
                */

                $data_content['offer'] = $this->Offers_model->get_offer_item($id);

                if (!$data_content['offer'] || !is_object($data_content['offer'])) {
                    show_404();
                    return;
                }

                if ($data_content['offer']->removed == 1) {
                    show_404();
                    return;
                }

                if ($this->agent->is_mobile()):

                    $this->load->view('mobile/user/head', $data_head);
                    $this->load->view('mobile/main/header', array("page_header" => $data_header, "page_content" => $data_content, "page_footer" => $data_footer));
                    $this->load->view('mobile/offers/guest__page__single', array("page_content" => $data_content));
                    $this->load->view('mobile/main/footer');

                    return;
                endif;
            }
            else
            {
                $data_content['current_offer']       = false;
                $data_content['current_offer_id']    = 0;
            }

            if( $data_content['offers'] )
            {
                foreach($data_content['offers'] as $offer){
                    $last_loaded_offer  = $offer->id;  // устаревшее. Только в гостевом просмотре для ПК,
                };
                $data_content['last_loaded_ad']         = $last_loaded_offer; // устаревшее. Только в гостевом просмотре для ПК,
                $data_content['last_loaded_offer']      = $last_loaded_offer;
            }
            else
            {
                $data_content['last_loaded_ad']         = 0;
                $data_content['last_loaded_offer']      = 0;
            }

            $data_content['filter']             = $filter;



            if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                $this->load->view('mobile/user/head',       $data_head);
                $this->load->view('mobile/main/header',     array("page_header"  => $data_header, "page_content" => $data_content, "page_footer" => $data_footer ));
                $this->load->view('mobile/offers/guest__page', array( "page_content" => $data_content ) );
                $this->load->view('mobile/main/footer');

            else:

                $this->load->view('desktop/user/head',              $data_head);
                $this->load->view('desktop/misc/guest__html__header');
                $this->load->view('desktop/offers/guest__page',    $data_content);
                $this->load->view('desktop/misc/guest__html__footer');

            endif;
        }
    }

    public function find() {

        if( $this->router->user_lang == 'ru' ){
            $this->lang->load('main', 'russian');
        } elseif ( $this->router->user_lang == 'en' ) {
            $this->lang->load('main', 'english');
        }

        $data_head['meta_data']             = array(
            'title'         => 'Результаты поиска объявлений',
            'keywords'      => '',
            'description'   => ''
        );

        $data_header = array(
            'usd'               => $this->Option_model->get_option("cbr_usd"),
            'eur'               => $this->Option_model->get_option("cbr_eur"),
            'search_or_link'    => array(
                'type'          => 'search',
                'target'        => 'offers',
                'title'         => 'Поиск по объявлениям'
            ),
        );

        $data_footer = array(
            'notifications' => $this->Notification_model->get_notifications( $this->session->user )
        );

        $data_content = array(
            'menu'          => array(
                'selected'          => 'offers',
                'new_messages'      => $this->Message_model->count_unread_dialogs($this->session->user),
                'new_partners'      => $this->Partner_model->get_inbox_partners_count($this->session->user),
                'active_requests'   => $this->Request_model->count_active_requests($this->session->user),
            ),
        );

        $data_content['keyword']    = $this->input->get('query');
        if( $data_content['keyword'] )
            $data_content['offers']     = $this->Offers_model->get_offers( array('keyword' => $data_content['keyword'] )  );
        else
            $data_content['offers'] = false;

        $data_content['ads']        = $data_content['offers'];  // Устаревшее // Используется только в ПК версии


        if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

            $this->load->view('mobile/user/head',           $data_head);
            $this->load->view('mobile/offers/page__find',   array("page_header"  => $data_header, "page_content" => $data_content ) );
            $this->load->view('mobile/user/footer',         $data_footer);

        else:

            $this->load->view('desktop/user/head',          $data_head);
            $this->load->view('desktop/user/header',        $data_header);
            $this->load->view('desktop/offers/page__find',  $data_content);
            $this->load->view('desktop/user/footer',        $data_footer);

        endif;

    }
}