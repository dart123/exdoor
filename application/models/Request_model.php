<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 10.09.16
 * Time: 13:17
 */


function archived_requests_combinator__oldest($a, $b) {

    if ( $a->id == $b->id ) {
        return 0;
    }
    return ($a->id > $b->id) ? +1 : -1;

}

function archived_requests_combinator__last($a, $b) {

    if ( $a->id == $b->id ) {
        return 0;
    }
    return ($a->id < $b->id) ? +1 : -1;

}

function archived_requests_combinator__updated($a, $b) {

    $a_last_update  = new DateTime($a->last_update);
    $b_last_update  = new DateTime($b->last_update);

    return ($a_last_update->format('U') < $b_last_update->format('U')) ? +1 : -1;
}


class Request_model extends CI_Model {


    /**
     * @param $id
     * @return bool
     * @throws Exception
     */
    public function get_request ($id ) {

        $query = $this->db->get_where('requests', array('id' => $id));

        if($query->result()) {
            foreach($query->result() as $row) {

                $row->eq_images        = json_decode( $row->eq_images );

                if( is_array( $row->eq_images ) && !empty( $row->eq_images ) )
                {
                    foreach ($row->eq_images as $row_thumbnail)
                    {
                        $row->eq_thumbnail     = $row_thumbnail;
                        $row->eq_thumbnail_out = $row_thumbnail.'?v='.time();
                        break;
                    }
                }
                else
                {
                    $row->eq_images        = false;
                    $row->eq_thumbnail     = false;
                }

                if( $row->eq_year == 0)
                    $row->eq_year = '';

                if( $row->eq_editable == 1)
                    $row->eq_editable = true;
                else $row->eq_editable = false;

                /* Вычисляем уровень заполненности заявки */
                $progress_fill = 0;
                if ($row->eq_brand) $progress_fill  += 12.5;
                if ($row->eq_appointment) $progress_fill += 12.5;
                if ($row->eq_model) $progress_fill  += 12.5;
                if ($row->eq_serial_number) $progress_fill  += 12.5;
                if ($row->eq_engine) $progress_fill  += 12.5;
                if ($row->eq_year) $progress_fill  += 12.5;
                if ($row->eq_section) $progress_fill  += 12.5;
                if ($row->eq_images) $progress_fill  += 12.5;

                $row->progress = intval( $progress_fill / 2);


                // Возможности по статусам


                if( $row->author == $this->session->user ):

                    $row->is_author         = true;
                    $row->is_executor       = false;
                    $row->can__compare      = false;
                    $row->can__set_rating   = false;
                    $row->can__clone        = true;
                    $row->can__cancel       = true;
                    $row->finished          = false;
                    $row->can__archived     = false;
                    $row->html_compare_url  = '/requests/'.$row->id.'/compare';


                    switch( $row->status ) {
                        case 'answered':
                            $row->can__compare  = true;
                            break;
                        case 'in_process':
                            $row->can__compare  = true;
                            $row->show_rating   = false;
                            $row->can__set_rating   = true;
                            break;
                        case 'payed':
                            $row->can__compare  = true;
                            $row->show_rating   = false;
                            $row->can__set_rating   = true;
                            break;
                        case 'delivered':
                            $row->can__compare  = true;
                            $row->show_rating   = false;
                            $row->can__set_rating   = true;
                            break;
                        case 'payed_delivered':
                            $row->can__compare  = true;
                            $row->show_rating   = false;
                            $row->can__set_rating   = true;
                            break;
                        case 'done':
                            $row->can__compare  = true;
                            $row->show_rating   = false;
                            $row->can__cancel       = false;

                            $row->finished      = true;

                            $now                    = new DateTime();
                            $last_up                = new DateTime($row->last_update);
                            $last_up->modify('+7 day');

                            if( $last_up->format('U') > $now->format('U'))
                                $row->can__set_rating   = true;
                            else
                                $row->can__set_rating   = false;

                            break;
                        case 'finished':
                            $row->can__set_rating   = true;
                            $row->can__compare      = true;
                            $row->can__archived     = true;
                            $row->can__cancel       = false;

                            $now                    = new DateTime();
                            $last_up                = new DateTime($row->last_update);
                            $last_up->modify('+7 day');

                            if( $last_up->format('U') > $now->format('U'))
                                $row->can__set_rating   = true;
                            else
                                $row->can__set_rating   = false;

                            break;
                        case 'canceled':
                        default:
                            $row->can__compare      = false;
                            $row->can__archived     = true;
                            $row->can__cancel       = false;

                            if( $row->executor != 0 ){
                                $now                    = new DateTime();
                                $last_up                = new DateTime($row->last_update);
                                $last_up->modify('+7 day');

                                if( $last_up->format('U') > $now->format('U'))
                                    $row->can__set_rating   = true;
                                else
                                    $row->can__set_rating   = false;
                            } else {
                                $row->can__set_rating       = false;
                            }


                            break;
                    }

                    if( $row->can__set_rating && $row->is_author && $row->rating_executor )
                        $row->show_rating       = true;

                    if( $row->archived == '1' ):
                        $row->can__archived     = false;
                    endif;

                elseif ( $row->executor == $this->session->user ):

                    $row->is_author         = false;
                    $row->is_executor       = true;
                    $row->can__clone        = false;
                    $row->finished          = false;
                    $row->can__set_rating   = false;
                    $row->can__compare      = false;
                    $row->can__archived     = false;
                    $row->can__cancel       = true;
                    $row->show_rating       = false;


                    switch( $row->status ) {
                        case 'in_process':
                            $row->show_rating   = false;
                            $row->can__set_rating   = true;
                            break;
                        case 'payed':
                            $row->show_rating   = false;
                            $row->can__set_rating   = true;
                            break;
                        case 'delivered':
                            $row->show_rating   = false;
                            $row->can__set_rating   = true;
                            break;
                        case 'payed_delivered':
                            $row->show_rating   = false;
                            $row->can__set_rating   = true;
                            break;
                        case 'done':
                            $row->show_rating   = false;
                            $row->can__set_rating   = true;
                            $row->can__archived     = true;
                            $row->can__cancel       = false;

                            $now                    = new DateTime();
                            $last_up                = new DateTime($row->last_update);
                            $last_up->modify('+7 day');

                            if( $last_up->format('U') > $now->format('U'))
                                $row->can__set_rating   = true;
                            else
                                $row->can__set_rating   = false;

                            break;
                        case 'finished':

                            if( !$row->show_rating && $row->executor == $this->session->user  )
                                $row->set_rating    = true;
                            $row->can__set_rating   = true;
                            $row->can__archived     = true;
                            $row->can__cancel       = false;

                            $now                    = new DateTime();
                            $last_up                = new DateTime($row->last_update);
                            $last_up->modify('+7 day');

                            if( $last_up->format('U') > $now->format('U'))
                                $row->can__set_rating   = true;
                            else
                                $row->can__set_rating   = false;

                            break;
                        case 'canceled':
                        default:
                            $row->can__archived     = true;
                            $row->can__cancel       = false;

                            $now                    = new DateTime();
                            $last_up                = new DateTime($row->last_update);
                            $last_up->modify('+7 day');

                            if( $last_up->format('U') > $now->format('U'))
                                $row->can__set_rating   = true;
                            else
                                $row->can__set_rating   = false;

                            break;
                    }

                    if( $row->can__set_rating && $row->is_executor && $row->rating_author )
                        $row->show_rating       = true;

                    if( $row->archived == '1' ):
                        $row->can__archived     = false;
                    endif;

                else:

                    $row->is_author         = false;
                    $row->is_executor       = false;

                    $user_relation  = $this->get_user_request_relation( $row->id, $this->session->user );

                    if( $user_relation ):

                        $row->can__clone        = false;
                        $row->finished          = false;
                        $row->can__set_rating   = false;
                        $row->can__compare      = false;
                        $row->can__archived     = false;
                        $row->can__cancel       = true;

                        if( $row->archived == '1' )
                            $row->can__archived     = false;

                    endif;

                endif;

                return $row;
            }
        } else
            return false;
    }

    public function get_requests( $user_id ) {
        $result = array();
        $query = $this->db->order_by('date', 'DESC')->get_where('requests', array( 'author' => $user_id ) );
                if($query->result()) {
            foreach($query->result() as $row) {

                $row->eq_images        = json_decode( $row->eq_images );

                if( is_array( $row->eq_images ) && !empty( $row->eq_images ) )
                {
                    foreach ($row->eq_images as $row_thumbnail)
                    {
                        $row->eq_thumbnail     = $row_thumbnail;
                        $row->eq_thumbnail_out = $row_thumbnail.'?v='.time();
                        break;
                    }
                }
                else
                {
                    $row->eq_images        = false;
                    $row->eq_thumbnail     = false;
                }

                if( $row->eq_year == 0)
                    $row->eq_year = '';

                $row->positions     = $this->get_request_positions( $row->id );

                $result[] = $row;
            }
            return $result;
        } else
            return false;
    }

    public function get_list ( $user_id ) {
        $result = array();

        $partners = $this->Partner_model->get_partners( $user_id );

        if( $partners ) {
            foreach ( $partners as $partner )
            {
                $row = array();
                $row['author']      = $this->User_model->get_user_by_id( $partner->partner_id );
                $row['requests']    = $this->get_requests( $partner->partner_id );

                if( $row['requests'] != false )
                {
                    $result[]   = $row;
                }
            }

            if( !empty($result) )
                return $result;
            else
                return false;
        }
        else return false;
    }

    public function copy_request( $request_id ) {

        $request_for_clone      = $this->get_request( $request_id );
        $request_positions      = $this->get_request_positions( $request_id );

        $request_data   = array(
            'author'                => $request_for_clone->author,
            'executor'              => 0,
            'step'                  => 2,
            'status'                => 'send',
            'company_id'            => $request_for_clone->company_id,
            'eq_id'                 => $request_for_clone->eq_id,
            'eq_brand'              => $request_for_clone->eq_brand,
            'eq_brand_name'         => $request_for_clone->eq_brand_name,
            'eq_images'	            => json_encode($request_for_clone->eq_images),
            'eq_appointment'        => $request_for_clone->eq_appointment,
            'eq_appointment_name'   => $request_for_clone->eq_appointment_name,
            'eq_model'              => $request_for_clone->eq_model,
            'eq_serial_number'      => $request_for_clone->eq_serial_number,
            'eq_engine'             => $request_for_clone->eq_engine,
            'eq_year'               => $request_for_clone->eq_year,
            'eq_section'            => $request_for_clone->eq_section,
            'eq_editable'           => $request_for_clone->eq_editable
        );

        $new_request_id         = $this->create_request( $request_data );

        foreach ( $request_positions as $position ) {

            $new_position   = array(
                'request_id'    => $new_request_id,
                'detail'        => $position->detail,
                'catalog_num'   => $position->catalog_num,
                'amount'        => $position->amount,
                'images'        => $position->images,
            );

            $this->add_positions( $new_position );

        }

        $this->session->request_id      = $new_request_id;

        return true;

    }



    public function get_inbox_requests( $user_id = 0, $filter = array(), $show_author = false, $employers_list = false ) {

        $user       = $this->User_model->get_user_by_id( $user_id );

        $this->db   ->select('
                        r.id,
                        r.executor,
                        r.author,
                        r.status as request_status,
                        r.date,
                        r.rating_author,
                        r.rating_executor,
                        r.is_marked as is_marked_for_author,
                        
                        r.eq_id,
                        r.eq_brand,
                        r.eq_brand_name,
                        r.eq_images,
                        r.eq_appointment,
                        r.eq_appointment_name,
                        r.eq_model,
                        r.eq_serial_number,
                        r.eq_engine,
                        r.eq_year,
                        r.eq_section,
                        
                        rp.request_id,
                        rp.user_id,
                        rp.company_id,
                        rp.status,
                        rp.comment,
                        rp.actual,
                        rp.archived,
                        rp.last_update,
                        rp.viewed,
                        rp.is_marked as is_marked_for_partner,
                        
                        u.id as author_id,
                        u.name,
                        u.last_name,
                        u.second_name,
                        u.avatar
                    ')
                    ->from('requests_partners as rp')
                    ->join('requests as r', 'r.id = rp.request_id')
                    ->join('users as u', 'u.id = r.author')
                    ->where('rp.user_id', $user_id)
                    ->where('r.step', 4);                   // Для счетчика на странице

        if( $employers_list ) {
            $this->db->where('rp.company_id', $employers_list);
        } else {
            if ( $user->company_id && $user->company_status == 'accepted' ) {
                $this->db->group_start();
                    $this->db->or_where('rp.company_id', $user->company_id);
                    $this->db->or_where('rp.company_id', 0);
                $this->db->group_end();
            }
            else
            {
                $this->db->where('rp.company_id', 0);
            }
        }

        if( array_key_exists( 'archived', $filter) && $filter['archived'] != '' ) {
            $this->db->where('rp.archived', $filter['archived'] );
        } else {
            $this->db->where('rp.archived !=', 1);
        }

        if( array_key_exists('status', $filter) && !empty($filter['status']) ) {
            $this->db->group_start();
            foreach ( $filter['status'] as $filter_status ) {
                $this->db->or_where('rp.status', $filter_status );
            }
            $this->db->group_end();
        }

        if( array_key_exists('sort', $filter) && !empty($filter['sort']) ) {
            if( $filter['sort'] == 'oldest' )
                $this->db->order_by('rp.id ASC, rp.is_marked DESC' );
            if( $filter['sort'] == 'last' )
                $this->db->order_by('rp.id DESC, rp.is_marked DESC' );
            if( $filter['sort'] == 'updated' )
                $this->db->order_by('rp.last_update DESC, rp.is_marked DESC' );
            if( $filter['sort'] == 'marked' )
                $this->db->order_by('rp.is_marked DESC, rp.last_update DESC');
        } else {
            $this->db->order_by('rp.last_update DESC, rp.is_marked DESC' );
        }

        if( array_key_exists('date_from', $filter) && !empty($filter['date_from']) ) {
            $this->db->where('r.date >=', $filter['date_from']);
        }

        if( array_key_exists('date_to', $filter) && !empty($filter['date_to']) ) {
            /*  поправка для выбора */
            $date_to = new DateTime( $filter['date_to'] );
            $date_to->modify('+1 day');
            $filter['date_to'] = $date_to->format('Y-m-d');

            $this->db->where('r.date <=', $filter['date_to']);
        }


        if( array_key_exists('limit', $filter) && !empty($filter['limit']) ) {
            $this->db->limit( $filter['limit'] );
        }

        // получаем для списка заявок через APE сервер
        if( array_key_exists('request_id', $filter) && !empty($filter['request_id']) ) {
            $this->db->where('r.id', $filter['request_id']);
        }

        $query =    $this->db->get();

        $result = array();
        if($query->result()) {
            foreach($query->result() as $row) {
                $formed_request = $this->build_inbox_request__list($row, $show_author, $employers_list);
                if( is_object($formed_request) ) {
                    $result[]   = $formed_request;
                }

            }
            return $result;
        } else
            return false;
    }

    public function get_outbox_requests( $user_id = 0, $filter = array(), $show_author = false, $employers_list = false ) {

        $user   = $this->User_model->get_user_by_id( $user_id );

        $this->db   ->select('
                        r.id,
                        r.executor,
                        r.author,
                        r.status as request_status,
                        r.date,
                        r.rating_author,
                        r.rating_executor,
                        r.archived,
                        r.last_update,
                        r.is_marked,
                        
                        r.eq_id,
                        r.eq_brand,
                        r.eq_brand_name,
                        r.eq_images,
                        r.eq_appointment,
                        r.eq_appointment_name,
                        r.eq_model,
                        r.eq_serial_number,
                        r.eq_engine,
                        r.eq_year,
                        r.eq_section,
                    ')
                    ->from('requests as r')
                    ->where('r.step', 4)
                    ->where('r.author', $user_id);

        if( $employers_list ) {
            $this->db->where('r.company_id', $employers_list);
        } else {
            if ( $user->company_id && $user->company_status == 'accepted' ) {
                $this->db->group_start();
                $this->db->or_where('r.company_id', $user->company_id);
                $this->db->or_where('r.company_id', 0);
                $this->db->group_end();
            }
            else
            {
                $this->db->where('r.company_id', 0);
            }
        }

        if( array_key_exists( 'archived', $filter) && $filter['archived'] != '' ) {
            $this->db->where('r.archived', $filter['archived'] );
        } else {
            $this->db->where('r.archived !=', 1);
        }

        if( array_key_exists('equipment', $filter) && !empty($filter['equipment']) ) {
            $this->db->group_start();
            foreach ( $filter['equipment'] as $filter_equipment ) {
                $this->db->or_where('r.eq_id', $filter_equipment );
            }
            $this->db->group_end();
        }

        if( array_key_exists('status', $filter) && !empty($filter['status']) ) {
            $this->db->group_start();
                foreach ( $filter['status'] as $filter_status ) {
                    $this->db->or_where('r.status', $filter_status );
                }
            $this->db->group_end();
        }

        if( array_key_exists('sort', $filter) && !empty($filter['sort']) ) {
            if( $filter['sort'] == 'oldest' )
                $this->db->order_by('r.id ASC, r.is_marked DESC' );
            if( $filter['sort'] == 'last' )
                $this->db->order_by('r.id DESC, r.is_marked DESC' );
            if( $filter['sort'] == 'updated' )
                $this->db->order_by('r.last_update DESC, r.is_marked DESC' );
            if( $filter['sort'] == 'marked' )
                $this->db->order_by('rp.is_marked DESC, rp.last_update DESC');
        } else {
            $this->db->order_by('r.last_update DESC, r.is_marked DESC' );
        }

        if( array_key_exists('date_from', $filter) && !empty($filter['date_from']) ) {
            $this->db->where('r.date >=', $filter['date_from']);
        }
        if( array_key_exists('date_to', $filter) && !empty($filter['date_to']) ) {
            /*  поправка для выбора */
            $date_to = new DateTime( $filter['date_to'] );
            $date_to->modify('+1 day');
            $filter['date_to'] = $date_to->format('Y-m-d');

            $this->db->where('r.date <=', $filter['date_to']);
        }

        if( array_key_exists('limit', $filter) && !empty($filter['limit']) ) {
            $this->db->limit( $filter['limit'] );
        }

        // получаем для списка заявок через APE сервер
        if( array_key_exists('request_id', $filter) && !empty($filter['request_id']) ) {
            $this->db->where('r.id', $filter['request_id']);
        }

        $query =        $this->db->get();

        if($query->result()) {
            foreach($query->result() as $row) {

                $row->user_id = $row->author;
                $result[] = $this->build_outbox_request__list( $row, $show_author, $employers_list );
            }
            return $result;
        } else
            return false;
    }

    public function get_archived_requests( $user_id = 0, $filter = array(), $show_author = false, $employers_list = false ) {

        $filter['archived'] = 1;
        $combined_data      = array();

        if( array_key_exists('equipment', $filter ) && !empty( $filter['equipment'] )  )
            $archived_inbox     = false;
        else
            $archived_inbox     = $this->get_inbox_requests( $user_id, $filter, $show_author, $employers_list );

        $archived_outbox    = $this->get_outbox_requests( $user_id, $filter, $show_author, $employers_list);

        if( is_array( $archived_inbox))
            foreach ( $archived_inbox as $a_in ) {
                $a_in->archived_request_title   = 'Входящая заявка';
                $combined_data[]    = $a_in;
            }

        if( is_array( $archived_outbox))
            foreach ( $archived_outbox as $a_out ) {
                $a_out->archived_request_title   = 'Исходящая заявка';
                $combined_data[]    = $a_out;
            }

        if( is_array( $archived_inbox) && is_array( $archived_outbox ) ) {


            if( array_key_exists('sort', $filter) && !empty($filter['sort']) ) {
                if( $filter['sort'] == 'oldest' ) {

                    usort($combined_data, "archived_requests_combinator__oldest");

                }

                if( $filter['sort'] == 'last' ) {

                    usort($combined_data, "archived_requests_combinator__last");

                }

                if( $filter['sort'] == 'updated' ) {

                    usort($combined_data, "archived_requests_combinator__updated");

                }
            } else {

                usort($combined_data, "archived_requests_combinator__updated");

            }



        } elseif( is_array( $archived_outbox ) ) {
            $combined_data = $archived_outbox;
        } elseif( is_array( $archived_inbox )) {
            $combined_data = $archived_inbox;
        }


        return $combined_data;

    }



    public function get_users_requests ( $user_id = 0, $filter = array() ) {

        $limit              = 5;
        $combined_data      = array();

        if( array_key_exists('limit', $filter) && !empty($filter['limit']) ) {
            $limit      = $filter['limit'];
        }

        $inbox_requests     = $this->get_inbox_requests( $user_id, array( 'limit' => $limit ) );
        $outbox_requests    = $this->get_outbox_requests( $user_id, array( 'limit' => $limit ) );


        if($inbox_requests)
        {
            foreach($inbox_requests as $in_r)
            {
                $combined_data[]    = $in_r;
            }
        }
        if($outbox_requests)
        {
            foreach ($outbox_requests as $out_r)
            {
                $combined_data[]    = $out_r;
            }
        }


        function cmp2($a, $b)
        {
            return strnatcmp($a->last_update, $b->last_update);
        }
        usort($combined_data, "cmp2");

        $reverse_result = array_reverse($combined_data);
        $result = array_slice($reverse_result, 0, $limit );

        return $result;
    }

    public function get_company_requests ( $company_id = '', $filter = array() ) {

        $employers      = $this->Company_model->get_company_employers_ids( $company_id );
        $director_id    = $this->Company_model->get_company_director_id( $company_id );

        $limit              = 5;
        $combined_data      = array();

        if( array_key_exists('limit', $filter) && !empty($filter['limit']) ) {
            $limit      = $filter['limit'];
        }

        if( $employers ) {
            foreach ( $employers as $employer ) {

                if ($employer != $director_id) {

                    $inbox_requests = $this->get_inbox_requests($employer, array('limit' => $limit), true, $company_id );
                    $outbox_requests = $this->get_outbox_requests($employer, array('limit' => $limit), true, $company_id);

                    if ($inbox_requests) {
                        foreach ($inbox_requests as $in_r) {
                            $in_r->archived_request_title   = 'Входящая заявка';
                            $in_r->can__compare         = false;
                            $in_r->can__set_rating      = false;
                            $in_r->can__archived        = false;
                            $in_r->can__cancel          = false;

                            $combined_data[] = $in_r;

                        }
                    }
                    if ($outbox_requests) {
                        foreach ($outbox_requests as $out_r) {
                            $out_r->archived_request_title   = 'Исходящая заявка';
                            $out_r->can__compare        = true;
                            $out_r->can__set_rating     = false;
                            $out_r->can__archived       = false;
                            $out_r->can__cancel         = false;

                            $combined_data[] = $out_r;

                        }
                    }

                }
            }

            usort($combined_data, "archived_requests_combinator__updated");

            $reverse_result = array_reverse($combined_data);
            $result = array_slice($reverse_result, 0, $limit );

            return $result;


        } else return false;








    }



    public function get_undone_requests ( $user_id ) {
        $this->db   ->select('
                        r.id,
                        r.executor,
                        r.author,
                        r.status,
                        r.date,
                        r.rating_author,
                        r.rating_executor,
                        
                        r.eq_id,
                        r.eq_brand,
                        r.eq_images,
                        r.eq_appointment,
                        r.eq_model,
                        r.eq_serial_number,
                        r.eq_engine,
                        r.eq_year,
                        r.eq_section,
                    ')
                    ->from('requests as r')
                    ->where('r.author', $user_id)
                    ->where('r.archived', 0)
                    ->where('r.step != 4');

        $query =        $this->db->get();

        if($query->result()) {
            foreach($query->result() as $row) {
                return $row;
            }
        } else
            return false;
    }

    public function get_request_positions ( $id ) {
        $result = array();
        $query = $this->db->get_where('requests_positions', array('request_id' => $id));
        if($query->result()) {
            foreach($query->result() as $row) {
                if( $row->images != '' )
                    $row->images_arr    = json_decode( $row->images );
                else
                    $row->images_arr    = array();

                $result[] = $row;

            }
            return $result;
        } else
            return false;
    }

    public function create_request ( $data ) {
        $now    = new DateTime();
        $data['date']   = $now->format('Y-m-d H:i:s');

        $this->db->insert('requests', $data );
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function add_positions ( $data ) {

        $this->db->insert('requests_positions', $data );

        return true;
    }

    public function remove_request( $request_id ) {

        $this->db->where('id', $request_id);
        $this->db->delete('requests');

        $this->db->reset_query();

        $this->remove_positions( $request_id );

        $this->session->unset_userdata('request_id');

        return true;


    }

    public function remove_positions( $request_id = 0 ) {
        $this->db->where('request_id', $request_id);
        $this->db->delete('requests_positions');
        return true;
    }

    public function update_request ( $id, $data, $update_timestamp = true ){

        if( isset($data['eq_brand']) && $data['eq_brand'] != '' )
            $data['eq_brand_name']     = $this->Option_model->get_directory_value( intval( $data['eq_brand'] ) );

        if( isset($data['eq_appointment']) && $data['eq_appointment'] != '' )
            $data['eq_appointment_name']    = $this->Option_model->get_directory_value( intval( $data['eq_appointment'] ) );

        $data['last_update_key']    = uniqid(); // Для обновления timestamp

        if( !$update_timestamp ) {
            $curent_timestamp       = $this->get_request( $id );
            $data['last_update']    =   $curent_timestamp->last_update;
        }


        $this->db->where('id', $id);
        if ( $this->db->update('requests', $data) )
            return true;
        else
            return false;
    }

    public function add_partner( $data ) {

        $this->db->insert_batch('requests_partners', $data);

        return true;
    }

    public function add_partners( $data ) {

        if( is_array( $data ) && !empty( $data ) ) {

            foreach ( $data as $insert_val ) {
                $this->db->insert('requests_partners', $insert_val);
            }
            return true;
        } else {
            return false;
        }

    }

    public function get_request_partners( $request_id ){

        $this->db   ->select(
                            '
                                r_partners.id as response_id,
                                r_partners.request_id, 
                                r_partners.user_id,
                                r_partners.status,
                                r_partners.last_status,
                                r_partners.can_re_response
                            '
                    )
                    ->from('requests_partners as r_partners')
                    ->where('r_partners.request_id', $request_id)
                    ->order_by('r_partners.sort_index');

        $query = $this->db->get();

        $result = array();
        if($query->result()) {
            foreach($query->result() as $row) {

                $partner                    = $this->User_model->get_user_by_id( $row->user_id );

                $row->name                  = $partner->name;
                $row->phone                 = $partner->phone;
                $row->last_name             = $partner->last_name;
                $row->second_name           = $partner->second_name;
                $row->company_id            = $partner->company_id;
                $row->company_status        = $partner->company_status;
                $row->profession            = $partner->profession;
                $row->avatar                = $partner->avatar;
                $row->show_phone            = $partner->show_phone;
                $row->email                 = $partner->email;
                $row->company_role          = $partner->company_role;
                $row->company_profession    = $partner->company_profession;
                $row->security_page         = $partner->security_page;
                $row->security_contacts     = $partner->security_contacts;
                $row->security_partners     = $partner->security_partners;
                $row->notice_popup_time     = $partner->notice_popup_time;

                $row->responses                 = $this->get_request_responses( $request_id, $row->user_id );
                $row->request_response_data     = $this->get_user_request_relation( $request_id, $row->user_id);
                $result[]       = $row;
            }
            return $result;
        } else
            return false;
    }

    public function get_request_partners_ids( $request_id ){

        $this->db       ->select('u.id')
                        ->from('requests_partners as r_partners')
                        ->join('users as u', 'r_partners.user_id = u.id')
                        ->where('r_partners.request_id', $request_id)
                        ->order_by('r_partners.sort_index');

        $query = $this->db->get();

        $result = array();
        if($query->result()) {
            foreach($query->result() as $row) {
                $result[]       = $row->id;
            }
            return $result;
        } else
            return false;

    }

    public function get_request_executor( $request_id, $user_id ){

        $this->db   ->select(
                            '
                                r_partners.request_id, 
                                r_partners.user_id,
                                r_partners.status,
                                r_partners.can_re_response,
                                u.id as user_id,
                                u.name, 
                                u.phone, 
                                u.last_name, 
                                u.second_name, 
                                u.company_id, 
                                u.company_status, 
                                u.profession,
                                u.avatar, 
                                u.show_phone, 
                                u.email,
                                u.rating_points,
                                u.rating_counts,
                                (u.rating_points / u.rating_counts) as rating,
                                u.company_role, 
                                u.company_profession, 
                                u.security_page, 
                                u.security_contacts, 
                                u.security_partners,
                                u.notice_popup_time
                            '
                            )
                    ->from('requests_partners as r_partners')
                    ->join('users as u', 'r_partners.user_id = u.id')
                    ->where('r_partners.user_id', $user_id)
                    ->where('r_partners.request_id', $request_id);

        $query = $this->db->get();

        if($query->result()) {
            foreach($query->result() as $row) {

                if( $row->name == '' && $row->last_name == '' ) {
                    $row->name = $row->phone;
                }

                if( $row->company_id )
                    $row->company   = $this->Company_model->get_company_by_id( $row->company_id );
                else
                    $row->company = false;

                if( $row->rating_counts >= 5 )
                    $row->rating     = intval( round($row->rating) );
                else
                    $row->rating     = false;

                $row->responses                 = $this->get_request_responses( $request_id, $user_id );
                $row->request_response_data     = $this->get_user_request_relation( $request_id, $user_id);
                return $row;
            }
        } else
            return false;
    }

    public function get_request_partners_count( $request_id ){

        $result             = array( 'send', 'read', 'answered', 'canceled', 'total');
        $request_status     = array( 'send', 'read', 'answered', 'canceled');
        $total              = 0;

        foreach ($request_status as $request_state) {
            $this->db   ->select(
                            '
                                r_partners.request_id,
                                r_partners.status,
                            '
            )
                ->from('requests_partners as r_partners')
                ->where('r_partners.request_id', $request_id)
                ->where('r_partners.status', $request_state);

            $number         = $this->db->count_all_results();

            if( $request_state == 'answered' )
                $total  += $number;

            $result[$request_state]     = $number;
        }

        $result['total']    = $total;

        return $result;
    }

    public function get_request_partners_count__last_status( $request_id ){

        $result             = array( 'send', 'read', 'answered', 'canceled', 'total');
        $request_status     = array( 'send', 'read', 'answered', 'canceled');
        $total              = 0;

        foreach ($request_status as $request_state) {
            $this->db   ->select(
                '
                                r_partners.request_id,
                                r_partners.last_status as status,
                            '
            )
                ->from('requests_partners as r_partners')
                ->where('r_partners.request_id', $request_id)
                ->where('r_partners.last_status', $request_state);

            $number         = $this->db->count_all_results();

            if( $request_state == 'answered' )
                $total  += $number;

            $result[$request_state]     = $number;
        }

        $result['total']    = $total;

        return $result;
    }

    public function get_user_request_relation ( $request_id, $user_id ) {

        $this->db
            ->from('requests_partners as r_partners')
            ->where('r_partners.request_id', $request_id)
            ->where('r_partners.user_id', $user_id)
            ->limit(1);

        $query = $this->db->get();

        if($query->result()) {
            foreach($query->result() as $row) {
                $row->disable   = false;

                if( $row->saved_actual != "0000-00-00") {
                    $saved_actual = new DateTime($row->saved_actual);
                    $row->saved_actual = $saved_actual->format('d.m.Y');
                } else {
                    $row->saved_actual = "";
                }

                if( $row->actual != "0000-00-00") {
                    $now            = new DateTime('now');
                    $actual         = new DateTime( $row->actual );
                    $row->actual    = $actual->format('d.m.Y');


                    if( $actual > $now || $row->status == 'canceled' || $row->status == 'finished' ) {
                        $row->disable   = true;
                    }
                } else {
                    $row->actual = "";
                }


                return $row;
            }
        } else
            return false;
    }

    public function set_executor( $request_id, $executor_id ) {

        $update_data = array(
            'executor'  => $executor_id,
            'status'    => 'in_process',
        );

        $this->update_request( $request_id, $update_data );

        $this->db->reset_query();

        $this->db   ->where('request_id', $request_id)
                    ->where('user_id !=', $executor_id)
                    ->update('requests_partners', array('status' => 'canceled', 'is_marked' => 0) );

        $this->db->reset_query();

        $this->db   ->where('request_id', $request_id)
                    ->where('user_id', $executor_id)
                    ->update('requests_partners', array('status' => 'in_proccess', 'is_marked' => 1) );

        return true;
    }

    private function partner_last_update( $id = 0 ) {
        $this->db->select('last_update')
                    ->from('requests_partners')
                    ->where('id', $id);

        $query = $this->db->get();

        if($query->result()) {
            foreach ($query->result() as $row) {
                return $row->last_update;
            }
        }
    }

    public function change_partners_request_data( $id, $data, $no_update = false) {

        if( $no_update ) {
            $data['last_update']     = $this->partner_last_update( $id );
        }

        $this->db->where('id', $id);
        if ( $this->db->update('requests_partners', $data) ) {
            return true;
        }

        else
            return false;
    }

    public function change_partners_request_data_by_request_id ( $user_id, $request_id, $data = array() ) {

        $this->db   ->where('request_id', $request_id)
                    ->where('user_id', $user_id);

        if ( $this->db->update('requests_partners', $data) )
            return true;
        else
            return false;
    }

    public function is_full_request_denied( $request_id ) {

        $query  = $this->db         ->from('requests_partners')
                                    ->where('status !=', 'canceled')
                                    ->where('request_id', $request_id)
                                    ->count_all_results();

        if( $query == 0 ) {
            $this->update_request($request_id, array('status' => 'canceled', 'is_marked' => 0));
            return true;
        } else
            return false;



    }

    public function request_denied ( $request_id ) {

        $this->update_request( $request_id, array( 'status' => 'canceled', 'is_marked' => 0 ));

        $this->db   ->where('request_id', $request_id);

        //if ( $this->db->update('requests_partners', array( 'status' => 'canceled', 'last_update' => 'last_update', 'is_marked' => 0)) )
        if ( $this->db->update('requests_partners', array( 'status' => 'canceled', 'is_marked' => 0)) )
            return true;
        else
            return false;

    }

    public function update_request_responses ( $data ) {

        foreach ($data as $response){
            $this->db->replace('requests_response', $response);
        }

    }


    public function get_request_response( $request_id, $user_id, $position_id ) {

        $this->db   ->from('requests_response')
                    ->where('request_id', $request_id)
                    ->where('user_id', $user_id)
                    ->where('position_id', $position_id);

        $query = $this->db->get();

        if($query->result()) {
            foreach($query->result() as $row) {
                return $row;
            }
        } else
            return false;
    }

    public function get_request_responses( $request_id, $user_id ) {

        $this->db   ->from('requests_response')
                    ->where('request_id', $request_id)
                    ->where('user_id', $user_id)
                    ->order_by('id');

        $query = $this->db->get();
        $result = array();

        if($query->result()) {
            foreach($query->result() as $row) {
                $result[$row->position_id]       = $row;
            }
            return $result;
        } else
            return false;
    }

    public function update_avalible_filter_options( $filter = array(), $user_id = 0, $type = 'outbox', $is_company = false ) {

        switch( $type ){
            case 'outbox':
                $this->db               ->select('status')
                                        ->from('requests')
                                        ->where('author', $user_id)
                                        ->where('archived', 0)
                                        ->where('step', 4);

                if ( is_numeric( $is_company ) ) :
                        $this->db->where('company_id', $is_company );
                elseif ( $is_company === false ) :
                        $this->db->where('company_id', 0);
                endif;

                $query      = $this->db->get();

                if($query->result()) {
                    foreach ($query->result() as $row) {
                        switch ($row->status) {
                            case 'send':
                            case 'read':
                            case 'answered':
                                $filter['formed'] = true;
                                break;

                            case 'in_process':
                            case 'payed':
                            case 'delivered':
                            case 'payed_delivered':
                                $filter['in_proccess'] = true;
                                break;

                            case 'canceled':
                                $filter['canceled'] = true;
                                break;
                            case 'finished':
                            case 'done':
                                $filter['done']     = true;
                                break;
                        }
                    }
                }
                break;
            case 'inbox':
                $this->db               ->select('status')
                                        ->from('requests_partners')
                                        ->where('user_id', $user_id)
                                        ->where('archived', 0 );

                /*
                if ( is_numeric( $is_company ) ) :
                    $this->db->where('company_id', $is_company );
                elseif ( $is_company === false ) :
                    $this->db->where('company_id', 0);
                endif;
*/
                $query      = $this->db->get();

                if($query->result()) {

                    foreach ($query->result() as $row) {

                        switch ($row->status) {
                            case 'send':
                            case 'read':
                            case 'answered':
                                $filter['formed'] = true;
                                break;

                            case 'in_process':
                            case 'payed':
                            case 'delivered':
                            case 'payed_delivered':
                                $filter['in_proccess'] = true;
                                break;

                            case 'canceled':
                                $filter['canceled'] = true;
                                break;
                            case 'finished':
                            case 'done':
                                $filter['done']     = true;
                                break;
                        }
                    }
                }
                break;
            case 'archive':
                $this->db      ->select('status')
                                        ->from('requests')
                                        ->where('author', $user_id)
                                        ->where('archived', 1)
                                        ->where('step', 4);

                if ( is_numeric( $is_company ) ) :
                    $this->db->where('company_id', $is_company );
                elseif ( $is_company === false ) :
                    $this->db->where('company_id', 0);
                endif;

                $query      = $this->db->get();

                if($query->result()) {
                    foreach ($query->result() as $row) {
                        switch ($row->status) {
                            case 'send':
                            case 'read':
                            case 'answered':
                                $filter['formed'] = true;
                                break;

                            case 'in_process':
                            case 'payed':
                            case 'delivered':
                            case 'payed_delivered':
                                $filter['in_proccess'] = true;
                                break;

                            case 'canceled':
                                $filter['canceled'] = true;
                                break;

                            case 'finished':
                            case 'done':
                                $filter['done']     = true;
                                break;
                        }
                    }
                }
                break;
        }

        return $filter;

    }

    public function count_inbox_requests( $user_id ) {

        $result = $this->db     ->select('
                                    rp.user_id,
                                    rp.status,
                                    rp.actual,
                                ')
                                ->from('requests_partners as rp')
                                ->where('rp.user_id', $user_id)
                                ->where('rp.archived', 0)
                                ->count_all_results();

        return intval( $result );
    }

    public function count_outbox_requests( $user_id ) {
        $result = $this->db     ->select('
                                    rp.user_id,
                                    rp.status,
                                    rp.actual,
                                ')
            ->from('requests_partners as rp')
            ->join('requests as r', 'r.id = rp.request_id')
            ->where('r.author', $user_id)
            ->where('r.archived', 0)
            ->count_all_results();

        return intval( $result );
    }

    public function count_requests( $user_id ) {
        return $this->count_inbox_requests( $user_id ) + $this->count_outbox_requests( $user_id );
    }

    public function count_inbox_requests_status ( $user_id, $status ) {
        switch ( $status ) {
            case 'formed':
                $result = $this->db     ->select('
                                    rp.user_id,
                                    rp.status,
                                    rp.actual,
                                ')
                    ->from('requests_partners as rp')
                    ->where('rp.user_id', $user_id)
                    ->group_start()
                        ->or_where('rp.status', 'send')
                        ->or_where('rp.status', 'read')
                        ->or_where('rp.status', 'answered')
                    ->group_end()
                    ->where('rp.archived', 0)
                    ->count_all_results();
                break;
            case 'process':
                $result = $this->db     ->select('
                                    rp.user_id,
                                    rp.status,
                                    rp.actual,
                                ')
                    ->from('requests_partners as rp')
                    ->where('rp.user_id', $user_id)
                    ->group_start()
                        ->or_where('rp.status', 'in_process')
                        ->or_where('rp.status', 'payed')
                        ->or_where('rp.status', 'delivered')
                        ->or_where('rp.status', 'payed_delivered')
                    ->group_end()
                    ->where('rp.archived', 0)
                    ->count_all_results();

                break;
            case 'done':
                $result = $this->db     ->select('
                                    rp.user_id,
                                    rp.status,
                                    rp.actual,
                                ')
                    ->from('requests_partners as rp')
                    ->where('rp.user_id', $user_id)
                    ->group_start()
                        ->or_where('rp.status', 'done')
                        ->or_where('rp.status', 'finished')
                    ->group_end()
                    ->where('rp.archived', 0)
                    ->count_all_results();

                break;

            case 'canceled':

                $result = $this->db     ->select('
                                    rp.user_id,
                                    rp.status,
                                    rp.actual,
                                ')
                    ->from('requests_partners as rp')
                    ->where('rp.user_id', $user_id)
                    ->where('rp.status', 'canceled')
                    ->where('rp.archived', 0)
                    ->count_all_results();

                break;
        }
        return intval( $result );
    }

    public function count_outbox_requests_status ( $user_id, $status ) {
        switch ( $status ) {
            case 'formed':
                $result = $this->db     ->select('
                                    rp.user_id,
                                    rp.status,
                                    rp.actual,
                                ')
                    ->from('requests_partners as rp')
                    ->join('requests as r', 'r.id = rp.request_id')
                    ->where('r.author', $user_id)
                    ->group_start()
                        ->or_where('r.status', 'send')
                        ->or_where('r.status', 'read')
                        ->or_where('r.status', 'answered')
                    ->group_end()
                    ->where('r.archived', 0)
                    ->count_all_results();


                break;
            case 'process':
                $result = $this->db     ->select('
                                    rp.user_id,
                                    rp.status,
                                    rp.actual,
                                ')
                    ->from('requests_partners as rp')
                    ->join('requests as r', 'r.id = rp.request_id')
                    ->where('r.author', $user_id)
                    ->group_start()
                        ->or_where('r.status', 'in_process')
                        ->or_where('r.status', 'payed')
                        ->or_where('r.status', 'delivered')
                        ->or_where('r.status', 'payed_delivered')
                    ->group_end()
                    ->where('r.archived', 0)
                    ->count_all_results();
                break;
            case 'done':
                $result = $this->db     ->select('
                                    rp.user_id,
                                    rp.status,
                                    rp.actual,
                                ')
                    ->from('requests_partners as rp')
                    ->join('requests as r', 'r.id = rp.request_id')
                    ->where('r.author', $user_id)
                    ->group_start()
                        ->or_where('r.status', 'done')
                        ->or_where('r.status', 'finished')
                    ->group_end()
                    ->where('r.archived', 0)
                    ->count_all_results();

                break;
            case 'canceled':
                $result = $this->db     ->select('
                                    rp.user_id,
                                    rp.status,
                                    rp.actual,
                                ')
                    ->from('requests_partners as rp')
                    ->join('requests as r', 'r.id = rp.request_id')
                    ->where('r.author', $user_id)
                    ->where('r.status', 'canceled')
                    ->where('r.archived', 0)
                    ->count_all_results();

                break;

        }
        return intval( $result );
    }

    public function count_archived_requests ( $user_id ) {


        $archived_inbox = $this->db     ->select('
                                    rp.user_id,
                                    rp.status,
                                    rp.actual,
                                ')
            ->from('requests_partners as rp')
            ->where('rp.user_id', $user_id)
            ->where('rp.archived', 1)
            ->count_all_results();

        $archived_outbox = $this->db     ->select('
                                    rp.user_id,
                                    rp.status,
                                    rp.actual,
                                ')
            ->from('requests_partners as rp')
            ->join('requests as r', 'r.id = rp.request_id')
            ->where('r.author', $user_id)
            ->where('r.archived', 1)
            ->count_all_results();

        return intval( $archived_inbox + $archived_outbox );
    }









    public function count_outbox_active_requests( $user_id ) {

        $user   = $this->User_model->get_user_by_id( $user_id );

        $this->db   ->from('requests as r')
                    ->where('r.is_marked', '1')
                    ->where('r.author', $user_id)
                    ->where('r.archived', 0);

        if ( is_object($user) && property_exists($user, 'company_id') && $user->company_status == 'accepted' ) {
            $this->db->group_start();
                $this->db->or_where('r.company_id', $user->company_id);
                $this->db->or_where('r.company_id', 0);
            $this->db->group_end();
        } else {
            $this->db->where('r.company_id', 0);
        }

        $result     = $this->db->count_all_results();

        return intval( $result );
    }

    public function count_inbox_active_requests( $user_id )
    {
        $user   = $this->User_model->get_user_by_id( $user_id );

        $this->db       ->from('requests_partners as rp')
                        ->where('rp.is_marked', '1')
                        ->where('rp.user_id', $user_id)
                        ->where('rp.archived', 0);

        if ( is_object($user) && property_exists($user, 'company_id') && $user->company_status == 'accepted' ) {
            $this->db->group_start();
                $this->db->or_where('rp.company_id', $user->company_id);
                $this->db->or_where('rp.company_id', 0);
            $this->db->group_end();
        } else {
            $this->db->where('rp.company_id', 0);
        }




        $result     = $this->db->count_all_results();

        return intval( $result );
    }

    public function count_active_requests( $user_id )
    {
        $inbox  = $this->count_inbox_active_requests( $user_id );
        $outbox = $this->count_outbox_active_requests( $user_id );

        return $inbox + $outbox;
    }





    public function get_user_filter( $user_id = 0, $type = 'inbox' ) {

        $query = $this->db  ->from('users_filter')
                            ->where( 'user_id', $user_id )
                            ->where( 'type', $type )
                            ->get();

        if($query->result()) {
            foreach ($query->result() as $row) {

                $filter = json_decode( $row->filter );

                $filter->output__date_from  = "";
                $filter->output__date_to    = "";


                if( $filter->date_from ){
                    $date_from = new DateTime( $filter->date_from );
                    $filter->output__date_from  = $date_from->format('d.m.Y');
                }
                if( $filter->date_to ){
                    $date_to = new DateTime( $filter->date_to );
                    $filter->output__date_to    = $date_to->format('d.m.Y');
                }
                return $filter;
            }
        } else {
            return new stdClass();
        }
    }

    public function update_user_filter( $user_id = 0, $type = 'inbox',  $filter ) {

        $filter['employers']    = $filter['employers__to_show'];
        // Сортировка всегда по недавно обновленным
        //$filter['sort'] = 'updated';

        $query      =    $this->db  ->select('id')
                                    ->from( 'users_filter' )
                                    ->where( 'user_id', $user_id )
                                    ->where( 'type', $type )
                                    ->get();

        if ( $query->result() ) {
            foreach ( $query->result() as $row ) {
                $filter_id = $row->id;
                break;
            }
            $this->db   ->where( 'id', $filter_id )
                        ->update( 'users_filter', array('filter' => json_encode( $filter )) );
        } else {
            $this->db->insert('users_filter', array( 'user_id' => $user_id,'type' => $type, 'filter' => json_encode( $filter) ));
        }
        return true;
    }

    public function request_partners__set_viewed( $request_id = 0 ) {

        $this->db   ->where('request_id', $request_id)
                    ->where('viewed', 0 )
                    ->update('requests_partners', array('viewed' => 1) );

        $this->db->reset_query();

        $this->db   ->where('id', $request_id)
                    ->update('requests', array('is_marked' => 0) );

        return true;
    }

    public function archivator () {
        $this->db   ->where('last_update < DATE_SUB(CURDATE(), INTERVAL 6 DAY)')
                    ->group_start()
                        ->or_where('status', 'canceled')
                        ->or_where('status', 'finished')
                    ->group_end()
                    ->where('archived', 0)
                    ->update('requests', array('archived' => 1) );

        $this->db->reset_query();

        $this->db   ->where('last_update < DATE_SUB(CURDATE(), INTERVAL 6 DAY)')
                    ->group_start()
                        ->or_where('status', 'canceled')
                        ->or_where('status', 'finished')
                    ->group_end()
                    ->where('archived', 0)
                    ->update('requests_partners', array('archived' => 1) );

        return true;
    }

    public function actualizator () {

        $this->db   ->where( 'actual <= CURDATE()' )
                    ->where( 'status', 'answered')
                    ->where( 'archived', 0)
                    ->update('requests_partners', array('is_marked' => 1) );

        $this->db   ->reset_query();

        $this->db   ->where( 'saved_actual <= CURDATE()')
                    ->update('requests_partners', array('saved_actual' => '0000-00-00') );

        return true;
    }

    public function re_response_cleaner() {
        $this->db   ->where( 'can_re_response', 0 )
                    ->update('requests_partners', array('can_re_response' => 1) );

        return true;
    }


    public function search_request( $keyword, $limit = 10 ) {
        $keywords = explode(" ", $keyword);

        $value = array();

        $this->db->select('r.id, r.eq_brand_name, r.author, r.archived, r.date');

        $this->db->from('requests r');
        $this->db->join('requests_positions rp', 'rp.request_id = r.id');
        $this->db->join('requests_partners ru', 'ru.request_id = r.id');


        if( is_array($keywords) && !empty($keywords)):
            foreach($keywords as $search_word):
                $this->db->group_start();
                    $this->db->or_like('r.eq_brand_name', $search_word, 'both' );
                    $this->db->or_like('r.eq_appointment_name', $search_word, 'both' );
                    $this->db->or_like('r.eq_model', $search_word, 'both' );
                    $this->db->or_like('r.eq_serial_number', $search_word, 'both' );
                    $this->db->or_like('r.eq_section', $search_word, 'both' );
                    $this->db->or_like('r.eq_engine', $search_word, 'both' );
                    $this->db->or_like('rp.detail', $search_word, 'both' );
                    $this->db->or_like('rp.catalog_num', $search_word, 'both' );
                $this->db->group_end();
            endforeach;
        endif;

        $this->db->group_start();

            $this->db->where('r.author', $this->session->user);
            $this->db->or_where('r.executor',  $this->session->user);

            $this->db->or_group_start();
                $this->db->where('ru.user_id', $this->session->user);
                $this->db->where('r.executor', '0');
            $this->db->group_end();

        $this->db->group_end();


        $this->db->where('r.step', 4);

        if ( $limit > 0 )
            $this->db->limit($limit);

        $query = $this->db->get();

        foreach($query->result() as $row) {

            if( $row->archived )
                $request_type = 'Архивная';
            elseif( $row->author == $this->session->user )
                $request_type = 'Исходящая';
            else {
                $request_type = 'Входящая';
            }

            $date_object    = new DateTime($row->date);

            $value[] = array(
                'type'          => 'suggestion',
                'value'         => $row->eq_brand_name,
                'request_id'    => $row->id,
                'request_type'  => $request_type,
                'date'          => $date_object->format('H:i:s d.m.Y'),
            );
        }

        $value[] = array(
            'type'          => 'show_all',
            'value'         => 'Показать все результаты',
            'url'           => '/request/find',
        );
        return $value;
    }


    private function build_inbox_request__list ( $request, $show_author = false, $employers_list = false ) {

        $request->is_author         = false;

        $d          = new DateTime( $request->date );
        $day        = $d->format('j');
        $date       = explode(".", $d->format('m'));

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

        $request->date_output      = $day.' '.$m.' '.$d->format('H:i');

        $request->html_class    = '';
        $request->status_text   = '';
        
        if( $show_author )
            $request->author_info = $this->User_model->get_user_by_id( $request->user_id );
        else
            $request->author_info = false;


        if( is_array( $request->eq_images ) && !empty( $request->eq_images ) ) {

            foreach ($request->eq_images as $row_thumbnail) {
                $request->eq_thumbnail     = $row_thumbnail;
                $request->eq_thumbnail_out = $row_thumbnail.'?v='.time();
                break;
            }

        } else {

            $request->eq_images        = false;
            $request->eq_thumbnail     = false;

        }

        $request->is_executor   = false;
        $request->show_rating   = false;

        if( $request->executor == $request->user_id  ) { // для директора ...&&
            $request->is_executor = true;

            if( $request->rating_author && !$employers_list )
                $request->show_rating = true;
        }


        $request->set_rating    = false;
        $request->positions     = $this->get_request_positions( $request->id );

        $request->can__clone        = false;
        $request->finished          = false;
        $request->can__set_rating   = false;
        $request->can__compare      = false;
        $request->can__archived     = false;
        $request->can__cancel       = true;

        $request->html_url = '/requests/'.$request->id;

        if( $request->is_executor && !$employers_list ) {

            switch( $request->request_status ) {
                case 'in_process':
                    $request->status_text   = 'В работе (ожидает оплаты)';
                    $request->html_class    = 'request__status--active';
                    $request->show_rating   = false;
                    $request->can__set_rating   = true;
                    break;
                case 'payed':
                    $request->status_text   = 'В работе (оплачено, ожидает отгрузки)';
                    $request->html_class    = 'request__status--active';
                    $request->show_rating   = false;
                    $request->can__set_rating   = true;
                    break;
                case 'delivered':
                    $request->status_text   = 'В работе (отгружено, ожидает оплаты)';
                    $request->html_class    = 'request__status--active';
                    $request->show_rating   = false;
                    $request->can__set_rating   = true;
                    break;
                case 'payed_delivered':
                    $request->status_text   = 'В работе (оплачено и отгружено)';
                    $request->html_class    = 'request__status--active';
                    $request->show_rating   = false;
                    $request->can__set_rating   = true;
                    break;
                case 'done':
                    $request->status_text   = 'Завершена';
                    $request->html_class    = 'request__status--done';
                    $request->show_rating   = false;
                    $request->can__set_rating   = true;
                    $request->can__archived     = true;
                    $request->can__cancel       = false;

                    $now                    = new DateTime();
                    $last_up                = new DateTime($request->last_update);
                    $last_up->modify('+7 day');

                    if( $last_up->format('U') > $now->format('U'))
                        $request->can__set_rating   = true;
                    else
                        $request->can__set_rating   = false;

                    break;
                case 'finished':
                    $request->status_text   = 'Завершена';
                    $request->html_class    = 'request__status--done';
                    if( !$request->show_rating && $request->executor == $this->session->user && !$employers_list )
                        $request->set_rating    = true;
                    $request->can__set_rating   = true;
                    $request->can__archived     = true;
                    $request->can__cancel       = false;

                    $now                    = new DateTime();
                    $last_up                = new DateTime($request->last_update);
                    $last_up->modify('+7 day');

                    if( $last_up->format('U') > $now->format('U'))
                        $request->can__set_rating   = true;
                    else
                        $request->can__set_rating   = false;

                    break;
                case 'canceled':
                default:
                    $request->status_text   = 'Отменена';
                    $request->html_class    = 'request__status--canceled';
                    $request->can__archived     = true;
                    $request->can__cancel       = false;

                    $now                    = new DateTime();
                    $last_up                = new DateTime($request->last_update);
                    $last_up->modify('+7 day');

                    if( $last_up->format('U') > $now->format('U'))
                        $request->can__set_rating   = true;
                    else
                        $request->can__set_rating   = false;

                break;
            }

            if( $request->can__set_rating && $request->is_executor && $request->rating_author )
                $request->show_rating       = true;


            if( $request->is_marked_for_partner == '1')
                $request->html_class    .= ' req-item__marked' ;

            if( $request->archived == '1' )
                $request->can__archived     = false;


        }

        elseif( !$request->is_executor && !$employers_list ) {

            switch( $request->status ) {
                case 'send':
                    $request->status_text   = 'Сформирована (получена)';
                    $request->html_class    = 'request__status--answered';
                    break;
                case 'read':
                    $request->status_text   = 'Сформирована (ожидает ответа)';
                    $request->html_class    = 'request__status--answered';
                    break;
                case 'answered':
                    $request->status_text   = 'Сформирована (ответ отправлен)';
                    $request->html_class    = 'request__status--answered';
                    break;
                case 'canceled':
                default:
                    $request->status_text   = 'Отменена';
                    $request->html_class    = 'request__status--canceled';
                    $request->can__archived     = true;
                    $request->can__cancel       = false;
                    break;
            }

            $now                = new DateTime('now');
            $actual             = new DateTime( $request->actual );
            $request->actual    = $actual->format('d.m.Y');

            if( $request->status == 'answered' && ( $actual < $now ) ) {
                $request->status_text   = 'Сформирована (нуждается в обновлении)';
                $request->html_class    = 'request__status--answered';
            }

            if( $request->is_marked_for_partner == '1')
                $request->html_class    .= ' req-item__marked' ;

            if( $request->archived == '1' )
                $request->can__archived     = false;


        }

        elseif ( $employers_list && $request->is_executor ) {

            $request->html_url = '/requests/'.$request->id.'?view=b&employer='.$request->user_id;

            switch( $request->request_status ) {
                case 'in_process':
                    $request->status_text   = 'В работе (ожидает оплаты)';
                    $request->html_class    = 'request__status--active';
                    break;
                case 'payed':
                    $request->status_text   = 'В работе (оплачено, ожидает отгрузки)';
                    $request->html_class    = 'request__status--active';
                    break;
                case 'delivered':
                    $request->status_text   = 'В работе (отгружено, ожидает оплаты)';
                    $request->html_class    = 'request__status--active';
                    break;
                case 'payed_delivered':
                    $request->status_text   = 'В работе (оплачено и отгружено)';
                    $request->html_class    = 'request__status--active';
                    break;
                case 'done':
                    $request->status_text   = 'Завершена (требует подтверждения)';
                    $request->html_class    = 'request__status--done';
                    break;
                case 'finished':
                    $request->status_text   = 'Завершена';
                    $request->html_class    = 'request__status--done';
                    break;
                case 'canceled':
                default:
                    $request->status_text   = 'Отменена';
                    $request->html_class    = 'request__status--canceled';
                    break;
            }

            $request->can_compare       = false;
            $request->can__set_rating   = false;
            $request->can__archived     = false;
            $request->can__cancel       = false;


        }

        elseif ( $employers_list && !$request->is_executor ) {

            $request->html_url = '/requests/'.$request->id.'?view=b&employer='.$request->user_id;

            switch( $request->status ) {
                case 'send':
                    $request->status_text   = 'Сформирована (получена)';
                    $request->html_class    = 'request__status--answered';
                    break;
                case 'read':
                    $request->status_text   = 'Сформирована (ожидает ответа)';
                    $request->html_class    = 'request__status--answered';
                    break;
                case 'answered':
                    $request->status_text   = 'Сформирована (ответ отправлен)';
                    $request->html_class    = 'request__status--answered';
                    break;
                case 'canceled':
                default:
                    $request->status_text   = 'Отменена';
                    $request->html_class    = 'request__status--canceled';
                    break;
            }

            $request->can_compare       = false;
            $request->can__set_rating   = false;
            $request->can__archived     = false;
            $request->can__cancel       = false;

            $now                = new DateTime('now');
            $actual             = new DateTime( $request->actual );
            $request->actual    = $actual->format('d.m.Y');

            if( $request->status == 'answered' && ( $actual < $now ) )
                $request->status_text   = 'Сформирована (нуждается в обновлении)';




        }

        else {

            return false;

        }


        return $request;

    }

    private function build_outbox_request__list ( $request, $show_author = false, $employers_list = false ) {

        $d          = new DateTime( $request->date );
        $day        = $d->format('j');
        $date       = explode(".", $d->format('m'));

        switch ($date[0]) {
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
        $request->date_output      = $day.' '.$m.' '.$d->format('H:i');

        $request->html_class    = '';
        $request->status_text   = '';

        if( $show_author )
            $request->author_info = $this->User_model->get_user_by_id( $request->user_id );
        else
            $request->author_info = false;

        if( is_array( $request->eq_images ) && !empty( $request->eq_images ) ) {

            foreach ($request->eq_images as $row_thumbnail) {
                $request->eq_thumbnail     = $row_thumbnail;
                $request->eq_thumbnail_out = $row_thumbnail.'?v='.time();
                break;
            }

        } else {

            $request->eq_images        = false;
            $request->eq_thumbnail     = false;

        }

        $request->is_author     = false;
        $request->is_executor   = false;
        $request->show_rating   = false;
        $request->can__clone    = false;

        if( $employers_list == false  ) {
            $request->is_author     = true;
            $request->can__clone    = true;
        }







        $request->positions         = $this->get_request_positions( $request->id );
        $request->partners          = $this->get_request_partners( $request->id );
        $request->can__set_rating   = false;
        $request->can__compare      = false;
        $request->finished          = false;
        $request->can__archived     = false;
        $request->can__cancel       = true;

        $request->html_url              = '/requests/'.$request->id;
        $request->html_compare_url      = '/requests/'.$request->id.'/compare';

        //if( $request->is_author ) {
        if( !$employers_list ) {
            switch( $request->request_status ) {
                case 'send':
                    $request->status_text   = 'Сформирована (отправлена)';
                    $request->html_class    = 'request__status--answered';
                    break;
                case 'read':
                    $request->status_text   = 'Сформирована (в обработке)';
                    $request->html_class    = 'request__status--answered';
                    break;
                case 'answered':

                    $request->status_text   = 'Сформирована (есть ответ)';

                    $partners_count_requests    = $this->get_request_partners_count( $request->id );
                    if( $partners_count_requests['total'] != 0 ) {
                        $this->load->helper('morphem');
                        $answered_text  = morphem( $partners_count_requests['total'], 'ответ', 'ответа', 'ответов');
                        $request->status_text = 'Сформирована (есть '.$partners_count_requests['total'].' '.$answered_text.')';
                    }

                    $request->html_class    = 'request__status--answered';
                    $request->html_url      = $request->html_compare_url;
                    $request->can__compare  = true;
                    break;
                case 'in_process':

                    $request->status_text   = 'В работе (ожидает оплаты)';
                    $request->html_class    = 'request__status--active';
                    $request->can__compare  = true;
                    $request->show_rating   = false;

                    $request->can__set_rating   = true;
                    break;
                case 'payed':
                    $request->status_text   = 'В работе (оплачено, ожидает отгрузки)';
                    $request->html_class    = 'request__status--active';
                    $request->can__compare  = true;
                    $request->show_rating   = false;
                    $request->can__set_rating   = true;
                    break;
                case 'delivered':
                    $request->status_text   = 'В работе (отгружено, ожидает оплаты)';
                    $request->html_class    = 'request__status--active';
                    $request->can__compare  = true;
                    $request->show_rating   = false;
                    $request->can__set_rating   = true;
                    break;
                case 'payed_delivered':
                    $request->status_text   = 'В работе (оплачено и отгружено)';
                    $request->html_class    = 'request__status--active';
                    $request->can__compare  = true;
                    $request->show_rating   = false;
                    $request->can__set_rating   = true;
                    break;
                case 'done':
                    $request->status_text   = 'Завершена (требует подтверждения)';
                    $request->html_class    = 'request__status--done';
                    $request->can__compare  = true;
                    $request->show_rating   = false;
                    $request->can__cancel       = false;

                    $request->finished      = true;

                    $now                    = new DateTime();
                    $last_up                = new DateTime($request->last_update);
                    $last_up->modify('+7 day');

                    if( $last_up->format('U') > $now->format('U'))
                        $request->can__set_rating   = true;
                    else
                        $request->can__set_rating   = false;

                    break;
                case 'finished':
                    $request->status_text   = 'Завершена';
                    $request->html_class    = 'request__status--done';
                    $request->can__set_rating   = true;
                    $request->can__compare      = true;
                    $request->can__archived     = true;
                    $request->can__cancel       = false;

                    $now                    = new DateTime();
                    $last_up                = new DateTime($request->last_update);
                    $last_up->modify('+7 day');

                 ;

                    if( $last_up->format('U') > $now->format('U'))
                        $request->can__set_rating   = true;
                    else
                        $request->can__set_rating   = false;

                    break;
                case 'canceled':
                default:
                    $request->status_text       = 'Отменена';
                    $request->html_class        = 'request__status--canceled';
                    $request->can__compare      = false;
                    $request->can__archived     = true;
                    $request->can__cancel       = false;


                    if( $request->executor != 0 ){
                        $now                    = new DateTime();
                        $last_up                = new DateTime($request->last_update);
                        $last_up->modify('+7 day');

                        if( $last_up->format('U') > $now->format('U'))
                            $request->can__set_rating   = true;
                        else
                            $request->can__set_rating   = false;
                    } else {
                        $request->can__set_rating       = false;
                    }


                break;
            }

            if( $request->can__set_rating && $request->is_author && $request->rating_executor )
                $request->show_rating       = true;

            if( $request->is_marked   == '1' )
                $request->html_class    .= ' req-item__marked';

            if( $request->archived == '1' )
                $request->can__archived     = false;





        }
        //elseif( $employers_list ) {
        else {

            $request->html_url          = '/requests/'.$request->id.'?view=b&employer='.$request->user_id;
            $request->html_compare_url  = '/requests/'.$request->id.'/compare?view=b&employer='.$request->user_id;


            $request->can__cancel       = false;

            switch( $request->request_status ) {
                case 'send':
                    $request->status_text   = 'Сформирована (отправлена)';
                    $request->html_class    = 'request__status--answered';
                    $request->can__compare  = false;
                    break;
                case 'read':
                    $request->status_text   = 'Сформирована (в обработке)';
                    $request->html_class    = 'request__status--answered';
                    $request->can__compare  = false;
                    break;
                case 'answered':
                    $request->status_text   = 'Сформирована (есть ответ)';

                    $partners_count_requests    = $this->get_request_partners_count( $request->id );

                    if( $partners_count_requests['total'] != 0 ):

                        $this->load->helper('morphem');

                        $answered_text          = morphem( $partners_count_requests['total'], 'ответ', 'ответа', 'ответов');
                        $request->status_text   = 'Сформирована (есть '.$partners_count_requests['total'].' '.$answered_text.')';

                    endif;

                    $request->html_class    = 'request__status--answered';
                    $request->html_url      = $request->html_compare_url;
                    $request->can__compare  = true;
                    break;
                case 'in_process':
                    $request->status_text   = 'В работе (ожидает оплаты)';
                    $request->html_class    = 'request__status--active';
                    $request->can__compare  = true;
                    break;
                case 'payed':
                    $request->status_text   = 'В работе (оплачено, ожидает отгрузки)';
                    $request->html_class    = 'request__status--active';
                    $request->can__compare  = true;
                    break;
                case 'delivered':
                    $request->status_text   = 'В работе (отгружено, ожидает оплаты)';
                    $request->html_class    = 'request__status--active';
                    $request->can__compare  = true;
                    break;
                case 'payed_delivered':
                    $request->status_text   = 'В работе (оплачено и отгружено)';
                    $request->html_class    = 'request__status--active';
                    $request->can__compare  = true;
                    break;
                case 'done':
                    $request->status_text   = 'Завершена (требует подтверждения)';
                    $request->html_class    = 'request__status--done';
                    $request->can__compare  = true;
                    $request->finished      = true;
                    break;
                case 'finished':
                    $request->status_text   = 'Завершена';
                    $request->html_class    = 'request__status--done';
                    $request->can__compare  = true;
                    break;
                case 'canceled':
                default:
                    $request->status_text   = 'Отменена';
                    $request->html_class    = 'request__status--canceled';
                    $request->can__compare  = false;
                    break;
            }

        }



        return $request;


    }


}
