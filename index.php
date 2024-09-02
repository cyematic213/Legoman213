<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $firstname = htmlspecialchars(trim($_POST['firstname']));
    $lastname = htmlspecialchars(trim($_POST['lastname']));
    $email = htmlspecialchars(trim($_POST['email']));
    $subject = htmlspecialchars(trim($_POST['subject']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $message = htmlspecialchars(trim($_POST['message']));
    $agreement = htmlspecialchars(trim($_POST['agreement']));

    // Basic validation
    if (empty($firstname) || empty($lastname) || empty($email) || empty($subject) || empty($phone) || empty($message) || empty($agreement)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        // Prepare the email
        $to = "your-email@example.com"; // Replace with your email address
        $headers = "From: $email" . "\r\n" .
                   "Reply-To: $email" . "\r\n" .
                   "X-Mailer: PHP/" . phpversion();

        $full_message = "First Name: $firstname\n";
        $full_message .= "Last Name: $lastname\n";
        $full_message .= "Email: $email\n";
        $full_message .= "Phone: $phone\n";
        $full_message .= "Subject: $subject\n\n";
        $full_message .= "Message:\n$message\n\n";
        $full_message .= "Agreement: $agreement\n";

        // Send the email
        if (mail($to, $subject, $full_message, $headers)) {
            $success = "Thank you for contacting us. We will get back to you shortly.";
        } else {
            $error = "Sorry, something went wrong. Please try again later.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <style>
        /* Your existing CSS styles */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            overflow: auto;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            box-sizing: border-box;
        }

        h1 {
            text-align: center;
        }

        label {
            font-weight: bold;
        }

        .required-text {
            color: red;
            font-size: 0.9em;
        }

        .input-group {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 15px;
        }

        .input-group div {
            flex: 1;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        textarea {
            width: 90%;
            padding: 10px;
            margin: 5px 0 15px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        textarea {
            resize: none;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .agreement-label {
            display: block;
            margin-top: 10px;
        }

        .radio-buttons {
            margin-bottom: 15px;
        }

        .radio-buttons div {
            margin-bottom: 10px;
        }

        .message {
            text-align: center;
            margin-bottom: 20px;
        }

        .error {
            color: red;
        }

        .success {
            color: green;
        }
    </style>
</head>
<body>
    <form action="" method="post">
        <h1>CONTACT FORM</h1>

        <?php if (!empty($error)): ?>
            <div class="message error"><?php echo $error; ?></div>
        <?php elseif (!empty($success)): ?>
            <div class="message success"><?php echo $success; ?></div>
        <?php endif; ?>

        <div class="input-group">
            <div>
                <label for="firstname">Name</label><small class="required-text">&nbsp; (Required)</small><br>
                <small class="firstname">First Name</small>
                <input type="text" id="firstname" name="firstname" required>
            </div>
            <div>
                <br><small class="lastname">Last Name</small><br>
                <input type="text" id="lastname" name="lastname" required>
            </div>
        </div>

        <label for="email">Email Address</label><small class="required-text">&nbsp; (Required)</small><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="subject">Subject</label><small class="required-text">&nbsp; (Required)</small><br>
        <input type="text" id="subject" name="subject" required><br><br>

        <label for="phone">Phone Number</label><small class="required-text">&nbsp; (Required)</small><br>
        <input type="tel" id="phone" name="phone" required><br><br>

        <label for="message">Message</label><small class="required-text">&nbsp; (Required)</small><br>
        <textarea id="message" name="message" rows="4" required></textarea><br><br>

        <div class="agreement-label">
            <label>By submitting this form, you consent that we may reach out to you via phone call...</label>
        </div>
        <div class="radio-buttons">
            <div style="text-align: left;">
                <input type="radio" id="agree" name="agreement" value="agree" required>
                <label for="agree">I Agree to Opt-in</label><br>
                
                <input type="radio" id="disagree" name="agreement" value="disagree" required>
                <label for="disagree">I Do not agree to opt-in</label>
            </div>
        </div>

        <input type="submit" value="Submit">
    </form>
</body>
</html>
