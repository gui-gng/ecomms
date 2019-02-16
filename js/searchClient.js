$(function() {
  $("button#btnSearchClient").on("click", function(event) {
    event.preventDefault();
    var searchTxt = $("input#txtSearchClient").val();

    if (searchTxt != "") {
      $.get("searchClient.php", { txtSearchClient: searchTxt } )
        .done(function( data ) {
          var result = JSON.parse(data);

          if ('no_results' in result) {
            $("input#txtClientId").val("");
            $("input#txtClientName").val("");
            $("input#txtClientAddress").val("");
            $("input#txtClientPhone").val("");

            alert("There is no Client with ID: " + searchTxt)
          } else {
            $("input#txtClientId").val(result.id);
            $("input#txtClientName").val(result.name);
            $("input#txtClientAddress").val(result.address);
            $("input#txtClientPhone").val(result.phone);
          }
        });
    }
  })
});
