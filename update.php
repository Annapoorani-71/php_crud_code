<?php
$xmlFile = 'data.xml';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $id = isset($_POST['id']) ? $_POST['id'] : null;

    // Load the XML file or create a new XML structure
    if (file_exists($xmlFile)) {
        $xml = simplexml_load_file($xmlFile);
    } else {
        $xml = new SimpleXMLElement('<?xml version="1.0"?><users></users>');
    }

    if ($id !== null) {
        // Update existing entry by ID
        foreach ($xml->user as $user) {
            if ((string)$user['id'] === $id) {
                $user->name = htmlspecialchars($name);
                $user->email = htmlspecialchars($email);
                break;
            }
        }
    } else {
        // Add new entry with a unique ID
        $newId = $xml->user ? (int)$xml->user[count($xml->user) - 1]['id'] + 1 : 1;
        $user = $xml->addChild('user');
        $user->addAttribute('id', $newId);
        $user->addChild('name', htmlspecialchars($name));
        $user->addChild('email', htmlspecialchars($email));
    }

    // Save the updated XML back to the file
    $xml->asXML($xmlFile);
}
?>
