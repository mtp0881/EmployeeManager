<?php  
    $id = $_POST['id'];  
    
    try {  
        require "../db_config.php";  
    } catch(Exception $e) {  
        exit('データベースに接続できません。');  
    }  
    
    $sql = "DELETE from events WHERE id=".$id;  
    $q = $bdd->prepare($sql);  
    $q->execute();  
?>  