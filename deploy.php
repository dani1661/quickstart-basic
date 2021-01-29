<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'Proyecto');

// Project repository
set('repository', 'git@github.com:dani1661/quickstart-basic.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true); 

// Shared files/dirs between deploys 
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server 
add('writable_dirs', []);


// Hosts

host('192.168.1.136')
    ->user('prod-ud4-deployer')
    ->identityFile('~/.ssh/id_rsa.pub')
    ->set('deploy_path', '/var/www/prod-ud4-a4/html');    
    
// Tasks

task('build', function () {
    run('cd {{release_path}} && build');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'artisan:migrate');

// Podemos definir tareas adicionales que queremos que se ejecuten

//Declaración de la tarea
task('reload:php-fpm', function () {
run('sudo /etc/init.d/php7.4-fpm restart');
});

//inclusión en el ciclo de despliegue
after('deploy', 'reload:php-fpm');
