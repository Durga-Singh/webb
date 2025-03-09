<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body>
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

    <section class="custom-case-section">
        <div class="container">
            <div class="custom-case-content">
                <div class="text-area">
                    <span class="your-image-text"><img src="https://www.casecobra.com/snake-1.png" alt=""></span>
                    <h1>Your Image on a <span class="custom-text">Custom Phone Case</span></h1>
                    <p>Capture your favorite memories with your own, one-of-one phone case. CaseCobra allows you to protect your memories, not just your phone case.</p>
                    <ul class="features">
                        <li><i class="fas fa-check"></i> High-quality, durable material</li>
                        <li><i class="fas fa-check"></i> 5 year print guarantee</li>
                        <li><i class="fas fa-check"></i> Modern iPhone models supported</li>
                    </ul>
                    <div class="review-area">
                        <div class="stars">
                            <i class="fas fa-star"></i>
                        </div>
                        <p>1,250+ happy customers</p>
                    </div>
                </div>
                <div class="image-area">
                    <img src="your-image.png" alt="your-image" class="your-image" style=" width: 163px;">
                    <img src="dog.png" alt="Custom Phone Case">
                </div>
            </div>
        </div>
    </section>
</body>

</html>