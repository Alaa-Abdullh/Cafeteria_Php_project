<?php
session_start();
unset($_SESSION['user_id']);  
echo json_encode(['success' => true]);

?>