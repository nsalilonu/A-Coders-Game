<!DOCTYPE html>
<html>
<body>

<?php
// References:
// https://www.php.net/manual/en/function.header.php
// https://www.w3schools.com/php/php_form_validation.asp

// Formats text input.
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = strtolower($data);
    return $data;
  }

// Get user input. 
$answer1 = test_input($_GET["answer1"]);
$answer2 = test_input($_GET["answer2"]);
$host  = $_SERVER['HTTP_HOST'];

$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$referer = $_SERVER['HTTP_REFERER'];

// Make sure that answer 2 is a number. If it isn't, redirect back to the previous coding page.
if (!is_numeric($answer2) && $answer2 != "") {
    header("Location: $referer");
    exit;
}

else if (is_numeric($answer2)) {
    $answer2 = (int)$answer2;
}

// Check if the answer is correct if coming from the original coding page.
if ($answer1 == "true" && strpos($referer, "codeLevel1.php")) {
    // Delete the cookie for the number of mistakes if they made a mistake.
    if ($_COOKIE["mistakes"] !== "0") {
        setcookie("mistakes", "0", 0, "/");
    }
    
    $extra = 'codeLevel1_1.php';
    header("Location: http://$host$uri/$extra");
    exit;
}


if ($answer2 == 6  && strpos($referer, "codeLevel1.php")) {
    if ($_COOKIE["mistakes"] !== "0") {
        setcookie("mistakes", "0", 0, "/");
    }
    $extra = 'codeLevel1_2.php';
    header("Location: http://$host$uri/$extra");
    exit;
}

// Check if the answer is correct if coming from the new coding pages.
if ($answer1 == "true" && strpos($referer, "codeLevel1_2.php")) {
    $extra = 'codeLevel1End.php';
    header("Location: http://$host$uri/$extra");
    exit;
    }
    
    
if ($answer2 == 6  && strpos($referer, "codeLevel1_1.php")) {
    $extra = 'codeLevel1End.php';
    header("Location: http://$host$uri/$extra");
    exit;
}

// If either answer is incorrect, then display the old HTML page and send an error message.
// Let old HTML page know that there's been an error by setting a cookie.
else {
    $count = (int)$_COOKIE["mistakes"] + 1;
    setcookie("mistakes", $count, 0, "/");
    header("Location: $referer");
    exit;
}
?>

<br>
</body>
</html>