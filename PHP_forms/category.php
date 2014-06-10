<?php
require_once 'idiorm.php';
ORM::configure('sqlite:db.sqlite');

function check_if_valid() {
    if ($_GET['cat_id'] === "" || !isset($_GET['cat_id']) || empty($_GET['cat_id'])) {
        return false;
    }

    $nrElemInCat = ORM::for_table('pw_category')->where('cat_id', $_GET['cat_id'])->find_many();  

    if (($nrElemInCat == false) || !is_numeric($_GET['cat_id'])) {
        return false;
    }

    return true;
}

function create_json($cat_id) {
    $arts = ORM::for_table('pw_article_category')->join('pw_article', array('pw_article_category.artc_art_id', '=', 'pw_article.art_id'))->where('artc_cat_id', $cat_id)->order_by_desc('pw_article.art_publish_date')->join('pw_user', array('pw_article.art_author', '=', 'pw_user.usr_id'))->find_many();

    $json = array();
    
    foreach ($arts as $val) {
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

    $jsonstring = json_encode($json);
    echo $jsonstring;
}

function return_list() {

    $check = check_if_valid();
    if ($check === false) {
        ob_clean();
        echo 'wrong_cat';
        return;
    }
    $cat_id = $_GET['cat_id'];

    create_json($cat_id);

}

return_list();

?>
