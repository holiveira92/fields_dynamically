<?php
$connect            = mysqli_connect("app.galo.q4dev.com.br", "root", "", "dinamically");
$number             = count($_POST["title_card"]);
$ids_delete         = explode(',',$_POST["json_delete"]);
$table_data         = array();
for($i=0; $i<$number; $i++){
    $table_data[] = array(
        'id_card'               => !empty($_POST["id_card"][$i]) ? $_POST["id_card"][$i] : '',
        'title_card'            => !empty($_POST["title_card"][$i]) ? $_POST["title_card"][$i] : '',
        'subtitle_card'         => !empty($_POST["subtitle_card"][$i]) ? $_POST["subtitle_card"][$i] : '',
        'text_footer_card'      => !empty($_POST["text_footer_card"][$i]) ? $_POST["text_footer_card"][$i] : '',
        'subtext_footer_card'   => !empty($_POST["subtext_footer_card"][$i]) ? $_POST["subtext_footer_card"][$i] : '',
        'card_link'             => !empty($_POST["card_link"][$i]) ? $_POST["card_link"][$i] : '',
        'img_bg_url'            => !empty($_POST["img_bg_url"][$i]) ? $_POST["img_bg_url"][$i] : '',
    );
}

foreach($table_data as $key=>&$value){
    if(empty($value['id_card'])){
        unset($value['id_card']);
        //insert
        $fields                 = implode("','",$value);
        $sql                    = "INSERT INTO wp_d1_cases(title_card,subtitle_card,text_footer_card,subtext_footer_card,card_link,img_bg_url) VALUES('$fields')";
        mysqli_query($connect, $sql);
    }else{
        //update
        $id_card                = $value['id_card'];
        $title_card             = $value['title_card'];
        $subtitle_card          = $value['subtitle_card'];
        $text_footer_card       = $value['text_footer_card'];
        $subtext_footer_card    = $value['subtext_footer_card'];
        $card_link              = $value['card_link'];
        $img_bg_url             = $value['img_bg_url'];
        $sql                    = "UPDATE wp_d1_cases SET title_card='$title_card', subtitle_card='$subtitle_card', text_footer_card='$text_footer_card',
         subtext_footer_card='$subtext_footer_card', card_link='$card_link', img_bg_url='$img_bg_url' WHERE id_card = '$id_card';";
        mysqli_query($connect, $sql);
    }
}

if(!empty($ids_delete[0])){
    foreach($ids_delete as $id){
        $sql                    = "DELETE FROM wp_d1_cases WHERE id_card=$id;";
        mysqli_query($connect, $sql);
    }
}