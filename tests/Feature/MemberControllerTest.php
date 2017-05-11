<?php

namespace Tests\Feature;

use App\Business\MemberObject;
use App\Model\MemberModel;
use Faker\Factory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;

class MemberControllerTest extends TestCase
{
    use DatabaseMigrations;

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

        $response = $this->call('POST', route('post.add'), $newMember);
        $this->assertEquals(200, $response->status());
        $this->assertDatabaseHas('member',
            [
                'name' => $newMember['name'],
                'address' => $newMember['address'],
                'age' => $newMember['age'],
                'email' => $newMember['email'],
            ]);
    }

    /**
     * Purpose: test when add new member.
     */
    public function testPostEdit()
    {
        $newMember = Factory(MemberModel::class)->create([
            'name' => 'RomeCody',
            'address' => 'NamTuLiem,HaNoi',
            'age' => 23,
            'email' => 'romecody@gmail.com',
        ]);

        $editMember = [
            'name' => 'Cobol',
            'address' => 'TrungHa',
            'age' => 21,
            'email' => 'natsukorom@gmail.com'
        ];

        $response = $this->call('POST',
            route('post.edit', ['id' => $newMember->id]), $editMember);

        $this->assertEquals(200, $response->status());
        $this->assertDatabaseHas('member',
            [
                'name' => $editMember['name'],
                'address' => $editMember['address'],
                'age' => $editMember['age'],
                'email' => $editMember['email'],
            ]);
    }

    /**
     *  Purpose: test when delete a member.
     */
    public function testDeleteMember()
    {
        $newMember = Factory(MemberModel::class)->create([
            'name' => 'Root',
            'address' => 'TranDaiNghia',
            'age' => 21,
            'email' => 'romelike@gmail.com'
        ]);
        $response = $this->call('get',
            route('get.delete', ['id' => $newMember->id]));
        $this->assertEquals(200, $response->status());
        $this->assertDatabaseMissing('member',
            [
                'name' => 'Root',
                'address' => 'TranDaiNghia',
                'age' => 21,
                'email' => 'romelike@gmail.com'
            ]);
    }

    //test add.name 99 character
    public function testAddName99Charaters()
    {
        $newMember = [
            'name' => '012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678',
            'address' => 'NamTuLiem,HaNoi',
            'age' => 23,
            'email' => 'romecody@gmail.com',
        ];

        $response = $this->call('POST', route('post.add'), $newMember);
        $this->assertEquals(200, $response->status());
        $this->assertDatabaseHas('member',
            [
                'name' => $newMember['name'],
                'address' => $newMember['address'],
                'age' => $newMember['age'],
                'email' => $newMember['email'],
            ]);
    }

    //test add.name 100 character
    public function testAddName100Charaters()
    {
        $newMember = [
            'name' => '0123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789',
            'address' => 'NamTuLiem,HaNoi',
            'age' => 23,
            'email' => 'romecody@gmail.com',
        ];

        $response = $this->call('POST', route('post.add'), $newMember);
        $this->assertEquals(200, $response->status());
        $this->assertDatabaseHas('member',
            [
                'name' => $newMember['name'],
                'address' => $newMember['address'],
                'age' => $newMember['age'],
                'email' => $newMember['email'],
            ]);
    }

    //test edit.name 99 character
    public function testEditName99Characters()
    {
        $newMember = Factory(MemberModel::class)->create([
            'name' => 'RomeCody',
            'address' => 'NamTuLiem,HaNoi',
            'age' => 23,
            'email' => 'romecody@gmail.com',
        ]);

        $editMember = [
            'name' => '012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678',
            'address' => 'TrungHa',
            'age' => 21,
            'email' => 'natsukorom@gmail.com'
        ];

        $response = $this->call('POST',
            route('post.edit', ['id' => $newMember->id]), $editMember);

        $this->assertEquals(200, $response->status());
        $this->assertDatabaseHas('member',
            [
                'name' => $editMember['name'],
                'address' => $editMember['address'],
                'age' => $editMember['age'],
                'email' => $editMember['email'],
            ]);
    }

    //test edit.name 100 character
    public function testEditName100Characters()
    {
        $newMember = Factory(MemberModel::class)->create([
            'name' => 'RomeCody',
            'address' => 'NamTuLiem,HaNoi',
            'age' => 23,
            'email' => 'romecody@gmail.com',
        ]);

        $editMember = [
            'name' => '0123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789',
            'address' => 'TrungHa',
            'age' => 21,
            'email' => 'natsukorom@gmail.com'
        ];

        $response = $this->call('POST',
            route('post.edit', ['id' => $newMember->id]), $editMember);

        $this->assertEquals(200, $response->status());
        $this->assertDatabaseHas('member',
            [
                'name' => $editMember['name'],
                'address' => $editMember['address'],
                'age' => $editMember['age'],
                'email' => $editMember['email'],
            ]);
    }

    //test add.address 299 character
    public function testAddAddress299Charaters()
    {
        $newMember = [
            'name' => 'basic',
            'address' => '01234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678',
            'age' => 23,
            'email' => 'romecody@gmail.com',
        ];

        $response = $this->call('POST', route('post.add'), $newMember);
        $this->assertEquals(200, $response->status());
        $this->assertDatabaseHas('member',
            [
                'name' => $newMember['name'],
                'address' => $newMember['address'],
                'age' => $newMember['age'],
                'email' => $newMember['email'],
            ]);
    }

    //test edit.address 299 character
    public function testEditAddress299Characters()
    {
        $newMember = Factory(MemberModel::class)->create([
            'name' => 'RomeCody',
            'address' => 'NamTuLiem,HaNoi',
            'age' => 23,
            'email' => 'romecody@gmail.com',
        ]);

        $editMember = [
            'name' => 'Basically',
            'address' => '01234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678',
            'age' => 21,
            'email' => 'natsukorom@gmail.com'
        ];

        $response = $this->call('POST',
            route('post.edit', ['id' => $newMember->id]), $editMember);

        $this->assertEquals(200, $response->status());
        $this->assertDatabaseHas('member',
            [
                'name' => $editMember['name'],
                'address' => $editMember['address'],
                'age' => $editMember['age'],
                'email' => $editMember['email'],
            ]);
    }

    //test add.address 300 character
    public function testAddAddress300Charaters()
    {
        $newMember = [
            'name' => 'basic',
            'address' => '012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789',
            'age' => 23,
            'email' => 'romecody@gmail.com',
        ];

        $response = $this->call('POST', route('post.add'), $newMember);
        $this->assertEquals(200, $response->status());
        $this->assertDatabaseHas('member',
            [
                'name' => $newMember['name'],
                'address' => $newMember['address'],
                'age' => $newMember['age'],
                'email' => $newMember['email'],
            ]);
    }

    //test edit.address 300 character
    public function testEditAddress300Characters()
    {
        $newMember = Factory(MemberModel::class)->create([
            'name' => 'RomeCody',
            'address' => 'NamTuLiem,HaNoi',
            'age' => 23,
            'email' => 'romecody@gmail.com',
        ]);

        $editMember = [
            'name' => 'Basically',
            'address' => '012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789',
            'age' => 21,
            'email' => 'natsukorom@gmail.com'
        ];

        $response = $this->call('POST',
            route('post.edit', ['id' => $newMember->id]), $editMember);

        $this->assertEquals(200, $response->status());
        $this->assertDatabaseHas('member',
            [
                'name' => $editMember['name'],
                'address' => $editMember['address'],
                'age' => $editMember['age'],
                'email' => $editMember['email'],
            ]);
    }

    //test add.image lessthan 10MB
    public function testAddImageLessthan10MB()
    {
        $image
            = new \Symfony\Component\HttpFoundation\File\UploadedFile(storage_path('images\test-file.csv'),
            'leuleu.jpg','image/png',3444, $error = null, $test = true);

//        dd($image->getClientSize());
        $newMember = [
            'name' => 'basic',
            'address' => 'basic address',
            'age' => 23,
            'email' => 'romecody@gmail.com',
            'avatar' => $image,
        ];

        $response = $this->call('POST', route('post.add'), $newMember);
        $this->assertEquals(200, $response->status());
        $this->assertDatabaseHas('member',
            [
                'name' => $newMember['name'],
                'address' => $newMember['address'],
                'age' => $newMember['age'],
                'email' => $newMember['email'],
            ]);
    }

    //test edit.image lessthan 10MB
    public function testEditImageLessthan10MB()
    {

    }

    //test add.image's extention = jpg
    public function addImageJpg()
    {

    }

    //test edit.image's extention = jpg
    public function editImageJpg()
    {

    }

    //test add.image's extention = png
    public function addImagePng()
    {

    }

    //test edit.image's extention = png
    public function editImagePng()
    {

    }

    //test add.image's extention = png
    public function addImageGif()
    {

    }

    //test edit.image's extention = png
    public function editImageGif()
    {

    }
}
