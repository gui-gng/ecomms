<?PHP
  $authChk = true;
  require('app-lib.php');

  build_header($displayName);
?>
  <?PHP build_navBlock(); ?>
  <div id="content">
    <div class="PageTitle">Help Guide</div>
    <p>This is a eCommerce website store, developed as requested on assessment of the unit ICT50715 of the Diploma of Software Development in CTI, done by <strong>Guilherme Nazareth Gonçalves</strong></p>
    <p>In this web page you can see a <strong>MAIN MENU</strong>, which have the <strong>HOME</strong>, <strong>STOCK</strong>, <strong>SALES</strong>, <strong>HELP</strong> and <strong>Logout</strong> buttons, if you are a administrator you have the <strong>USERS</strong> button as well.</p>
    <div>
      <strong>USERS:</strong><br />
      <p>A normal user has access to login and search in the web store.</p>
      <ul>
        <li><strong>HOME:</strong> Just a empty page.</li>
        <li><strong>STOCK:</strong> Show the item list in stock with the respective details</li>
        <li><strong>HELP:</strong> Help about the web store</li>
        <li><strong>Logout:</strong> Button for logout from your account.</li>
      </ul>
    </div>
    <div>
      <strong>ADMINISTRATOR</strong><br />
      <p>They have all the normal user acess plus:</p>
      <ul>
        <li><strong>SALES:</strong> Access to see when, who and how much someone spent in the web store, and to add or remove an invoice.</li>
        <li><strong>USERS:</strong> Access to see username, first and last, group and status of the users, and to add or remove an user.</li>
      </ul>
    </div>
  </div>
  <script>
  </script>
<?PHP
build_footer();
?>
