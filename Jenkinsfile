pipeline {
  agent {
      label {
        'docker-agent'
      }
  }
  stages {
    agent {
        docker {
            image 'dancarvalhodev/php:8.0'
        }
    }
    stage('PHP') {
      steps {
        sh 'php -v'
      }
    }
  }
}
