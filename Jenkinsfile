pipeline {
    agent any
    stages {
        stage('Checkout') {
            steps {
                checkout([$class: 'GitSCM', branches: [[name: '*/master']], extensions: [], userRemoteConfigs: [[url: 'https://github.com/dancarvalhodev/Jogorizador']]])
            }
        }
        stage('Docker') {
            agent { docker { image 'dancarvalhodev/php:8.0-arm' } }
            steps {
                sh 'php -v'
            }
        }
    }
}
