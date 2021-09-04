<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 10.07.17
 * Time: 15:34
 */

class Permissions_model extends CI_Model
{

    public function if_user_can( $action = '', $user_id = 0, $object_id = 0, $options = array() )
    {
        switch ( $action ) {

            /*
             *
             *
             *      Новости и комментарии к ним
             *
             *
             */

            case 'news__edit':

            case 'news__remove':

                $author_id          = $this->News_model->get_news_author_id( $object_id );
                $is_company_news    = $this->News_model->is_company_news( $object_id );

                if( $is_company_news ) {

                    $company_director = $this->Company_model->get_company_director_id( $author_id );
                    if ( $user_id == $company_director )
                        return true;
                    else return false;

                } else {

                    if ( $user_id == $author_id )
                        return true;
                    else return false;

                }

                break;

            case 'news_comment__edit':

                $author_id          = $this->News_model->get_comment_author_id( $object_id );

                if( $user_id == $author_id ) {
                    return true;
                } else return false;

                break;

            case 'news_comment__remove':

                $news_id            = $this->News_model->get_comment_news_id( $object_id );
                $author_id          = $this->News_model->get_comment_author_id( $object_id );
                $news_author_id     = $this->News_model->get_news_author_id( $news_id );
                $is_company_news    = $this->News_model->is_company_news( $news_id );

                if( $is_company_news ) {
                    $company_director = $this->Company_model->get_company_director_id( $news_author_id );

                    if( $user_id == $author_id || $user_id == $company_director  ) {
                        return true;
                    } else return false;

                } else {

                    if( $user_id == $author_id || $user_id == $news_author_id ) {
                        return true;
                    } else return false;

                }

                break;


            /*
             *
             *
             *          Сообщения
             *
             *
             */

            case 'chatroom_view':

                $result         = $this->Message_model->is_user_in_dialog( $user_id, $object_id );
                return $result;

                break;


            /*
             *
             *
             *          Заявки
             *
             *
             */

            case 'request__read_mode_from_user' :
                $see_from       = $options['from'];
                $request_id     = $object_id;
                $director       = $user_id;

                $company_id     = $this->Company_model->get_company_id_by_director_id( $director );
                $request_data   = $this->Request_model->get_request($request_id);

                if( $this->Company_model->is_user_my_director($see_from, $director)  ||  $this->Company_model->is_ex_employer($see_from, $company_id) ) {

                    if ($request_data->author == $see_from) {
                        if( $request_data->company_id == $company_id )
                            return 'author_view';
                        else
                            return false;
                    } else {

                        $request_relation   = $this->Request_model->get_user_request_relation( $request_id, $see_from );

                        if( $request_relation && is_object($request_relation) && $request_relation->company_id == $company_id ) {

                            if ($request_data->executor != 0 && $request_data->executor == $see_from) {
                                return 'executor_view';
                            } else {
                                return 'partner_view';
                            }

                        }
                        else {
                            return false;
                        }

                    }
                }
                else
                    return false;


                break;

            case 'request__read_mode':

                $request_data       = $this->Request_model->get_request($object_id);

                if( $this->Company_model->is_user_my_director($request_data->author, $user_id) )
                    return $request_data->author;


                $request_users      = $this->Request_model->get_request_partners_ids( $object_id );

                if( is_array($request_users) && !empty( $request_users ) ) {
                    foreach( $request_users as $request_user_id ) {
                        if( $this->Company_model->is_user_my_director( $request_user_id, $user_id) )
                            return $request_user_id;

                    }
                }
                else {
                    return false;

                }


                break;

            case 'request__view':

                $request_data       = $this->Request_model->get_request($object_id);

                if( is_object($request_data) ) {

                    if( $request_data->author == $user_id )
                        return true;

                    if( $this->Company_model->is_user_my_director($request_data->author, $user_id) )
                        return true;    // Показываем, если директор автора


                    $request_users      = $this->Request_model->get_request_partners_ids( $object_id );

                    if( is_array($request_users) && !empty( $request_users ) ) {
                        foreach( $request_users as $request_user_id ) {

                            if( $request_user_id == $user_id )
                                return true;

                            if( $this->Company_model->is_user_my_director( $request_user_id, $user_id) )
                                return true;    // Показываем, если директор автора

                        }
                    }
                    else {
                        return false;

                    }



                }
                else
                    return false;

                break;

            case 'request__actions':

                $request_data       = $this->Request_model->get_request($object_id);

                if( is_object($request_data) ) {

                    if( $request_data->author == $user_id )
                        return true;

                    if( $request_data->executor != 0) {

                        if( $request_data->executor == $user_id )
                            return true;

                    } else {

                        $request_users      = $this->Request_model->get_request_partners_ids( $object_id );

                        if( is_array($request_users) && !empty( $request_users ) ) {
                            foreach( $request_users as $request_user_id ) {

                                if( $request_user_id == $user_id )
                                    return true;

                            }

                            return false;

                        } else
                            return false;

                    }

                } else return false;

                break;

            case 'request__compare_view':

                $request_data       = $this->Request_model->get_request($object_id);

                if ( is_object( $request_data ) ) {

                    if( $request_data->author == $user_id )
                        return true;    // Показываем, если автор

                    if( $this->Company_model->is_user_my_director($request_data->author, $user_id) )
                        return true;    // Показываем, если директор автора
                    else
                        return false;

                } else
                    return false;

                break;

            case 'request__compare_actions':

                $request_data       = $this->Request_model->get_request($object_id);

                if ( is_object( $request_data ) ) {

                    if( $request_data->author == $user_id && !$request_data->executor )
                        return true;    // Показываем, если автор

                    else
                        return false;

                } else
                    return false;

                break;

            case 'request__copy':

                $request        = $this->Request_model->get_request( $object_id );

                if( is_object( $request ) && $request->author == $user_id ) {
                    return true;
                } else return false;

                break;

        }
    }
}
