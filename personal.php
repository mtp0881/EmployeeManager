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
               <a href="./index.php">ホーム</a><span> / プロファイル</span>
               <p>プロファイル管理</p>
            </div>
            <div class="body-left-profile">
               <div class="body-left-img">
                  <img src="./images/<?=$face_image?>.jpg" alt="">
               </div>
							 <p class="user-name"><?=$last_name?> <?=$first_name?></p>
               <p><?= date('Y年m月d日 H:i') ?></p>
            </div>
            <div class="body-left-menu">
               <div class="menu-wrap row">
                  <div class="col-6 menu-item">
                     <a href="#">
                     <span><i class="fas fa-home"></i></span>
                     <span>ダッシュボード</span>
                     </a>
                  </div>
                  <div class="col-6 menu-item">
                     <a href="#">
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
               <li href="#" class=""><a href="#">詳細</a></li>
               <li href="#" class=""><a href="#">資料</a></li>
               <li href="#" class=""><a href="#">設定</a></li>
            </ul>
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
            <div class="container">
               <div class="wraper">
                  <div>
                     <p><?= $title ?></p>
                     <form action="update.php" method="POST">
                        <table border="1">
                           <tbody>
                              <tr>
                                 <th>社員番号</th>
                                 <td colspan="3"><?= $employee_no?><input type="hidden" name="employee_no" value="<?= $employee_no?>" /></td>
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
                        <input type="submit" value="修正" class="btn btn-outline-primary">
                     </form>
                     <form action="syainlist.php">
                        <input type="submit" value="社員一覧へ" class="btn btn-outline-secondary"/>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </body>
</html>