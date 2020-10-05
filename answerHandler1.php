<!DOCTYPE html>
<html>
<body>

<?php
// Get user input. 
$answer1 = test_input($_GET["answer1"]);
$answer2 = test_input($_GET["answer2"]);

// Make sure that answer 2 is a number. If it isn't, redirect back to the previous coding page.
if (!is_numeric($answer2)) {
    $host = $_SERVER['HTTP_REFERER'];
    $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    header("Location: $host");
    exit;
}

else {
    $answer2 = (int)$answer2;
}

// Check if the answer is correct.
if ($answer1 == "true") {
// If the answer is correct, then link to a new HTML page that makes the error a normal color.
// Taken from https://www.php.net/manual/en/function.header.php
$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = 'codeLevel1_1.html';
header("Location: http://$host$uri/$extra");
exit;
}

if ($answer2 >= 0.000000000001) {
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $extra = 'codeLevel1_1.html';
    header("Location: http://$host$uri/$extra");
    exit;
}

// If either answer is incorrect, then display the old HTML page.
if ($answer1 != "true" || ($answer2 <= 0.000000000001 && $answer2 != "")) {
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $extra = 'codeLevel1.html';
    header("Location: http://$host$uri/$extra");
    exit;
}

// Formats input if it's a string, taken from https://www.w3schools.com/php/php_form_validation.asp
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  $data = strtolower($data);
  return $data;
}
?>

<br>
</body>
</html>