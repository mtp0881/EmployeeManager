<?php

   // 全てのイベント表示する
   $json = array();  

   $requete = "SELECT * FROM events ORDER BY id";  

   try {  
      require "../db_config.php";  
   } catch(Exception $e) {  
      exit('データベースに接続できません。');  
   }  

   $resultat = $bdd->query($requete) or die(print_r($bdd->errorInfo()));  

   echo json_encode($resultat->fetchAll(PDO::FETCH_ASSOC));  
?>  