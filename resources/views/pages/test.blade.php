<?php
$response = "Dekujeme za zaslani SMS.";
Header ('Content-type: text/plain');
Header ('Content-length:'.strlen($response));
echo $response;
?>