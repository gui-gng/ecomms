<?PHP 
  require('app-lib.php'); 
  build_header();
?>
  <?PHP build_navBlock(); ?>

  <?PHP

    $cart = $_COOKIE["cart"];
    if(!isset($cart)) {
        echo "Cookie named is not set!";
    } else {
        $cartObj = json_decode($cart);
        $arrlength = count($cartObj);
        $idsToSearch = "";
        for($x = 0; $x < $arrlength; $x++) {
            $idsToSearch = $idsToSearch . $cartObj[$x]->{'productID'} . ",";
        }
        $idsToSearch = $idsToSearch . "0";

        openDB();
        $query = "SELECT * FROM lpa_stock ".
        "WHERE lpa_stock_status = 'a' ".
        "AND lpa_stock_ID IN (". $idsToSearch .")".
        "ORDER BY lpa_stock_name ASC";
        $result = $db->query($query);

        $jsonSearch = "[";
        while ($row = $result->fetch_assoc()) {
            if($row['lpa_image']) {
                $prodImage = $row['lpa_image'];
            } else {
                $prodImage = "question.png";
            }
            $prodID = $row['lpa_stock_ID'];
            $prodName = $row['lpa_stock_name'];
            $prodDesc = $row['lpa_stock_desc'];
            $prodPrice = $row['lpa_stock_price'];
            $prodOnHand = $row['lpa_stock_onhand'];

            $jsonSearch = $jsonSearch . "{" .
            "ID:'" . $prodID . "'," .
            "Name:'" . $prodName . "'," .
            "Desc:'" . $prodDesc . "'," .
            "Image: '" . $prodImage . "'," .
            "Price:" . $prodPrice . "," .
            "OnHand:" . $prodOnHand . "," . 
            "},";
        }
        $jsonSearch = $jsonSearch . "{}]"; 
        //echo $jsonSearch;

        $userID = $_SESSION['authUser'];
        $firstName = "";
        $lastName = "";
        $address = "";
        $phone = "";

        $query = "SELECT * FROM lpa_ecomms.lpa_clients 
        WHERE lpa_client_ID =" . $userID;
        $result = $db->query($query);

        while ($row = $result->fetch_assoc()) {
            $client_id = $row['lpa_client_ID'];
            $firstName = $row['lpa_client_firstname'];
            $lastName = $row['lpa_client_lastname'];
            $address = $row['lpa_client_address'];
            $phone = $row['lpa_client_phone'];
        }
?>


<div id="content">
    <div id="listProducts_checkout" class="scrolling-wrapper" style='max-height: 540px; max-width:750px;'>
    </div>
    <div id="listProducts_checkout_total"></div>

    <div id="paymentDetails_checkout" style='max-height: 740px; max-width:750px;' class="d-none">
        <div class="form-row">
        <div class="form-group col-md-6">
        <label for="payment_firstName">First Name</label>
        <input type="text" value="<?PHP echo $firstName ?>" class="form-control" id="payment_firstName" placeholder="firstName" disabled>
        </div>
        <div class="form-group col-md-6">
        <label for="payment_lastName">Last Name</label>
        <input type="text" value="<?PHP echo $lastName ?>" class="form-control" id="payment_lastName" placeholder="lastName" disabled>
        </div>
    </div>
    <div class="form-group">
        <label for="inputAddress">Address</label>
        <input type="text" value="<?PHP echo $address ?>" class="form-control" id="inputAddress" placeholder="1234 Main St" disabled>
    </div>
    <div class="form-group">
        <label for="payment_phone">Phone Number</label>
        <input type="text" value="<?PHP echo $phone ?>" class="form-control" id="payment_phone" placeholder="0444-444-444" disabled>
    </div>
    <div class="form-row">
        <div class="form-group col-md-4">
        <label for="inputState">Payment option</label>
        <select id="inputState" class="form-control">
            <option selected>Paypal</option>
            <option>VISA</option>
            <option>MasterCard</option>
            <option>Direct deposit</option>
        </select>
        </div>
    </div>
    </div>

    <div class="row ml-0 mt-1 align-items-center justify-content-center" style=' max-width:750px;'>
        <div class="col">
            <button id="checkout_update" onclick="allowUpdate()" type="button" class="btn w-100 btn-secondary">Update</button>
            <button id="checkout_cancel" onclick="showCart()" type="button" class="btn w-100 btn-secondary d-none">Cancel</button>
        </div>
        <div class="col">
            <button id="checkout_continueButton" onclick="showPayment()" type="button" class="btn w-100 btn-success">Continue</button>
            <button id="checkout_paynow" onclick="executePayment(productsRequest)" type="button" class="btn w-100 btn-success d-none">Pay Now</button>
        </div>
        
    </div>
    
</div>

<script type="text/javascript">
    var products = <?PHP  echo $jsonSearch; ?> ;
    var productsCoockies = JSON.parse($.cookie("cart"));
    var totalPrice = 0;
    var component = "";
    var items = [];

    

    if(productsCoockies){
    productsCoockies.forEach(pdC => {
        products.forEach((product) => {
            if(pdC.productID == product.ID) {
                //Render
                component = "";
                component = component.concat("<div id='card_" + product.ID + "' class='card' style='max-width: 740px;'>");
                component = component.concat("<div class='row'>");
                component = component.concat("<div class='col-2'>");
                component = component.concat("<img src='images/" + product.Image + "' class='card-img' alt=''>");
                component = component.concat("</div>");
                component = component.concat("<div class='col-4'>");
                component = component.concat("<div class='card-body'>");
                component = component.concat("<h5 class='card-title'>" + product.Name + "</h5>");
                component = component.concat("<p class='card-text'>" + product.Desc + "</p>");
                component = component.concat("</div></div>");

                component = component.concat("<div class='col-3'>");
                component = component.concat("<p class='card-text showValuesPrice'><small class='text-muted'>" + "Price: " + pdC.qnt +  " x " + currencyFormat(product.Price) + "</small></p>");
                component = component.concat("<p class='card-text updateValuesPrice d-none'><small class='text-muted'>" + "Price: <input class='inputQnt' type='number' value='" + pdC.qnt +  "' max='" +  product.OnHand + "' min='0' > x " + currencyFormat(product.Price) + "</small></p>");
                component = component.concat("</div>");
                
                var priceQnt = product.Price * pdC.qnt;
                component = component.concat("<div class='col-3'>");
                component = component.concat("<h5 class='card-title'>Total: " + currencyFormat(priceQnt) + "</h5>");
                component = component.concat("</div>");

                component = component.concat("</div></div>");
                
                totalPrice += priceQnt;

                component = component.concat("");
                $("#listProducts_checkout").append(component);


                //Create object
                product.qnt = pdC.qnt;
                items.push(product);

            }
        });
    });
    component = "";
    component = component.concat("<div class='card' style='max-width: 740px;'>");
    component = component.concat("<div class='row'>");
    component = component.concat("<div class='col-6'>");
    component = component.concat("<h5 class='card-title'>Total</h5>");
    component = component.concat("</div>");
    component = component.concat("<div class='col-6'>");
    component = component.concat("<h5 class='card-title'>" + currencyFormat(totalPrice) + "</h5>");
    component = component.concat("</div>");
    component = component.concat("</div></div>");
    $("#listProducts_checkout_total").append(component);

    var productsRequest = {
        invoice_client_id: <?PHP echo $client_id ?>,
        invoice_name: '<?PHP echo $firstName . " " . $lastName ?>',
        invoice_address: '<?PHP echo $address ?>',
        invoice_amount: totalPrice,
        invoice_items: items
    }
}
else
{
    alert(productsCoockies);
}
   
</script>


<?PHP
    }
  ?>
 
<?PHP
  build_footer();
?>