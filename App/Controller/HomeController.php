<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Users;
use Raymonds\Controller\Controller;
use Raymonds\Utility\Sanitizer;

class HomeController extends Controller
{
    public function index(?string $input = null, ?int $second = null)
    {
        // $array = [
        //     'first' => [
        //         'second',
        //         '\'second',
        //         'HEY\\ café',
        //         "<a href='test'>Test</a>",
        //         "onclick=alert(/hacked/)"
        //     ]
        // ];
        //dd($array);
        $users = new Users;
        // $users->fname = "Test";
        // $users->lname = "User";
        // $users->email = "testuser@email.com";
        // $users->username = "testuser";
        // $users->password = '$2y$10$Vqblj4xCxLUI0NNksP3COeE2uGj80L3p5tPfz0kdZcsOoAaUp8nkq';
        // $users->acl = "none";
        // $users->deleted = 0;
        //$faker = \Faker\Factory::create();

        // pre(Users::create([
        //     'fname' => $faker->firstName,
        //     'lname' => $faker->lastName,
        //     'email' => $faker->email,
        //     'username' => $faker->userName,
        //     'password' => $faker->sha256,
        //     'acl' => 'test',
        //     'deleted' => 0
        // ]));

        //pre($users->save());
        // $user1 = Users::findFirst(1);
        // pre($user1);
        // pre(Users::all());
        //dd(Sanitizer::clean($input));
        $this->render('home/index.twig', ['users' => dd(Users::findFirst(1))]);
    }
}
