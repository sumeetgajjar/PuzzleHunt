<?php
/**
 * Created by PhpStorm.
 * User: sumeet
 * Date: 18/1/17
 * Time: 12:57 AM
 */
define('QUESTION_COUNT', 8);


function getCurrentTime()
{
    return date("Y-m-d H:i:s");
}

function getConnection()
{
    $conn = pg_connect(getenv("DATABASE_URL"));
    if (!$conn)
        die('Cannot connect to DB ' . pg_last_error());
    return $conn;
}

function closeConnection($result, $conn)
{
    pg_free_result($result);
    pg_close($conn);
}

function createNewUser($name, $phone)
{
    $conn = getConnection();
    $query = "INSERT INTO users (name, phone_number, creation_date) VALUES ('$name', $phone, '" . getCurrentTime() . "') returning id";

    $result = pg_query($conn, $query);
    if ($result) {
        if ($row = pg_fetch_assoc($result)) {
            $user_id = $row['id'];
        } else {
            die('Cannot create user ' . pg_last_error());
        }

    } else {
        die('Cannot create user ' . pg_last_error());
    }
    closeConnection($result, $conn);
    return $user_id;
}

function getUserDetails($name, $phone)
{
    $conn = getConnection();
    $query = "SELECT * from users where name = '" . $name . "' and phone_number = '" . $phone . "'";

    $userDetails = array();
    $result = pg_query($conn, $query);
    if ($result) {

        if ($row = pg_fetch_assoc($result)) {
            array_push($userDetails, $row);
            $userDetails = $userDetails[0];
        }

    } else {
        die('Cannot get user details ' . pg_last_error());
    }
    closeConnection($result, $conn);
    return $userDetails;
}

function getRandomQuestion()
{
    $conn = getConnection();
    $query = "SELECT * from questions";

    $questionSet = array();
    $result = pg_query($conn, $query);
    if ($result) {

        while ($row = pg_fetch_assoc($result)) {
            $questionSet[$row['id'] . ""] = array(
                'question' => $row['question'] . "",
                'code' => $row['code'] . "",
                'destination' => $row['destination'] . "",
                'answer' => explode(",", $row['answer']
                )
            );
        }

    } else {
        die('Cannot get question details ' . pg_last_error());
    }
    closeConnection($result, $conn);

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

    $result = pg_query($conn, $query);
    if ($result) {

    } else {
        die('Cannot insert random sequence ' . pg_last_error());
    }
    closeConnection($result, $conn);
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

    $result = pg_query($conn, $query);
    if ($result) {

        if ($row = pg_fetch_assoc($result)) {
            $finalResult = array($row);
            closeConnection($result, $conn);
            return $finalResult[0];
        }

    } else {
        die('Cannot get question details ' . pg_last_error());
    }
    return false;
}

function markQuestionCompleted($userId, $questionId)
{
    $conn = getConnection();
    $query = "update user_question_mapping set status = 1, completed_time = '" . getCurrentTime() . "' where user_id = $userId and question_id = $questionId";

    $result = pg_query($conn, $query);
    if ($result) {

    } else {
        die('Cannot mark question completed ' . pg_last_error());
    }
    closeConnection($result, $conn);
}

function updateCompletedTime($userId)
{
    $conn = getConnection();
    $query = "update users set completed = 1, hunt_completed_time = '" . getCurrentTime() . "' where id = $userId";

    $result = pg_query($conn, $query);
    if ($result) {

    } else {
        die('Cannot update completion time ' . pg_last_error());
    }
    closeConnection($result, $conn);
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
    $result = pg_query($conn, $query);
    if ($result) {

        while ($row = pg_fetch_assoc($result)) {
            array_push($userStatus, $row);
        }

    } else {
        die('Cannot get user Status ' . pg_last_error());
    }
    closeConnection($result, $conn);
    return $userStatus;
}

function getWinnerStatus()
{

    $conn = getConnection();
    $query = "";
    $query .= "select id,name,phone_number, ";
    $query .= "cast(hunt_completed_time as timestamp) - cast(creation_date as timestamp) as total_time, ";
    $query .= "creation_date , hunt_completed_time ";
    $query .= "from users ";
    $query .= "where completed = 1 ";
    $query .= "order by total_time ";

    $winnerStatus = array();
    $result = pg_query($conn, $query);
    if ($result) {

        while ($row = pg_fetch_assoc($result)) {
            array_push($winnerStatus, $row);
        }

    } else {
        die('Cannot get winner Status ' . pg_last_error());
    }
    closeConnection($result, $conn);
    return $winnerStatus;
}