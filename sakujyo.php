<?php
    //ログインチェック
	include 'logincheck.php';
	$title = "社員情報削除";

	//パラメータの取得
	if(isset($_GET['employee_no'])== TRUE && $_GET['employee_no'] != ''){
		$Delkey =$_GET['employee_no'];
		$_SESSION["Delkey"] = $Delkey;
	}
	
	else{
		header('location:./syainlist.php');
	}
	
	try{
		
		//DB接続
		require_once('./DBInfo.php');
		$pdo = new PDO(DBInfo::DSN, DBInfo::USER, DBInfo::PASSWORD, array(PDO::ATTR_PERSISTENT => true));
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		//参照系SQL
		$sql = "SELECT * FROM employee AS A INNER JOIN employee AS B ON A.manager INNER JOIN department AS C ON A.department = C.department_no = B.employee_no WHERE A.employee_no = :employee_no GROUP BY A.manager";

		//参照系SQLを発行
		$statement = $pdo->prepare($sql);

		$statement->bindValue(":employee_no", $Delkey);

		$statement->execute();
		
		//データの取得
		if($row = $statement->fetch()){
			$employee_no     = $row[0];
			$last_name       = $row[1];
			$first_name      = $row[2];
			$last_name_kana  = $row[3];
			$first_name_kana = $row[4];
			$gender          = $row[5];
			$entrance_date   = $row[6];
			$salary          = $row[7];
			$manager         = $row[8];
			$department      = $row[9];
			$face_image      = $row[10];			
			$manager_name    = $row[13].$row[14];
			$department_name = $row[23];
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
		header('location:./syainlist.php');
	}
	
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8" />
<link rel="stylesheet" type="text/css" href="./emp_style.css" />
<title>EX28　yyJNccnn　社員データ削除</title>
</head>
<body>
	<div id="list">
	<h3 style="margin-left:90px;"><?php print($title); ?></h3>
	<form action="delete.php" method="POST">
	<?php print("<img src=\"/EX/EX28/images/$face_image.bmp\" >"); ?>
	<table border="1">
	<tbody>
		<tr>
			<th>社員番号</th>
			<td><?php print($employee_no); ?></td>
			<input type="hidden" name="employee_no" value="<?php print($employee_no); ?>" />
		</tr>
		<tr>
			<th>名字(漢字)</th>
			<td><?= $last_name?></td>
		</tr>
		<tr>
			<th>名前(漢字)</th>
			<td><?= $first_name?></td>
		</tr>
		<tr>
			<th>名字(カナ)</th>
			<td><?= $last_name_kana?></td>
		</tr>
		<tr>
			<th>名前(カナ)</th>
			<td><?= $first_name_kana?></td>
		</tr>
		<tr>
			<th>性別</th>
			<?php 
			if ($gender == 1){
				print"<td>男</td>";
			}
			else{
				print"<td>女</td>";
			}
			?>
			</tr>
		<tr>
			<th>入社年月日</th>
			<td><?= $entrance_date?></td>
		</tr>
		<tr>
			<th>給与</th>
			<td><?= $salary?></td>
		</tr>
		<tr>
			<th>上司名</th>
			<td><?= $manager_name?></td>
		</tr>
		<tr>
			<th>所属名</th>
			<td><?= $department_name?></td>
		</tr>
		<tr>
			<th>写真</th>
			<td><?= $face_image?></td>
		</tr>
	</tbody>
	</table>
	<p>本当に削除しますか？</p>
	<input type="submit" value="削除">
	</form>
	<form action="./syainlist.php">
		<input type="submit" value="社員一覧へ" />
	</form>
	</div>
</body>
</html>
