<?php
include 'top.php';

//##############################################################################
//
// This page lists the records based on the query given
// 
//##############################################################################
$records = '';
$orderBy = "ORDER BY fldYear";
$query = "SELECT * FROM tblActingRoles ";
$query .= $orderBy;

if ($thisDatabaseReader->querySecurityOk($query, 0, 1)) {
    $query = $thisDatabaseReader->sanitizeQuery($query);
    $records = $thisDatabaseReader->select($query);
}
$username = htmlentities($_SERVER["REMOTE_USER"], ENT_QUOTES, "UTF-8");
print('<p>User: '. $username . '</p>');
if($username == "abatisto" || $username == "rerickso" || $username == "ylin19"){
    print('<p>Admin = True</p>');
}
    
print "<h2>Roles</h2>";

print "<table>";
print "<tr>";
print "<th>Role Type</th>";
print "<th>Role Name</th>";
print "<th>Description</th>";
print "<th>Year</th>";
print "</tr>";
if (is_array($records)) {
    foreach ($records as $record) {
        print "\n\t<tr>";
        print '<td class = roleType>' . $record['fldRoleType'] . '</td>';
        print '<td class = roleName>' . $record['fldRoleName'] . '</td>';
        print '<td class = roleDesc>' . $record['fldDescription'] . '</td>';
        print '<td class = roleYear>' . $record['fldYear'] . '</td>';
        if($username == "abatisto" || $username == "rerickso" || $username == "ylin19"){ 
            print '<td><a href = "rolesEdit.php?updateID=' . $record['pmkRoleId'] . '">[Edit]</a></td>';
            print '<td><a href = "rolesDel.php?updateID=' . $record['pmkRoleId'] . '">[X]</a></td>';
        }
        print "\n\t</tr>";
        
    }
    if($username == "abatisto" || $username == "rerickso" || $username == "ylin19"){
        print "<tr><td><a id = 'addRecord' href ='rolesEdit.php'>Add Record</a></td></tr>     ";
        print '<tr><td><a href = "tables.php">Tables.php</a></td></tr>';
    }
}





print "</table>";
include 'footer.php';
?>