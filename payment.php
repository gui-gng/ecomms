<?PHP
require('app-lib.php'); 

$productsInvoice = json_decode($_POST["invoice"], true);

$invoice_date = date("Y-m-d h:i:s");
$invoice_client_id = $productsInvoice["invoice_client_id"];
$invoice_name = $productsInvoice["invoice_name"];
$invoice_address = $productsInvoice["invoice_address"];
$invoice_amount = $productsInvoice["invoice_amount"];


$query_invoices = "INSERT INTO lpa_ecomms.lpa_invoices
(lpa_inv_date,
lpa_inv_client_ID,
lpa_inv_client_name,
lpa_inv_client_address,
lpa_inv_amount,
lpa_inv_status)
VALUES
("."
'" . $invoice_date . "',".
$invoice_client_id . ",'" .
$invoice_name . "','" .
$invoice_address . "'," .
$invoice_amount . "," .
"'U');";

$query_select_invoice = "SELECT lpa_inv_no FROM lpa_ecomms.lpa_invoices
WHERE 
`lpa_inv_client_ID` = " . $invoice_client_id . " AND 
`lpa_inv_date` = '" . $invoice_date . "'" ;




openDB();
$query = $query_invoices . $query_invoices_items;
//echo $query;
$result = $db->query($query_invoices);


$query_invoices_items = "";

$items = $productsInvoice["invoice_items"];
foreach ($items as $key => $item) {

$query_invoices_item = "INSERT INTO lpa_ecomms.lpa_invoice_items
(
lpa_invitem_inv_no,
lpa_invitem_stock_ID,
lpa_invitem_stock_name,
lpa_invitem_qty,
lpa_invitem_stock_price,
lpa_invitem_stock_amount,
lpa_inv_status)
    VALUES"
    .  "(" . 
    "(" . $query_select_invoice . ")," .
    $item["ID"] . "," .
   "'" . $item["Name"] . "'," .
    $item["qnt"] . "," .
    $item["Price"] . "," .
    $item["qnt"] . "*" . $item["Price"] . "," .
    "'U');";

    $result = $db->query($query_invoices_item);
    $query_invoices_items = $query_invoices_items . $query_invoices_item;
}




if($db->error) {
    echo "Errormessage: %s\n", $db->error;
  } else {
    echo "Success";
  }
?>