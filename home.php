<?php
session_start();

include('base.php');

if (!isset($_SESSION['user']) && isset($_COOKIE['EMAIL'])) {
    $_SESSION['user'] = [
        'email' => $_COOKIE['EMAIL']
    ];
}

$email = isset($_SESSION['user']['email']) ? $_SESSION['user']['email'] : '';

?>

<section class="bg-white dark:bg-gray-900">
  <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
      <div class="mx-auto max-w-screen-md text-center mb-8 lg:mb-12">
          <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">Cours projet semaine 01</h2>
          <p class="mb-5 font-light text-gray-500 sm:text-xl dark:text-gray-400">J'ai utilisé Flowbite et Tailwind css pour le syle du site et générer rapidement mes pages.</p>
        </br>
      </div>
      
      <?php
        // Récupérer la liste des fichiers JSON dans le dossier "courses"
        $courseFiles = glob('courses/*.json');

        // Parcourir chaque fichier JSON
        foreach ($courseFiles as $file) {
            // Lire le contenu du fichier JSON
            $jsonCourse = file_get_contents($file);

            // Décoder le JSON en tant que tableau associatif
            $course = json_decode($jsonCourse, true);

            // Extraire les données du cours
            $courseId = $course['id'];
            $courseTitle = $course['title'];
            $courseContent = $course['content'];

            // Afficher le contenu du cours dans une carte
            echo '
                <!-- Course Card -->
                <div class="flex flex-col p-6 mx-auto max-w-lg m-5 text-center text-gray-900 bg-white rounded-lg border border-gray-100 shadow dark:border-gray-600 xl:p-8 dark:bg-gray-800 dark:text-white">
                    <h3 class="mb-4 text-2xl font-semibold">' . $courseTitle . '</h3>
                    <p class="font-light text-gray-500 sm:text-lg dark:text-gray-400">' . $courseContent . '</p>
                    <a href="course_details.php?id=' . $courseId . '" class="text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:ring-primary-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:text-white dark:focus:ring-primary-900">View details</a>
                </div>';
        }
        ?>
  </div>
</section>