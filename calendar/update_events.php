<?php  
    $id = $_POST['id'];  
    $title = $_POST['title'];  
    $start = $_POST['start'];  
    $end = $_POST['end'];  
    
    try {  
        require "../db_config.php";  
    } catch(Exception $e) {  
        exit('データベースに接続できません。');  
    }  
    
    $sql = "UPDATE events SET title=?, start=?, end=? WHERE id=?";  
    $q = $bdd->prepare($sql);  
    $q->execute(array($title,$start,$end,$id));  
?>  