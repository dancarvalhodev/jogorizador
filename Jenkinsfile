pipeline {
  agent {
      docker {
          image 'dancarvalhodev/php:8.0'
      }
  }
  stages {
    stage('PHP') {
      steps {
        sh 'php -v'
      }
    }
  }
}
