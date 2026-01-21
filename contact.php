<?php

// Only allow POST requests
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    exit("Invalid request");
}

// Company email (RECEIVER)
$address = "prabhat.kumar@sanjaygroup.in"; 

// Clean and secure input
function clean($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

$first_name = clean($_POST["first_name"] ?? "");
$last_name  = clean($_POST["last_name"] ?? "");
$email      = clean($_POST["email"] ?? "");
$phone      = clean($_POST["phone"] ?? "");
$location   = clean($_POST["Location"] ?? "");
$comments   = clean($_POST["comments"] ?? "");

// Validation
if ($first_name == "") {
    echo "<div class='error_message'>Please enter your first name.</div>";
    exit;
}

if ($email == "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<div class='error_message'>Please enter a valid email address.</div>";
    exit;
}

if ($comments == "") {
    echo "<div class='error_message'>Please enter your message.</div>";
    exit;
}

// Email subject
$subject = "New Website Contact Form Submission";

// Email body
$message = "
New Contact Form Submission

Name: $first_name $last_name
Email: $email
Phone: $phone
Location: $location

Message:
$comments
";

// Headers
$headers  = "From: Sanjay Techno Plast Website <no-reply@sanjaytechnoplast.in>\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// Send email
if (mail($address, $subject, $message, $headers)) {

    echo "
    <div id='success_page' style='padding:15px; background:#e7f9f0; border-left:4px solid #28a745; color:#155724;'>
        <h4>Message Sent Successfully!</h4>
        <p>Thank you <strong>$first_name</strong>, we have received your message. Our team will contact you soon.</p>
    </div>
    ";

} else {

    echo "
    <div class='error_message' style='padding:15px; background:#fdecea; border-left:4px solid #dc3545; color:#721c24;'>
        ERROR: Your message could not be sent. Please try again later.
    </div>
    ";

}
?>
