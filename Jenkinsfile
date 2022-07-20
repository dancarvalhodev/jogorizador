pipeline {
    agent {
        docker {
            image 'dancarvalhodev/php:8.0'
        }
    }
  stages {
    stage('Test') {
      steps {
        sh 'php -v'
      }
    }
    // stage('Composer') {
    //   steps {
    //     sh 'composer install --dry-run'
    //     sh 'composer install --no-dev'
    //   }
    // }

    // stage('Setting permissions') {
    //   steps {
    //     sh 'chown -R $USER:www-data storage/'
    //     sh 'chmod -R ug+w storage/'
    //   }
    // }

    // stage('Generate keys') {
    //   steps {
    //     sh 'cd data/keys/oauth'
    //     sh 'openssl genrsa -out private.key 2048'
    //     sh 'openssl rsa -in private.key -pubout -out public.key'
    //     sh 'cd ..'
    //     sh 'chmod -R 777 data/keys/oauth'
    //   }
    // }
  }
}
