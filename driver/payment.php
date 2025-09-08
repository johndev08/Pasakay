<?php
session_start();
include("../connection.php");
include("./nav.php");

$user_id = $_SESSION['id'];
$user_username = $_SESSION['username'];

$getqr = mysqli_query($connection, "SELECT username, p_method, qr1, qr2 FROM users WHERE access='admin'");
$row = mysqli_fetch_assoc($getqr);
$qr1 = $row['qr1'];
$qr2 = $row['qr2'];

// Handle GCash Proof Upload
if (isset($_POST['sendgcash'])) {
    $uploadDir = '../images/';
    $fileName = basename($_FILES['gcashproof']['name']);
    $uploadFilePath = $uploadDir . $fileName;
    $currentDate = date('Y-m-d'); // Get current date
    error_log("Reference number received: " . $_POST['reference_number']);
    $refNumber = isset($_POST['reference_number']) ? mysqli_real_escape_string($connection, $_POST['reference_number']) : '';

    if (move_uploaded_file($_FILES['gcashproof']['tmp_name'], $uploadFilePath)) {
        $query = "UPDATE users SET 
        proof='$fileName', 
        p_method='G Cash', 
        monthly='paid', 
        total='300', 
        paydate='$currentDate', 
        reference_number='$refNumber' 
        WHERE username='$user_username'";

        error_log("Query being executed: " . $query);

        if (mysqli_query($connection, $query)) {
            error_log("Database update successful for user: " . $user_username);
            echo "<script>alert('Payment proof and reference number uploaded successfully.');
            window.location.href='./queue.php';</script>";
        } else {
            // Log database error
            error_log("Database error: " . mysqli_error($connection));
            echo "<script>alert('Failed to update payment: " . mysqli_error($connection) . "');</script>";
        }
    } else {
        echo "<script>alert('Failed to upload the GCash proof.');</script>";
    }
}

// Handle Maya Proof Upload
if (isset($_POST['sendmaya'])) {
    $uploadDir = '../images/';
    $fileName = basename($_FILES['mayaproof']['name']);
    $uploadFilePath = $uploadDir . $fileName;
    $currentDate = date('Y-m-d'); // Get current date

    if (move_uploaded_file($_FILES['mayaproof']['tmp_name'], $uploadFilePath)) {
        $query = "UPDATE users SET proof='$fileName', p_method='Maya', monthly='paid', total='300', paydate='$currentDate' WHERE username='$user_username'";
        if (mysqli_query($connection, $query)) {
            echo "<script>alert('Payment proof uploaded successfully.');
            window.location.href='./queue.php';</script>";
        } else {
            echo "<script>alert('Failed to update payment in the database.');</script>";
        }
    } else {
        echo "<script>alert('Failed to upload the Maya proof.');</script>";
    }
}

if (isset($_POST['set_cash'])) {
    $currentDate = date('Y-m-d'); // Get current date
    // Update the database to set p_method to "Cash" and proof to "N/A"
    $update_query = "UPDATE users SET p_method='Cash', monthly='paid', proof='N/A', total='300', paydate='$currentDate' WHERE username='$user_username'";
    if (mysqli_query($connection, $update_query)) {
        echo "<script>alert('Payment method set to Cash successfully. Please give the cash to the admin ASAP, else you might get terminated from Queue!');
        window.location.href='./queue.php';
        </script>";
    } else {
        echo "<script>alert('Failed to update payment method. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/tesseract.js@4/dist/tesseract.min.js"></script>
    <title>Driver QR Code</title>
    <style>
        .reference-extract {
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        #preview {
            max-width: 100%;
            margin: 10px 0;
            display: none;
            /* Hide preview initially */
        }

        #result {
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #ccc;
            display: none;
            font-size: 16px;
        }

        #loading {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            text-align: center;
            display: none;
        }

        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-right: 10px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>
    <h1 class="text-center oswald mt-2">Select Payment</h1>
    <div class="m-4">
        <form method="POST" action="">
            <input type="submit" value="Cash" class="mb-3 btn btn-lg btn-primary w-100" name="set_cash" onclick='return confirm(`Are you sure you want to pay cash?`)'>
        </form>
        <button class="mb-3 btn btn-lg btn-success w-100" popovertarget="gcash">G Cash</button>
        <button class="mb-3 btn btn-lg btn-primary w-100" popovertarget="maya">Maya</button>
        <a href="./queue.php" class="btn  btn-warning w-100 text-decoration-none mt-4 ">Cancel</a>
    </div>


    <form method="POST" enctype="multipart/form-data" action="" id="gcash" class="position-absolute top-50 start-50 translate-middle p-3 border shadow rounded" popover style="width: 90%;">
        <h3>Scan Admin's G Cash</h3>
        <img src="../images/<?php echo htmlspecialchars($qr1); ?>" alt="QR Code" width="100%">

        <div class="reference-extract">
            <label for="gcashproof">Upload Receipt:</label>
            <input type="file" name="gcashproof" id="gcashproof" required accept="image/*">
            <img id="preview">
            <div id="loading">
                <div class="loading-spinner"></div>
                <span>Processing receipt... Please wait.</span>
            </div>
            <div id="result"></div>
            <div class="mt-3">
                <label for="reference_number">Reference Number:</label>
                <input type="text" name="reference_number" id="reference_number" class="form-control" readonly>
            </div>
        </div>

        <input type="submit" value="Send proof" class="btn btn-success w-100 mt-3" name="sendgcash">
    </form>
    <form method="POST" enctype="multipart/form-data" action="" id="maya" class="position-absolute top-50 start-50 translate-middle p-3 border shadow rounded" popover style="width: 90%;">
        <h3>Scan Admin's Maya</h3>
        <img src="../images/<?php echo htmlspecialchars($qr2); ?>" alt="Driver QR Code" width="100%">
        <label for="mayaproof">Proof:</label>
        <input type="file" name="mayaproof" id="mayaproof" required>
        <input type="submit" value="Send proof" class="btn btn-success w-100 mt-3" name="sendmaya">
    </form>
    <script>
        const gcashproof = document.getElementById('gcashproof');
        const preview = document.getElementById('preview');
        const result = document.getElementById('result');
        const loading = document.getElementById('loading');
        const referenceNumberInput = document.getElementById('reference_number');

        gcashproof.addEventListener('change', async (e) => {
            const file = e.target.files[0];
            if (!file) return;

            // Show preview
            const reader = new FileReader();
            reader.onload = (e) => {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);

            // Show loading immediately
            loading.style.display = 'block';
            result.style.display = 'none';

            try {
                console.log('Starting OCR processing...');
                const {
                    data: {
                        text
                    }
                } = await Tesseract.recognize(
                    file,
                    'eng', {
                        logger: m => {
                            console.log(m);
                            if (m.status === 'recognizing text') {
                                loading.querySelector('span').textContent =
                                    `Processing receipt... ${Math.round(m.progress * 100)}%`;
                            }
                        }
                    }
                );

                console.log('OCR completed. Extracted text:', text);

                const patterns = [
                    /Ref\.?\s*No\.?\s*(\d{4}\s*\d{3}\s*\d{6})/i,
                    /Reference\s*No\.?\s*(\d{4}\s*\d{3}\s*\d{6})/i,
                    /Ref\.?\s*Number\s*(\d{4}\s*\d{3}\s*\d{6})/i,
                    /(\d{4}\s*\d{3}\s*\d{6})/ // Just look for the number pattern
                ];

                let match = null;
                for (const pattern of patterns) {
                    match = text.match(pattern);
                    if (match) break;
                }

                // Hide loading and show result
                loading.style.display = 'none';
                result.style.display = 'block';

                if (match) {
                    const refNumber = match[1].replace(/\s/g, '');
                    console.log('Reference number found:', refNumber); // Debug log
                    result.innerHTML = `Reference Number: ${refNumber}`;
                    referenceNumberInput.value = refNumber;
                } else {
                    console.log('No reference number found in text:', text); // Debug log
                    result.innerHTML = 'No reference number found. Please make sure the receipt image is clear.';
                    referenceNumberInput.value = '';
                }
            } catch (error) {
                console.error('Error during OCR:', error);
                loading.style.display = 'none';
                result.style.display = 'block';
                result.innerHTML = 'Error processing image: ' + error.message;
                referenceNumberInput.value = '';
            }
        });
    </script>
</body>

</html>