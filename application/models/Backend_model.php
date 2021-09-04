<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 10.05.16
 * Time: 16:29
 */

class Backend_model extends CI_Model {

    public function login ($user_name, $user_pass) {

        $query = $this->db->get_where('managers', array('user_name' => $user_name, 'password' => sha1($user_pass)), 1);

        if( $query->result() ){
            foreach ($query->result() as $row)
            {
                $this->session->set_userdata(
                    array(
                        "manager"       => $row->id,
                    )
                );
                return true;
            }
        } else {
            return false;
        }
    }

    public function logout (){
        $this->session->unset_userdata('manager');
        return true;
    }

    public function is_auth_manager () {
        if ( $this->session->userdata('manager') ) {
            return true;
        } else
            return false;
    }


}