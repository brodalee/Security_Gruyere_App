# Security_Gruyere_App

Application gruyère d'entrainement à la sécurité applicative web.

Ce faux site de classement de sauces épicées contient 8 failles de sécurité différentes, aux utilisateurs de trouver comment les exploiter

# Installation avec Docker compose

En se mettant à la racine du projet, tapez les commandes suivantes :

```bash
$ docker-compose up -d --build

Vous aurez 3 containers :
  - phpmyadmin ( localhost:7000 )
  - db ( BDD maria localhost:3306 )
  - web ( localhost:5500 )
```

# Installation avec le script sh

Vous aurez besoin au préalable d'avoir déjà installé / lancer la base de données mysql / maria
et configurer dans Config/database_config.php les valeurs de connexion.

Vous devrez aussi avoir PHP d'installé et accessible en cmd.

En se mettant à la racine du projet, tapez les commandes suivantes :

````bash
$ sh ./launch.sh
````

Une fois le script bien executé ( sans erreur d'initialisation ), vous pourrez lancer l'application sur localhost:5500.

# Installation manuel

Vous aurez besoin au préalable d'avoir déjà installé / lancer la base de données mysql / maria
et configurer dans Config/database_config.php les valeurs de connexion.
Vous devrez aussi avoir PHP d'installé et accessible en cmd.

En se mettant à la racine du projet, tapez les commandes suivantes :

```bash
$ php ./src/scripts/install_composer.php
$ ./composer.phar dumpautoload -o
$ php ./src/scripts/script_init_db.php
$ php -S localhost:5500 index.php
```

Vous pouvez accèder à l'application sur localhost:5500 .