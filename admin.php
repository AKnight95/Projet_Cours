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

// Vérifiez si le formulaire de création de cours est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['update_course_id'])) {
    // Récupérer les données du formulaire
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Créer un tableau associatif avec les données du cours
    $course = [
        'id' => uniqid(), // Génère un identifiant unique pour le cours
        'title' => $title,
        'content' => $content
    ];

    // Convertir le tableau associatif en JSON
    $jsonCourse = json_encode($course);

    // Écrire le JSON dans un fichier
    $filePath = 'courses/' . $course['id'] . '.json';
    file_put_contents($filePath, $jsonCourse);

    // Récupérer l'email de l'utilisateur
    $userEmail = $_SESSION['user']['email'];

    // Écrire l'email dans un fichier
    $emailFilePath = 'courses/' . $course['id'] . '_email.txt';
    file_put_contents($emailFilePath, $userEmail);

    // Recharger la page
    header("Location: admin.php");
    exit(); // Assurez-vous d'arrêter l'exécution du script après la redirection
}

// Vérifiez si le formulaire de modification de cours est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_course_id'])) {
    // Récupérer l'ID du cours à mettre à jour
    $courseId = $_POST['update_course_id'];

    // Récupérer les données du formulaire
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Créer un tableau associatif avec les nouvelles données du cours
    $updatedCourse = [
        'id' => $courseId,
        'title' => $title,
        'content' => $content
    ];

    // Convertir le tableau associatif en JSON
    $jsonUpdatedCourse = json_encode($updatedCourse);

    // Écrire le JSON dans le fichier du cours
    $filePath = 'courses/' . $courseId . '.json';
    file_put_contents($filePath, $jsonUpdatedCourse);

    // Recharger la page
    header("Location: admin.php");
    exit(); // Assurez-vous d'arrêter l'exécution du script après la redirection
}

include('base.php');
?>


<section class="bg-white dark:bg-gray-900 h-full">
    <div class="py-8 lg:py-16 px-4 mx-auto max-w-screen-md">
        <!-- Le contenu de la page "admin.php" -->
        <h1 class="text-center text-white text-lg">Admin</h1>

        <!-- Modal toggle -->
        <div class="flex justify-center m-5">
            <button id="defaultModalButton" data-modal-toggle="defaultModal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" type="button">
                Créer un cours
            </button>
        </div>

        <!-- Main modal -->
        <div id="defaultModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
            <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
                <!-- Modal content -->
                <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                    <!-- Modal header -->
                    <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Ajouter un cours
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="defaultModal">
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                            <span class="sr-only">Fermer</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <form action="#" method="POST">
                        <div class="grid gap-4 mb-4 sm:grid-cols-2">
                            <div>
                                <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Titre</label>
                                <input type="text" name="title" id="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Titre du cours" required="">
                            </div>
                            <div class="sm:col-span-2">
                                <label for="content" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contenu</label>
                                <textarea id="content" name="content" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Contenu du cours"></textarea>
                            </div>
                        </div>
                        <button type="submit" class="text-white inline-flex items-center bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                            <svg class="mr-1 -ml-1 w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                            Ajouter le cours
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <div class="w-full p-5 flex flex-col justify-center items-center">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
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

                // Vérifier si le fichier contenant l'email existe
                $emailFile = 'courses/' . $courseId . '_email.txt';
                if (file_exists($emailFile)) {
                    // Lire l'email depuis le fichier
                    $courseEmail = file_get_contents($emailFile);
                } else {
                    // L'email n'est pas disponible
                    $courseEmail = 'Non disponible';
                }
                ?>

                <div class="w-full p-6 m-3 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <a href="#"><h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"><?= $courseTitle ?></h5></a>
                    <p class="mb-3 font-normal text-gray-700 dark:text-white"><?= $courseContent ?></p>
                    <p class="text-sm text-gray-400 italic">Créé par : <?= $courseEmail ?></p>
                    <p class="text-sm text-gray-400 italic mb-5">Le <?= date('Y-m-d H:i:s', filemtime($file)) ?></p>
                    <div class="flex">
                        <button id="updateProductButton" data-modal-toggle="updateProductModal" class="block block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" type="button" onclick="populateUpdateForm('<?= $courseId ?>', '<?= $courseTitle ?>', '<?= $courseContent ?>')">
                            Modifier le cours
                        </button>
                    </div>
                </div>

            <?php
            }
            ?>
        </div>
    </div>

</section>

<div id="updateProductModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
    <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
        <!-- Modal content -->
        <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
            <!-- Modal header -->
            <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Modifier ce cours
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="updateProductModal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Fermer</span>
                </button>
            </div>
            <!-- Modal body -->
            <form action="#" method="POST">
                <div class="grid gap-4 mb-4 sm:grid-cols-2">
                    <div>
                        <input type="hidden" name="update_course_id" id="update_course_id" value="">
                        <label for="update_title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Titre</label>
                        <input type="text" name="title" id="update_title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Titre du cours" required="">
                    </div>
                    <div class="sm:col-span-2">
                        <label for="update_content" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contenu</label>
                        <textarea id="update_content" name="content" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Contenu du cours"></textarea>
                    </div>
                </div>
                <button type="submit" class="text-white inline-flex items-center bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                    <svg class="mr-1 -ml-1 w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                    Modifier le cours
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    // Fonction pour pré-remplir le formulaire de modification avec les données du cours sélectionné
    function populateUpdateForm(courseId, courseTitle, courseContent) {
        document.getElementById('update_course_id').value = courseId;
        document.getElementById('update_title').value = courseTitle;
        document.getElementById('update_content').value = courseContent;
        toggleModal('updateProductModal');
    }

   
</script>







