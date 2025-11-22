<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Metoda není povolena']);
    exit();
}

// Get JSON data from request body
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Validate required fields
if (empty($data['name']) || empty($data['email']) || empty($data['message'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Všechna pole jsou povinná']);
    exit();
}

// Sanitize inputs
$name = htmlspecialchars(strip_tags(trim($data['name'])));
$email = filter_var(trim($data['email']), FILTER_SANITIZE_EMAIL);
$message = htmlspecialchars(strip_tags(trim($data['message'])));

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['error' => 'Neplatná emailová adresa']);
    exit();
}

// Email configuration - ZMĚŇ TYTO HODNOTY!
$to = 'info@filipkoudelnicek.cz'; // <-- Změň na svůj email
$from_email = 'noreply@' . $_SERVER['HTTP_HOST']; // Email z tvé domény
$subject = 'Nová zpráva z portfolia od ' . $name;

// Email body
$email_body = "Nová zpráva z kontaktního formuláře:\n\n";
$email_body .= "Jméno: $name\n";
$email_body .= "Email: $email\n";
$email_body .= "Zpráva:\n$message\n";

// Email headers - From musí být z tvé domény!
$headers = "From: Portfolio <$from_email>\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// Send email
$mail_sent = @mail($to, $subject, $email_body, $headers);

if ($mail_sent) {
    // Log successful send (optional)
    error_log("Email sent successfully from: $email");
    
    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => 'Zpráva byla úspěšně odeslána'
    ]);
} else {
    // Log error
    $error = error_get_last();
    error_log("Email failed to send. Error: " . print_r($error, true));
    
    http_response_code(500);
    echo json_encode(['error' => 'Nepodařilo se odeslat email. Zkus to prosím později.']);
}
?>
