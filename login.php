<?php
session_start();

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Vérification des identifiants par rapport à la base de données des utilisateurs
    $userFiles = glob('users/*.json');

    $authenticated = false;

    foreach ($userFiles as $userFile) {
        $userDataJson = file_get_contents($userFile);
        $userData = json_decode($userDataJson, true);

        if ($userData['email'] === $email && $userData['password'] === $password) {
            // Identifiants valides, authentification réussie
            $_SESSION['user'] = [
                'email' => $email,
                'password' => $password
            ];
            $authenticated = true;
            break;
        }
    }

    if ($authenticated) {
        // Authentification réussie, redirection vers la page d'accueil
        error_log("Authentification réussie. Redirection vers la page d'accueil.");
        header('Location: home.php');
        exit();
    } else {
        // Identifiants invalides, affichage d'un message d'erreur
        $errorMessage = "Identifiants incorrects. Veuillez réessayer.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css"  rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    
<section class="bg-gray-50 dark:bg-gray-900">
  <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
      <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
          <img class="w-12 h-12 mr-2" src="./asset/php_PNG10.png" alt="logo">
          PHP  
      </a>
      <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
          <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
              <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white mb-2">
                  Connexion
              </h1>
              <?php if (isset($errorMessage)) : ?>
                <span id="badge-dismiss-red" class="inline-flex items-center px-2 py-1 mr-2 text-sm font-medium text-red-800 bg-red-100 rounded dark:bg-red-900 dark:text-red-300">
                    <?php echo $errorMessage; ?>
                    <button type="button" class="inline-flex items-center p-0.5 ml-2 text-sm text-red-400 bg-transparent rounded-sm hover:bg-red-200 hover:text-red-900 dark:hover:bg-red-800 dark:hover:text-red-300" data-dismiss-target="#badge-dismiss-red" aria-label="Remove">
                        <svg aria-hidden="true" class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        <span class="sr-only">Remove badge</span>
                    </button>
                </span>
              <?php endif; ?>
              <form class="space-y-4 md:space-y-6" action="login.php" method="POST">

                  <div>
                      <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Adresse mail</label>
                      <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@company.com" required="">
                  </div>
                  <div>
                      <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mot de passe</label>
                      <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                  </div>
                  <div class="flex items-center justify-between">
                      <div class="flex items-start">
                          <div class="flex items-center h-5">
                            <input id="remember" aria-describedby="remember" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800" required="">
                          </div>
                          <div class="ml-3 text-sm">
                            <label for="remember" class="text-gray-500 dark:text-gray-300">Se souvenir de moi</label>
                          </div>
                      </div>
                      <a href="#" class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-500">Mot de passe oublié?</a>
                  </div>
                  <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700">Se connecter</button>
              </form>
          </div>
          <p class="flex items-center justify-center px-6 py-4 text-gray-500 dark:text-gray-400">
              Vous n'avez pas de compte?
              <a href="register.php" class="text-blue-600 hover:underline ml-1 dark:text-blue-400">Inscrivez-vous</a>
          </p>
      </div>
  </div>
</section>

</body>
</html>


