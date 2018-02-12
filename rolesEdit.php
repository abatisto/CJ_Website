<?php
include "top.php";
if ($username == "abatisto" || $username == "rerickso" || $username == "ylin19"){

    $update = false;
    
    $acting = false;
    $modeling = false;
    
    if (isset($_GET['updateID'])){
        $updateID = htmlentities($_GET['updateID'], ENT_QUOTES, "UTF-8");

        //if($updateID > 0){
            $update = true;
        //}

        $query = 'SELECT * FROM tblActingRoles WHERE pmkRoleId = ?' ;
        //$query .= $updateID;
        $data = array($updateID);

        if ($thisDatabaseReader->querySecurityOk($query, 1)) {
            $query = $thisDatabaseReader->sanitizeQuery($query);
            $role = $thisDatabaseReader->select($query, $data);
        }

        $roleName = $role[0]["fldRoleName"];
        $roleTypes = $role[0]["fldRoleType"];
        $description = $role[0]["fldDescription"]; 
        $year = $role[0]["fldYear"];


    }else{
        $roleName = ""; 
        $roleTypes = "Acting";
        $description= "";
        $year = "";
    }



    // Step Two: create your query
    $query = "SELECT DISTINCT fldRoleType ";
    $query .= "FROM tblActingRoles ";
    $query .= "ORDER BY fldRoleType ";


    // Step Three: run your query being sure to implement security
    if ($thisDatabaseReader->querySecurityOk($query, 0, 1)) {
        $query = $thisDatabaseReader->sanitizeQuery($query);
        $roleTypes = $thisDatabaseReader->select($query, '');
    }


    //Initialize errors 
    $roleNameERROR = false;
    $roleTypeERROR = false;
    $descriptionERROR = false;
    $yearERROR = false;

    $errorMsg = array();
    $data = array();
    $dataEntered = false;


    //Begin if button is submitted
    if (isset($_POST["btnSubmit"])) {


        //Sanitize input

        $updateID = (int) htmlentities($_POST["hidRoleId"], ENT_QUOTES, "UTF-8");
        if ($updateID > 0) {
            $update = true;
        }
        $roleName = htmlentities($_POST["txtRoleName"], ENT_QUOTES, "UTF-8");
        $data[] = $roleName;

        $roleTypeChosen= htmlentities($_POST["radRoleType"], ENT_QUOTES, "UTF-8");
        $data[] = $roleTypeChosen;

        $description = htmlentities($_POST["txtDescription"], ENT_QUOTES, "UTF-8");
        $data[] = $description;

        $year = htmlentities($_POST["txtYear"], ENT_QUOTES, "UTF-8");
        $data[] = $year;

        $query = 'SELECT * FROM tblActingRoles WHERE fldRoleName = ? ';


        if ($thisDatabaseReader->querySecurityOk($query, 1)) {
            $query = $thisDatabaseReader->sanitizeQuery($query);
            $trail = $thisDatabaseReader->select($query, $trailName);
        }

        $roleID = $role["pmkRoleId"];




        //Validate input 
        if ($roleName == ""){
            $errorMsg[] = "Please enter a role name";         
            $roleNameERROR = true;     
        }
        
        if (!isset ($_POST["radRoleType"])) {
            $errorMsg[] = "Please enter the role type";
            $roleTypeERROR = true;
        }

        if ($description == "") {
            $errorMsg[] = "Please enter the role description";
            $descriptionERROR = true;
        }

        if ($year == "") {
            $errorMsg[] = "Please enter the role year";
            $yearERROR = true;
        }

        





    //If the form is valid
        if (!$errorMsg) {
            //if ($debug) {
                print "<p>Form is valid</p>";
            //}

        //Save data
        $dataEntered = false;
            try {
                $thisDatabaseWriter->db->beginTransaction();

                //If updating, call UPDATE SQL command
                if ($update){
                    print "updating!";
                    $query = 'UPDATE tblActingRoles SET ';
                    
                //Otherwise call INSERT SQL command
                } else {
                    $query = 'INSERT INTO tblActingRoles SET ';
                }

                $query .= 'fldRoleName = ?, ';
                $query .= 'fldRoleType = ?, ';
                $query .= 'fldDescription = ?, ';
                $query .= 'fldyear = ? ';

                if ($update) {
                    $query .= 'WHERE pmkRoleId = ?';
                    $data[] = $updateID;
                    print_r($query);

                    if ($thisDatabaseReader->querySecurityOk($query, 1)) {
                        $query = $thisDatabaseWriter->sanitizeQuery($query);
                        $results = $thisDatabaseWriter->update($query, $data);
                    }

                } else {
                    print_r($query);
                    print_r($data);
                    // You really don't need to test this query, i left it here for you.

                    if ($debug) {
                        $thisDatabaseWriter->TestSecurityQuery($query, 0);
                        print_r($data);
                    }

                    if ($thisDatabaseWriter->querySecurityOk($query, 0)) {
                        $query = $thisDatabaseWriter->sanitizeQuery($query);
                        $results = $thisDatabaseWriter->insert($query, $data);
                        $primaryKey = $thisDatabaseWriter->lastInsert();
                    }

                    if ($debug) {
                        print "<p>pmk= " . $primaryKey;
                    }
                }  


                // all sql statements are done so lets commit to our changes

                $dataEntered = $thisDatabaseWriter->db->commit();

                if ($debug)
                    print "<p>transaction complete ";
            } catch (PDOExecption $e) {
                $thisDatabase->db->rollback();
                if ($debug)
                    print "Error!: " . $e->getMessage() . "</br>";
                $errorMsg[] = "There was a problem with accpeting your data please contact us directly.";
            }

        }

    }

    //Print out any error messages
            if ($errorMsg) {
                print '<div id="errors">';
                print '<h2 class="mistakes">Your form has the following mistakes</h2>';
                print "<ol>\n";
                foreach ($errorMsg as $err) {
                    print "<li class = 'mistakes'>" . $err . "</li>\n";
                }
                print "</ol>\n";
                print '</div>';
            }



    // Step Four: prepare html output

    ?>

            <h2>Document a Role:</h2>

            <form action="<?php print $phpSelf; ?>"
                  method="post"
                  id="frmRegister">

                <input type="hidden" id="hidRoleId" name="hidRoleId"
                       value="<?php print $updateID; ?>"
                       >

                <!--Role name text box-->
                <fieldset>
                    <label for="txtRoleName" class="required">Role Name
                        <input type="text" id="txtRoleName" name="txtRoleName"
                               value="<?php print $roleName; ?>"
                               tabindex="100" maxlength="45" placeholder="Enter role name"
                               <?php if ($roleNameERROR) print 'class="mistake"'; ?>
                               onfocus="this.select()"
                               >
                    </label>
                </fieldset>
                
                <!--Role type radio buttons-->
                <?php
                $output = array();
                $output[] = '<fieldset class="radio ';
                if ($roleTypeERROR) {
                    $output[] = ' mistake';
                }
                $output[] = '">';
                $output[] = '<legend>Choose a role type:</legend>';

                if (is_array($roleTypes)) {
                    foreach ($roleTypes as $roleType) {
                        //$output[] = $roleType;

                        $output[] = '<label for="rad' . str_replace(" ", "-", $roleType["fldRoleType"]) . '"><input type="radio" ';
                        $output[] = ' id="rad' . str_replace(" ", "-", $roleType["fldRoleType"]) . '" ';
                        $output[] = ' name="radRoleType" ';


                        if ($roleType["fldRoleType"] == "Acting") {

                            if ($acting) {
                                $output[] = ' checked ';
                            }
                        }

                        if ($roleType["fldRoleType"] == "Modeling") {
                            if ($modeling) {
                                $output[] = ' checked ';
                            }
                        }



                // -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-

                        $output[] = 'value="' . $roleType["fldRoleType"] . '">' . $roleType["fldRoleType"] ;
                        $output[] = '</label>';
                    }
                }
                $output[] = '</fieldset>';
                print join("\n", $output);
                ?>

                <!--Total Distance text box-->
                <fieldset>
                    <label for="txtDescription" class="required">Role Description
                        <input type="text" id="txtDescription" name="txtDescription"
                               value="<?php print $description; ?>"
                               tabindex="100" maxlength="45" placeholder="Enter role description"
                               <?php if ($descriptionERROR) print 'class="mistake"'; ?>
                               onfocus="this.select()"
                               >
                    </label>
                </fieldset>

                <!--Hiking time text box-->
                <fieldset>
                    <label for="txtYear" class="required">Year
                        <input type="text" id="txtYear" name="txtYear"
                               value="<?php print $year; ?>"
                               tabindex="100" maxlength="45" placeholder="Enter the role year"
                               <?php if ($yearERROR) print 'class="mistake"'; ?>
                               onfocus="this.select()"
                               >
                    </label>
                </fieldset>



                <!--Submit button-->
                <fieldset class="buttons">
                    <input type="submit" id="btnSubmit" name="btnSubmit" value="Save" tabindex="900" class="button">
                </fieldset> <!-- ends buttons -->
            </form>


    <?php
    include 'footer.php';
}else{
    print("<p>You do not have permission to view this page</p>");
}
?>
