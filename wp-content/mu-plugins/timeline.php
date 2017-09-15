<?php

/*
  Plugin Name: Dudley Timeline
  Description:
  Version: 1.0
  Author: Matthew Bull @ Philosophy Design
  Author URI: http://www.philosophydesign.com
 */
!defined('ABSPATH') and exit;

if (!isset($_SESSION))
    session_start();


Class DudleyTimeline {

    private static $post_type = "timeline";

    public static function init() {
        add_action( "init", array( __CLASS__, "register_post_type" ) );
        add_action('p2p_init', array(__CLASS__, "register_connections"));
        add_action('wp_loaded', array(__CLASS__, 'timeline_search_submit'));
        add_action('pre_get_posts', array(__CLASS__, 'show_all_alphabetically'));
        add_action('wp_ajax_get-search-suggestions', array(__CLASS__, 'get_search_sugestions'));
        add_action('wp_ajax_nopriv_get-search-suggestions', array(__CLASS__, 'get_search_sugestions'));
    }

    public static function register_connections() {


    }

    public static function register_post_type() {
        $args = array(
            "label" => "Timeline",
            "public" => true,
            "show_in_menu" => true,
            "supports" => array("title", "editor", "thumbnail", "revisions"),
            "has_archive" => "timeline/timeline",
            "rewrite" => array(
                "with_front" => false,
                "slug" => "timeline/timeline"
            ),
            'menu_icon' => get_template_directory_uri() . '/imgs/admin/timeline.png'
        );
        register_post_type(self::$post_type, $args);
    }

    public static function show_all_alphabetically($query) {
        if (!isset($query->query['post_type']) || $query->query['post_type'] != self::$post_type)
            return;
        $query->set("posts_per_page", -1);
        $query->set("orderby", "title");
        $query->set("order", "ASC");
    }

    public static function timeline_search_submit() {
//        var_dump($_POST);
        if (!isset($_POST['search_timeline_nonce']))
            return;
        if (!wp_verify_nonce($_POST['search_timeline_nonce'], 'search_people'))
            return;
        if (!empty($_POST['ge_service']))
            $_SESSION['timeline_search_service'] = (int) $_POST['ge_service'];
        else
            unset($_SESSION['peep_search_service']);
        if (!empty($_POST['ge_sector']))
            $_SESSION['timeline_search_sector'] = (int) $_POST['ge_sector'];
        else
            unset($_SESSION['timeline_search_sector']);
        if (!empty($_POST['ge_office']))
            $_SESSION['timeline_search_office'] = (int) $_POST['ge_office'];
        else
            unset($_SESSION['timeline_search_office']);

        if (!empty($_POST['timeline_keyword_search'])) {
            $_SESSION['timeline_keyword_search'] = strip_tags($_POST['timeline_keyword_search']);
            //IE sends out the placeholder (sooo retarded... d'oh)
            if ($_SESSION['timeline_keyword_search'] == '') {
                unset($_SESSION['timeline_keyword_search']);
            }
        } else {
            unset($_SESSION['timeline_keyword_search']);
        }
    }

    public static function get_search_sugestions() {
        global $post;

        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json");

        $term = strip_tags($_GET["term"]);

        global $wpdb;

        $sql = "
                SELECT
                    post_title, ID
                FROM
                    `" . $wpdb->prefix . "posts`
                WHERE
                    `post_title` LIKE '%" . $term . "%'
                AND
                    `post_type` = 'timeline'
                LIMIT 20
                ";

        $values = $wpdb->get_results($sql);

        foreach ($values as $v) {
            $v->post_title = trim($v->post_title);
            $return[$v->post_title] = $v->post_title;
        }

        $response = json_encode($return);
        print($response);
        die();
    }
}

//DudleyTimeline::init();
