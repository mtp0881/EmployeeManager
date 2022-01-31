<?php
    //ログインチェック
	include 'logincheck.php';
	//スーパーグローバル変数「$_SESSION」でセッションを参照
	$Delkey = '';
	if(isset($_SESSION["Delkey"]) == TRUE){
		$Delkey = $_SESSION["Delkey"];
	}
	else{
		header('location:./syainlist.php');
    }
	try{
		
		//DB接続
		require_once('./DBInfo.php');
		$pdo = new PDO(DBInfo::DSN, DBInfo::USER, DBInfo::PASSWORD, array(PDO::ATTR_PERSISTENT => true));
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		//更新系SQL 
		$sql = "DELETE FROM employee WHERE employee_no = :employee_no";
	
		//更新系SQLを発行
		$statement = $pdo->prepare($sql);
		
		$statement->bindValue(":employee_no", $Delkey);

		$statement->execute();
		
		//DB切断
		$pdo = null;
		//削除後にセッション変数「Delkey」を削除する。
		unset($_SESSION["Delkey"]);
		header('location:./syainlist.php');
	}
	catch(PDOException $e){
		
		//DB切断
		$pdo = null;
		
		//エラーページに移動する
		//header('location:error.php');
		$code = $e->getcode();
		$message = $e->getMessage();
		print("{$code}/{$message},br/>");
	}
?>
