pipeline {
    agent any
    
    stages {
        stage('Build') {
            steps {
                sh 'cp sample.env .env'
                
                // Aquí colocarías los comandos necesarios para construir tu proyecto PHP
                //  sh '/usr/bin/docker-compose up -d --build'
                sh '''
                    export PATH=$PATH:/opt/homebrew/bin
                    /opt/homebrew/bin/composer require --dev phpunit/phpunit
                    /usr/local/bin/docker-compose up -d --build
                    '''
            }
        }
        stage('Test') {
           steps {
                // Add PHP path to the PATH environment variable
                withEnv(['PATH+PHP=/opt/homebrew/bin']) {
                    sh './vendor/bin/phpunit tests/'
                }
            }
        }
        stage('Deploy') {
            steps {
                // Aquí colocarías los comandos necesarios para desplegar tu aplicación
                // Por ejemplo, si estás usando Docker, podrías construir y desplegar contenedores
                  sh '''
                    export PATH=$PATH:/opt/homebrew/bin
                    /usr/local/bin/docker-compose up -d
                    '''

                sh '/opt/homebrew/bin/docker tag todo_cicd-webserver carlosveryan/todo_cicd-webserver:latest'
                sh '/opt/homebrew/bin/docker tag todo_cicd-phpmyadmin carlosveryan/todo_cicd-phpmyadmin:latest'
                sh '/opt/homebrew/bin/docker tag redis carlosveryan/redis:latest'
                sh '/opt/homebrew/bin/docker tag todo_cicd-database carlosveryan/todo_cicd-database:latest'

                sh '/opt/homebrew/bin/docker push carlosveryan/todo_cicd-webserver:latest'
                sh '/opt/homebrew/bin/docker push carlosveryan/todo_cicd-phpmyadmin:latest'
                sh '/opt/homebrew/bin/docker push carlosveryan/redis:latest'
                sh '/opt/homebrew/bin/docker push carlosveryan/todo_cicd-database:latest'
            }
        }
    }
}
