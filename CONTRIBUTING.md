# DOCUMENTATION DE CONTRIBUTION
## INTRODUCTION
### Les différents environnements d'un projet  
#### L’environnement de dev 
C’est celui qui va permettre de coder l’application avec des outils spécifiques tels que les fixtures, le profiler pour le débogage etc…
La configuration ce fera dans le fichier app/config/config_dev.yml

#### L’environnement de test
Sert pour la rédaction des tests unitaires et fonctionnels
on trouve sa configuration dans  
_app/config/config_test.yml_
Les fichiers sont insérés dans le dossier  
_tests/AppBundle/_
en reprenant la structure des éléments du dossier _src/AppBundle/_

#### L’environnement de production
En production on va rechercher à optimiser la vitesse d’exécution sans utiliser par exemple le profiler et les librairies propres au développement..
On trouvera la configuration dans _app/config/config_prod.yml_

Pour exécuter l’application en fonction de l’environnement souhaité on utilisera les urls suivantes :  
http://localhost/app.php      -> *prod* environment  
http://localhost/app_dev.php  -> *dev* environment

Au sein des fichiers app.php et app_dev.php on trouvera le code suivant dans lequel en premier paramètre
de la classe Appkernel est mentionné l’environnement qui sera exécuté et en second l’activation ou non du mode debug (false,true).  
_$kernel = new AppKernel('prod', false);_  
_$kernel = new AppKernel(dev, true);_

On n’oubliera pas de vider le cache prod à chaque intervention dans le code
avant de rafraichir le navigateur pour mettre à jour les modifications.  
_php bin/console c:c --env=prod_

## Contribution au projet

Il est possible de contribuer à l’évolution du projet ToDoList
en proposant des améliorations sur le code existant et/ou en soumettant des fonctionnalités nouvelles.

Pour ce faire il y a un certain nombre de points à respecter et des outils à utiliser que nous allons voir dans la suite de ce document.
## Utilisation de Git et Github
Git est logiciel doit être installé pour gérer les modifications faites sur les fichiers d’un projet.
GitHub est un dépôt distant qui héberge les fichiers utilisés dans le développement  d’un projet géré par Git.

## Mode opératoire pour une contribution

### Créer une copie du projet
Allez sur le github du projet et clonez le
### Créez un dossier sur votre poste de travail
* Placez y le clone du projet
* Ouvrez un terminal de commande 
* Allez à l’endroit où se trouve le projet
* Faites un git init
* Faites un composer install pour mettre en place les différentes dépendances utiles au projet
### Créer une branche
git  checkout -b newBranche
### Faire un développement 
Si validation, merger la pull request sur la branche courante
### Ajouter les modifications au git
git  add --all
### Faire un commit en décrivant brièvement les modifications apportées
git commit -m “brève mention des modifications”
### Envoyer les modifications sur le dépôt Github
git  push origin NomDeLaBrancheCourante
### Créer la Pull Request
### Vérifier le code avec l'analyse fourni par Codacy  
https://app.codacy.com/manual/d.males/p8_todoAndCo/dashboard

### Suite à la validation, fusionner (merge) la pull request sur la branche master

## Audit de performance
Il est préconisé de faire un audit de performance avec l'outil [Blackfire](https://blackfire.io).

## Gardons les bonnes pratiques 

### PSR (PHP Standards Recommendation)
Au minimum le code généré devra suivre les recommandations de la PSR-1  
  <https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md>

Au PSR-1 on ajoutera le PSR-12 qui vient le compléter suite aux évolutions du langage PHP ces dernières années.  
  <https://www.php-fig.org/psr/psr-12/>
### Symfony Best Practices
On veillera enfin à appliquer les bonnes pratiques de la version Symfony dans laquelle le projet a été mis à jour, soit la 4.4
  <https://symfony.com/doc/4.4/best_practices.html>
