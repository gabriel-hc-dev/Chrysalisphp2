<?php
include_once('../backend/conexao.php');
session_start();
unset($_SESSION['usuario_id']);
unset($_SESSION['usuario_email']);
session_destroy();
$_SESSION = array();
include_once('limparCache.php');
header('Location: login.php');
exit();
?>