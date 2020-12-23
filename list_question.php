<?php require_once(__DIR__ . "/partials/nav.php"); ?>
<?php
if (!has_role("Admin")) {
    //this will redirect to login and kill the rest of this script (prevent it from executing)
    flash("You don't have permission to access this page");
    die(header("Location: login.php"));
}
?>
<?php
$query = "";
$results = [];
if (isset($_POST["query"])) {
    $query = $_POST["query"];
}
if (isset($_POST["search"]) && !empty($query)) {
    $db = getDB();
    $stmt = $db->prepare("SELECT q.id,q.question,survey.title as s, Users_prj.username from Questions as q JOIN Users_prj on q.user_id = Users_prj.id LEFT JOIN Survey as survey on q.survey_id = survey.id WHERE q.question like :q LIMIT 10");
    $r = $stmt->execute([":q" => "%$query%"]);
    if ($r) {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    else {
        flash("There was a problem fetching the results " . var_export($stmt->errorInfo(), true));
    }
}
?>
<h3>List Questions</h3>
<form method="POST">
    <input name="query" placeholder="Search" value="<?php safer_echo($query); ?>"/>
    <input type="submit" value="Search" name="search"/>
</form>
<div class="results">
    <?php if (count($results) > 0): ?>
        <div class="list-group">
            <?php foreach ($results as $r): ?>
                <div class="list-group-item">
                    <div>
                        <div>Questions:</div>
                        <div><?php safer_echo($r["question"]); ?></div>
                    </div>
                    <div>
                        <div>Survey:</div>
                        <div><?php safer_echo($r["survey"]); ?></div>
                    </div>
                    <div>
                        <div>User:</div>
                        <div><?php safer_echo($r["username"]); ?></div>
                    </div>
                    <div>
                        <a type="button" href="edit_question.php?id=<?php safer_echo($r['id']); ?>">Edit Questions</a>
                        <a type="button" href="view_question.php?id=<?php safer_echo($r['id']); ?>">View Questions</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No results</p>
    <?php endif; ?>
</div>