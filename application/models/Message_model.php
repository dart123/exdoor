<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 26.07.16
 * Time: 19:58
 */

class Message_model extends CI_Model {

    public function get_dialogs( $id = false )  {

        $output = array();

        $query = $this->db  ->select('mc.id, mc.last_message_id, mm.unread')
                            ->from('messages_chatrooms mc')
                            ->join('messages_members mm', 'mm.chatroom_id = mc.id')
                            ->where('mm.member_id', $id)
                            ->order_by('mc.last_message_id', 'desc')
                            ->get();

        foreach ($query->result() as $row) {

            $last_message_id = $this->get__last_message_id($row->id);

            if ($last_message_id) {

                $row->last_message_id = $last_message_id;
                $row->last_message = $this->get_message_by_id($last_message_id);
                $row->member = $this->get_chatroom_members($row->id, array('exclude_users' => $this->session->user));

                if ($row->member->name != '') {
                    $row->typing_text = $row->member->name . ' печатает...';
                } else {
                    $row->typing_text = $row->member->phone . ' печатает...';
                }

                $output[] = $row;
            }
        }
        return $output;
    }

    //  Получаем только одного человека для диалога
    public function get_chatroom_members ( $chatroom_id = 0, $options  ){

        $this->db           ->select('u.id')
                            ->from('messages_members mm')
                            ->join('users u',  'mm.member_id = u.id')
                            ->where('mm.chatroom_id', $chatroom_id);

        if(array_key_exists('exclude_users', $options))
            $this->db->where_not_in('u.id', $options['exclude_users']);
        $query = $this->db->get();

        if( $query->result() ):

            foreach($query->result() as $row):
                return $this->User_model->get_user_by_id( $row->id );
            endforeach;
        else:
            return false;
        endif;

    }

    public function get_messages( $chatroom_id = 0, $limit = 15, $from = 0, $inverse = true ) {

        $output = array();

        $this->db   ->select('mes.id, mes.chatroom_id, mes.author_id, mes.images, mes.message, mes.date, mes.unread')
                    ->from('messages_messages mes')
                    ->where('mes.chatroom_id', $chatroom_id)

                    ->group_start()
                        ->or_group_start()
                                ->where('mes.author_id', $this->session->user)
                                ->where('mes.removed', 0)
                        ->group_end()

                        ->or_group_start()
                            ->where('mes.author_id !=', $this->session->user)
                            ->where('mes.removed_by_opponent', 0)
                        ->group_end()
                    ->group_end();

        if( $from != 0 )
            $this->db->where('mes.id <', $from );

        $this->db   ->order_by("mes.id desc")
                    ->limit($limit);

        $query = $this->db->get();

        if( $query->result() ){
            foreach($query->result() as $row){
                $message = $this->create_message( $row );
                $output[] = $message;
            }
            if ($inverse)
                return array_reverse($output);
            else return $output;

        } else return false;
    }

    public function get_message_by_id( $id = 0) {

        $query = $this->db  ->select('mes.id, mes.chatroom_id, mes.author_id, mes.message, mes.images, mes.date, mes.unread, mes.removed')
                            ->from('messages_messages mes')
                            ->where('mes.id', $id)
                            ->get();

        if( $query->result() ) {

            foreach ($query->result() as $row) {
                $message = $this->create_message( $row );
                return $message;

            }
        } else return false;
    }

    public function get_opponent_id ( $chatroom_id = 0, $member_id = 0) {
        $query = $this->db  ->select('member_id')
                            ->from('messages_members')
                            ->where('chatroom_id', $chatroom_id)
                            ->where('member_id !=', $member_id)
                            ->get();

        if( $query->result() ) {
            foreach ($query->result() as $row) {
                return $row->member_id;
            }
        } else return false;
    }

    public function edit_message( $chatroom_id = 0, $message_id = 0, $update_data = array() ) {

        $old_message    = $this->get_message_by_id( $message_id );

        $update_data['message']     = htmlspecialchars( $update_data['message'] );

        if( $old_message->editable ) {

            $upload_images_db = array();

            if( array_key_exists('post_images', $update_data) && !empty( $update_data['post_images'] ) )
            {
                foreach ( $update_data['post_images'] as $img ) {
                    $upload_image       = $this->Images_model->upload_base64_image( $img, 'messages', $chatroom_id );
                    $upload_images_db[] = $upload_image;
                }
            }

            if( array_key_exists('existing_images', $update_data)  && !empty( $update_data['existing_images'] ) )
            {
                foreach ( $update_data['existing_images'] as $img ) {
                    $upload_images_db[] = $img;
                }
            }

            unset( $update_data['post_images'] );
            unset( $update_data['existing_images'] );

            $update_data['images'] = json_encode($upload_images_db);

            $this->db->where('id', $message_id);
            $this->db->where('unread', 1);
            if ( $this->db->update('messages_messages', $update_data) )
                return true;
            else
                return false;

        }
        else {
            return false;
        }

    }

    public function remove_message( $message_id ) {

        $data = array(
            'removed'   => 1
        );

        $this->db->where('id', $message_id);
        if ( $this->db->update('messages_messages', $data) )
            return true;
        else return false;

    }

    public function remove_message_by_oponent( $message_id ) {

        $data = array(
            'removed_by_opponent'   => 1
        );

        $this->db->where('id', $message_id);
        if ( $this->db->update('messages_messages', $data) )
            return true;
        else
            return false;

    }

    public function restore_message( $message_id ) {
        $data = array(
            'removed'   => 0
        );

        $this->db->where('id', $message_id);
        if ( $this->db->update('messages_messages', $data) )
            return true;
        else
            return false;
    }

    public function delete_message( $message_id ){

        $this_message       = $this->get_message_by_id( $message_id );
        $chatroom_id        = $this_message->chatroom_id;

        $this->db->where('id', $message_id);
        if ( $this->db->delete('messages_messages') ) {

            $opponent_id        = $this->get_opponent_id( $chatroom_id);

            if( $last_message_id    = $this->get__last_message_id( $chatroom_id ) ) {
                $last_message       = $this->get_message_by_id( $last_message_id );

                if( $last_message->unread == 0 )
                    $this->mark_read_dialog( $chatroom_id, $opponent_id );

            } else {
                $this->remove_dialog( $chatroom_id );
            }

            return true;
        } else return false;

    }

    public function is_unread_message ( $message_id ) {

        $this->db           ->select('unread')
                            ->from('messages_messages')
                            ->where('id', $message_id);

        $query = $this->db->get();

        if( $query->result() ) {

            foreach($query->result() as $row){
                if( $row->unread == 1 )
                    return true;
                else return false;
            }

        } else return false;
    }

    public function new_dialog( $members = array() ) {
        if(!empty($members)){

            $this->db->insert('messages_chatrooms', array('last_message_id' => 0) );
            $chatroom_id = $this->db->insert_id();

            foreach ($members as $member_id) {
                $insert_data = array(
                    'chatroom_id'   => $chatroom_id,
                    'member_id'     => $member_id
                );
                $this->db->insert('messages_members', $insert_data);
            }
            return $chatroom_id;
        } else
            return false;
    }

    public function read_messages( $chatroom, $user ) {

        $opponent           = $this->get_opponent_id($chatroom, $user);

        $this->db->where('chatroom_id', $chatroom);
        $this->db->where('author_id', $opponent);
        $this->db->where('unread', 1);

        if ( $this->db->update('messages_messages', array('unread' => 0)) )
            return true;
        else
            return false;
    }

    public function mark_read_dialog( $chatroom_id, $user_id ){
        $update_data = array(
            'unread'   => 0
        );
        $this->db->where('chatroom_id', intval($chatroom_id) );
        $this->db->where('member_id', intval($user_id) );
        $this->db->update('messages_members', $update_data);

        return true;
    }

    public function remove_dialog ( $chatroom_id = 0 ) {

        $this->db->where('id', $chatroom_id);
        $this->db->delete('messages_chatrooms');

        return true;
    }

    public function is_dialog_exist( $members = array() ) {

        if( !empty($members) ){
            $query = $this->db->select('m1.chatroom_id as chatroom_id, m1.member_id as user_1, m2.member_id as user_2')
                ->from('messages_members m1')
                ->join('messages_members m2', 'm1.chatroom_id = m2.chatroom_id')
                ->where('m1.member_id', $members[0])
                ->where('m2.member_id', $members[1])
                ->get();

            if( $query->result() ) {
                foreach ($query->result() as $row) {
                    return ($row->chatroom_id);
                }
            } else return false;
        } else {
            return false;
        }
    }

    public function send_message(  $author = '0', $chatroom = '0', $message = '' , $images = array() ) {

        $insert_ids     = array();

        if ( mb_strlen($message) > 5000 ) {

            while (mb_strlen($message) > 5000) {

                $insert_ids[]   = $this->send_message($author, $chatroom, mb_substr($message, 0, 4997) . '...');

                $message = '...' . mb_substr($message, 4997);

            }
        }

        $data = array(
            'author_id'         => intval($author),
            'chatroom_id'       => intval($chatroom),
            'message'           => htmlspecialchars( $message ),
        );

        $this->db->insert('messages_messages', $data );
        $insert_id = $this->db->insert_id();

        $this->db->reset_query();

        if( !empty($insert_ids) )
            $insert_ids[]   = $insert_id;

        if(!empty($images)) {
            $upload_images_db = array();
            foreach ( $images as $img ) {
                $upload_image       = $this->Images_model->upload_base64_image( $img, 'messages', $chatroom );
                $upload_images_db[] = $upload_image;
            }
            $this->db->where('id', $insert_id );
            $this->db->update('messages_messages', array('images' => json_encode($upload_images_db)) );
            $this->db->reset_query();
        }

        $update_data = array(
            'last_message_id'   => $insert_id
        );
        $this->db->where('id', intval($chatroom) );
        $this->db->update('messages_chatrooms', $update_data);

        $this->db->reset_query();

        // Указываем что сообщение не прочинатно опонентом

        $update_data = array(
            'unread'   => 1
        );
        $this->db->where('chatroom_id', intval($chatroom) );
        $this->db->where('member_id !=', intval($author) );
        $this->db->update('messages_members', $update_data);


        if( !empty($insert_ids) )
            return $insert_ids;
        else
            return $insert_id;

    }


    /*
     *
     *      условные
     *
     */

    public function is_message_author ( $user_id, $message_id ) {
        $query      = $this->db     ->select('author_id')
                                    ->from('messages_messages')
                                    ->where('id', $message_id)
                                    ->get();

        if( $query->result() ) {
            foreach ($query->result() as $row) {
                if( $row->author_id == $user_id ) {
                    return true;
                } else return false;
            }
        } else return false;
    }

    public function get_users_chatrooms_ids ( $user_id = 0 ) {
        $output = array();

        $query = $this->db      ->select('mc.id')
                                ->from('messages_chatrooms mc')
                                ->join('messages_members mm', 'mm.chatroom_id = mc.id')
                                ->where('mm.member_id', $user_id)
                                ->get();

        if( $query->result() ) {
            foreach($query->result() as $row){
                $output[]   = $row->id;
            }
            return $output;
        } else return false;


    }

    public function is_user_in_dialog( $user_id, $chatroom_id ) {
        $this->db   ->from('messages_members')
                    ->where('chatroom_id', $chatroom_id)
                    ->where('member_id', $user_id)
                    ->limit(1);

        $query = $this->db->get();

        if( $query->result() ) {
            return true;
        }
        else
            return false;
    }

    public function count_unread_dialogs( $user_id = 0 ){

        $this->db->from('messages_members');
        $this->db->where('member_id', $user_id);
        $this->db->where('unread', 1);

        return $this->db->count_all_results();
    }

    private function get__last_message_id( $chatroom_id = 0 ){
        $this->db   ->select('mes.id')
                    ->from('messages_messages mes')
                    ->where('mes.chatroom_id', $chatroom_id)
                    ->where('mes.removed', 0)
                    ->order_by('id', 'DESC')
                    ->limit(1);

        $query = $this->db->get();

        if( $query->result() ) {
            foreach ($query->result() as $row) {
                return (int) $row->id;
            }
        }
        else
            return false;
    }

    private function create_message( $message ){

        $author     = $this->User_model->get_user_by_id( $message->author_id );

        $message->avatar    = $author->avatar;
        $message->name      = $author->name;
        $message->last_name = $author->last_name;
        $message->phone     = $author->phone;

        $d          = new DateTime( $message->date );
        $day        = $d->format('j');
        $date       = explode(".", $d->format('m'));

        if( $message->author_id == $this->session->user ) {
            $message->is_author     = true;
            if ($message->unread == 1 )  {
                $message->unread        = true;
                $message->editable      = true;
            }
            else {
                $message->unread        = false;
                $message->editable      = false;
            }
        } else {
            $message->is_author     = false;
            $message->unread        = false;
            $message->editable      = false;
        }

        switch ($date[0]){
            case 1:     $m='января';    break;
            case 2:     $m='февраля';   break;
            case 3:     $m='марта';     break;
            case 4:     $m='апреля';    break;
            case 5:     $m='мая';       break;
            case 6:     $m='июня';      break;
            case 7:     $m='июля';      break;
            case 8:     $m='августа';   break;
            case 9:     $m='сентября';  break;
            case 10:    $m='октября';   break;
            case 11:    $m='ноября';    break;
            case 12:    $m='декабря';   break;
        }
        $message->date      = $day.' '.$m.' '.$d->format('H:i');
        if( $message->message ){
            $message->message_for_edit  = htmlspecialchars_decode($message->message);
            $message->message_preview   = mb_substr( nl2br(htmlspecialchars_decode($message->message)) ,0,90).' ';
            $message->message           = auto_link($message->message, 'both', TRUE);

            $message->message           = preg_replace('/<a (.*?)>(.*?)<\/a>/', '<a $1 class="is-blue-link"><span>$2</span></a>', $message->message);
        } else {
            $message->message           = '';
            $message->message_for_edit  = '';
            $message->message_preview   = '';
        }

        if( $message->images ) {
            $message->images = json_decode( $message->images );
        } else {
            $message->images = '';
        }

        if( is_array( $message->images) && !empty($message->images) ) {
            $message->message_preview   .= '<i>(Прикрепленные изображения: '.count( $message->images ).')</i>';
        }

        return $message;

    }

}