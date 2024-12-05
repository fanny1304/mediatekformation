# Mediatekformation
## Présentation
Ce site, développé avec Symfony, permet d'accéder aux vidéos d'auto-formation proposées par une chaîne de médiathèques, et permet également après authentification sur le serveur d'assurer la gestion des données enregistrées. L'application d'origine ne comportait que la partie <u>front-office</u>, c'est à dire la consultation des formations et des playlists répertoriées par la médiathèque. Le code de l'application de base est disponible dans le dépôt suivant : https://github.com/CNED-SLAM/mediatekformation. <br>

Le but de cet atelier de professionnalisation était donc de créer de toute pièce la partie <u>back-office</u> associée au site. Elle contient les fonctionnalités globales suivantes après authentification :<br>
•	Gérer les formations : ajouter, modifier ou supprimer une formation <br>
•	Gérer les playlists : ajouter, modifier ou supprimer une playlist <br>
•	Gérer les catégories : ajouter ou supprimer une catégorie <br>
•	Se déconnecter<br>

## Les différentes pages
Voici les différentes pages de la partie "back-office" de l'application :
### Page 1 : Page de connexion
Depuis la partie "front-office", on peut accéder à la page d'aministration, accessible en ajoutant "/admin" à l'URL du site. Cette page passe par l'intermédiaire Keycloak et permet de se connecter à la partie d'administration du site à l'aide d'identifiants de connexion (nom d'utilisateur + mot de passe) associés au role "administrateur". <br>

![img1](https://github.com/user-attachments/assets/14427370-6915-4fef-b024-342aea5098d9)

### Page 2 : page de gestion des formations
Cette page présente les formations proposées en ligne et accessibles sur YouTube. La partie haute est identique à chaque page du back-office. <br>
La partie centrale contient un tableau composé de 6 colonnes : <br>
•	La 1ère colonne ("Formation") contient le titre de chaque formation.  <br>
•	La 2ème colonne ("Playlist") contient le nom de la playlist dans laquelle chaque formation se trouve. <br>
•	La 3ème colonne ("Catégorie") contient la ou les catégories concernées par chaque formation. <br>
•	La 4ème colonne ("Date de publication") contient la date de publication de chaque formation. <br>
•	La 5ème colonne contient la capture visible sur Youtube pour chaque formation. <br>
•	La 6ème colonne ("Actions") contient 2 boutons permettant soit d'éditer la formation, soit de la supprimer. Au clic du bouton "supprimer", un pop-up s'affiche demandant confirmation de la suppression. <br>
Au niveau de l'en-tête du tableau, les colonnes "Formation", "Playlist" et "Date de publication" contiennent 2 boutons ("<" et ">") permettant de trier les lignes dans l'ordre corissant ou décroissant. <br>
Toujours dans l'en-tête, au niveau des colonnes "Formation" et "Playlist", il est possible de filtrer les lignes grâce à un champ de recherche. <br>
Concernant la colonne "Catégorie", le filtre s'effectue grâce à un menu déroulant. <br>
Par défaut, la liste est triée sur la date par ordre décroissant. <br>

![img2](https://github.com/user-attachments/assets/7932b409-61a9-4f84-9a1a-a288f8c80a35)

### Page 3 : ajouter une formation
Depuis la page de gestion des formations, il est possible d'accéder à la page d'ajout d'une formation en cliquant sur le bouton "Ajouter une formation". <br>
Cette page contient un titre au-dessus d'un formulaire vide contenant les champs suivants : <br>
•	"Titre de la formation" : permet de renseigner le titre de la formation. <br>
• "Description" : permet d'ajouter une description facultative pour cette formation. <br>
• "Playlist" : permet de choisir parmi une liste, le nom de la playlist dans laquelle la formation va se trouver. <br>
• "Catégorie" : permet de choisir parmi une liste, le nom de la ou les catégorie(s) associées à la formation. <br>
• "Date de publication" : permet de sélectionner la date de publication de la formation (qui ne peut pas être postérieure à la date du jour). <br>

![img3](https://github.com/user-attachments/assets/0d61c248-6b2c-4003-87c2-ebae400bf288)

### Page 4 : éditer une formation
Depuis la page de gestion des formations, il est possible pour chaque formation, d'accéder à la page d'édition de cette formation. On y accède en cliquant sur le bouton "Editer" dans la dernière colonne de la ligne de la formation concernée. <br>
Cette page contient un titre, avec un formulaire prérempli des informations existantes sur la formation concernée. <br>
La structure du formulaire est identique à celle du formulaire d'ajout d'une formation présenté plus haut. <br>

![img4](https://github.com/user-attachments/assets/ad5ae9bd-36d8-478a-afdc-32230fce5c01)

### Page 5 : gestion des playlists
Grâce au menu présent dans la partie haute de chaque page, il est possible en cliquant sur le lien correspondant, d'accéder à la partie de gestion des playlists. <br>
Cette page présente les playlists disponibles. <br>
La partie centrale de la page contient un tableau composé de 4 colonnes : <br>
• La 1ère colonne ("Nom de la playlist") contient le nom de chaque playlist. <br>
• La 2ème colonne ("Catégories associées") contient la ou les catégories concernées par chaque playlist. <br>
• La 3ème colonne ("Nombre de formations") contient le nombre de formations contenues dans chaque playlist. <br>
• La 4ème colonne ("Actions") contient 2 boutons permettant soit d'éditer une playlist, soit de la supprimer. Au clic du bouton "supprimer", un pop-up s'affiche demandant confirmation de la suppression. Il est possible de supprimer une playlist que si elle n'est rattachée à aucune formation. <br>
Au niveau de l'en-tête du tableau, les colonnes "Nom de la playlist" et "Nombre de formations" contiennent 2 boutons ("<" et ">") permettant de trier les lignes dans l'ordre croissant ou décroissant. <br> 
Toujours dans l'en-tête, au niveau de la colonne "Nom de la playlist", il est possible de filtrer les lignes grâce à un champ de recherche. <br>
Concernant la colonne "Catégories associées", le filtre s'effectue grâce à un menu déroulant. <br>

![img5](https://github.com/user-attachments/assets/ece74285-dcd5-4874-ad28-3ffa40ff43bd)

### Page 6 : ajouter une playlist 
Depuis la page de gestion des playlists, il est possible d'accéder à la page d'ajout d'une playlist en cliquant sur le bouton "Ajouter une playlist". <br>
Cette page contient un titre avec au-dessous un formulaire vide contenant les champs suivants : <br> 
•	"Nom de la playlist" : permet de renseigner le nom de la playlist. <br> 
•	"Description" : permet d'ajouter une description facultative pour cette playlist. <br> 

![image](https://github.com/user-attachments/assets/e6414fdb-2bb1-439f-a8aa-09a47f9e249a)

### Page 7 : editer une playlist
Depuis la page de gestion de playlists, il est possible pour chaque playlist, d'accéder à la page d'édition de cette playlist. On y accède en cliquant sur le bouton "Editer" dans la dernière colonne de la ligne de la playlist concernée. <br> 
Cette page contient un titre, avec un formulaire prérempli des informations existantes sur la playlist concernée. <br> 
La structure du formulaire est identique à celui d'ajout d'une playlist présenté plus haut. Seul un champ est ajouté permettant de consulter les formations associée à la playlist (champ non modifiable). <br>

![image](https://github.com/user-attachments/assets/71042e52-2230-47b5-9e02-89166bd715b3)

### Page 8 : gestion des catégories
Grâce au menu présent dans la partie haute de chaque page, il est possible en cliquant sur le lien correspondant, d'accéder à la partie de gestion des catégories. <br>
Cette page présente les catégories enregistrées. <br>
La partie centrale de la page contient un tableau composé de 3 colonnes : <br>
• La 1ère colonne ("Nom de la catégorie") contient le nom de chaque catégorie. <br>
• La 2ème colonne ("Nombre de formations associées") contient le nombre de formations auxquelles est associée la catégorie. <br>
• La 3ème colonne ("Actions") contient un bouton permettant de supprimer chaque catégorie. Au clic du bouton "supprimer", un pop-up s'affiche demandant confirmation de la suppression. <br> 

![image](https://github.com/user-attachments/assets/2ac356a5-d6a6-4b39-aaba-be75ba0c6efe)

### Page 9 : ajouter une catégorie 
Depuis la page de gestion des catégories, il est possible d'accéder à la page d'ajout d'une catégorie en cliquant sur le bouton "Ajouter une catégorie". <br>
Cette page contient un titre avec un formulaire vide contenant l'unique champ suivant : 
•	"Nom de la catégorie" : permet de renseigner le nom de la catégorie qui doit être unique dans la base de données. 

![image](https://github.com/user-attachments/assets/539d7255-10a9-4177-96c8-4498d36a062f)

## Test de l'application en local
Voici ci-dessous le mode opératoire à suivre pour installer et utiliser l'application en local. 
- Vérifier que Composer, Git et Wamserver (ou équivalent) sont installés sur l'ordinateur. <br>
- Télécharger le code et le dézipper dans www de Wampserver (ou dossier équivalent) puis renommer le dossier en "mediatekformation".<br>
- Ouvrir une fenêtre de commandes en mode admin, se positionner dans le dossier du projet et taper "composer install" pour reconstituer le dossier vendor.<br>
- Dans phpMyAdmin, se connecter à MySQL en root sans mot de passe et créer la BDD 'mediatekformation'.<br>
- Récupérer le fichier mediatekformation.sql en racine du projet et l'utiliser pour remplir la BDD (si vous voulez mettre un login/pwd d'accès, il faut créer un utilisateur, lui donner les droits sur la BDD et il faut le préciser dans le fichier ".env" en racine du projet).<br>
- Installer l'utilitaire Keycloak en local et le configurer pour pouvoir gérer l'authentification à la partie administrateur de l'application (modifier les informations correspondantes dans le fichier ".env" en racine du projet).
- De préférence, ouvrir l'application dans un IDE professionnel. L'adresse pour la lancer est : http://localhost/mediatekformation/public/index.php<br>

## Test de l'application en ligne 
Pour accéder à l'application en ligne, il faut se rendre à l'URL suivant : "https://white-scorpion-113733.hostingersite.com/mediatekformation/public/" <br>
Pour accéder à la partie administrateur, il faut ajouter "/admin" à la fin de l'URL : "https://white-scorpion-113733.hostingersite.com/mediatekformation/public/admin" <br>
(Me contacter pour obtenir les identifiants de connexion) <br>
