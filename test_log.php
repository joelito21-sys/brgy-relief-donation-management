<?php
file_put_contents('storage/logs/laravel.log', "\n" . date('Y-m-d H:i:s') . " Test entry\n", FILE_APPEND);
echo "Log entry added";
?>