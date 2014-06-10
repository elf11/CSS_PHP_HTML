<?php
require_once 'idiorm.php';
ORM::configure('sqlite:db_table.sqlite');


function validate_body($str) {

	if(mb_strlen($str,'utf8')<1 || mb_strlen($str, 'utf8') > 100)
		return false;

	// Encode all html special characters (<, >, ", & .. etc) and convert
	// the new line characters to <br> tags:

	$str = nl2br(htmlspecialchars($str));

	// Remove the new line characters that are left
	$str = str_replace(array(chr(10),chr(13)),'',$str);

	return $str;
}

function validate_name($str) {

    if(mb_strlen($str,'utf8')<1)
    		return false;

    $str = str_replace(array(chr(10),chr(13)),'',$str);

    return $str;
}

function validate(&$arr) {

    $errors = array();
    $data	= array();


    $artid = $_POST['artid'];
    if (isset($artid)) {
        if(is_numeric($artid) ) {
            $data['artid'] = $artid;
        } else {
            $errors['artid'] = 'Invalid article id.';
        }

    } else {
        $errors['artid'] = 'Invalid article id.';
    }


    if (isset($_POST['name'])) {
        if(!($data['name'] = filter_input(INPUT_POST,'name',FILTER_CALLBACK,array('options'=>'validate_name')))) {
            $errors['name'] = 'You provided an invalid name, the length of the name should be more than 1 char.';
        }
    }

    if (isset($_POST['email'])) {
        if(!($data['email'] = filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL))) {
    	    $errors['email'] = 'You provided an invalid email address.';
        }
    }

    if (isset($_POST['email'])) {
        if(!($data['body'] = filter_input(INPUT_POST,'body',FILTER_CALLBACK,array('options'=>'validate_body')))) {
        	$errors['body'] = 'The comment should not be null and it should contain less than 100 characters.';
        }
    }

    if(!empty($errors)) {
        $arr = $errors;
    	return false;
    }

    if(!function_exists('sqlite_escape_string')){
        function sqlite_escape_string($string) {
            return str_replace("'", "''", $string);
        }
    }

    foreach($data as $k=>$v) {
        $arr[$k] = sqlite_escape_string($v);
    }

    // email address in all lower case
    $arr['email'] = strtolower(trim($arr['email']));

    return true;

}

function create_html_comment($input) {

    // Converting the time to a UNIX timestamp:
    $input['date'] = strtotime($input['date']);

    return '
    	<div class="comment">
            <div class="name">'.$input['name'].'</div>
            <div class="date" title="Added at '.date('H:i \o\n d M Y',$input['date']).'">'.date('d M Y',$input['date']).'</div>
            <p>'.$input['body'].'</p>
    	</div>
    ';

}

function create_new_record($input_data, &$date) {
    $comments = ORM::for_table('pw_comments')->create();
    $comments->usr_username = $input_data['name'];
    $comments->usr_email = $input_data['email'];
    $comments->usr_mes = $input_data['body'];
    $reg_time = date("Y-m-d H:i:s");
    $comments->com_publish_date = $reg_time;
    $date = $reg_time;
    $comments->artid = $input_data['artid'];
    $comments->save();
}


function add_the_comment() {
    $input_data = array();
    $valid = validate($input_data);

    if ($valid) {

        create_new_record($input_data, $date);

        $input_data['date'] = $date;

        create_html_comment($input_data);

        echo json_encode(array('status'=>1,'html'=>create_html_comment($input_data)));

    } else {
      	echo '{"status":0,"errors":'.json_encode($input_data).'}';
    }
}

add_the_comment();

?>