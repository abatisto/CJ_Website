<?php
include "top.php";
if ($username == "abatisto" || $username == "rerickso" || $username == "ylin19"){
    
    $update = false;
    
    if(isset($_GET['updateID'])){
        $updateID = htmlentities($_GET['updateID'], ENT_QUOTES, "UTF-8");
        
        $update = true;
        
        $query = 'SELECT * FROM tblMailList WHERE pmkContactId = ?';
        $data = array($updateID);
        
        if($thisDatabaseReader->querySecurityOk($query, 1)){
            $query = $thisDatabaseReader->sanitizeQuery($query);
            $contact = $thisDatabaseReader->select($query, $data);
        }
        
   
        $firstName = $contact[0]["fldFirstName"];
        $lastName = $contact[0]["fldLastName"];
        $email = $contact[0]["fldEmail"]; 
        $ageRange = $contact[0]["fldAgeRange"];
        $gender = $contact[0]["fldGender"];
        
        print "<h2 id='deleting'>Deleted Record: </h2>";
        print "<p>Contact ID: " . $updateID . "</p>";
        print "<p>Contact First Name: " . $firstName . "</p>";
        print "<p>Contact Last Name: " . $lastName . "</p>";
        print "<p>Email: " . $email . "</p>";
        print "<p>Age Range: " . $ageRange . "</p>";
        
        try {
            $thisDatabaseWriter->db->beginTransaction();
            
            $query = 'DELETE FROM tblMailList ';
            $query .= 'WHERE pmkContactId = ? ';
            $data1[] = $updateID;

                    if ($thisDatabaseReader->querySecurityOk($query, 1)) {
                        $query = $thisDatabaseWriter->sanitizeQuery($query);
                        $results = $thisDatabaseWriter->delete($query, $data1);
                    }
                    
            $query = 'DELETE FROM tblMailListContactType ';
            $query .= 'WHERE fnkContact = ? ';
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
