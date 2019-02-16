function clickme() {
    alert("You have clicked on me");
}
function navMan(URL) {
    window.location = URL;
}
function addToCart(ID) {

    var qty = document.getElementById("fldQTY-"+ID).value;
    var products = $.cookie("cart");
    var productsJ = [];
    if(products){
        productsJ = JSON.parse(products);
    }
    productsJ.push({productID: ID, qnt: qty});
    $.cookie("cart", JSON.stringify(productsJ));

    alert(qty + " x Item: " + ID + " has been added to your cart");
}
function do_login() {
    document.getElementById("frmLogin").submit();
}

function displayProductsCookies(){
    var products = $.cookie("cart");

}



function currencyFormat(num) {
    return '$' + num.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
}


function showPayment(){

    $("#checkout_continueButton").addClass("d-none");
    $("#checkout_paynow").removeClass("d-none");

    $("#checkout_update").addClass("d-none");
    $("#checkout_cancel").removeClass("d-none");
    
    $("#paymentDetails_checkout").toggleClass("d-none");
    $("#listProducts_checkout_total").toggleClass("d-none");
    $("#listProducts_checkout").toggleClass("d-none");

}



function showCart(){
    $("#checkout_continueButton").removeClass("d-none");
    $("#checkout_paynow").addClass("d-none");

    $("#checkout_update").removeClass("d-none");
    $("#checkout_cancel").addClass("d-none");
    
    $("#paymentDetails_checkout").toggleClass("d-none");
    $("#listProducts_checkout_total").toggleClass("d-none");
    $("#listProducts_checkout").toggleClass("d-none");
}


function allowUpdate(){
    $('.showValuesPrice').toggleClass("d-none");
    $('.updateValuesPrice').toggleClass("d-none");
}


function executePayment(productsRequest){

    $.post('payment.php', {invoice: JSON.stringify(productsRequest)},function(result){

        if(result=='Success')
        {
            alert('Payment is successful');
            $.cookie("cart", "");
            window.location.href = '/ecomms/index.php';
        }
        else
        {
            alert(result);
            alert('Payment is Failed \n' + result);
        }
    });
}