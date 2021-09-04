<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 10.09.16
 * Time: 15:21
 */


class Offers_model extends CI_Model
{
    /*
     * Параметры фильтра
     *
     * author       - автор
     * type         - тип записи (купить, продать, сервис)
     * category     - категории
     * brand        - бренды
     * price        - цена
     * max_price    - потолок цены
     * offset         - отступ
     * limit        - количество записей
     * reverse      - обратный порядок
     *
     */
    public function get_offers( $filter = array() ) {

        $global__brands     = $this->Option_model->get_directory('brand', false);
        $global__categories = $this->Option_model->get_directory('offer_category', false);

        $result         = array();


        $limit          = 10;    // Количество новостей для вывода
        if( array_key_exists("limit", $filter) && $filter['limit']  != 0 )
            $limit      = $filter['limit'];

        $offset         = false;    // Отступ (для пагинации)
        if( array_key_exists("offset", $filter) && $filter['offset']  != 0 )
            $offset     = $filter['offset'];

        $count_news         = false;    // Возвращаем только новости
        if( array_key_exists("count", $filter) && $filter['count']  = true )
            $count_news     = true;     // Возвращаем количество новосте


        $this->db       ->select('o.id, o.type, o.category, d_c.value as category_value, o.brand, d_b.value as brand_value, o.title, o.keywords, o.price, o.max_price, o.barter, o.barter_text, o.content, o.date, o.images, o.author_id, o.pinned, o.pin_date, o.views, o.removed, o.contacts, u.name, u.last_name, u.phone, u.avatar')
                        ->from('offers as o')
                        ->join('users as u', 'u.id = o.author_id')
                        ->join('directory as d_c', 'o.category = d_c.id')
                        ->join('directory as d_b', 'o.brand = d_b.id');


        if( array_key_exists('from', $filter) && $filter['from'] != 0 )
            $this->db   ->where('o.id <', intval( $filter['from'] ) );


        if( array_key_exists('barter', $filter) && $filter['barter'] == "yes" )
            $this->db->where('barter', 1);


        if( array_key_exists('pinned', $filter) && $filter['pinned'] == "yes" )
            $this->db->where('pinned', 1);


        elseif ( array_key_exists('pinned', $filter) && $filter['pinned'] == "no" )
            $this->db->where('pinned', 0);




        if( array_key_exists('keyword', $filter) && $filter['keyword'] != "" ):
            $keywords = explode(" ", $filter['keyword']);


            /* Ищем ключевые слова категорий и выбрасываем их из массива ключевых */
            foreach( $keywords as $search_i => $search_word ):

                if( mb_strtolower( $search_word ) == "купить" || mb_strtolower( $search_word ) == "куплю" ):
                    $this->db->where('o.type', "buy" );
                    unset( $keywords[$search_i] );

                elseif( mb_strtolower( $search_word ) == "продать" || mb_strtolower( $search_word ) == "продам"  ):
                    $this->db->where('o.type', "sell" );
                    unset( $keywords[$search_i] );

                elseif( mb_strtolower( $search_word ) == "сервис" || mb_strtolower( $search_word ) == "услуга" ):
                    $this->db->where('o.type', "service" );
                    unset( $keywords[$search_i] );

                endif;

            endforeach;



            /*
             *
             *      НАЧАЛО
             *      Если в ключевых словах есть слова о брендах
             *
             */

            $filter_brands  = array();

            foreach( $keywords as $search_i => $search_word ):

                foreach ($global__brands as $global__brand):
                    if( mb_strtolower( $search_word ) == mb_strtolower( $global__brand->value ) ):
                        $filter_brands[]    = $global__brand->id;
                        unset( $keywords[$search_i] );
                    endif;
                endforeach;

            endforeach;



            if( !empty($filter_brands) ):

                if (count( $filter_brands ) > 1):
                    $this->db->group_start();
                    foreach ( $filter_brands as $f_brand ):
                        $this->db->or_where('o.brand', $f_brand );
                    endforeach;
                    $this->db->group_end();

                elseif( count( $filter_brands ) == 1 ):
                    foreach ( $filter_brands as $f_brand ):
                        $this->db->where('o.brand', $f_brand );
                    endforeach;
                endif;

            endif;


            /*
             *
             *      КОНЕЦ
             *      Если в ключевых словах есть слова о брендах
             *
             */




            /*
             *
             *      НАЧАЛО
             *      Если в ключевых словах есть слова о категориях / рубриках
             *
             */

            $filter_categories  = array();

            foreach( $keywords as $search_i => $search_word ):

                foreach ($global__categories as $global__category):
                    if( mb_strtolower( $search_word ) == mb_strtolower( $global__category->value ) ):
                        $filter_categories[]    = $global__category->id;
                        unset( $keywords[$search_i] );
                    endif;
                endforeach;

            endforeach;


            if( !empty($filter_categories) ):

                if (count( $filter_categories ) > 1):
                    $this->db->group_start();
                    foreach ( $filter_categories as $f_cat ):
                        $this->db->or_where('o.category', $f_cat );
                    endforeach;
                    $this->db->group_end();

                elseif( count( $filter_categories ) == 1 ):
                    foreach ( $filter_categories as $f_cat ):
                        $this->db->where('o.category', $f_cat );
                    endforeach;
                endif;

            endif;


            /*
             *
             *      КОНЕЦ
             *      Если в ключевых словах есть слова о категориях / рубриках
             *
             */


            if ( !empty($keywords)):
                $this->db->group_start();

                    $this->db->or_like('o.title', implode(" ", $keywords), 'both' );
                    $this->db->or_like('o.keywords', implode(" ", $keywords), 'both' );
                    $this->db->or_like('o.content', implode(" ", $keywords), 'both' );

                    $this->db->or_like('u.name', implode(" ", $keywords), 'both' );
                    $this->db->or_like('u.last_name', implode(" ", $keywords), 'both' );
                    $this->db->or_like('u.phone', implode(" ", $keywords), 'both' );

                $this->db->group_end();
            endif;
        endif;




        if( array_key_exists('offset', $filter) && $filter['offset'] != 0 )
            $this->db->limit(10, $filter['offset']);

        if( array_key_exists('user_id', $filter) && $filter['user_id'] != 0 )
            $this->db->where('o.author_id', intval( $filter['user_id'] ) );



        if ( array_key_exists('type', $filter) && !empty($filter['type']) )
        {
            $this->db->where('o.type', $filter['type'] );
        }
        if ( array_key_exists('category', $filter) && !empty($filter['category']) )
        {
            $this->db->group_start();
            foreach( $filter['category'] as $c )
            {
                $this->db->or_where('o.category', $c );
            }
            $this->db->group_end();
        }
        if ( array_key_exists('brand', $filter) && !empty($filter['brand']) )
        {
            $this->db->group_start();
            foreach( $filter['brand'] as $b )
            {
                $this->db->or_where('o.brand', $b );
            }
            $this->db->group_end();
        }
        if ( array_key_exists('price', $filter) && array_key_exists('max_price', $filter) && $filter['price'] != '' && $filter['max_price'] != '' )
        {
            $this->db->group_start();
                // если в объявлении есть и верхняя цена, и нижняя
                $this->db->or_group_start();
                        $this->db->where('o.max_price !=',     0 );
                        $this->db->group_start();
                            $this->db->or_group_start();
                                $this->db->where('o.price <=',      intval( $filter['max_price'] ) );
                                $this->db->where('o.price >=',      intval( $filter['price'] ) );

                            $this->db->group_end();

                            $this->db->or_group_start();
                                $this->db->where('o.max_price >=',  intval( $filter['price'] ) );
                                $this->db->where('o.max_price <=',  intval( $filter['max_price'] ) );

                            $this->db->group_end();


                            //$this->db->or_where('o.max_price >=',  intval( $filter['price'] ) );
                        $this->db->group_end();

                        $this->db->or_group_start();
                            $this->db->where('o.price >=',      intval( $filter['price'] ) );
                            $this->db->where('o.price <=',      intval( $filter['max_price'] ) );
                            $this->db->where('o.max_price <=',  intval( $filter['max_price'] ) );
                            $this->db->where('o.max_price >=',  intval( $filter['price'] ) );

                        $this->db->group_end();

                $this->db->group_end();

                // если в объявлении задано только нижняя цена
                $this->db->or_group_start();
                        $this->db->where('o.price <=',      intval( $filter['max_price'] ) );
                        $this->db->where('o.max_price',     0 );
                        $this->db->where('o.price >=',      intval( $filter['price'] ) );
                $this->db->group_end();



/*

                $this->db->or_group_start();

                    $this->db->where('o.price <=', intval( $filter['price'] ) );
                    $this->db->or_where('o.max_price >=', intval( $filter['price'] ) );
                    $this->db->where('o.max_price !=', 0 );

                $this->db->group_end();
                $this->db->or_group_start();

                    $this->db->where('o.max_price >=', intval( $filter['price'] ) );
                    $this->db->or_where('o.max_price <=', intval( $filter['max_price'] ) );
                    $this->db->where('o.max_price !=', 0 );

                $this->db->group_end();
                */
            $this->db->group_end();

        }

        // В фильтре пришла только нижняя цена
        elseif ( array_key_exists('price', $filter) && $filter['price'] != '' ) {
            $this->db->group_start();
                // Если в объявлении есть только цена от
                $this->db->or_where('o.price >=', intval( $filter['price'] ) );

                // Если в объявлении и от и до, то подойдет любое, где потолок выше указанной цены
                $this->db->or_group_start();
                    $this->db->where('o.max_price >=', intval( $filter['price'] ) );
                    $this->db->where('o.max_price !=', 0 );
                $this->db->group_end();
            $this->db->group_end();
        }
        elseif ( array_key_exists('max_price', $filter) && $filter['max_price'] != '' ) {
            $this->db->where('o.price <=', intval( $filter['max_price'] ) );
        }

        if( !array_key_exists('removed', $filter) || $filter['removed'] != 'all'){
            $this->db->where('o.removed', 0);
        }


        if( array_key_exists('sort_by', $filter) ) {
            switch ($filter['sort_by']){
                case 'id':
                    $this->db->order_by('id', 'DESC');
                    break;
                case 'views':
                    $this->db->order_by('views', 'DESC');
                    break;
                case 'category':
                    $this->db->order_by('category', 'DESC');
                    break;
                case 'low_price':
                    $this->db->order_by('price ASC, max_price ASC');
                    break;
                case 'high_price':
                    $this->db->order_by('price DESC, max_price DESC');
                    break;
                case 'pin_date':
                    $this->db->order_by('pin_date', 'DESC');
                    break;
                default:
                    $this->db->order_by('id', 'DESC');
                    break;
            }
        } else {
            $this->db->order_by('removed ASC, id DESC');
        }

        if( $limit )
            $this->db->limit( $limit );

        if( $offset )
            $this->db->offset( $offset );

        $query = $this->db->get();

        if($query->result()) {


            if ( $count_news ) {
                return $query->num_rows();
            } else {
                foreach ($query->result() as $row) {
                    $result[] = $this->create_offer($row);
                }
                if (array_key_exists('inverse', $filter) && $filter['inverse'] == true)
                    return array_reverse($result);
                else
                    return $result;
            }
        }
        else
            return false;
    }

    public function get_offer_item( $id = 0 ) {
        $query = $this->db  ->select('o.id, o.type, o.category, o.brand, o.title, o.keywords, o.price, o.max_price, o.barter, o.barter_text, o.content, o.date, o.images, o.author_id, o.pinned, o.views, o.removed, o.contacts')
                            ->from('offers as o')
                            ->where('o.id', $id)
                            ->get();

        if( $query->result() ) {
            foreach ($query->result() as $row) {
                return $this->create_offer($row);
            }
        }
        else
            return false;
    }

    public function add_offer(  $options = array(), $images = array() )
    {
        if( array_key_exists('price', $options) && array_key_exists('max_price', $options) && $options['price'] > $options['max_price']) {
            $price                  = $options['price'];
            $max_price              = $options['max_price'];
            $options['price']       = $max_price;
            $options['max_price']   = $price;
        }

        $this->db->insert('offers', $options );
        $insert_id = $this->db->insert_id();
        $this->db->reset_query();
        if(!empty($images))
        {
            $upload_images_db = array();
            foreach ( $images as $img )
            {
                $upload_image       = $this->Images_model->upload_base64_image( $img, 'offers', $insert_id );
                $upload_images_db[] = $upload_image;
            }
            $this->db->where('id', $insert_id );
            $this->db->update('offers', array('images' => json_encode($upload_images_db)) );
            $this->db->reset_query();
        }
        return $insert_id;
    }

    public function edit_offer( $offer_id = 0, $content = array() ) {

        if( array_key_exists('price', $content) && array_key_exists('max_price', $content) && $content['price'] > $content['max_price'] && $content['price'] != '' && $content['max_price'] != '' ) {
            $price                  = $content['price'];
            $max_price              = $content['max_price'];
            $content['price']       = $max_price;
            $content['max_price']   = $price;
        }

        $upload_images_db = array();

        if( array_key_exists('post_images', $content) || array_key_exists('existing_images', $content) ) {

            if( array_key_exists('post_images', $content) && !empty( $content['post_images'] ) )
            {
                foreach ( $content['post_images'] as $img ) {
                    $upload_image       = $this->Images_model->upload_base64_image( $img, 'offers', $offer_id );
                    $upload_images_db[] = $upload_image;
                }
            }

            if( array_key_exists('existing_images', $content)  && !empty( $content['existing_images'] ) )
            {
                foreach ( $content['existing_images'] as $img ) {
                    $upload_images_db[] = $img;
                }
            }

            unset( $content['post_images'] );
            unset( $content['existing_images'] );

            $content['images'] = json_encode($upload_images_db);
        }



        $this->db->where('id', $offer_id);
        if ( $this->db->update('offers', $content) )
            return true;
        else
            return false;
    }

    public function add_offers_contact ( $offer_id = 0 ) {

        $this->db->set('contacts', 'contacts+1', FALSE);
        $this->db->where('id', $offer_id);
        $this->db->update('offers');

        return true;
    }

    public function remove_item( $id = 0 ) {
        $this->db->where('id', $id);
        if ( $this->db->update('offers', array('removed' => 1)) )
            return true;
        else
            return false;
    }

    public function undo_remove_item ( $id = 0 ) {
        $this->db->where('id', $id);
        if ( $this->db->update('offers', array('removed' => 0)) )
            return true;
        else
            return false;
    }

    public function count_user_offers ( $user_id = 0 ){
        $all    =   $this->db   ->from('offers')
                                ->where('author_id', $user_id)
                                ->count_all_results();

        $active =   $this->db   ->from('offers')
                                ->where('removed', 0)
                                ->where('author_id', $user_id)
                                ->count_all_results();

        return array( 'all' => $all, 'active' => $active);
    }

    public function count_user_offers_views( $user_id = 0 ) {

        $query_all      =   $this->db   ->select_sum('views')
                                        ->from('offers')
                                        ->where('author_id', $user_id)
                                        ->get();

        foreach ($query_all->result() as $row) {
            $all = $row->views;
        }

        $query_active   =   $this->db   ->select_sum('views')
                                        ->from('offers')
                                        ->where('removed', 0)
                                        ->where('author_id', $user_id)
                                        ->get();

        foreach ($query_active->result() as $row) {
            $active = $row->views;
        }

        return array( 'all' => $all, 'active' => $active);
    }

    public function count_user_offers_contacts( $user_id = 0 ) {

        $query_all      =   $this->db   ->select_sum('contacts')
                                        ->from('offers')
                                        ->where('author_id', $user_id)
                                        ->get();

        foreach ($query_all->result() as $row) {
            $all = $row->contacts;
        }

        $query_active   =   $this->db   ->select_sum('contacts')
                                        ->from('offers')
                                        ->where('removed', 0)
                                        ->where('author_id', $user_id)
                                        ->get();

        foreach ($query_active->result() as $row) {
            $active = $row->contacts;
        }

        return array( 'all' => $all, 'active' => $active);

    }



    public function count_all_offers( ) {

        $all    =   $this->db   ->from('offers')
                                ->count_all_results();

        $active =   $this->db   ->from('offers')
                                ->where('removed', 0)
                                ->count_all_results();

        return array( 'all' => $all, 'active' => $active);
    }

    public function count_all_offers_views( ) {
        $query_all      =   $this->db   ->select_sum('views')
                                        ->from('offers')
                                        ->get();

        foreach ($query_all->result() as $row) {
            $all = $row->views;
        }

        $query_active   =   $this->db   ->select_sum('views')
                                        ->from('offers')
                                        ->where('removed', 0)
                                        ->get();

        foreach ($query_active->result() as $row) {
            $active = $row->views;
        }

        return array( 'all' => $all, 'active' => $active);
    }

    public function count_all_offers_contacts( ) {

        $query_all      =   $this->db   ->select_sum('contacts')
                                        ->from('offers')
                                        ->get();

        foreach ($query_all->result() as $row) {
            $all = $row->contacts;
        }

        $query_active   =   $this->db   ->select_sum('contacts')
                                        ->from('offers')
                                        ->where('removed', 0)
                                        ->get();

        foreach ($query_active->result() as $row) {
            $active = $row->contacts;
        }

        return array( 'all' => $all, 'active' => $active);

    }






    public function if__user_can_edit( $user_id = 0, $offer_id ){

        $this_offer     = $this->get_offer_item( $offer_id );
        if ( is_object( $this_offer ) && $this_offer->is_author === true )
            return true;
        else
            return false;

    }

    public function has_brand_offers($brand_id = 0, $page_type = 'sell') {
        $this->db->select('id');
        $this->db->from('offers');
        $this->db->where('brand', $brand_id);
        $this->db->where('type', $page_type);
        $this->db->where('removed', 0);
        $this->db->limit(1);

        $query  = $this->db->get();

        if( $query->result() ) {
            return true;
        }
        else {
            return false;
        }
    }

    public function has_category_offers( $category_id = 0, $page_type = 'sell') {
        $this->db->select('id');
        $this->db->from('offers');
        $this->db->where('category', $category_id);
        $this->db->where('type', $page_type);
        $this->db->where('removed', 0);
        $this->db->limit(1);

        $query  = $this->db->get();

        if( $query->result() ) {
            return true;
        }
        else {
            return false;
        }
    }

    public function has_barter_offers( $page_type = 'sell') {
        $this->db->select('id');
        $this->db->from('offers');
        $this->db->where('barter', 1);
        $this->db->where('type', $page_type);
        $this->db->where('removed', 0);
        $this->db->limit(1);

        $query  = $this->db->get();

        if( $query->result() ) {
            return true;
        }
        else {
            return false;
        }
    }

    public function search_offers( $keyword, $limit = 10 ) {

        $global__brands     = $this->Option_model->get_directory('brand', false);
        $global__categories = $this->Option_model->get_directory('offer_category', false);



        $value = array();

        $this->db
            ->select('o.id, o.type, o.category, o.brand, o.title, o.keywords, o.price, o.max_price, o.barter, o.barter_text, o.content, o.date, o.images, o.author_id, o.pinned, o.views, u.name, u.last_name, u.phone, u.avatar')
            ->from('offers as o')
            ->join('users u', 'u.id = o.author_id')
            ->where('o.removed', 0);


            $keywords = explode(" ", $keyword);


            /* Ищем ключевые слова категорий и выбрасываем их из массива ключевых */
            foreach( $keywords as $search_i => $search_word ):

                if( mb_strtolower( $search_word ) == "купить" || mb_strtolower( $search_word ) == "куплю" ):
                    $this->db->where('o.type', "buy" );
                    unset( $keywords[$search_i] );

                elseif( mb_strtolower( $search_word ) == "продать" || mb_strtolower( $search_word ) == "продам"  ):
                    $this->db->where('o.type', "sell" );
                    unset( $keywords[$search_i] );

                elseif( mb_strtolower( $search_word ) == "сервис" || mb_strtolower( $search_word ) == "услуга" ):
                    $this->db->where('o.type', "service" );
                    unset( $keywords[$search_i] );

                endif;

            endforeach;







            /*
             *
             *      НАЧАЛО
             *      Если в ключевых словах есть слова о брендах
             *
             */

            $filter_brands  = array();

            foreach( $keywords as $search_i => $search_word ):

                foreach ($global__brands as $global__brand):
                    if( mb_strtolower( $search_word ) == mb_strtolower( $global__brand->value ) ):
                        $filter_brands[]    = $global__brand->id;
                        unset( $keywords[$search_i] );
                    endif;
                endforeach;

            endforeach;

            if( !empty($filter_brands) ):

                if (count( $filter_brands ) > 1):
                    $this->db->group_start();
                    foreach ( $filter_brands as $f_brand ):
                        $this->db->or_where('o.brand', $f_brand );
                    endforeach;
                    $this->db->group_end();

                elseif( count( $filter_brands ) == 1 ):
                    foreach ( $filter_brands as $f_brand ):
                        $this->db->where('o.brand', $f_brand );
                    endforeach;
                endif;

            endif;


            /*
             *
             *      КОНЕЦ
             *      Если в ключевых словах есть слова о брендах
             *
             */




            /*
             *
             *      НАЧАЛО
             *      Если в ключевых словах есть слова о категориях / рубриках
             *
             */

            $filter_categories  = array();

            foreach( $keywords as $search_i => $search_word ):

                foreach ($global__categories as $global__category):
                    if( mb_strtolower( $search_word ) == mb_strtolower( $global__category->value ) ):
                        $filter_categories[]    = $global__category->id;
                        unset( $keywords[$search_i] );
                    endif;
                endforeach;

            endforeach;


            if( !empty($filter_categories) ):

                if (count( $filter_categories ) > 1):
                    $this->db->group_start();
                    foreach ( $filter_categories as $f_cat ):
                        $this->db->or_where('o.category', $f_cat );
                    endforeach;
                    $this->db->group_end();

                elseif( count( $filter_categories ) == 1 ):
                    foreach ( $filter_categories as $f_cat ):
                        $this->db->where('o.category', $f_cat );
                    endforeach;
                endif;

            endif;


            /*
             *
             *      КОНЕЦ
             *      Если в ключевых словах есть слова о категориях / рубриках
             *
             */



            if ( !empty($keywords)):
                $this->db->group_start();

                $this->db->or_like('o.title', implode(" ", $keywords), 'both' );
                $this->db->or_like('o.keywords', implode(" ", $keywords), 'both' );
                $this->db->or_like('o.content', implode(" ", $keywords), 'both' );

                $this->db->or_like('u.name', implode(" ", $keywords), 'both' );
                $this->db->or_like('u.last_name', implode(" ", $keywords), 'both' );
                $this->db->or_like('u.phone', implode(" ", $keywords), 'both' );

                $this->db->group_end();
            endif;


        if ( $limit > 0 )
            $this->db->limit($limit);

        $query =    $this->db->get();

        foreach($query->result() as $row) {

            if( is_string($row->images) ) {

                $row->images      = json_decode( $row->images );

                if( is_array($row->images) && !empty($row->images) ){
                    foreach ($row->images as $img) {
                        $row->image = $img;
                        break;
                    }
                }
                else {
                    $row->image = false;
                }

            }
            else
                $row->image = false;


            $offer_type = 'Продам';
            switch ($row->type) {
                case 'sell':
                    $offer_type = 'Продам';
                    break;
                case 'buy':
                    $offer_type = 'Куплю';
                    break;
                case 'service':
                    $offer_type = 'Услуга';
                    break;

            }

            if( $row->content )
                $description   = $row->content;
            else
                $description   = "Описание отсутствует";

            $value[] = array(
                'type'          => 'suggestion',
                'offer_img'     => $row->image,
                'offer_id'      => $row->id,
                'value'         => $row->title,
                'description'   => mb_substr( htmlspecialchars_decode( strip_tags( $description ) ), 0, 125).' ',
                'offer_type'    => $offer_type,
                'data'          => $this->create_offer($row),
            );
        }
        return $value;

    }

    public function activate_offer($offerID) {
        $data = array(
            'removed' => '0'
        );
        $this->db->update('offers', $data, array('id' => $offerID));
        return true;
    }

    public function deactivate_offer($offerID) {
        $data = array(
            'removed' => '1'
        );
        $this->db->update('offers', $data, array('id' => $offerID));
        return true;
    }


    private function create_offer( $offer ) {

        switch( $offer->type ) {
            case "buy":
                $offer->type_buy        = true;
                $offer->type_sell       = false;
                $offer->type_service    = false;
                break;

            case "sell":
                $offer->type_buy        = false;
                $offer->type_sell       = true;
                $offer->type_service    = false;
                break;

            case "service":
                $offer->type_buy        = false;
                $offer->type_sell       = false;
                $offer->type_service    = true;
                break;
        }

        $author             = $this->User_model->get_user_by_id( $offer->author_id );

        $offer->name        = $author->name;
        $offer->last_name   = $author->last_name;
        $offer->phone       = $author->name;
        $offer->avatar      = $author->avatar;

        $d                  = new DateTime( $offer->date );
        $offer->date        = $d->format('d.m.Y');
        $offer->udate       = $d->format('U');
        $offer->post_type   = 'offer';

        if ($offer->content)
            $offer->content   = substr( nl2br(htmlspecialchars(addslashes(trim( $offer->content )))) ,0,1000);
        else
            $offer->content   = "";

        if( $offer->pinned )
            $offer->pinned = true;
        else
            $offer->pinned = false;

        $offer->post_type = 'offers';

        if( $offer->author_id == $this->session->user)
            $offer->is_author = true;
        else
            $offer->is_author = false;

        if($offer->brand)
            $offer->brand_text = $this->Option_model->get_directory_value( $offer->brand );
        else
            $offer->brand_text = '';

        if($offer->category)
            $offer->category_text = $this->Option_model->get_directory_value( $offer->category );

        if( is_string($offer->images) )
            $offer->images      = json_decode( $offer->images );
        else
            $offer->images      = '';

        if( is_array($offer->images) && !empty($offer->images)) {
            $i = 0;
            foreach ($offer->images as $img) {
                if( $i == 0 )
                    $offer->first_image = $img;
                $i++;
                break;
            }
            $offer->images_count  = count($offer->images);
        }
        else {
            $offer->images = '';
            $offer->images_count = 0;
            $offer->first_image = false;
        }
        if($offer->images_count > 1)
            $offer->slider = true;
        else
            $offer->slider = false;

        if($offer->barter) {
            $offer->barter = true;
            $offer->boolean__barter = true;
        }

        else {
            $offer->barter = "";
            $offer->boolean__barter = false;
        }

        if( !$offer->price )
            $offer->price = "";

        if( !$offer->max_price )
            $offer->max_price = "";

        if ( $this->count_user_offers( $offer->author_id ) <= 1 )
            $offer->is_first_offer      = true;
        else
            $offer->is_first_offer     = false;

        return $offer;
    }
}