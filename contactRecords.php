<?php
include "top.php";
if ($username == "abatisto" || $username == "rerickso" || $username == "ylin19"){
$query = "SELECT * FROM tblMailList ";
    print_r($query);

    if ($thisDatabaseReader->querySecurityOk($query, 0)) {
        $query = $thisDatabaseReader->sanitizeQuery($query);
        $records = $thisDatabaseReader->select($query, '');
    }


    print_r($records);

    print "<table id = contactRecords>";
    print "<tr>";
    print "<th>First Name</th>";
    print "<th>Last Name</th>";
    print "<th>Email</th>";
    print "<th>Age Range</th>";
    print "<th>Gender</th>";
    print "</tr>";
    
print '<h2 class="alternateRows">Contacts:  </h2>';
if (is_array($records)) {
    foreach ($records as $record) {
        print "\n\t<tr>";
        print '<td class = Firstname>' . $record['fldFirstName'] . '</td>';
        print '<td class = LastName>' . $record['fldLastName'] . '</td>';
        print '<td class = Email>' . $record['fldEmail'] . '</td>';
        print '<td class = AgeRange>' . $record['fldAgeRange'] . '</td>';
        print '<td class = Gender>' . $record['fldGender'] . '</td>';
        print '<td><a href = "form-contact.php?updateID=' . $record['pmkContactId'] . '">[Edit]</a></td>';
        print '<td><a href = "contactDel.php?updateID=' . $record['pmkContactId'] . '">[X]</a></td>';
        
        print "\n\t</tr>";
        
    }
   
        print "<td><a id = 'addRecord' href ='form-contact.php'>Add Record</a></td>     ";
    
}





print "</table>";
}