<?php
declare(strict_types=1);

use Firebase\JWT\JWT;

require_once(__DIR__ . '/../../vendor/autoload.php');
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');

$hasValidCredentials = false;

$method = $_SERVER['REQUEST_METHOD'];
// $request = explode('/', trim($_SERVER['PATH_INFO'],'/login'));
$url = parse_url($_SERVER['REQUEST_URI']);

$servername = "localhost";
$usernameDB = "developer";
$password = "secret123";
$dbname = "vuedb"; 

$conn = new mysqli($servername, $usernameDB, $password, $dbname);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$username = $_POST['username'];
if(!isset($username)){ http_response_code(402); }

$pass = $_POST['pass'];
if(!isset($pass)){ http_response_code(402); }

if($method == 'POST')
{
  $sql = "select id, username, password from users where username =".$username; 

  $result = mysqli_query($conn, $sql);
    // TODO test result with encryption

  $hasValidCredentials = true;
}

if ($hasValidCredentials) { 
  $secretKey  = 'bGS6lzFqvvSQ8ALbOxatm7/Vk7mLQyzqaS34Q4oR1ew=';
  $issuedAt   = new DateTimeImmutable();
  $expire     = $issuedAt->modify('+6 minutes')->getTimestamp();      // Add 60 seconds
  $serverName = "your.domain.name";
  $username   = $_POST['username'];                                           // Retrieved from filtered POST data

  $data = [
      'iat'  => $issuedAt->getTimestamp(),         // Issued at: time when the token was generated
      'iss'  => $serverName,                       // Issuer
      'nbf'  => $issuedAt->getTimestamp(),         // Not before
      'exp'  => $expire,                           // Expire
      'userName' => $username,                     // User name
  ];

  // Encode the array to a JWT string.
  echo JWT::encode(
    $data,
    $secretKey,
    'HS512'
  );

  $conn->close();
}


function console_log( $data ){
  echo '<script>';
  echo 'console.log('. json_encode( $data ) .')';
  echo '</script>';
}

?>