<?php

$server = "localhost";
$db = "crud";
$user = "root";
$psw = "";

try {
    $bdd = new PDO("mysql:host=$server;dbname=$db;charset=utf8", $user, $psw);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION).
    $bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    create("Coquelet", "Sam", 31, $bdd);
    create("Senju", "Tsunade", 51, $bdd);
    reade($bdd);
    update("Senju", "Mei", 32, 8, $bdd);
    delete(7, $bdd);



}
catch (PDOException $e) {
    echo $e->getMessage();
}


function create($nom, $prenom, $age, $bdd) {
    $sql = ("INSERT INTO eleve VALUES (null, '$nom', '$prenom', $age)");
    $bdd->exec($sql);
    echo 'eleve créer';
}


function reade($bdd) {
    $stmt = $bdd->prepare("SELECT * from eleve");

    $state = $stmt->execute();

    if ($state) {
        foreach ($stmt -> fetchAll() as $user) {
            echo "Eleve" . $user['id'] . ": " . $user['nom'] . " " . $user['prenom'] . ", " . $user['age'] . " ans. <br>";
        }
    }
}


function update($prenom, $nom, $age, $idEleve, $bdd) {
    $stm = $bdd->prepare("UPDATE eleve SET prenom = :prenom, nom = :nom, age = :age WHERE id = :id");

    $stm->bindParam(':prenom', $prenom);
    $stm->bindParam(':nom', $nom);
    $stm->bindParam(':age', $age);
    $stm->bindParam(':id', $idEleve);
    $stm->execute();

    echo 'update ok';
}


function delete($idEleve, $bdd) {
    $sql = "DELETE FROM eleve WHERE id = $idEleve";
    if ($bdd->exec($sql) !== false) {
        echo "L'élève ayant l'id " . $idEleve . " a bien été supprimé !";
    }
}

