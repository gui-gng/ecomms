<?PHP 
$authChk = true;
$adminChk = true;

require('app-lib.php');
isset($_POST['a'])? $action = $_POST['a'] : $action = "";
if(!$action) {
	isset($_REQUEST['a']) ? $action = $_REQUEST['a'] : $action = "";
}

isset($_POST['txtSearch']) ? $txtSearch = $_POST['txtSearch'] : $txtSearch = "";
if(!$txtSearch) {
	isset($REQUEST['txtSearch']) ? $txtSearch = $_REQUEST['txtSearch'] : $txtSeach = "";
}

build_header($displayName);
build_navBlock();
?>

<div id="content">
	<div class="PageTitle"> Users Management Search </div>

	<!-- Search Section Start --> 
	<form name=frmSearchUser" method="post" id="frmSearchUser" action="<?PHP echo $_SERVER['PHP_SELF'] ?>">
		<div class="displayPane"> 
			<div class="displayPaneCaption">Search:</div>
			<div>
				<input name="txtSearch" id="txtSearch" placeholder="Search User" style="width: calc(100% - 115px)" value="<?PHP echo $txtSearch; ?>" >
				<button type="button" id="btnSearch">Search</button>
				<button type="button" id="btnAddRec">Add</button>
			</div>
		</div>
		<input type="hidden" name="a" value="listUser">
	</form>

	<!-- Search section end -->


	<!-- Search list Start -->

	<?PHP 
		if($action == "listUser"){
	?>

	<div>
		<table style="width: calc(100% - 15px); border: #CCC solid 1px;">
			<tr style="background: #EEE">
				<td style="width: 80px;border-left: #CCC solid 1px;text-align: center;"><b>User ID</b> </td>
				<td style="width: 80px;border-left: #CCC solid 1px;text-align: center;"><b>Username</b> </td>
				<td style="width: 80px;border-left: #CCC solid 1px;text-align: center;"><b>First Name</b> </td>
				<td style="width: 80px;border-left: #CCC solid 1px;text-align: center;"><b>Last Name</b> </td>
				<td style="width: 80px;border-left: #CCC solid 1px;text-align: center;"><b>Group</b> </td>
				<td style="width: 80px;border-left: #CCC solid 1px;text-align: center;"><b>Edition</b> </td>
				<td style="width: 80px;border-left: #CCC solid 1px;text-align: center;"><b>Remove</b> </td>

			</tr> 

<?PHP 
openDB();

$query = "SELECT * FROM lpa_users WHERE lpa_user_ID LIKE '%$txtSearch%' AND lpa_user_status = 1
OR lpa_user_username LIKE '%$txtSearch%' AND lpa_user_status = 1";

$result = $db->query($query);
$row_cnt = $result->num_rows;

if($row_cnt >= 1){
	while($row = $result->fetch_assoc()){
		$uid = $row['lpa_user_ID'];
		?>
		<tr class="h1">
			<td style="text-align: right"><?PHP echo $row['lpa_user_ID'] ?> </td>
			<td style="text-align: right"><?PHP echo $row['lpa_user_username'] ?> </td>
			<td style="text-align: right"><?PHP echo $row['lpa_user_firstname'] ?> </td>
			<td style="text-align: right"><?PHP echo $row['lpa_user_lastname'] ?> </td>
			<td style="text-align: right"><?PHP echo $row['lpa_user_group'] ?> </td>
			<td style="text-align: right">
				<button type="button" id="btnEdit" onClick="loadUser(<?PHP echo $uid; ?>, 'Edit')" /> 
				Edit 
			</td>
			<td style="text-align: right">
				<button type="button" id="btnDelete" onClick="loadUser(<?PHP echo $uid; ?>, 'Delete')" /> 
				Delete 
			</td>
		</tr>	
<?PHP }
	} else { 
?>
	<tr>
		<td colspan="3" style="text-align: center">
			No Records Found for: <b><?PHP echo $txtSearch; ?></b>
		</td>
	</tr>


<?PHP } ?>
		</table>
	</div>

<?PHP } ?>
</div>


<!-- Search Section List End -->
<script> 
var action = "<?PHP echo $action; ?>";
var search = "<?PHP echo $txtSearch; ?>";

if(action == "recUpdate"){
	alert("Record Update!");
	navMan("users.php?a=listUser&txtSearch" + search);
}

if(action == "recInsert"){
	alert("Record Added!");
	navMan("users.php?a=listUser&txtSearch" + search);
}

if(action == "recDelete"){
	alert("Record Delete!");
	navMan("users.php?a=listUser&txtSearch" + search);
}

function loadUser(ID, MODE){
	window.location = "useraddedit.php?uid=" + ID + "&a=" + MODE + "&txtSearch=" + search;
}


$("#btnSearch").click(function(){
	$("#frmSearchUser").submit();
});

$("#btnAddRec").click(function(){
	loadUser("", "Add");
});

setTimeout(function(){
	$("#txtSearch").select().focus();
},1);
</script>

<?PHP 
build_footer();
?>

