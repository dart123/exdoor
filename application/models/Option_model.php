<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 28.05.16
 * Time: 14:22
 */

class Option_model extends CI_Model {

    public function get_option($option){

        $query = $this->db->get_where('options', array('name' => $option), 1, 0);
        foreach($query->result() as $row) {
            $value = $row->value;
        }
        return $value;
    }

    public function update_option($name, $value){
        $update_data = array(
            'value'     => $value
        );
        $this->db->where('name', $name);
        if ( $this->db->update('options', $update_data) )
            return true;
        else
            return false;
    }

    public function get_directory( $type='profession', $active=false) {
        $result = array();

        $this->db->from('directory');

        if($active == true)
            $this->db->where('active', 1);
        $this->db->where('type', $type);
        $this->db->order_by("active DESC, value ASC");

        $query = $this->db->get();

        foreach($query->result() as $row) {
            if( $row->id == 0 ) array_unshift($result, $row);
            else $result[] = $row;
        }

        return $result;
    }

    public function get_directory_value( $id = 0 ) {
        $this->db->where('id', $id)->limit(1);

        $query = $this->db->get('directory');
        foreach($query->result() as $row) {
            return $row->value;
        }
    }

    public function add_to_directory( $data ){
        $this->db->insert('directory', $data );
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function update_directory( $id, $data ) {
        $this->db->where('id', $id);
        if ( $this->db->update('directory', $data) )
            return true;
        else
            return false;
    }

    public function get_city( $keyword ) {

        $value = array();

        $query = $this->db->select('c.city_id, c.name, reg.name as region, cou.name as country')
            ->from('data_city c')
            ->join('data_region reg', 'c.region_id = reg.region_id')
            ->join('data_country cou', 'c.country_id = cou.country_id')
            ->like( 'c.name', $keyword, 'after' )
            ->limit(10)
            ->get();

        foreach($query->result() as $row) {
            $value[] = array(
                'value'     => $row->name,
                'data'      => $row
            );
        }
        return $value;
    }

    public function get_partnets( $keyword, $user_id ) {

        $value = array();

        $query = $this->db      ->select('rel.user_id, rel.partner_id, u.id, u.phone, u.name, u.last_name, u.avatar')
                                ->from('users_relationship rel')
                                ->join('users u', 'u.id = rel.partner_id')
                                ->where('rel.user_id', $user_id)
                                ->where('rel.partner_id !=', $user_id)
                                ->where('rel.relation', 3)
                                ->group_start()
                                    ->like( 'u.name', $keyword, 'after' )
                                    ->or_like( 'u.last_name', $keyword, 'after' )
                                    ->or_like( 'u.second_name', $keyword, 'after' )
                                ->group_end()
                                ->limit(10)
                                ->get();


        foreach($query->result() as $row) {
            $value[] = array(
                'value'     => $row->name,
                'data'      => $row
            );
        }
        return $value;
    }

    public function get_interlocutors ( $keyword, $user_id ) {

        $value = array();

        $query = $this->db      ->select('rel.user_id, rel.partner_id, u.id, u.phone, u.name, u.last_name, u.avatar')
                                ->from('users_relationship rel')
                                ->join('users u', 'u.id = rel.partner_id')
                                ->where('rel.user_id', $user_id)
                                ->where('rel.partner_id !=', $user_id)
                                ->where('rel.relation', 3)
                                ->group_start()
                                ->like( 'u.name', $keyword, 'after' )
                                    ->or_like( 'u.last_name', $keyword, 'after' )
                                    ->or_like( 'u.second_name', $keyword, 'after' )
                                ->group_end()
                                ->limit(10)
                                ->get();

        if( $query->result() ) {
            foreach($query->result() as $row) {
                $value[] = array(
                    'value'     => $row->name,
                    'data'      => $row
                );
            }
        }


        $this->db->flush_cache();


        $chatrooms_ids          = $this->Message_model->get_users_chatrooms_ids( $user_id );

        if( is_array($chatrooms_ids) && !empty($chatrooms_ids)) {

            $query = $this->db      ->select('mm.member_id as user_id, mm.member_id as partner_id, u.id, u.phone, u.name, u.last_name, u.avatar')
                                    ->from('users u')
                                    ->join('messages_members mm', 'u.id = mm.member_id')
                                    ->where_in('mm.chatroom_id', $chatrooms_ids)
                                    ->where('mm.member_id !=', $user_id)
                                    ->group_start()
                                    ->like( 'u.name', $keyword, 'after' )
                                    ->or_like( 'u.last_name', $keyword, 'after' )
                                    ->or_like( 'u.second_name', $keyword, 'after' )
                                    ->group_end()
                                    ->limit(10)
                                    ->get();


            if( $query->result() ) {
                foreach($query->result() as $row) {
                    $value[] = array(
                        'value'     => $row->name,
                        'data'      => $row
                    );
                }
            }

        }



        return $value;

    }

}