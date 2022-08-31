<?php

require_once __DIR__ . '/../conn.php';
if (isset($_POST['next']) && isset($_POST['name'])) {
    // prepare and bind
    $stmt = $mysqli->prepare("INSERT INTO results (date, name) VALUES (?, ?)");
    $stmt->bind_param("ss", $_POST['next'], $_POST['name']);
    $stmt->execute();
}

$sql = "SELECT *  FROM results";
$result = $mysqli->query($sql);
$results = [];
$final = [];
$date = [];
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $results[] = [
        'date' => $row['date'],
        'name' => $row['name']
    ];
  }
}
foreach ($results as $result) {
    $final[$result['date']][] = $result['name'];
}
foreach ($final as $key => $val) {
    $date[$key] = count($val);
}
arsort($date, SORT_NUMERIC);
?>
<html>
    <title>DND Time Scheduler</title>
    <link rel="icon" type="image/x-icon" href="/favicon.ico">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <div class="container">
        <h1>DND Time Scheduling</h1>
        <div class="well well-lg">
            <form method="POST">
                <label for="start">Next date:</label>
                <input type="date" id="start" name="next" min="<?=date('Y-m-d')?>">
                <br>
                <label for="name">Submitters Name:</label>
                <input type="text" id="name" name="name">    
                <br>
                <button class="btn btn-primary" type="submit">Submit</button>
            </form>
        </div>
        <hr>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Date</th>
                    <th scope="col">Count</th>
                    <th scope="col">Votees</th>
                </tr>
            </thead>
            <tbody>
            <?php
            foreach ($date as $key => $v) {
                ?>
                <tr>
                    <td><?=$key;?></td>
                    <td><?php echo $v;?></td>
                    <td><?php echo implode("<br>", $final[$key]);?></td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</html>