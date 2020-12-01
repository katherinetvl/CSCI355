<?php 
    require_once('config.php');
?>

<!DOCTYPE html> 
<html>
<head>
    <title> Katherine Le CRUD via PHP </title>
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

        $host = 'localhost:3308';
        $user = 'root';
        $pw = '';
        $database = 'forphpconnect';
        $mysqli = new mysqli($host, $user, $pw, $database);
        $result = $mysqli->query("SELECT * FROM user") or die($mysqli->error);
    ?>
        <table>
            <thead>
            <th> id </th>
            <th> fname </th>
            <th> age </th>
            </thead>

        <?php
            while($row = $result->fetch_assoc()): ?>
            <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['fname']; ?></td>
            <td><?php echo $row['age']; ?></td>
            </tr>
        <?php endwhile; ?>
        </table>

    <?php
       if($_SERVER['REQUEST_METHOD'] == 'GET')
       {
        ?>
        <p> Enter data below as well as choose command.</p>
        <form method = "POST" action = "index.php">
            <label> id: <input type = "text" name = "inputName"> </input></label><br>
            <label> fname: <input type = "text" name = "fname"> </input></label></br>
            <label> age: <input type = "number" name = "age" min = "0" max = "110"> </input></label></br>
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
            echo "$theCommand <br>";
            if($theCommand == "insert")
            {
                if(isset($_POST['fname']) && isset($_POST['age']))
                {
                    $fname = $_POST['fname'];
                    $age = $_POST['age'];
                    $sql = "INSERT INTO user (fname, age) VALUES ('$fname', '$age')"; 
                    if (mysqli_query($mysqli, $sql)) 
                    {
                        $message = "$theCommand was executed. <br>";
                        echo $message . "<br>";
                    } 
                    else 
                    {
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }
                }
            }
            if($theCommand == "select")
            {
                if(isset($_POST['fname']) && isset($_POST['age']))
                {
                    $fname = $_POST['fname'];
                    $age = $_POST['age'];
                    $sql = "SELECT * FROM user WHERE fname = '$fname' AND age = '$age'";
                    if (mysqli_query($mysqli, $sql)) 
                    {
                        $message = "$theCommand was executed. <br>";
                        echo $message . "<br>";
                    } 
                    else 
                    {
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }
                }
                else if(isset($_POST['fname']))
                {
                    $fname = $_POST['fname'];
                    $sql = "SELECT * FROM user WHERE fname = '$fname'";
                    if (mysqli_query($mysqli, $sql)) 
                    {
                        $message = "$theCommand was executed. <br>";
                        echo $message . "<br>";
                    } 
                    else 
                    {
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }
                }
                else
                {
                    if(isset($_POST['age']))
                    {
                        $fname = $_POST['age'];
                        $sql = "SELECT * FROM user WHERE age = '$age'";
                        if (mysqli_query($mysqli, $sql)) 
                        {
                            $message = "$theCommand was executed. <br>";
                            echo $message . "<br>";
                        } 
                        else 
                        {
                            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                        }
                    }
                }
            }
        }

        // Let user perform another action
        echo "<br>";
        echo "<a href='index.php'>" . "Return to Index" . "</a>";
    }
    else
    {
        echo "Please fill out form to continue.";
    }
    ?>
</body>
</html>