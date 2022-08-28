pipeline {
    agent any
        options {
        // This is required if you want to clean before build
        skipDefaultCheckout(true)
    }
    stages {
        stage('Checkout') {
            steps {
                // Clean before build
                cleanWs()
                // We need to explicitly checkout from SCM here
                checkout scm
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
                sh './key.sh'
            }
        }
    }
}
