<?php
/**
 * Created by PhpStorm.
 * User: sumeet
 * Date: 18/1/17
 * Time: 1:05 AM
 */
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        function validate() {
            name = $('#name').val();
            phone = $('#phone-number').val();
            console.log("name=" + name + "|phone=" + phone);
            var match = phone.match(/\d/g);
            return match != null && match.length === 10;
        }
    </script>
</head>
<body>
<div class="container">
    <div class="row pt pl pr">
        <form action="start.php" method="get" class="form-horizontal" onsubmit="return validate()">
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Name</label>

                <div class="col-sm-10">
                    <input type="text" class="form-control" id="name" placeholder="Enter your Name" autofocus required>
                </div>
            </div>
            <div class="form-group">
                <label for="phone-number" class="col-sm-2 control-label">Phone Number</label>

                <div class="col-sm-10">
                    <input type="text" maxlength="10" class="form-control" id="phone-number"
                           placeholder="Enter Phone Number" required>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <input type="submit" class="btn btn-success" value="Sign in">
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>
