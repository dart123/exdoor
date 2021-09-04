<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 12.03.17
 * Time: 8:41
 */

class Notification_model extends CI_Model {

    public function get_notifications( $user_id  = 0) {

        $result = array();

        $query = $this->db  ->from('notifications')
                            ->where('user_id', $user_id )
                            ->get();

        if($query->result()) {
            foreach($query->result() as $row) {
                $result[] = $this->create_noty($row);
            }
            return $result;
        } else
            return false;
    }

    public function get_notification( $noty_id = 0 ) {

        $query = $this->db  ->from('notifications')
                            ->where('id', $noty_id )
                            ->get();

        if($query->result()) {
            foreach($query->result() as $row) {
                return $this->create_noty($row);
            }
        } else
            return false;
    }

    public function save_notification( $data = array() ) {

        $this->db->insert('notifications', $data );

        return $this->db->insert_id();

    }

    public function remove_notification( $noty_id = 0 ) {

        $this->db->where('id',$noty_id);
        $this->db->delete('notifications');

        return true;

    }

    public function form_notification( $data = array() ) {
        $noty = new stdClass;

        $noty->user_id      = $data['user_id'];
        $noty->from_id      = $data['from_id'];
        $noty->from_company = $data['from_company'];
        $noty->title        = $data['title'];
        $noty->content      = $data['content'];
        $noty->url          = $data['url'];

        if( array_key_exists('type', $data) )
            $noty->type         = $data['type'];
        else
            $noty->type         = false;

        if( array_key_exists('target', $data) )
            $noty->tg           = $data['target'];
        else
            $noty->tg           = false;



        return $this->create_noty( $noty );
    }

    public function target_complete( $user_id = 0, $target = 'main') {

        $this->db->where('user_id',$user_id);
        $this->db->where('target', $target);
        $this->db->delete('notifications');

        return true;

    }

    private function create_noty( $notification ) {

        if( $notification->from_company )
        {
            $notification->from_company     = true;
            $from_user      = $this->Company_model->get_company_by_id( $notification->from_id );
            $notification->from_id__avatar  = $from_user->logo;
        }
        else
        {
            $notification->from_company     = false;
            $from_user      = $this->User_model->get_user_by_id( $notification->from_id );
            $notification->from_id__avatar  = $from_user->avatar;
        }

        $notification->noty_json        = json_encode( $notification );

        return $notification;
    }

}
