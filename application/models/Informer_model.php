<?php

/**
 * Created by PhpStorm.
 * User: developer
 * Date: 20.03.17
 * Time: 0:21
 */
class Informer_model extends CI_Model {




    public function informer_update( $type='', $for_user_id = '', $options = array() ) {
        $APEserver = 'http://ape.exdor.ru:6969/0/?';
        $APEPassword = 'testpasswd';

        switch ($type) {
            // Информер о новом входящем сообщении
            case 'notification':
                $cmd = array(
                    array(
                        'cmd' => 'inlinepush',
                        'params' =>  array(
                            'password'  => $APEPassword,
                            'raw'       => 'DATA',
                            'channel'   => 'channel_'.$for_user_id,
                            'data'      => array(
                                'type'      => 'informer__notification',
                                'result'    => $options['noty']
                            )
                        )
                    ),
                );
                break;

            case 'informer__message':
                $cmd = array(
                    array(
                        'cmd' => 'inlinepush',
                        'params' =>  array(
                            'password'  => $APEPassword,
                            'raw'       => 'DATA',
                            'channel'   => 'channel_'.$for_user_id,
                            'data'      => array(
                                'type'      => 'informer__message',
                                'result'    => $options['unread_dialogs']
                            )
                        )
                    ),
                );
                break;

            case 'message':
                $cmd = array(
                    array(
                        'cmd' => 'inlinepush',
                        'params' =>  array(
                            'password'  => $APEPassword,
                            'raw'       => 'DATA',
                            'channel'   => 'channel_'.$for_user_id,
                            'data'      => array(
                                'type'      => 'message',
                                'result'    => $options
                            )
                        )
                    ),
                );
                break;

            case 'message__dialog_update':
                $cmd = array(
                    array(
                        'cmd' => 'inlinepush',
                        'params' =>  array(
                            'password'  => $APEPassword,
                            'raw'       => 'DATA',
                            'channel'   => 'channel_'.$for_user_id,
                            'data'      => array(
                                'type'      => 'message__dialog_update',
                                'result'    => $options
                            )
                        )
                    ),
                );
                break;

            case 'message__edit':
                $cmd = array(
                    array(
                        'cmd' => 'inlinepush',
                        'params' =>  array(
                            'password'  => $APEPassword,
                            'raw'       => 'DATA',
                            'channel'   => 'channel_'.$for_user_id,
                            'data'      => array(
                                'type'      => 'message__edit',
                                'result'    => $options
                            )
                        )
                    ),
                );
                break;

            case 'informer__message__remove':
                $cmd = array(
                    array(
                        'cmd' => 'inlinepush',
                        'params' =>  array(
                            'password'  => $APEPassword,
                            'raw'       => 'DATA',
                            'channel'   => 'channel_'.$for_user_id,
                            'data'      => array(
                                'type'      => 'informer__message__remove',
                                'message'   => $options['message_id']
                            )
                        )
                    ),
                );
                break;


            case 'informer__message__remove__undo':
                $cmd = array(
                    array(
                        'cmd' => 'inlinepush',
                        'params' =>  array(
                            'password'  => $APEPassword,
                            'raw'       => 'DATA',
                            'channel'   => 'channel_'.$for_user_id,
                            'data'      => array(
                                'type'      => 'informer__message__remove__undo',
                                'message'   => $options['message_id']
                            )
                        )
                    ),
                );
                break;

            case 'informer__message_typing':
                $cmd = array(
                    array(
                        'cmd' => 'inlinepush',
                        'params' =>  array(
                            'password'  => $APEPassword,
                            'raw'       => 'DATA',
                            'channel'   => 'channel_'.$for_user_id,
                            'data'      => array(
                                'type'          => 'informer__message_typing',
                                'chatroom_id'   => $options['chatroom_id']
                            )
                        )
                    ),
                );
                break;

            case 'informer__dialog_read':
                $cmd = array(
                    array(
                        'cmd' => 'inlinepush',
                        'params' =>  array(
                            'password'  => $APEPassword,
                            'raw'       => 'DATA',
                            'channel'   => 'channel_'.$for_user_id,
                            'data'      => array(
                                'type'          => 'informer__dialog_read',
                                'chatroom_id'   => $options['chatroom_id']
                            )
                        )
                    ),
                );
                break;

            case 'informer__partner':
                $cmd = array(
                    array(
                        'cmd' => 'inlinepush',
                        'params' =>  array(
                            'password'  => $APEPassword,
                            'raw'       => 'DATA',
                            'channel'   => 'channel_'.$for_user_id,
                            'data'      => array(
                                'type'          => 'informer__partner',
                                'result_in'     => $this->Partner_model->get_inbox_partners_count( $for_user_id ),
                                'result_out'    => $this->Partner_model->get_outbox_partners_count( $for_user_id )
                            )
                        )
                    ),
                );
                break;
            case 'informer__partner__new_partner':
                $cmd = array(
                    array(
                        'cmd' => 'inlinepush',
                        'params' =>  array(
                            'password'  => $APEPassword,
                            'raw'       => 'DATA',
                            'channel'   => 'channel_'.$for_user_id,
                            'data'      => array(
                                'type'      => 'informer__partner__new_partner',
                                'result'    => $options['user'],
                            )
                        )
                    ),
                );
                break;
            case 'informer__partner__new_partner__undo':
                $cmd = array(
                    array(
                        'cmd' => 'inlinepush',
                        'params' =>  array(
                            'password'  => $APEPassword,
                            'raw'       => 'DATA',
                            'channel'   => 'channel_'.$for_user_id,
                            'data'      => array(
                                'type'      => 'informer__partner__new_partner__undo',
                                'result'    => $options['user_id'],
                            )
                        )
                    ),
                );
                break;
            case 'informer__partner__new_inbox_request':
                $cmd = array(
                    array(
                        'cmd' => 'inlinepush',
                        'params' =>  array(
                            'password'  => $APEPassword,
                            'raw'       => 'DATA',
                            'channel'   => 'channel_'.$for_user_id,
                            'data'      => array(
                                'type'      => 'informer__partner__new_inbox_request',
                                'result'    => $options['user'],
                            )
                        )
                    ),
                );
                break;


            case 'informer__partner__cancel_request':
                $cmd = array(
                    array(
                        'cmd' => 'inlinepush',
                        'params' =>  array(
                            'password'  => $APEPassword,
                            'raw'       => 'DATA',
                            'channel'   => 'channel_'.$for_user_id,
                            'data'      => array(
                                'type'      => 'informer__partner__cancel_request',
                                'result'    => $options['user_id'],
                            )
                        )
                    ),
                );
                break;
            case 'informer__partner__cancel_request__undo':
                $cmd = array(
                    array(
                        'cmd' => 'inlinepush',
                        'params' =>  array(
                            'password'  => $APEPassword,
                            'raw'       => 'DATA',
                            'channel'   => 'channel_'.$for_user_id,
                            'data'      => array(
                                'type'      => 'informer__partner__cancel_request__undo',
                                'result'    => $options['user'],
                            )
                        )
                    ),
                );
                break;
            case 'informer__partner__new_outbox_request':
                $cmd = array(
                    array(
                        'cmd' => 'inlinepush',
                        'params' =>  array(
                            'password'  => $APEPassword,
                            'raw'       => 'DATA',
                            'channel'   => 'channel_'.$for_user_id,
                            'data'      => array(
                                'type'      => 'informer__partner__new_outbox_request',
                                'result'    => $options['user'],
                            )
                        )
                    ),
                );
                break;

            case 'informer__news_edit':
                $cmd = array(
                    array(
                        'cmd' => 'inlinepush',
                        'params' =>  array(
                            'password'  => $APEPassword,
                            'raw'       => 'DATA',
                            'channel'   => 'channel_'.$for_user_id,
                            'data'      => array(
                                'type'      => 'informer__news_edit',
                                'result'    => $options
                            )
                        )
                    ),
                );
                break;
            case 'informer__news_comments':
                $cmd = array(
                    array(
                        'cmd' => 'inlinepush',
                        'params' =>  array(
                            'password'  => $APEPassword,
                            'raw'       => 'DATA',
                            'channel'   => 'channel_'.$for_user_id,
                            'data'      => array(
                                'type'      => 'informer__news_comments',
                                'result'    => $options
                            )
                        )
                    ),
                );
                break;
            case 'informer__news_comments__edit':
                $cmd = array(
                    array(
                        'cmd' => 'inlinepush',
                        'params' =>  array(
                            'password'  => $APEPassword,
                            'raw'       => 'DATA',
                            'channel'   => 'channel_'.$for_user_id,
                            'data'      => array(
                                'type'      => 'informer__news_comments__edit',
                                'result'    => $options
                            )
                        )
                    ),
                );
                break;
            case 'informer__news_comments__remove':
                $cmd = array(
                    array(
                        'cmd' => 'inlinepush',
                        'params' =>  array(
                            'password'  => $APEPassword,
                            'raw'       => 'DATA',
                            'channel'   => 'channel_'.$for_user_id,
                            'data'      => array(
                                'type'      => 'informer__news_comments__remove',
                                'result'    => $options
                            )
                        )
                    ),
                );
                break;
            case 'informer__news_comments__remove_undo':
                $cmd = array(
                    array(
                        'cmd' => 'inlinepush',
                        'params' =>  array(
                            'password'  => $APEPassword,
                            'raw'       => 'DATA',
                            'channel'   => 'channel_'.$for_user_id,
                            'data'      => array(
                                'type'      => 'informer__news_comments__remove_undo',
                                'result'    => $options
                            )
                        )
                    ),
                );
                break;

            case 'informer__news_likes':
                $cmd = array(
                    array(
                        'cmd' => 'inlinepush',
                        'params' =>  array(
                            'password'  => $APEPassword,
                            'raw'       => 'DATA',
                            'channel'   => 'channel_'.$for_user_id,
                            'data'      => array(
                                'type'      => 'informer__news_likes',
                                'result'    => $options
                            )
                        )
                    ),
                );
                break;
            case 'new_news':
                $cmd = array(
                    array(
                        'cmd' => 'inlinepush',
                        'params' =>  array(
                            'password'  => $APEPassword,
                            'raw'       => 'DATA',
                            'channel'   => 'channel_'.$for_user_id,
                            'data'      => array(
                                'type'      => 'new_news',
                                'result'    => $options
                            )
                        )
                    ),
                );
                break;
            case 'new_ads':
                $cmd = array(
                    array(
                        'cmd' => 'inlinepush',
                        'params' =>  array(
                            'password'  => $APEPassword,
                            'raw'       => 'DATA',
                            'channel'   => 'channel_'.$for_user_id,
                            'data'      => array(
                                'type'      => 'new_ads',
                                'result'    => $options
                            )
                        )
                    ),
                );
                break;
            case 'new_equipment':
                $cmd = array(
                    array(
                        'cmd' => 'inlinepush',
                        'params' =>  array(
                            'password'  => $APEPassword,
                            'raw'       => 'DATA',
                            'channel'   => 'channel_'.$for_user_id,
                            'data'      => array(
                                'type'      => 'new_equipment',
                                'result'    => $options
                            )
                        )
                    )
                );
                break;

            case 'employer_added':
                $cmd = array(
                    array(
                        'cmd' => 'inlinepush',
                        'params' =>  array(
                            'password'  => $APEPassword,
                            'raw'       => 'DATA',
                            'channel'   => 'channel_'.$for_user_id,
                            'data'      => array(
                                'type'      => 'new_employer',
                                'result'    => $options
                            )
                        )
                    )
                );
                break;

            case 'employers_count':
                $cmd = array(
                    array(
                        'cmd' => 'inlinepush',
                        'params' =>  array(
                            'password'  => $APEPassword,
                            'raw'       => 'DATA',
                            'channel'   => 'channel_'.$for_user_id,
                            'data'      => array(
                                'type'      => 'employers_count',
                                'result'    => $options
                            )
                        )
                    )
                );
                break;

            case 'informer__request':
                $cmd = array(
                    array(
                        'cmd' => 'inlinepush',
                        'params' =>  array(
                            'password'  => $APEPassword,
                            'raw'       => 'DATA',
                            'channel'   => 'channel_'.$for_user_id,
                            'data'      => array(
                                'type'      => 'informer__request',
                                'result'    => $options
                            )
                        )
                    ),
                );
                break;

            case 'requests__list__new':
                $cmd = array(
                    array(
                        'cmd' => 'inlinepush',
                        'params' =>  array(
                            'password'  => $APEPassword,
                            'raw'       => 'DATA',
                            'channel'   => 'channel_'.$for_user_id,
                            'data'      => array(
                                'type'      => 'requests__list__new',
                                'result'    => $options
                            )
                        )
                    ),
                );
                break;

            case 'requests__list__update':
                $cmd = array(
                    array(
                        'cmd' => 'inlinepush',
                        'params' =>  array(
                            'password'  => $APEPassword,
                            'raw'       => 'DATA',
                            'channel'   => 'channel_'.$for_user_id,
                            'data'      => array(
                                'type'      => 'requests__list__update',
                                'result'    => $options
                            )
                        )
                    ),
                );
                break;


            default:
                $cmd = array();
                break;

        };

        $data = file_get_contents($APEserver.rawurlencode(json_encode($cmd)));
        $data = json_decode($data);
        if ($data[0]->data->value == 'ok')
        {
            //echo 'Message sent!';
        } else {
            //echo 'Error sending message, server response is : <pre>'.json_encode($data).'</pre>';
        }
    }
}

