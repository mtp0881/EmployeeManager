<?php
    //ログインチェック
	include 'logincheck.php';
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8" />
<link
      rel="stylesheet"
      href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
      integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p"
      crossorigin="anonymous"
    />
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="./employeelist.css" />

<title>EX28　yyJNccnn　社員データ一覧表</title>
</head>
<body>

<!------------    employees List Start       -------------->

<div class="container">
	<h1 class="title">社員データ一覧表</h1>
	<div class="wraper">
		<div class="employee-list">

		<?php
				try{
					//DB接続
					require_once('./DBInfo.php');
					$pdo = new PDO(DBInfo::DSN, DBInfo::USER, DBInfo::PASSWORD, array(PDO::ATTR_PERSISTENT => true));
					$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
								
					//参照系SQL
					$sql = "SELECT * FROM employee";
								
					//参照系SQLを発行
					$statement = $pdo->prepare($sql);
					$statement->execute();

					//データの取得
					$linecnt = 1;
					$linecolor;
					$fontcolor;

					while($row = $statement->fetchObject()){ ?>
						<div class="employee-list-item">
							<div class="employee-list-logo">
								<img src="images/<?= $row->face_image?>.jpg" alt="" />
							</div>
							<h3 class="employee-list-title"><?= $row->last_name?> <?= $row->first_name?></h3>
							<div class="employee-list-detail">
								SampleEmail@gmail.com
							</div>
							<div class="employee-list-tag">
								<div class="tag-item">Full Time</div>
								<div class="tag-item">Min 1 Year</div>
								<div class="tag-item"><?= $row->department?></div>
							</div>
							<div class="employee-list-friends">
								<div class="friends-item">
									<img src="images/image01.jpg" alt="" />
								</div>
								<div class="friends-item">
									<img src="images/image02.jpg" alt="" />
								</div>
								<div class="friends-item">
									<img src="images/image03.jpg" alt="" />
								</div>
								<div class="friends-item">+2</div>
								<div class="friends-count">5 Friends Work here</div>
							</div>
							<div class="employee-list-action">
								<a class="action-button action-button--blue btn btn-primary" href='personal.php?employee_no=<?= $row->employee_no?>'>
									詳細
								</a>
								<a class="action-button action-button--gray btn btn-secondary" href='sakujyo.php?employee_no=<?= $row->employee_no?>'>
									削除
								</a>
							</div>
						</div>
					<?php
				}
				//DB切断
				$pdo = null;

			} catch(PDOException $e){
				//DB切断
				$pdo = null;
							
				//エラーページに移動する
				header('location:error.php');
			}
		?>
		</div>
	</div>
</div>
<!------------    employees List End        -------------->

		<form action="./toroku.php" method="GET">
			<div class="form-group create-from">
				<button type="submit" class="btn btn-warning center ">新規登録</button>
			</div>
		</form>

</body>
</html>
