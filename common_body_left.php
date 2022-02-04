<div class="body-left-menu">
  <table>
    <tr class="first-tr">
      <td <?php if ($pageName == 'index'){
        echo "class='active'";
        }?>>
        <a href="./index.php">
          <i class="fas fa-home"></i>
          <p>ホーム</p>
        </a>
      </td>
      <td <?php if ($pageName == 'employee'){
        echo "class='active'";
        }?>>
        <a href="./employee_list.php">
          <i class="fas fa-users"></i>
          <p>社員</p>
        </a>
      </td>
    </tr>
    <tr>
      <td <?php if ($pageName == 'company'){
        echo "class='active'";
        }?>>
        <a href="./company.php">
          <i class="fas fa-building"></i>
          <p>会社</p>
        </a>
      </td>
      <td <?php if ($pageName == 'calendar'){
        echo "class='active'";
        }?>>
        <a href="./calendar.php">
          <i class="fas fa-calendar-week"></i>
          <p>カレンダー</p>
        </a>
      </td>
    </tr>
    <tr class="last-tr">
      <td <?php if ($pageName == 'report'){
        echo "class='active'";
        }?>>
        <a href="./report.php">
          <i class="fas fa-paste"></i>
          <p>レポート</p>
        </a>
      </td>
      <td <?php if ($pageName == 'setting'){
        echo "class='active'";
        }?>>
        <a href="./setting.php">
          <i class="fas fa-cog"></i>
          <p>設定</p>
        </a>
      </td>
    </tr>
  </table>
</div>