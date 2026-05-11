<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration Form</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #e8f0f7 0%, #f0e8f7 100%);
            padding: 20px;
            margin: 0;
        }
        
        .container {
            max-width: 850px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 40px;
            border: 2px solid #2c3e50;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            border-radius: 5px;
        }
        
        h1 {
            text-align: center;
            color: #ffffff;
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            border-bottom: 3px solid #3498db;
            padding: 20px 15px;
            margin: -40px -40px 30px -40px;
            font-size: 2em;
            letter-spacing: 1px;
            border-radius: 3px 3px 0 0;
        }
        
        fieldset {
            border: 2px solid #3498db;
            padding: 20px;
            margin-bottom: 25px;
            background: linear-gradient(to bottom, #ecf0f1 0%, #ffffff 100%);
            border-radius: 5px;
        }
        
        legend {
            padding: 8px 15px;
            color: #ffffff;
            background-color: #3498db;
            font-weight: bold;
            font-size: 1.15em;
            border-radius: 3px;
            display: inline-block;
        }
        
        .form-group {
            margin-bottom: 16px;
            padding: 12px 15px;
            background-color: #ffffff;
            border-left: 5px solid #3498db;
            border-radius: 3px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .form-group strong {
            color: #2c3e50;
            font-weight: bold;
            min-width: 180px;
            display: block;
            margin-bottom: 3px;
        }
        
        .form-group:nth-child(odd) {
            background-color: #f8f9fa;
            border-left-color: #2980b9;
        }
        
        .form-value {
            color: #555555;
            line-height: 1.6;
            flex: 1;
        }
        
        /* Color coding for different sections */
        fieldset:nth-of-type(1) legend {
            background-color: #3498db;
        }
        
        fieldset:nth-of-type(2) legend {
            background-color: #2ecc71;
        }
        
        fieldset:nth-of-type(3) legend {
            background-color: #e74c3c;
        }
        
        fieldset:nth-of-type(4) legend {
            background-color: #f39c12;
        }
        
        fieldset:nth-of-type(5) legend {
            background-color: #9b59b6;
        }
        
        fieldset:nth-of-type(1) {
            border-color: #3498db;
        }
        
        fieldset:nth-of-type(2) {
            border-color: #2ecc71;
        }
        
        fieldset:nth-of-type(3) {
            border-color: #e74c3c;
        }
        
        fieldset:nth-of-type(4) {
            border-color: #f39c12;
        }
        
        fieldset:nth-of-type(5) {
            border-color: #9b59b6;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Student Registration Form</h1>
        
        <?php
        // Personal Information
        $fullName = "Mark Benedict Castro";
        $location = "Manila, Philippines";
        $phoneNumber = "+63 912 345 6789";
        $emailAddress = "mocastro@fit.edu.ph";
        $website = "lumastrip-vercel.app";
        
        // Academic Information
        $studentID = "202410198";
        $program = "Bachelor of Science in Information Technology";
        $yearLevel = "2nd Year";
        $gpa = "3.85";
        
        // Emergency Contact
        $emergencyName = "Mercy Castro";
        $emergencyRelation = "Mother";
        $emergencyPhone = "+63 912 345 6790";
        $emergencyAddress = "Subic, Zambales, Philippines";
        
        // Course Information
        $enrollmentDate = "August 15, 2024";
        $expectedGraduation = "May 30, 2028";
        $tuitionStatus = "Fully Paid";
        $scholarshipStatus = "Not Available";
        
        // Additional Information
        $languages = "English, Tagalog, Spanish";
        $skills = "PHP, Python, JavaScript, Database Design";
        $activities = "ACM, AITS";
        $achievements = "With High Honor, Best Capstone Project (2024   ) Biology Science";
        ?>
        
        <fieldset>
            <legend>Personal Information</legend>
            <div class='form-group'><strong>Full Name:</strong> <span class='form-value'><?php echo strtoupper($fullName); ?></span></div>
            <div class='form-group'><strong>Location:</strong> <span class='form-value'><?php echo ucwords($location); ?></span></div>
            <div class='form-group'><strong>Phone Number:</strong> <span class='form-value'><?php echo $phoneNumber; ?></span></div>
            <div class='form-group'><strong>Email Address:</strong> <span class='form-value'><?php echo strtolower($emailAddress); ?></span></div>
            <div class='form-group'><strong>Website:</strong> <span class='form-value'><?php echo strtolower($website); ?></span></div>
        </fieldset>
        
        <fieldset>
            <legend>Academic Information</legend>
            <div class='form-group'><strong>Student ID:</strong> <span class='form-value'><?php echo $studentID; ?></span></div>
            <div class='form-group'><strong>Program:</strong> <span class='form-value'><?php echo ucwords($program); ?></span></div>
            <div class='form-group'><strong>Year Level:</strong> <span class='form-value'><?php echo ucwords($yearLevel); ?></span></div>
            <div class='form-group'><strong>GPA:</strong> <span class='form-value'><?php echo number_format(floatval($gpa), 2); ?></span></div>
        </fieldset>
        
        <fieldset>
            <legend>Emergency Contact</legend>
            <div class='form-group'><strong>Contact Name:</strong> <span class='form-value'><?php echo strtoupper($emergencyName); ?></span></div>
            <div class='form-group'><strong>Relation:</strong> <span class='form-value'><?php echo ucwords($emergencyRelation); ?></span></div>
            <div class='form-group'><strong>Phone Number:</strong> <span class='form-value'><?php echo $emergencyPhone; ?></span></div>
            <div class='form-group'><strong>Address:</strong> <span class='form-value'><?php echo ucwords($emergencyAddress); ?></span></div>
        </fieldset>
        
        <fieldset>
            <legend>Course Information</legend>
            <div class='form-group'><strong>Enrollment Date:</strong> <span class='form-value'><?php echo date('F d, Y', strtotime($enrollmentDate)); ?></span></div>
            <div class='form-group'><strong>Expected Graduation:</strong> <span class='form-value'><?php echo date('F d, Y', strtotime($expectedGraduation)); ?></span></div>
            <div class='form-group'><strong>Tuition Status:</strong> <span class='form-value'><?php echo strtoupper($tuitionStatus); ?></span></div>
            <div class='form-group'><strong>Scholarship Status:</strong> <span class='form-value'><?php echo ucwords($scholarshipStatus); ?></span></div>
        </fieldset>
        
        <fieldset>
            <legend>Additional Information</legend>
            <div class='form-group'><strong>Languages:</strong> <span class='form-value'><?php echo ucwords($languages); ?></span></div>
            <div class='form-group'><strong>Skills:</strong> <span class='form-value'><?php echo strtoupper($skills); ?></span></div>
            <div class='form-group'><strong>Activities:</strong> <span class='form-value'><?php echo strtoupper($activities); ?></span></div>
            <div class='form-group'><strong>Achievements:</strong> <span class='form-value'><?php echo ucwords($achievements); ?></span></div>
        </fieldset>
    </div>
</body>
</html>
