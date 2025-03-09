<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Case</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body id="create_case">
    <nav class="nav">
        <div class="logo">
            <p><a href="home.php"><span class="case">Case</span> <span class="cobra">Cobra</span></a></p>
        </div>
        <div class="navtwo">
            <div class="left-links">
                <a href="create_case.php">Create Case <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="right-links">
                <?php
                session_start();
                include("config.php");
                if (!isset($_SESSION['valid'])) {
                    header("Location: index.php");
                }
                $id = $_SESSION['id'];
                $query = mysqli_query($con, "SELECT * FROM users WHERE Id=$id");
                while ($result = mysqli_fetch_assoc($query)) {
                    $res_id = $result['Id'];
                }
                echo "<a href='edit.php?Id=$res_id'><i class='fas fa-user-circle profile-icon-logo'></i></a>";
              ?>
            </div>
        </div>
    </nav>

    <div class="steps-container">
        <div class="step-box">
            <div class="step active">Step 1: Add Image</div>
            <div class="step-description">Choose an image for your case</div>
        </div>
        <svg class="step-separator" viewBox="0 0 12 82" fill="none" preserveAspectRatio="none">
            <path d="M0.5 0V31L10.5 41L0.5 51V82" stroke="currentcolor" vector-effect="non-scaling-stroke"></path>
        </svg>
        <div class="step-box">
            <div class="step">Step 2: Customize design</div>
            <div class="step-description">Make the case yours</div>
        </div>
        <svg class="step-separator" viewBox="0 0 12 82" fill="none" preserveAspectRatio="none">
            <path d="M0.5 0V31L10.5 41L0.5 51V82" stroke="currentcolor" vector-effect="non-scaling-stroke"></path>
        </svg>
        <div class="step-box">
            <div class="step">Step 3: Summary</div>
            <div class="step-description">Review your final design</div>
        </div>
    </div>

    <div class="guide">
        <div class="upload-area">
            <div class="drag-drop-area">
                <i class="fas fa-cloud-upload-alt"></i>
                <p>Click to upload or drag and drop</p>
                <p>PNG, JPG, JPEG</p>
                <input type="file" id="upload" accept="image/*" hidden>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2023 All rights reserved by CaseCobra</p>
        <div class="links">
            <a href="#">Terms</a>
            <a href="#">Privacy Policy</a>
            <a href="#">Cookie Policy</a>
        </div>
    </div>

    <script src="script.js"></script>
</body>

</html>