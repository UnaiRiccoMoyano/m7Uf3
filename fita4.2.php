<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=ç, initial-scale=1.0">
    <title>Buscar continentes</title>
</head>
<body>
<?php
    try {
        $hostname = "127.0.0.1";
        $dbname = "world";
        $username = "admin";
        $pw = "admin123";
        $pdo = new PDO ("mysql:host=$hostname;dbname=$dbname","$username","$pw");
    } catch (PDOException $e) {
        echo "Failed to get DB handle: " . $e->getMessage() . "\n";
        exit;
    }
      
    //preparem i executem la consulta
    if(isset($_GET['continente'])){
        $code = $_GET['continente'];
        # (2.1) creem el string de la consulta (query)
        $query2 = $pdo->prepare("SELECT Name FROM country where Continent = '$code';");
        $query2->execute(); 
    }
    $query = $pdo->prepare("SELECT distinct Continent FROM country;");
    $query->execute();
    //eliminem els objectes per alliberar memòria 

     ?>
    <form action="./fita4.2.php" method="GET">
        
        <?php
        //anem agafant les fileres d'amb una amb una
            $row = $query->fetch();
            while ($row) {
                echo "<label><input type='checkbox' value='".$row['Continent']."' name='continentes[]'>".$row['Continent'];
                echo "</label><br>\n";
                $row = $query->fetch();
            }
        ?>
    <input type="submit">
    </form>
    <ul>
        <?php
        if(isset($_GET['continentes'])){
            $txtContinent = implode(', ' ,$_GET['continentes']);
            $queryCountr = $pdo->prepare('SELECT Name as nombre from country where in ('.$txtContinent.');');
            $queryCountry -> execute();
            $row = $queryCountry -> fetch();
            echo "<ul>";
            while($row){
                echo "<li>".$row['nombre']."</li>";
                $row = $queryCountry -> fetch();
            }
        }
    unset($pdo); 
    unset($query);
        ?>
    </ul>
</body>
</html>