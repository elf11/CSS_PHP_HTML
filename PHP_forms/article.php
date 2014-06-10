<?php
require_once 'idiorm.php';
ORM::configure('sqlite:db.sqlite');

function check_if_valid() {
    if (!isset($_GET['art_id']) || empty($_GET['art_id'])) {
        return false;
    }

    $nrElemInArt = ORM::for_table('pw_article')->where('art_id', $_GET['art_id'])->find_many();  

    if (!is_numeric($_GET['art_id']) || $nrElemInArt == false) {
        return false;
    }

    return true;
}

function update_article_table($id) {
    ORM::configure('id_column', 'art_id');
    $art_found = ORM::for_table('pw_article')->find_one($id);
    $newViews = $art_found->art_views + 1;
    $art_found->set('art_views', $newViews);
    $art_found->save();
    return;
}  

function create_json($art_id) {
    $arts = ORM::for_table('pw_article')->join('pw_user',array('pw_article.art_author', '=', 'pw_user.usr_id'))->where('art_id', $art_id)->find_many();
    $json = array();
    
    foreach ($arts as $val) {
        $json = array(
            'id' => $val->art_id,
            'title' => $val->art_title,
            'content' => $val->art_content,
            'views' => $val->art_views,
            'author' => $val->usr_username,
            'publish_date' => $val->art_publish_date,
            'update_date' => $val->art_update_date
        );
    }

    $jsonstring = json_encode($json);
    echo $jsonstring;
}

function return_list() {

    $check = check_if_valid();
    if ($check === false) {
        ob_clean();
        echo 'wrong_art';
        return;
    }
    $art_id = $_GET['art_id'];

    create_json($art_id);

    update_article_table($art_id);
}

return_list();

?>
