<?php
  include 'logincheck.php';
  
  if($_POST['employee_no']== ''){

    header('location:./syainlist.php');

  }	
  
  $employee_no     = $_POST['employee_no'];
  $last_name       = $_POST['last_name'];
  $first_name      = $_POST['first_name'];
  $last_name_kana  = $_POST['last_name_kana'];	
  $first_name_kana = $_POST['first_name_kana'];	
  $gender          = $_POST['radio'];	
  $entrance_date   = $_POST['entrance_date'];	
  $salary          = $_POST['salary'];	
  $manager         = $_POST['manager'];
  $department      = $_POST['department'];
  $face_image      = $_POST['face'];	
  
  try{
    require_once('./DBInfo.php');
    $pdo = new PDO(DBInfo::DSN, DBInfo::USER, DBInfo::PASSWORD, array(PDO::ATTR_PERSISTENT => true));
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "INSERT INTO employee(employee_no,last_name,first_name,last_name_kana,first_name_kana,gender,entrance_date,salary,manager,department,face_image) VALUES(:employee_no,:last_name,:first_name,:last_name_kana,:first_name_kana,:gender,:entrance_date,:salary,:manager,:department,:face_image)";
    
    $statement = $pdo->prepare($sql);
    
    $statement->bindValue(":employee_no", $employee_no);
    $statement->bindValue(":last_name", $last_name);
    $statement->bindValue(":first_name", $first_name);
    $statement->bindValue(":last_name_kana", $last_name_kana);
    $statement->bindValue(":first_name_kana", $first_name_kana);
    $statement->bindValue(":gender", $gender);
    $statement->bindValue(":entrance_date", $entrance_date);
    $statement->bindValue(":salary", $salary);
    $statement->bindValue(":manager", $manager);
    $statement->bindValue(":department", $department);
    $statement->bindValue(":face_image", $face_image);
    
    $statement->execute();
    
    $pdo = null;
    
    header('location:./syainlist.php');
  }
  catch(PDOException $e){
    $pdo = null;

    header('location:./syainlist.php');
  }
  ?>