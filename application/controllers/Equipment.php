<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 07.07.16
 * Time: 13:44
 */

class Equipment extends CI_Controller
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
    public function index() {

        if( $this->router->user_lang == 'ru' ){
            $this->lang->load('main', 'russian');
        } elseif ( $this->router->user_lang == 'en' ) {
            $this->lang->load('main', 'english');
        }

        if ( $this->User_model->is_auth_user() ) {

            $filter     = array();
            if( $this->input->get('filter') == 'true' && ( $this->input->get('brand') ) && is_array( $this->input->get('brand') ) ) {
                $filter = array(
                    'brand'     => $this->input->get('brand'),
                );
            } else {
                $filter = array(
                    'brand'     => array(),
                );
            }

            $data_head['is_home_page']          = false;
            $data_head['meta_data']             = array(
                'title'         => 'Парк техники',
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
                    'selected'          => 'equipment',
                    'new_messages'      => $this->Message_model->count_unread_dialogs($this->session->user),
                    'new_partners'      => $this->Partner_model->get_inbox_partners_count($this->session->user),
                    'active_requests'   => $this->Request_model->count_active_requests($this->session->user),
                ),
                'brands'                => $this->Option_model->get_directory('brand', true),
                'equipment_appointment' => $this->Option_model->get_directory('equipment_appointment', true),
            );

            $user       = $this->User_model->get_user_by_id( $this->session->user );
            if( $user->company_id )
                if ( $user->id == $this->Company_model->get_company_director_id( $user->company_id ) ) {
                    $data_content['menu']['new_employers']  = $this->Company_model->count_company_candidats( $user->company_id );
                }

            $data_content['filter_brands']  = $this->Equipment_model->get_equipment_brands( $this->session->user );
            $data_content['equipment']      = $this->Equipment_model->get_items( $this->session->user, $filter );
            $data_content['filter']         = $filter;


            if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                $this->load->view('mobile/user/head',       $data_head);
                $this->load->view('mobile/equipment/page',  array("page_header"  => $data_header, "page_content" => $data_content ) );
                $this->load->view('mobile/user/footer',     $data_footer);

            else:

                $this->load->view('desktop/user/head',      $data_head);
                $this->load->view('desktop/user/header',    $data_header);
                $this->load->view('desktop/equipment/page', $data_content);
                $this->load->view('desktop/user/footer',    $data_footer);

            endif;

        } else {
            redirect('/', 'refresh', 302);
        }
    }
}
