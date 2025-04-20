<?php
session_start();
session_destroy(); // सत्र समाप्त करें
header("Location: index.php"); // इंडेक्स पृष्ठ पर रीडायरेक्ट करें
exit();
?>