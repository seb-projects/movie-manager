# HDFID movie manager

### Consignes du test
Réaliser une application de visualisation de films se basant sur l’API de moviesdatabase 
https://rapidapi.com/SAdrian/api/moviesdatabase

L’idée étant de :

Démarrer une toute nouvelle appli
En utilisant l’API de moviesdatabase
En intégrant à minima un listener et un subscriber
Nous vérifierons surtout la qualité du code, sa maintenabilité, l’ergonomie des formulaires et l’aspect esthétique de l’appli en dernier lieu.


### Démarrage du projet :
``composer install``

Pour accéder à l'interface Movie Manager,
aller à http://localhost:8888/public/index.php/movies
(port à changer en fonction de la configuration)

Pour accéder au profiler Symfony,
aller à http://localhost:8888/public/index.php/_profiler/

### Exécution de tous les tests :
``bin/tests``

(vérifier les droits d'exécution en cas de problème)

### Exécution des tests séparément :
Tests fonctionnels Behat

``vendor/bin/behat features/``

Tests unitaires PhpUnit

``bin/phpunit tests/``

Tests PHP-CS-Fixer (PHP Standards Recommendations)

``vendor/friendsofphp/php-cs-fixer/php-cs-fixer fix src --dry-run --diff``

Tests de qualité de code PhpStan

``vendor/bin/phpstan``