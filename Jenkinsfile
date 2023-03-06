pipeline {
    agent any

    stages {
        stage('Build') {
            steps {
                git 'https://gitlab.com/imamsy/digipatrol-backend.git'
                sh 'composer install'
                sh 'cp .env.example .env'
                sh 'php artisan key:generate'
            }
        }
        stage('Test') {
            steps {
                sh './vendor/bin/phpunit'
            }
        }
    }
}