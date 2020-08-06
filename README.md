# Survey the users



## Rappel de l'objectif 

Développer une application  web permettant à un utlisateur de répondre à un questionnaire comprenant deux types de questions:

- Texte libre
- Echelle de satisfaction (type échelle de Likert)

Une interface d'administration permet d'ajouter ou de supprimer des questions. Il est également possible d'exporter les réponses au format .CSV.



J'ai développé une application très simple en HTML/CSS et PHP7.4.2. J'ai choisi d'utiliser une architecture MVC que j'ai développé moi même il y'a quelques années et qui utilise quelques éléments de Symfony.

J'utilise dans ce projet le système de gestion de base de données MySql. Le fichier `database.sql` permet de créer la base de données, les tables et l'utilisateur utilisés. Si vous souhaitez modifier le nom de la base de données, le nom de l'utilisateur ou le mot de passe utilisés par le projet, rendez-vous dans le fichier `config.ini`.

Pour la tester facilement j'ai mis en ligne l'application, vous pouvez suivre [ce lien](http://survey.newexplorers.fr/).

L'interface administrateur se trouve [ici](survey.newexplorers.fr/admin)



## Découpage du temps

J'ai réalisé ce projet dans le laps de temps des 4 heures demandé. Voici une description détaillée du découpage de mon travail:

| Temps passé sur la tâche | Nom/description de la tâche                                  |
| :----------------------: | :----------------------------------------------------------- |
|          20 min          | Conception architecture, base de données, maquettes (papier) |
|          15 min          | Développement de la structure HTML                           |
|          20 min          | Création de la base de données                               |
|          25 min          | Développement du modele de données (en PHP)                  |
|          20 min          | Développement de la page d'accueil<br />l'utilisateur à accès aux question de la base de donnée et peut répondre au questionnaire |
|          30 min          | Développement de l'accueil administrateur<br />L'administrateur peut voir toutes les questions et récupérer les réponses au format CSV<br />Il peut également supprimer des questions |
|          20 min          | Développement de l'interface d'ajout de questions<br />L'administrateur peut ajouter un des deux types de question au choix |
|          50 min          | Design des différentes pages                                 |
|          40 min          | Tests et ajustements                                         |
|                          |                                                              |
|     **Temps Total**      | *3 heures et 50 minutes*                                     |



## Auto-évaluation

L'application développée remplit tous les critères fonctionnels demandés.

J'ai du effectuer certain choix au cours de la réalisation du projet:

- L'utilisateur doit "s'identifier" à l'aide d'un mail et d'un nom à la fin du questionnaire (cela permet notemment d'empêcher qu'un questionnaire soit rempli plusieurs fois par une même personne)
- Lorsque l'administrateur ajoute ou supprime une question, le questionnaire est remis à 0 (toutes les réponses précédentes sont supprimés). J'ai fais ce choix car il me paraissait incohérent de comparer les résultats de questionnaires présentants des questions différentes.

On pourrait ajouter beaucoup d'éléments à une telle application:

- Vérification en direct du remplissage des champs (en javascript)
- Les éléments de base de sécurité (contre les injections SQL notamment sont vérifiés), mais on pourrait effectuer plus de vérifications sur la saisie et l'identité des utilisateurs
- La possibilité de gérer plusieurs questionnaires : cela demanderait quelques petites modifications de la base de données, mais la base pour un questionnaire est là.
- Le backend de l'application est en PHP, la structuer actuellement utilisée se rapproche assez bien de la structure d'une API. En effectuant quelques modifications sur le frontend (faire passer tous les appels backend via des requêtes `fetch` en javascript) et à l'aide du framework Electron par exemple, on pourrait facilement la déployer en tant que web application de bureau utilisable sur toutes les plateformes.
- ...

