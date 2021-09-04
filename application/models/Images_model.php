<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 03.10.16
 * Time: 12:20
 */

class Images_model extends CI_Model {

    public function upload_base64_image( $base64img = '', $type = '', $id = '', $image_name = '' ) {

        switch ($type){
            case 'companies':
                $user_dir = './uploads/companies/'.$id;
                if( !is_dir($user_dir) )
                {
                    mkdir($user_dir);
                };
                break;
            case 'messages':
                $user_dir = './uploads/messages/'.$id;
                if( !is_dir($user_dir) )
                {
                    mkdir($user_dir);
                };
                break;
            case 'news':
                $user_dir = './uploads/news/'.$id;
                if( !is_dir($user_dir) )
                {
                    mkdir($user_dir);
                };
                break;
            case 'offers':
                $user_dir = './uploads/offers/'.$id;
                if( !is_dir($user_dir) )
                {
                    mkdir($user_dir);
                };
                break;
            case 'equipment':
                $user_dir = './uploads/equipment/'.$id;
                if( !is_dir($user_dir) )
                {
                    mkdir($user_dir);
                };
                break;
            case 'position':
                $user_dir = './uploads/positions/'.$id;
                if( !is_dir($user_dir) )
                {
                    mkdir($user_dir);
                };
                break;
        }

        $image_info     = explode(",", $base64img);

        $extention = '';

        if ( $image_info[0] == 'data:image/jpeg;base64') {
            $base64img      = str_replace('data:image/jpeg;base64,', '', $base64img);
            $extention      = 'jpg';
        } elseif ( $image_info[0] == 'data:image/jpg;base64' ) {
            $base64img      = str_replace('data:image/jpg;base64,', '', $base64img);
            $extention      = 'jpg';
        } elseif ( $image_info[0] == 'data:image/png;base64' ) {
            $base64img      = str_replace('data:image/png;base64,', '', $base64img);
            $extention      = 'png';
        } elseif ( $image_info[0] == 'data:image/gif;base64' ) {
            $base64img      = str_replace('data:image/gif;base64,', '', $base64img);
            $extention      = 'gif';
        } elseif ( $image_info[0] == 'data:image/bmp;base64' ) {
            $base64img      = str_replace('data:image/bmp;base64,', '', $base64img);
            $extention      = 'bmp';
        }



        if( !$image_name ){
            $file_name_no_extention     = uniqid();
            $file_name                  = $file_name_no_extention.'.'.$extention;
        }
        else {
            $file_name_no_extention     = pathinfo($image_name)['filename'];
            $file_name                  = $image_name;
        }

        $data           = base64_decode($base64img);
        $file           = $user_dir . '/' . $file_name;

        file_put_contents($file, $data);



        if( $extention == 'jpg' || $extention == 'png') {

            $input_file     = $user_dir.'/'.$file_name;
            $output_file    = $user_dir.'/'.$file_name_no_extention.'.jpg';

            if( $extention == 'png' ) {
                $input = imagecreatefrompng($input_file);
                list($width, $height) = getimagesize($input_file);
                $output = imagecreatetruecolor($width, $height);
                $white = imagecolorallocate($output,  255, 255, 255);
                imagefilledrectangle($output, 0, 0, $width, $height, $white);
                imagecopy($output, $input, 0, 0, 0, 0, $width, $height);
                imagejpeg($output, $output_file);
                imagepng($output, $input_file);
            }
            $this->image_fix_orientation( $output_file );
        }

        $this->load->library('image_moo');

        switch ($type){
            case 'companies':
                $this->image_moo
                    ->load($_SERVER["DOCUMENT_ROOT"].'/uploads/companies/'.$id.'/'.$file_name)
                    ->set_background_colour("#fff")
                    ->save($_SERVER["DOCUMENT_ROOT"].'/uploads/companies/'.$id.'/'.$file_name_no_extention.'.jpg', TRUE)
                    ->resize(1000, 1000)
                    ->set_background_colour("#fff")
                    ->set_jpeg_quality(70)
                    ->save($_SERVER["DOCUMENT_ROOT"].'/uploads/companies/'.$id.'/lg1000_'.$file_name_no_extention.'.jpg', TRUE)

                    ->resize_crop(780,520)
                    ->set_background_colour("#fff")
                    ->set_jpeg_quality(70)
                    ->save($_SERVER["DOCUMENT_ROOT"].'/uploads/companies/'.$id.'/large_'.$file_name_no_extention.'.jpg', TRUE)
                    ->resize(510,1500)
                    ->set_background_colour("#fff")
                    ->set_jpeg_quality(70)
                    ->save($_SERVER["DOCUMENT_ROOT"].'/uploads/companies/'.$id.'/large_r_'.$file_name_no_extention.'.jpg', TRUE)
                    ->resize_crop(375,280)
                    ->set_background_colour("#fff")
                    ->set_jpeg_quality(70)
                    ->save($_SERVER["DOCUMENT_ROOT"].'/uploads/companies/'.$id.'/medium_'.$file_name_no_extention.'.jpg', TRUE)
                    ->resize_crop(150,150)
                    ->set_background_colour("#fff")
                    ->set_jpeg_quality(70)
                    ->save($_SERVER["DOCUMENT_ROOT"].'/uploads/companies/'.$id.'/small_'.$file_name_no_extention.'.jpg', TRUE);


                break;
            case 'messages':

                $this->image_moo
                    ->load($_SERVER["DOCUMENT_ROOT"].'/uploads/messages/'.$id.'/'.$file_name)
                    ->set_background_colour("#fff")
                    ->save($_SERVER["DOCUMENT_ROOT"].'/uploads/messages/'.$id.'/'.$file_name_no_extention.'.jpg', TRUE)
                    ->resize(1000, 1000)
                    ->set_background_colour("#fff")
                    ->set_jpeg_quality(70)
                    ->save($_SERVER["DOCUMENT_ROOT"].'/uploads/messages/'.$id.'/lg1000_'.$file_name_no_extention.'.jpg', TRUE)

                    ->resize_crop(780,520)
                    ->set_background_colour("#fff")
                    ->set_jpeg_quality(70)
                    ->save($_SERVER["DOCUMENT_ROOT"].'/uploads/messages/'.$id.'/large_'.$file_name_no_extention.'.jpg', TRUE)
                    ->resize(510,1500)
                    ->set_background_colour("#fff")
                    ->set_jpeg_quality(70)
                    ->save($_SERVER["DOCUMENT_ROOT"].'/uploads/messages/'.$id.'/large_r_'.$file_name_no_extention.'.jpg', TRUE)
                    ->resize_crop(375,280)
                    ->set_background_colour("#fff")
                    ->set_jpeg_quality(70)
                    ->save($_SERVER["DOCUMENT_ROOT"].'/uploads/messages/'.$id.'/medium_'.$file_name_no_extention.'.jpg', TRUE)
                    ->resize_crop(150,150)
                    ->set_background_colour("#fff")
                    ->set_jpeg_quality(70)
                    ->save($_SERVER["DOCUMENT_ROOT"].'/uploads/messages/'.$id.'/small_'.$file_name_no_extention.'.jpg', TRUE);


                break;
            case 'news':

                $this->image_moo
                    ->load($_SERVER["DOCUMENT_ROOT"].'/uploads/news/'.$id.'/'.$file_name)
                    ->set_background_colour("#fff")
                    ->save($_SERVER["DOCUMENT_ROOT"].'/uploads/news/'.$id.'/'.$file_name_no_extention.'.jpg', TRUE)
                    ->resize(1000, 1000)
                    ->set_background_colour("#fff")
                    ->set_jpeg_quality(70)
                    ->save($_SERVER["DOCUMENT_ROOT"].'/uploads/news/'.$id.'/lg1000_'.$file_name_no_extention.'.jpg', TRUE)

                    ->resize_crop(780,520)
                    ->set_background_colour("#fff")
                    ->set_jpeg_quality(70)
                    ->save($_SERVER["DOCUMENT_ROOT"].'/uploads/news/'.$id.'/large_'.$file_name_no_extention.'.jpg', TRUE)
                    ->resize(780,1500)
                    ->set_background_colour("#fff")
                    ->set_jpeg_quality(70)
                    ->save($_SERVER["DOCUMENT_ROOT"].'/uploads/news/'.$id.'/large_r_'.$file_name_no_extention.'.jpg', TRUE)
                    ->resize_crop(375,280)
                    ->set_background_colour("#fff")
                    ->set_jpeg_quality(70)
                    ->save($_SERVER["DOCUMENT_ROOT"].'/uploads/news/'.$id.'/medium_'.$file_name_no_extention.'.jpg', TRUE)
                    ->resize_crop(150,150)
                    ->set_background_colour("#fff")
                    ->set_jpeg_quality(70)
                    ->save($_SERVER["DOCUMENT_ROOT"].'/uploads/news/'.$id.'/small_'.$file_name_no_extention.'.jpg', TRUE);

                break;
            case 'offers':

                $this->image_moo
                    ->load($_SERVER["DOCUMENT_ROOT"].'/uploads/offers/'.$id.'/'.$file_name)
                    ->set_background_colour("#fff")
                    ->save($_SERVER["DOCUMENT_ROOT"].'/uploads/offers/'.$id.'/'.$file_name_no_extention.'.jpg', TRUE)
                    ->resize(1000, 1000)
                    ->set_background_colour("#fff")
                    ->set_jpeg_quality(70)
                    ->save($_SERVER["DOCUMENT_ROOT"].'/uploads/offers/'.$id.'/lg1000_'.$file_name_no_extention.'.jpg', TRUE)

                    ->resize_crop(780,520)
                    ->set_background_colour("#fff")
                    ->set_jpeg_quality(70)
                    ->save($_SERVER["DOCUMENT_ROOT"].'/uploads/offers/'.$id.'/large_'.$file_name_no_extention.'.jpg', TRUE)
                    ->resize(780,1500)
                    ->set_background_colour("#fff")
                    ->set_jpeg_quality(70)
                    ->save($_SERVER["DOCUMENT_ROOT"].'/uploads/offers/'.$id.'/large_r_'.$file_name_no_extention.'.jpg', TRUE)
                    ->resize_crop(375,280)
                    ->set_background_colour("#fff")
                    ->set_jpeg_quality(70)
                    ->save($_SERVER["DOCUMENT_ROOT"].'/uploads/offers/'.$id.'/medium_'.$file_name_no_extention.'.jpg', TRUE)
                    ->resize_crop(150,150)
                    ->set_background_colour("#fff")
                    ->set_jpeg_quality(70)
                    ->save($_SERVER["DOCUMENT_ROOT"].'/uploads/offers/'.$id.'/small_'.$file_name_no_extention.'.jpg', TRUE);

                break;
            case 'equipment':

                $this->image_moo
                    ->load($_SERVER["DOCUMENT_ROOT"].'/uploads/equipment/'.$id.'/'.$file_name)
                    ->set_background_colour("#fff")
                    ->save($_SERVER["DOCUMENT_ROOT"].'/uploads/equipment/'.$id.'/'.$file_name_no_extention.'.jpg', TRUE)
                    ->resize(1000, 1000)
                    ->set_background_colour("#fff")
                    ->set_jpeg_quality(70)
                    ->save($_SERVER["DOCUMENT_ROOT"].'/uploads/equipment/'.$id.'/lg1000_'.$file_name_no_extention.'.jpg', TRUE)

                    ->resize_crop(780,520)
                    ->set_background_colour("#fff")
                    ->set_jpeg_quality(70)
                    ->save($_SERVER["DOCUMENT_ROOT"].'/uploads/equipment/'.$id.'/large_'.$file_name_no_extention.'.jpg', TRUE)
                    ->resize(780,1500)
                    ->set_background_colour("#fff")
                    ->set_jpeg_quality(70)
                    ->save($_SERVER["DOCUMENT_ROOT"].'/uploads/equipment/'.$id.'/large_r_'.$file_name_no_extention.'.jpg', TRUE)
                    ->resize_crop(375,280)
                    ->set_background_colour("#fff")
                    ->set_jpeg_quality(70)
                    ->save($_SERVER["DOCUMENT_ROOT"].'/uploads/equipment/'.$id.'/medium_'.$file_name_no_extention.'.jpg', TRUE)
                    ->resize_crop(158,158)
                    ->set_background_colour("#fff")
                    ->set_jpeg_quality(70)
                    ->save($_SERVER["DOCUMENT_ROOT"].'/uploads/equipment/'.$id.'/158x158_'.$file_name_no_extention.'.jpg', TRUE)
                    ->resize_crop(150,150)
                    ->set_background_colour("#fff")
                    ->set_jpeg_quality(70)
                    ->save($_SERVER["DOCUMENT_ROOT"].'/uploads/equipment/'.$id.'/small_'.$file_name_no_extention.'.jpg', TRUE);

                break;


            case 'position':

                $this->image_moo
                    ->load($_SERVER["DOCUMENT_ROOT"].'/uploads/positions/'.$id.'/'.$file_name)
                    ->set_background_colour("#fff")
                    ->save($_SERVER["DOCUMENT_ROOT"].'/uploads/positions/'.$id.'/'.$file_name_no_extention.'.jpg', TRUE)
                    ->resize(1000, 1000)
                    ->set_background_colour("#fff")
                    ->set_jpeg_quality(70)
                    ->save($_SERVER["DOCUMENT_ROOT"].'/uploads/positions/'.$id.'/lg1000_'.$file_name_no_extention.'.jpg', TRUE)

                    ->resize_crop(780,520)
                    ->set_background_colour("#fff")
                    ->set_jpeg_quality(70)
                    ->save($_SERVER["DOCUMENT_ROOT"].'/uploads/positions/'.$id.'/large_'.$file_name_no_extention.'.jpg', TRUE)
                    ->resize(780,1500)
                    ->set_background_colour("#fff")
                    ->set_jpeg_quality(70)
                    ->save($_SERVER["DOCUMENT_ROOT"].'/uploads/positions/'.$id.'/large_r_'.$file_name_no_extention.'.jpg', TRUE)
                    ->resize_crop(375,280)
                    ->set_background_colour("#fff")
                    ->set_jpeg_quality(70)
                    ->save($_SERVER["DOCUMENT_ROOT"].'/uploads/positions/'.$id.'/medium_'.$file_name_no_extention.'.jpg', TRUE)
                    ->resize_crop(150,150)
                    ->set_background_colour("#fff")
                    ->set_jpeg_quality(70)
                    ->save($_SERVER["DOCUMENT_ROOT"].'/uploads/positions/'.$id.'/small_'.$file_name_no_extention.'.jpg', TRUE);

                break;
        }



        return $file_name_no_extention.'.jpg';
    }







    public function upload_post_image( $post_img = '', $type = '', $id = '', $image_name = '' ) {

        $this->load->library('upload');             // Библиотека для загрузки аватара

        switch ($type) {
            case 'company':
                $user_dir = './uploads/companies/'.$id;
                if( !is_dir($user_dir) )
                {
                    mkdir($user_dir);
                };
                break;
        }
        $config_upload['upload_path']   = $user_dir;
        $config_upload['allowed_types'] = 'gif|jpg|png|jpeg';
        $config_upload['max_size']      = '8000';
        $config_upload['max_width']     = '5000';
        $config_upload['max_height']    = '5000';


        $this->upload->initialize($config_upload);

        if ( $this->upload->do_upload('logo')) {
            $this->load->library('image_moo');

            $uploaded_image = $this->upload->data();

            $this->image_moo->load($uploaded_image['full_path']);
            $this->image_moo->resize_crop(180, 180);
            $this->image_moo->set_background_colour("#fff");
            $this->image_moo->set_jpeg_quality(100);
            $this->image_moo->save($uploaded_image['file_path'] . '/' . '180x180_'.$uploaded_image['file_name'].'.jpg', TRUE);
            $this->image_moo->resize_crop(80, 80);
            $this->image_moo->set_background_colour("#fff");
            $this->image_moo->set_jpeg_quality(100);
            $this->image_moo->save($uploaded_image['file_path'] . '/' . '80x80_'.$uploaded_image['file_name'].'.jpg', TRUE);

            $update_data['logo'] = $uploaded_image['file_name'];
            //  Храним в БД только имя файла. Директория  /uploads/users/$user_id/avatar/$size_avatar

            $this->Company_model->update_company( $id, $update_data );



        }

    }


    private function image_fix_orientation( $filename ) {

        try {
            $exif       = @exif_read_data($filename);
        }
        catch (Exception $exp) {
            $exif = false;
        }

        if (!empty($exif['Orientation'])) {
            $image      = imagecreatefromjpeg( $filename );
            switch ($exif['Orientation']) {
                case 3:
                    $image = imagerotate($image, 180, 0);
                    break;
                case 6:
                    $image = imagerotate($image, -90, 0);
                    break;
                case 8:
                    $image = imagerotate($image, 90, 0);
                    break;
            }
            imagejpeg($image, $filename);
        }
    }


}