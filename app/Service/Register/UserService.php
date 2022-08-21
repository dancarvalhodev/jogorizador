<?php

namespace App\Service\Register;

use App\Entity\Register\UserEntity;
use App\Helpers\Password;
use App\Repository\Register\UserRepository;
use App\Service\Service;

/**
 * Class UserService.
 *
 * @author  Jerfeson Guerreiro <jerfeson_guerreiro@hotmail.com>
 *
 * @since   3.0.0
 *
 * @version 3.0.0
 */
class UserService extends Service
{
    /**
     * @param $params
     * @return bool
     * @throws \Throwable
     */
    public function register($params)
    {
        $this->beginTransaction();

        try {
            $user = new UserEntity();

            $user->profile_id = 2;
            $user->name = $params['name'];
            $user->username = $params['username'];
            $user->email = $params['email'];
            $user->password = Password::hash($params['password']);

            $user->save();
            $this->commit();

            return true;
        } catch (Throwable $e) {
            error_log($e);
            $this->rollBack();

            return false;
        }
    }


    /**
     * @return string
     */
    protected function getRepositoryClass(): string
    {
        return UserRepository::class;
    }
}
