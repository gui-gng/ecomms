<?PHP 
  require('app-lib.php');

  isset($_POST['uid'])? $uid = $_POST['uid'] : $uid = "";
  if(!$uid) {
    isset($_REQUEST['uid'])? $uid = $_REQUEST['uid'] : $uid = "";
  }

  isset($_POST['a'])? $action = $_POST['a'] : $action = "";
  if(!$action) {
    isset($_REQUEST['a'])? $action = $_REQUEST['a'] : $action = "";
  }

  isset($_POST['txtSearch'])? $txtSearch = $_POST['txtSearch'] : $txtSearch = "";
  if(!$txtSearch) {
    isset($_REQUEST['txtSearch'])? $txtSearch = $_REQUEST['txtSearch'] : $txtSearch = "";
  }

  if($action == "Delete") {
    $query =
      "UPDATE lpa_users SET
         lpa_user_status = 0
       WHERE
         lpa_user_ID = $uid LIMIT 1
      ";
    openDB();
    $result = $db->query($query);
    if($db->error) {
      printf("Errormessage: %s\n", $db->error);
      exit;
    } else {
      header("Location: users.php?txtSearch=$userUsername&a=listUser");
      exit;
    }
  }
  isset($_POST['txtUserID'])?    $userID =        $_POST['txtUserID'] :    $userID = "";
  isset($_POST['txtFirstName'])? $userFirstName = $_POST['txtFirstName'] : $userFirstName = "";
  isset($_POST['txtLastName'])?  $userLastName =  $_POST['txtLastName'] :  $userLastName = "";
  isset($_POST['txtUsername'])?  $userUsername =  $_POST['txtUsername'] :  $userUsername = "";
  isset($_POST['txtPassword'])?  $userPassword =  crypt($_POST['txtPassword'], '$2a$07$cti2017387guilhermenazareth$') :  $userPassword  = "";
  isset($_POST['txtGroup'])?  $userGroup =  $_POST['txtGroup'] :  $userGroup  = "";
  isset($_POST['txtStatus'])?    $userStatus =    $_POST['txtStatus'] :    $userStatus = "1";
  


  $mode = "insertRec";
  if($action == "updateRec") {

    $query =
      "UPDATE lpa_users SET
        lpa_user_username = '$userUsername',
        lpa_user_password = '$userPassword',
        lpa_user_firstname = '$userFirstName',
        lpa_user_lastname = '$userLastName',
        lpa_user_group = '$userGroup',
        lpa_user_status = '$userStatus'
       WHERE
         lpa_user_ID = $userID LIMIT 1
      ";
     openDB();
     $result = $db->query($query);
     if($db->error) {
       printf("Errormessage: %s\n", $db->error);
       print($query);

       foreach ($_POST as $param_name => $param_val) {
          echo "<br />Param: $param_name; Value: $param_val\n";
      }
       exit;
     } else {
         header("Location: users.php?txtSearch=$userUsername&a=listUser");
       exit;
     }
  }
 

  if($action == "insertRec") {
    $query =
      "INSERT INTO lpa_users (
      
        lpa_user_username,
        lpa_user_password,
        lpa_user_firstname,
        lpa_user_lastname,
        lpa_user_group,
        lpa_user_status
       ) VALUES (
        '$userUsername',
        '$userPassword',
        '$userFirstName',
        '$userLastName',
        '$userGroup',
        '$userStatus'
       )
      ";
    openDB();
    $result = $db->query($query);
    if($db->error) {
      printf("Errormessage: %s\n", $db->error);
      printf($query);
      exit;
    } else {
      header("Location: users.php?txtSearch=$userUsername&a=listUser");
      exit;
    }
  }

 //printf("<script>alert('$action')</script>");
if($action == "Edit") {
  openDB();
    $query = "SELECT * FROM lpa_users  WHERE lpa_user_ID = '$uid' LIMIT 1";
    $result = $db->query($query);
    $row_cnt = $result->num_rows;
    $row = $result->fetch_assoc();

    $userID         = $row['lpa_user_ID'];
    $userUsername   = $row['lpa_user_username'];
    $userPassword   = $row['lpa_user_password'];
    $userFirstName  = $row['lpa_user_firstname'];
    $userLastName   = $row['lpa_user_lastname'];
    $userGroup      = $row['lpa_user_group'];
    $userStatus     = $row['lpa_user_status'];
      
    $mode = "updateRec";
  }


  build_header();
?>
  <?PHP build_navBlock(); ?>
  <div id="content">
    <div class="sectionHeader">New Customer Registration</div>

    <form name="frmUserRec" id="frmUserRec" method="post" action="<?PHP echo $_SERVER['PHP_SELF']; ?>">

        <div class="displayPane">
          <label><strong>ID</strong></label>
          <input name="txtUserIDshow" id="txtUserIDshow" value="<?PHP echo $userID; ?>" disabled>
        </div>
        <br/>

        <div class="displayPane">
          <label><strong>First Name</strong></label>
          <input name="txtFirstName" id="txtFirstName" value="<?PHP echo $userFirstName; ?>" />
        </div>
        <br />
        <div class="displayPane">
          <label><strong>Last Name</strong></label>
          <input name="txtLastName" id="txtLastName" value="<?PHP echo $userLastName; ?>" />
        </div>
        <br />

        <div class="displayPane">
          <label><strong>Username</strong></label>
          <input name="txtUsername" id="txtUsername" value="<?PHP echo $userUsername; ?>" />
        </div>
        <br />

        <div class="displayPane">
          <label><strong>Password</strong></label>
          <input name="txtPassword" id="txtPassword" value="<?PHP echo $userPassword; ?>" />
        </div>

        <div class="displayPane">
          <br/>
          <label><strong>Group</strong></label>
          <select name="txtGroup" id="txtGroup">
            <option value="administrator" <?PHP if($userGroup == "administrator"){echo "selected";} ?> >Administrator</option>
            <option value="user" <?PHP if($userGroup == "user"){echo "selected";} ?> >user</option>
          </select>
        </div>
        

        <br />
        <input name="a" id="a" value="<?PHP echo $mode; ?>" type="hidden">  
        <input name="txtUserID" id="txtUserID" value="<?PHP echo $userID; ?>" type="hidden">

    </form>

    <div class="optBar">
      <button type="button" id="btnUserSave">Save</button>
      <button type="button" onclick="navMan('users.php')">Close</button>
    </div>
  </div>



<script>
    $("#btnUserSave").click(function(){
        $("#frmUserRec").submit();
    });

  </script>

<?PHP
build_footer();
?>