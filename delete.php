<?php
$xmlFile = 'data.xml';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if (file_exists($xmlFile)) {
        $xml = simplexml_load_file($xmlFile);
        
        foreach ($xml->user as $index => $user) {
            if ((string)$user['id'] === $id) { // Check user by unique ID
                unset($xml->user[$index]);
                break; // Exit loop once found and deleted
            }
        }

        $xml->asXML($xmlFile); // Save changes back to XML
    }
}
?>
