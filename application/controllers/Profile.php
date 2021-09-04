<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 07.07.16
 * Time: 13:44
 */


class Profile extends CI_Controller
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
        // Если он авторизован, но при попытке получить данные о нем возвращается false - выкидываем
        $user = $this->User_model->get_user_by_id( intval( $this->session->user ) );
        if(!$user){
            $this->User_model->user_logout();
            redirect('/', 'refresh');
        }
    }

    public function index() {

        if( $this->router->user_lang == 'ru' ){
            $this->lang->load('main', 'russian');
        } elseif ( $this->router->user_lang == 'en' ) {
            $this->lang->load('main', 'english');
        }

        $data_head['is_home_page']          = false;
        if ( $this->User_model->is_auth_user() ) {
            $data_head['meta_data']             = array(
                'title'         => 'Профиль пользователя',
                'keywords'      => '',
                'description'   => ''
            );
            $data_header = array(
                'usd'           => $this->Option_model->get_option("cbr_usd"),
                'eur'           => $this->Option_model->get_option("cbr_eur"),
                'body_class'    => 'page-content-form__wrap'
            );
            $data_footer = array(
                'notifications' => $this->Notification_model->get_notifications( $this->session->user )
            );
            $data_content = array(
                'menu'          => array(
                    'selected'          => 'profile',
                    'new_messages'      => $this->Message_model->count_unread_dialogs($this->session->user),
                    'new_partners'      => $this->Partner_model->get_inbox_partners_count($this->session->user),
                    'active_requests'   => $this->Request_model->count_active_requests($this->session->user),
                ),
                'brands'            => $this->Option_model->get_directory('brand', true),
            );

            $user   = $this->User_model->get_user_by_id( $this->session->user );
            if( $user->company_id )
                if ( $user->id == $this->Company_model->get_company_director_id( $user->company_id ) ) {
                    $data_content['menu']['new_employers']  = $this->Company_model->count_company_candidats( $user->company_id );
                }


            $data_content['user']           = $this->User_model->get_user_by_id( intval( $this->session->user ) );
            $data_content['professions']    = $this->Option_model->get_directory('profession', true);
            $data_content['user_brands']    = $this->User_model->get_user_brands( intval( $this->session->user ) );


            if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                $this->load->view('mobile/user/head',       $data_head);
                $this->load->view('mobile/profile/page',    array("page_header"  => $data_header, "page_content" => $data_content ) );
                $this->load->view('mobile/user/footer',     $data_footer);

            else:

                $this->load->view('desktop/user/head',      $data_head);
                $this->load->view('desktop/user/header',    $data_header);
                $this->load->view('desktop/profile/page',   $data_content);
                $this->load->view('desktop/user/footer',    $data_footer);

            endif;

        } else {
            redirect('/', 'refresh', 302);
        }
    }

    public function company() {

        if( $this->router->user_lang == 'ru' ){
            $this->lang->load('main', 'russian');
        } elseif ( $this->router->user_lang == 'en' ) {
            $this->lang->load('main', 'english');
        }

        $data_head['is_home_page']          = false;
        if ( $this->User_model->is_auth_user() ) {
            $data_head['meta_data']             = array(
                'title'         => 'Моя компания',
                'keywords'      => '',
                'description'   => ''
            );
            $data_header = array(
                'usd'           => $this->Option_model->get_option("cbr_usd"),
                'eur'           => $this->Option_model->get_option("cbr_eur"),
                'body_class'    => 'page-content-form__wrap'
            );
            $data_footer = array(
                'notifications' => $this->Notification_model->get_notifications( $this->session->user )
            );
            $data_content = array(
                'menu'          => array(
                    'selected'          => 'profile',
                    'new_messages'      => $this->Message_model->count_unread_dialogs($this->session->user),
                    'new_partners'      => $this->Partner_model->get_inbox_partners_count($this->session->user),
                    'active_requests'   => $this->Request_model->count_active_requests($this->session->user),
                ),
            );

            $user   = $this->User_model->get_user_by_id( intval( $this->session->user ) );

            if( $user->company_id )
                if ( $user->id == $this->Company_model->get_company_director_id( $user->company_id ) ) {
                    $data_content['menu']['new_employers']  = $this->Company_model->count_company_candidats( $user->company_id );
                }

            $data_content['user']   = $user;

            if ( ($data_content['user']->company_id != 0) && ($this->input->get('change_inn') != 'true') ) {

                $company = $this->Company_model->get_company_by_id( intval( $data_content['user']->company_id ) );



                if( $this->input->post('action') == 'leave_company' ){


                    $this->load->library('Socket');
                    $socket     = new Socket();
                    $socket->initialize();


                    if( $company->is_manager ) {

                        $employers      = $this->Company_model->get_company_employers( $company->id );

                        // Отправляем нотификацию сотрудникам об удалении
                        if ( $employers) {
                            foreach ( $employers as $employer ) {

                                if( $employer->id != $user->id ):

                                    $noty_data = array(
                                        'user_id'       => $employer->id,
                                        'from_id'       => $company->director,
                                        'from_company'  => 0,
                                        'title'         => 'Директор удалил Вашу компанию',
                                        'content'       => 'Директор принял решение удалить данные о компании с сервиса.',
                                        'url'           => '/company',
                                        'target'        => 'company'
                                    );

                                    $noty_id    = $this->Notification_model->save_notification( $noty_data );
                                    $noty       = $this->Notification_model->get_notification( $noty_id );

                                    $socket->emit('send', [ 'channel' => 'channel_'.$employer->id, 'type' => 'notification', 'content' => json_encode($noty)]);

                                endif;
                            }
                        }

                        $this->Company_model->remove_company( $company->id );

                        redirect('/profile/company', 'refresh', 302);

                    }
                    else
                    {
                        $this->Company_model->leave_company( $this->session->user, $company->id );

                        // Отправляем нотификацию директору о ренегате
                        $noty_data = array(
                            'user_id'       => $company->director,
                            'from_id'       => $this->session->user,
                            'from_company'  => 0,
                            'title'         => $data_content['user']->name.' '.$data_content['user']->last_name.' покинул(а) Вашу компанию',
                            'content'       => 'Сотрудник покинул Вашу команию',
                            'url'           => false
                        );

                        $noty    = $this->Notification_model->form_notification( $noty_data );

                        $socket->emit('send', [ 'channel' => 'channel_'.$company->director, 'type' => 'notification', 'content' => json_encode($noty)]);

                        $socket->emit('send', [ 'channel' => 'channel_'.$company->director, 'type' => 'informer__employer_leave_company', 'content' => $this->session->user]);

                    }

                    $socket->close();
                    redirect('/profile/company', 'refresh', 302);

                }


                $data_content['company'] = $company;
                $data_content['company_manager'] = $this->User_model->get_user_by_id( $company->director );

                if( $data_content['user']->company_status == 'not accepted' ) {

                    if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                        $this->load->view('mobile/user/head',       $data_head);
                        $this->load->view('mobile/profile/page__company_found__candidat',       array("page_header"  => $data_header, "page_content" => $data_content ) );
                        $this->load->view('mobile/user/footer',     $data_footer);

                    else:

                        $this->load->view('desktop/user/head',              $data_head);
                        $this->load->view('desktop/user/header',            $data_header);
                        $this->load->view('desktop/profile/page__company_found__candidat',  $data_content);
                        $this->load->view('desktop/user/footer',            $data_footer);

                    endif;


                } elseif( $data_content['user']->company_status == 'accepted' ) {

                    if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                        $this->load->view('mobile/user/head',       $data_head);
                        $this->load->view('mobile/profile/page__company_accepted',       array("page_header"  => $data_header, "page_content" => $data_content ) );
                        $this->load->view('mobile/user/footer',     $data_footer);

                    else:

                        $this->load->view('desktop/user/head',              $data_head);
                        $this->load->view('desktop/user/header',            $data_header);
                        $this->load->view('desktop/profile/page__company_accepted',  $data_content);
                        $this->load->view('desktop/user/footer',            $data_footer);

                    endif;

                }
            } else {

                /* Если директор или сотрудник кликают по ссылке "Сменить ИНН" они автовыпиливаются */

                if ( $data_content['user']->company_id != 0 && $this->input->get('change_inn') == 'true'  ) {

                    $company = $this->Company_model->get_company_by_id( intval( $data_content['user']->company_id ) );
                    if( $company->is_manager )
                        $this->Company_model->remove_company( $company->id );
                    else
                        $this->Company_model->leave_company( $this->session->user, $company->id );


                }

                if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                    $this->load->view('mobile/user/head',       $data_head);
                    $this->load->view('mobile/profile/page__company',       array("page_header"  => $data_header, "page_content" => $data_content ) );
                    $this->load->view('mobile/user/footer',     $data_footer);

                else:

                    $this->load->view('desktop/user/head',              $data_head);
                    $this->load->view('desktop/user/header',            $data_header);
                    $this->load->view('desktop/profile/page__company',  $data_content);
                    $this->load->view('desktop/user/footer',            $data_footer);

                endif;


            };

        } else {
            redirect('/', 'refresh', 302);
        }
    }

    public function add_company() {

        if( $this->router->user_lang == 'ru' ){
            $this->lang->load('main', 'russian');
        } elseif ( $this->router->user_lang == 'en' ) {
            $this->lang->load('main', 'english');
        }

        $data_head['is_home_page']          = false;
        if ( $this->User_model->is_auth_user() ) {
            $data_head['meta_data']             = array(
                'title'         => 'Моя компания',
                'keywords'      => '',
                'description'   => ''
            );
            $data_header = array(
                'usd'           => $this->Option_model->get_option("cbr_usd"),
                'eur'           => $this->Option_model->get_option("cbr_eur"),
                'body_class'    => 'page-content-form__wrap'
            );
            $data_footer = array(
                'notifications' => $this->Notification_model->get_notifications( $this->session->user )
            );
            $data_content = array(
                'menu'          => array(
                    'selected'          => 'profile',
                    'new_messages'      => $this->Message_model->count_unread_dialogs($this->session->user),
                    'new_partners'      => $this->Partner_model->get_inbox_partners_count($this->session->user),
                    'active_requests'   => $this->Request_model->count_active_requests($this->session->user),
                ),
            );

            $user   = $this->User_model->get_user_by_id( $this->session->user );
            if( $user->company_id )
                if ( $user->id == $this->Company_model->get_company_director_id( $user->company_id ) ) {
                    $data_content['menu']['new_employers']  = $this->Company_model->count_company_candidats( $user->company_id );
                }

            $data_content['user']   = $user;
                //  Первичное добавление компании. Не трогаем базу
            if( $this->input->post('action') == 'add_company_step_1'){

                if( $this->input->post('full_name') ){
                    $data_content['company']['full_name'] = $this->input->post('full_name');
                } else {
                    $data_content['company']['full_name'] = '';
                }
                if( $this->input->post('short_name') ){
                    $data_content['company']['short_name'] = $this->input->post('short_name');
                } else {
                    $data_content['company']['short_name'] = '';
                }
                if( $this->input->post('inn') ){
                    $data_content['company']['inn'] = $this->input->post('inn');
                } else {
                    $data_content['company']['inn'] = '';
                }
                if( $this->input->post('kpp') ){
                    $data_content['company']['kpp'] = $this->input->post('kpp');
                } else {
                    $data_content['company']['kpp'] = '';
                }
                if( $this->input->post('ogrn') ){
                    $data_content['company']['ogrn'] = $this->input->post('ogrn');
                } else {
                    $data_content['company']['ogrn'] = '';
                }
                if( $this->input->post('address') ){
                    $data_content['company']['address'] = $this->input->post('address');
                } else {
                    $data_content['company']['address'] = '';
                }
                if( $this->input->post('manager') ){
                    $data_content['company']['manager'] = $this->input->post('manager');
                } else {
                    $data_content['company']['manager'] = '';
                }
                if( $this->input->post('manager_post') ){
                    $data_content['company']['manager_post'] = $this->input->post('manager_post');
                } else {
                    $data_content['company']['manager_post'] = '';
                }
                if( $this->input->post('company_type') ){
                    $data_content['company']['type'] = $this->input->post('company_type');
                } else {
                    $data_content['company']['type'] = '';
                }

                //  Если пользователь сотрудник - проверяем наличие и отправляем заявку
                if( $this->input->post('my-company-role') && $this->input->post('my-company-role') == 'worker'){

                    $company = $this->Company_model->get_company_by_inn( intval( $data_content['company']['inn'] ) );

                    if( $company ){

                        $data_content['company'] = $company;

                        /* !!!!!!!!!!!!!!!!!!!


                        $this->Company_model->enter_company( $this->session->user, $company->id );

                        $this->load->library('Socket');
                        $socket     = new Socket();
                        $socket->initialize();

                        $noty_data = array(
                            'user_id'       => $company->director,
                            'from_id'       => $this->session->user,
                            'from_company'  => 0,
                            'title'         => $data_content['user']->name.' '.$data_content['user']->last_name,
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

                        redirect('/profile/company', 'refresh', 302);


                        !!!!!!!!!!!!!!!!!!!!!   */

                        $data_content['company_manager'] = $this->User_model->get_user_by_id( $company->director );

                        if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                            $this->load->view('mobile/user/head',       $data_head);
                            $this->load->view('mobile/profile/page__company_found',       array("page_header"  => $data_header, "page_content" => $data_content ) );
                            $this->load->view('mobile/user/footer',     $data_footer);

                        else:

                            $this->load->view('desktop/user/head',              $data_head);
                            $this->load->view('desktop/user/header',            $data_header);
                            $this->load->view('desktop/profile/page__company_found',  $data_content);
                            $this->load->view('desktop/user/footer',            $data_footer);

                        endif;


                    } else {

                        if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                            $this->load->view('mobile/user/head',       $data_head);
                            $this->load->view('mobile/profile/page__company_not_found',       array("page_header"  => $data_header, "page_content" => $data_content ) );
                            $this->load->view('mobile/user/footer',     $data_footer);

                        else:

                            $this->load->view('desktop/user/head',              $data_head);
                            $this->load->view('desktop/user/header',            $data_header);
                            $this->load->view('desktop/profile/page__company_not_found',  $data_content);
                            $this->load->view('desktop/user/footer',            $data_footer);

                        endif;

                    }

                }
                //  Если пользователь директор - добавляем компанию
                else {
                    $data_content['brands'] = $this->Option_model->get_directory('brand', true);

                    if( $company = $this->Company_model->get_company_by_inn( intval( $data_content['company']['inn'] ) ) ) {

                        $data_content['company'] = $company;
                        $data_content['company_manager'] = $this->User_model->get_user_by_id( $company->director );

                        if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                            $this->load->view('mobile/user/head',       $data_head);
                            $this->load->view('mobile/profile/page__company_found',       array("page_header"  => $data_header, "page_content" => $data_content ) );
                            $this->load->view('mobile/user/footer',     $data_footer);

                        else:

                            $this->load->view('desktop/user/head',              $data_head);
                            $this->load->view('desktop/user/header',            $data_header);
                            $this->load->view('desktop/profile/page__company_found',  $data_content);
                            $this->load->view('desktop/user/footer',            $data_footer);

                        endif;

                        return;

                    }


                    if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                        $this->load->view('mobile/user/head',       $data_head);
                        $this->load->view('mobile/profile/page__company_add',       array("page_header"  => $data_header, "page_content" => $data_content ) );
                        $this->load->view('mobile/user/footer',     $data_footer);

                    else:

                        $this->load->view('desktop/user/head',              $data_head);
                        $this->load->view('desktop/user/header',            $data_header);
                        $this->load->view('desktop/profile/page__company_add',  $data_content);
                        $this->load->view('desktop/user/footer',            $data_footer);

                    endif;


                }

            //  Добавление компании, шаг 2. Заполнение данных и внесение их в БД
            }

            elseif( $this->input->post('action') == 'add_company_step_2' ) {

                $post_inn       = $this->input->post('inn');


                $company__dadata_copy   = $this->Company_model->get_dadata_suggest( array('query' => $post_inn ), $post_inn  ) ;


                if ( $company__dadata_copy ) {
                    $insert_data = array(
                        'full_name'     => $company__dadata_copy['data']['name']['full_with_opf'],
                        'short_name'    => $company__dadata_copy['data']['name']['short_with_opf'],
                        'director'      => $this->session->user,
                        'ogrn'          => $company__dadata_copy['data']['ogrn'],
                        'inn'           => $company__dadata_copy['data']['inn']
                    );

                    if( $company__dadata_copy['data']['type'] == 'INDIVIDUAL') :
                        $insert_data['org_type']        = 'INDIVIDUAL';
                        $insert_data['manager']         = $company__dadata_copy['data']['name']['full'];
                        $insert_data['manager_post']    = $company__dadata_copy['data']['opf']['full'];
                        $insert_data['active']          = 1;
                        $insert_data['exdor_code']      = 0;
                    elseif( $company__dadata_copy['data']['type'] == 'ORGANIZATION' || $company__dadata_copy['data']['type'] == 'LEGAL' ) :
                        $insert_data['org_type']        = 'LEGAL';
                        $insert_data['manager']         = $company__dadata_copy['data']['management']['name'];
                        $insert_data['manager_post']    = $company__dadata_copy['data']['management']['post'];
                        $insert_data['kpp']             = $company__dadata_copy['data']['kpp'];
                        $insert_data['u_address']       = $company__dadata_copy['data']['address']['value'];

                        if($this->input->post('f_address')){    /*  ФАКТИЧЕСКИЙ И ПОЧТОЫВЙ АДРЕС  */
                            $insert_data['f_address'] = $this->input->post('f_address');
                        }
                        if($this->input->post('p_address')){
                            $insert_data['p_address'] = $this->input->post('p_address');
                        }

                    endif;

                    /*  ТИП КОМПАНИИ  */


                    if($this->input->post('company_sell')){
                        $insert_data['type'] = 'sell';
                    }
                    if($this->input->post('company_buy')){
                        $insert_data['type'] = 'buy';
                    }
                    if($this->input->post('company_buy') && $this->input->post('company_sell')){
                        $insert_data['type'] = 'all';
                    }

                    /*  С КАКИМИ БРЕНДАМИ РАБОТАЕТ  */
                    if($this->input->post('brand')){
                        $insert_data['brands'] = $this->input->post('brand');
                    }

                    /*  КОНТАКТНАЯ ИНФОРМАЦИЯ  */
                    if($this->input->post('phone')){
                        $insert_data['phone'] = $this->input->post('phone');
                    }
                    if($this->input->post('email')){
                        $insert_data['email'] = $this->input->post('email');
                    }

                    if( $this->input->post('site') ) {
                        $site_name      =   $this->input->post('site');
                        // Оставляем протокол, или добавляем если его нет
                        preg_match( '/^(https?:\/\/)/', $site_name, $post__company_site);
                        if( is_array($post__company_site) && empty($post__company_site) ){
                            $insert_data['site'] = 'http://'.$site_name;
                        } else
                            $insert_data['site'] = $site_name;
                    }

                    if($this->input->post('city')){
                        $insert_data['city'] = $this->input->post('city');
                    }
                    if($this->input->post('description')){
                        $insert_data['description'] = $this->input->post('description');
                    }



                    /*      БАНКОВСКАЯ ИНФОРМАЦИЯ        */
                    if($this->input->post('r_account')){
                        $insert_data['r_account'] = $this->input->post('r_account');
                    }
                    if($this->input->post('k_account')){
                        $insert_data['k_account'] = $this->input->post('k_account');
                    }
                    if($this->input->post('bank_bik')){
                        $insert_data['bank_bik'] = $this->input->post('bank_bik');
                    }
                    if($this->input->post('bank_name')){
                        $insert_data['bank_name'] = $this->input->post('bank_name');
                    }








                    $company_id     = $this->Company_model->add_company( $insert_data );

                    $system_email   = $this->Option_model->get_option( 'system_email' );
                    $this->load->library('email');
                    $this->email->from(     'robot@exdor.ru', 'Exdor'   );
                    $this->email->to(       $system_email );
                    $this->email->subject(  'Exdor.ru - Добавлена новая компания'  );
                    $this->email->message(  'Это уведомление о том, что пользователь добавил новую заявку!' );
                    $this->email->send();


                    $this->load->library('upload');             // Библиотека для загрузки аватара

                    // Создаем директорию для пользователя
                    $company_dir = './uploads/companies/'.$company_id;
                    if( !is_dir($company_dir) ) {
                        mkdir($company_dir);
                        mkdir($company_dir.'/logo');
                        mkdir($company_dir.'/park');
                        mkdir($company_dir.'/others');
                        mkdir($company_dir.'/ads');
                    }

                    $config_upload['upload_path'] = $company_dir.'/logo';
                    $config_upload['allowed_types'] = 'gif|jpg|png|jpeg';
                    $config_upload['max_size'] = '8000';
                    $config_upload['max_width'] = '5000';
                    $config_upload['max_height'] = '5000';

                    $this->upload->initialize($config_upload);

                    if ( $this->upload->do_upload('logo')) {
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

                        $this->Company_model->update_company( $company_id, $update_data );


                    }

                    if( $company__dadata_copy['data']['type'] == 'INDIVIDUAL' ) {
                        redirect('/company', 'refresh', 302);
                    } else {
                        redirect('/profile/company', 'refresh', 302);
                    }


                } else {
                    echo 'произошла ошибка, мы не можем проверить подлинность информации';
                }



            }

            else {
                echo 'произошла ошибка';
            }





        } else {
            redirect('/', 'refresh', 302);
        }
    }

    public function security() {

        if( $this->router->user_lang == 'ru' ){
            $this->lang->load('main', 'russian');
        } elseif ( $this->router->user_lang == 'en' ) {
            $this->lang->load('main', 'english');
        }

        $data_head['is_home_page']          = false;
        if ( $this->User_model->is_auth_user() ) {
            $data_head['meta_data']             = array(
                'title'         => 'Безопасность профиля',
                'keywords'      => '',
                'description'   => ''
            );
            $data_header = array(
                'usd'           => $this->Option_model->get_option("cbr_usd"),
                'eur'           => $this->Option_model->get_option("cbr_eur"),
                'body_class'    => 'page-content-form__wrap'
            );
            $data_footer = array(
                'notifications' => $this->Notification_model->get_notifications( $this->session->user )
            );
            $data_content = array(
                'menu'          => array(
                    'selected'          => 'profile',
                    'new_messages'      => $this->Message_model->count_unread_dialogs($this->session->user),
                    'new_partners'      => $this->Partner_model->get_inbox_partners_count($this->session->user),
                    'active_requests'   => $this->Request_model->count_active_requests($this->session->user),
                ),
            );

            $user   = $this->User_model->get_user_by_id( $this->session->user );
            if( $user->company_id )
                if ( $user->id == $this->Company_model->get_company_director_id( $user->company_id ) ) {
                    $data_content['menu']['new_employers']  = $this->Company_model->count_company_candidats( $user->company_id );
                }



            $data_content['user']   = $this->User_model->get_user_by_id( intval( $this->session->user ) );

            if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                $this->load->view('mobile/user/head',       $data_head);
                $this->load->view('mobile/profile/page__security',    array("page_header"  => $data_header, "page_content" => $data_content ) );
                $this->load->view('mobile/user/footer',     $data_footer);

            else:
                $this->load->view('desktop/user/head',              $data_head);
                $this->load->view('desktop/user/header',            $data_header);
                $this->load->view('desktop/profile/page__security', $data_content);
                $this->load->view('desktop/user/footer',            $data_footer);
            endif;

        } else {
            redirect('/', 'refresh', 302);
        }
    }

    public function plan( $invoice = '') {

        if( $this->router->user_lang == 'ru' ){
            $this->lang->load('main', 'russian');
        } elseif ( $this->router->user_lang == 'en' ) {
            $this->lang->load('main', 'english');
        }

        $data_head['is_home_page']          = false;

        if ( $this->User_model->is_auth_user() ) {
            $data_head['meta_data']             = array(
                'title'         => 'Тарифный план',
                'keywords'      => '',
                'description'   => ''
            );
            $data_header = array(
                'usd'           => $this->Option_model->get_option("cbr_usd"),
                'eur'           => $this->Option_model->get_option("cbr_eur"),
                'body_class'    => 'page-content-form__wrap'
            );
            $data_footer = array(
                'notifications' => $this->Notification_model->get_notifications( $this->session->user )
            );
            $data_content = array(
                'menu'          => array(
                    'selected'          => 'profile',
                    'new_messages'      => $this->Message_model->count_unread_dialogs($this->session->user),
                    'new_partners'      => $this->Partner_model->get_inbox_partners_count($this->session->user),
                    'active_requests'   => $this->Request_model->count_active_requests($this->session->user),
                ),
            );

            $user   = $this->User_model->get_user_by_id( $this->session->user );
            if( $user->company_id )
                if ( $user->id == $this->Company_model->get_company_director_id( $user->company_id ) ) {
                    $data_content['menu']['new_employers']  = $this->Company_model->count_company_candidats( $user->company_id );
                }



            if( $invoice == 'invoice' ) {

                $post_summ      = $this->input->post('invoice_summ');
                $post_fio       = $this->input->post('invoice_fio');
                $post_address   = $this->input->post('invoice_address');

                $pdf    = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

                $s  = 0;

                $pdf->SetPrintHeader(false);
                $pdf->SetPrintFooter(false);

                $pdf->AddPage();
                $pdf->setFontStretching(105);
                $pdf->SetFont('freesans', 'B', 9);
                $pdf->Text(20, 22, 'Извещение' );
                $pdf->Text(23, 81, 'Кассир' );
                $pdf->Text(20, 142,'Квитанция' );
                $pdf->Text(23, 151, 'Кассир' );

                $pdf->SetFont('freesans', 'B', 8);
                $pdf->Text(54, 22, 'СБЕРБАНК РОССИИ' );
                $pdf->SetFont('freesans', '', 5);
                $pdf->Text(54, 26, 'Основан в 1841 году' );

                $pdf->SetFont('freesans', 'I', 5);
                $pdf->Text(178.5, 23, 'Форма № ПД-4' );

                $pdf->SetDrawColor(0);
                $pdf->SetLineWidth(0.3);

                $pdf->Line(9,20,197,20);
                $pdf->Line(197,20,197,160);
                $pdf->Line(9,20,9,160);
                $pdf->Line(9,160,197,160);
                $pdf->Line(9,90,197,90);
                $pdf->Line(50.7,20,50.7,160);

                $pdf->Line(55,$s+26,87,$s+26);

//для двух проходов: нижнего и верхнего
                $s_arr = array(-0.5, 70);
                foreach($s_arr as $s)
                {
//Линии
                    $pdf->Line(55,$s+32,192,$s+32);


                    $pdf->Line(55,$s+35,103,$s+35);
                    $pdf->Line(55,$s+39,103,$s+39);

                    $a=55;
                    for($i=0; $i<13; $i++)
                    {
                        $pdf->Line($a,$s+35,$a,$s+39);
                        $a = $a+4;
                    }

                    $pdf->Line(112,$s+35,192,$s+35);
                    $pdf->Line(112,$s+39,192,$s+39);

                    $a=192;
                    for($i=0; $i<21; $i++)
                    {
                        $pdf->Line($a,$s+35,$a,$s+39);
                        $a = $a-4;
                    }

                    $pdf->Line(156,$s+42,192,$s+42);
                    $pdf->Line(156,$s+46,192,$s+46);
                    $pdf->Line(60,$s+46,144,$s+46);

                    $a=192;
                    for($i=0; $i<10; $i++)
                    {
                        $pdf->Line($a,$s+42,$a,$s+46);
                        $a = $a-4;
                    }

                    $pdf->Line(112,$s+47,192,$s+47);
                    $pdf->Line(112,$s+51,192,$s+51);

                    $a=192;
                    for($i=0; $i<21; $i++)
                    {
                        $pdf->Line($a,$s+47,$a,$s+51);
                        $a = $a-4;
                    }

                    $pdf->Line(55,$s+55,128,$s+55);
                    $pdf->Line(136,$s+55,192,$s+55);

                    $pdf->Line(88,$s+62,192,$s+62);
                    $pdf->Line(88,$s+67,192,$s+67);

                    $pdf->Line(80,$s+73,95,$s+73);
                    $pdf->Line(103,$s+73,110,$s+73);

                    $pdf->Line(164,$s+73,173,$s+73);
                    $pdf->Line(180,$s+73,185,$s+73);

                    $pdf->Line(66,$s+78,81,$s+78);
                    $pdf->Line(89,$s+78,96,$s+78);
                    $pdf->Line(140,$s+78,148,$s+78);
                    $pdf->Line(151,$s+78,180,$s+78);
                    $pdf->Line(186,$s+78,189,$s+78);
                    $pdf->Line(150,$s+88.6,192,$s+88.6);

//ТЕКСТЫ
                    $pdf->SetFont('freesans', '', 6);

                    $pdf->Text(104, $s+32, '(наименование получателя платежа)' );

                    $pdf->SetFont('freesans', '', 6);
                    $pdf->Text(65, $s+39, '(ИНН получателя платежа)' );
                    $pdf->Text(135, $s+39,'(номер счета получателя платежа)' );

                    $pdf->SetFont('freesans', '', 8);

                    $pdf->Text(148, $s+42.5, 'БИК' );

                    $pdf->SetFont('freesans', '', 7);
                    $pdf->Text(55, $s+47, 'Номер кор./сч.банка получателя платежа' );

                    $pdf->SetFont('freesans', 'B', 9);
                    $pdf->Text(60, $s+51, 'пополнение счета #'.$this->session->user. ' на exdor.ru' );

                    $pdf->SetFont('freesans', '', 6);
                    $pdf->Text(80, $s+55,'(наименование платежа)' );
                    $pdf->Text(141, $s+55, '(номер лицевого счета (код) плательщика)' );

                    $pdf->SetFont('freesans', '', 8);
                    $pdf->Text(55, $s+59, 'Ф.И.О. Плательщика' );

                    $pdf->SetFont('freesans', '', 8);
                    $pdf->Text(55, $s+64, 'Адрес плательщика' );

                    $pdf->SetFont('freesans', '', 8);
                    $pdf->Text(55, $s+70, 'Сумма платежа' );
                    $pdf->Text(96, $s+70, 'руб.' );
                    $pdf->Text(110, $s+70, 'коп.' );

                    $pdf->Text(130, $s+70, 'Сумма платы за услуги' );

                    $pdf->Text(173, $s+70, 'руб.' );
                    $pdf->Text(185, $s+70, 'коп.' );
                    $pdf->Text(55, $s+75, 'Итого' );
                    $pdf->Text(82, $s+75, 'руб.' );
                    $pdf->Text(96, $s+75, 'коп.' );
                    $pdf->Text(138, $s+75, '"' );
                    $pdf->Text(147, $s+75, '"' );
                    $pdf->Text(180, $s+75, '201' );
                    $pdf->Text(189, $s+75, 'г.' );

                    $pdf->SetFont('freesans', '', 6);
                    $pdf->Text(55, $s+80, 'С условиями приема указанной в платежном документе суммы, в т.ч. с суммой взимаемой платы за услуги' );
                    $pdf->Text(55, $s+83, 'банка, ознакомлен и согласен' );

                    $pdf->SetFont('freesans', 'B', 7);
                    $pdf->Text(119, $s+85, 'Подпись плательщика' );

//Заполняем данные предприятия

                    $pdf->SetFont('freesans', '', 10);
                    $pdf->Text(61, $s+28, 'Индивидуальный предприниматель Кукареков Николай Владимирович' );

//Банк

                    $pdf->SetFont('freesans', '', 7);
                    $pdf->Text(55, $s+42.5, 'в' );
                    $pdf->Text(59, $s+42.5, 'Северо-Западный банк ОАО "Сбербанк России"  г.Санкт-Петербург' );

//Заполняем данные клиента

                    $fio        = $post_fio;
                    $summa_rub  = $post_summ;
                    $summa_kop  = "00";

                    $id_order = 298777;

                    $pdf->SetFont('freesans', 'B', 10);

//ИНН получателя платежа (12-значный)

                    $a=55;
                    $arr = array(4,8,2,0,0,1,5,6,8,0,1,1);
                    for($i=0; $i<12; $i++)
                    {
                        $pdf->Text($a, $s+34.8, $arr[$i]);
                        $a = $a + 4;
                    }

//номер счета получателя платежа (20-значный)

                    $a=112;
                    $arr = array(4,0,8,0,2,8,1,0,2,5,5,1,4,0,0,0,0,5,7,7);
                    for($i=0; $i<20; $i++)
                    {
                        $pdf->Text($a, $s+34.8, $arr[$i]);
                        $a = $a + 4;
                    }

//БИК (9-значный)

                    $a=156;
                    $arr = array(0,4,4,0,3,0,6,5,3);
                    for($i=0; $i<9; $i++)
                    {
                        $pdf->Text($a, $s+42, $arr[$i]);
                        $a = $a + 4;
                    }

//Номер кор./сч.банка получателя платежа (20-значный)

                    $a=112;
                    $arr = array(3,0,1,0,1,8,1,0,5,0,0,0,0,0,0,0,0,6,5,3);
                    for($i=0; $i<20; $i++)
                    {
                        $pdf->Text($a, $s+46.7, $arr[$i]);
                        $a = $a + 4;
                    }

                    $pdf->SetFont('freesans', '', 10);

                    $pdf->Text(88, $s+58, $fio);
                    $pdf->Text(88, $s+63, $post_address);
                    $pdf->Text(80, $s+69, $summa_rub);
                    $pdf->Text(103.5, $s+69,  $summa_kop);
                }

                $pdf->Output(uniqid(), 'I');
            }

            elseif ( $invoice == 'invoice2') {


                $this->load->library('Pdf');
                $pdf    = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);

                $s  = 0;

                $pdf->SetPrintHeader(false);
                $pdf->SetPrintFooter(false);

                $pdf->AddPage('P', 'A4');
                $pdf->SetFont('freesans', '', 8);

                $pdf->Text(10, 22,'Получатель:' );
                $pdf->Text(10, 26,'ИНН:' );
                $pdf->Text(10, 30,'Рассчетный счет:' );
                $pdf->Text(10, 34,'Коор. счет:' );
                $pdf->Text(10, 38,'БИК:' );
                $pdf->Text(10, 42,'Банк:' );

                $pdf->Text(10, 50,'Отправитель:' );
                $pdf->Text(10, 54,'Адрес:' );
                $pdf->Text(10, 58,'ИНН:' );
                $pdf->Text(10, 62,'КПП:' );
                $pdf->Text(10, 66,'Рассчетный счет:' );
                $pdf->Text(10, 70,'Коор. счет:' );
                $pdf->Text(10, 74,'БИК:' );
                $pdf->Text(10, 78,'Банк:' );



                $pdf->SetFont('freesans', 'B', 10);
                $pdf->Text(80, 87,'Счет №XXXX от XX.XX.XXXX' );

                //  Горизонтальные линии таблицы
                $pdf->Line(10,100,197,100);
                $pdf->Line(10,110,197,110);
                $pdf->Line(10,120,197,120);
                $pdf->Line(10,127,197,127);

                //  Вертикальные линии таблицы
                $pdf->Line(10,100,10,127);
                $pdf->Line(20,100,20,120);
                $pdf->Line(90,100,90,120);
                $pdf->Line(110,100,110,127);
                $pdf->Line(137,100,137,127);
                $pdf->Line(167,100,167,127);
                $pdf->Line(197,100,197,127);

                //  Заголовки таблицы
                $pdf->SetFont('freesans', 'B', 8);
                $pdf->Text(12, 102,'#' );
                $pdf->Text(22, 102,'Наименование' );
                $pdf->Text(92, 102,'Ед. изм.' );
                $pdf->Text(112, 102,'Кол-во' );
                $pdf->Text(139, 102,'Цена' );
                $pdf->Text(169, 102,'Сумма' );

                //  Подвал таблицы
                $pdf->Text(22, 122,'Итого' );

                //  Значения таблицы
                $pdf->SetFont('freesans', '', 8);
                $pdf->Text(12, 112,'1' );
                $pdf->Text(22, 112,'Пополнение баланса на сайте exdor.ru' );
                //$pdf->Text(92, 112,'' );
                $pdf->Text(112, 112,'1' );
                $pdf->Text(139, 112,'20 000,00' );
                $pdf->Text(169, 112,'20 000,00' );

                //  Значения итого
                $pdf->SetFont('freesans', 'B', 8);
                $pdf->Text(112, 122,'1' );
                $pdf->Text(169, 122,'20 000,00' );


                //  Подвал
                $pdf->Text(10, 152,'Руководитель' );
                $pdf->Line(33,155,70,155);

                $pdf->Text(112, 152,'Бухгалтер' );
                $pdf->Line(129,155,166,155);

                $pdf->Output(uniqid(), 'I');


            }



            else {

                $data_content['user']   = $this->User_model->get_user_by_id( intval( $this->session->user ) );



                if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                    $this->load->view('mobile/user/head',       $data_head);
                    $this->load->view('mobile/profile/page__plan',    array("page_header"  => $data_header, "page_content" => $data_content ) );
                    $this->load->view('mobile/user/footer',     $data_footer);

                else:
                    $this->load->view('desktop/user/head',              $data_head);
                    $this->load->view('desktop/user/header',            $data_header);
                    $this->load->view('desktop/profile/page__plan',     $data_content);
                    $this->load->view('desktop/user/footer',            $data_footer);
                endif;


            }


        } else {
            redirect('/', 'refresh', 302);
        }

    }
}