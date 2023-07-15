<?php
session_start();

$email = $_POST['email'];
$password = $_POST['password'];

$userId = uniqid();
$userData = array(
  'email' => $email,
  'password' => $password
);

$userDataJson = json_encode($userData);

$filename = 'users/' . $userId . '.json';
file_put_contents($filename, $userDataJson);

$_SESSION['userId'] = $userId; // Stocke l'identifiant de l'utilisateur dans la session

header('Location: ./home.php');
exit();
?>
