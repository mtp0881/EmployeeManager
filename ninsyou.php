<?php
  //ログインチェック
  include 'logincheck.php';
  
  	//本来はユーザが入力する値
  	$userId = $_POST['UserID'];
  	$password = $_POST['Password'];;
  	
  	//SQLインジェクション
  	//$userId = '適当';
  	//$password = "' OR 'A' = 'A";
  	
  try{
  	//DB接続
  	require_once('./DBInfo.php');
  	$pdo = new PDO(DBInfo::DSN, DBInfo::USER, DBInfo::PASSWORD, array(PDO::ATTR_PERSISTENT => true));
  	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  			
  	//参照系SQL
  	$sql = "SELECT * FROM myuser WHERE user_id=:userId AND password=:password";
  
  	// print("{$sql}<br/>");
  				
  	//参照系SQLを発行
  	$statement = $pdo->prepare($sql);
  	$statement->bindValue(":userId", $userId);
  	$statement->bindValue(":password", $password);
  	$statement->execute();
  				
  	//セッションを使用する関数
  	session_start();
  
  	//セッションIDを変更する関数
  	session_regenerate_id(TRUE);
  				
  	//データの取得
  	if($row = $statement->fetchObject()){
  		//スーパーグローバル変数「$_SESSION」でセッションに代入
  		$_SESSION['LoginOK'] = "OK";
  		$_SESSION['userName'] = $row->user_id;
  		$_SESSION['role'] = $row->role;
  		// print($_SESSION['LoginOK']);
  		header('location:./index.php');
  	}
  	else{
  		//スーパーグローバル変数「$_SESSION」でセッションに代入
  		$_SESSION['LoginOK'] = "NG";
  		header('location:./login.php');
  	}
  } catch(PDOException $e){
  		//エラー情報の表示
  		// $code = $e->getCode();
  		$message = $e->getMessage();
  	}
  	//DB切断
  	$pdo = null;
  ?>