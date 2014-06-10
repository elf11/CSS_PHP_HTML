<?php
require_once 'idiorm.php';
ORM::configure('sqlite:db.sqlite');

#echo $id . $title . $content . $author . $cat_id;

function create_new_entry($cat_id, $art_id) {
    $cat_entry = ORM::for_table('pw_article_category')->create();
    $cat_entry->artc_art_id = $art_id;
    $cat_entry->artc_cat_id = $cat_id;
    $cat_entry->save();
    #return;
}

function update_article_table($id, $title, $content, $author) {
    ORM::configure('id_column', 'art_id');
    $art_found = ORM::for_table('pw_article')->find_one($id);
    $art_found->set('art_title', $title);
    $art_found->set('art_content', $content);
    $art_found->set('art_author', $author);
    $update_time = date("Y-m-d H:i:s");
    $art_found->set('art_update_date', $update_time);
    $art_found->save();
}

function edit_article() {
    if (empty($_POST['id']) || !isset($_POST['id']) || !is_numeric($_POST['id'])) {
        ob_clean();
        echo 'id';
        return;
    }

    $id = $_POST['id'];

    if (empty($_POST['title']) || !isset($_POST['title'])) {
        ob_clean();
        echo 'title';
        return;
    }
    
    $title = $_POST['title'];
    
    if (empty($_POST['content']) || !isset($_POST['content'])) {
        ob_clean();
        echo 'content';
        return;
    }

    $content = $_POST['content'];

    if (empty($_POST['author']) || !isset($_POST['author'])) {
        ob_clean();
        echo 'author';
        return;
    }
    
    $author = $_POST['author'];
    
    $user = ORM::for_table('pw_user')->where('usr_id', $author)->find_many();
    if ($user == false) {
        ob_clean();
        echo 'author';
        return;
    }

    if (empty($_POST['cat_id']) || !isset($_POST['cat_id']) || !is_array($_POST['cat_id'])) {
        ob_clean();
        echo 'cat_id';
        return;
    }

    $cat_id = $_POST['cat_id'];

    foreach ($cat_id as $idCat) {
        $idC = ORM::for_table('pw_category')->where('cat_id', $idCat)->find_many();
        if ($idC == false) {
            ob_clean();
            echo 'cat_id';
            return;
        }
    }

    update_article_table($id, $title, $content, $author);

    foreach($cat_id as $idCat) {
        create_new_entry($idCat, $id); 
    }

    ob_clean();
    echo 'ok';
}

edit_article();


?>
