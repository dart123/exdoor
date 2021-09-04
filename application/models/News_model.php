<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 10.09.16
 * Time: 13:17
 *
 *
 *      get_news        - Получаем ленту новостей
 *      get_news_item   - Получаем новость
 *      add_news        - Добавить новость
 *      add_comment     - Добавить комментарий к новости
 */


class News_model extends CI_Model {

    /*
     * Параметры фильтра
     *
     * user_id      - пользователь
     * type         - тип записей (lenta или solo)
     * from         - отступ
     * limit        - количество записей
     * reverse      - обратный порядок
     *
     */
    public function get_news ( $filter = array() ) {

        $limit          = 10;    // Количество новостей для вывода
        if( array_key_exists("limit", $filter) && $filter['limit']  != 0 )
            $limit      = $filter['limit'];

        $offset         = false;    // Отступ (для пагинации)
        if( array_key_exists("offset", $filter) && $filter['offset']  != 0 )
            $offset     = $filter['offset'];

        $count_news         = false;    // Возвращаем только новости
        if( array_key_exists("count", $filter) && $filter['count']  = true )
            $count_news     = true;     // Возвращаем количество новосте





        $result             = array();
        if( array_key_exists('user_id', $filter) && $filter['user_id'] && $filter['user_id'] != 1 ) {

            $partners_ids   = $this->Partner_model->get_partners_ids( $filter['user_id'] );

            if( is_array($partners_ids) )
                $partners_ids[]     = $filter['user_id'];
            else
                $partners_ids   = array( $filter['user_id'] );

            $partners_ids[]     = 1;
        }
        elseif( array_key_exists('company_id', $filter) && $filter['company_id'] ) {

            $partners_ids   = $this->Company_model->get_company_employers_ids( $filter['company_id'] );

            if( !is_array($partners_ids) || empty($partners_ids) )
                $partners_ids   = array( );

        }
        else
            $partners_ids       = array(1);



        $this->db       ->select('n.id, n.content, n.date, n.images, n.author_id, n.taxonomy, n.company_news, n.removed')
                        ->from('news as n');

        if( array_key_exists('keyword', $filter) && $filter['keyword'] != "" ):
            $keywords = explode(" ", $filter['keyword']);


            /*
             *
             *      НАЧАЛО
             *      Если в ключевых словах есть слова таксономий
             *
             */


            $filter_taxonomy  = array();

            foreach( $keywords as $search_i => $search_word ):

                switch ( mb_strtolower( $search_word ) ) {

                    case "технологии":
                    case "технология":
                        $filter_taxonomy[]  = 'technology';
                        unset( $keywords[$search_i] );
                        break;

                    case "деньги":
                        $filter_taxonomy[]  = 'money';
                        unset( $keywords[$search_i] );
                        break;

                    case "интервью":
                        $filter_taxonomy[]  = 'interview';
                        unset( $keywords[$search_i] );
                        break;

                    case "обзор":
                    case "обзоры":
                        $filter_taxonomy[]  = 'review';
                        unset( $keywords[$search_i] );
                        break;

                    case "юмор":
                        $filter_taxonomy[]  = 'humor';
                        unset( $keywords[$search_i] );
                        break;
                    default:
                        break;

                }

            endforeach;

            if( !empty($filter_taxonomy) ):

                if (count( $filter_taxonomy ) > 1):
                    $this->db->group_start();
                    foreach ( $filter_taxonomy as $f_tax ):
                        $this->db->or_where('n.taxonomy', $f_tax );
                    endforeach;
                    $this->db->group_end();

                elseif( count( $filter_taxonomy ) == 1 ):
                    foreach ( $filter_taxonomy as $f_tax ):
                        $this->db->where('n.taxonomy', $f_tax );
                    endforeach;
                endif;

            endif;


            /*
             *
             *      КОНЕЦ
             *      Если в ключевых словах есть слова таксономий
             *
             */

            if ( !empty($keywords)):
                $this->db->group_start();
                    foreach( $keywords as $search_word):
                        if( $search_word != ''):
                            $this->db->or_like('n.content', $search_word, 'both' );
                        endif;
                    endforeach;
                $this->db->group_end();
            endif;
        endif;


        if( array_key_exists('from', $filter) && $filter['from'] != 0 )
            $this->db   ->where('n.id <', intval( $filter['from'] ) );

        if ( array_key_exists('limit', $filter) )
            $this->db->limit($filter['limit']);
        elseif( !$count_news )
            $this->db->limit(10);


        if( array_key_exists('taxonomy', $filter) && $filter['taxonomy'] != '' )
            $this->db   ->where('n.taxonomy',  $filter['taxonomy']  );


        if( array_key_exists('type', $filter) && $filter['type'] == 'lenta' )
        {

            $this->db->group_start();

                if( !empty($partners_ids) ) {

                    foreach ($partners_ids as $partner_id) {

                        $this->db
                            ->or_group_start()
                            ->where(array('author_id' => $partner_id, 'company_news' => 0))
                            ->group_end();
                    }

                }

                if( array_key_exists('company_id', $filter) && ( !array_key_exists('employers_only', $filter) || $filter['employers_only'] == 0 ) ) {

                    $this->db
                        ->or_group_start()
                        ->where(array('author_id' => $filter['company_id'], 'company_news' => 1))
                        ->group_end();

                }

            $this->db->group_end();


        }
        elseif ( array_key_exists('type', $filter) && $filter['type'] == 'solo' ) {

            if( array_key_exists('user_id', $filter) && $filter['user_id'] ) {
                $this->db->where(array('author_id' => $filter['user_id'], 'company_news' => 0));
            }

            if( array_key_exists('company_id', $filter) && $filter['company_id'] ) {
                $this->db->where(array('author_id' => $filter['company_id'], 'company_news' => 1));
            }
        }
        elseif( !array_key_exists( 'keyword', $filter))
        {
            $this->db->group_start();
            if( array_key_exists('user_id', $filter) && $filter['user_id'] ) {
                $this->db
                    ->or_group_start()
                    ->where(array('author_id' => $filter['user_id'], 'company_news' => 0))
                    ->group_end();
            }

            if( array_key_exists('company_id', $filter) && $filter['company_id']  ) {
                $this->db
                    ->or_group_start()
                    ->where(array('author_id' => $filter['company_id'], 'company_news' => 1))
                    ->group_end();
            }
            $this->db->group_end();
        }

        if( !array_key_exists('removed', $filter) || $filter['removed'] != 'all'){
            $this->db->where('n.removed', 0);
        }

        $this->db->order_by("removed ASC, id DESC");

        if( $limit )
            $this->db->limit( $limit );

        if( $offset )
            $this->db->offset( $offset );


        $query      = $this->db->get();

        if( $query->result() ) {

            if ( $count_news ) {
                return $query->num_rows();
            } else {

                foreach($query->result() as $row) {
                    $result[] = $this->build_news($row);
                }
                if ( array_key_exists('inverse', $filter) && $filter['inverse'] == true )
                    return array_reverse($result);
                else  {
                    return $result;
                }
            }

        } else
            return false;
    }


    public function get_news_item ( $id = 0, $removed = false ) {
        $this->db->select('n.id, n.author_id, n.taxonomy, n.content, n.images, n.removed, n.date, n.company_news')
            ->from('news n')
            ->where('n.id', $id);

        if( $removed != true )
            $this->db->where('n.removed', 0);

        $query = $this->db->get();

        if( $query->result() ) {

            foreach ($query->result() as $row) {
                return $this->build_news($row);
            }
        } else return false;
    }

    public function get_comments( $news_id, $offset = 0, $limit = 5, $reverse = true ) {
        $this->db   ->select('
                            c.id, 
                            c.news_id, 
                            n.author_id as news_author_id, 
                            n.company_news as is_company_news,
                            c.user_id, 
                            c.comment, 
                            c.date 
                            ')
                    ->from('news_comments as c')
                    ->join('news as n', 'n.id = c.news_id')
                    ->where('c.news_id', $news_id)
                    ->where('c.removed', 0);

        if( $offset != 0 )
            $this->db   ->offset( $offset );

        $this->db   ->order_by("c.date desc")
                    ->limit($limit);

        $query =   $this->db->get();

        if($query->result()) {
            foreach($query->result() as $row) {
                $result[] = $this->build_comment( $row );
            }
            if( $reverse )
                return array_reverse( $result );
            else
                return $result;
        } else
            return false;

    }

    public function get_comment( $comment_id = 0 ) {
        $this->db   ->select('
                            c.id, 
                            c.news_id, 
                            n.author_id as news_author_id, 
                            n.company_news as is_company_news,
                            c.user_id, 
                            c.comment, 
                            c.date')
                    ->from('news_comments as c')
                    ->join('news as n', 'n.id = c.news_id')
                    ->where('c.id', $comment_id)
                    ->where('c.removed', 0);

        $query =    $this->db->get();

        if($query->result()) {
            foreach($query->result() as $row)
            {
                $result = $this->build_comment( $row );
            }
            return $result;
        } else
            return false;
    }

    public function edit_comment ($id, $update_data = array() ) {
        $this->db->where('id', $id);
        if ( $this->db->update('news_comments', $update_data) )
            return true;
        else
            return false;
    }

    public function remove_comment ( $comment_id = 0 ) {
        $this->db->where('id', $comment_id);
        if ( $this->db->update('news_comments', array('removed' => 1)) )
            return true;
        else
            return false;
    }

    public function undo_remove_comment ( $comment_id = 0 ) {
        $this->db->where('id', $comment_id);
        if ( $this->db->update('news_comments', array('removed' => 0)) )
            return true;
        else
            return false;
    }

    public function add_news ( $author_id = 0, $content = '', $images = array(), $is_company_news = false, $taxonomy = 'user' ) {

        $insert_news_data = array(
            'author_id'     => $author_id,
            'content'       => $content,
            'taxonomy'      => $taxonomy,
        );

        if( $is_company_news )
        {
            $insert_news_data['company_news'] = 1;
        }


        $this->db->insert('news', $insert_news_data );
        $insert_id = $this->db->insert_id();

        $this->db->reset_query();

        if(!empty($images)) {
            $upload_images_db = array();
            foreach ( $images as $img ) {
                $upload_image       = $this->Images_model->upload_base64_image( $img, 'news', $insert_id );
                $upload_images_db[] = $upload_image;
            }
            $this->db->where('id', $insert_id );
            $this->db->update('news', array('images' => json_encode($upload_images_db)) );
            $this->db->reset_query();
        }

        return $insert_id;
    }

    public function edit_news( $news_id = 0, $content = array() ) {

        $upload_images_db = array();

        if( array_key_exists('post_images', $content) || array_key_exists('existing_images', $content) ) {
            if( array_key_exists('post_images', $content) && !empty( $content['post_images'] ) )
            {
                foreach ( $content['post_images'] as $img ) {
                    $upload_image       = $this->Images_model->upload_base64_image( $img, 'news', $news_id );
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


        $this->db->where('id', $news_id);
        if ( $this->db->update('news', $content) )
            return true;
        else
            return false;
    }

    public function remove_item( $news_id = 0 ) {
        $this->db->where('id', $news_id);
        if ( $this->db->update('news', array('removed' => 1)) )
            return true;
        else
            return false;
    }

    public function undo_remove_item ( $news_id = 0 ) {
        $this->db->where('id', $news_id);
        if ( $this->db->update('news', array('removed' => 0)) )
            return true;
        else
            return false;
    }

    public function add_comment ( $data ) {
        $this->db->insert('news_comments', $data );
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function add_like( $data ) {
        $this->db->insert('news_likes', $data );
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function remove_like( $data ) {
        $this->db->where('author_id',   $data['author_id']);
        $this->db->where('news_id',     $data['news_id']);
        $this->db->delete('news_likes');
        return true;
    }

    public function delete_news( $newsID ) {
        $this->db->where('id',     $newsID);
        $this->db->delete('news');
        return true;
    }

    public function is_liked( $news_id, $user_id ) {
        $query =   $this->db    ->select('news_id')
                                ->from('news_likes')
                                ->where('news_id', $news_id)
                                ->where('author_id', $user_id)
                                ->count_all_results();
        if ( $query > 0) {
            return true;
        } else
            return false;
    }

    public function count_comments( $news_id ) {
        $query =   $this->db->select('news_id')
                            ->from('news_comments')
                            ->where('news_id', $news_id)
                            ->where('removed', 0)
                            ->count_all_results();

        return $query;
    }

    public function count_likes( $news_id ) {
        $query =   $this->db->select('news_id')
                            ->from('news_likes')
                            ->where('news_id', $news_id)
                            ->count_all_results();

        return $query;
    }

    public function count_user_news( $user_id = 0 ) {

        $all    =   $this->db   ->from('news')
                                ->where('author_id', $user_id)
                                ->where('company_news', 0)
                                ->count_all_results();

        $active =   $this->db   ->from('news')
                                ->where('removed', 0)
                                ->where('author_id', $user_id)
                                ->where('company_news', 0)
                                ->count_all_results();

        return array( 'all' => $all, 'active' => $active);

    }

    public function count_all_news( ) {
        $all    =    $this->db  ->from('news')
                                ->where('author_id !=', 1)
                                ->count_all_results();

        $active =    $this->db  ->from('news')
                                ->where('author_id !=', 1)
                                ->where('removed', 0)
                                ->count_all_results();

        return array( 'all' => $all, 'active' => $active);
    }

    public function count_all_comments( ) {

        $all    =    $this->db  ->from('news_comments as nc')
                                ->join('news as n', 'n.id = nc.news_id')
                                ->where('n.author_id !=', 1)
                                ->where('nc.removed', 0)
                                ->count_all_results();

        $active =    $this->db  ->from('news_comments as nc')
                                ->join('news as n', 'n.id = nc.news_id')
                                ->where('n.author_id !=', 1)
                                ->where('n.removed', 0)
                                ->where('nc.removed', 0)
                                ->count_all_results();

        return array( 'all' => $all, 'active' => $active);
    }

    public function count_all_likes( ) {

        $all    =    $this->db  ->from('news_likes as nl')
                                ->join('news as n', 'n.id = nl.news_id')
                                ->where('n.author_id !=', 1)
                                ->count_all_results();

        $active =    $this->db  ->from('news_likes as nl')
                                ->join('news as n', 'n.id = nl.news_id')
                                ->where('n.author_id !=', 1)
                                ->where('n.removed', 0)
                                ->count_all_results();

        return array( 'all' => $all, 'active' => $active);
    }

    public function count_all_project_news( ) {
        $all    =    $this->db  ->from('news as n')
                                ->where('n.author_id', 1)
                                ->count_all_results();

        $active =    $this->db  ->from('news as n')
                                ->where('n.author_id', 1)
                                ->where('n.removed', 0)
                                ->count_all_results();

        return array( 'all' => $all, 'active' => $active);
    }

    public function count_all_project_comments( ) {

        $all    =    $this->db  ->from('news_comments as nc')
                                ->join('news as n', 'n.id = nc.news_id')
                                ->where('n.author_id', 1)
                                ->where('nc.removed', 0)
                                ->count_all_results();

        $active =    $this->db  ->from('news_comments as nc')
                                ->join('news as n', 'n.id = nc.news_id')
                                ->where('n.author_id', 1)
                                ->where('n.removed', 0)
                                ->where('nc.removed', 0)
                                ->count_all_results();

        return array( 'all' => $all, 'active' => $active);
    }

    public function count_all_project_likes( ) {

        $all    =    $this->db  ->from('news_likes as nl')
                                ->join('news as n', 'n.id = nl.news_id')
                                ->where('n.author_id', 1)
                                ->count_all_results();

        $active =    $this->db  ->from('news_likes as nl')
                                ->join('news as n', 'n.id = nl.news_id')
                                ->where('n.author_id', 1)
                                ->where('n.removed', 0)
                                ->count_all_results();

        return array( 'all' => $all, 'active' => $active);
    }

    public function has_user_news ( $user_id ) {
        $query =    $this->db   ->from('news')
                                ->where('author_id', $user_id)
                                ->where('company_news', 0)
                                ->where('removed', 0)
                                ->limit(1)
                                ->count_all_results();

        if( $query > 0 )
            return true;
        else return false;
    }

    public function has_company_news ( $company_id ) {
        $query =    $this->db   ->from('news')
                                ->where('author_id', $company_id)
                                ->where('company_news', 1)
                                ->where('removed', 0)
                                ->limit(1)
                                ->count_all_results();

        if( $query > 0 )
            return true;
        else return false;
    }

    public function has_employers_news ( $company_id ) {
        $employers          = $this->Company_model->get_company_employers_ids( $company_id );

        if ( $employers ) {
            foreach ( $employers as $employer ) {
                if( $this->has_user_news($employer) )
                    return true;

            }
        }
        return false;
    }

    public function get_news_author_id ( $news_id ) {
        $query =    $this->db   ->select('author_id')
                                ->from('news')
                                ->where('id', $news_id)
                                ->limit(1)
                                ->get();

        if($query->result()) {
            foreach($query->result() as $row) {
                return $row->author_id;
            }
        } else
            return false;
    }

    public function get_comment_news_id ( $comment_id ) {
        $query =    $this->db   ->select('news_id')
                                ->from('news_comments')
                                ->where('id', $comment_id)
                                ->limit(1)
                                ->get();

        if($query->result()) {
            foreach($query->result() as $row) {
                return $row->news_id;
            }
        } else
            return false;
    }

    public function get_comment_author_id ( $comment_id ) {
        $query =    $this->db   ->select('user_id')
                                ->from('news_comments')
                                ->where('id', $comment_id)
                                ->limit(1)
                                ->get();

        if($query->result()) {
            foreach($query->result() as $row) {
                return $row->user_id;
            }
        } else
            return false;
    }

    public function is_company_news ( $news_id ) {
        $query =    $this->db   ->select('company_news')
                                ->from('news')
                                ->where('id', $news_id)
                                ->limit(1)
                                ->get();

        if($query->result())
            foreach($query->result() as $row) {
                if ($row->company_news == 1)
                    return true;
                else if ($row->company_news == 0)
                    return false;
            }
        else
            return false;
    }


    public function user_statistic__all_comments( $user_id ) {

        $all            =   $this->db   ->from('news_comments nc')
                                        ->join('news n', 'nc.news_id = n.id' )
                                        ->where('n.author_id', $user_id)
                                        ->where('n.company_news', 0)
                                        ->count_all_results();

        $active         =   $this->db   ->from('news_comments nc')
                                        ->join('news n', 'nc.news_id = n.id' )
                                        ->where('n.author_id', $user_id)
                                        ->where('n.company_news', 0)
                                        ->where('n.removed', 0)
                                        ->count_all_results();

        return array( 'all' => $all, 'active' => $active);


    }
    public function user_statistic__all_likes( $user_id ) {

        $all            =   $this->db   ->from('news_likes nl')
                                        ->join('news n', 'nl.news_id = n.id' )
                                        ->where('n.author_id', $user_id)
                                        ->where('n.company_news', 0)
                                        ->count_all_results();

        $active         =   $this->db   ->from('news_likes nl')
                                        ->join('news n', 'nl.news_id = n.id' )
                                        ->where('n.author_id', $user_id)
                                        ->where('n.company_news', 0)
                                        ->where('n.removed', 0)
                                        ->count_all_results();

        return array( 'all' => $all, 'active' => $active);
    }


    public function activate_news($newsID) {
        $data = array(
            'removed' => '0'
        );
        $this->db->update('news', $data, array('id' => $newsID));
        return true;
    }

    public function deactivate_news($newsID) {
        $data = array(
            'removed' => '1'
        );
        $this->db->update('news', $data, array('id' => $newsID));
        return true;
    }



    public function search_news( $keyword, $limit = 10 ) {

        $keywords = explode(" ", $keyword);

        $value = array();
        $this->db->select('n.id, n.content, n.date, n.company_news, u.avatar, n.author_id ');
        $this->db->from('news n');
        $this->db->join('users u', 'n.author_id = u.id');
        $this->db->where('n.removed', 0);

        if( is_array($keywords) && !empty($keywords)):
            foreach($keywords as $search_word):
                $this->db->like('n.content', $search_word, 'both' );
            endforeach;
        endif;

        if ( $limit > 0 )
            $this->db->limit($limit);

        $query = $this->db->get();

        foreach($query->result() as $row) {

            $date_object    = new DateTime($row->date);

            if( $row->company_news == 1 ):
                $row->author_name    = $this->Company_model->get_company_name_by_id( $row->author_id );
            else:
                $row->author_name    = $this->User_model->get_user_name_by_id( $row->author_id );
            endif;

            $value[] = array(
                'avatar'        => $row->avatar,
                'author_id'     => $row->author_id,
                'type'          => 'suggestion',
                'value'         => mb_substr( htmlspecialchars_decode( strip_tags($row->content) ), 0, 125).' ',
                'date'          => $date_object->format('d.m.Y в H:i'),
                'data'          => $row
            );
        }

        return $value;

    }




    private function build_news ( $news ) {

        $this->load->helper('morphem');
        $news->likes                 = $this->count_likes( $news->id );
        $news->comments              = $this->get_comments( $news->id );
        $news->comments_count        = $this->count_comments( $news->id );

        $news->post_type            = 'news';

        if ($news->comments_count != 0)
            $news->comments_count_text   = morphem( $news->comments_count, 'комментарий', 'комментария', 'комментариев');
        else
            $news->comments_count_text   = 'Нет комментариев';

        $news->liked             = $this->is_liked( $news->id, $this->session->user);

        $d          = new DateTime( $news->date );
        $d_now      = new DateTime();
        $interval   = intval( $d_now->format('U') ) - intval( $d->format('U') );

        $news->udate        = $d->format('U');

        if( $news->company_news == 1 ) {

            $news->company_news = true;
            $news->author       = $this->Company_model->get_company_by_id( $news->author_id );
            if( $news->author && $news->author->director == $this->session->user )
            {
                $news->is_author = true;

                if( $interval > 60*60 )
                {
                    $news->editable      = false;
                }
                else
                {
                    $news->editable      = true;
                }
            }
            else
            {
                $news->is_author = false;
                $news->editable  = false;
            }
        }
        else  {
            $news->company_news = false;
            $news->author       = $this->User_model->get_user_by_id( $news->author_id );

            if( $news->author_id == $this->session->user) {
                $news->is_author = true;

                if( $interval > 60*60 ) {
                    $news->editable      = false;
                }
                else  {
                    $news->editable      = true;
                }
            } else {
                $news->is_author = false;
                $news->editable  = false;
            }

        }

        $news->is_exdor_news    = false;

        if( $news->author_id == 1 ) {

            $news->is_exdor_news    = true;

            switch ( $news->taxonomy ) {
                case 'user':
                    $news->taxonomy_public_url      = 'exdor';
                    $news->taxonomy_public_title    = 'Новости проекта';
                    $news->taxonomy_public_icon    = "/uploads/users/1/avatar/80x80_exdor.jpg";
                    break;
                case 'technology':
                    $news->taxonomy_public_url      = $news->taxonomy;
                    $news->taxonomy_public_title    = 'Технологии';
                    $news->taxonomy_public_icon    = "/assets__old/img/news_technology.svg";
                    break;
                case 'money':
                    $news->taxonomy_public_url      = $news->taxonomy;
                    $news->taxonomy_public_title    = 'Финансы';
                    $news->taxonomy_public_icon    = "/assets__old/img/news_money.svg";
                    break;
                case 'interview':
                    $news->taxonomy_public_url      = $news->taxonomy;
                    $news->taxonomy_public_title    = 'Интервью';
                    $news->taxonomy_public_icon    = "/assets__old/img/news_interview.svg";
                    break;
                case 'review':
                    $news->taxonomy_public_url      = $news->taxonomy;
                    $news->taxonomy_public_title    = 'Обзоры';
                    $news->taxonomy_public_icon    = "/assets__old/img/news_review.svg";
                    break;
                case 'humor':
                    $news->taxonomy_public_url      = $news->taxonomy;
                    $news->taxonomy_public_title    = 'Юмор';
                    $news->taxonomy_public_icon    = "/assets__old/img/news_humor.svg";
                    break;
            }



        }


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

        if( $d_now->format("Y") !== $d->format("Y") )
        {
            $news->date      = $day.' '.$m.' '.$d->format('Y');
        }
        else
        {
            $news->date      = $day.' '.$m.' '.$d->format('H:i');
        }




        if( $news->content  ) {
            $news->content_html = $news->content;
            $news->content      = nl2br(htmlspecialchars(trim( $news->content )));
        }

        else
            $news->content = '';

        if($news->images) {
            $news->images = json_decode( $news->images );
            $news->images_count = count( $news->images );
        }
        else
        {
            $news->images = '';
            $news->images_count = 0;
        }

        if($news->images_count > 1)
        {
            $news->slider = true;
        }
        else
        {
            $news->slider = false;
        }

        $news->double_images     = false;
        if( $news->images_count == 2 )
        {
            $news->double_images = true;
        }

        if ( $this->count_user_news( $news->author_id ) <= 1 )
            $news->is_first_news    = true;
        else $news->is_first_news   = false;

        return $news;
    }

    private function build_comment ( $comment ) {

        $user   = $this->User_model->get_user_by_id( $comment->user_id );

        $comment->avatar    = $user->avatar;
        $comment->name      = $user->name;
        $comment->last_name = $user->last_name;
        $comment->phone     = $user->phone;

        $d          = new DateTime( $comment->date );
        $d_now      = new DateTime();
        $interval   = intval( $d_now->format('U') ) - intval( $d->format('U') );

        if( $comment->is_company_news == 1 ) {
            $company_director   = $this->Company_model->get_company_director_id( $comment->news_author_id );

            if( $company_director == $this->session->user  ) {
                $comment->is_author     = false;
                $comment->editable      = false;
                $comment->removable     = true;
            } else {
                $comment->is_author     = false;
                $comment->editable      = false;
                $comment->removable     = false;
            }

            if ( $comment->user_id  == $this->session->user ) {
                $comment->is_author = true;
                $comment->removable = true;
                if ($interval > 60 * 60 * 12) {
                    $comment->editable = false;
                } else {
                    $comment->editable = true;
                }
            }
        }
        else {
            if( $comment->user_id == $this->session->user ) {
                $comment->is_author = true;
                $comment->removable = true;
                if ($interval > 60 * 60 * 12) {
                    $comment->editable = false;
                } else {
                    $comment->editable = true;
                }
            } elseif ( $comment->news_author_id  == $this->session->user ) {
                $comment->is_author     = false;
                $comment->editable      = false;
                $comment->removable     = true;
            } else {
                $comment->is_author     = false;
                $comment->editable      = false;
                $comment->removable     = false;
            }
        }


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

        if( $d_now->format("Y") !== $d->format("Y") )
        {
            $comment->date      = $day.' '.$m.' '.$d->format('Y');
        }
        else
        {
            $comment->date      = $day.' '.$m.' '.$d->format('H:i');
        }

        $comment->m_date    = $d->format('d.m.Y')."<br>".$d->format('в H:i');
        $comment->comment   = substr( nl2br(htmlspecialchars(addslashes(trim( $comment->comment )))) ,0,1000);


        return $comment;
    }
}
