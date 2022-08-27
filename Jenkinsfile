pipeline {
    agent any
    stages {
        stage('Checkout') {
            steps {
                checkout([$class: 'GitSCM', branches: [[name: '*/master']], extensions: [], userRemoteConfigs: [[url: 'https://github.com/dancarvalhodev/Jogorizador']]])
            }
        }
        stage('Permissions') {
            steps {
                sh 'chown -R $USER:www-data storage/'
                sh 'chmod -R ug+w storage/'
            }
        }
        stage('Docker') {
            agent { docker { image 'dancarvalhodev/php:8.0' } }
            steps {
                sh 'composer install'
                sh 'php -v'
                sh 'cd data/keys/oauth'
                sh 'openssl genrsa -out private.key 2048'
                sh 'openssl rsa -in private.key -pubout -out public.key'
                sh 'cd ..'
                sh 'chmod -R 777 oauth/'
            }
        }
    }
}
