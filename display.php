<?php
$xmlFile = 'data.xml';

if (file_exists($xmlFile)) {
    $xml = simplexml_load_file($xmlFile);
    echo "<ul>";
    foreach ($xml->user as $user) {
        $userId = htmlspecialchars($user['id']); // Unique ID
        $userName = addslashes(htmlspecialchars($user->name)); // Name for display in prompt
        echo "<li>
                Name: " . htmlspecialchars($user->name) . " - Email: " . htmlspecialchars($user->email) . "
                <button onclick=\"editEntry('$userId', '" . addslashes($user->name) . "', '" . addslashes($user->email) . "')\">Edit</button>
                <button onclick=\"deleteEntry('$userId', '$userName')\">Delete</button>
              </li>";
    }
    echo "</ul>";
} else {
    echo "<p>No data available yet.</p>";
}
?>
