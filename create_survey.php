<?php require_once(__DIR__ . "/partials/nav.php"); ?>
<?php
if (!has_role("Admin")) {
    //this will redirect to login and kill the rest of this script (prevent it from executing)
    flash("You don't have permission to access this page");
    die(header("Location: login.php"));
}
?>

 <form method="POST">
	<label> Title</label>
	 <input name="Title" placeholder="Title"/>
	 <label>Description</label>
     <input type="text" name="desc"/>
	<labe>Visibility</label>
	 <select name="visibility">
		<option value="0">Draft</option>
		<option value="1">Private</option>
		<option value="2">Public</option>
	</select>
	 <input type="submit" name="save" value="Create Survey"/>
	 
</form>
<?php
	if(isset($_POST["save"])){
		$title = $_POST["Title"];
		$desc = $_POST["desc"];
		$state = $_POST["visibility"];
		$nst = date('Y-m-d H:i:s');
		$user = get_user_id();
		$db = getDB();
		$stmt = $db->prepare("INSERT INTO Survey(title,description,visibility,user_id) VALUES(:title, :desc, :state, :user)");
		$r = $stmt->execute([
			":title"=>$title,
			":desc"=>$desc,
			":state"=>$state,
			":user"=>$user
			]);
		if($r){
			flash("Successful creation of survey with id: " . $db->lastInsertID());
		}
		else{
			$e = $stmt->errorInfo();
			flash("Error creating: " . var_export($e,true));
		}
	}
?>
<?php require(__DIR__ . "/partials/flash.php");
		