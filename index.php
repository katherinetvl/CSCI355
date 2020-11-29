<?php 
// connect to database
$conn = mysqli_connect("localhost:3307", "root", "", "forphpconnect");

// check connection
if(!$conn)
{
    echo "Warning: Connection error" . mysqli_connect_error();
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title> Database Create, Retrieve, Update, Delete </title>
</head>
    <body>
    <?php 
        if($conn)
        {
            echo "Current Table: PAYMENT_METHOD <br>";
            echo "Current database: Netflix <br>";
            echo "Columns: id | CreditCardNumber(NN) | CVV | ExpirationDate | AcctID (NN) <br>";
        }
    ?>

    <?php 
        if($_SERVER['REQUEST_METHOD'] == 'GET')
        {
            ?>
            <!-- form begins -->
            <form method = "POST" action = "index.php">
            <label for="commands">Choose an option:</label>
            <select id="commands" name="commands" size="1">
            <option value="insert">Insert</option>
            <option value="select">Select</option>
            <option value="update">Update</option>
            <option value="delete">Delete</option>
            </select> 
            </form>

            <?php
        }
        else if(isset($_POST['commands']))
        {
            if($_POST['commands]'] != '')
            {
                $command = $_POST['commands'];
            }
            
            echo "User chose: $command <br>";

        }
        else 
        {
            echo "Make a command selection to make changes to this table.";
        }
            ?>
    
    </body>
</html>