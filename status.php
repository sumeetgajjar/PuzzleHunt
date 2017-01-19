<?php
require_once('dal/dbutil.php');
/**
 * Created by PhpStorm.
 * User: sumeet
 * Date: 19/1/17
 * Time: 3:00 PM
 */
?>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#9500ca"/>
    <link rel="icon" type="image/png" href="css/favicon.png">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <h2 class="text-center">Winner Status</h2>
    <table class="table table-bordered table-striped table-hover table-responsive">
        <thead>
        <tr>
            <th>User ID</th>
            <th>Name</th>
            <th>Phone No</th>
            <th>Completed Time</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $winnerStatus = getWinnerStatus();
        if ($winnerStatus) {
            foreach ($winnerStatus as $key => $value) {
                echo '<tr>';
                echo '<td>' . $value['id'] . '</td>';
                echo '<td>' . $value['name'] . '</td>';
                echo '<td>' . $value['phone_number'] . '</td>';
                echo '<td>' . $value['hunt_completed_time'] . '</td>';
                echo '</tr>';
            }
        } else {
            echo '<h4>No one completed </h4>';
        }
        ?>
        </tbody>
    </table>

    <h2 class="text-center">Complete Status</h2>
    <table class="table table-bordered table-striped table-hover table-responsive">
        <thead>
        <tr>
            <th>User ID</th>
            <th>Name</th>
            <th>Question ID</th>
            <th>Status</th>
            <th>Rank</th>
            <th>Completion Time</th>
            <th>Destination</th>
            <th>Code</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $userStatus = getUserStatus();
        foreach ($userStatus as $key => $value) {
            echo '<tr>';
            echo '<td>' . $value['user_id'] . '</td>';
            echo '<td>' . $value['name'] . '</td>';
            echo '<td>' . $value['question_id'] . '</td>';
            echo '<td>' . $value['status'] . '</td>';
            echo '<td>' . $value['rank'] . '</td>';
            echo '<td>' . $value['completed_time'] . '</td>';
            echo '<td>' . $value['destination'] . '</td>';
            echo '<td>' . $value['code'] . '</td>';
            echo '</tr>';
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>
