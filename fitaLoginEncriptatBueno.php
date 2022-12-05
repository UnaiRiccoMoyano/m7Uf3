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
            $dbname = "login";
            $username = "root";
            $pw = "admin2020";
            $pdo = new PDO ("mysql:host=$hostname;dbname=$dbname","$username","$pw");
          } catch (PDOException $e) {
            echo "Failed to get DB handle: " . $e->getMessage() . "\n";
            exit;
          }

          if(isset($_POST['username']) && isset($_POST['password'])){
            ///$query = $pdo->prepare('INSERT INTO users (nom,password) values ("admin123", "'.sha1("Admin2020").'");');
            $query = $pdo->prepare('SELECT count("nom") as cantidad from users where (nom = ? && password = ? );');
            $username = $_POST['username'];
            $password = sha1($_POST['password']);
            $query->bindParam(1,$username);
            $query->bindParam(2,$password);
            $query->execute();
          }   
        ?>

        <form action="fitaLoginEncriptatBueno.php" method="post">
            <input type="text" name="username" placeholder="username">
            <input type="text" name="password" placeholder="password">
            <input type="submit">
        </form>
<?php
        if($_POST['username'] && $_POST['password']){
            $row = $query->fetch();
            if($row['cantidad'] == 1){
                echo "Te has logeado correctamente!";
            }else{
                echo $row['cantidad']." Algo ha salido mal :c";
            }
        }
        ?>
</table>
</body>
</html>