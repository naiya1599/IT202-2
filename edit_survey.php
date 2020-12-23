<?php require_once(__DIR__ . "/partials/nav.php"); ?>
<?php
if (!has_role("Admin")) {
    //this will redirect to login and kill the rest of this script (prevent it from executing)
    flash("You don't have permission to access this page");
    die(header("Location: login.php"));
}
?>
<?php
//we'll put this at the top so both php block have access to it
if(isset($_GET["id"])){
	$id = $_GET["id"];
}
?>
<?php
if(isset($_POST["save"])){
	$title = $_POST["Title"];
		$desc = $_POST["desc"];
		$state = $_POST["visibility"];
		$nst = date('Y-m-d H:i:s');
		$user = get_user_id();
		$db = getDB();
		if(isset($id)){
			$stmt = $db->prepare("UPDATE SURVEY set title=:title, description=:desc, visibility=:state where id=:id"); 
				//$stmt = $bd->prepare("INSERT INTO Survey(title,description,visibility,user_id) VALUES(:title, :desc, :state, :user)");
			$r = $stmt->execute([
					":title"=>$name,
			":desc"=>$desc,
			":state"=>$state,
			":id"=>$id
			]);
			if($r){
				flash("Updated successfully with id: " . $id);
			}
			else{
			$e = $stmt->errorInfo();
			flash("Error updating: " . var_export($e, true));
		}
	}
	else{
		flash("ID isn't set, we need an ID in order to update");
	}
}
?>
<?php
//fetching
$result = [];
if(isset($id)){
	$id = $_GET["id"];
	$db = getDB();
	$stmt = $db->prepare("SELECT * FROM Survey where id = :id");
	$r = $stmt->execute([":id"=>$id]);
	$result = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
 <form method="POST">
	<label> Title</label>
	 <input name="Title" placeholder="Title"/>
	 <label>Description</label>
     <input type="text" name="desc"/>
	 <select name="visibility">
		<option value="0">Draft</option>
		<option value="1">Private</option>
		<option value="2">Public</option>
	</select>
	 <input type="submit" name="save" value="Create Survey"/>
	 
</form>
<?php require(__DIR__ . "/partials/flash.php");




