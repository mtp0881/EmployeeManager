<?php
    //ログインチェック
	include 'logincheck.php';
	date_default_timezone_set ('Asia/Tokyo');
  $pageName = 'employee';
  $pageName_bar = 'dashboard-color';

  $limitEnd = 9;

  if(isset($_GET['limitStart']) == TRUE &&  $_GET['limitStart'] != ''){
    $limitStart =$_GET['limitStart'];
  }
  else{
    $limitStart = 0;
  }

	try{
			//DB接続
			require_once('./DBInfo.php');
			$pdo = new PDO(DBInfo::DSN, DBInfo::USER, DBInfo::PASSWORD, array(PDO::ATTR_PERSISTENT => true));
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $sqlSelectAll = "SELECT employee_no FROM employee";
      $statementAll = $pdo->prepare($sqlSelectAll);
			$statementAll->execute();
						

			//参照系SQL
			$sql = "SELECT * FROM employee LEFT JOIN department ON employee.department = department.department_no ORDER BY department.department_no LIMIT :limitStart,:limitEnd";

						
			//参照系SQLを発行
			$statement = $pdo->prepare($sql);

      $statement->bindValue(":limitStart", $limitStart,PDO::PARAM_INT);
      $statement->bindValue(":limitEnd", $limitEnd,PDO::PARAM_INT);

			$statement->execute();

				//DB切断
			$pdo = null;

	} catch(PDOException $e){
		//DB切断
		$pdo = null;
					
		//エラーページに移動する
		header('location:error.php');
	}

  $rowCount = $statementAll->rowCount();
  $cnt = 0;
  $i = 0;

  for($i = 0; $i < $rowCount; $i++){
    if($i % 9 == 0){
      $arr[$cnt] = $i;
      $cnt++;
    }
  }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8" />
<?php include "./common_library.php" ?>
<title>社員データ一覧</title>
</head>
<body>
<?php include "./common_header.php" ?>
  <div class="body">
    <div class="body-left">
      <div class="body-left-place">
        <a href="./index.php">ホーム</a><span> / 会員</span>
        <p>会員管理</p>
      </div>
      <?php include "./common_body_left.php" ?>
    </div>
    <div class="body-right">
      <div class="body-right-option">
        <div class="option-item <?php if ($pageName_bar == 'dashboard-color'){ echo "dashboard-color"; }?>"><a href="./employee_list.php">ダッシュボード</a></div>
        <div class="option-item"><a href="#">部門</a></div>
        <div class="option-item"><a href="#">チーム</a></div>
      </div>
			<div class="body-right-create">
				<div class="create-left">
					<p><?= $statementAll->rowCount() ?> 社員が在職しています</p>
				</div>
				<div class="create-right">
					<form action="./toroku.php" method="GET">
						<div class="form-group create-from">
							<button type="submit" class="btn btn-warning ">新規登録</button>
						</div>
					</form>
				</div>
			</div>
      
		<div class="container-option">
        <form action="personal.php" method="GET" class="form form2">
                <div class="input-group mb-3 nonemargin">
                  <input type="text" name="employee_no" class="form-control" placeholder="社員番号を入力してください">
                  <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">社員検索</button>
                  </div>
                </div>
              </form>
        <div class="wraper">
          <div class="employee-list">
          <?php while($row = $statement->fetchObject()){ 
            
            $date1 = new DateTime("NOW");
            $date2 = new DateTime($row->entrance_date);
            
            $interval = $date1->diff($date2);
            
            if($interval->y < 1){
              $hireToNow = '在職'.$interval->y.'年以下';
            } else{
              $hireToNow = '在職'.$interval->y.'年以上';
            }
            ?>
                  <div class="employee-list-item">
                    <div class="employee-list-logo">
                      <img src="images/<?= $row->face_image?>.jpg" alt="" />
                    </div>
                    <h3 class="employee-list-title"><?= $row->last_name?> <?= $row->first_name?></h3>
                    <div class="employee-list-detail">
                      sampleEmail@gmail.com
                    </div>
                    <div class="employee-list-tag">
                      <div class="tag-item"><?= $row->department_name?></div>
                      <div class="tag-item"><?= $hireToNow?></div>
                      <!-- <div class="tag-item"><?= $row->department?></div> -->
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
                      <div class="friends-count">5チーム共同</div>
                    </div>
                    <div class="employee-list-action">
                      <a class="btn btn-outline-primary form-control" href='personal.php?employee_no=<?= $row->employee_no?>'>
                        詳細
                      </a>
                    </div>
                  </div>
                <?php
              } ?>
              <div class="paginate-btn">
                <nav aria-label="Page navigation example">
                  <ul class="pagination justify-content-end">
                    <li class="page-item disabled">
                      <a class="page-link" href="#" tabindex="-1">前のページ</a>
                    </li>
                    <?php 
                      $cnt = 1;
                      if(isset($_GET['state']) != TRUE){
                        $_GET['state'] = 1;
                      }
                      foreach($arr as $value){
                        if($_GET['state'] == $cnt){
                          ?>
                          <li class="page-item state"><a class="page-link" href="./employee_list.php?state=<?= $cnt ?>&limitStart=<?= $value ?>"><?= $cnt ?></a></li>
                          <?php
                        } else {
                        ?>
                          <li class="page-item"><a class="page-link" href="./employee_list.php?state=<?= $cnt ?>&limitStart=<?= $value ?>"><?= $cnt ?></a></li>
                        <?php }
                          $cnt++;
                      }
                    ?>
                    <li class="page-item disabled" >
                      <a class="page-link" href="#">次ぎ</a>
                    </li>
                  </ul>
                </nav>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
