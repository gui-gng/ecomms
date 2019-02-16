<?PHP
  $authChk = true;
  require('app-lib.php');

  isset($_POST['a'])? $action = $_POST['a'] : $action = "";
  if(!$action) {
    isset($_REQUEST['a'])? $action = $_REQUEST['a'] : $action = "";
  }
  isset($_POST['txtSearch'])? $txtSearch = $_POST['txtSearch'] : $txtSearch = "";
  if(!$txtSearch) {
    isset($_REQUEST['txtSearch'])? $txtSearch = $_REQUEST['txtSearch'] : $txtSearch = "";
  }

  build_header($displayName);
?>
  <?PHP build_navBlock(); ?>
  <div id="content">
    <div class="PageTitle">Sales Search</div>

  <!-- Search Section Start -->
    <form name="frmSearchSale" method="post"
          id="frmSearchSale"
          action="<?PHP echo $_SERVER['PHP_SELF']; ?>">
      <div class="displayPane">
        <div class="displayPaneCaption">Search:</div>
        <div>
          <input name="txtSearch" id="txtSearch" placeholder="Search Sales"
          style="width: calc(100% - 115px)" value="<?PHP echo $txtSearch; ?>">
          <button type="button" id="btnSearch">Search</button>
          <button type="button" id="btnAddRec">Add</button>
        </div>
      </div>
      <input type="hidden" name="a" value="listSale">
    </form>
    <!-- Search Section End -->
    <!-- Search Section List Start -->
    <?PHP
      if($action == "listSale") {
    ?>
    <div>
      <table style="width: calc(100% - 15px);border: #cccccc solid 1px">
        <tr style="background: #eeeeee">
          <td style="width: 105px;border-left: #cccccc solid 1px"><b>Invoice Number</b></td>
          <td style="border-left: #cccccc solid 1px"><b>Client Name</b></td>
          <td style="width: 130px;text-align: right"><b>Date</b></td>
          <td style="width: 80px;text-align: right"><b>Amout</b></td>
        </tr>
    <?PHP
      openDB();
      $query =
        "SELECT
            *
         FROM
            lpa_invoices
         WHERE
            lpa_inv_no LIKE '%$txtSearch%' AND lpa_inv_status <> 'D'
         OR
            lpa_inv_client_name LIKE '%$txtSearch%' AND lpa_inv_status <> 'D'

         ";
      $result = $db->query($query);
      $row_cnt = $result->num_rows;
      if($row_cnt >= 1) {
        while ($row = $result->fetch_assoc()) {
          $sid = $row['lpa_inv_no'];
          ?>
          <tr class="hl">
            <td onclick="loadInvoice(<?PHP echo $sid; ?>,'Edit')"
                style="cursor: pointer;border-left: #cccccc solid 1px">
              <?PHP echo $sid; ?>
            </td>
            <td onclick="loadInvoice(<?PHP echo $sid; ?>,'Edit')"
                style="cursor: pointer;border-left: #cccccc solid 1px">
                <?PHP echo $row['lpa_inv_client_name']; ?>
            </td>
            <td style="text-align: right">
              <?PHP echo $row['lpa_inv_date']; ?>
            </td>
            <td style="text-align: right" class="value">
              <?PHP echo $row['lpa_inv_amount']; ?>
            </td>
          </tr>
        <?PHP } ?>
          <tr style="border-top: #cccccc solid 1px">
            <td style="border-right: #cccccc solid 1px"><strong>Total</strong></td>
            <td colspan="3" style="text-align: right;"><strong class="totalAmount"></strong></td>
          </tr>
      <?PHP } else { ?>
        <tr>
          <td colspan="3" style="text-align: center">
            No Records Found for: <b><?PHP echo $txtSearch; ?></b>
          </td>
        </tr>
      <?PHP } ?>
      </table>
    </div>
    <?PHP } ?>
    <!-- Search Section List End -->
  </div>
  <script>
    var action = "<?PHP echo $action; ?>";
    var search = "<?PHP echo $txtSearch; ?>";
    if(action == "recUpdate") {
      alert("Record Updated!");
      navMan("sales.php?a=listSale&txtSearch=" + search);
    }
    if(action == "recInsert") {
      alert("Record Added!");
      navMan("sales.php?a=listSale&txtSearch=" + search);
    }
    if(action == "recDel") {
      alert("Record Deleted!");
      navMan("sales.php?a=listSale&txtSearch=" + search);
    }
    function loadInvoice(ID,MODE) {
      window.location = "salesaddedit.php?sid=" +
      ID + "&a=" + MODE + "&txtSearch=" + search;
    }
    $("#btnSearch").click(function() {
      $("#frmSearchSale").submit();
    });
    $("#btnAddRec").click(function() {
      loadInvoice("","Add");
    });
    setTimeout(function(){
      $("#txtSearch").select().focus();
    },1);

    var totalAmount = 0
    $("td.value").each(function() {
      totalAmount += parseFloat($(this).text());
    });
    $("strong.totalAmount").text(totalAmount.toFixed(2));
  </script>
<?PHP
build_footer();
?>
