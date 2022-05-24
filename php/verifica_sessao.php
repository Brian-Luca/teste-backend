<?php
session_start();

if (!isset($_SESSION['logado'])) :
    header("Location: login.php");
elseif ($_SESSION['logado'] == 'NAO') :
    header("Location: login.php");
endif;