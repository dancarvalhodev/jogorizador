pipeline {
  agent {label 'docker-agent-template'}

  stages {
    stage('build') {
      steps {
        echo 'building the application...'
        sh 'docker ps'
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
