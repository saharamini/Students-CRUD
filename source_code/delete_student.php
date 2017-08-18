<?php

require('database.php');

// delete a student
$student_id = filter_input(INPUT_POST, 'student_id', FILTER_VALIDATE_INT);

$query = 'DELETE FROM students WHERE studentID = :id';
$statement1 = $db->prepare($query);
$statement1->bindValue(':id', $student_id);
$statement1->execute();
$statement1->closeCursor();

// Display the Students List page
header("Location: students_list.php");
?>