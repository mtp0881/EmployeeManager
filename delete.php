<?php
	include 'logincheck.php';

	session_start();
	session_regenerate_id(TRUE);

	if(isset($_GET['employee_no'])== TRUE && $_GET['employee_no'] != '' && isset($_GET['compareCode'])== TRUE && $_GET['compareCode'] != '' && $_GET['employee_no'] == $_GET['compareCode']){

		try{
		
			require_once('./DBInfo.php');
			$pdo = new PDO(DBInfo::DSN, DBInfo::USER, DBInfo::PASSWORD, array(PDO::ATTR_PERSISTENT => true));
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			$sql = "SELECT * FROM employee WHERE employee_no = :employee_no";

			$sqlDelete = "DELETE FROM employee WHERE employee_no = :employee_no";
	
			//参照系SQLを発行
			$statement = $pdo->prepare($sql);
			$delete = $pdo->prepare($sqlDelete);
	
			$statement->bindValue(":employee_no", $_GET['employee_no'],PDO::PARAM_INT);
			$delete->bindValue(":employee_no", $_GET['employee_no'],PDO::PARAM_INT);

			$statement->execute();
			if($statement->fetchObject()){
				
				$delete->execute();

			} else{
				$_SESSION["error"] = "エラーがあります";
			}
			
			$pdo = null;
	
			header('location:./employee_list.php');
		}
		catch(PDOException $e){
	
			$pdo = null;
	
			header('location:./employee_list.php');
		}

	}
	
	else{
		
		$_SESSION["error"] = "パスワードに誤りがあります";

		header('location:./clearCheck.php?employee_no='.$_GET['employee_no']);
	}
	
?>