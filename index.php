<?php 
require_once('config.php');
?>

<!DOCTYPE html> 
<html>
<head>
    <title> Group 5 CRUD via PHP </title>
</head> 
<body>
<h2> Current Database is: forphpconnect </h2>
    <?php 
        if($mysqli)
        {
            echo "<b> Current Table: </b><br>";
            echo "<pre>     user</pre><br>";
            echo "<b> Columns: </b><br>";
            echo "<pre>     id | fname(NN) | age(NN)</pre><br>";
            echo "----------------------------------------------------------------------------------- <br>";
        }
    ?>
    <?php 
       if($_SERVER['REQUEST_METHOD'] == 'GET')
       {
        ?>
        <p> Please choose an option to below to interact with the database.</p>
        <form method = "POST" action = "index.php">
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
        echo "Click on the link to fill out form for each <br>";
        foreach($commandArr as $theCommand)
        {
            echo "$theCommand <br>";
            if($theCommand == "insert")
            {
                echo "<a href='insertcommand.php' target=_blank>" . "Insert Form" . "</a>";
            }
        }

        // Let user perform another action
        // echo "<br>";
        // echo "<a href='index.php'>" . "Return to Index" . "</a>";
    }
    else
    {
        echo "Please fill out form to continue.";
    }
    ?>
</body>
</html>