<!DOCTYPE html>
<html>

<head>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.0/fabric.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
        <title>Summary</title>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    </head>
</head>

<body>

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
        <?php
        include("config.php");

        if (!isset($_SESSION['valid'])) {
            header("Location: index.php");
        }

        $products_file = 'products.json';
        $products = json_decode(file_get_contents($products_file), true);
        ?>

        <div class="steps-container">
            <div class="step-box">
                <div class="step active" id="step3_1">Step 1: Add Image</div>
                <div class="step-description">Choose an image for your case</div>
            </div>
            <svg class="step-separator" viewBox="0 0 12 82" fill="none" preserveAspectRatio="none">
                <path d="M0.5 0V31L10.5 41L0.5 51V82" stroke="currentcolor" vector-effect="non-scaling-stroke"></path>
            </svg>
            <div class="step-box">
                <div class="step" id="step3_2">Step 2: Customize design</div>
                <div class="step-description">Make the case yours</div>
            </div>
            <svg class="step-separator" viewBox="0 0 12 82" fill="none" preserveAspectRatio="none">
                <path d="M0.5 0V31L10.5 41L0.5 51V82" stroke="currentcolor" vector-effect="non-scaling-stroke"></path>
            </svg>
            <div class="step-box">
                <div class="step" id="step3_3">Step 3: Summary</div>
                <div class="step-description">Review your final design</div>
            </div>
        </div>

        <div class="summary_container">
            <div id="case-summary"></div>
            <div class="summary-details">
                <h2>Your iPhone 15 Case</h2>
                <div class="status">✓ In stock and ready to ship</div>

                <div class="details">
                    <div class="highlights">
                        <h3>Highlights</h3>
                        <ul>
                            <li>Wireless charging compatible</li>
                            <li>TPU shock absorption</li>
                            <li>Packaging made from recycled materials</li>
                            <li>5 year print warranty</li>
                        </ul>
                    </div>
                    <div class="materials">
                        <h3>Materials</h3>
                        <ul>
                            <li>High-quality, durable material</li>
                            <li>Scratch- and fingerprint resistant coating</li>
                        </ul>
                    </div>
                </div>

                <div class="price">
                    <div class="price-item">
                        <span>Base price</span>
                        <span>₹500.00</span>
                    </div>
                    <div class="price-item">
                        <span></span>
                        <span></span>
                    </div>
                    <div class="price-item">
                        <span></span>
                        <span></span>
                    </div>
                    <div class="order-total">
                        <span></span>
                        <span></span>
                    </div>
                </div>
                <button id="summaryDownloadButton">Download Design</button>
                <button onclick="redirectToPage()" class="checkout-button">Check out →</button>
            </div>
        </div>



        <script>
            const finalCaseImage = localStorage.getItem("finalCaseImage");
            const imgElement = document.createElement("img");

            if (finalCaseImage) {
                imgElement.src = finalCaseImage;
            } else {
                imgElement.src = "default_case_image.png";
            }

            const caseSummaryDiv = document.getElementById("case-summary");
            caseSummaryDiv.appendChild(imgElement);

            const summaryDownloadButton = document.getElementById('summaryDownloadButton');
            summaryDownloadButton.addEventListener('click', () => {
                const link = document.createElement('a');
                link.download = 'custom_phone_case.png';
                link.href = finalCaseImage;
                link.click();
            });

            document.addEventListener('DOMContentLoaded', function() {
                const selectedModel = localStorage.getItem("selectedModel");
                const modelHeading = document.querySelector(".summary-details h2"); // Select the h2 tag

                if (selectedModel && modelHeading) {
                    // Construct the heading text based on the selected model
                    const modelText = selectedModel === 'iphone12pro' ? 'iPhone 12 pro' : 'iPhone 12'; // Correcting model name
                    modelHeading.textContent = `Your ${modelText} Case`;
                }

                const selectedMaterial = localStorage.getItem("selectedMaterial");
                const selectedFinish = localStorage.getItem("selectedFinish");

                // Update material price item
                const materialPriceItem = document.querySelector('.price-item:nth-child(2)'); // Select the 2nd price-item
                if (selectedMaterial && materialPriceItem) {
                    const materialText = selectedMaterial ? `${selectedMaterial}` : 'Default material';
                    const materialPrice = selectedMaterial === 'silicone' ? 100 : 120;
                    materialPriceItem.innerHTML = `<span>${materialText}</span> <span>₹${materialPrice.toFixed(2)}</span>`;
                }

                // Update finish price item (if needed)
                const finishPriceItem = document.querySelector('.price-item:nth-child(3)');
                if (selectedFinish && finishPriceItem) {
                    const finishText = selectedFinish ? `${selectedFinish}` : 'Default finish';
                    const finishPrice = selectedFinish === 'glossy' ? 150 : 200;
                    finishPriceItem.innerHTML = `<span>${finishText}</span> <span>₹${finishPrice.toFixed(2)}</span>`;
                }

                // Function to update order total
                function updateOrderTotal() {
                    let total = 500;

                    if (selectedMaterial) {
                        total += selectedMaterial === 'silicone' ? 100 : 120;
                    }
                    if (selectedFinish) {
                        total += selectedFinish === 'glossy' ? 150 : 200;
                    }

                    // Assuming you have an element to display total price
                    const totalPriceElement = document.querySelector('.order-total');
                    if (totalPriceElement) {
                        totalPriceElement.textContent = `Total: ₹${total.toFixed(2)}`;
                    }
                }

                // Update order total
                updateOrderTotal();
            });

            function redirectToPage() {
                window.location.href = "checkout.php"; // Change this to your desired page
            }
        </script>

    </body>
    <script src="script.js"></script>

</html>