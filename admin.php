<?php
session_start();

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    // Utilisateur non connecté, redirection vers la page de connexion
    header("Location: login.php");
    exit(); // Assurez-vous d'arrêter l'exécution du script après la redirection
}

// L'utilisateur est connecté, récupérez les informations de l'utilisateur
$email = $_SESSION['user']['email'];

include('base.php');
?>


<!-- Modal toggle -->
<section class="bg-white dark:bg-gray-900 h-full">
  <div class="py-8 lg:py-16 px-4 mx-auto max-w-screen-md">
    <!-- Le contenu de la page "admin.php" -->
    <h1 class="text-center text-white text-lg">Admin</h1>
  </div>
</section>

