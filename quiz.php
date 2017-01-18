<?php
require_once('dal/dbutil.php');
require_once('util.php');
/**
 * Created by PhpStorm.
 * User: sumeet
 * Date: 18/1/17
 * Time: 3:17 AM
 */
if (checkParam('name') && checkParam('phone-number')) {

    $name = $_POST['name'];
    $phone = $_POST['phone-number'];
    $userDetail = getUserDetails($name, $phone);
    if ($userDetail) {
        $userId = $userDetail['id'];

        if (checkParam('solved') && checkParam('question-id')) {
            $questionId = $_POST['question-id'];
            markQuestionCompleted($userId, $questionId);
        }

        $question = getNextQuestionForUser($userId);
        if (!$question) {
            updateCompletedTime($userId);
            header("Location:completed.php");
        }
        ?>
        <html>
        <head>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" type="text/css"
                  href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
            <link rel="stylesheet" type="text/css" href="css/style.css">
            <script type="text/javascript"
                    src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
            <script type="text/javascript"
                    src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

            <script type="text/javascript">
                $(document).ready(function () {
                    $('#show-question').on('click', function () {
                        checkCode();
                    });

                    $('#code').keypress(function (e) {
                        var key = e.which;
                        if (key == 13) {
                            checkCode();
                        }
                    });
                });

                function checkCode() {
                    if ($('#code').val() == <?php echo $question['code'] ?>) {

                        $('.answer-div').removeClass('hidden');
                        $('.code-div').addClass('hidden');

                    } else {
                        alert('Please Enter Correct Code !!');
                    }
                }

                function checkAnswer() {
                    userAnswer = $('#user-answer').val();
                    correctAnswer = $('#correct-answer').val().split(",");
                    for (i = 0; i < correctAnswer.length; i++) {
                        if (correctAnswer[i].toLowerCase() == userAnswer.toLowerCase()) {
                            $('#solved').val('1');
                            alert('Correct answer');
                            return true;
                        }
                    }
                    alert('Incorrect answer');
                    return false;
                }
            </script>

        </head>
        <body>
        <div class="container">
            <div class="row">
                <?php print_r($question) ?>
                <div class="text-center">
                    <h2>Current question <?php echo $question['rank'] ?></h2>

                    <h2>Go to site <?php echo $question['destination'] ?></h2>

                    <h2>And Enter the Code below</h2>
                </div>
            </div>

            <div class="code-div form-group">
                <label for="code" class="col-sm-2 control-label">Code</label>

                <div class="col-sm-8">
                    <input type="text" class="form-control" id="code" name="code" placeholder="Enter the Code"
                           autofocus required>
                </div>
            </div>

            <div class="code-div form-group text-center">
                <div class="col-sm-offset-2 col-sm-8">
                    <input id="show-question" type="button" class="btn btn-primary btn-lg" value="Show Question">
                </div>
            </div>

            <form action="#" method="post" class="form-horizontal mt" onsubmit="return checkAnswer()">
                <input type="text" name="name" value="<?php echo $name ?>" hidden>
                <input type="text" name="phone-number" value="<?php echo $phone ?>" hidden>
                <input id="solved" type="text" name="solved" value="" hidden>
                <input id="question-id" type="text" name="question-id" value="<?php echo $question['id'] ?>" hidden>
                <input id="correct-answer" type="text" name="correct-answer" value="<?php echo $question['answer'] ?>"
                       hidden>

                <div class="answer-div form-group hidden">
                    <label for="answer" class="col-sm-2 control-label">Answer</label>

                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="user-answer" name="user-answer"
                               placeholder="whats your answer" required>
                    </div>
                </div>
                <div class="answer-div form-group text-center hidden">
                    <div class="col-sm-offset-2 col-sm-8">
                        <input type="submit" class="btn btn-success btn-lg" value="Submit Answer">
                    </div>
                </div>
            </form>
        </div>
        </body>
        </html>

        <?php
    }
} else {
    header('Location:index.php');
}
?>
