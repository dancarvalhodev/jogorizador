pipeline {
    agent any
    stages {
        stage('Checkout') {
            steps {
                cleanWs()
                checkout([$class: 'GitSCM', branches: [[name: '*/master']], extensions: [], userRemoteConfigs: [[url: 'https://github.com/dancarvalhodev/Jogorizador']]])
            }
        }
        stage('Permissions') {
            steps {
                sh './permissions.sh'
            }
        }
        stage('Docker') {
            agent { docker { image 'dancarvalhodev/php:8.0' } }
            steps {
                sh 'composer install'
                sh 'openssl genrsa -out private.key 2048'
                sh 'openssl rsa -in private.key -pubout -out public.key'
                sh 'cp public.key data/keys/oauth'
                sh 'cp private.key data/keys/oauth'
                sh 'chmod 777 data/keys/oauth/*'
            }
        }
    }
}
