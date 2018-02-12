<!-- ######################     Main Navigation   ########################## -->
<nav>
    <ol id="nav">
        <?php
        // This sets a class for current page so you can style it differently
            
            print '<li><h1 id = "title">Craig Holcomb Jr</h1><li>';
            print '<li ';
            if ($PATH_PARTS['filename'] == 'index') {
                print '><a class="activePage" href="index.php">Home</a></li>';
            }else{
                print '><a class="navLink" href="index.php">Home</a></li>';
            }
       
            print '<li ';
            if ($PATH_PARTS['filename'] == 'clips') {
                print '><a class="activePage" href="clips.php">Clips</a></li>';
            }else{
                print '><a class="navLink" href="clips.php">Clips</a></li>';
            }
            
            print '<li ';
            if ($PATH_PARTS['filename'] == 'photos') {
                print '><a class="activePage" href="photos.php">Photos</a></li>';
            }else{
                print '><a class="navLink" href="photos.php">Photos</a></li>';
            }
        
            print '<li ';
            if ($PATH_PARTS['filename'] == 'about') {
                print '><a class="activePage" href="about.php">About</a></li>';
            }else{
                print '><a class="navLink" href="about.php">About</a></li>';
            }
            
            print '<li ';
            if ($PATH_PARTS['filename'] == 'roles') {
                print '><a class="activePage" href="roles.php">Roles</a></li>';
            }else{
                print '><a class="navLink" href="roles.php">Roles</a></li>';
            }
            
            print '<li ';
            if ($PATH_PARTS['filename'] == 'resume') {
                print '><a class="activePage" href="resume.php">Resume</a></li>';
            }else{
                print '><a class="navLink" href="resume.php">Resume</a></li>';
            }
            
            print '<li ';
            if ($PATH_PARTS['filename'] == 'form-contact') {
                print '><a class="activePage" href="form-contact.php">Contact</a></li>';
            }else{
                print '><a class="navLink" href="form-contact.php">Contact</a></li>';
            }
        
        ?>
    </ol>
</nav>
<!-- #################### Ends Main Navigation    ########################## -->

