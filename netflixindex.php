<?php 
    require_once('netflixconfig.php');
    $host = 'localhost:3308';
    $user = 'root';
    $pw = '';
    $database = 'netflix';
?>

<!DOCTYPE html> 
<html>
<head>
    <title> Katherine Le - CRUD via PHP for Netflix </title>
    <style>
         table, th, td {
            border: 1px solid black;
         }
      </style>
</head> 
<body>
<h2> Current Database is: Netflix </h2>
    <?php 
        if($mysqli)
        {
            echo "<b> Current Table: </b><br>";
            echo "<pre>     payment_method</pre><br>";
            echo "<b> Columns: </b><br>";
            echo "<pre>     id(PK) | CreditCardNumber(NN) | CVV | ExpirationDate | AcctID (NN)</pre><br>";
            echo "<pre>     Composite Unique Key ON (AcctID, CreditCardNumber) </pre><br>";
            echo "----------------------------------------------------------------------------------- <br>";
        }

        $mysqli = new mysqli($host, $user, $pw, $database);
        $result = $mysqli->query("SELECT * FROM payment_method") or die($mysqli->error);
    ?>
        <table>
            <thead>
            <th style="padding:10px"> id </th>
            <th style="padding:10px"> CreditCardNumber </th>
            <th style="padding:10px"> CVV </th>
            <th style="padding:10px"> ExpirationDate </th>
            <th style="padding:10px"> AcctID </th>
            </thead>

        <?php
            while($row = $result->fetch_assoc()): ?>
            <tr>
            <td style="padding:10px"><?php echo $row['id']; ?></td>
            <td style="padding:10px"><?php echo $row['CreditCardNumber']; ?></td>
            <td style="padding:10px"><?php echo $row['CVV']; ?></td>
            <td style="padding:10px"><?php echo $row['ExpirationDate']; ?></td>
            <td style="padding:10px"><?php echo $row['AcctID']; ?></td>
            </tr>
        <?php endwhile; ?>
        </table>

    <?php
       if($_SERVER['REQUEST_METHOD'] == 'GET')
       {
        ?>
        <p> Enter values below as well as choose command.</p>
        <form method = "POST" action = "netflixindex.php">
            <label for = "id">id:</label><br>
            <input type = "number" id = "id" name = "id" min = "1" max = "18446744073709551615"></input></br>
            <label for ="CreditCardNumber">CreditCardNumber:</label></br>
            <input type = "number" id = "CreditCardNumber" name = "CreditCardNumber" min = "1111111111111111" max = "9999999999999999"></input><br>
            <label for = "CVV"> CVV:</label></br>
            <input type = "number" id = "CVV" name = "CVV" min = "111" max = "999"> </input></br>
            <label for ="ExpirationDate">ExpirationDate:</label></br>
            <input type = "date" id = "ExpirationDate" name = "ExpirationDate"></input><br>
            <label for = "AcctID "> AcctID :</label></br>
            <input type = "number" id = "AcctID" name = "AcctID" min = "1" max = "18446744073709551615"></input></br>
            <br>

            <label> Commands: 
            <br>
                <select name="commands[]" size="4" multiple>
                <option value= "insert">Insert</option>
                <option value= "select">Select</option>
                <option value= "update">Update</option>
                <option value= "delete">Delete</option>
                </select>
            </label>
            <br>

            <p>----------------------------------------------------------------------------------- </p>
            <label> WHERE column: (Specify for update command only)
            <br>
            <select name="whereCondition" size="5">
                <option value= "id">id</option>
                <option value= "CreditCardNumber">CreditCardNumber</option>
                <option value= "CVV">CVV</option>
                <option value= "ExpirationDate">ExpirationDate</option>
                <option value= "AcctID">AcctID</option>
                </select>
            </label>
            <br>
            <br>
            <br>
            <button type = "submit" name = "submit"> Submit </button></br>
        </form>
        <?php 
       }
    else if(isset($_POST['submit']))
    {
        if(isset($_POST['commands']))
        {
            $commandArr = array();
            foreach($_POST['commands'] as $singleCommand)
            {
                $commandArr[] = $singleCommand;
            }
        }

        foreach($commandArr as $theCommand)
        {
            if($theCommand == "insert")
            {
                if(isset($_POST['id']) && isset($_POST['CreditCardNumber']) && isset($_POST['CVV']) && isset($_POST['ExpirationDate']) && isset($_POST['AcctID']))
                {
                    $id = $_POST['id']; 
                    $CreditCardNumber = $_POST['CreditCardNumber'];
                    $CVV = $_POST['CVV'];
                    $ExpirationDate = $_POST['ExpirationDate'];
                    $AcctID = $_POST['AcctID'];

                    $mysqli = new mysqli($host, $user, $pw, $database);
                    $sql = "INSERT INTO payment_method (id, CreditCardNumber, CVV, ExpirationDate, AcctID) VALUES (?, ?, ?, ?, ?)"; 

                    $stmt = $mysqli->prepare($sql);
                    $stmt->bind_param("iiisi", $id, $CreditCardNumber, $CVV, $ExpirationDate, $AcctID);
                    $stmt->execute();
                    echo "<br>Query has been processed. <br>";
                    printf("Affected rows (INSERT): %d\n", $mysqli->affected_rows);
                    $mysqli->close();
                }
                else if(isset($_POST['CreditCardNumber']) && isset($_POST['CVV']) && isset($_POST['ExpirationDate']) && isset($_POST['AcctID']))
                {
                    $CreditCardNumber = $_POST['CreditCardNumber'];
                    $CVV = $_POST['CVV'];
                    $ExpirationDate = $_POST['ExpirationDate'];
                    $AcctID = $_POST['AcctID'];
                    
                    $mysqli = new mysqli($host, $user, $pw, $database);
                    $sql = "INSERT INTO payment_method (CreditCardNumber, CVV, ExpirationDate, AcctID) VALUES (?, ?, ?, ?)"; 

                    $stmt = $mysqli->prepare($sql);
                    $stmt->bind_param("iisi", $CreditCardNumber, $CVV, $ExpirationDate, $AcctID);
                    $stmt->execute();
                    echo "<br>Query has been processed. <br>";
                    printf("Affected rows (INSERT): %d\n", $mysqli->affected_rows);
                    $mysqli->close();
                }
                else if(isset($_POST['CreditCardNumber']) && isset($_POST['CVV']) && isset($_POST['AcctID']))
                {
                    $CreditCardNumber = $_POST['CreditCardNumber'];
                    $CVV = $_POST['CVV'];
                    $AcctID = $_POST['AcctID'];

                    $mysqli = new mysqli($host, $user, $pw, $database);
                    $sql = "INSERT INTO payment_method (CreditCardNumber, CVV, AcctID) VALUES (?, ?, ?)"; 

                    $stmt = $mysqli->prepare($sql);
                    $stmt->bind_param("iii", $CreditCardNumber, $CVV, $AcctID);
                    $stmt->execute();
                    echo "<br>Query has been processed. <br>";
                    printf("Affected rows (INSERT): %d\n", $mysqli->affected_rows);
                    $mysqli->close();
                }
                else if(isset($_POST['CreditCardNumber']) && isset($_POST['ExpirationDate']) && isset($_POST['AcctID']))
                {
                    $CreditCardNumber = $_POST['CreditCardNumber'];
                    $ExpirationDate = $_POST['ExpirationDate'];
                    $AcctID = $_POST['AcctID'];

                    $mysqli = new mysqli($host, $user, $pw, $database);
                    $sql = "INSERT INTO payment_method (CreditCardNumber, ExpirationDate, AcctID) VALUES (?, ?, ?)"; 

                    $stmt = $mysqli->prepare($sql);
                    $stmt->bind_param("isi", $CreditCardNumber, $ExpirationDate, $AcctID);
                    $stmt->execute();
                    echo "<br>Query has been processed. <br>";
                    printf("Affected rows (INSERT): %d\n", $mysqli->affected_rows);
                    $mysqli->close();
                }
                else if(isset($_POST['CreditCardNumber']) && isset($_POST['AcctID']))
                {
                    $CreditCardNumber = $_POST['CreditCardNumber'];
                    $AcctID = $_POST['AcctID'];

                    $mysqli = new mysqli($host, $user, $pw, $database);
                    $sql = "INSERT INTO payment_method (CreditCardNumber, AcctID) VALUES (?, ?)"; 

                    $stmt = $mysqli->prepare($sql);
                    $stmt->bind_param("ii", $CreditCardNumber, $AcctID);
                    $stmt->execute();
                    echo "<br>Query has been processed. <br>";
                    printf("Affected rows (INSERT): %d\n", $mysqli->affected_rows);
                    $mysqli->close();
                }
                else
                {
                    echo "Enter values to insert into table <br>";
                    exit("<a href='netflixindex.php'>" . "Return to Homepage" . "</a>");
                }
            }
            if($theCommand == "select")
            {
                if(isset($_POST['id']))
                {
                    $id = $_POST['id'];

                    $mysqli = new mysqli($host, $user, $pw, $database);
                    $sql = "SELECT * FROM payment_method WHERE id = ?";
                    
                    $stmt = $mysqli->prepare($sql);
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                     
                    $result = $stmt->get_result();
                    ?>
                        <p> Selection result: </p>
                        <table>
                            <thead>
                            <th style="padding:10px"> id </th>
                            <th style="padding:10px"> CreditCardNumber </th>
                            <th style="padding:10px"> CVV </th>
                            <th style="padding:10px"> ExpirationDate </th>
                            <th style="padding:10px"> AcctID </th>
                            </thead>

                        <?php
                            while($row = $result->fetch_assoc()): ?>
                            <tr>
                            <td style="padding:10px"><?php echo $row['id']; ?></td>
                            <td style="padding:10px"><?php echo $row['CreditCardNumber']; ?></td>
                            <td style="padding:10px"><?php echo $row['CVV']; ?></td>
                            <td style="padding:10px"><?php echo $row['ExpirationDate']; ?></td>
                            <td style="padding:10px"><?php echo $row['AcctID']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                        </table>
                    <?php
                }
                else
                {
                    echo "Specify the id value for WHERE clause using the form <br>";
                }
            }
            if($theCommand == "update")
            {
                if(isset($_POST['whereCondition']))
                {
                    $whereCondition = $_POST['whereCondition'];
                    
                    // updating using id 
                    if($whereCondition == "id")
                    {
                        if(isset($_POST['id']))
                        {
                            $id = $_POST['id'];
    
                            if(isset($_POST['CVV']) && isset($_POST['ExpirationDate']))
                            {
                                if($_POST['CVV'] != '' && $_POST['ExpirationDate'] != '')
                                {
                                    $CVV = $_POST['CVV'];
                                    $ExpirationDate = $_POST['ExpirationDate'];
                                }
                                else 
                                {
                                    echo "Enter values for both CVV and ExpirationDate to update. <br>";
                                    exit("<a href='netflixindex.php'>" . "Return to Homepage" . "</a>");
                                }
                                $sql = "UPDATE payment_method SET CVV = '$CVV', ExpirationDate = '$ExpirationDate' WHERE id = '$id'"; 
                                if (mysqli_query($mysqli, $sql)) 
                                {
                                    $message = "$theCommand was executed. <br>";
                                    echo $message . "<br>";
                                } 
                                else 
                                {
                                    echo "Error: " . $sql . "<br>" . mysqli_error($mysqli);
                                }
                            }
                            else if(isset($_POST['CreditCardNumber']) && isset($_POST['AcctID']))
                            {
                                $CreditCardNumber = $_POST['CreditCardNumber'];
                                $AcctID = $_POST['AcctID'];
                                $sql = "UPDATE payment_method SET CreditCardNumber = '$CreditCardNumber', AcctID = '$AcctID' WHERE id = '$id'"; 
                                if (mysqli_query($mysqli, $sql)) 
                                {
                                    $message = "$theCommand was executed. <br>";
                                    echo $message . "<br>";
                                } 
                                else 
                                {
                                    echo "Error: " . $sql . "<br>" . mysqli_error($mysqli);
                                }
                            }
                            else
                            {
                                echo "Enter values for the pairs CVV and ExpirationDate or CreditCardNumber and AcctID that you'd like to update <br>";
                            }
                        }
                    }
                    else
                    {
                        echo "Specify the id value for WHERE clause <br>";
                    }
                }
                else 
                {
                    echo "Specify the column for WHERE clause <br>";
                }
            }
            if($theCommand == "delete")
            {
                if(isset($_POST['id']))
                {
                    $id = $_POST['id'];

                    $mysqli = new mysqli($host, $user, $pw, $database);
                    $sql = "DELETE FROM payment_method WHERE id = ?";

                    $stmt = $mysqli->prepare($sql);
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    echo "<br>Query has been processed. <br>";
                    printf("Affected rows (DELETE): %d\n", $mysqli->affected_rows);
                    $mysqli->close();
                }
                else if(isset($_POST['CreditCardNumber']) && isset($_POST['AcctID']))
                {
                    $CreditCardNumber = $_POST['CreditCardNumber'];
                    $AcctID = $_POST['AcctID'];

                    $mysqli2 = new mysqli($host, $user, $pw, $database);
                    $sql = "DELETE FROM payment_method WHERE CreditCardNumber = ? AND AcctID = ?"; 
                    $stmt = $mysqli->prepare($sql);
                    $stmt->bind_param("ii", $CreditCardNumber, $AcctID);
                    $stmt->execute();
                    echo "<br>Query has been processed. <br>";
                    printf("Affected rows (DELETE): %d\n", $mysqli2->affected_rows);
                    $mysqli2->close();
                }
                else
                {
                    echo "Enter id value or CreditCardNumber and AcctID values for WHERE clause in the form <br>";
                }
            }
        }

        // Let user perform another action
        echo "<br>";
        echo "<a href='netflixindex.php'>" . "Return to Homepage" . "</a>";
        echo "<br><br><br>";
    }
    else
    {
        echo "Please fill out form to continue.";
    }
    ?>
</body>
</html>