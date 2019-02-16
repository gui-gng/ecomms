<?PHP
  $authChk = true;
  require('app-lib.php');

  $search = $_GET['txtSearchClient'];

  $query = "SELECT * FROM lpa_clients WHERE lpa_client_ID = '$search' AND lpa_client_status <> 'D' LIMIT 1";
  openDB();
  $result = $db->query($query);
  $row_cnt = $result->num_rows;

  if ($row_cnt >= 1) {
    $row = $result->fetch_assoc();
    $searchComplete = array(
      'id' => $row['lpa_client_ID'],
      'name' => "{$row['lpa_client_firstname']} {$row['lpa_client_lastname']}",
      'address' => $row['lpa_client_address'],
      'phone' => $row['lpa_client_phone'],
    );
  } else {
    $searchComplete = array('no_results' => true);
  }

  echo json_encode($searchComplete);
?>
