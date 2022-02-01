<?php
    //ログインチェック
	include 'logincheck.php';
	date_default_timezone_set ('Asia/Tokyo');

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

				//DB切断
			$pdo = null;

	} catch(PDOException $e){
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
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous">
<link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@500;600&family=Noto+Serif+JP:wght@500&display=swap" rel="stylesheet">
<link
      rel="stylesheet"
      href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
      integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p"
      crossorigin="anonymous"
    />
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="./css/employeelist.css" />
<link rel="stylesheet" type="text/css" href="./css/dashboard.css" />
<link rel="stylesheet" type="text/css" href="./css/employeedetail.css" />


<title>社員データ一覧</title>
</head>
<body>
<header>
    <div class="header-left">
      <a class="header-title" href="./index.php">Master Management</a>
    </div>
    <div class="header-right">
      <div class="header-right-search">
        <input class="header-input" type="text" placeholder="ここに検索する">
      </div>
      <div class="header-right-img">
        <img src="./images/image01.jpg" alt="">
      </div>
    </div>
  </header>
  <div class="body">
    <div class="body-left">
      <div class="body-left-place">
        <a href="./index.php">ホーム</a><span> / ダッシュボード</span>
        <p>ダッシュボード管理</p>
      </div>
      <!-- <div class="body-left-profile">
        <div class="body-left-img">
          <img src="./images/image01.jpg" alt="">
        </div>
        <p>おかえりなさい</p>
        <p><?= date('Y年m月d日 H:i') ?></p>
      </div> -->
      <div class="body-left-menu">
        <div class="menu-wrap row">
          <div class="col-6 menu-item">
							<a href="./index.php">
								<span><i class="fas fa-home"></i></span>
								<span>ダッシュボード</span>
							</a>
					</div>
          <div class="col-6 menu-item">
							<a href="./syainlist.php">
								<span><i class="fas fa-users"></i></span>
								<span>社員</span>
							</a>
					</div>
          <div class="col-6 menu-item">
							<a href="#">
								<span><i class="fas fa-building"></i></span>
								<span>会社</span>
							</a>
					</div>
          <div class="col-6 menu-item">
							<a href="#">
								<span><i class="fas fa-calendar-week"></i></span>
								<span>カレンダー</span>
							</a>
					</div>
          <div class="col-6 menu-item">
							<a href="#">
								<span><i class="fas fa-paste"></i></span>
								<span>レポート</span>
							</a>
					</div>
          <div class="col-6 menu-item">
							<a href="#">
								<span><i class="fas fa-cog"></i></span>
								<span>設定</span>
							</a>
					</div>
        </div>
      </div>
    </div>
    <div class="body-right">
			<ul class="body-right-option">
				<li href="#" class=""><a href="#">全部</a></li>
				<li href="#" class=""><a href="#">チーム</a></li>
				<li href="#" class=""><a href="#">オフィス</a></li>
			</ul>
			<div class="body-right-create">
				<div class="create-left">
					<p><?= $statement->rowCount() ?> 社員</p>
				</div>
				<div class="create-right">
					<form action="./toroku.php" method="GET">
						<div class="form-group create-from">
							<button type="submit" class="btn btn-warning ">新規登録</button>
						</div>
					</form>
				</div>
			</div>
		<div class="container">
	<div class="wraper">
		<div class="employee-list">
		<?php while($row = $statement->fetchObject()){ ?>
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
								<a class="btn btn-outline-primary form-control" href='personal.php?employee_no=<?= $row->employee_no?>'>
									詳細
								</a>
								<!-- <a class="action-button action-button--gray btn btn-secondary" href='sakujyo.php?employee_no=<?= $row->employee_no?>'>
									削除
								</a> -->
							</div>
						</div>
					<?php
				} ?>
		</div>
	</div>
</div>
    </div>
  </div>
</body>
</html>
