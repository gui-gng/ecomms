<?PHP
  $authChk = true;
  require('app-lib.php');
  isset($_REQUEST['sid'])? $sid = $_REQUEST['sid'] : $sid = "";
  if(!$sid) {
    isset($_POST['sid'])? $sid = $_POST['sid'] : $sid = "";
  }
  isset($_REQUEST['a'])? $action = $_REQUEST['a'] : $action = "";
  if(!$action) {
    isset($_POST['a'])? $action = $_POST['a'] : $action = "";
  }
  isset($_POST['txtSearch'])? $txtSearch = $_POST['txtSearch'] : $txtSearch = "";
  if(!$txtSearch) {
    isset($_REQUEST['txtSearch'])? $txtSearch = $_REQUEST['txtSearch'] : $txtSearch = "";
  }

  if($action == "delRec") {
    $query =
      "UPDATE lpa_invoices SET
         lpa_inv_status = 'D'
       WHERE
         lpa_inv_no = '$sid' LIMIT 1
      ";
    openDB();
    $result = $db->query($query);
    if($db->error) {
      printf("Errormessage: %s\n", $db->error);
      exit;
    } else {
      header("Location: sales.php?a=recDel&txtSearch=$txtSearch");
      exit;
    }
  }

  isset($_POST['txtInvNo'])?          $invoiceID = $_POST['txtInvNo'] :                 $invoiceID = "";
  isset($_POST['txtClientId'])?       $invClientID = $_POST['txtClientId'] :            $invClientID = "0";
  isset($_POST['txtClientName'])?     $invClientName = $_POST['txtClientName'] :        $invClientName = "";
  isset($_POST['txtClientAddress'])?  $invClientAddress = $_POST['txtClientAddress'] :  $invClientAddress = "";
  isset($_POST['txtInvoiceAmount'])?  $invAmount = $_POST['txtInvoiceAmount'] :         $invAmount  = "0.00";
  isset($_POST['txtStatus'])?         $invStatus = $_POST['txtStatus'] :                $invStatus = "";
  


  $mode = "insertRec";
  if($action == "updateRec") {
    $query =
      "UPDATE lpa_invoices SET
        lpa_inv_client_ID = '$invClientID',
        lpa_inv_client_name = '$invClientName',
        lpa_inv_client_address = '$invClientAddress',
        lpa_inv_amount = '$invAmount',
        lpa_inv_status = '$invStatus'
       WHERE
         lpa_inv_no = '$sid' LIMIT 1
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
         header("Location: sales.php?a=recUpdate&txtSearch=$txtSearch");
       exit;
     }
  }
 

  if($action == "insertRec") {

    $query =
      "INSERT INTO lpa_invoices (
      
        lpa_inv_date,
        lpa_inv_client_ID,
        lpa_inv_client_name,
        lpa_inv_client_address,
        lpa_inv_amount,
        lpa_inv_status
       ) VALUES (
        
         NOW(),
         '$invClientID',
         '$invClientName',
         '$invClientAddress',
         $invAmount,
         '$invStatus'
       )
      ";
    openDB();
    $result = $db->query($query);
    if($db->error) {
      printf("Errormessage: %s\n", $db->error);
      printf($query);
      
      exit;
    } else {
      header("Location: sales.php?a=recInsert&txtSearch=".$invoiceID);
      exit;
    }
  }

  if($action == "Edit") {
    $query = "SELECT * FROM lpa_invoices 
          INNER JOIN lpa_ecomms.lpa_clients ON lpa_ecomms.lpa_clients.lpa_client_ID = lpa_ecomms.lpa_invoices.lpa_inv_client_ID WHERE lpa_inv_no = '$sid' LIMIT 1";
    $result = $db->query($query);
    $row_cnt = $result->num_rows;
    $row = $result->fetch_assoc();
    $invoiceID     = $row['lpa_inv_no'];
    $invDate   = $row['lpa_inv_date'];
    $invClientID   = $row['lpa_inv_client_ID'];
    $invClientName   = $row['lpa_inv_client_name'];
    $invClientAddress   = $row['lpa_inv_client_address'];
    $invAmount   = $row['lpa_inv_amount'];
    $invStatus   = $row['lpa_inv_status'];
      
    $mode = "updateRec";
  }
  build_header($displayName);
  build_navBlock();
  $fieldSpacer = "5px";
?>
  <script src="js/searchClient.js" type="text/javascript"></script>

  <div id="content">
    <div class="PageTitle">Invoice Record Management (<?PHP echo $action; ?>)</div>

    <form name="frmInvoiceRec" id="frmInvoiceRec" method="post" action="<?PHP echo $_SERVER['PHP_SELF']; ?>">
      <div class="displayPane">
        <label><strong>Invoice Number:</strong> <?PHP echo $invoiceID; ?></label>
        <input name="txtInvNo" id="txtInvNo" value="<?PHP echo $invoiceID; ?>" type="hidden">
      </div>
      <br />
      <div class="displayPane">
        <div class="displayPaneCaption">Search Client:</div>
        <div>
          <input name="txtSearchClient" id="txtSearchClient" placeholder="Search Client"
          style="width: 115px">
          <button type="button" id="btnSearchClient">Search</button>

        </div>
        <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
          <div style="display: inline-block; width: 24%">
            <label for=""><strong>Client ID</strong></label>
            <br />
            <input name="txtClientId" id="txtClientId" value="<?= $invClientID ?>" title="Client ID"  style="width: 95%;">
          </div>
          <div style="display: inline-block; width: 24%">
            <label for=""><strong>Name</strong></label>
            <br />
            <input name="txtClientName" id="txtClientName" value="<?= $invClientName ?>" title="Name"  style="width: 95%;">
          </div>
          <div style="display: inline-block; width: 24%">
            <label for=""><strong>Address</strong></label>
            <br />
            <input name="txtClientAddress" id="txtClientAddress" value="<?= $invClientAddress ?>" title="Address"  style="width: 95%;">
          </div>
           <div style="display: inline-block; width: 24%">
            <label for=""><strong>Phone</strong></label>
            <br />
            <input name="txtClientPhone" id="txtClientPhone" value="" title="Phone"  style="width: 95%;">
          </div>


           <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
            <input name="txtInvoiceAmount" id="txtInvoiceAmount" placeholder="Invoice Amount" value="<?PHP echo $invAmount; ?>" style="width: 90px;text-align: right"  title="Invoice Amount">
          </div>
          
        </div>
      </div>
      <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
        <div>Invoice Status:</div>
        <input name="txtStatus" id="txtInvoiceStatusActive" type="radio" value="P"/>
          <label for="txtInvoiceStatusActive">Active</label>
        <input name="txtStatus" id="txtInvoiceStatusInactive" type="radio" value="U" />
          <label for="txtInvoiceStatusInactive">Inactive</label>
      </div>
      <input name="a" id="a" value="<?PHP echo $mode; ?>" type="hidden">
      <input name="sid" id="sid" value="<?PHP echo $sid; ?>" type="hidden">
      <input name="txtSearch" id="txtSearch" value="<?PHP echo $txtSearch; ?>" type="hidden">
    </form>
    <div class="optBar">
      <button type="button" id="btnInvoiceSave">Save</button>
      <button type="button" onclick="navMan('sales.php')">Close</button>
      <?PHP if($action == "Edit") { ?>
      <button type="button" onclick="delRec('<?PHP echo $sid; ?>')" style="color: darkred; margin-left: 20px">DELETE</button>
      <?PHP } ?>
    </div>
  </div>
  <script>
    $("#btnInvoiceSave").click(function(){
        $("#frmInvoiceRec").submit();
    });
    function delRec(ID) {
      navMan("salesaddedit.php?sid=" + ID + "&a=delRec");
    }
    setTimeout(function(){
      $("#txtInvoiceAmount").focus();

    var stockRecStatus = "<?PHP echo $invStatus; ?>";
   
    if(stockRecStatus == "P") {
      $('#txtInvoiceStatusActive').prop('checked', true);
    } else {
      $('#txtInvoiceStatusInactive').prop('checked', true);
    }

    },1);
  </script>
<?PHP
build_footer();
?>
