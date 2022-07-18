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

    stage('Setting permissions') {
      steps {
        sh 'chown -R $USER:www-data storage/'
        sh 'chmod -R ug+w storage/'
      }
    }

    stage('deploy') {
      steps {
        echo 'deploying the application...'
      }
    }
  }
}
