<?php
require_once 'idiorm.php';
ORM::configure('sqlite:db.sqlite');

function create_json($str, $cat_id) {
    if ($cat_id == 0) 
        $res = ORM::for_table('pw_article')->join('pw_user', array('pw_article.art_author', '=', 'pw_user.usr_id'))->where_raw('(art_title LIKE ? OR art_content LIKE ?)', array('%' . $str . '%', '%' . $str . '%'))->order_by_desc('art_publish_date')->find_many();
    else {
        $res = ORM::for_table('pw_article')
        ->join('pw_user', array('pw_article.art_author', '=', 'pw_user.usr_id'))
        ->join('pw_article_category', array('pw_article.art_id', '=', 'pw_article_category.artc_art_id'))
        ->where('pw_article_category.artc_cat_id', $cat_id)
        ->where_raw('(pw_article.art_title LIKE ? OR pw_article.art_content LIKE ?)', array('%' . $str . '%', '%' . $str . '%'))
        ->order_by_desc('pw_article.art_publish_date')->find_many();
    }

    $json = array();

    if (count($res) > 0) { 
        foreach ($res as $val) {
            $posT = strpos($val->art_title, $str);
            $posC = strpos($val->art_content, $str);
            if ($posT !== false || $posC !== false) {
                $bus = array(
                    'id' => $val->art_id,
                    'title' => $val->art_title,
                    'content' => $val->art_content,
                    'views' => $val->art_views,
                    'author' => $val->usr_username,
                    'publish_date' => $val->art_publish_date,
                    'update_date' => $val->art_update_date
                );
                array_push($json, $bus);
                }
            }
    }

    $jsonstring = json_encode($json);
    echo $jsonstring;
}

function return_search() {

    if (empty($_GET['s']) || !isset($_GET['s'])) {
        ob_clean();
        echo 's';
        return;
    }

    $cat_id = 0;

    if (isset($_GET['cat_id']) || !empty($_GET['cat_id'])) {
        $cat_id = (int)$_GET['cat_id'];
    }

    $str = $_GET['s'];

    create_json($str, $cat_id);

}

return_search();

?>
