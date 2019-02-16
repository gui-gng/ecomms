<?PHP 
  require('app-lib.php'); 
  build_header();
?>
  <?PHP build_navBlock(); ?>
  <div id="content">
    <div class="sectionHeader">Product List</div>
    <div class="setionSearch">
        <form action="catalog.php" method="get">
            <input type="text" name="Search" id="fldSearch">
            <button type="submit">Search</button>
        </form>
    </div>
  </div>


  <?PHP
    $itemNum = 1;
    openDB();
    $search = $_GET["Search"];
    $query = "SELECT * FROM lpa_stock ".
      "WHERE lpa_stock_status = 'a' ".
      "AND lpa_stock_name LIKE '%". $search ."%'".
      "ORDER BY lpa_stock_name ASC";
    $result = $db->query($query);

    while ($row = $result->fetch_assoc()) {
     if($row['lpa_image']) {
       $prodImage = $row['lpa_image'];
     } else {
       $prodImage = "question.png";
     }
    $prodID = $row['lpa_stock_ID'];
  ?>
    <?PHP echo $search; ?>
    <div class="productListItem">
      <div
        class="productListItemImageFrame"
        style="background: url('images/<?PHP echo $prodImage; ?>') no-repeat center center;">
      </div>
      <div class="prodTitle"><?PHP echo $row['lpa_stock_name']; ?></div>
      <div class="prodDesc"><?PHP echo $row['lpa_stock_desc']; ?></div>
      <div class="prodOptionsFrame">
        <div class="prodPriceQty">
          <div class="prodPrice">$<?PHP echo $row['lpa_stock_price']; ?></div>
          <div class="prodQty">QTY:</div>
          <div class="prodQtyFld">
            <input
              name="fldQTY-<?PHP echo $prodID; ?>"
              id="fldQTY-<?PHP echo $prodID; ?>"
              type="number"
              value="1">
          </div>
        </div>
        <div class="prodAddToCart">
          <button
            type="button"
            onclick="addToCart('<?PHP echo $prodID; ?>')" >
            Add To Cart
          </button>
        </div>
      </div>
      <div style="clear: left"></div>
    </div>
<?PHP } ?>
  </div>
<?PHP
  build_footer();
?>