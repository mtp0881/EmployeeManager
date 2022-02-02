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
  $sql = "SELECT * FROM employee AS A INNER JOIN employee AS B ON A.manager INNER JOIN department AS C ON A.department = C.department_no = B.employee_no WHERE A.employee_no = :employee_no";
  
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
    <link rel="stylesheet" type="text/css" href="./css/emp_style.css" />
    <link rel="stylesheet" type="text/css" href="./css/employeedetail.css" />
    <title>データ検索・修正</title>
  </head>
  <body>
    <header>
      <div class="header-left">
        <a class="header-title" href="./index.php"><i class="fas fa-users-cog" style="margin-right: 16px;"></i>Master Management</a>
      </div>
      <div class="header-right">
        <div class="header-right-search">
          <div class="input">
            <input class="header-input" type="text" placeholder="ここに検索する">
            <a class="search-icon" href="#">
            <i class="fas fa-search"></i>
            </a>
          </div>
        </div>
        <div class="header-right-img">
          <img src="./images/image01.jpg" alt="">
        </div>
      </div>
    </header>
    <div class="body">
      <div class="body-left">
        <div class="body-left-place">
          <a href="./index.php">ホーム</a><span> / <a href="./syainlist.php">会員</a> / 詳細</span>
          <p>会員詳細情報</p>
        </div>
        <div class="body-left-profile">
          <div class="body-left-img">
            <img src="./images/<?=$face_image?>.jpg" alt="">
          </div>
          <p><?= $last_name ?> <?= $first_name ?></p>
          <!-- <p><?= date('Y年m月d日 H:i') ?></p> -->
          <p>example@example.com</p>
        </div>
        <div class="body-left-menu">
          <table>
            <tr class="first-tr">
              <td>
                <a href="./index.php">
                  <i class="fas fa-home"></i>
                  <p>ダッシュボード</p>
                </a>
              </td>
              <td>
                <a href="./syainlist.php">
                  <i class="fas fa-users"></i>
                  <p>社員</p>
                </a>
              </td>
            </tr>
            <tr>
              <td>
                <a href="#">
                  <i class="fas fa-building"></i>
                  <p>会社</p>
                </a>
              </td>
              <td>
                <a href="#">
                  <i class="fas fa-calendar-week"></i>
                  <p>カレンダー</p>
                </a>
              </td>
            </tr>
            <tr class="last-tr">
              <td>
                <a href="#">
                  <i class="fas fa-paste"></i>
                  <p>レポート</p>
                </a>
              </td>
              <td>
                <a href="#">
                  <i class="fas fa-cog"></i>
                  <p>設定</p>
                </a>
              </td>
            </tr>
          </table>
        </div>
      </div>
      <div class="body-right">
        <div class="body-right-option">
          <div class="option-item is-active"><a href="./personal.php?employee_no=<?= $employee_no ?>">詳細</a></div>
          <div class="option-item"><a href="#">部門</a></div>
          <div class="option-item"><a href="#">チーム</a></div>
          <div class="option-item"><a href="./clearCheck.php?employee_no=<?= $employee_no ?>">削除</a></div>
        </div>
        <div class="body-right-div">
          <form action="personal.php" method="GET" class="form">
            <div class="input-group mb-3 nonemargin">
              <input type="text" name="employee_no" class="form-control" placeholder="社員番号を入力してください">
              <div class="input-group-append">
                <button class="btn btn-warning" type="submit">検索</button>
              </div>
            </div>
          </form>
        </div>
        <div class="container-person">
          <h4><?= $title ?></h4>
          <div class="wraper">
            <div>
              <form action="update.php" method="POST">
                <table  class="employee_table">
                  <tbody>
                    <tr>
                      <th>社員番号</th>
                      <td colspan="3" class="form-control" readonly><?= $employee_no?><input type="hidden" name="employee_no" value="<?= $employee_no?>" /></td>
                    </tr>
                    <tr>
                      <th>名字(漢字)</th>
                      <td><input class="form-control" type="text" name="last_name" value="<?= $last_name?>"</td>
                      <th>名前(漢字)</th>
                      <td><input class="form-control" type="text" name="first_name" value="<?= $first_name?>"</td>
                    </tr>
                    <tr>
                      <th>名字(カナ)</th>
                      <td><input class="form-control" type="text" name="last_name_kana" value="<?= $last_name_kana?>"</td>
                      <th>名前(カナ)</th>
                      <td><input class="form-control" type="text" name="first_name_kana" value="<?= $first_name_kana?>"</td>
                    </tr>
                    <tr>
                      <th>性別</th>
                      <?php 
                        if ($gender == 1){ ?> 
                      <td>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="radio" id="radio1" value="1" checked>
                          <label class="form-check-label" for="radio1">
                          男
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="radio" id="radio2" value="2">
                          <label class="form-check-label" for="radio2">
                          女
                          </label>
                        </div>
                      </td>
                      <?php
                        }
                        else{ ?>
                      <td>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="radio" id="radio1" value="1" >
                          <label class="form-check-label" for="radio1">
                          男
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="radio" id="radio2" value="2" checked>
                          <label class="form-check-label" for="radio2">
                          女
                          </label>
                        </div>
                      </td>
                      <?php
                        }
                        ?>
                      <td colspan="2">　</td>
                    </tr>
                    <tr>
                      <th>入社年月日</th>
                      <td><input class="form-control" type="date" name="entrance_date" value="<?= $entrance_date?>"</td>
                      <th>給与</th>
                      <td><input class="form-control" type="text" name="salary" value="<?= $salary?>"</td>
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
                          		
                          print("<select id=\"select_manager\" name=\"manager\" class='form-control'>");
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
                      <td  class="form-control" readonly><?= $manager_name?></td>
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
                          		
                          print("<select id=\"select_department\" name=\"department\" class='form-control'>");
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
                      <td  class="form-control" readonly><?= $department_name?></td>
                    </tr>
                    <tr>
                      <th>写真</th>
                      <td><input class="form-control" type="text" name="face" value="<?= $face_image?>"</td>
                      <td colspan="2">　</td>
                    </tr>
                  </tbody>
                </table>
                <div class="create-btn-div">
                  <p>本当に修正しますか？</p>
                  <input type="submit" value="修正" class="btn btn-outline-primary">
                </div>
              </form>
              <div class="turn-back">
                <form action="syainlist.php">
                  <input type="submit" value="社員一覧へ" class="btn btn-outline-secondary"/>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>