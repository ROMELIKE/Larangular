<?php

namespace Tests\Feature;

use App\Business\MemberObject;
use App\Model\MemberModel;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MemberControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    /**
     * Purpose: test view list member return.
     */
    public function testList()
    {
        $member = factory(MemberModel::class)->create();
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /**
     * Purpose: test feedback when choose a memmber.
     */
    public function testEdit()
    {
        $member = factory(MemberModel::class)->create();
        $response = $this->get(route('get.edit', ['id' => $member->id]));
        $response->assertStatus(200);
    }

    /**
     * Purpose: test when add new member.
     */
    public function testAdd()
    {
        $newMember = [
            'name' => 'RomeCody',
            'address' => 'NamTuLiem,HaNoi',
            'age' => 23,
            'email' => 'romecody@gmail.com',
        ];
        
        $response = $this->call('POST',route('post.add'), $newMember);
        $this->assertEquals(200, $response->status());
//        $this->assertDatabaseHas('member',
//            [
//                'name' => $newMember['name'],
//                'address' => $newMember['address'],
//                'age' => $newMember['age'],
//                'email' => $newMember['email'],
//            ]);
    }


}
