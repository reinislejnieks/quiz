<?php

namespace Quiz\Tests;

use PHPUnit\Framework\TestCase;
use Quiz\Models\UserModel;
use Quiz\Repositories\UserRepository;

class UserTest extends TestCase
{
    /** @var userRepository */
    private $userRepository;

    public function setUp()
    {
        parent::setUp();

        $this->userRepository = new UserRepository;

        $user = new UserModel;
        $user->id = 23;
        $user->name = 'Atis';

        $this->userRepository->saveOrCreate($user);



    }
    /** @test */
    public function userRetrievalById()
    {
        $user = $this->userRepository->getById(23);

        self::assertEquals(23, $user->id);
    }
    /** @test */
    public function userCreation()
    {
        $repo = new UserRepository();


        $user = new UserModel;
        $user->name = 'Mārcis';

        $userCreated = $repo->saveOrCreate($user);

        self::assertFalse($userCreated->isNew(), 'User not created');
        self::assertEquals($user->name, $userCreated->name, 'Names match');


    }

    /** @test */
    public function nameEdit()
    {
        $repo = new UserRepository();


        $user = new UserModel;
        $user->name = 'Mārcis';

        $savedUser = $repo->saveOrCreate($user);

        $savedUser->name = 'Jānis';

        $editedUser = $repo->saveOrCreate($user);

        self::assertFalse($savedUser->name, $editedUser->name, 'Name is saved');
        self::assertFalse($savedUser->id, $editedUser->id, 'Same id');
    }

    /** @test */
    public function multipleUserSaving()
    {
        $repo = new UserRepository();


        $user = new UserModel;
        $user->name = 'Mārcis';

        $repo->saveOrCreate($user);

        $user = new UserModel;
        $user->name = 'Agris';

        $repo->saveOrCreate($user);

//        self::assertCount()


    }
}