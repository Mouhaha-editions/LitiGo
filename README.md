Pour qui ?
=========
Ce projet est principalement déstiné à tous ceux qui utilisent des fichiers Excel pour communiquer avec leurs clients et faire le suivi des projets.

Comment ca marche ? 
=========
Vous : 
* vous inscrivez. 
* créez un ou plusieurs "clients".
* créez un projet.
* associez un ou plusieurs clients à un projet
* ajoutez les differents points à suivre, et definissez les type de point (bug, amelioration, ... créez les votres)
* envoyez le lien de connexion au projet à votre client

et c'est parti ! 

On vous a vendu le produit ? 
==========
Plusieurs solutions : 
* On vous l'installe sur une machine que vous possedez. (coût moyen)
* Vous vous l'installez sur votre machine. (gratuit, mais aucun SAV)
* Vous utilisez l'application en mutualisé. (coût faible)


Comment je l'installe ? 
==========
Il vous faut une machine avec PHP 7.2 minimum et un mysql.
Vous téléchargez avec le bouton en haut à droite du GitHub, ou clonez le dépot.
(je pars du principe que vous savez configurer apache ou nginx)
et apres ca se passe en ligne de commande dans le dossier racine (là ou se trouve /web et ce maginfique README) :

``composer install `` (installation des librairies et parametrage des infos de base .. (identifiant mdp de bdd, serveur, emails))

``bower install`` (installation des librairies javascript et css)

``php bin/console d:s:u --force`` (génération de la base de données)

``php bin/console fos:user:create [admin_username] [admin_password] --super-admin`` (création de l'utilisateur super administrateur (vous), ne soyez pas bête remplacez les parties entre [ ] )

Après cela ca devrait etre bon ...