<?php
require('database.php');

$error_messages=[];
$message='';

// first name
$fname = filter_input(INPUT_POST, 'fname');
// validate investment
if ($fname === '' ) {
    $error_messages[] = 'First name is not valid.';
}
// last name
$lname = filter_input(INPUT_POST, 'lname');
if ($lname === '' ) {
    $error_messages[] = 'Last name is not valid.';
}
// email
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
if ($email === FALSE ) {
    $error_messages[] = 'Email address is not valid.';
}


if(isset($_POST['submit']) && empty($error_messages)){

// Add student
    $queryAdd = 'INSERT INTO students (firstname,lastname,email) VALUES
                (:first_name,:last_name,:e_mail)';
    $statement1 = $db->prepare($queryAdd);
    $statement1->bindValue(':first_name', $fname);
    $statement1->bindValue(':last_name', $lname);
    $statement1->bindValue(':e_mail', $email);
    $statement1->execute();
    $statement1->closeCursor();
    $message='The student is added successfully.';
}

?>
<!DOCTYPE html>
<html>
    <!-- the head section -->
    <head>
        <title>Add Student</title>
		<link rel="stylesheet" type="text/css" href="stylesheets/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="stylesheets/main.css" />
    </head>
    <!-- the body section -->
    <body>
    <br>
        <?php if ($message != ''){ ?>
            <p class="alert alert-danger"><?php echo htmlspecialchars($message); ?></p>
        <?php } ?>
        <?php if (count($error_messages) > 0){ ?>
            <?php foreach ($error_messages as $error_message) :?>
                <p class="alert alert-danger"><?php echo htmlspecialchars($error_message); ?></p>
            <?php endforeach?>
        <?php } ?>
        <header>
            <h1>Add a new Student</h1>
        </header>
        <div class="panel panel-primary form">
            <div class="panel-heading"><h3>Form</h3></div>
            <div class="panel-body">
				<!-- add new student -->
				<form action=<?php echo $_SERVER['PHP_SELF']; ?> method="post">
				<div class="form-group">
					<label>First Name:</label>
					<input class="form-control" type="text" name="fname"> 
				</div>
				<div class="form-group">
					<label>Last Name:&nbsp;</label>
					<input class="form-control" type="text" name="lname"> 
				</div>
				<div class="form-group">
					<label>Email Address:&nbsp;</label>
					<input class="form-control" type="email" name="email"> 
				</div>
				<div class="form-group">
					<input type="submit" name="submit" value="Add" class="btn btn-success" />
					<input type="button" onclick="location.href='index.html';" value="Go Back" class="btn btn-warning"/>
				</div>
				</form>
            </div>
        </div>
    </body>
</html>