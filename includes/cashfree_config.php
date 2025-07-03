<?php
require_once __DIR__ . '/../vendor/autoload.php';

// Load environment variables if .env file exists
if (file_exists(__DIR__ . '/../.env')) {
    $env = parse_ini_file(__DIR__ . '/../.env');
    foreach ($env as $key => $value) {
        putenv("$key=$value");
        $_ENV[$key] = $value;
    }
}

// Determine environment
$is_production = getenv('APP_ENV') === 'production';

// Cashfree API Configuration for test
// define('CASHFREE_API_ENV', 'TEST');
// define('CASHFREE_API_ENV', 'sandbox');
// define('CASHFREE_APP_ID', 'TEST10502007916f333a159ab40448ea70020501');
// define('CASHFREE_SECRET_KEY', 'cfsk_ma_test_afc43f1f1bcb19b484fb91118ed22cfb_91ff6561');

// define('CASHFREE_API_URL', 'https://sandbox.cashfree.com/pg'); // api url for test

// Cashfree API Configuration for production
define('CASHFREE_API_ENV', 'production');
define('CASHFREE_APP_ID', '92372279d8389fa97e82abe3e4227329');
define('CASHFREE_SECRET_KEY', 'cfsk_ma_prod_2eb1aea574b6325bb0830926c52f9f73_3a010861');

// API Endpoints
define('CASHFREE_API_URL', 'https://api.cashfree.com/pg'); // api url for production 
define('CASHFREE_API_VERSION', '2022-09-01');

// Payment Configuration
define('CASHFREE_CURRENCY', 'INR');
define('CASHFREE_PAYMENT_METHODS', json_encode(['upi', 'card', 'netbanking', 'wallet']));

// Timeout settings
define('CASHFREE_API_TIMEOUT', 30);
define('CASHFREE_API_CONNECT_TIMEOUT', 10);

// Get the base URL
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
// $protocol = 'https://';
$base_url = $protocol . $_SERVER['HTTP_HOST'];
define('BASE_URL', $base_url);

/**
 * Helper function to generate Cashfree headers
 */
function getCashfreeHeaders() {
    return [
        'Content-Type: application/json',
        'x-api-version: ' . CASHFREE_API_VERSION,
        'x-client-id: ' . CASHFREE_APP_ID,
        'x-client-secret: ' . CASHFREE_SECRET_KEY
    ];
}

/**
 * Helper function to verify Cashfree signature
 */
function verifyCashfreeSignature($orderId, $orderAmount, $referenceId, $txStatus, $paymentMode, $txMsg, $txTime, $signature) {
    $data = $orderId . $orderAmount . $referenceId . $txStatus . $paymentMode . $txMsg . $txTime;
    $hash_hmac = hash_hmac('sha256', $data, CASHFREE_SECRET_KEY, true);
    $computedSignature = base64_encode($hash_hmac);
    return $signature === $computedSignature;
}

/**
 * Helper function to format phone number
 */
function formatPhoneNumber($phone) {
    $phone = preg_replace('/[^0-9]/', '', $phone);
    return substr($phone, -10);
}

// Allowed Payment Methods
define('CASHFREE_ALLOWED_PAYMENT_METHODS', json_encode([
    'upi',
    'card',
    'netbanking',
    'wallet'
]));

// Webhook Secret (for verifying webhook signatures)
define('CASHFREE_WEBHOOK_SECRET', getenv('CASHFREE_WEBHOOK_SECRET'));

// Error messages
define('CASHFREE_ERROR_MESSAGES', [
    'initialization_failed' => 'Unable to initialize payment. Please try again later.',
    'invalid_signature' => 'Payment verification failed. Please contact support.',
    'payment_failed' => 'Payment was not successful. Please try again.',
    'invalid_amount' => 'Invalid payment amount.',
    'order_not_found' => 'Order not found or unauthorized access.',
    'api_error' => 'Payment gateway is currently unavailable. Please try again later.'
]);

// Load environment variables with error handling
try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();
} catch (Exception $e) {
    error_log("Error loading .env file: " . $e->getMessage());
}

// API endpoints
if (CASHFREE_API_ENV === 'PROD') {
    define('CASHFREE_ORDER_CREATE_URL', 'https://api.cashfree.com/pg/orders');
} else {
    define('CASHFREE_ORDER_CREATE_URL', 'https://sandbox.cashfree.com/pg/orders');
}
?> 