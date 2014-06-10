 <?php
require_once 'idiorm.php';
ORM::configure('sqlite:db.sqlite');

#$table = $_GET['table'];

function create_json($table) {
    if ($table === 'pw_article') {
        $arts = ORM::for_table('pw_article')->find_many();
            $json = array();
            foreach ($arts as $val) {
                $bus = array(
                    'art_id' => $val->art_id,
                    'art_title' => $val->art_title,
                    'art_content' => $val->art_content,
                    'art_views' => $val->art_views,
                    'art_publish_date' => $val->art_publish_date,
                    'art_update_date' => $val->art_update_date,
                    'art_author' => $val->art_author
                );
                array_push($json, $bus);
            }
            $jsonstring = json_encode($json);
            echo $jsonstring;
        }

        if ($table === 'pw_article_category') {
            $arts = ORM::for_table('pw_article_category')->find_many();
            $json = array();
            foreach ($arts as $val) {
                $bus = array(
                    'artc_art_id' => $val->artc_art_id,
                    'artc_cat_id' => $val->artc_cat_id
                );
                array_push($json, $bus);
            }
            $jsonstring = json_encode($json);
            echo $jsonstring;
        }

        if ($table === 'pw_category') {
            $arts = ORM::for_table('pw_category')->find_many();
            $json = array();
            foreach ($arts as $val) {
                $bus = array(
                    'cat_id' => $val->cat_id,
                    'cat_title' => $val->cat_title
                );
                array_push($json, $bus);
            }
            $jsonstring = json_encode($json);
            echo $jsonstring;
        }

        if ($table === 'pw_user') {
            $arts = ORM::for_table('pw_user')->find_many();
            $json = array();
            foreach ($arts as $val) {
                $bus = array(
                    'usr_id' => $val->usr_id,
                    'usr_username' => $val->usr_username,
                    'usr_password' => $val->usr_password,
                    'usr_salt' => $val->usr_salt,
                    'usr_register_date' => $val->usr_register_date,
                    'usr_last_login' => $val->usr_last_login
                );
                array_push($json, $bus);
            }
            $jsonstring = json_encode($json);
            echo $jsonstring;
        }
    }

    function check_if_valid($table) {
        if (ereg('[^a-zA-Z0-9_]', $table)) {
            return false;
        } else {
            return true;
        }
    }

    function return_list() {

        if (empty($_GET['table']) || !isset($_GET['table'])) {
            ob_clean();
            echo 'wrong_table';
            return;
        } else {
            $table = $_GET['table'];
            $check = check_if_valid($table);
            if ($check === false) {
                ob_clean();
                echo 'wrong_table';
                return;
            }
        } 

        create_json($table);

    }

    return_list();

?>
