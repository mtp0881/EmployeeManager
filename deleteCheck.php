<?php
	//ログインチェック
include 'logincheck.php';

//パラメータの取得
if(isset($_GET['employee_no'])== TRUE && $_GET['employee_no'] != ''){
	$Delkey =$_GET['employee_no'];
	$_SESSION["Delkey"] = $Delkey;
}

else{
	header('location:./employee_list.php');
}

try{
	
	//DB接続
	require_once('./DBInfo.php');
	$pdo = new PDO(DBInfo::DSN, DBInfo::USER, DBInfo::PASSWORD, array(PDO::ATTR_PERSISTENT => true));
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	//参照系SQL
	$sql = "SELECT * FROM employee WHERE A.employee_no = :employee_no ";

	//参照系SQLを発行
	$statement = $pdo->prepare($sql);

	$statement->bindValue(":employee_no", $Delkey);

	$statement->execute();
	
	//データの取得
	if($row = $statement->fetch()){
		
	}
	else{
		$title = '該当データはありません';
	}
	
	//DB切断
	$pdo = null;
	
}
catch(PDOException $e){
	
	//DB切断
	$pdo = null;
	
	//社員データ一覧に移動する
	header('location:./employee_list.php');
}
?>