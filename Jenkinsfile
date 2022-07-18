pipeline {
  agent {label 'docker-agent-template'}

  stages {
    stage('build') {
      agent { docker { image 'dancarvalhodev/php:8.0' } }

      steps {
        echo 'building the application...'
        sh 'php -v'
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
