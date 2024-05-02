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
                    /usr/local/bin/docker-compose up -d --build
                    '''
            }
        }
        stage('Test') {
            steps {
                // Aquí colocarías los comandos necesarios para ejecutar tus pruebas
                sh 'vendor/bin/phpunit tests/'
            }
        }
        stage('Deploy') {
            steps {
                // Aquí colocarías los comandos necesarios para desplegar tu aplicación
                // Por ejemplo, si estás usando Docker, podrías construir y desplegar contenedores
                sh 'docker-compose up -d'
            }
        }
    }
}
