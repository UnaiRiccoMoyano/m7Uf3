<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EXERCICI 1</title>
</head>
<body>
    <?php
        //connexiÃ³ dins block try-catch:
        //  prova d'executar el contingut del try
        //  si falla executa el catch
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
        if(isset($_GET['palabraBusqueda'])){
            //preparem i executem la consulta
            $palabraBusqueda = $_GET['palabraBusqueda'];
            $query = $pdo->prepare('SELECT country.Name as Pais,country.Code, countrylanguage.Language as Idioma, countrylanguage.IsOfficial as Oficial, countrylanguage.Percentage as Porcentage from country inner join countrylanguage on country.Code = countrylanguage.CountryCode where Name like "%'.$palabraBusqueda.'%";');
            $query->execute();
        }
        ?>

        <form action="./">
            <input type="text" name="palabraBusqueda">
            <input type="submit" id="">
        </form>
        <table border="1px">
            <tr>
                <th>Pais</th>
                <th>Lenguatge</th>
                <th>Es oficial</th>
                <th>Percentatge</th>
            </tr>
<?php
        if(isset($_GET['palabraBusqueda'])){
            echo "<tr>";
            //anem agafant les fileres d'amb una amb una
            $row = $query->fetch();
            while ($row) {
                echo "<td>".$row['Pais']."</td>";
                echo "<td>".$row['Idioma']."</td>";
                echo "<td>".$row['Oficial']."</td>";
                echo "<td>".$row['Porcentage']."</td>";
                echo "</tr>";
                $row = $query->fetch();
            }
            
        }
        ?>
</table>
</body>
</html>