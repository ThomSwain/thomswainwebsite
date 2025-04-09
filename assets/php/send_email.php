<?php
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get POST data
    $name = isset($_POST['name']) ? strip_tags(trim($_POST['name'])) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $message = isset($_POST['message']) ? strip_tags(trim($_POST['message'])) : '';

    // Validate form fields
    if (empty($name)) {
        $errors[] = 'Name is empty';
    }

    if (empty($email)) {
        $errors[] = 'Email is empty';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email is invalid';
    }

    if (empty($message)) {
        $errors[] = 'Message is empty';
    }

    // If no errors, send email
    if (empty($errors)) {
        // Recipient email address (replace with your own)
        $recipient = "thomas.e.swain@gmail.com";
        $subject = $name . " has contacted you via thomswain.net";

        // Additional headers
        $headers = "\r\n\n\n" . "From: " . $name . " <". $email . ">" . "\r\n";
        $message .= $headers;

        // Send email
        if (mail($recipient, $subject, $message)) {
            echo "Email sent successfully! \n You will be contacted shortly";
            $feedback = '*Message sent! You will receive a reply shortly!';
            // header("Location: index.html");  
            exit();
        } else {
            echo "Failed to send email. Please try again later.";
            $feedback = '*Message failed to send';
        }
    } else {
        // Display errors
        echo "The form contains the following errors:<br>";
        // $feedback = 'Missing Params';
        foreach ($errors as $error) {
            echo "- $error<br>";
        }
    }
} else {
    // Not a POST request, display a 403 forbidden error
    header("HTTP/1.1 403 Forbidden");
    echo "You are not allowed to access this page.";
}

echo $feedback;
?>