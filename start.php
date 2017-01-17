<?php
require_once('dal/dbutil.php');
/**
 * Created by PhpStorm.
 * User: sumeet
 * Date: 18/1/17
 * Time: 1:12 AM
 */
if (checkParam('name') && checkParam('phone-number')) {

    $name = $_POST['name'];
    $phone = $_POST['phone-number'];
    $userDetail = getUserDetails($name, $phone);

    if (!$userDetail) {
        $userId = createNewUser($name, $phone);
        $userDetail = array(
            'id' => $userId,
            'name' => $name,
            'phone' => $phone
        );

        $randQuestion = getRandomQuestion();
        storeRandomQuestion($userId, $randQuestion);
    }
    $userId = $userDetail['id'];
    ?>
    <html>
    <head>
        <link rel="stylesheet" type="text/css"
              href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script type="text/javascript"
                src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    </head>
    <body>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="text-center">Welcome <?php echo $userDetail['name'] ?></h1>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 text-center pt">
                <form action="quiz.php" method="post">
                    <input type="text" name="name" value="<?php echo $name ?>" hidden>
                    <input type="text" name="phone-number" value="<?php echo $phone ?>" hidden>
                    <input type="submit" class="btn btn-success btn-lg" value="Continue the Hunt">
                </form>
            </div>
        </div>
    </div>
    </body>
    </html>
    <?php
} else {
    header('Location:index.php');
}
?>
