<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.0/fabric.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <style>
        .container_check {
            display: flex;
            align-items: center;
            flex-direction: column;
            justify-content: center;
            margin-top: 100px;
        }

        .container_check img {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100px;
        }
    </style>
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

    <div class="container_check">
        <h2>Checkout</h2>

        <?php
        // Fetch the final image from localStorage via JavaScript
        echo "<img src='' id='finalImage' alt='Case Image'>";
        ?>
        <p style="font-weight: bold; margin-top:10px">₹ <span class="price order-total"></span></p>
        
        <input type="button" name="btn" id="btn" value="Pay Now" onclick="pay_now()">
    </div>

    

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectedModel = localStorage.getItem("selectedModel");
            const modelHeading = document.querySelector(".summary-details h2");
            if (selectedModel && modelHeading) {
                const modelText = selectedModel === 'iphone12pro' ? 'iPhone 12 pro' : 'iPhone 12';
                modelHeading.textContent = `Your ${modelText} Case`;
            }

            const selectedMaterial = localStorage.getItem("selectedMaterial");
            const selectedFinish = localStorage.getItem("selectedFinish");

            const materialPriceItem = document.querySelector('.price-item:nth-child(2)');
            if (selectedMaterial && materialPriceItem) {
                const materialText = selectedMaterial ? `${selectedMaterial}` : 'Default material';
                const materialPrice = selectedMaterial === 'silicone' ? 100 : 120;
                materialPriceItem.innerHTML = `<span><span class="math-inline">\{materialText\}</span\> <span\>₹</span>{materialPrice.toFixed(2)}</span>`;
            }

            const finishPriceItem = document.querySelector('.price-item:nth-child(3)');
            if (selectedFinish && finishPriceItem) {
                const finishText = selectedFinish ? `${selectedFinish}` : 'Default finish';
                const finishPrice = selectedFinish === 'glossy' ? 150 : 200;
                finishPriceItem.innerHTML = `<span><span class="math-inline">\{finishText\}</span\> <span\>₹</span>{finishPrice.toFixed(2)}</span>`;
            }

            function updateOrderTotal() {
                let total = 500;
                if (selectedMaterial) {
                    total += selectedMaterial === 'silicone' ? 100 : 120;
                }
                if (selectedFinish) {
                    total += selectedFinish === 'glossy' ? 150 : 200;
                }
                const totalPriceElement = document.querySelector('.order-total');
                if (totalPriceElement) {
                    totalPriceElement.textContent = `${total}`;
                }
            }

            updateOrderTotal();
        });

        const finalImage = localStorage.getItem("finalCaseImage");
        if (finalImage) {
            document.getElementById('finalImage').src = finalImage;
        }

        function pay_now() {
            var name = jQuery('#name').val();
            var amt = document.querySelector('.order-total').textContent;
            var model = localStorage.getItem("selectedModel"); // Get selected model
            var material = localStorage.getItem("selectedMaterial"); // Get selected material
            var finish = localStorage.getItem("selectedFinish"); // Get selected finish
            var image = localStorage.getItem("finalCaseImage"); // Get the image data

            jQuery.ajax({
                type: 'post',
                url: 'payment_process.php',
                data: { 
                    amt: amt,  
                    model: model, // Pass selected model
                    material: material, // Pass selected material
                    finish: finish, // Pass selected finish
                    image: image // Pass the image data
                },
                success: function(result) {
                    var options = {
                        "key": "rzp_test_sqR0Xp1n2BeoIf",
                        "amount": amt * 100,
                        "currency": "INR",
                        "name": "Casecobra",
                        "description": "Test Transaction",
                        "image": "https://www.casecobra.com/snake-1.png",
                        "handler": function(response) {
                            jQuery.ajax({
                                type: 'post',
                                url: 'payment_process.php',
                                data: "payment_id=" + response.razorpay_payment_id,
                                success: function(result) {
                                    window.location.href = "my_orders.php";
                                }
                            });
                        }
                    };
                    var rzp1 = new Razorpay(options);
                    rzp1.open();
                }
            });
        }
    </script>
</body>
<script src="script.js"></script>
</html>