<?php
require('autoloader.php');

use classes\Connection;
$db = new Connection();

$users = $db->getUserList();
$keyboards = $db->getKeyboardList();
?>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="includes/timing.js" ></script>
    <link rel="stylesheet" href="includes/style.css">
</head>
<body>
<div class="settings-div">
    <form>
        <div class="form-group">
            <label for="exampleInputEmail1">Participant</label>
            <select class="form-control" name="participant" id="participant" placeholder="Select Participant">
                <option value="0">Please select a participant</option>
                <?php foreach ($users as $user) echo "<option value='{$user['id']}'>{$user['name']}</option>"; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Keyboard</label>
            <select class="form-control" name="keyboard" id="keyboard" placeholder="Select Keyboard">
                <option value="0">Please select a keyboard</option>
                <?php foreach ($keyboards as $keyboard) echo "<option value='{$keyboard['id']}'>{$keyboard['name']}</option>"; ?>
            </select>
        </div>
    </form>
</div>
<div style="text-align: center;"><a href="extract.php">See the results</a></div>
<div id="text_box"><div style="height:140px;"><p></p></div></div>
<div id="entries">
</div>

</body>
</html>