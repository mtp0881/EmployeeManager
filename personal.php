<?php
    //ログインチェック
	include 'logincheck.php';
	//パラメータの取得
	if(isset($_GET['employee_no'])== TRUE && $_GET['employee_no'] != ''){
		$key =$_GET['employee_no'];
	}
	else{
        header('location:syainlist.php');
	}
	//表示用変数
	$title = '社員情報修正';
	$employee_no = '';
	$last_name = '';
	$first_name = '';
	$last_name_kana = '';
	$first_name_kana = '';
	$gender = '';
	$entrance_date = '';
	$salary = '';
	$manager = '';
	$manager_name = '';
	$department = '';
	$department_name = '';
	$face_image = '';
	
	try{
		
		//DB接続
		require_once('./DBInfo.php');
		$pdo = new PDO(DBInfo::DSN, DBInfo::USER, DBInfo::PASSWORD, array(PDO::ATTR_PERSISTENT => true));
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		//参照系SQL
		$sql = "SELECT * FROM employee AS A INNER JOIN employee AS B ON A.manager INNER JOIN department AS C ON A.department = C.department_no = B.employee_no WHERE A.employee_no = :employee_no GROUP BY A.manager";

		//参照系SQLを発行
		$statement = $pdo->prepare($sql);

		$statement->bindValue(":employee_no", $key);

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
		
		//エラーページに移動する
		header('location:error.php');
	}
	
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8" />
<link rel="stylesheet" type="text/css" href="./emp_style.css" />
<title>EX28　yyJNccnn　データ検索・修正</title>
</head>
<body>
    <div id="list">
	<form action="personal.php" method="GET">
		社員番号:
		<input type="text" name="employee_no" />
		<input type="submit" value="検索" />
	</form>
	</div>
    <div id="list">
    <h3><?= $title ?></h3>
	<form action="update.php" method="POST">
		<?php print("<img src=\"/EX/EX28/images/$face_image.bmp\" style=                            >"); ?>
		<table border="1">
			<tbody>
				<tr>
					<th>社員番号</th>
					<td><?= $employee_no?></td>
					<td colspan="2"><input type="hidden" name="employee_no" value="<?= $employee_no?>" /></td>
				</tr>
				<tr>
					<th>名字(漢字)</th>
					<td><input type="text" name="last_name" value="<?= $last_name?>"</td>
					<th>名前(漢字)</th>
					<td><input type="text" name="first_name" value="<?= $first_name?>"</td>
				</tr>
				<tr>
					<th>名字(カナ)</th>
					<td><input type="text" name="last_name_kana" value="<?= $last_name_kana?>"</td>
					<th>名前(カナ)</th>
					<td><input type="text" name="first_name_kana" value="<?= $first_name_kana?>"</td>
				</tr>
				<tr>
					<th>性別</th>
					<?php 
					if ($gender == 1){
						print"<td>";
						print"<label for=\"radio1\">男</label>";
						print"<input type=radio id=\"radio1\" name=\"radio\" value=\"1\" tabindex=\"5\" checked/>";
						print"<label for=\"radio2\">女</label>";
						print"<input type=radio id=\"radio2\" name=\"radio\" value=\"2\" tabindex=\"6\" />";
						print"</td>";
						}
					else{
						print"<td>";
						print"<label for=\"radio1\">男</label>";
						print"<input type=radio id=\"radio1\" name=\"radio\" value=\"1\" tabindex=\"5\" />";
						print"<label for=\"radio2\">女</label>";
						print"<input type=radio id=\"radio2\" name=\"radio\" value=\"2\" tabindex=\"6\" checked/>";
						print"</td>";
					}
					?>
					<td colspan="2">　</td>
				</tr>
				<tr>
					<th>入社年月日</th>
					<td><input type="text" name="entrance_date" value="<?= $entrance_date?>"</td>
					<th>給与</th>
					<td><input type="text" name="salary" value="<?= $salary?>"</td>
				</tr>
				<tr>
					<th>上司</th>
					<td>
					<?php
					//DB接続
					require_once('./DBInfo.php');
					$pdo = new PDO(DBInfo::DSN, DBInfo::USER, DBInfo::PASSWORD, array(PDO::ATTR_PERSISTENT => true));
					$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
							
					// 参照系SQL
					$sql = "SELECT M.manager, CONCAT(E.last_name, E.first_name) AS manager_name FROM employee AS M INNER JOIN employee AS E ON M.manager = E.employee_no WHERE M.manager GROUP BY M.manager";
							
					// 参照系SQLを発行
					$statement = $pdo->prepare($sql);
					$statement->execute();
							
					print("<select id=\"select_manager\" name=\"manager\">");
					//データの取得
					while($row = $statement->fetchObject()){
						if ($row->manager == $manager){
							print("<option value=\"{$row->manager}\" selected>{$row->manager_name}</option>");
						}
						else{
							print("<option value=\"{$row->manager}\" >{$row->manager_name}</option>");
						}
					}
					//DB切断
					$pdo = null;
					?>
					</select>
				</td>
					<th>上司名</th>
					<td><?= $manager_name?></td>
				</tr>
				<tr>
					<th>所属</th>
					<td>
					<?php
					//DB接続
					require_once('./DBInfo.php');
					$pdo = new PDO(DBInfo::DSN, DBInfo::USER, DBInfo::PASSWORD, array(PDO::ATTR_PERSISTENT => true));
					$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
							
					//参照系SQL
					$sql = "SELECT * FROM department";
							
					//参照系SQLを発行
					$statement = $pdo->prepare($sql);
					$statement->execute();
							
					print("<select id=\"select_department\" name=\"department\">");
					//データの取得
					while($row = $statement->fetchObject()){
						if ($row->department_no == $department){
							print("<option value=\"{$row->department_no}\" selected>{$row->department_name}</option>");
						}
						else{
							print("<option value=\"{$row->department_no}\">{$row->department_name}</option>");
						}
					}
					//DB切断
					$pdo = null;
					?>
				</select>
				</td>
					<th>所属名</th>
					<td><?= $department_name?></td>
				</tr>
				<tr>
					<th>写真</th>
					<td><input type="text" name="face" value="<?= $face_image?>"</td>
					<td colspan="2">　</td>
				</tr>
			</tbody>
		</table>
		<p>本当に修正しますか？</p>
		<input type="submit" value="修正">
	</form>
	<form action="syainlist.php">
	<input type="submit" value="社員一覧へ" />
	</form>
	</div>
</body>
</html>
