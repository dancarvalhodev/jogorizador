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
//                 sh './key.sh'
            }
        }
    }
}
