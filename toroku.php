<?php
    //ログインチェック
	include 'logincheck.php';
	//表示用変数
	$title = '社員情報登録';
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
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8" />
<link rel="stylesheet" type="text/css" href="./emp_style.css" />
<title>社員情報登録</title>
</head>
<body>
	<div id="detail">
    <h3 style="margin-left:90px;"><?= $title ?></h3>
	<form action="./insert.php" method="POST">
		<table border="1">
		<tbody>
		<tr>
			<th>社員番号</th>
			<td><input type="text" name="employee_no" value="<?= $employee_no?>"/></td>
            <td></td>
            <td></td>
		</tr>
		<tr>
			<th>名字(漢字)</th>
			<td><input type="text" name="last_name" value="<?= $last_name ?>"/></td>
			<th>名前(漢字)</th>
			<td><input type="text" name="first_name" value="<?= $first_name ?>"/></td>
		</tr>
		<tr>
			<th>名字(カナ)</th>
			<td><input type="text" name="last_name_kana" value="<?= $last_name_kana ?>"/></td>
			<th>名前(カナ)</th>
			<td><input type="text" name="first_name_kana" value="<?= $first_name_kana ?>"/></td>
		</tr>
		<tr>
			<th>性別</th>
			<td>
				<label for="radio1">男</label>
				<input type="radio" id="radio1" name="radio" value="1" tabindex="5" checked/>
				<label for="radio2">女</label>
				<input type="radio" id="radio2" name="radio" value="2" tabindex="6" />
			</td>
			<td></td>
            <td></td>
		</tr>
		<tr>
			<th>入社年月日</th>
			<td><input type="text" name="entrance_date" value="<?= $entrance_date ?>"/></td>
			<th>給与</th>
			<td><input type="text" name="salary" value="<?= $salary ?>"></td>
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
					if ($row->manager == 1){
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
		</tr>
		<tr>
			<th>写真</th>
			<td><input type="text" name="face" value="<?= $face_image ?>"/></td>
            <td></td>
            <td></td>
		</tr>
		</tbody>
		</table>
		<p>本当に登録しますか？</p>
		<input type="submit" value="登録">
	</form>
	<form action="./syainlist.php">
		<input type="submit" value="社員一覧へ" />
	</form>
	</div>
</body>
</html>
