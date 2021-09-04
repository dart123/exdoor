<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 06.05.16
 * Time: 14:17
 */

class Page_model extends CI_Model {

    public function get_language_switcher($slug = ''){

        if($slug == ''){

            if ($this->router->user_lang == 'ru')
                return '<a href="/en" class="footer__switch-lang is-fade">English</a>';
            elseif ($this->router->user_lang == 'en')
                return '<a href="/" class="footer__switch-lang is-fade">Русский</a>';

        } else {

            $query = $this->db->get_where('pages', array('slug' => $slug), 1, 0);
            foreach($query->result() as $row) {
                $result = $row;
            }

            if ($this->router->user_lang == 'ru')
                return '<a href="/en/page/'.$result->slug.'" class="footer__switch-lang is-fade">English</a>';
            elseif ($this->router->user_lang == 'en')
                return '<a href="/page/'.$result->slug.'" class="footer__switch-lang is-fade">Русский</a>';

        }

    }



    public function get_footer_menu()
    {
        $query  = $this->db->get_where('pages', array('public' => '1'));
        $output = array();

        $output[]   = array(
            "slug"      => $this->lang->line('url_lang_prefix')."/news",
            "title"     => $this->lang->line('news'),
        );
        $output[]   = array(
            "slug"      => $this->lang->line('url_lang_prefix')."/offers",
            "title"     => $this->lang->line('offers'),
        );

        if ($this->router->user_lang == 'ru'):

            $this->lang->load("menu", "russian");

            foreach ($query->result() as $row):
                $output[]     = array(
                    "slug"  => $this->lang->line('url_lang_prefix')."/page/".$row->slug,
                    "title" => $row->title_ru
                );
            endforeach;

        elseif ($this->router->user_lang == 'en'):

            $this->lang->load("menu", "english");

            foreach ($query->result() as $row):
                $output[]     = array(
                    "slug"  => $this->lang->line('url_lang_prefix')."/page/".$row->slug,
                    "title" => $row->title_en
                );
            endforeach;

        endif;

        return $output;
    }

    public function get_sidebar_menu()
    {
        if ($this->router->user_lang == 'ru')
            $this->lang->load("menu", "russian");
        elseif ($this->router->user_lang == 'en')
            $this->lang->load("menu", "english");

        $output = '';
        $menu = array(
            array(
                'title' => $this->lang->line('menu_about'),
                'url'   => $this->lang->line('url_lang_prefix').'/page/about'
            ),
            array(
                'title' => $this->lang->line('menu_news'),
                'url'   => $this->lang->line('url_lang_prefix').'/'
            ),
            array(
                'title' => $this->lang->line('menu_ads'),
                'url'   => $this->lang->line('url_lang_prefix').'/page/ads'
            )
        );
        $i = 0;
        $css_class = "";
        $len = count($menu);
        foreach ($menu as $menu_item) {
            if ($i == 0) {
                $css_class = "is-first-item btn ripple-effect";
            } else if ($i == $len - 1) {
                $css_class = "is-first-item btn ripple-effect";
            }
            $css_class = "btn ripple-effect";
            $output .= '<li><a href="'.$menu_item['url'].'" class="'.$css_class.'">'.$menu_item['title'].'</a></li>';
            $i++;
        }

        return $output;
    }


    public function get_page_by_slug($slug){

        // Выстаскиваем русскую версию страницы
        if ($this->router->user_lang == 'ru') {
            $this->db->select('id, title_ru, content_ru, date_add, meta_title_ru, meta_keywords_ru, meta_description_ru');
            $query = $this->db->get_where('pages', array('slug' => $slug), 1, 0);
            if( $query->result() ) {
                foreach($query->result() as $row){
                    $output = array(
                        'id'                => $row->id,
                        'title'             => $row->title_ru,
                        'content'           => $row->content_ru,
                        'date'              => $row->date_add,
                        'meta_title'        => $row->meta_title_ru,
                        'meta_keywords'     => $row->meta_keywords_ru,
                        'meta_description'  => $row->meta_description_ru
                    );
                }



                return $output;
            } else
                return false;

        }
        // Вытаскиваем английскую версию страницы
        elseif ($this->router->user_lang == 'en') {
            $this->db->select('id, title_en, content_en, date_add, meta_title_en, meta_keywords_en, meta_description_en');
            $query = $this->db->get_where('pages', array('slug' => $slug), 1, 0);
            if( $query->result() ) {
                foreach($query->result() as $row){
                    $output = array(
                        'id'                => $row->id,
                        'title'             => $row->title_en,
                        'content'           => $row->content_en,
                        'date'              => $row->date_add,
                        'meta_title'        => $row->meta_title_en,
                        'meta_keywords'     => $row->meta_keywords_en,
                        'meta_description'  => $row->meta_description_en
                    );
                }
                return $output;
            } else {
                return false;
            }
        }
    }



    public function get_pages( $filter ) {

        $limit          = false;    // Количество новостей для вывода
        if( array_key_exists("limit", $filter) && $filter['limit']  != 0 )
            $limit      = $filter['limit'];

        $offset         = false;    // Отступ (для пагинации)
        if( array_key_exists("offset", $filter) && $filter['offset']  != 0 )
            $offset     = $filter['offset'];

        $count_news         = false;    // Возвращаем только новости
        if( array_key_exists("count", $filter) && $filter['count']  = true )
            $count_news     = true;     // Возвращаем количество новосте


        $output = array();

        if( $limit )
            $this->db->limit( $limit );

        if( $offset )
            $this->db->offset( $offset );

        $this->db->order_by("public DESC, title_ru ASC, title_en ASC");

        $query = $this->db->get('pages');

        if( $query->result() ) {

            if ( $count_news ) {
                return $query->num_rows();
            }
            else {
                foreach($query->result() as $row){
                    $output[] = $row;
                }
                return $output;
            }

        }
    }

    public function get_edit_page_by_id($pageID){
        $output = array();
        $query = $this->db->get_where('pages', array('id' => $pageID), 1, 0);
        foreach($query->result() as $row){
            $output = $row;
        }
        return $output;
    }

    public function add_page (
        $slug,
        $public = 0,
        $date_add,
        $title_ru,
        $title_en,
        $content_ru,
        $content_en,
        $meta_title_ru,
        $meta_title_en,
        $meta_keywords_ru,
        $meta_keywords_en,
        $meta_description_ru,
        $meta_description_en
    ) {

        $data = array(
            'slug'                  => $slug,
            'public'                => $public,
            'date_add'              => $date_add,
            'title_ru'              => $title_ru,
            'title_en'              => $title_en,
            'content_ru'            => $content_ru,
            'content_en'            => $content_en,
            'meta_title_ru'         => $meta_title_ru,
            'meta_title_en'         => $meta_title_en,
            'meta_keywords_ru'      => $meta_keywords_ru,
            'meta_keywords_en'      => $meta_keywords_en,
            'meta_description_ru'   => $meta_description_ru,
            'meta_description_en'   => $meta_description_en
        );

        if ( $this->get_page_by_slug( $data['slug'] ) ) {
            $i = 1;
            $slug = $data['slug'];
            while( $this->get_page_by_slug( $data['slug'] )){
                $data['slug'] = $slug.'_'.$i;
                $i++;
            }
        };

        $this->db->insert('pages', $data );
        return $this->db->insert_id();
    }
    public function update_page(
        $pageID,
        $slug,
        $public = 0,
        $date_add,
        $title_ru,
        $title_en,
        $content_ru,
        $content_en,
        $meta_title_ru,
        $meta_title_en,
        $meta_keywords_ru,
        $meta_keywords_en,
        $meta_description_ru,
        $meta_description_en
    ){
        $data = array(
            'slug'                  => $slug,
            'public'                => $public,
            'date_add'              => $date_add,
            'title_ru'              => $title_ru,
            'title_en'              => $title_en,
            'content_ru'            => $content_ru,
            'content_en'            => $content_en,
            'meta_title_ru'         => $meta_title_ru,
            'meta_title_en'         => $meta_title_en,
            'meta_keywords_ru'      => $meta_keywords_ru,
            'meta_keywords_en'      => $meta_keywords_en,
            'meta_description_ru'   => $meta_description_ru,
            'meta_description_en'   => $meta_description_en
        );

        if ( $this_page = $this->get_page_by_slug( $data['slug'] ) ) {

            if( is_array($this_page) && !empty($this_page) ) {

                if( $this_page['id'] != $pageID ) {

                    $i = 1;
                    $slug = $data['slug'];
                    while( $this->get_page_by_slug( $data['slug'] )){
                        $data['slug'] = $slug.'_'.$i;
                        $i++;
                    }

                }
                else {
                    $data['slug']   = $slug;
                }

            }

            else {
                $data['slug']   = $slug;
            }

        }
        else {
            $data['slug']   = $slug;
        }

        $this->db->update('pages', $data, "id = ".$pageID );
        return true;
    }

    public function delete_page($pageID) {
        $this->db->delete('pages', array('id' => $pageID));
        return true;
    }

    public function activate_page($pageID) {
        $data = array(
            'public' => '1'
        );
        $this->db->update('pages', $data, array('id' => $pageID));
        return true;
    }

    public function deactivate_page($pageID) {
        $data = array(
            'public' => '0'
        );
        $this->db->update('pages', $data, array('id' => $pageID));
        return true;
    }

    public function home_page_link(){

        if ($this->router->user_lang == 'ru')
            $this->lang->load("menu", "russian");
        elseif ($this->router->user_lang == 'en')
            $this->lang->load("menu", "english");

        $output =
            "<a href='".$this->lang->line('url_home_page')."' class='information__go-back is-blue-link'>
                <i class='fa fa-caret-left'></i>
                <span>".$this->lang->line('go_back')."</span>
            </a>";

        return $output;
    }
}