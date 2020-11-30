<?php 
require_once('usemysqli.php');
?>

<!DOCTYPE html> 
<html>
<head>
    <title> Katherine's forphpconnect </title>
</head> 
<body>
<h2> Current Database is: Netflix </h2>
    <?php 
        if($mysqli)
        {
            echo "<b> Current Table: </b><br>";
            echo "<pre>     PAYMENT_METHOD</pre><br>";
            echo "<b> Columns: </b><br>";
            echo "<pre>     id | CreditCardNumber(NN) | CVV | ExpirationDate | AcctID (NN) </pre><br>";
            echo "----------------------------------------------------------------------------------- <br>";
        }
    ?>
    <?php 
       if($_SERVER['REQUEST_METHOD'] == 'GET')
       {
        ?>
        <p> Please choose an option to below to interact with the database.</p>
        <form method = "POST" action = "homepage.php">
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

        echo "These are your chosen command(s) <br>";
        print_r($commandArr);


        // Let user perform another action
        echo "<br>";
        echo "Would you like to perform another command? <br>";
        echo "<a href='homepage.php'>" . "Home" . "</a>";
    }
    else
    {
        echo "Please fill out form to continue.";
    }
    ?>
</body>
</html>