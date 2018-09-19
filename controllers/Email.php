<?php

function send_mail(){

    if(isset($_POST['data'])){
        $to = Mailer::getAdminMail();
        $data = $_POST['data'];
        $topic = sanitize_text_field($data['topic']);
        $message = sanitize_text_field($data['message']);
        $name = sanitize_text_field($data['name']);
        $from = sanitize_text_field($data['email']);


        $headers[] = 'From: '.$name.' <'.$from.'>';
        $headers[] = 'Reply-To: '.$name.' <'.$from.'>,';

        $headers[] = 'Cc: '.$name.''; // note you can just use a simple email address
        $errors = array();
        $result = array();

        foreach($data as $key => $value){
            if($value == 'undefined' || $value == ''){
                $errors[$key] = $value;
            }
        }

        if(sizeof($errors) == 0){
            try {
                $success = wp_mail($to, $topic, $message, $headers);
                $result['result'] = $success;
                $result['msg'] = 'Wiadomość wysłano pomyślnie, niedługo się odezwę';
                echo json_encode($result, true);
            } catch (Exception $e){
                echo json_encode($e->getMessage(), true);
                $result['msg'] = 'Coś poszło nie tak, spróbój później';
            }
        } else{
            echo json_encode($errors, true);
	          $result['msg'] = 'Coś poszło nie tak, spróbój później';
        }

    }
    wp_die();
}
