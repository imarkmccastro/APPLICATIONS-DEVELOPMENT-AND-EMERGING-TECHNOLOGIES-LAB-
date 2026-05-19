<?php
// header.php — loaded with require() because it is critical for page structure
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="grid-container">

    <div class="header">
        <h1>Student Resume</h1>
    </div>

    <div class="main">

        <!-- Profile area: photo + personal info label -->
        <div class="profile-area">
            <div class="profile-photo">
                <!-- Silhouette placeholder -->
                <svg width="100" height="100" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="50" cy="35" r="22" fill="#555"/>
                    <ellipse cx="50" cy="85" rx="35" ry="22" fill="#555"/>
                </svg>
            </div>
            <div class="profile-info">Personal Information</div>
        </div>

        <!-- Navigation links to each section -->
        <div class="nav-links">
            <a href="index.php" <?php if($pageTitle == "Personal Information") echo 'class="active"'; ?>>&#8226; Personal Information</a>
            <a href="career_objective.php" <?php if($pageTitle == "Career Objective") echo 'class="active"'; ?>>&#8226; Career Objective</a>
            <a href="educational_attainment.php" <?php if($pageTitle == "Educational Attainment") echo 'class="active"'; ?>>&#8226; Educational Attainment page</a>
            <a href="skills.php" <?php if($pageTitle == "Skills") echo 'class="active"'; ?>>&#8226; Skills page</a>
            <a href="affiliation.php" <?php if($pageTitle == "Affiliation") echo 'class="active"'; ?>>&#8226; Affiliation page</a>
            <a href="work_experience.php" <?php if($pageTitle == "Work Experience") echo 'class="active"'; ?>>&#8226; Work Experience Page</a>
        </div>

        <!-- Section content starts here -->
        <div class="section-content">
