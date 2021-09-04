<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 07.07.16
 * Time: 13:33
 */

class Company extends CI_Controller
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
        $user = $this->User_model->get_user_by_id( intval( $this->session->user ) );
        if(!$user)
        {
            $this->User_model->user_logout();
            redirect('/', 'refresh');
        }
        $this->User_model->online_checker( $this->session->user );
        $this->Notification_model->target_complete($this->session->user, 'company');
    }

    public function index( $company_id = '', $news_id = 0 )
    {
        if( $this->router->user_lang == 'ru' ){
            $this->lang->load('main', 'russian');
        } elseif ( $this->router->user_lang == 'en' ) {
            $this->lang->load('main', 'english');
        }

        if ( $this->User_model->is_auth_user() ) {


            $user = $this->User_model->get_user_by_id( intval( $this->session->user ) );
            if(!$user)
            {
                $this->User_model->user_logout();
                redirect('/', 'refresh');
            }

            if( $company_id ) {
                $data_head['is_home_page']          = false;
                $data_head['meta_data']             = array(
                    'title'         => 'Профиль компании',
                    'keywords'      => '',
                    'description'   => ''
                );
                $data_header = array(
                    'usd'           => $this->Option_model->get_option("cbr_usd"),
                    'eur'           => $this->Option_model->get_option("cbr_eur"),
                    'body_class'    => 'js--news js--news-company',
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
                        'selected'          => 'company',
                        'new_messages'      => $this->Message_model->count_unread_dialogs($this->session->user),
                        'new_partners'      => $this->Partner_model->get_inbox_partners_count($this->session->user),
                        'active_requests'   => $this->Request_model->count_active_requests($this->session->user),
                    ),
                    'roles'     => $this->Option_model->get_directory('role'),
                );
                if( $user->company_id )
                    if ( $user->id == $this->Company_model->get_company_director_id( $user->company_id ) ) {
                        $data_content['menu']['new_employers']  = $this->Company_model->count_company_candidats( $user->company_id );
                    }

                $data_content['user']       = $user;
                $data_content['company']    = $this->Company_model->get_company_by_id( $company_id  );

                if( !$data_content['company'] ) {
                    show_404();
                    return;
                }


                if(  $data_content['company']->active == 0) {

                    if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                        $this->load->view('mobile/user/head',       $data_head);
                        $this->load->view('mobile/company/page__on_moderation',  array("page_header"  => $data_header, "page_content" => $data_content ) );
                        $this->load->view('mobile/user/footer',     $data_footer);

                    else:

                        $this->load->view('desktop/user/head',                  $data_head);
                        $this->load->view('desktop/user/header',                $data_header);
                        $this->load->view('desktop/company/page__on_moderation',    $data_content);
                        $this->load->view('desktop/user/footer',                $data_footer);

                    endif;

                    return;
                }

                $data_content['company_news']   = $this->News_model->get_news( array('company_id' => $company_id, 'type' => 'lenta') );

                if( $news_id && $news_id != 0)
                {
                    $data_content['current_news']       = $this->News_model->get_news_item( $news_id );
                    $data_content['current_news_id']    = $news_id;
                }
                else
                {
                    $data_content['current_news']       = false;
                    $data_content['current_news_id']    = 0;
                }

                $data_content['has_company_news']       = $this->News_model->has_company_news( $company_id );
                $data_content['has_employers_news']     = $this->News_model->has_employers_news( $company_id );


                // Для публикования новостей от лица компании
                $data_content['news_from_company']  = true;


                $data_content['candidats']          = $this->Company_model->get_company_candidats( $company_id  );
                $data_content['employers']          = $this->Company_model->get_company_employers( $company_id  );

                $data_content['company_requests']   = $this->Request_model->get_company_requests( $company_id  );




                if( $data_content['company']->removed == 1):

                    if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                        $this->load->view('mobile/user/head',       $data_head);
                        $this->load->view('mobile/company/page__removed',  array("page_header"  => $data_header, "page_content" => $data_content ) );
                        $this->load->view('mobile/user/footer',     $data_footer);

                    else:

                        $this->load->view('desktop/user/head',                  $data_head);
                        $this->load->view('desktop/user/header',                $data_header);
                        $this->load->view('desktop/company/page__removed',      $data_content);
                        $this->load->view('desktop/user/footer',                $data_footer);

                    endif;

                else:

                    if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                        $this->load->view('mobile/user/head',       $data_head);
                        $this->load->view('mobile/company/page',  array("page_header"  => $data_header, "page_content" => $data_content ) );
                        $this->load->view('mobile/user/footer',     $data_footer);

                    else:

                        $this->load->view('desktop/user/head',                  $data_head);
                        $this->load->view('desktop/user/header',                $data_header);
                        $this->load->view('desktop/company/page',               $data_content);
                        $this->load->view('desktop/user/footer',                $data_footer);

                    endif;

                endif;



            }
            else
            {

                if( $user->company_id )
                    redirect('/company/id'.$user->company_id, '302');
                else
                    redirect('/profile/company', 'refresh');
                /*
                if($this->session->company)
                {
                    redirect('/company/id_'.$this->session->company, 'refresh');
                } else {
                    echo "Что-то не так. Обратитесь к администратору. В сессии нет информации о компании, и не задан ее id";
                    die();
                }
                */


                /*
                 *
                 *
                 *      Похоже, этот код работать не будет
                 *
                 *
                 *
                $data_head['is_home_page']          = false;
                $data_head['meta_data']             = array(
                    'title'         => 'Моя компания',
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
                    'menu' => array(
                        'selected'          => 'company',
                        'new_messages'      => $this->Message_model->count_unread_dialogs($this->session->user),
                        'new_partners'      => $this->Partner_model->get_inbox_partners_count($this->session->user),
                        'active_requests'   => $this->Request_model->count_active_requests($this->session->user),
                    ),
                    'roles'     => $this->Option_model->get_directory('role'),
                );
                if( $user->company_id )
                    if ( $user->id == $this->Company_model->get_company_director_id( $user->company_id ) ) {
                        $data_content['menu']['new_employers']  = $this->Company_model->count_company_candidats( $user->company_id );
                    }

                $data_content['roles'] = $this->Option_model->get_directory('role');
                $user = $this->User_model->get_user_by_id( intval( $this->session->user ) );
                if(!$user)
                {
                    $this->User_model->user_logout();
                    redirect('/', 'refresh');
                }
                $data_content['user']           = $user;
                $data_content['company_news']   = false;
                if( $data_content['user']->company_id )
                {
                    $data_content['company']        = $this->Company_model->get_company_by_id( $data_content['user']->company_id  );

                    if( $data_content['company']->active == 0 )
                        redirect('/profile/company', 'refresh');

                    $data_content['company_news']   = $this->News_model->get_news( array('company_id' => $data_content['company']->id, 'type' => 'lenta' ) );

                    $data_content['candidats']      = $this->Company_model->get_company_candidats( $data_content['user']->company_id  );
                    $data_content['employers']      = $this->Company_model->get_company_employers( $data_content['user']->company_id  );

                    $this->load->view('desktop/user/head',      $data_head);
                    $this->load->view('desktop/user/header',    $data_header);
                    $this->load->view('desktop/company/page',   $data_content);
                    $this->load->view('desktop/user/footer',    $data_footer);

                }
                else
                {
                    redirect('/profile/company', 'refresh', 302);
                }
                */
            }
        }
        else
        {
            redirect('/', 'refresh', 302);
        }
    }

    public function edit()
    {
        if( $this->router->user_lang == 'ru' ){
            $this->lang->load('main', 'russian');
        } elseif ( $this->router->user_lang == 'en' ) {
            $this->lang->load('main', 'english');
        }

        if ( $this->User_model->is_auth_user() )
        {
            $data_head['is_home_page'] = false;
            $data_head['meta_data'] = array(
                'title'         => 'Изменение данных о компании',
                'keywords'      => '',
                'description'   => ''
            );
            $data_header = array(
                'usd'               => $this->Option_model->get_option("cbr_usd"),
                'eur'               => $this->Option_model->get_option("cbr_eur"),
                'body_class'        => 'page-content-form__wrap',
                'search_or_link'    => array(
                    'type'      => 'link',
                    'url'       => '/company',
                    'title'     => 'На страницу компании'
                )
            );

            $data_footer = array(
                'notifications' => $this->Notification_model->get_notifications( $this->session->user )
            );
            $data_content = array(
                'menu' => array(
                    'selected'          => 'company',
                    'new_messages'      => $this->Message_model->count_unread_dialogs($this->session->user),
                    'new_partners'      => $this->Partner_model->get_inbox_partners_count($this->session->user),
                    'active_requests'   => $this->Request_model->count_active_requests($this->session->user),
                ),
                'roles'     => $this->Option_model->get_directory('role'),
            );

            $user = $this->User_model->get_user_by_id(intval($this->session->user));

            if (!$user) {
                $this->User_model->user_logout();
                redirect('/', 'refresh');
            }

            if( $user->company_id )
                if ( $user->id == $this->Company_model->get_company_director_id( $user->company_id ) ) {
                    $data_content['menu']['new_employers']  = $this->Company_model->count_company_candidats( $user->company_id );
                }
                else {
                    redirect('/company/', 'refresh');
                }
            else redirect('/company/', 'refresh');



            $company    = $this->Company_model->get_company_by_id( $user->company_id );

            if( $this->input->post('action') == 'update_company' ) {



                $insert_candidats   = $this->input->post('candidat');

                if ( is_array($insert_candidats) && !empty($insert_candidats) ) {
                    foreach( $insert_candidats as $i_cand_key => $i_cand_val) {

                        if( count($i_cand_val) == 2 &&  $i_cand_val[0] != '' && !ctype_space($i_cand_val[0]) && $i_cand_val[1] != '' && !ctype_space($i_cand_val[1])) {
                            $i_cand_data     = array(
                                'company_status'        => 'accepted',
                                'company_role'          => $i_cand_val[0],
                                'company_profession'    => $i_cand_val[1]
                            );
                            $this->User_model->update_user_info($i_cand_key, $i_cand_data);
                        }
                    }
                }




                $update_employers   = $this->input->post('employer');

                if ( is_array($update_employers) && !empty($update_employers) ) {
                    foreach( $update_employers as $u_emp_key => $u_emp_val) {

                        if( count($u_emp_val) == 2 && $u_emp_val[0] != '' && !ctype_space($u_emp_val[0]) && $u_emp_val[1] != '' && !ctype_space($u_emp_val[1]) ) {
                            $u_emp_data     = array(
                                'company_role'          => $u_emp_val[0],
                                'company_profession'    => $u_emp_val[1]
                            );
                            $this->User_model->update_user_info($u_emp_key, $u_emp_data);
                        }

                    }
                }





                $update_data = array();

                $company_id                     = $this->input->post('company_id');

                if( $this->input->post('brand') )
                    $update_data['brands']       = $this->input->post('brand');

                if( $this->input->post('phone') )
                    $update_data['phone']       = $this->input->post('phone');
                if( $this->input->post('email') )
                    $update_data['email']       = $this->input->post('email');
                if( $this->input->post('site') ) {
                    $site_name      =   $this->input->post('site');
                    // Оставляем протокол, или добавляем если его нет
                    preg_match( '/^(https?:\/\/)/', $site_name, $post__company_site);
                    if( is_array($post__company_site) && empty($post__company_site) ){
                        $update_data['site'] = 'http://'.$site_name;
                    } else
                        $update_data['site'] = $site_name;
                }


                if( $this->input->post('company_buy') == 'buy' && $this->input->post('company_sell') == 'sell' )
                    $update_data['type']        = 'all';
                elseif ( $this->input->post('company_buy') == 'buy' )
                    $update_data['type']        = 'buy';
                elseif ( $this->input->post('company_sell') == 'sell' )
                    $update_data['type']        = 'sell';

                if( $this->input->post('r_account') )
                    $update_data['r_account']   = $this->input->post('r_account');
                if( $this->input->post('k_account') )
                    $update_data['k_account']   = $this->input->post('k_account');
                if( $this->input->post('bank_bik') )
                    $update_data['bank_bik']    = $this->input->post('bank_bik');
                if( $this->input->post('bank_name') )
                    $update_data['bank_name']   = $this->input->post('bank_name');

                if( $this->input->post('f_address') )
                    $update_data['f_address']   = $this->input->post('f_address');
                if( $this->input->post('p_address') )
                    $update_data['p_address']   = $this->input->post('p_address');

                if( $this->input->post('city') )
                    $update_data['city']        = $this->input->post('city');
                if( $this->input->post('description') )
                    $update_data['description'] = $this->input->post('description');






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

                }


                $this->Company_model->update_company( $company_id, $update_data);

                redirect( '/company/id'.$company_id, '302');
                
            }


            $data_content['user']           = $user;
            $data_content['company']        = $company;
            $data_content['brands']         = $this->Option_model->get_directory('brand', true);
            $data_content['employers']      = $this->Company_model->get_company_employers($data_content['user']->company_id);
            $data_content['candidats']      = $this->Company_model->get_company_candidats($data_content['user']->company_id);



            if ( $company->approved == 'not_approved' || $company->removed == 1 ):

                if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                    $this->load->view('mobile/user/head',                           $data_head);
                    $this->load->view('mobile/company/page__edit__not_approved',    array("page_header"  => $data_header, "page_content" => $data_content ) );
                    $this->load->view('mobile/user/footer',                         $data_footer);

                else:

                    $this->load->view('desktop/user/head',                          $data_head);
                    $this->load->view('desktop/user/header',                        $data_header);
                    $this->load->view('desktop/company/page__edit__not_approved',   $data_content);
                    $this->load->view('desktop/user/footer',                        $data_footer);

                endif;

            elseif ($data_content['company']->approved == 'approved'):

                if( $this->agent->is_mobile() && !$this->session->has_userdata('pc_view') ):

                    $this->load->view('mobile/user/head',                   $data_head);
                    $this->load->view('mobile/company/page__edit',          array("page_header"  => $data_header, "page_content" => $data_content ) );
                    $this->load->view('mobile/user/footer',                 $data_footer);

                else:

                    $this->load->view('desktop/user/head',                  $data_head);
                    $this->load->view('desktop/user/header',                $data_header);
                    $this->load->view('desktop/company/page__edit',         $data_content);
                    $this->load->view('desktop/user/footer',                $data_footer);

                endif;

            endif;

        }
        else
        {
            redirect('/', 'refresh', 302);
        }
    }
}