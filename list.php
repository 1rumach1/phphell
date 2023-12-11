<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbnat";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['nName'])) {
        // Delete record with prepared statement
        $stmt = $conn->prepare("DELETE FROM studlist WHERE nName=?");
        $stmt->bind_param("s", $_GET['nName']);
        $stmt->execute();
        $stmt->close();
        header("location:{$_SERVER['PHP_SELF']}");
    } elseif (isset($_GET['txtcourse']) && isset($_GET['txtname'])) {
        if (!empty($_GET['edit_nName'])) {
            // Update record with prepared statement
            $stmt = $conn->prepare("UPDATE studlist SET nName=?, course=? WHERE nName=?");
            $stmt->bind_param("sss", $_GET['txtname'], $_GET['txtcourse'], $_GET['edit_nName']);
        } else {
            // Insert record with prepared statement
            $stmt = $conn->prepare("INSERT INTO studlist (nName, course) VALUES (?, ?)");
            $stmt->bind_param("ss", $_GET['txtname'], $_GET['txtcourse']);
        }
        $stmt->execute();
        $stmt->close();
        header("location:{$_SERVER['PHP_SELF']}");
    }
}
?>

<html>

<body>
    <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <table style="font-family:calibri;border:1px solid grey">
            <tr>
                <td>Name</td>
                <td><input type="text" name="txtname" size="20" value="<?php echo isset($_GET['edit_nName']) ? $_GET['edit_nName'] : ''; ?>"></td>
            </tr>
            <tr>
                <td>course</td>
                <td><input type="text" name="txtcourse" size="50" value="<?php echo isset($_GET['edit_nName']) ? getCourse($_GET['edit_nName'], $conn) : ''; ?>">
                    <input type="hidden" name="edit_nName" value="<?php echo isset($_GET['edit_nName']) ? $_GET['edit_nName'] : ''; ?>">
                    <input type="button" value="Print" onclick="window.open('http://localhost/DOG/186/shimi.php')" />
                    <input type="submit" value="Save"></td>
            </tr>
        </table>
    </form>

    <table cellpadding="0" cellspacing="0" border="1" style="font-family:calibri;width:300px">
        <tr>
            <th></th>
            <th>Name</th>
            <th>course</th>
            <th>Edit</th>
        </tr>
        <?php
        $result = $conn->query('SELECT * FROM studlist');
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
            <td><a href='{$_SERVER['PHP_SELF']}?nName={$row['nName']}'><input type='button' value='x'></a></td>
            <td>{$row['nName']}</td>
            <td>{$row['Course']}</td>
            <td><a href='{$_SERVER['PHP_SELF']}?edit_nName={$row['nName']}'><input type='button' value='Edit'></a></td>
            </tr>";
        }
        ?>
    </table>
</body>

</html>

<?php
function getCourse($nName, $conn)
{
    $stmt = $conn->prepare("SELECT course FROM studlist WHERE nName=?");
    $stmt->bind_param("s", $nName);
    $stmt->execute();
    $stmt->bind_result($course);
    $stmt->fetch();
    $stmt->close();
    return $course;
}
?>
