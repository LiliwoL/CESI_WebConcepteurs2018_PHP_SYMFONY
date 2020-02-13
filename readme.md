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


### Connexion SSH

On se connecte via
```bash
ssh user@host
```

### Mise à jour du projet avec GIT

```bash
git pull
```





