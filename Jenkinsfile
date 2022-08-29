pipeline {
    agent any
    stages {
        stage('Checkout') {
            steps {
                dir('/var/lib/jenkins/workspace/Jogo@2') {
                  sh 'sudo rm -rf storage'
                }
                checkout([$class: 'GitSCM', branches: [[name: '*/master']], extensions: [], userRemoteConfigs: [[url: 'https://github.com/dancarvalhodev/Jogorizador']]])
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
                sh 'php vendor/bin/codecept run acceptance '
            }
        }
        stage('Set Storage Permissions') {
            steps {
                dir('/var/lib/jenkins/workspace/Jogo@2') {
                  sh 'sudo ./permissions.sh'
                }

                sh 'sudo systemctl restart docker'
            }
        }
    }
}
