<?php
function get_card($id_card=false){
    //configurações do banco de dados
    $config = array(
        'host'      => "app.galo.q4dev.com.br",
        'database'  => "dinamically",
        'user'      => "root",
        'pass'      => "",
    );

    //conecta ao banco de dados e executa a query
    $con            = mysql_pconnect($config['host'],$config['user'],$config['pass']) or trigger_error(mysql_error(),E_USER_ERROR); 
    mysql_select_db($config['database'], $con);
    $query          = sprintf("SELECT * FROM wp_d1_cases");
    if($id_card){
        $sql = $sql . "WHERE id_card=$id_card";
    }
    $dados          = mysql_query($query, $con) or die(mysql_error());
    while($line = mysql_fetch_array($dados, MYSQL_ASSOC)){
        $result[] = $line;
    }
    return $result;
}
?>