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
                sh 'chown +x permissions.sh'
                sh './permissions.sh'
            }
        }
        stage('Docker') {
            agent { docker { image 'dancarvalhodev/php:8.0' } }
            steps {
                sh 'composer install'
                sh 'php -v'
                sh 'openssl genrsa -out private.key 2048'
                sh 'openssl rsa -in private.key -pubout -out public.key'
                sh 'mv private.key public.key data/keys/oauth'
                sh 'chmod -R 777 oauth/'
            }
        }
    }
}
