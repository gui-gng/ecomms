


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

 <link href="css/stylemashup.css" rel="stylesheet" type="text/css">
  <?PHP build_navBlock(); ?>


  <div id="content">

    <div class="mashup_mission">
        <h2> Mission statement </h2>

        <p>
            Our mission is provide the best service with a reliable software.       
        </p>
    </div>


    <div class="mashup_googlemaps">
        <h2> Google Maps </h2>

    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3540.119840239508!2d153.02717481505232!3d-27.465528223101124!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6b915a1d772edb2d%3A0xa10d73f1dee93c97!2sCanterbury+Technical+Institute!5e0!3m2!1spt-BR!2sau!4v1538019251623" width="300" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
    </div>

    <div class="mashup_youtube">
        <h2> Youtube </h2>

        <iframe width="400" height="400"
        src="https://www.youtube.com/embed/tgbNymZ7vqY">
        </iframe>
    </div>

    <div class="mashup_facebook">
        <h2> Facebook </h2>

        <iframe src="https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2FCanterburyTechnicalInstitute%2Fposts%2F888226921364385&width=500" width="400" height="400" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>
    </div>
</div>