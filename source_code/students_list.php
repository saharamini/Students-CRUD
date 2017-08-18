<?php

require('database.php');

$query1 = 'SELECT * FROM students';
$statement1 = $db->prepare($query1);
$statement1->execute();
// counting number of page - get number of rows - show 15 rows each page
$count = $statement1->rowCount();
$eachPage = ceil($count/15);
$statement1->closeCursor();

$page = @$_GET["page"];

if($page =="" || $page =="1" ){
    $pageNum =0;
}

else{
    $pageNum=($page*15)-15;
}

// if user enters a page number which is greater than number of pages
if($page > $eachPage){
    $pageNum =0;
}

// Get all students
$query = 'SELECT * FROM students Orders LIMIT 15 OFFSET :pagenumber';
$statement = $db->prepare($query);
//$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$statement->bindValue(':pagenumber', $pageNum, PDO::PARAM_INT);
$statement->execute();
$students = $statement->fetchAll();
$statement->closeCursor();

?>
<!DOCTYPE html>
<html>
<!-- the head section -->
    <head>
        <title>Studetns List</title>
        <link rel="stylesheet" type="text/css" href="stylesheets/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="stylesheets/main.css" />
    </head>
    <!-- the body section -->
    <body>
	<br/>
        <?php if (@$message != ''){ ?>
                <p class="alert alert-danger"><?php echo htmlspecialchars($message); ?></p>
        <?php } ?>
        <!-- student list -->
        <header>
            <h1>Student Lists</h1>
        </header>
        <?php if (count($students) == 0) : ?>
            <p class="alert alert-danger">The list is empty.</p>
        <?php else: ?>
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
                    <?php foreach( $students as $student ) : ?>
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
        <!-- page number-->
        <ul class="pagination">
        <?php
        for($i=1; $i<=$eachPage; $i++):
            ?>
            <li>
                <a href="students_list.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
            <?php
        endfor;
        ?>
        </ul>
        <div class="form-group">
            <input type="button" onclick="location.href='index.html';" value="Go Back" class="btn btn-warning"/>
        </div>
    </body>
</html>