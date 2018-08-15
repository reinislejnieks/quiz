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




    }
    /** @test */
    public function userRetrievalById()
    {
        $userRepository = new UserRepository;

        $user = new UserModel(0, 'Atis');

        $user = $userRepository->saveOrCreate($user);



        $userRetrieved = $userRepository->getById($user->id);

        self::assertEquals($user, $userRetrieved);
    }
    /** @test */
    public function userCreation()
    {
        $repo = new UserRepository();


        $user = new UserModel(2, 'Mārcis');

        $userCreated = $repo->saveOrCreate($user);

        self::assertFalse($userCreated->isNew(), 'User not created');
        self::assertEquals($user->name, $userCreated->name, 'Names match');


    }

    /** @test */
    public function nameEdit()
    {
        $repo = new UserRepository();
        $user = new UserModel(1, 'Mārcis');
        $savedUser = $repo->saveOrCreate($user);

        $savedUser->name = 'Jānis';

        $editedUser = $repo->saveOrCreate($savedUser);

        self::assertEquals($savedUser->id, $editedUser->id, 'Same id');
        self::assertEquals($savedUser->name, $editedUser->name, 'Name is saved');
    }

    /** @test */
    public function multipleUserSaving()
    {
        $repo = new UserRepository();

        $user = new UserModel(2, 'Mārcis');
        $repo->saveOrCreate($user);

        $anotherUser = new UserModel(3, 'Agris');
        $repo->saveOrCreate($anotherUser);

        self::assertCount(2, $repo->getAll());


    }
}