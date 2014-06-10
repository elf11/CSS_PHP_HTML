<?php
require_once 'idiorm.php';
ORM::configure('sqlite:db_table.sqlite');

function create_array() {

    $json = array();

    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        die();
    } else {
        $artid = $_GET['id'];
    }

    $comments = ORM::for_table('pw_comments')->where('artid', $artid)->find_many();

    foreach ($comments as $val) {
        $bus = array(
            'name'=> $val->usr_username,
            'date'=> $val->com_publish_date,
            'body'=> $val->usr_mes
        );
        array_push($json, $bus);
    }


    #$jsonstring = json_encode($json);
    #print_r($json);
    #die();

    return $json;


}

function create_html_comment($coms) {

    $result = '';

    for ($i=0; $i<count($coms); $i++) {

        $input = $coms[$i];

        #echo $i;
        #print_r($input);
        #die();

        $input['date'] = strtotime($input['date']);

        $result = $result . '
            <div class="comment">
                <div class="name">'.$input['name'].'</div>
                <div class="date" title="Added at '.date('H:i \o\n d M Y',$input['date']).'">'.date('d M Y',$input['date']).'</div>
                <p>'.$input['body'].'</p>
            </div>
        ';

    }

    return $result;
}

function refreshComments() {

    $com = create_array();

    echo json_encode(array('status'=>1,'html'=>create_html_comment($com)));

}

refreshComments();

?>