<?php
/* Variables */

$jeu = true; // Booléen permettant de faire tourner le jeu dans la boucle while principale
$gagner = false; // Booléen permettant de savoir si le joueur a gagner
$choix = 0; // Int permettant de savoir ce que le joueur fera comme choix (entre 1 et 5)
$today = date("d/m/Y H:i:s"); // Reprise de la date du jour
$filename = "resultats.txt";
$message = "";

/* Programme */

while($jeu == true){
    echo"Bienvenue dans le jeu de devinette!\n";
    echo"Le but du jeu est de deviner un nombre entre 1 et 100.\n";
    echo"Vous avez 10 à 15 essais pour trouver le nombre.\n";
    echo"Bonne chance!\n";
    echo "\n";
    echo"1. Jouer\n";
    echo"2. Voir les résulats\n";
    echo"3. Voir les résulats d'une date\n";
    echo"4. Voir les résulats d'un joueur\n";
    echo"5. Quitter\n";
    $choix = readline("Votre choix (1,2,3,4 ou 5) : ");


    /* Condition si l'utilisateur choisi de jouer */

    if($choix==1){
        $nombreOrd = random_int(1,100);
        $nombreEssais = 0;
        $nombreEssaisMax = random_int(10,15);
        $pseudo = readline("Saisir votre pseudo : ");
        echo "Commençons à jouer ! \n";
        while($nombreEssaisMax!=0){
            $essais = (int)readline("Devinez le nombre : ");
            while($essais<1 || $essais>100){
                echo"Saisie incorrecte\n";
                $essais = (int)readline("Devinez le nombre : ");
            }
            $nombreEssaisMax-=1;
            $nombreEssais++;
            if($essais==$nombreOrd){
                echo "Vous avez gagner\n";
                $choix=0;
                break;
            }elseif($essais>$nombreOrd){
                echo "Le nombre est plus petit.\n";
            }else{
                echo "Le nombre est plus grand.\n";
            }
        }
        if($nombreEssaisMax==0){
            $message = "Désolé ".$pseudo." : vous avez atteint le nombre maximum de tentatives ! Le nombre était ".$nombreOrd;
            $message2 = "Perdu. Le nombre à deviné était ".$nombreOrd."\n";
        }elseif($nombreEssaisMax>10){
            $message = "Excellent ".$pseudo." : vous avez trouvé le nombre ".$nombreOrd." en ". $nombreEssais." tentatives !\n";
            $message2 = "Excellent! Vous avez trouvé le nombre en ".$nombreEssais." essais.";
        }else{
            $message = "Bien joué ".$pseudo." : vous avez trouvé le nombre ".$nombreOrd." en ". $nombreEssais." tentatives !\n";
            $message2 = "Bien joué ! Vous avez trouvé le nombre en ".$nombreEssais." essais.";
        }
        echo $message;
        $fichier = fopen($filename,"a+");
        fwrite($fichier,$today." - Pseudo : ".$pseudo." - Résultat: ".$message2."\n");
        fclose($fichier);


    /* Condition si l'utilisateur choisi d'afficher tous les résultats enregistrés */

    }elseif($choix==2){
        $fichier = fopen($filename,"r");
        while (!feof($fichier)){
            echo fgets($fichier)."\n";
        }
        fclose($fichier);


    /* Condition si l'utilisateur choisi d'afficher tous les résultats enregistrés en fonction de la date */

    }elseif($choix==3){
        $date = (string) readline("Saisir la date sous le format jj/mm/aaaa : ");
        $fichier = fopen($filename,"r");
        while(!feof($fichier)){
            $ligne = fgets($fichier);
            if(str_contains($ligne,$date)){
                echo $ligne."\n";
            }
        }
        fclose($fichier);


    /* Condition si l'utilisateur choisi d'afficher tous les résultats enregistrés en fonction du pseudo */

    }elseif($choix==4){
        $pseudoDemande = readline("Saisir le pseudo : ");
        $fichier = fopen($filename,"r");
        while(!feof($fichier)) {
            $ligne = fgets($fichier);
            if (str_contains($ligne, $pseudoDemande)) {
                echo $ligne."\n";
            }
        }
        fclose($fichier);


    /* Condition si l'utilisateur choisi de quitter le jeu */

    }elseif($choix==5){
        echo "See you next time"."\n";
        $jeu = false;
    }
}
