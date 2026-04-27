<?php
$fullName = "Mark Benedict Castro";
$location = "Manila, Philippines";
$phoneNumber = "+63 912 345 6789";
$emailAddress = "mark.benedict.castro@example.com";
$website = "https://markbenedictcastro.com";

$expertise = [
    "",
    "",
    "",
    "",
    "",
    "",
    "",
    "",
    "",
];

$operationalSkills = [
    "",
    "",
    "",
    "",
    "",
    "",
];

$references = [
    [
        "name" => "",
        "position" => "",
        "email" => "",
        "website" => "",
    ],
    [
        "name" => "",
        "position" => "",
        "email" => "",
        "website" => "",
    ],
    [
        "name" => "",
        "position" => "",
        "email" => "",
        "website" => "",
    ],
];

$profile = [
    "",
    "",
    "",
    "",
];

$experience = [
    [
        "title" => "",
        "company" => "",
        "date" => "",
        "details" => [
            "",
            "",
            "",
        ],
    ],
    [
        "title" => "",
        "company" => "",
        "date" => "",
        "details" => [
            "",
            "",
            "",
        ],
    ],
    [
        "title" => "",
        "company" => "",
        "date" => "",
        "details" => [
            "",
            "",
            "",
        ],
    ],
];

$education = [
    [
        "level" => "Tertiary",
        "date" => "Aug 2024 - Present",
        "degree" => "Bachelor of Science in Information Technology",
        "school" => "Web and Applications development · FEU Institute of Technology - Tech",
    ],
    [
        "level" => "Secondary",
        "date" => "Sep 2022 - Jun 2024",
        "degree" => "Columban College - Barretto",
        "school" => "",
    ],
    [
        "level" => "Primary",
        "date" => "Jun 2012 - May 2016",
        "degree" => "International Philippine School in Al-Khobar",
        "school" => "",
    ],
];

$certifications = [
    [
        "status" => "Participant",
        "title" => "IT Specialist - Python",
        "issuer" => "Certiport",
        "date" => "March 24, 2026",
    ],
    [
        "status" => "Participant",
        "title" => "IT Specialist - JavaScript",
        "issuer" => "Certiport",
        "date" => "March 24, 2026",
    ],
    [
        "status" => "",
        "title" => "IT Specialist - Java",
        "issuer" => "Certiport",
        "date" => "November 25, 2025",
    ],
    [
        "status" => "",
        "title" => "IT Specialist - Databases",
        "issuer" => "Certiport",
        "date" => "November 11, 2025",
    ],
];

function displayText($text) {
    return htmlspecialchars($text, ENT_QUOTES, "UTF-8");
}
?>
<!DOCTYPE html>
<html lang="en">    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resume Example 2</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="resume">
        <header class="header">
            <div>
                <div class="name-line">
                    <h1 class="name"><?php echo displayText($fullName); ?></h1>
                </div>
                <div class="location"><?php echo displayText($location); ?></div>
                <div class="contact">
                    <div><?php echo displayText($phoneNumber); ?></div>
                    <div><?php echo displayText($emailAddress); ?></div>
                    <div><?php echo displayText($website); ?></div>
                </div>
            </div>
            <div class="photo"></div>
        </header>

        <div class="content">
            <aside class="sidebar">
                <section class="section">
                    <h2>Expertise</h2>
                    <ul class="blank-list">
                        <?php foreach ($expertise as $skill) { ?>
                            <li><?php echo displayText($skill); ?></li>
                        <?php } ?>
                    </ul>
                </section>

                <section class="section">
                    <h2>Operational Skills</h2>
                    <ul class="blank-list compact">
                        <?php foreach ($operationalSkills as $skill) { ?>
                            <li><?php echo displayText($skill); ?></li>
                        <?php } ?>
                    </ul>
                </section>

                <section class="section">
                    <h2>References</h2>
                    <?php foreach ($references as $reference) { ?>
                        <div class="reference">
                            <div class="reference-title"><?php echo displayText($reference["name"]); ?></div>
                            <div><?php echo displayText($reference["position"]); ?></div>
                            <div><?php echo displayText($reference["email"]); ?></div>
                            <div><?php echo displayText($reference["website"]); ?></div>
                        </div>
                    <?php } ?>
                </section>
            </aside>

            <section class="main">
                <section class="section">
                    <h2>Profile</h2>
                    <div class="profile-lines">
                        <?php foreach ($profile as $line) { ?>
                            <span class="line"><?php echo displayText($line); ?></span>
                        <?php } ?>
                    </div>
                </section>

                <section class="section">
                    <h2>Experience</h2>
                    <?php foreach ($experience as $job) { ?>
                        <article class="job">
                            <h3 class="job-title"><?php echo displayText($job["title"]); ?></h3>
                            <div class="job-meta">
                                <?php echo displayText($job["company"]); ?>
                                <?php echo displayText($job["date"]); ?>
                            </div>
                            <ul>
                                <?php foreach ($job["details"] as $detail) { ?>
                                    <li><?php echo displayText($detail); ?></li>
                                <?php } ?>
                            </ul>
                        </article>
                    <?php } ?>
                </section>

                <section class="section">
                    <h2>Education</h2>
                    <?php foreach ($education as $school) { ?>
                        <article class="education-item">
                            <div class="education-meta">
                                <span class="education-level"><?php echo displayText($school["level"]); ?></span>
                                <span class="education-date"><?php echo displayText($school["date"]); ?></span>
                            </div>
                            <h3 class="degree"><?php echo displayText($school["degree"]); ?></h3>
                            <?php if (!empty($school["school"])) { ?>
                                <div class="school"><?php echo displayText($school["school"]); ?></div>
                            <?php } ?>
                        </article>
                    <?php } ?>
                </section>

                <section class="section">
                    <h2>Certifications</h2>
                    <?php foreach ($certifications as $certification) { ?>
                        <article class="certification-item">
                            <?php if (!empty($certification["status"])) { ?>
                                <div class="certification-status"><?php echo displayText($certification["status"]); ?></div>
                            <?php } ?>
                            <h3 class="certification-title"><?php echo displayText($certification["title"]); ?></h3>
                            <div class="certification-meta">Awarded by <?php echo displayText($certification["issuer"]); ?> on <?php echo displayText($certification["date"]); ?></div>
                            <a class="credential-link" href="#" aria-label="View credential for <?php echo displayText($certification["title"]); ?>">View Credential</a>
                        </article>
                    <?php } ?>
                </section>
            </section>
        </div>
    </main>
</body>
</html>
