<?php
  //ログインチェック
  include 'logincheck.php';
  $pageName = 'employee';
  
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
    <?php include "./common_library.php" ?>
    <title>社員情報登録</title>
  </head>
  <body>
    <?php include "./common_header.php" ?>
    <div class="body">
      <div class="body-left">
        <div class="body-left-place">
          <a href="./index.php">ホーム</a><span> / <a href="./syainlist.php">会員</a> / 登録</span>
          <p>社員情報登録</p>
        </div>
        <?php include "./common_body_left.php" ?>
      </div>
      <div class="body-right">
        <div class="container-person">
          <h4><?= $title ?></h4>
          <div class="wraper">
            <div>
              <form action="./insert.php" method="POST">
                <table  class="employee_table">
                  <tbody>
                    <tr>
                      <th>社員番号</th>
                      <td colspan="1" ><input type="text" name="employee_no" value="<?= $employee_no?>" class="form-control" required/></td>
                    </tr>
                    <tr>
                      <th>名字(漢字)</th>
                      <td><input class="form-control" type="text" name="last_name" value="<?= $last_name?>" required/></td>
                      <th>名前(漢字)</th>
                      <td><input class="form-control" type="text" name="first_name" value="<?= $first_name?>" required/></td>
                    </tr>
                    <tr>
                      <th>名字(カナ)</th>
                      <td><input class="form-control" type="text" name="last_name_kana" value="<?= $last_name_kana?>" required/></td>
                      <th>名前(カナ)</th>
                      <td><input class="form-control" type="text" name="first_name_kana" value="<?= $first_name_kana?>" required/></td>
                    </tr>
                    <tr>
                      <th>性別</th>
                      <td>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="radio" id="radio1" value="1" checked required/>
                          <label class="form-check-label" for="radio1">
                          男
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="radio" id="radio2" value="2" required/>
                          <label class="form-check-label" for="radio2">
                          女
                          </label>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <th>入社年月日</th>
                      <td><input class="form-control" type="date" name="entrance_date" value="<?= $entrance_date?>" /></td>
                      <th>給与</th>
                      <td><input class="form-control" type="text" name="salary" value="<?= $salary?>" /></td>
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
                    </tr>
                    <tr>
                      <th>写真</th>
                      <td><input class="form-control" type="text" name="face" value="<?= $face_image?>"/></td>
                      <td colspan="2">　</td>
                    </tr>
                  </tbody>
                </table>
                <div class="create-btn-div">
                  <p>本当に登録しますか？</p>
                  <input type="submit" value="登録" class="btn btn-outline-primary">
                </div>
              </form>
              <div class="turn-back">
                <form action="./employee_list.php">
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