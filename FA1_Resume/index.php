<?php
$fullName = "Mark Benedict Castro";
$location = "Manila, Philippines";
$phoneNumber = "+63 912 345 6789";
$emailAddress = "mark.benedict.castro@gmail.com";
$website = "https://markbenedictcastro.com";

$expertise = [
    "Web development and responsive layout",
    "Frontend design and styling",
    "Backend scripting with PHP",
    "Database handling and data entry",
    "Problem solving and debugging",
    "Documentation and reporting",
    "Collaborative class projects",
    "Time management and organization",
    "Continuous learning in IT",
];

$technicalSkills = [
    "HTML5 and semantic markup",
    "CSS3 and responsive layout",
    "PHP and server-side scripting",
    "JavaScript fundamentals",
    "Python programming basics",
    "MySQL database basics",
];

$references = [
    [
        "name" => "Academic Adviser",
        "position" => "Faculty Reference",
        "email" => "Available upon request",
        "website" => "FEU Institute of Technology",
    ],
    [
        "name" => "Programming Instructor",
        "position" => "Technical Reference",
        "email" => "Available upon request",
        "website" => "BSIT Coursework",
    ],
    [
        "name" => "Project Peer",
        "position" => "Student Reference",
        "email" => "Available upon request",
        "website" => "Group Project Collaboration",
    ],
];

$profile = [
    "BSIT student focused on web and application development with a strong interest in building clean and functional interfaces.",
    "Comfortable working with PHP, HTML, CSS, JavaScript, Python, and MySQL for school requirements and hands-on projects.",
    "Developing problem-solving, documentation, and teamwork skills through coursework and project-based learning.",
    "Motivated to keep improving technical skills and apply them to practical systems that solve real problems.",
];

$experience = [
    [
        "title" => "Student Developer",
        "company" => "Academic Projects",
        "date" => "2024 - Present",
        "details" => [
            "Built responsive school outputs and practice pages using PHP, HTML, and CSS.",
            "Applied semantic structure, clean layout, and basic validation techniques.",
            "Improved code organization through repeated revisions and feedback.",
        ],
    ],
    [
        "title" => "Project Collaborator",
        "company" => "Group Assignments",
        "date" => "2024 - Present",
        "details" => [
            "Worked with classmates on programming tasks, presentations, and documentation.",
            "Contributed to task planning, debugging, and checking output quality.",
            "Practiced teamwork, communication, and time management in shared deliverables.",
        ],
    ],
    [
        "title" => "Independent Learner",
        "company" => "Self-Study and Labs",
        "date" => "2025 - Present",
        "details" => [
            "Practiced Python, JavaScript, and MySQL through guided exercises.",
            "Strengthened problem-solving skills by troubleshooting layout and code issues.",
            "Continues to build confidence in developing practical technical outputs.",
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
                    <h2>Technical Skills</h2>
                    <ul class="blank-list compact">
                        <?php foreach ($technicalSkills as $skill) { ?>
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
                    <div class="section-toolbar section-toolbar--education">
                        <div class="section-heading">
                            <h2>Educational Qualification</h2>
                        </div>
                    </div>
                    <?php foreach ($education as $school) { ?>
                        <article class="education-item education-item--modern">
                            <div class="education-copy">
                                <div class="education-meta">
                                    <span class="education-level"><?php echo displayText($school["level"]); ?></span>
                                    <span class="education-date"><?php echo displayText($school["date"]); ?></span>
                                </div>
                                <h3 class="degree"><?php echo displayText($school["degree"]); ?></h3>
                                <?php if (!empty($school["school"])) { ?>
                                    <div class="school"><?php echo displayText($school["school"]); ?></div>
                                <?php } ?>
                            </div>
                        </article>
                    <?php } ?>
                </section>

                <section class="section">
                    <div class="section-toolbar">
                        <h2>Certifications</h2>
                    </div>
                    <?php foreach ($certifications as $certification) { ?>
                        <article class="certification-item certification-item--modern">
                            <div class="certification-copy">
                                <?php if (!empty($certification["status"])) { ?>
                                    <div class="certification-status"><?php echo displayText($certification["status"]); ?></div>
                                <?php } ?>
                                <h3 class="certification-title"><?php echo displayText($certification["title"]); ?></h3>
                                <div class="certification-meta">Awarded by <?php echo displayText($certification["issuer"]); ?> on <?php echo displayText($certification["date"]); ?></div>
                            </div>
                        </article>
                    <?php } ?>
                </section>
            </section>
        </div>
    </main>
</body>
</html>
