<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 16.06.16
 * Time: 12:08
 */

class User_model extends CI_Model {

    public function get_users( $filter = array() ){

        $keywords       = false;    // ищем по ключевому слову
        if( array_key_exists("keywords", $filter) && $filter['keywords'] != '' ) {
            $keywords   = $filter['keywords'];
            $keywords   = explode(" ", $keywords);
        }


        $limit          = false;    // Количество пользователей для вывода
        if( array_key_exists("limit", $filter) && $filter['limit']  != 0 )
            $limit      = $filter['limit'];

        $offset         = false;    // Отступ (для пагинации)
        if( array_key_exists("offset", $filter) && $filter['offset']  != 0 )
            $offset     = $filter['offset'];

        $count_users         = false;    // Возвращаем только пользователей
        if( array_key_exists("count", $filter) && $filter['count']  = true )
            $count_users     = true;     // Возвращаем только количество пользователей


        $output = array();

        $this->db->select('u.id, 
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
                            c.name as city, 
                            c.city_id, 
                            u.avatar, 
                            u.show_phone, 
                            u.email, 
                            u.status, 
                            u.company_role, 
                            u.company_profession, 
                            u.sms_limit, 
                            u.security_page, 
                            u.security_contacts, 
                            u.security_partners, 
                            u.notice_popup_time,
                            u.removed,
                            up.tarif,
                            up.date_start as tarif_date_start,
                            up.date_end as tarif_date_end,
                            up.balance');
        $this->db->from('users as u');
        $this->db->join('data_city c', 'u.city = c.city_id');
        $this->db->join('users_plans up', 'u.id = up.user_id');


        if( is_array( $keywords ) && !empty($keywords)):
            foreach($keywords as $search_word):
                $this->db->group_start();
                $this->db->or_like('u.name', $search_word, 'both' );
                $this->db->or_like('u.last_name', $search_word, 'both' );
                $this->db->or_like('u.second_name', $search_word, 'both' );
                $this->db->or_like('u.phone', $search_word, 'both' );
                $this->db->or_like('u.email', $search_word, 'both' );
                $this->db->group_end();
            endforeach;
        endif;

        if( array_key_exists('editors_mod', $filter) && $filter['editors_mod'] != true ) {
            $this->db->where('u.name !=', '');
            $this->db->where('u.last_name !=', '');
        }

        $this->db->where('u.id !=', 1); // Исключаем EXDOR
        $this->db->where('u.confirm', 1); // Только пользователи, которые авторизовывались

        if(array_key_exists('exclude_users',$filter))
            $this->db->where_not_in('u.id', $filter['exclude_users']);


        if( $limit )
            $this->db->limit( $limit );

        if( $offset )
            $this->db->offset( $offset );

        $this->db->order_by("removed ASC, last_name ASC");


        $query = $this->db->get();

        if( $query->result() ) {

            if ( $count_users ) {

                return $query->num_rows();

            } else {

                foreach ($query->result() as $row) {

                    $this->build_user( $row );



                    $output[] = $row;
                }
                return $output;

            }

        }

    }

    public function get_user_by_id( $id ) {

        $this->db->select('
                            u.id, 
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
                            c.name as city, 
                            c.city_id,
                            u.avatar, 
                            u.show_phone, 
                            u.email, 
                            u.status, 
                            u.company_role, 
                            u.company_profession, 
                            u.sms_limit,
                            u.security_page, 
                            u.security_contacts, 
                            u.security_partners, 
                            u.notice_popup_time,
                            u.notice_popup_count_name,
                            u.notice_popup_count_lastname,
                            u.notice_popup_count_secondname,
                            u.notice_popup_count_city,
                            u.notice_popup_count_email,
                            u.notice_popup_count_brands,
                            u.notice_popup_count_direction,
                            u.removed,
                            up.tarif,
                            up.date_start as tarif_date_start,
                            up.date_end as tarif_date_end,
                            up.balance,
                            ')
                ->from('users as u')
                ->join('data_city c', 'u.city = c.city_id')
                ->join('users_plans up', 'u.id = up.user_id')
                ->where('u.id',$id)
                ->limit(1);

        $query = $this->db->get();


        if($query->result()) {
            foreach($query->result() as $result) {
                return $this->build_user( $result );
            }
        } else
            return false;
    }

    public function get_user_by_phone( $phone ) {
        $phone      = intval( preg_replace("/[^0-9]/", '', $phone) );
        $query = $this->db->get_where('users', array('phone' => $phone), 1, 0);
        if($query->result()) {
            foreach ($query->result() as $result) {
                return $result;
            }
        } else
            return false;
    }

    public function get_user_name_by_id( $id ) {
        $this->db->select('name, last_name, second_name');
        $this->db->from('users');
        $this->db->where('id', $id);

        $query = $this->db->get();
        if($query->result()) {
            foreach ($query->result() as $result) {
                return $result->name.' '.$result->second_name.' '.$result->last_name;
            }
        } else
            return false;
    }

    public function add_user($phone){
        $now        = new DateTime();
        $phone      = preg_replace("/[^0-9]/", '', $phone);
        $data = array(
            'phone'                 => $phone,
            'contact_phone'         => $phone,
            'reg_date'              => $now->format("Y-m-d")
        );
        $this->db->insert('users', $data );
        $user_id    = $this->db->insert_id();

        $this->new_user_plan( $user_id );

        return $user_id;
    }

    public function update_user_info( $id, $data) {

        if( array_key_exists('brands', $data) ){
            $this->db->delete('users_brands', array('user_id' => $id));
            foreach ( $data['brands'] as $brand ) {
                $this->db->insert('users_brands', array('user_id' => $id, 'brand_id' => $brand));
            }
            unset( $data['brands'] );
        }

        if(array_key_exists('phone', $data)){
            $data['phone']      = preg_replace("/[^0-9]/", '', $data['phone']);
            // Если при обновлении телефона указали тот, который уже есть в базе - не обновляемся
            if( $this->get_user_by_phone( $data['phone'] )) {
                unset($data['phone']);
            }
        }

        if( array_key_exists("tarif", $data) || array_key_exists("tarif_date_end", $data) ){

            if( isset(  $data['balance'] )) {
                $this->update_user_tarif( $id, $data['tarif'], $data['tarif_date_end'],  $data['balance'] );
            } else {
                $this->update_user_tarif( $id, $data['tarif'], $data['tarif_date_end'] );
            }


            unset( $data['tarif'] );
            unset( $data['tarif_date_end'] );
            unset( $data['balance'] );
        }

        /*
        if( array_key_exists( 'name', $data) && $data['name'] != '' )
            $data['notice_popup_count_name']    = 4;
        else $data['notice_popup_count_name']      = 0;

        if( array_key_exists( 'last_name', $data) && $data['last_name'] != '' )
            $data['notice_popup_count_lastname']    = 4;
        else $data['notice_popup_count_lastname']      = 0;

        if( array_key_exists( 'second_name', $data) && $data['second_name'] != '' )
            $data['notice_popup_count_secondname']    = 4;
        else $data['notice_popup_count_secondname']      = 0;

        if( array_key_exists( 'city', $data) && $data['city'] != '' )
            $data['notice_popup_count_city']    = 4;
        else $data['notice_popup_count_city']      = 0;

        if( array_key_exists( 'email', $data) && $data['email'] != '' )
            $data['notice_popup_count_email']    = 4;
        else $data['notice_popup_count_email']      = 0;

        */

        if( count( $data ) != 1 && (!array_key_exists('avatar', $data) || !array_key_exists('last_action', $data)) ) {
            $current_date       = new DateTime('now');
            $notice_popup_time  = $current_date->getTimestamp() + 60*60*24;
            date_timestamp_set($current_date, $notice_popup_time);
            $data['notice_popup_time'] = date_format($current_date, 'Y-m-d H:i:s') ;
        }


        $this->db->where('id', $id);
        if ( $this->db->update('users', $data) )
            return true;
        else
            return false;
    }

    public function get_user_brands( $user_id ) {

        $output = array();
        $query = $this->db  ->select('brand_id')
                            ->from('users_brands')
                            ->where('user_id', $user_id)
                            ->get();

        foreach($query->result() as $row){
            $output[$row->brand_id]     = $row->brand_id;
        }
        return $output;
    }

    public function password_generator(){
        $chars      = "qazxswedcvfrtgbnhyujmkp123456789QAZXSWEDCVFRTGBNHYUJMKP";
        $max        = 8;
        $size       = StrLen($chars)-1;
        $password   = null;
        while($max--)
            $password .= $chars[rand(0,$size)];
        return $password;
    }

    public function get_user_change_login_data ( $user_id ) {
        $this->db->select('
                            u.id, 
                            u.phone,
                            u.change_login__code,
                            u.change_login__phone,
                            u.change_login__password
                            ')
            ->from('users as u')
            ->where('u.id',$user_id)
            ->limit(1);

        $query = $this->db->get();
        if($query->result()) {
            foreach($query->result() as $result) {
                return $result;
            }
        }
        else return false;
    }

    public function change_login__code( $user_id ){
        $chars      = "123456789";
        $max        = 4;
        $size       = StrLen($chars)-1;
        $password   = null;
        while($max--)
            $password .= $chars[rand(0,$size)];

        if( $this->update_user_info( $user_id, array('change_login__code' => $password)) )
            return $password;

        else return false;
    }

    public function is_register_phone($phone) {
        $phone      = preg_replace("/[^0-9]/", '', $phone);
        $query = $this->db->get_where('users', array('phone' => $phone), 1, 0);
        if($query->result())
            return true;
        else
            return false;
    }

    public function is_register_email($email) {
        $query = $this->db->get_where('users', array('email' => $email), 1, 0);
        if($query->result())
            return true;
        else
            return false;
    }

    public function is_user_confirm($phone) {
        $phone      = preg_replace("/[^0-9]/", '', $phone);
        $query = $this->db->get_where('users', array('phone' => $phone, 'confirm' => 1), 1, 0);
        if($query->result())
            return true;
        else return false;
    }

    public function get_user_password($phone) {
        $pass       = '';
        $phone      = preg_replace("/[^0-9]/", '', $phone);
                 $this->db->select('password');
        $query = $this->db->get_where('users', array('phone' => sha1($phone)), 1, 0);
        if($query->result()) {
            foreach ($query->result() as $result) {
                $pass = $result->password;
            }
        }
        return $pass;
    }

    public function get_user_company_id($user_id) {
        $this->db       ->select('company_id')
                        ->from('users')
                        ->where('id',$user_id)
                        ->where('company_status', 'accepted')
                        ->limit(1);

        $query = $this->db->get();


        if($query->result()) {
            foreach($query->result() as $result) {
                return $result->company_id;
            }
        } else
            return false;
    }

    public function confirm_user_phone($phone){
        $phone      = preg_replace("/[^0-9]/", '', $phone);
        $update_data = array(
            'confirm'     => 1
        );
        $this->db->where('phone', $phone);
        if ( $this->db->update('users', $update_data) )
            return true;
        else
            return false;
    }

    public function user_auth($phone, $password) {
        $phone      = preg_replace("/[^0-9]/", '', $phone);
        $query = $this->db->get_where('users', array('phone' => $phone, 'password' => $password, 'removed' => 0), 1);

        if( $query->result() ){
            foreach ($query->result() as $row)
            {

                $this->session->set_userdata(
                    array(
                        "user"      => $row->id,
                        "phone"     => $row->phone,
                        "company"   => $row->company_id
                    )
                );

                delete_cookie('user', 'exdor.ru', '/');
                delete_cookie('password', 'exdor.ru', '/');
                set_cookie( array(
                        'name'   => 'user',
                        'value'  => $row->id,
                        'expire' => '604800',
                        'domain' => 'exdor.ru',
                        'path'   => '/'
                    )
                );

                set_cookie( array(
                        'name'   => 'password',
                        'value'  => $password,
                        'expire' => '604800',
                        'domain' => 'exdor.ru',
                        'path'   => '/'
                    )
                );

                return true;
            }
        } else {
            return false;
        }
    }

    private function cookie_user_auth($id, $password) {
        $query = $this->db->get_where('users', array('id' => $id, 'password' => $password), 1);

        if( $query->result() ){
            foreach ($query->result() as $row)
            {
                $this->session->set_userdata(
                    array(
                        "user"  => $row->id,
                        "phone" => $row->phone,
                    )
                );
                delete_cookie('user', 'exdor.ru', '/');
                delete_cookie('password', 'exdor.ru', '/');

                set_cookie( array(
                        'name'   => 'user',
                        'value'  => $row->id,
                        'expire' => '604800',
                        'domain' => 'exdor.ru',
                        'path'   => '/'
                    )
                );

                set_cookie( array(
                        'name'   => 'password',
                        'value'  => $password,
                        'expire' => '604800',
                        'domain' => 'exdor.ru',
                        'path'   => '/'
                    )
                );
                return true;
            }
        } else {
            return false;
        }
    }

    public function is_auth_user () {

        if ( $this->session->userdata('user') ) {


            $user   = $this->get_user_by_id( $this->session->user );
            if( $user->removed  == 1 ):
                $this->user_logout();
                return false;
            endif;


            return true;
        } else {
            if( get_cookie('user') && get_cookie('password')) {

                $user   = $this->get_user_by_id( get_cookie('user') );
                if( $user->removed  == 1 ):
                    $this->user_logout();
                    return false;
                endif;


                $response = $this->cookie_user_auth( get_cookie('user'), get_cookie('password'));
                return boolval($response);
            } else {
                return false;
            }
        }
    }

    public function is_user_removed($user_id) {

        $this->db->select("removed");
        $query = $this->db->get_where('users', array('id' => $user_id), 1, 0);

        if( $query->result())
            foreach($query->result() as $row)
                return $row->removed;
        else
            return false;

    }

    public function user_logout (){

        $this->session->unset_userdata('user');
        $this->session->unset_userdata('phone');
        //delete_cookie('user', $this->config->item('item_name'), '/');
        //delete_cookie('password', $this->config->item('item_name'), '/');

        set_cookie('user', null, time() - 3600, 'exdor.ru', '/');
        set_cookie('password', null, time() - 3600, 'exdor.ru', '/');



        return true;
    }

    public function get_user_content( $filter = array() )
    {
        if (array_key_exists('user_id', $filter) )
        {
            $user_id    = $filter['user_id'];
        }
        else
        {
            return false;
        }
        if (array_key_exists('last_loaded_news', $filter) )
        {
            $news_from_filter   = $filter['last_loaded_news'];
        }
        else
        {
            $news_from_filter   = 0;
        }
        if (array_key_exists('last_loaded_offers', $filter) )
        {
            $ads_from_filter    = $filter['last_loaded_offers'];
        }
        else
        {
            $ads_from_filter    = 0;
        }
        if (array_key_exists('limit', $filter) )
        {
            $limit      = $filter['limit'];
        }
        else
        {
            $limit      = 10;
        }

        $combined_data      = array();

        $ads_filter         = array(
                                'user_id'   => $user_id,
                                'pinned'    => 'no',
                                'from'      => $ads_from_filter,
                                'limit'     => $limit,
                                'inverse'   => false
                            );

        $news_filter        = array(
                                'user_id'   => $user_id,
                                'type'      => 'solo',
                                'from'      => $news_from_filter,
                                'limit'     => $limit,
                                'inverse'   => false
                            );

        $user__last_news    = $this->News_model->get_news( $news_filter );
        $user__last_ads     = $this->Offers_model->get_offers( $ads_filter);

        if($user__last_news)
        {
            foreach($user__last_news as $user_news)
            {
                $combined_data[]    = $user_news;
            }
        }
        if($user__last_ads)
        {
            foreach ($user__last_ads as $user_ads)
            {
                $combined_data[]    = $user_ads;
            }
        }


        function cmp($a, $b)
        {
            return strnatcmp($a->udate, $b->udate);
        }
        usort($combined_data, "cmp");

        $reverse_result = array_reverse($combined_data);

        $result = array_slice($reverse_result, 0, 10);
        return $result;
    }

    public function online_checker ( $user_id ) {
        $now        = new DateTime('now');
        $data       = array (
            'last_action'       => $now->format('Y-m-d H:i:s')
        );

        $this->update_user_info( $user_id, $data );

        return true;
    }

    public function online_users( ) {

        $now        = new DateTime('now');
        $now->sub(new DateInterval('PT15M'));

        $online     = $now->format('Y-m-d H:i:s');

        $this->db->select('u.id, u.name, u.last_name, u.phone');
        $this->db->from('users as u');
        $this->db->where('u.id !=', 1); // Исключаем EXDOR
        $this->db->where('u.last_action >=', $online);


        $query = $this->db->get();

        $output         = array();

        if( $query->result() ) {
            foreach($query->result() as $row){
                $output[] = $row;
            }
            return $output;
        } else return false;



    }


    public function search_users( $keyword, $limit = 10 ) {


        $user_friends_ids = $this->Partner_model->get_partners_ids( $this->session->user );

        $keywords = explode(" ", $keyword);

        $value = array();

        $this->db
            ->select('u.id, u.name, u.last_name, u.second_name, u.avatar, u.company_id, u.phone, u.status, c.name as city, (u.rating_points / u.rating_counts) as rating')
            ->from('users u')
            ->join('data_city c', 'u.city = c.city_id')
            ->where('u.id !=', 1)
            ->where('u.removed', 0)
            ->where('u.id !=', $this->session->user);

        if( is_array($user_friends_ids) && !empty($user_friends_ids)) {
            $this->db->group_start();
                foreach( $user_friends_ids as $friend_id ):

                    $this->db->where('u.id !=', $friend_id);

                endforeach;
            $this->db->group_end();
        }

        if( is_array($keywords) && !empty($keywords)):
            foreach($keywords as $search_word):
                $this->db->group_start();
                $this->db->or_like('u.name', $search_word, 'both' );
                $this->db->or_like('u.last_name', $search_word, 'both' );
                $this->db->group_end();
            endforeach;
        endif;

        if ( $limit > 0 )
            $this->db->limit($limit);

        $query =    $this->db->get();

        foreach($query->result() as $row) {

            if( $row->name || $row->last_name ) {
                $name   = $row->name." ".$row->second_name." ".$row->last_name;
            }
            else {
                $name   = $row->phone;
            }

            if( $row->city ) {
                $city   = $row->city;
            }
            else {
                $city   = 'Город не указан';
            }

            if( $row->company_id != '0' ) {
                $row->company   = $this->Company_model->get_company_by_id( $row->company_id );
            } else {
                $row->company = false;
            }

            $value[] = array(
                'id'        => $row->id,
                'avatar'    => $row->avatar,
                'name'      => $row->name,
                'last_name' => $row->last_name,
                'company_id'=> $row->company_id,
                'company'   => $row->company,
                'status'    => $row->status,
                'value'     => $name,
                'city'      => $city,
                'type'      => 'user',
                'data'      => $row,
                'rating'    => intVal($row->rating)
            );
        }

        return $value;

    }

    public function search_friends( $keyword, $limit = 10 ) {

        $keywords = explode(" ", $keyword);

        $value = array();

        $this->db
            ->select('u.id, u.name, u.last_name, u.second_name, u.avatar, u.company_id, u.phone, u.status, c.name as city, (u.rating_points / u.rating_counts) as rating')
            ->from('users u')
            ->join('data_city c', 'u.city = c.city_id')
            ->join('users_relationship ur', 'ur.user_id = u.id')
            ->where('u.id !=', 1)
            ->where('u.id !=', $this->session->user)
            ->where('u.removed', 0)
            ->where('ur.partner_id', $this->session->user)
            ->where('ur.relation', 'partner');

        if( is_array($keywords) && !empty($keywords)):
            foreach($keywords as $search_word):
                $this->db->group_start();
                $this->db->or_like('u.name', $search_word, 'both' );
                $this->db->or_like('u.last_name', $search_word, 'both' );
                $this->db->group_end();
            endforeach;
        endif;

        if ( $limit > 0 )
            $this->db->limit($limit);

        $query =    $this->db->get();

        foreach($query->result() as $row) {

            if( $row->name || $row->last_name ) {
                $name   = $row->name." ".$row->second_name." ".$row->last_name;
            }
            else {
                $name   = $row->phone;
            }

            if( $row->city ) {
                $city   = $row->city;
            }
            else {
                $city   = 'Город не указан';
            }

            if( $row->company_id != '0' ) {
                $row->company   = $this->Company_model->get_company_by_id( $row->company_id );
            } else {
                $row->company = false;
            }

            $value[] = array(
                'id'        => $row->id,
                'avatar'    => $row->avatar,
                'name'      => $row->name,
                'last_name' => $row->last_name,
                'company_id'=> $row->company_id,
                'company'   => $row->company,
                'status'    => $row->status,
                'value'     => $name,
                'city'      => $city,
                'type'      => 'user',
                'data'      => $row,
                'rating'    => intVal($row->rating)
            );
        }

        return $value;

    }


    public function count_search_users( $keyword ) {

        $user_friends_ids = $this->Partner_model->get_partners_ids( $this->session->user );

        $keywords = explode(" ", $keyword);

        $this->db
            ->from('users u')
            ->join('data_city c', 'u.city = c.city_id')
            ->where('u.id !=', 1)
            ->where('u.id !=', $this->session->user);

        if( is_array($user_friends_ids) && !empty($user_friends_ids)) {
            $this->db->group_start();
            foreach( $user_friends_ids as $friend_id ):

                $this->db->where('u.id !=', $friend_id);

            endforeach;
            $this->db->group_end();
        }

        if( is_array($keywords) && !empty($keywords)):
            foreach($keywords as $search_word):
                $this->db->group_start();
                $this->db->or_like('u.name', $search_word, 'both' );
                $this->db->or_like('u.last_name', $search_word, 'both' );
                $this->db->group_end();
            endforeach;
        endif;

        return $this->db->count_all_results();
    }

    public function count_search_friends( $keyword ) {

        $keywords = explode(" ", $keyword);

        $this->db
            ->select('u.id, u.name, u.last_name, u.second_name, u.avatar, u.company_id, u.phone, u.status, c.name as city, (u.rating_points / u.rating_counts) as rating')
            ->from('users u')
            ->join('data_city c', 'u.city = c.city_id')
            ->join('users_relationship ur', 'ur.user_id = u.id')
            ->where('u.id !=', 1)
            ->where('u.id !=', $this->session->user)
            ->where('ur.partner_id', $this->session->user)
            ->where('ur.relation', 'partner');

        if( is_array($keywords) && !empty($keywords)):
            foreach($keywords as $search_word):
                $this->db->group_start();
                $this->db->or_like('u.name', $search_word, 'both' );
                $this->db->or_like('u.last_name', $search_word, 'both' );
                $this->db->group_end();
            endforeach;
        endif;

        return $this->db->count_all_results();

    }


    public function update_user_tarif( $user_id = 0, $tarif = "", $date_end = "", $balance = 0 ) {
        $now        = new DateTime();

        $update_data    = array(
            'tarif'         => $tarif,
            'date_end'      => $date_end,
            'date_start'    => $now->format('Y-m-d'),
            'balance'       => $balance,
        );
        $this->db->where('user_id', $user_id);
        $this->db->update('users_plans', $update_data);
    }

    public function new_user_plan( $user_id = 0 ) {

        $now        = new DateTime();
        $year       = new DateTime();
        $year->add(new DateInterval('P1Y'));

        $insert_data    = array(
            'user_id'       => $user_id,
            'tarif'         => 'premium_user',
            'date_start'    => $now->format('Y-m-d'),
            'date_end'      => $year->format( 'Y-m-d'),
        );
        $this->db->insert('users_plans', $insert_data );
    }

    public function check_users_tarif( ) {

        $now        = new DateTime();
        $year       = new DateTime();
        $year->add(new DateInterval('P1Y'));

        $update_data    = array(
            'tarif'         => 'free',
            'date_start'    => $now->format('Y-m-d'),
            'date_end'      => $year->format( 'Y-m-d'),
        );

        $this->db->where('date_end <=', $now->format('Y-m-d'));
        $this->db->update('users_plans', $update_data);

        return true;
    }

    public function clear_users() {

        $this->db->where('reg_date < DATE_SUB(CURDATE(), INTERVAL 1 DAY)');
        $this->db->where('confirm', 0);
        $this->db->delete('users');

        return true;

    }

    public function build_user ( $user ) {

        if( $user->name == '' && $user->last_name == '' ) {
            $user->name = $user->phone;
        }

        if( $user->removed == 1 ):
            $user->avatar         = "";
        endif;

        if( $user->company_id != '0' ) {
            $user->company   = $this->Company_model->get_company_by_id( $user->company_id );
        } else {
            $user->company = false;
        }

        $tarif_date_end             = new DateTime( $user->tarif_date_end );
        $user->tarif_days_left      = $tarif_date_end->diff( new DateTime(), true )->days;    //  Осталось дней до конца

        $tarif_date_start           = new DateTime( $user->tarif_date_start );
        $user->tarif_days_range     = $tarif_date_end->diff( $tarif_date_start, true )->days;    //  Осталось дней до конца

        if( $user->rating_counts >= 1 )
            $user->rating     = intval( round($user->rating) );
        else
            $user->rating     = false;

        return $user;

    }

}
