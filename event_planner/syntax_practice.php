<?php
// 1. PHP OPENING TAG: Tells the server to process backend logic.

// SYNTAX PRACTICE: Variable declaration always starts with a '$' sign.
$student_name = "Maysoon"; 
$is_logged_in = true;

// SYNTAX PRACTICE: Arrays store multiple values. Database rows come back as arrays.
$sample_event_row = [
    'title'    => 'Global AI & Web Summit 2026',
    'price'    => 3500,
    'category' => 'Technology'
];

// SYNTAX PRACTICE: Conditional structures (if / else statements)
if ($sample_event_row['price'] == 0) {
    // String Assignment
    $price_text = "FREE"; 
} else {
    // String Concatenation using the dot (.) operator and number_format() function
    $price_text = "KSh " . number_format($sample_event_row['price'], 0);
}

// 2. CLOSING TAG: Exits PHP mode to allow plain HTML structural rendering.
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>PHP Syntax Practice</title>
</head>
<body>

    <div class="welcome-banner">
        <h1>Welcome Back, <?php echo $student_name; ?>!</h1>
    </div>

    <div class="event-card-preview">
        <h3><?php echo $sample_event_row['title']; ?></h3>
        
        <p>Category: <strong><?php echo $sample_event_row['category']; ?></strong></p>
        
        <p>Admission: <span><?php echo $price_text; ?></span></p>
    </div>

</body>
</html>