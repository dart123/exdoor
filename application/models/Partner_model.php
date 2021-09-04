<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 25.07.16
 * Time: 14:34
 */

class Partner_model extends CI_model {

    public function get_partners( $id, $filter = array() ) {
        $this->db->select('rel.user_id, rel.partner_id, rel.message, u.id, u.phone, u.name, u.second_name, u.last_name, u.phone, u.avatar, u.status, u.removed, u.company_id, u.rating_points, u.rating_counts, (u.rating_points/u.rating_counts) as rating,')
            ->from('users_relationship rel')
            ->join('users u', 'u.id = rel.partner_id')
            ->where('user_id', $id)
            ->where('rel.relation', 'partner');

        if( array_key_exists('limit', $filter) ) {
            $this->db->limit( $filter['limit']);
        }
        if( array_key_exists( 'sort', $filter) && $filter['sort'] == 'RAND' ) {
            $this->db->order_by('id', 'RANDOM');
        }

        $query = $this->db->get();

        $result = array();

        if($query->result()) {
            foreach($query->result() as $row) {

                $partner    = $this->build_partner( $row );
                $result[]   = $partner;

            }
            return $result;
        } else
            return false;
    }





    public function get_outbox_partners( $id ) {
        $query = $this->db->select('rel.user_id, rel.partner_id, rel.message, u.id, u.phone, u.name, u.last_name, u.phone, u.avatar, u.status, u.company_id, u.rating_points, u.rating_counts, (u.rating_points/u.rating_counts) as rating, u.removed')
            ->from('users_relationship rel')
            ->join('users u', 'u.id = rel.partner_id')
            ->where('user_id', $id)
            ->where('rel.relation', 'send_request')
            ->get();


        $result = array();

        if($query->result()) {
            foreach($query->result() as $row) {

                $partner    = $this->build_partner( $row );
                $result[] = $partner;

            }
            return $result;
        } else
            return false;
    }

    public function get_inbox_partners( $id ) {
        $query = $this->db->select('rel.user_id, rel.partner_id, rel.message, u.id, u.phone, u.name, u.last_name, u.phone, u.avatar, u.status, u.company_id, u.removed')
            ->from('users_relationship rel')
            ->join('users u', 'u.id = rel.partner_id')
            ->where('user_id', $id)
            ->where('rel.relation', 'get_request')
            ->get();

        $result = array();

        if($query->result()) {
            foreach($query->result() as $row) {

                $partner    = $this->build_partner( $row );
                $result[]   = $partner;

            }
            return $result;
        } else
            return false;
    }

    public function get_inbox_partners_count( $id ){
        return $this->db->from('users_relationship')
            ->where('user_id', $id)
            ->where('relation', 'get_request')
            ->count_all_results();
    }

    public function get_outbox_partners_count( $id ) {
        return $this->db->from('users_relationship')
            ->where('user_id', $id)
            ->where('relation', 'send_request')
            ->count_all_results();
    }

    public function get_request( $user, $partner ) {
        $this->db       ->select('*')
                        ->from('users_relationship')
                        ->where('user_id', $user)
                        ->where('partner_id', $partner )
                        ->limit(1);

        $query  =   $this->db->get();

        if($query->result()) {
            foreach($query->result() as $row) {
                return $row;
            }
        } else
            return false;
    }

    public function request__add_message($user_id, $partner_id, $message) {
        $this->db->update('users_relationship', array('message' => $message), array('user_id' => $user_id, 'partner_id' => $partner_id));
        $this->db->update('users_relationship', array('message' => $message), array('user_id' => $partner_id, 'partner_id' => $user_id));
        return true;
    }

    public function get_partners_ids( $id ) {

        $query = $this->db->select('partner_id')
                    ->get_where('users_relationship', array('user_id' => $id, 'relation' => 'partner' ) );

        $result = array();

        if($query->result()) {
            foreach($query->result() as $row) {
                $result[] = $row->partner_id;
            }
            return $result;
        } else
            return false;
    }

    public function get_potencial_partners_ids( $id ) {

        $query = $this->db  ->select('partner_id')
                            ->from('users_relationship')
                            ->where('user_id',  $id)
                            ->group_start()
                                ->or_where('relation', 'send_request' )
                                ->or_where('relation', 'get_request')
                            ->group_end()
                            ->get();
        $result = array();

        if($query->result()) {
            foreach($query->result() as $row) {
                $result[] = $row->partner_id;
            }
            return $result;
        } else
            return false;
    }

    public function check_relationship( $id, $partner_id ) {

        $query = $this->db->get_where('users_relationship', array('user_id' => $id, 'partner_id' => $partner_id), 1, 0);
        if( $query->result() ){
            $new_query = $this->db->get_where('users_relationship', array('user_id' => $partner_id, 'partner_id' => $id), 1, 0);
            if ( $new_query->result() ) {
                foreach($new_query->result() as $row) {
                    return $row->relation; // раньше было true
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function send_request( $id, $partner_id ) {

        if( !$this->check_relationship($id, $partner_id) ) {

            $data = array(
                'user_id'           => $id,
                'partner_id'        => $partner_id,
                'relation'          => 'send_request'
            );
            if( $this->db->insert('users_relationship', $data ) ) {
                // Если удалось сделать первую запись, делаем вторую
                $new_data = array(
                    'user_id'           => $partner_id,
                    'partner_id'        => $id,
                    'relation'          => 'get_request'
                );
                if( $this->db->insert('users_relationship', $new_data ) ){
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }

        } else return false;


    }

    public function add_partner( $id, $partner_id, $undo = false ) {


        if (!$undo) {

            if( $this->check_relationship($id, $partner_id) == 'send_request' ) {

                $data_user = array(
                    'relation' => 'partner',
                    'can_be_undone' => 1,
                );
                $data_partner = array(
                    'relation' => 'partner',
                );

                $this->db->update('users_relationship', $data_user, array('user_id' => $id, 'partner_id' => $partner_id));
                $this->db->update('users_relationship', $data_partner, array('user_id' => $partner_id, 'partner_id' => $id));

                return true;
            } else return false;

        } elseif ($this->can_request_be_undone($id, $partner_id)) {

            $this->cancel_request($id, $partner_id);       // Удаляем предыдущий запрос
            $this->send_request($partner_id, $id);        // Отправляем "новый" от имени опонента

        }

        return true;

    }

    public function count_user_partners ( $user_id = 0 ) {

        $query = $this->db
                            ->from('users_relationship rel')
                            ->join('users u', 'u.id = rel.partner_id')
                            ->where('user_id', $user_id)

                            ->where('rel.relation', 'partner')
                            ->count_all_results();

       return $query;
    }

    public function remove_partner( $id, $partner_id ) {

        if( $this->check_relationship($id, $partner_id) == 'partner' ) {
            $data = array(
                'relation'          => '',
                'can_be_undone'     => 1,
            );
            $this->db->update('users_relationship', $data, array('user_id' => $id, 'partner_id' => $partner_id));
            $data = array(
                'relation'          => '',
                'can_be_undone'     => 1
            );
            $this->db->update('users_relationship', $data, array('user_id' => $partner_id, 'partner_id' => $id));

            return true;
        } else return false;
    }

    public function undo_remove_partner( $user_id, $partner_id ) {
        $data = array(
            'relation'          => 'partner',
            'can_be_undone'     => 0,
            'user_id'           => '',
            'partner_id'        => ''

        );

        $this->db->delete('users_relationship', array('user_id' => $user_id, 'partner_id' => $partner_id));
        $this->db->delete('users_relationship', array('partner_id' => $user_id, 'user_id' => $partner_id));

        $data['user_id']        = $user_id;
        $data['partner_id']     = $partner_id;
        $this->db->insert('users_relationship', $data );

        $data['user_id']        = $partner_id;
        $data['partner_id']     = $user_id;
        $this->db->insert('users_relationship', $data );

        return true;
    }

    public function cancel_request( $id, $partner_id ) {

        $this->db->delete('users_relationship', array('user_id' => $id, 'partner_id' => $partner_id));
        $this->db->delete('users_relationship', array('user_id' => $partner_id, 'partner_id' => $id));

        return true;
    }

    public function erase_undone_requests ( $user_id ){
        $this->db->update(
                            'users_relationship',
                            array('can_be_undone' => 0 ),
                            array('user_id' => $user_id)
        );



        $this->db
            ->or_group_start()
                ->where('user_id', $user_id)
                ->where('relation', '')
            ->group_end()
            ->or_group_start()
                ->where('partner_id', $user_id)
                ->where('relation', '')
            ->group_end()

            ->delete('users_relationship');

    }

    public function can_request_be_undone( $id, $partner_id ) {
        $query      = $this->db     ->select('can_be_undone')
                                    ->from('users_relationship')
                                    ->where( array(
                                                'user_id'       => $id,
                                                'partner_id'    => $partner_id,
                                                'can_be_undone' => 1
                                            )
                                    )
                                    ->limit(1)
                                    ->get();

        if( $query->result())
            return true;
        else
            return false;
    }




    public function get_partners_for_request( $filter = array() ) {

        $output     = array();
        $limit      = 'big';

        if ( array_key_exists( 'exclude_users', $filter ) && is_array( $filter['exclude_users'] ) ) {
            if( count($filter['exclude_users']) > 10 ) {
                $limit  = 'small';
            }
        }

        if($limit == 'small') {
            $filter['limit']    = 2;
        } else {
            $filter['limit']    = 4;
        }

        $users_rated    = $this->get_partners_for_request__rated( $filter );

        if( is_array($users_rated) && !empty($users_rated) ) {
            foreach( $users_rated as $usr ) {
                $filter['exclude_users'][]    = $usr->id;
                $output[]   = $usr;
            }
        }



        $users_premium  = $this->get_partners_for_request__premium( $filter );
        if( is_array($users_premium) && !empty($users_premium) ) {
            foreach( $users_premium as $usr ) {
                $filter['exclude_users'][]      = $usr->id;
                $output[]   = $usr;
            }
        }

        if($limit == 'small') {
            $filter['limit']    = 1;
        } else {
            $filter['limit']    = 2;
        }

        $users_new      = $this->get_partners_for_request__new( $filter );
        if( is_array($users_new) && !empty($users_new) ) {
            foreach( $users_new as $usr ) {
                $output[]   = $usr;
            }
        }



/*      if( array_key_exists('include_partners', $filter) && $filter['include_partners'] == true ) {
            echo "<pre>";
            echo '123';
            var_dump(  $output  );
            die();
        }
*/

        return $output;


    }

    public function get_partners_for_request__rated( $filter = array() ) {

        $output = array();

        $this->db->select('u.id, u.name, u.phone, u.last_name, u.second_name, u.company_id, u.rating_points, u.rating_counts, (u.rating_points/u.rating_counts) as rating, c.name as city, c.city_id, u.avatar,');
        $this->db->from('users as u');
        $this->db->join('data_city c', 'u.city = c.city_id');

        if( array_key_exists('brand',$filter) && !empty( $filter['brand']) ) {
            $this->db->join('users_brands ub', 'u.id = ub.user_id');
            $this->db->where('ub.brand_id', $filter['brand']);
        }

        $this->db->where('u.name !=', '');
        $this->db->where('u.removed', 0);
        $this->db->where('u.last_name !=', '');
        $this->db->where('u.id !=', 1); // Исключаем EXDOR

        $this->db->group_start();
        $this->db->or_where('u.direction', 'sell');
        $this->db->or_where('u.direction', 'all');
        $this->db->group_end();


        if( array_key_exists('exclude_users',$filter) && !empty( $filter['exclude_users']) )
            $this->db->where_not_in('u.id', $filter['exclude_users']);

        if( array_key_exists('limit',$filter) )
            $this->db->limit( $filter['limit'] );
        else
            $this->db->limit( 10 );

        $this->db->order_by('rating', 'ASC');

        $this->db->where('u.removed', 0);


        $query = $this->db->get();

/*
        if( array_key_exists('include_partners', $filter) && $filter['include_partners'] == true ) {
            echo "<pre>";
            var_dump(  $this->db->last_query()  );
            die();
        }
*/

        foreach($query->result() as $row){

            if( $row->company_id ) {
                $row->company   = $this->Company_model->get_company_by_id( $row->company_id );
            } else {
                $row->company = false;
            }
            $output[] = $row;
        }

        return $output;

    }

    public function get_partners_for_request__premium( $filter = array() ) {

        $output = array();

        $this->db->select('u.id, u.name, u.phone, u.last_name, u.second_name, u.company_id, u.rating_points, u.rating_counts, (u.rating_points/u.rating_counts) as rating, c.name as city, c.city_id, u.avatar,');
        $this->db->from('users as u');
        $this->db->join('data_city c', 'u.city = c.city_id');
        $this->db->join('users_plans up', 'up.user_id = u.id');

        if( array_key_exists('brand',$filter) && !empty( $filter['brand']) ) {
            $this->db->join('users_brands ub', 'u.id = ub.user_id');
            $this->db->where('ub.brand_id', $filter['brand']);
        }

        $this->db->where('u.removed', 0);

        $this->db->group_start();
            $this->db->or_where('up.tarif', 'premium_user');
            $this->db->or_where('up.tarif', 'premium_company');
        $this->db->group_end();

        $this->db->where('u.name !=', '');
        $this->db->where('u.last_name !=', '');
        $this->db->where('u.id !=', 1); // Исключаем EXDOR

        $this->db->group_start();
            $this->db->or_where('u.direction', 'sell');
            $this->db->or_where('u.direction', 'all');
        $this->db->group_end();

        if( array_key_exists('exclude_users',$filter) && !empty( $filter['exclude_users']) )
            $this->db->where_not_in('u.id', $filter['exclude_users']);

        if( array_key_exists('limit',$filter) )
            $this->db->limit( $filter['limit'] );
        else
            $this->db->limit( 10 );

        $this->db->order_by('id', 'RANDOM');

        $this->db->where('u.removed', 0);

        $query = $this->db->get();

        foreach($query->result() as $row){

            if( $row->company_id ) {
                $row->company   = $this->Company_model->get_company_by_id( $row->company_id );
            } else {
                $row->company = false;
            }
            $output[] = $row;
        }

        return $output;

    }

    public function get_partners_for_request__new( $filter = array() ) {

        $output = array();

        $this->db->select('u.id, u.name, u.phone, u.last_name, u.second_name, u.company_id, u.rating_points, u.rating_counts, (u.rating_points/u.rating_counts) as rating, c.name as city, c.city_id, u.avatar,');
        $this->db->from('users as u');
        $this->db->join('data_city c', 'u.city = c.city_id');
        $this->db->join('users_plans up', 'up.user_id = u.id');

        if( array_key_exists('brand',$filter) && !empty( $filter['brand']) ) {
            $this->db->join('users_brands ub', 'u.id = ub.user_id');
            $this->db->where('ub.brand_id', $filter['brand']);
        }

        $this->db->where('u.removed', 0);

        $this->db->where('u.rating_counts <', 5);
        $this->db->where('u.name !=', '');
        $this->db->where('u.last_name !=', '');
        $this->db->where('u.id !=', 1); // Исключаем EXDOR

        $this->db->group_start();
            $this->db->or_where('u.direction', 'sell');
            $this->db->or_where('u.direction', 'all');
        $this->db->group_end();

        if( array_key_exists('exclude_users',$filter) && !empty( $filter['exclude_users']) )
            $this->db->where_not_in('u.id', $filter['exclude_users']);

        if( array_key_exists('limit',$filter) )
            $this->db->limit( $filter['limit'] );
        else
            $this->db->limit( 10 );

        $this->db->order_by('id', 'RANDOM');

        $this->db->where('u.removed', 0);

        $query = $this->db->get();

        foreach($query->result() as $row){

            if( $row->company_id ) {
                $row->company   = $this->Company_model->get_company_by_id( $row->company_id );
            } else {
                $row->company = false;
            }
            $output[] = $row;
        }

        return $output;

    }




    private function build_partner ( $partner ) {

        if ( $partner->removed ) {

            $partner->avatar        = "";
            $partner->status        = "Пользователь деактивирован";
            $partner->company       = false;
            $partner->company_id    = false;

        }
        else {

            if ($partner->name == '' && $partner->last_name == '')
                $partner->name = $partner->phone;

            if ($partner->company_id) {
                $partner->company = $this->Company_model->get_company_by_id($partner->company_id);
            } else {
                $partner->company = false;
            }

        }

        return $partner;

    }
}