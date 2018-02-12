<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Craig Holcomb Jr</title>
        <meta charset="utf-8">
        <meta name="author" content="Austin Batistoni">
        <meta name="description" content="Website for Actor Craig Holcomb Jr.">

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!--[if lt IE 9]>
        <script src="//html5shim.googlecode.com/sin/trunk/html5.js"></script>
        <![endif]-->

        <link rel="stylesheet" href="css/base.css" type="text/css" media="screen">

        <?php
        // %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
        //
        // inlcude all libraries. 
        // 
        // %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
        print '<!-- begin including libraries -->';
        
        include 'lib/constants.php';

        include LIB_PATH . '/Connect-With-Database.php';
        //include LIB_PATH . '/constants.php';
        include LIB_PATH . '/mail-message.php';
        include LIB_PATH . '/security.php';
        include LIB_PATH . '/validation-functions.php';

        print '<!-- libraries complete-->';
        
        $phpSelf = htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES, "UTF-8");
        
        $username = htmlentities($_SERVER["REMOTE_USER"], ENT_QUOTES, "UTF-8");
        
        $isAdmin = true;
        
      

        ?>	

    </head>
    <!-- **********************     Body section      ********************** -->
    <?php
    print '<body ';

    print ' id="' . $PATH_PARTS['filename'] . '">';
    
    include 'header.php';
    include 'nav.php';
    ?>
