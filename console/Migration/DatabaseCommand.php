<?php

namespace Console\Migration;

use App\Helpers\Password;
use Console\Console;
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Connection;
use Illuminate\Database\Schema\Builder;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class DatabaseCommand.
 */
class DatabaseCommand extends Console
{
    /**
     * @var Builder
     */
    private Builder $schemaBuilder;

    /**
     * @var Connection
     */
    private Connection $connection;

    protected function configure()
    {
        $this->setName('app:create-database');
        $this->addArgument('drop', InputArgument::OPTIONAL, 'Delete created tables', false);
        $this->setDescription('Create full database');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Starting migration');
        $this->connection = DB::connection('default');
        $this->schemaBuilder = $this->connection->getSchemaBuilder();
        if ($input->getArgument('drop') == true) {
            $output->writeln([
                'Deleting tables',
                '============',
                '',
            ]);
            $this->dropTables();
        }

        $output->writeln([
            'Create tables',
            '============',
            '',
        ]);
        $this->createTables();
        $output->writeln([
            'Insert data',
            '============',
            '',
        ]);
        $this->insertData();
        $output->writeln([
            'Process successfully completed',
            '============',
            '',
        ]);

        return Command::SUCCESS;
    }

    /**
     *  Delete tables.
     */
    private function dropTables()
    {
        $this->schemaBuilder->dropAllTables();
    }

    /**
     * Crate tables.
     */
    private function createTables()
    {
        if (!$this->schemaBuilder->hasTable('migration')) {
            $this->schemaBuilder->create('migration', function ($table) {
                $table->increments('id')->unsigned();
                $table->string('path', 255)->unique();
                $table->dateTime('created_at');
                $table->dateTime('updated_at');
                $table->softDeletes('deleted_at', 0);
            });
        }

        if (!$this->schemaBuilder->hasTable('oauth2_scope')) {
            $this->schemaBuilder->create('oauth2_scope', function ($table) {
                $table->increments('id')->unsigned();
                $table->string('description', 255);
                $table->dateTime('created_at');
                $table->dateTime('updated_at');
                $table->softDeletes('deleted_at', 0);
            });
        }

        if (!$this->schemaBuilder->hasTable('oauth2_client')) {
            $this->schemaBuilder->create('oauth2_client', function ($table) {
                $table->increments('id')->unsigned();
                $table->string('identifier', 255);
                $table->string('secret', 255);
                $table->dateTime('created_at');
                $table->dateTime('updated_at');
                $table->softDeletes('deleted_at', 0);
            });
        }

        if (!$this->schemaBuilder->hasTable('oauth2_session')) {
            $this->schemaBuilder->create('oauth2_session', function ($table) {
                $table->increments('id')->unsigned();
                $table->integer('oauth2_client_id')->unsigned();
                $table->foreign('oauth2_client_id')->references('id')->on('oauth2_client');
                $table->string('owner_type', 255);
                $table->string('owner_id', 255);
                $table->dateTime('created_at');
                $table->dateTime('updated_at');
                $table->softDeletes('deleted_at', 0);
            });
        }

        if (!$this->schemaBuilder->hasTable('oauth2_auth_code')) {
            $this->schemaBuilder->create('oauth2_auth_code', function ($table) {
                $table->increments('id')->unsigned();
                $table->integer('oauth2_session_id')->unsigned();
                $table->foreign('oauth2_session_id')->references('id')->on('oauth2_session');
                $table->integer('expire_time')->nullable();
                $table->string('client_redirect_id', 255);
                $table->dateTime('created_at');
                $table->dateTime('updated_at');
                $table->softDeletes('deleted_at', 0);
            });
        }

        if (!$this->schemaBuilder->hasTable('profile')) {
            $this->schemaBuilder->create('profile', function ($table) {
                $table->increments('id')->unsigned();
                $table->string('name', 45);
                $table->dateTime('created_at');
                $table->dateTime('updated_at');
                $table->softDeletes('deleted_at', 0);
            });
        }

        if (!$this->schemaBuilder->hasTable('client')) {
            $this->schemaBuilder->create('client', function ($table) {
                $table->increments('id')->unsigned();

                //FK
                $table->integer('oauth2_client_id')->unsigned();
                $table->foreign('oauth2_client_id')->references('id')->on('oauth2_client');

                $table->string('name', 45);
                $table->tinyInteger('status');
                $table->dateTime('created_at');
                $table->dateTime('updated_at');
                $table->softDeletes('deleted_at', 0);
            });
        }

        if (!$this->schemaBuilder->hasTable('user')) {
            $this->schemaBuilder->create('user', function ($table) {
                $table->increments('id')->unsigned();

                //FK
                $table->integer('profile_id')->unsigned();
                $table->foreign('profile_id')->references('id')->on('profile');

                $table->string('name', 45);
                $table->string('email', 100);
                $table->string('username', 45);
                $table->string('password', 255);
                $table->dateTime('created_at');
                $table->dateTime('updated_at');
                $table->softDeletes('deleted_at', 0);
            });
        }

        if (!$this->schemaBuilder->hasTable('oauth2_access_token')) {
            //oauth2_access_token
            $this->schemaBuilder->create('oauth2_access_token', function ($table) {
                $table->increments('id')->unsigned();
                $table->integer('oauth2_client_id')->unsigned();
                $table->foreign('oauth2_client_id')->references('id')->on('oauth2_client');

                //FK
                $table->integer('user_id')->unsigned()->nullable();
                $table->foreign('user_id')->references('id')->on('user');

                $table->string('access_token', 255)->nullable();
                $table->dateTime('expiry_date_time')->nullable();
                $table->dateTime('created_at');
                $table->dateTime('updated_at');
                $table->softDeletes('deleted_at', 0);
            });
        }

        if (!$this->schemaBuilder->hasTable('oauth2_refresh_token')) {
            //oauth2_access_token
            $this->schemaBuilder->create('oauth2_refresh_token', function ($table) {
                $table->increments('id')->unsigned();

                //FK
                $table->integer('oauth2_access_token_id')->unsigned();
                $table->foreign('oauth2_access_token_id')->references('id')->on('oauth2_access_token');

                $table->integer('expire_time')->nullable();
                $table->string('refresh_token', 255);
                $table->dateTime('created_at');
                $table->dateTime('updated_at');
                $table->softDeletes('deleted_at', 0);
            });
        }

        if (!$this->schemaBuilder->hasTable('platforms')) {
            $this->schemaBuilder->create('platforms', function ($table) {
                $table->increments('id')->unsigned();

                $table->string('name');
                $table->string('developer');
                $table->string('generation');
                $table->string('release_jp');
                $table->string('release_us')->nullable();
                $table->string('release_br')->nullable();
                $table->string('media_type');

                $table->dateTime('created_at', 6);
                $table->dateTime('updated_at', 6);
                $table->softDeletes('deleted_at', 0);
            });
        }

        if (!$this->schemaBuilder->hasTable('roms')) {
            $this->schemaBuilder->create('roms', function ($table) {
                $table->increments('id')->unsigned();

                //FK
                $table->integer('platform_id')->unsigned();
                $table->foreign('platform_id')->references('id')->on('platforms');

                $table->string('name');
                $table->string('developer');
                $table->string('publisher');
                $table->string('series');
                $table->dateTime('release');
                $table->string('mode');

                $table->dateTime('created_at', 6);
                $table->dateTime('updated_at', 6);
                $table->softDeletes('deleted_at', 0);
            });
        }
    }

    /**
     * Enter standard data.
     */
    private function insertData()
    {
        $date = new \DateTime();

        $this->connection->table('profile')->insert([
            'name' => 'Administrator',
            'created_at' => $date,
            'updated_at' => $date,
        ]);

        $this->connection->table('profile')->insert([
            'name' => 'User',
            'created_at' => $date,
            'updated_at' => $date,
        ]);

        $this->connection->table('oauth2_client')->insert([
            'identifier' => 'NOT_USED',
            'secret' => 'NOT_USED',
            'created_at' => $date,
            'updated_at' => $date,
        ]);

        $this->connection->table('client')->insert([
            'name' => 'Administration',
            'oauth2_client_id' => 1,
            'status' => 1,
            'created_at' => $date,
            'updated_at' => $date,
        ]);

        $this->connection->table('user')->insert([
            'profile_id' => 1,
            'name' => 'Ademir',
            'email' => 'adm@adm.com',
            'username' => 'admin',
            'password' => Password::hash('admin'),
            'created_at' => $date,
            'updated_at' => $date,
        ]);

        $this->connection->table('platforms')->insert([
            'name' => 'Super Nintendo Entertainment System',
            'developer' => 'Nintendo',
            'generation' => 'Fourth Generation',
            'release_jp' => date("Y-m-d", strtotime("1990-11-21")),
            'release_us' => date("Y-m-d", strtotime("1991-08-23")),
            'release_br' => date("Y-m-d", strtotime("1993-08-30")),
            'media_type' => 'Rom Cartridge',
            'created_at' => $date,
            'updated_at' => $date,
        ]);
    }
}
