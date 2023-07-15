<?php

setcookie('EMAIL', '', time() - 3600);
header('Location: login.php');
exit();
?>
