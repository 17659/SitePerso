<h1>Formulaire</h1>
<?php

if (isset($_POST['gollum'])) {
    $nom = isset($_POST['nom']) ? $_POST['nom'] : "";
    $prenom = isset($_POST['prenom']) ? $_POST['prenom'] : "";
    $mail = isset($_POST['mail']) ? $_POST['mail'] : "";
    $tel = isset($_POST['tel']) ? $_POST['tel'] : "";
    $message = isset($_POST['message']) ? $_POST['message'] : "";

    $erreurs = array();

    if (!(mb_strlen($nom) >= 2 && ctype_alpha($nom)))
        array_push($erreurs, "Veuillez saisir un nom correct.");

    if (!(mb_strlen($prenom) >= 2 && ctype_alpha($prenom)))
        array_push($erreurs, "Veuillez saisir un prénom correct.");

    if (!filter_var($mail, FILTER_VALIDATE_EMAIL))
        array_push($erreurs, "Veuillez saisir une adresse mail valide.");

    if (!(mb_strlen($tel) >= 2 && ctype_alpha($tel)))
        array_push($erreurs, "Veuillez saisir un téléphone correct.");


    if (count($erreurs) > 0) {
        $message = "<ul>";
        $i = 0;

        while ($i < count($erreurs)) {
            $message .= "<li>" . $erreurs[$i] . "</li>";
            $i++;
        }

        $message .= "</ul>";

        echo $message;

        include "index.html";
    } else {
        $sql = "SELECT COUNT(*) FROM t_users WHERE USEMAIL='". $mail . "'";
        $nombreOccurences = $pdo->query($sql)->fetchColumn();

        if ($nombreOccurences == 0) {
            $sql = "INSERT INTO T_USERS
                (USENOM, USEPRENOM, USEMAIL, USETEL, )
                VALUES ('" . $nom . "', '" . $prenom . "', '" . $mail . "', '" . $tel . "')";

            $query = $pdo->prepare($sql);
            $query->bindValue('USENOM', $nom, PDO::PARAM_STR);
            $query->bindValue('USEPRENOM', $prenom, PDO::PARAM_STR);
            $query->bindValue('USEMAIL', $mail, PDO::PARAM_STR);
            $query->bindValue('USETEL', $mdp, PDO::PARAM_STR);
            $query->execute();

            echo "Coucou c'est bien enregistré !";

        }

        else {
            echo "Vous êtes déjà dans la BDD";
        }

    }

} else {
    require_once "index.html";
}

