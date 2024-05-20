<?php
     /*
    Author: Ilias Motsenigos
    Date: 20/5/2024
    Last Updated: 20/5/2024
    Description: This php file is complementary to mainform.php and it dynamically updates a specific field through AJAX.
                By receiving the date, specialty, semester, class and subject from the main form of the parent file it runs a query to the application's
                database to fetch previous log book entries matching the data provided and then updates the appropriate
                element of the page (<div id="pastEntries">). In summary this code fetches the latest entries matching the class and
                subject selected by the user.
    */

    //handling of unauthorized users
    $_PERMISSIONS = array('teacher' => 1, 'admin' => 0, 'guest' => 0, 'super' => 1);
    include_once '../common/checkAuthorization.php';
    
?>
