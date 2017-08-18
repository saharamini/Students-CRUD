<?php

require('database.php');

$search="";

if(isset($_POST['submit'])) {
// first name
    $student_fname = filter_input(INPUT_POST, 'fname');
// last name
    $student_lname = filter_input(INPUT_POST, 'lname');
// student id
    $student_id = filter_input(INPUT_POST, 'student_id', FILTER_VALIDATE_INT);

    if($student_id != "") {
        // Get student
        $queryID = 'SELECT * FROM students WHERE studentID = :id';
        $statement = $db->prepare($queryID);
        $statement->bindValue(':id', $student_id);
        $statement->execute();
        $search = $statement->fetchAll();
        $statement->closeCursor();
    }
    elseif($student_fname != ""){
        // Get student
        $queryFN = 'SELECT * FROM students WHERE firstname LIKE :fname
              ORDER BY studentID';
        $statement1 = $db->prepare($queryFN);
        $statement1->bindValue(':fname', '%'.$student_fname.'%');
        $statement1->execute();
        $search = $statement1->fetchAll();
        $statement1->closeCursor();
    }

    elseif($student_lname != ""){
        // Get student
        $queryLN = 'SELECT * FROM students WHERE lastname LIKE :lname
              ORDER BY studentID';
        $statement2 = $db->prepare($queryLN);
        $statement2->bindValue(':lname', '%'.$student_lname.'%');
        $statement2->execute();
        $search = $statement2->fetchAll();
        $statement2->closeCursor();
    }
    else{
        // Get all students
        $queryAll = 'SELECT * FROM students ORDER BY studentID';
        $statement3 = $db->prepare($queryAll);
        $statement3->execute();
        $search = $statement3->fetchAll();
        $statement3->closeCursor();
    }
}
?>
<!DOCTYPE html>
<html>
    <!-- the head section -->
    <head>
        <title>Search</title>
        <link rel="stylesheet" type="text/css" href="stylesheets/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="stylesheets/main.css" />
    </head>
    <!-- the body section -->
    <body>
    <header>
        <h1>Search Page</h1>
    </header>
	  <!-- search student -->
    <form action=<?php echo $_SERVER['PHP_SELF']; ?> method="post" style="display:inline-flex;">
		<div class="panel panel-primary form" style="margin-right: 10px;">
            <div class="panel-heading"><h4>Search by student ID</h4></div>
				<div class="panel-body">
					<label>Student ID:</label>
					<input class="form-control" type="text" name="student_id">
				</div>
		</div>
        <div class="panel panel-primary form" style="margin-right: 10px;">
            <div class="panel-heading"><h4>Search by first name</h4></div>
				<div class="panel-body">
					<label>First Name:</label>
					<input class="form-control" type="text" name="fname">
				</div>
		</div>
		<div class="panel panel-primary form">
            <div class="panel-heading"><h4>Search by last name</h4></div>
            <div class="panel-body">
				<label>Last Name:</label>
				<input class="form-control" type="text" name="lname"> 
			</div>
		</div>
		<div class="form-group" style="margin-top:50px;">
			<input class="btn btn-info" type="submit" name="submit" value="Search" style="margin-bottom: 10px;"/>
			<input class="btn btn-warning" type="button" onclick="location.href='index.html';" value="Go Back" />
		</div>
    </form>
    </div>
    <div>
        <br>
        <?php if(!empty($search)): ?>
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Student ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email Address</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
			</thead>
			<tbody>
                <?php foreach( $search as $student ) : ?>
                    <tr>
                        <td><?php echo $student['studentID']; ?></td>
                        <td><?php echo $student['firstname']; ?></td>
                        <td><?php echo $student['lastname']; ?></td>
                        <td><?php echo $student['email']; ?></td>
                        <td>
                            <form action="edit_student.php" method="post">
                                <input type="hidden" name="student_id" value="<?php echo $student['studentID']; ?>">
                                <input class="btn btn-success" type="submit" value="Edit">
                            </form>
                        </td>
                        <td>
                            <form action="delete_student.php" method="post">
                                <input type="hidden" name="student_id" value="<?php echo $student['studentID']; ?>">
                                <input class="btn btn-danger" type="submit" value="Delete">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
			</tbody>
        </table>
        <?php endif; ?>
    </div>
    </body>
</html>