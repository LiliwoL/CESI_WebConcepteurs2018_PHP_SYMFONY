# CESI Nantes

## Web Concepteurs 2018

### Symfony - Janvier 2020


Ce projet retrace l'introduction au framework Symfony.

Au menu:
* Controllers
* Moteur de vue TWIG

#### Pour cloner ce projet

```bash
git clone https://github.com/LiliwoL/CESI_WebConcepteurs2018_PHP_SYMFONY.git
```

Pensez ensuite à faire un **composer install** pour télécharger toutes les dépendances!
```bash
cd CESI_WebConcepteurs2018_PHP_SYMFONY
composer install
```


#### Rappels sur quelques commandes de la console Symfony

**Vous devez être à la racine de votre projet!**

Vidage du cache
```bash
php bin/console cache:clear
```

Vérification de la table de routage
```bash
php bin/console debug:router
```

Création d'un controller
```bash
php bin/console make:controller
```

***

### Symfony - Février 2020


On poursuit la découverte du framework

Au menu:
* Formulaires
* SSH et travail à distance
    * Idéalement on monte le dossier avec **SSHFS**
* Gestion des formulaires
* Vue d'un email
    * Utilisation de **mailtrap.io**
    * Design des emails spécifiques
    * Présentation de 
        * https://caniuse.email/
        * https://mjml.io/
* Présentation de Doctrine


### Connexion SSH

On se connecte via
```bash
ssh user@host
```

### Mise à jour du projet avec GIT

```bash
git pull
```

Attention à bien mettre à jour les dépendances!

```bash
composer install
```

### Doctrine

Doctrine est une couche d'abstraction de la base de données
https://symfony.com/doc/current/doctrine.html

Configurer l'accès à la base vie la fichier **.env**

ATTENTION! La base de données **formation_symfony** doit exister avant!

```
DATABASE_URL=mysql://root:root@127.0.0.1:3306/formation_symfony
```

Vérifier que la connexion fonctionne en créant la base

```bash
php bin/console doctrine:database:create
```





