<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 10.09.16
 * Time: 13:16
 */

class Equipment_model extends CI_Model {

    public function get_items ( $owner = 0, $filter = array() ) {

        $this->db       ->select('*')
                        ->from('equipment');

        if ( array_key_exists('brand', $filter) && !empty($filter['brand']) )
        {
            $this->db->group_start();
            foreach( $filter['brand'] as $b )
            {
                $this->db->or_where('brand', $b );
            }
            $this->db->group_end();
        }


        $this->db       ->where('owner', $owner)
                        ->where('show_in_park', 1)
                        ->where('removed', 0)
                        ->order_by('id', 'DESC');


        $result = array();
        $query = $this->db->get();
        if($query->result()) {
            foreach($query->result() as $row) {

                $row->images        = json_decode( $row->images );

                if( is_array( $row->images ) && !empty( $row->images ) )
                {
                    foreach ($row->images as $row_thumbnail)
                    {
                        $row->thumbnail     = $row_thumbnail;
                        $row->thumbnail_out = $row_thumbnail.'?v='.time();
                        break;
                    }
                }
                else
                {
                    $row->images        = false;
                    $row->thumbnail     = false;
                }

                if( $row->year == 0)
                    $row->year = '';

                if( $row->brand )
                    $row->brand_name    = $this->Option_model->get_directory_value( $row->brand );
                else
                    $row->brand_name    = '';
                if( $row->appointment )
                    $row->appointment_name  = $this->Option_model->get_directory_value( $row->appointment );
                else
                    $row->appointment_name  = '';
                $result[] = $row;
            }
            return $result;
        } else
            return false;

    }
    public function get_item ( $id ) {
        $query = $this->db->get_where('equipment', array('id' => $id));
        if($query->result()) {
            foreach($query->result() as $row) {
                $row->images        = json_decode( $row->images );

                if( is_array( $row->images ) && !empty( $row->images ) )
                {
                    foreach ($row->images as $row_thumbnail)
                    {
                        $row->thumbnail     = $row_thumbnail;
                        $row->thumbnail_out = $row_thumbnail.'?v='.time();
                        break;
                    }
                }
                else
                {
                    $row->images        = false;
                    $row->thumbnail     = false;
                }

                if( $row->year == 0)
                    $row->year = '';

                if( $row->brand )
                    $row->brand_name    = $this->Option_model->get_directory_value( $row->brand );
                else
                    $row->brand_name    = '';
                if( $row->appointment )
                    $row->appointment_name  = $this->Option_model->get_directory_value( $row->appointment );
                else
                    $row->appointment_name  = '';

                return $row;
            }
        }
        else
            return false;
    }

    public function add_item ( $options = array(), $images = array() ) {

        if( array_key_exists('id', $options)) {
            $original_id = $options['id'];
            unset( $options['id'] );
        } else {
            $original_id = false;
        }


        $this->db->insert('equipment', $options );
        $insert_id = $this->db->insert_id();
        $this->db->reset_query();



        if( is_array($images) && !empty($images))
        {
            $upload_images_db = array();
            foreach ( $images as $img )
            {
                $upload_image       = $this->Images_model->upload_base64_image( $img, 'equipment', $insert_id );
                $upload_images_db[] = $upload_image;
            }
            $this->db->where('id', $insert_id );
            $this->db->update('equipment', array('images' => json_encode($upload_images_db)) );
            $this->db->reset_query();
        }

        /* Для дублирования единиц парка техники копируем файлы в новую папку*/
        if( array_key_exists('images', $options) && $original_id) {

            $user_dir = './uploads/equipment/'.$insert_id;
            if( !is_dir($user_dir) )
            {
                mkdir($user_dir, 0775);
            };

            $source = './uploads/equipment/'.$original_id;
            $res    = './uploads/equipment/'.$insert_id;

            $hendle = opendir( $source ); // открываем директорию
            while ($file = readdir($hendle)) {
                if (($file!=".")&&($file!="..")) {
                    if (is_dir($source."/".$file) != true) {
                        if(is_dir($res."/".$file) != true) // существует ли папка
                        {
                            if(!copy($source."/".$file, $res."/".$file))
                            {
                                //print ("при копировании файла $file произошла ошибка...\n");
                            }// end if copy
                        }
                    }
                } // else $file == ..
            } // end while
            closedir($hendle);
        }


        return $insert_id;
    }

    public function edit_item ($id, $data) {


        $upload_images_db = array();


        if( array_key_exists('existing_images', $data)  && !empty( $data['existing_images'] ) )
        {
            foreach ( $data['existing_images'] as $img ) {
                $upload_images_db[] = $img;
            }
        }

        if( array_key_exists('post_images', $data) && !empty( $data['post_images'] ) )
        {
            foreach ( $data['post_images'] as $img ) {
                $upload_image       = $this->Images_model->upload_base64_image( $img, 'equipment', $id );
                $upload_images_db[] = $upload_image;
            }
        }

        unset( $data['post_images'] );
        unset( $data['existing_images'] );

        $data['images'] = json_encode($upload_images_db);





        $this->db->where('id', $id);
        if ( $this->db->update('equipment', $data) )
            return true;
        else
            return false;
    }
    public function remove_item ( $id = 0 ) {
        $this->db->where('id', $id);
        if ( $this->db->update('equipment', array('removed' => 1)) )
            return true;
        else
            return false;
    }
    public function undo_remove_item ( $id = 0 ) {
        $this->db->where('id', $id);
        if ( $this->db->update('equipment', array('removed' => 0)) )
            return true;
        else
            return false;
    }



    public function get_equipment_brands( $user_id ) {
        $this->db   ->select( 'brand' )
                    ->from('equipment')
                    ->where('owner', $user_id)
                    ->where('show_in_park', 1)
                    ->where('removed', 0);
        $query      = $this->db->get();

        $result = array();

        if($query->result()) {
            foreach ($query->result() as $row) {

                if( array_key_exists($row->brand, $result ) )
                {
                    $result[$row->brand]['count']++;
                }
                else
                {
                    $result[$row->brand] = array(
                        'id'            => $row->brand,
                        'name'          => $this->Option_model->get_directory_value( $row->brand ),
                        'count'         => 1
                    );
                }
            }
        }
        return( $result );
    }



    public function save_edit_image( $image='', $name='', $equipment_id = 0 ){

        if( $image && $name && $equipment_id )
        {
            $this->Images_model->upload_base64_image( $image, 'equipment', $equipment_id, $name );
            return true;
        }
        else
        {
            return false;
        }



    }
}
