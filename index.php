<?php

require_once __DIR__ . '/vendor/autoload.php';

use Google\Cloud\Core\Exception\GoogleException;
use Google\Cloud\Firestore\FirestoreClient;

# Explicitly use service account credentials by specifying the private key file.
$config = [
    'keyFilePath' => 'firestore-demo-ruby-e1cbef86b597.json',
    'projectId' => 'firestore-demo-ruby',
];

$NEW_LINE = "<br>";

// Create the Cloud Firestore client
try {

    $db = new FirestoreClient($config);

} catch (GoogleException $e) {

    printf('Error : ' . $e->getMessage());

}

printf('Created Cloud Firestore client with default project ID.' . $NEW_LINE . $NEW_LINE);

/**
 * @param FirestoreClient $db
 */
function display_users(FirestoreClient $db)
{
    $usersRef = $db->collection('users');
    $snapshot = $usersRef->documents();
    foreach ($snapshot as $user) {
        printf('User: %s' . $GLOBALS['NEW_LINE'], $user->id());
        printf('First: %s' . $GLOBALS['NEW_LINE'], $user['first']);
        if (!empty($user['middle'])) {
            printf('Middle: %s' . $GLOBALS['NEW_LINE'], $user['middle']);
        }
        printf('Last: %s' . $GLOBALS['NEW_LINE'], $user['last']);
        printf('Born: %d' . $GLOBALS['NEW_LINE'], $user['born']);
        printf($GLOBALS['NEW_LINE']);
    }

    printf('Retrieved and printed out all documents from the users collection.' . $GLOBALS['NEW_LINE']. $GLOBALS['NEW_LINE']);
}

display_users($db);

$docRef = $db->collection('users')->document('lovelace2');
$docRef->set([
    'first' => 'Ada2',
    'last' => 'Lovelace2',
    'born' => 18152
]);
printf('Added data to the lovelace2 document in the users collection.' . $NEW_LINE . $NEW_LINE);

$docRef = $db->collection('users')->document('aturing2');
$docRef->set([
    'first' => 'Alan2',
    'middle' => 'Mathison2',
    'last' => 'Turing2',
    'born' => 19122
]);
printf('Added data to the aturing2 document in the users collection.' . $NEW_LINE. $NEW_LINE);

display_users($db);

