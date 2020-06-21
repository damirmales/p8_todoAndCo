# DOCUMENTATION DE CONTRIBUTION
## INTRODUCTION
Il est possible de contribuer à l’évolution du projet ToDoAndCo
en proposant des améliorations sur du code existant et/ou en soumettant des fonctionnalités nouvelles.
Pour ce faire il y a un certain nombre de point à respecter et des outils à utiliser que nous allons voir dans la suite de ce document.
## Utilisation de Git et Github
Git est logiciel doit être installé pour gérer les modifications faites sur les fichiers d’un projet.
GitHub est un dépôt distant qui héberge les fichiers utilisés dans le développement  d’un projet géré par Git.
## Mode opératoire pour une contribution
### Créer une copie du projet
Allez sur le github du projet et clonez le
### Créez un dossier sur votre poste de travail
Placez y le clone du projet
Ouvrez un terminal de commande 
Allez à l’endroit où se trouve le projet
Faites un git init
Faites un composer install pour mettre en place les différentes dépendances utiles au projet
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
### Suite à la validation appliquez (merge) la pull request sur la branche master
## Gardons les bonnes pratiques 
### PSR (PHP Standards Recommendation)
Au minimum le code généré devra suivre les recommandations de la PSR-1
<https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md>
Au PSR-1 on ajoutera le PSR-12 qui vient le compléter suite aux évolutions du langage PHP ces dernières années.
<https://www.php-fig.org/psr/psr-12/>
### Symfony Best Practices
On veillera enfin à appliquer les recommandations de la version Symfony dans laquelle le projet a été mis à jour soit la 4.4
<https://symfony.com/doc/4.4/best_practices.html>
