<?php
/**
 * Created by PhpStorm.
 * User: sumeet
 * Date: 18/1/17
 * Time: 12:57 AM
 */

define('USERNAME', 'puzzle_hunt');
define('PASSWORD', 'Puzzle_Hunt');
define('SERVER', 'localhost');
define('DB_NAME', 'puzzle_hunt');
define('QUESTION_COUNT', 8);

function getCurrentTime()
{
    return date("Y-m-d H:i:s");
}

function getConnection()
{
    $conn = mysqli_connect(SERVER, USERNAME, PASSWORD, DB_NAME);
    if (!$conn)
        die('Cannot connect to DB' . mysqli_connect_error());
    return $conn;
}

function closeConnection($conn)
{
    mysqli_close($conn);
}

function createNewUser($name, $phone)
{
    $conn = getConnection();
    $query = "INSERT INTO users (name, phone_number, creation_date) VALUES ('$name', $phone, '" . getCurrentTime() . "')";

    if (mysqli_query($conn, $query)) {
        $user_id = mysqli_insert_id($conn);
    } else {
        die('Cannot create user' . mysqli_connect_error());
    }
    closeConnection($conn);
    return $user_id;
}

function getUserDetails($name, $phone)
{
    $conn = getConnection();
    $query = "SELECT * from users where name = '" . $name . "' and phone_number = '" . $phone . "'";

    $userDetails = array();
    $result = mysqli_query($conn, $query);
    if ($result) {

        if ($row = mysqli_fetch_assoc($result)) {
            closeConnection($conn);
            array_push($userDetails, $row);
            $userDetails = $userDetails[0];
        }

    } else {
        die('Cannot get user details' . mysqli_connect_error());
    }
    return $userDetails;
}

function getRandomQuestion()
{
    $conn = getConnection();
    $query = "SELECT * from questions";

    $questionSet = array();
    $result = mysqli_query($conn, $query);
    if ($result) {

        while ($row = mysqli_fetch_assoc($result)) {
            $questionSet[$row['id'] . ""] = array(
                'question' => $row['question'] . "",
                'code' => $row['code'] . "",
                'destination' => $row['destination'] . "",
                'answer' => explode(",", $row['answer']
                )
            );
        }

    } else {
        die('Cannot get question details' . mysqli_connect_error());
    }
    closeConnection($conn);

    $min = 99999999;
    $max = 0;
    foreach ($questionSet as $id => $question) {
        if ($id <= $min) {
            $min = $id;
        }
        if ($id >= $max) {
            $max = $id;
        }
    }

    $randSeq = array();
    $randQuestion = array();

    $i = 0;
    while ($i < QUESTION_COUNT) {
        $r = rand($min, $max);
        if (!in_array($r, $randSeq)) {
            $i++;
            $questionSet[$r]['rank'] = $i;
            $questionSet[$r]['id'] = $r;
            array_push($randSeq, $r);
            array_push($randQuestion, $questionSet[$r]);
        }
    }

    return $randQuestion;
}

function storeRandomQuestion($userId, $questions)
{
    $conn = getConnection();
    $query = "INSERT INTO user_question_mapping (user_id,destination, code, question_id, rank) VALUES";
    foreach ($questions as $question) {
        $query .= "(" . $userId . "," . $question['destination'] . "," . $question['code'] . "," . $question['id'] . "," . $question['rank'] . "),";
    }
    $query = trim($query, ",");

    if (mysqli_query($conn, $query)) {

    } else {
        die('Cannot insert random sequence' . mysqli_connect_error());
    }
    closeConnection($conn);
}

function getNextQuestionForUser($userId)
{
    $conn = getConnection();
    $query = '';
    $query .= "select b.*,a.rank ";
    $query .= "from user_question_mapping a ";
    $query .= "join questions b ";
    $query .= "on a.question_id = b.id ";
    $query .= "where a.user_id = '" . $userId . "' ";
    $query .= "and a.status = 0 ";
    $query .= "order by rank ";
    $query .= "limit 1";

    $result = mysqli_query($conn, $query);
    if ($result) {

        if ($row = mysqli_fetch_assoc($result)) {
            closeConnection($conn);
            $finalResult = array($row);
            return $finalResult[0];
        }

    } else {
        die('Cannot get question details' . mysqli_connect_error());
    }
    return false;
}

function markQuestionCompleted($userId, $questionId)
{
    $conn = getConnection();
    $query = "update user_question_mapping set status = 1, completed_time = '" . getCurrentTime() . "' where user_id = $userId and question_id = $questionId";

    if (mysqli_query($conn, $query)) {
        $user_id = mysqli_insert_id($conn);
    } else {
        die('Cannot mark question completed' . mysqli_connect_error());
    }
    closeConnection($conn);
    return $user_id;
}

function updateCompletedTime($userId)
{
    $conn = getConnection();
    $query = "update users set completed = 1, hunt_completed_time = '" . getCurrentTime() . "' where id = $userId";

    if (mysqli_query($conn, $query)) {
        $user_id = mysqli_insert_id($conn);
    } else {
        die('Cannot update completion time' . mysqli_connect_error());
    }
    closeConnection($conn);
    return $user_id;
}

function getUserStatus()
{
    $conn = getConnection();
    $query = "";
    $query .= "SELECT *  ";
    $query .= "from users a ";
    $query .= "join user_question_mapping b ";
    $query .= "on a.id = b.user_id ";
    $query .= "order by a.id , b.rank ";

    $userStatus = array();
    $result = mysqli_query($conn, $query);
    if ($result) {

        while ($row = mysqli_fetch_assoc($result)) {
            array_push($userStatus, $row);
        }

    } else {
        die('Cannot get user Status' . mysqli_connect_error());
    }
    closeConnection($conn);
    return $userStatus;
}

function getWinnerStatus()
{

    $conn = getConnection();
    $query = "";
    $query .= "select *  ";
    $query .= "from users ";
    $query .= "where completed = 1 ";
    $query .= "order by cast(hunt_completed_time as DATETIME) desc ";

    $winnerStatus = array();
    $result = mysqli_query($conn, $query);
    if ($result) {

        while ($row = mysqli_fetch_assoc($result)) {
            array_push($winnerStatus, $row);
        }

    } else {
        die('Cannot get winner Status' . mysqli_connect_error());
    }
    closeConnection($conn);
    return $winnerStatus;
}