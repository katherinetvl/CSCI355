<?php 
    require_once('netflixconfig.php');
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
<h2> Current Database is: forphpconnect </h2>
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

        $host = 'localhost:3308';
        $user = 'root';
        $pw = '';
        $database = 'netflix';
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
            <input type = "number" id = "id" name = "id" min = "0" max = "18446744073709551615"></input></br>
            <label for ="CreditCardNumber">CreditCardNumber:</label></br>
            <input type = "number" id = "CreditCardNumber" name = "CreditCardNumber" min = "0" max = "18446744073709551615"></input><br>
            <label for = "CVV"> CVV:</label></br>
            <input type = "number" id = "CVV" name = "CVV" min = "001" max = "999"> </input></br>
            <label for ="ExpirationDate">ExpirationDate:</label></br>
            <input type = "date" id = "ExpirationDate" name = "ExpirationDate"></input><br>
            <label for = "AcctID "> AcctID :</label></br>
            <input type = "number" id = "AcctID" name = "AcctID" min = "0" max = "18446744073709551615"></input></br>
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

            <label> WHERE column: (Specify for UPDATE command only)
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
                    $sql = "INSERT INTO payment_method (id, CreditCardNumber, CVV, ExpirationDate, AcctID) VALUES ('$id', '$CreditCardNumber', '$CVV', '$ExpirationDate', '$AcctID')"; 
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
                else if(isset($_POST['CreditCardNumber']) && isset($_POST['CVV']) && isset($_POST['ExpirationDate']) && isset($_POST['AcctID']))
                {
                    $CreditCardNumber = $_POST['CreditCardNumber'];
                    $CVV = $_POST['CVV'];
                    $ExpirationDate = $_POST['ExpirationDate'];
                    $AcctID = $_POST['AcctID'];
                    $sql = "INSERT INTO payment_method (CreditCardNumber, CVV, ExpirationDate, AcctID) VALUES ('$CreditCardNumber', '$CVV', '$ExpirationDate', '$AcctID')"; 
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
                else if(isset($_POST['CreditCardNumber']) && isset($_POST['CVV']) && isset($_POST['AcctID']))
                {
                    $CreditCardNumber = $_POST['CreditCardNumber'];
                    $CVV = $_POST['CVV'];
                    $AcctID = $_POST['AcctID'];
                    $sql = "INSERT INTO payment_method (CreditCardNumber, CVV, AcctID) VALUES ('$CreditCardNumber', '$CVV', '$AcctID')"; 
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
                else if(isset($_POST['CreditCardNumber']) && isset($_POST['ExpirationDate']) && isset($_POST['AcctID']))
                {
                    $CreditCardNumber = $_POST['CreditCardNumber'];
                    $ExpirationDate = $_POST['ExpirationDate'];
                    $AcctID = $_POST['AcctID'];
                    $sql = "INSERT INTO payment_method (CreditCardNumber, ExpirationDate, AcctID) VALUES ('$CreditCardNumber', '$ExpirationDate', '$AcctID')"; 
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
                    if(isset($_POST['CreditCardNumber']) && isset($_POST['AcctID']))
                    {
                        $CreditCardNumber = $_POST['CreditCardNumber'];
                        $AcctID = $_POST['AcctID'];
                        $sql = "INSERT INTO payment_method (CreditCardNumber, AcctID) VALUES ('$CreditCardNumber', '$AcctID')"; 
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
                }
            }
            if($theCommand == "select")
            {
                if(isset($_POST['id']))
                {
                    $id = $_POST['id'];
                    $sql = "SELECT * FROM payment_method WHERE id = '$id'";
                    if (mysqli_query($mysqli, $sql)) 
                    {
                        $mysqli = new mysqli($host, $user, $pw, $database);
                        $result = $mysqli->query($sql) or die($mysqli->error);
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
                    }
                    else 
                    {
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }
                }
                else if(isset($_POST['CreditCardNumber']) && isset($_POST['CVV']) && isset($_POST['ExpirationDate']) && isset($_POST['AcctID']))
                {
                    $CreditCardNumber = $_POST['CreditCardNumber'];
                    $CVV = $_POST['CVV'];
                    $ExpirationDate = $_POST['ExpirationDate'];
                    $AcctID = $_POST['AcctID'];
                    $sql = "SELECT * FROM payment_method WHERE CreditCardNumber = '$CreditCardNumber' AND CVV = '$CVV' AND ExpirationDate = '$ExpirationDate' AND AcctID = '$AcctID'";
                    if (mysqli_query($mysqli, $sql)) 
                    {
                        $mysqli = new mysqli($host, $user, $pw, $database);
                        $result = $mysqli->query($sql) or die($mysqli->error);
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
                    } 
                    else 
                    {
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }
                }
                else if(isset($_POST['CreditCardNumber']) && isset($_POST['CVV']) && isset($_POST['AcctID']))
                {
                    $CreditCardNumber = $_POST['CreditCardNumber'];
                    $CVV = $_POST['CVV'];
                    $AcctID = $_POST['AcctID'];
                    $sql = "SELECT * FROM payment_method WHERE CreditCardNumber = '$CreditCardNumber' AND CVV = '$CVV' AND AcctID = '$AcctID'";
                    
                    if (mysqli_query($mysqli, $sql)) 
                    {
                        $mysqli = new mysqli($host, $user, $pw, $database);
                        $result = $mysqli->query($sql) or die($mysqli->error);
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
                    } 
                    else 
                    {
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }
                }
                else if(isset($_POST['CreditCardNumber']) && isset($_POST['ExpirationDate']) && isset($_POST['AcctID']))
                {
                    $CreditCardNumber = $_POST['CreditCardNumber'];
                    $ExpirationDate = $_POST['ExpirationDate'];
                    $AcctID = $_POST['AcctID'];
                    $sql = "SELECT * FROM payment_method WHERE CreditCardNumber = '$CreditCardNumber' AND CVV = '$CVV' AND ExpirationDate = '$ExpirationDate' AND AcctID = '$AcctID'";
                    
                    if (mysqli_query($mysqli, $sql)) 
                    {
                        $mysqli = new mysqli($host, $user, $pw, $database);
                        $result = $mysqli->query($sql) or die($mysqli->error);
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
                    } 
                    else 
                    {
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }
                }
                else if(isset($_POST['CreditCardNumber']) && isset($_POST['AcctID']))
                {
                    $CreditCardNumber = $_POST['CreditCardNumber'];
                    $AcctID = $_POST['AcctID'];
                    $sql = "SELECT * FROM payment_method WHERE CreditCardNumber = '$CreditCardNumber' AND CVV = '$CVV' AND ExpirationDate = '$ExpirationDate' AND AcctID = '$AcctID'";
                    
                    if (mysqli_query($mysqli, $sql)) 
                    {
                        $mysqli = new mysqli($host, $user, $pw, $database);
                        $result = $mysqli->query($sql) or die($mysqli->error);
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
                    } 
                    else 
                    {
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }
                }
                else 
                {
                    if(isset($_POST['CreditCardNumber']))
                    {
                        $CreditCardNumber = $_POST['CreditCardNumber'];
                        $sql = "SELECT * FROM payment_method WHERE CreditCardNumber = '$CreditCardNumber'";
                        if (mysqli_query($mysqli, $sql)) 
                        {
                            $mysqli = new mysqli($host, $user, $pw, $database);
                            $result = $mysqli->query($sql) or die($mysqli->error);
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
                        } 
                        else 
                        {
                            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                        }
                    }
                    if(isset($_POST['AcctID']))
                    {
                        $AcctID = $_POST['AcctID'];
                        $sql = "SELECT * FROM payment_method WHERE AcctID = '$AcctID'";
                        if (mysqli_query($mysqli, $sql)) 
                        {
                            $mysqli = new mysqli($host, $user, $pw, $database);
                            $result = $mysqli->query($sql) or die($mysqli->error);
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
                        } 
                        else 
                        {
                            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                        }
                    }
                }
            }
            if($theCommand == "update")
            {
                if(isset($_POST['whereCondition']))
                {
                    $whereCondition = $_POST['whereCondition'];
                    
                    if(!$whereCondition == "id")
                    {
                        echo "Specify id for WHERE clause <br>";
                    }
                    else
                    {
                        if(isset($_POST['id']))
                        {
                            $id = $_POST['id'];

                            if(isset($_POST['CVV']) && isset($_POST['ExpirationDate']))
                            {
                                $CVV = $_POST['CVV'];
                                $ExpirationDate = $_POST['ExpirationDate'];
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
                            else if(isset($_POST['CVV']))
                            {
                                $CVV = $_POST['CVV'];
                                $sql = "UPDATE payment_method SET CVV = '$CVV' WHERE id = '$id'"; 
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
                            else if(isset($_POST['ExpirationDate']))
                            {
                                $ExpirationDate = $_POST['ExpirationDate'];
                                $sql = "UPDATE payment_method SET ExpirationDate = '$ExpirationDate' WHERE id = '$id'"; 
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
                                if(isset($_POST['CreditCardNumber']) && isset($_POST['AcctID']))
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
                            }
                        }
                    }
                }
                // gonna delete all the below. Limiting user to 
                // just id for updating. 
                    if($whereCondition == "CreditCardNumber")
                    {
                        if(isset($_POST['CreditCardNumber']))
                        {
                            $CreditCardNumber = $_POST['CreditCardNumber'];
                            if(isset($_POST['id']))
                            {
                                $id = $_POST['id'];
                                $sql = "UPDATE payment_method SET id = '$id' WHERE CreditCardNumber = '$CreditCardNumber'"; 
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
                            else if(isset($_POST['CVV']) && isset($_POST['ExpirationDate']))
                            {
                                $CVV = $_POST['CVV'];
                                $ExpirationDate = $_POST['ExpirationDate'];
                                $sql = "UPDATE payment_method SET CVV = '$CVV', ExpirationDate ='$ExpirationDate' WHERE CreditCardNumber = '$CreditCardNumber'"; 
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
                            else if(isset($_POST['CVV']))
                            {
                                $CVV = $_POST['CVV'];
                                $sql = "UPDATE payment_method SET CVV = '$CVV' WHERE CreditCardNumber = '$CreditCardNumber'"; 
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
                                if(isset($_POST['ExpirationDate']))
                                {
                                    $ExpirationDate = $_POST['ExpirationDate'];
                                    $sql = "UPDATE payment_method SET ExpirationDate = '$ExpirationDate' WHERE CreditCardNumber = '$CreditCardNumber'"; 
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
                            }
                        }
                        else 
                        {
                            echo "Specify CreditCardNumber value for WHERE clause <br>";
                        }
                    }
                    if($whereCondition == "AcctID")
                    {
                        if(isset($_POST['AcctID']))
                        {
                            $AcctID = $_POST['AcctID'];
                            if(isset($_POST['id']))
                            {
                                $id = $_POST['id'];
                                $sql = "UPDATE payment_method SET id = '$id' WHERE AcctID = '$AcctID'"; 
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
                            else if(isset($_POST['CVV']) && isset($_POST['ExpirationDate']))
                            {
                                $CVV = $_POST['CVV'];
                                $ExpirationDate = $_POST['ExpirationDate'];
                                $sql = "UPDATE payment_method SET CVV = '$CVV', ExpirationDate ='$ExpirationDate' WHERE AcctID = '$AcctID'"; 
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
                            else if(isset($_POST['CVV']))
                            {
                                $CVV = $_POST['CVV'];
                                $sql = "UPDATE payment_method SET CVV = '$CVV' WHERE AcctID = '$AcctID'"; 
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
                                if(isset($_POST['ExpirationDate']))
                                {
                                    $ExpirationDate = $_POST['ExpirationDate'];
                                    $sql = "UPDATE payment_method SET ExpirationDate = '$ExpirationDate' WHERE AcctID = '$AcctID'"; 
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
                            }
                        }
                        else 
                        {
                            echo "Specify AcctID value for WHERE clause <br>";
                        }
                    }
                }
                else 
                {
                    echo "Specify the column for the WHERE clause <br>";
                }
            }
            if($theCommand == "delete")
            {
                if(isset($_POST['id']))
                {
                    $id = $_POST['id'];
                    $sql = "DELETE FROM payment_method WHERE id = '$id'";
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
                    $sql = "DELETE FROM payment_method WHERE CreditCardNumber = '$CreditCardNumber' AND AcctID = '$AcctID'"; 
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
                else if(isset($_POST['CreditCardNumber']))
                {
                    $CreditCardNumber = $_POST['CreditCardNumber'];
                    $sql = "DELETE FROM payment_method WHERE CreditCardNumber = '$CreditCardNumber'"; 
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
                    if(isset($_POST['AcctID']))
                    {
                        $AcctID = $_POST['AcctID'];
                        $sql = "DELETE FROM payment_method WHERE AcctID = '$AcctID'"; 
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
                }
            }
        }

        // Let user perform another action
        echo "<br>";
        echo "<a href='netflixindex.php'>" . "Return to Homepage" . "</a>";
    }
    else
    {
        echo "Please fill out form to continue.";
    }
    ?>
</body>
</html>