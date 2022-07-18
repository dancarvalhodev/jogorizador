pipeline {
  agent {label 'docker-agent-template'}

  stages {
    stage('Check Dependencies') {
      steps {
        echo 'Checking...'
        sh 'composer install --dry-run'
      }
    }

    stage('Install Dependencies') {
      steps {
        echo 'Installing...'
        sh 'composer install --no-dev'
      }
    }

    stage('test') {
      steps {
        echo 'testing the application...'
      }
    }

    stage('deploy') {
      steps {
        echo 'deploying the application...'
      }
    }
  }
}
