<?PHP 
  require('app-lib.php');
  isset($_POST['a'])? $action = $_POST['a'] : $action = "";
  $msg = null;
  if($action == "doLogin") {

    isset($_POST['fldUsername'])? $uName = $_POST['fldUsername'] : $uName = "";
    isset($_POST['fldPassword'])? $uPassword = crypt($_POST['fldPassword'], '$2a$07$cti2017387guilhermenazareth$') : $uPassword = "";


    
    openDB();
    $query = "SELECT * FROM lpa_users 
      WHERE lpa_user_username = '$uName' 
      AND lpa_user_password = '$uPassword' ";
    $result = $db->query($query);

    $row = $result->fetch_assoc();
    
    $msg = "Login failed! Please try again.";

    if($row['lpa_user_username'] == $uName AND $row['lpa_user_password'] == $uPassword) {
      $_SESSION['authUser'] = $row['lpa_user_ID'];
      $_SESSION['isAdmin'] = (($row['lpa_user_group']=="administrator")?true:false);
      header("Location: index.php");
      exit;
    }
    else
    {
      $msg = "Login failed! Please try again.";
    }

    /*
    if($uName == "user") {
      //LOGIC SEARCH IN DATABASE
      if($uPassword == "open123") {
        header("location: index.php");
        exit;
      }
    }
    $msg = "Login failed! Please try again.";
    */
  }
 build_header();
?>
  <div id="contentLogin">
    <form name="frmLogin" id="frmLogin" method="post" action="login.php">
      <div id="loginFrame">
        <div class="msgTitle">Please supply your login details:</div>

        <div>Username:</div>
        <input type="text" name="fldUsername" id="fldUsername" placeholder="Username">

        <div>Password:</div>
        <input type="password" name="fldPassword" id="fldPassword" placeholder="Password">

        <div class="buttonBar">
          <button type="button" onclick="do_login()">Login</button>
        </div>

      </div>
      <input type="hidden" name="a" value="doLogin">
    </form>

 </div>
<script>
  var msg = "<?PHP  echo $msg; ?>";
  if(msg) {
    alert(msg);
  }

  $("#frmLogin").keypress(function(e){
    if(e.which == 13) {
      $(this).submit();
    }
  })
</script>
<?PHP
build_footer();
?>