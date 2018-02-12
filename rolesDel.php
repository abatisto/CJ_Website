<?php
include "top.php";
if ($username == "abatisto" || $username == "rerickso" || $username == "ylin19"){
    
    $update = false;
    
    if(isset($_GET['updateID'])){
        $updateID = htmlentities($_GET['updateID'], ENT_QUOTES, "UTF-8");
        
        $update = true;
        
        $query = 'SELECT * FROM tblActingRoles WHERE pmkRoleId = ?';
        $data = array($updateID);
        
        if($thisDatabaseReader->querySecurityOk($query, 1)){
            $query = $thisDatabaseReader->sanitizeQuery($query);
            $role = $thisDatabaseReader->select($query, $data);
        }
        
   
        $roleName = $role[0]["fldRoleName"];
        $roleType = $role[0]["fldRoleType"];
        $description = $role[0]["fldDescription"]; 
        $year = $role[0]["fldYear"];
        
        print "<h2 id='deleting'>Deleted Record: </h2>";
        print "<p>Role ID: " . $updateID . "</p>";
        print "<p>Role Name: " . $roleName . "</p>";
        print "<p>Role Type: " . $roleType . "</p>";
        print "<p>Description: " . $description . "</p>";
        print "<p>Year: " . $year . "</p>";
        
        try {
            $thisDatabaseWriter->db->beginTransaction();
            
            $query = 'DELETE FROM tblActingRoles ';
            $query .= 'WHERE pmkRoleId = ? ';
            $data1[] = $updateID;

                    if ($thisDatabaseReader->querySecurityOk($query, 1)) {
                        $query = $thisDatabaseWriter->sanitizeQuery($query);
                        $results = $thisDatabaseWriter->delete($query, $data1);
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