<?php

require('database.php');

// student id
$student_id = filter_input(INPUT_POST, 'student_id', FILTER_VALIDATE_INT);

// Get student
$queryStudent = 'SELECT * FROM students WHERE studentID = :id';
$statement3 = $db->prepare($queryStudent);
$statement3->bindValue(':id', $student_id);
$statement3->execute();
$student = $statement3->fetch();
$statement3->closeCursor();

$error_messages=[];


if(isset($_POST['submit'])){
    // first name
    $fname = filter_input(INPUT_POST, 'fname');
    // last name
    $lname = filter_input(INPUT_POST, 'lname');
    // email
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

    $stID = filter_input(INPUT_POST, 'stID', FILTER_VALIDATE_INT);

    // Update student
    $query = 'UPDATE students 
              SET firstname= :first_name,
                  lastname= :last_name,
                  email= :e_mail
              WHERE studentID = :id';

    $statement1 = $db->prepare($query);
    $statement1->bindValue(':first_name', $fname);
    $statement1->bindValue(':last_name', $lname);
    $statement1->bindValue(':e_mail', $email);
    $statement1->bindValue(':id', $stID);
    $statement1->execute();
    $statement1->closeCursor();

	$message = "The information is updated successfully";
    // Display the Students List page
    //header("Location: students_list.php");
	require("students_list.php");
	exit();
}
?>

<!DOCTYPE html>
<html>
<!-- the head section -->
    <head>
        <title>Edit Student</title>
        <link rel="stylesheet" type="text/css" href="stylesheets/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="stylesheets/main.css" />
    </head>
    <!-- the body section -->
    <body>
        <header>
            <h1>Update Student's Information</h1>
        </header>
        <div class="panel panel-primary form">
            <div class="panel-heading"><h3>Form</h3></div>
            <div class="panel-body">
            <!-- update student -->
            <form action=<?php echo $_SERVER['PHP_SELF']; ?> method="post">
                <div class="form-group">
					<label>First Name:</label>
					<input class="form-control" required type="text" name="fname" value="<?php echo $student['firstname']?>">
				</div>
				<div class="form-group">
					<label>Last Name:</label>
					<input class="form-control" required type="text" name="lname" value="<?php echo $student['lastname']?>"> 
				</div>
				<div class="form-group">
					<label>Email Address:</label>
					<input class="form-control" required type="email" name="email" value="<?php echo $student['email']?>"> 
				</div>
                <input type="hidden" name="stID" value="<?php echo $student['studentID']?>">
         
                <div class="form-group">
                    <input type="submit" name="submit" value="Update" class="btn btn-success"/>
                    <input type="button" onclick="location.href='students_list.php';" value="Go Back" class="btn btn-warning"/>
                </div>
            </form>
        </div>
    </body>
</html>
