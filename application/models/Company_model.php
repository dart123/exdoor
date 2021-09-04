<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 26.07.16
 * Time: 19:58
 */

class Company_model extends CI_Model {

    public function get_company_by_id($id)
    {
        $query = $this->db      ->select('
                                    comp.id,
                                    comp.logo,
                                    comp.full_name,
                                    comp.short_name,
                                    comp.u_address,
                                    comp.f_address,
                                    comp.p_address,
                                    comp.type,
                                    comp.inn,
                                    comp.kpp,
                                    comp.ogrn,
                                    comp.director,
                                    comp.manager,
                                    comp.manager_post,
                                    comp.phone,
                                    comp.email,
                                    comp.site,
                                    comp.bank_bik,
                                    comp.bank_name,
                                    comp.r_account,
                                    comp.k_account,
                                    comp.city,
                                    comp.description,
                                    comp.rating_points,
                                    comp.rating_counts,
                                    (comp.rating_points/comp.rating_counts) as rating,
                                    comp.approved,
                                    comp.active,
                                    comp.exdor_code,
                                    comp.removed,
                                    city.name as city_name
                                ')
                                ->from('companies as comp')
                                ->join('data_city as city', 'comp.city = city.city_id')
                                ->where( array('id' => $id))
                                ->limit(1)
                                ->get();
        if($query->result())
        {
            foreach($query->result() as $result)
            {
                return $this->create_company($result);
            }
        }
        else return false;
    }

    public function get_company_by_inn($inn)
    {

        $query = $this->db      ->select('
                                    comp.id,
                                    comp.logo,
                                    comp.full_name,
                                    comp.short_name,
                                    comp.u_address,
                                    comp.f_address,
                                    comp.p_address,
                                    comp.type,
                                    comp.inn,
                                    comp.kpp,
                                    comp.ogrn,
                                    comp.director,
                                    comp.manager,
                                    comp.manager_post,
                                    comp.phone,
                                    comp.email,
                                    comp.site,
                                    comp.bank_bik,
                                    comp.bank_name,
                                    comp.r_account,
                                    comp.k_account,
                                    comp.city,
                                    comp.description,
                                    comp.rating_points,
                                    comp.rating_counts,
                                    (comp.rating_points/comp.rating_counts) as rating,
                                    comp.approved,
                                    comp.active,
                                    comp.exdor_code,
                                    comp.removed,
                                    city.name as city_name
                                ')
                                ->from('companies as comp')
                                ->join('data_city as city', 'comp.city = city.city_id')
                                ->where( array('inn' => $inn))
                                ->limit(1)
                                ->get();

        if($query->result())

        {
            foreach($query->result() as $result)
            {
                return $this->create_company($result);
            }
        } else return false;
    }

    public function get_companies( $filter  = array() ) {

        $limit          = false;    // Количество новостей для вывода
        if( array_key_exists("limit", $filter) && $filter['limit']  != 0 )
            $limit      = $filter['limit'];

        $offset         = false;    // Отступ (для пагинации)
        if( array_key_exists("offset", $filter) && $filter['offset']  != 0 )
            $offset     = $filter['offset'];

        $count_news         = false;    // Возвращаем только новости
        if( array_key_exists("count", $filter) && $filter['count']  = true )
            $count_news     = true;     // Возвращаем количество новосте


        $result = array();


        if( $limit )
            $this->db->limit( $limit );

        if( $offset )
            $this->db->offset( $offset );

        $this->db->    select('
                                    comp.id,
                                    comp.logo,
                                    comp.full_name,
                                    comp.short_name,
                                    comp.u_address,
                                    comp.f_address,
                                    comp.p_address,
                                    comp.type,
                                    comp.inn,
                                    comp.kpp,
                                    comp.ogrn,
                                    comp.director,
                                    comp.manager,
                                    comp.manager_post,
                                    comp.phone,
                                    comp.email,
                                    comp.site,
                                    comp.bank_bik,
                                    comp.bank_name,
                                    comp.r_account,
                                    comp.k_account,
                                    comp.city,
                                    comp.description,
                                    comp.rating_points,
                                    comp.rating_counts,
                                    (comp.rating_points/comp.rating_counts) as rating,
                                    comp.approved,
                                    comp.active,
                                    comp.exdor_code,
                                    comp.removed,
                                    city.name as city_name
                                ')
                                ->from('companies as comp')
                                ->join('data_city as city', 'comp.city = city.city_id');

        if( array_key_exists('keyword', $filter) && $filter['keyword'] != "" ):
            $keywords = $filter['keyword'];
            $this->db->group_start();
                $this->db->or_like('comp.full_name', $keywords );
                $this->db->or_like('comp.short_name', $keywords );
                $this->db->or_like('comp.site', $keywords );
                $this->db->or_like('comp.description', $keywords );
                $this->db->or_like('comp.manager', $keywords );
            $this->db->group_end();

/*
            $keywords = explode(" ", $filter['keyword']);
            $this->db->or_group_start();
            foreach( $keywords as $search_word):
                if( $search_word != ''):
                    $this->db->or_like('comp.full_name', $search_word, 'both' );
                    $this->db->or_like('comp.short_name', $search_word, 'both' );
                    $this->db->or_like('comp.site', $search_word, 'both' );
                    $this->db->or_like('comp.description', $search_word, 'both' );
                    $this->db->or_like('comp.manager', $search_word, 'both' );
                endif;
            endforeach;
            $this->db->group_end();
*/
        endif;

        $this->db->order_by('removed ASC, short_name ASC');

        $query  = $this->db->get();

        if($query->result()) {

            if ( $count_news ) {

                return $query->num_rows();

            } else {

                foreach ($query->result() as $row) {
                    $result[] = $this->create_company($row);
                }
                return $result;

            }
        }
        else
            return false;
    }

    public function get_company_name_by_id( $id ) {
        $this->db->select('short_name');
        $this->db->from('companies');
        $this->db->where('id', $id);

        $query = $this->db->get();
        if($query->result()) {
            foreach ($query->result() as $result) {
                return $result->short_name;
            }
        } else
            return false;
    }

    public function add_company( $insert_data )
    {
        if( array_key_exists('brands', $insert_data) ){
            $brands = $insert_data['brands'];
            unset( $insert_data['brands'] );
        }
        else
        {
            $brands = false;
        }

        $insert_data['approved']   = 'not_approved';
        $insert_data['phone']      = preg_replace("/[^0-9]/", '', $insert_data['phone'] );


        if( $insert_data['org_type'] == 'LEGAL' )
            $insert_data['exdor_code']  =   rand(10000, 99999);
        else
        {
            $insert_data['exdor_code']  = 0;
            $insert_data['active']      = 1;
        }


        $this->db->insert('companies', $insert_data );
        $insert_id = $this->db->insert_id();


        // Прокачиваем пользователя
        $user_data_update = array(
            'company_id'        => $insert_id,
            'company_status'    => 2,
            'company_role'      => 0,
            'company_profession'=> $insert_data['manager_post']
        );
        $this->User_model->update_user_info( $this->session->user, $user_data_update );



        // Добавляем бренды
        if( $brands )
        {
            foreach($brands as $brand)
            {
                $this->db->insert(
                    'companies_brands',
                    array(
                        'company_id'        => $insert_id,
                        'brand_id'          => $brand
                    )
                );
            }
        }
        return $insert_id;
    }

    public function update_company( $id, $data ) {

        if( array_key_exists('brands', $data) ){
            $brands = $data['brands'];
            unset( $data['brands'] );

            $this->db->delete('companies_brands', array( 'company_id' => $id) );

            foreach($brands as $brand)
            {
                $this->db->insert(
                    'companies_brands',
                    array(
                        'company_id'        => $id,
                        'brand_id'          => $brand
                    )
                );
            }
        }



        $this->db->where('id', $id);
        if ( $this->db->update('companies', $data) )
            return true;
        else
            return false;
    }

    /*  Функция позволяет убрать привязку к организации */
    public function enter_company( $user_id, $company_id ) {

        $is_ex_employer         = $this->is_ex_employer( $user_id, $company_id );
        $data = array(
            'company_id'        => $company_id,
            'company_status'    => 'not accepted',
            'company_role'      => 0,
            'company_profession'=> ''
        );

        $this->db->where('id', $user_id);
        if ( $this->db->update('users', $data) ) {

            if( $this->is_ex_employer( $user_id, $company_id) ) {

                if( $this->remove_ex_employer($user_id, $company_id) ) {
                    return true;
                }
                else
                    return false;

            }

            return true;
        }
        else
            return false;

    }

    /*  Функция позволяет убрать привязку к организации */
    public function leave_company( $user_id, $company_id ) {

        $data = array(
            'company_id'        => 0,
            'company_status'    => 'not accepted',
            'company_role'      => 0,
            'company_profession'=>''
        );

        if ( $this->User_model->update_user_info($user_id, $data) ) {

            if( !$this->is_ex_employer( $user_id, $company_id ) ) {

                if ( $this->set_ex_employer( $user_id, $company_id ) ) {
                    return true;
                }
                else
                    return false;

            }
            else
                return true;
        }

        else
            return false;

    }

    /*  Функция позволяет убрать привязку к организации */
    public function remove_company( $company_id ) {

        /*  Обновляем данные всем пользователям, у которых id компании - соответствует удаляемой */
        $data = array(
            'company_id'        => 0,
            'company_status'    => 'not accepted',
            'company_role'      => 0,
            'company_profession'=>''
        );

        $this->db->where('company_id', $company_id);
        $this->db->update('users', $data);

        $this->db->delete('companies_brands', array( 'company_id' => $company_id) );

        $this->db->delete('companies', array( 'id' => $company_id) );

        return true;
    }




    public function get_company_director_id ( $company_id ){

        $query = $this->db      ->select('comp.director')
                                ->from('companies as comp')
                                ->where( array('id' => $company_id))
                                ->limit(1)
                                ->get();
        if($query->result())
        {
            foreach($query->result() as $result)
            {
                return $result->director;
            }
        }
        else return false;
    }

    public function get_company_id_by_director_id ( $director_id ){

        $query = $this->db      ->select('id')
                                ->from('companies')
                                ->where( array('director' => $director_id))
                                ->limit(1)
                                ->get();
        if($query->result()) {
            foreach($query->result() as $result) {
                return $result->id;
            }
        }
        else return false;
    }


    public function get_company_candidats ( $company_id ) {
        $result = array();
        $query = $this->db->get_where('users', array('company_id' => $company_id, 'company_status' => 'not accepted', 'removed' => 0)  );
        if($query->result()) {
            foreach($query->result() as $row) {
                $result[] = $row;
            }
            return $result;
        } else
            return false;
    }

    public function count_company_candidats ( $company_id ) {
        return  $this->db   ->from('users')
            ->where(array('company_id' => $company_id, 'company_status' => 'not accepted', 'removed' => 0))
            ->count_all_results();
    }

    public function get_company_employers ( $company_id, $ex_employers = false, $removed = false ) {

        /*
         *      $removed    = false; Не показывать удаленных
         */

        $result = array();

        $this->db           ->select('u.id, 
                                        u.name, 
                                        u.phone, 
                                        u.last_name, 
                                        u.second_name, 
                                        u.contact_phone, 
                                        u.company_id, 
                                        u.company_status, 
                                        u.profession, 
                                        u.direction, 
                                        u.rating_points,
                                        u.rating_counts,
                                        (u.rating_points / u.rating_counts) as rating, 
                                        u.avatar, 
                                        u.show_phone, 
                                        u.email, 
                                        u.status, 
                                        u.removed,
                                        u.company_role, 
                                        u.company_profession');
        if ( $ex_employers ) {

            $this->db       ->from('companies_ex_employers as ex')
                ->join('users as u', 'ex.user_id = u.id')
                ->where('ex.company_id', $company_id);
            if( !$removed ) {
                $this->db   ->where('u.removed', 0);
            }
        }
        else {
            $this->db       ->from('users as u')
                ->where('u.company_id', $company_id)
                ->where('u.company_status', 'accepted');
            if( !$removed ) {
                $this->db   ->where('u.removed', 0);
            }
        }

        $query = $this->db->get();

        if($query->result()) {
            foreach($query->result() as $row) {

                if( $ex_employers )
                    $row->ex_employer   = true;
                else
                    $row->ex_employer   = false;

                if( $row->name == '' && $row->last_name == '' )
                    $row->name  = $row->phone;

                if( $row->company_role != 0 )
                    $row->company_role__val = $this->Option_model->get_directory_value( $row->company_role );

                if( $row->rating_counts >= 5 )
                    $row->rating     = intVal( $row->rating );
                else
                    $row->rating     = false;

                $result[] = $row;
            }
            return $result;
        } else
            return false;
    }


    public function get_company_employers_ids ( $company_id ) {
        $result = array();
        $this->db           ->select('id')
                            ->from('users')
                            ->where('removed', 0)
                            ->where( array('company_id' => $company_id, 'company_status' => 'accepted') );
        $query = $this->db->get();
        if($query->result()) {
            foreach($query->result() as $row) {
                $result[] = $row->id;
            }
            return $result;
        } else
            return false;
    }

    public function count_company_employers ( $company_id ) {
        return  $this->db   ->from('users')
                            ->where('removed', 0)
                            ->where(array('company_id' => $company_id, 'company_status' => 'accepted'))
                            ->count_all_results();
    }

    //      Сотрудник становиться бывшим
    public function set_ex_employer( $user_id, $company_id ) {
        $data = array(
            'user_id'       => $user_id,
            'company_id'    => $company_id,
        );

        if( $this->db->insert('companies_ex_employers', $data) ) {
            return true;
        }
        else {
            return false;
        }
    }

    //      Сотрудник вновь возвращается в компанию
    public function remove_ex_employer( $user_id, $company_id ) {

        $this->db->where('user_id', $user_id);
        $this->db->where('company_id', $company_id);

        if( $this->db->delete('companies_ex_employers') ) {
            return true;
        }
        else {
            return false;
        }

    }

    public function is_ex_employer( $user_id, $company_id ){

        $query = $this->db  ->from('companies_ex_employers as ex')
                            ->where('ex.company_id', $company_id)
                            ->where('ex.user_id', $user_id)
                            ->get();

        if( $query->result() ) {
            return true;
        } else
            return false;
    }


    public function get_company_employers_news( $company_id ) {


    }

/*

    public function get_company__logo( $id ) {

        $this->db->select('logo')->from('companies')->where(array('id' => $id));
        $query = $this->db->get();
        if($query->result())
        {
            foreach($query->result() as $result)
            {
                return $result;
            }
        }
        else return false;
    }


    public function get_company__short_name( $id ) {
        $this->db->select('short_name')->from('companies')->where(array('id' => $id));
        $query = $this->db->get();
        if($query->result())
        {
            foreach($query->result() as $result)
            {
                return $result;
            }
        }
        else return false;
    }

*/







    /*  DADATA - ПРОВЕРЯЕМ ПОДЛИННОСТЬ ДАННЫХ*/

    public function get_dadata_suggest( $fields, $inn)
    {
        $result = false;
        if ($ch = curl_init("http://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/party"))
        {
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: Token e42baa031f283e1377b9a5cbc3c421547f8dc33f'
            ));
            curl_setopt($ch, CURLOPT_POST, 1);
            // json_encode
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            $result = curl_exec($ch);
            $result = json_decode($result, true);
            curl_close($ch);
        }

        if( array_key_exists("suggestions", $result) ) {
            foreach ($result['suggestions'] as $row ){
                if( $row['data']['inn'] == $inn )
                    return $row;
            }
        }

        return false;
    }


    public function make_company_active( $user_id, $code ) {

        $this->db   ->select('id')
                    ->from('companies')
                    ->where('exdor_code', $code)
                    ->where('director', $user_id)
                    ->limit(1);

        $query      = $this->db->get();

        if($query->result()) {
            foreach($query->result() as $row) {
                $data = array(
                    'active'        => 1,
                    'exdor_code'    => 0,
                    'approved'      => 'approved'
                );
                $this->update_company( $row->id, $data );
            }
            return true;
        } else
            return false;

    }



    public function is_user_my_director( $user_id, $director_id ) {

        $user_company       = $this->User_model->get_user_company_id( $user_id );

        if ( !$user_company )
            return false;

        $director_company   = $this->get_company_id_by_director( $director_id );

        if ( !$director_company )
            return false;

        if ( $director_company == $user_company )
            return true;
        else
            return false;

    }






    public function search_companies( $keyword, $limit = 10 ) {

        $value = array();

        $this->db
                    ->select('com.id, com.logo, com.short_name, com.type, (com.rating_points/com.rating_counts) as rating, c.name as city, com.description')
                    ->from('companies com')
                    ->join('data_city c', 'com.city = c.city_id')
                    ->where('active', 1)
                    ->where('removed', 0)
                    ->group_start()
                    ->or_like('com.full_name', $keyword, 'both' )
                    ->or_like('com.short_name', $keyword, 'both' )
                    ->group_end();

        if ( $limit > 0 )
            $this->db->limit($limit);

        $query = $this->db->get();

        foreach($query->result() as $row) {

            if( $row->city ) {
                $city   = $row->city;
            }
            else {
                $city   = 'Город не указан';
            }

            $company_employers          = $this->get_company_employers( $row->id );
            $company_employers_count    = $this->count_company_employers( $row->id );

            if( $row->description )
                $description   = $row->description;
            else
                $description   = "Описание отсутствует";

            $value[] = array(
                'value'                     => $row->short_name,
                'logo'                      => $row->logo,
                'company_employers'         => $company_employers,
                'company_employers_count'   => $company_employers_count,
                'city'                      => $city,
                'description'               => mb_substr( htmlspecialchars_decode( strip_tags($description) ), 0, 125).' ',
                'type'                      => 'company',
                'data'                      => $row,
            );
        }
        return $value;

    }



    public function count_search_companies( $keyword ) {

        $keywords = explode(" ", $keyword);

        $this->db
            ->from('companies com')
            ->where('active', 1)
            ->where('removed', 0);

        if( is_array($keywords) && !empty($keywords)):
            foreach($keywords as $search_word):
                $this->db
                    ->group_start()
                        ->or_like('com.full_name', $keyword, 'both' )
                        ->or_like('com.short_name', $keyword, 'both' )
                    ->group_end();
            endforeach;
        endif;
        return $this->db->count_all_results();

    }






    private function create_company ( $company ) {

        $this->load->helper('morphem');

        if( $company->director == $this->session->user )
            $company->is_manager        = true;
        else
            $company->is_manager        = false;

        $company->employers_num     = 1;
        $company->brands            = $this->get_company_brands( $company->id );

        /*
        if( strlen( $company->description ) >= 70 )
            $company->short_description = substr( $company->description, 0, 120).'...';
        else
            $company->short_description = false;
*/
        if( $company->rating_counts >= 1 )
            $company->rating    = intval( round($company->rating) );
        else
            $company->rating    = false;

        $company->count_employers       = $this->count_company_employers( $company->id );
        $company->count_employers_text  = morphem( $company->count_employers, 'сотрудник', 'сотрудника', 'сотрудников');
        $company->count_candidats       = $this->count_company_candidats( $company->id );

        return $company;
    }

    private function get_company_brands ( $company_id ) {

        $result = array();
        $query  = $this->db     ->select('cb.brand_id, d.value')
                                ->from('companies_brands as cb')
                                ->join('directory as d', 'd.id = cb.brand_id')
                                ->where('d.id = cb.brand_id')
                                ->where('cb.company_id', $company_id)
                                ->get();

        //$this->db->get_where('companies_brands', array('company_id' => $company_id) );

        if($query->result()) {
            foreach($query->result() as $row) {
                $result[$row->brand_id]   = $row->value;
            }
            return $result;
        } else
            return false;
    }

    private function get_company_id_by_director( $director_id ) {
        $query = $this->db      ->select('id')
                                ->from('companies')
                                ->where( 'director', $director_id )
                                ->limit(1)
                                ->get();

        if($query->result()) {
            foreach($query->result() as $result)  {
                return $result->id;
            }
        } else return false;
    }


}