<?php

namespace Tests\Feature;

use App\Model\MemberModel;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class WrongMemberControllerTest extends TestCase
{
    //Wrong testing cases:
    use DatabaseMigrations;

    //test add.name 101 charater
    public function testAddName101Charaters()
    {
        $newMember = [
            'name' => '01234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567891',
            'address' => 'NamTuLiem,HaNoi',
            'age' => 23,
            'email' => 'romecody@gmail.com',
        ];

        $response = $this->call('POST', route('post.add'), $newMember);
        $this->assertEquals(302, $response->status());
        $this->assertDatabaseMissing('member',
            [
                'name' => $newMember['name'],
                'address' => $newMember['address'],
                'age' => $newMember['age'],
                'email' => $newMember['email'],
            ]);
    }

    //test edit.name 101 charater
    public function testEditName101Characters()
    {
        $newMember = Factory(MemberModel::class)->create([
            'name' => 'RomeCody',
            'address' => 'NamTuLiem,HaNoi',
            'age' => 23,
            'email' => 'romecody@gmail.com',
        ]);

        $editMember = [
            'name' => '012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901',
            'address' => 'TrungHa',
            'age' => 21,
            'email' => 'natsukorom@gmail.com'
        ];

        $response = $this->call('POST',
            route('post.edit', ['id' => $newMember->id]), $editMember);

        $this->assertEquals(302, $response->status());
        $this->assertDatabaseMissing('member',
            [
                'name' => $editMember['name'],
                'address' => $editMember['address'],
                'age' => $editMember['age'],
                'email' => $editMember['email'],
            ]);
    }

    //test add.name empty
    public function testAddNameEmpty()
    {
        $newMember = [
            'name' => '',
            'address' => 'NamTuLiem,HaNoi',
            'age' => 23,
            'email' => 'romecody@gmail.com',
        ];

        $response = $this->call('POST', route('post.add'), $newMember);
        $this->assertEquals(302, $response->status());
        $this->assertDatabaseMissing('member',
            [
                'name' => $newMember['name'],
                'address' => $newMember['address'],
                'age' => $newMember['age'],
                'email' => $newMember['email'],
            ]);
    }

    //test edit.name empty
    public function testEditNameEmpty()
    {
        $newMember = Factory(MemberModel::class)->create([
            'name' => 'RomeCody',
            'address' => 'NamTuLiem,HaNoi',
            'age' => 23,
            'email' => 'romecody@gmail.com',
        ]);

        $editMember = [
            'name' => '',
            'address' => 'TrungHa',
            'age' => 21,
            'email' => 'natsukorom@gmail.com'
        ];

        $response = $this->call('POST',
            route('post.edit', ['id' => $newMember->id]), $editMember);

        $this->assertEquals(302, $response->status());
        $this->assertDatabaseMissing('member',
            [
                'name' => $editMember['name'],
                'address' => $editMember['address'],
                'age' => $editMember['age'],
                'email' => $editMember['email'],
            ]);
    }

    //test add.address empty
    public function testAddAddressEmpty()
    {
        $newMember = [
            'name' => 'basic',
            'address' => '',
            'age' => 23,
            'email' => 'romecody@gmail.com',
        ];

        $response = $this->call('POST', route('post.add'), $newMember);
        $this->assertEquals(302, $response->status());
        $this->assertDatabaseMissing('member',
            [
                'name' => $newMember['name'],
                'address' => $newMember['address'],
                'age' => $newMember['age'],
                'email' => $newMember['email'],
            ]);
    }

    //test edit.address empty
    public function testEditAddressEmpty()
    {
        $newMember = Factory(MemberModel::class)->create([
            'name' => 'RomeCody',
            'address' => 'NamTuLiem,HaNoi',
            'age' => 23,
            'email' => 'romecody@gmail.com',
        ]);

        $editMember = [
            'name' => 'romcody',
            'address' => '',
            'age' => 21,
            'email' => 'natsukorom@gmail.com'
        ];

        $response = $this->call('POST',
            route('post.edit', ['id' => $newMember->id]), $editMember);

        $this->assertEquals(302, $response->status());
        $this->assertDatabaseMissing('member',
            [
                'name' => $editMember['name'],
                'address' => $editMember['address'],
                'age' => $editMember['age'],
                'email' => $editMember['email'],
            ]);
    }

    //test add.age empty
    public function testAddAgeEmpty()
    {
        $newMember = [
            'name' => 'basic',
            'address' => 'Hanoi',
            'age' => '',
            'email' => 'romecody@gmail.com',
        ];

        $response = $this->call('POST', route('post.add'), $newMember);
        $this->assertEquals(302, $response->status());
        $this->assertDatabaseMissing('member',
            [
                'name' => $newMember['name'],
                'address' => $newMember['address'],
                'age' => $newMember['age'],
                'email' => $newMember['email'],
            ]);
    }

    //test edit.age empty
    public function testEditAgeEmpty()
    {
        $newMember = Factory(MemberModel::class)->create([
            'name' => 'RomeCody',
            'address' => 'NamTuLiem,HaNoi',
            'age' => 23,
            'email' => 'romecody@gmail.com',
        ]);

        $editMember = [
            'name' => 'romcody',
            'address' => 'Hanoi',
            'age' => null,
            'email' => 'natsukorom@gmail.com'
        ];

        $response = $this->call('POST',
            route('post.edit', ['id' => $newMember->id]), $editMember);

        $this->assertEquals(302, $response->status());
        $this->assertDatabaseMissing('member',
            [
                'name' => $editMember['name'],
                'address' => $editMember['address'],
                'age' => $editMember['age'],
                'email' => $editMember['email'],
            ]);
    }

    //test add.address 301 character
    public function testAddAddress301Charaters()
    {
        $newMember = [
            'name' => 'basic',
            'address' => '01234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901',
            'age' => 23,
            'email' => 'romecody@gmail.com',
        ];

        $response = $this->call('POST', route('post.add'), $newMember);
        $this->assertEquals(302, $response->status());
        $this->assertDatabaseMissing('member',
            [
                'name' => $newMember['name'],
                'address' => $newMember['address'],
                'age' => $newMember['age'],
                'email' => $newMember['email'],
            ]);
    }

    //test edit.address 301 character
    public function testEditAddress301Characters()
    {
        $newMember = Factory(MemberModel::class)->create([
            'name' => 'RomeCody',
            'address' => 'NamTuLiem,HaNoi',
            'age' => 23,
            'email' => 'romecody@gmail.com',
        ]);

        $editMember = [
            'name' => 'Basically',
            'address' => '0123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890',
            'age' => 21,
            'email' => 'natsukorom@gmail.com'
        ];

        $response = $this->call('POST',
            route('post.edit', ['id' => $newMember->id]), $editMember);

        $this->assertEquals(302, $response->status());
        $this->assertDatabaseMissing('member',
            [
                'name' => $editMember['name'],
                'address' => $editMember['address'],
                'age' => $editMember['age'],
                'email' => $editMember['email'],
            ]);
    }

    //test add.age 3 digit
    public function testAddAge3Digits()
    {
        $newMember = [
            'name' => 'basic',
            'address' => 'QuangNinh Province',
            'age' => 233,
            'email' => 'romecody@gmail.com',
        ];

        $response = $this->call('POST', route('post.add'), $newMember);
        $this->assertEquals(302, $response->status());
        $this->assertDatabaseMissing('member',
            [
                'name' => $newMember['name'],
                'address' => $newMember['address'],
                'age' => $newMember['age'],
                'email' => $newMember['email'],
            ]);
    }

    //test edit.age 3 digit
    public function testEditAge3Digits()
    {
        $newMember = Factory(MemberModel::class)->create([
            'name' => 'RomeCody',
            'address' => 'NamTuLiem,HaNoi',
            'age' => 23,
            'email' => 'romecody@gmail.com',
        ]);

        $editMember = [
            'name' => 'Basically',
            'address' => 'Hanoi BaDinh',
            'age' => 233,
            'email' => 'natsukorom@gmail.com'
        ];

        $response = $this->call('POST',
            route('post.edit', ['id' => $newMember->id]), $editMember);

        $this->assertEquals(302, $response->status());
        $this->assertDatabaseMissing('member',
            [
                'name' => $editMember['name'],
                'address' => $editMember['address'],
                'age' => $editMember['age'],
                'email' => $editMember['email'],
            ]);
    }


    /**
     *  //test  add age charater not number
     */
    public function testAddAgeNotNumber()
    {
        $newMember = [
            'name' => 'basic',
            'address' => 'QuangNinh Province',
            'age' => 'leu leu leu',
            'email' => 'romecody@gmail.com',
        ];

        $response = $this->call('POST', route('post.add'), $newMember);
        $this->assertEquals(302, $response->status());
        $this->assertDatabaseMissing('member',
            [
                'name' => $newMember['name'],
                'address' => $newMember['address'],
                'age' => $newMember['age'],
                'email' => $newMember['email'],
            ]);
    }

    /**
     * //test  edit age charater not number
     */
    public function testEditAgeNotNumber()
    {
        $newMember = Factory(MemberModel::class)->create([
            'name' => 'RomeCody',
            'address' => 'NamTuLiem,HaNoi',
            'age' => 23,
            'email' => 'romecody@gmail.com',
        ]);

        $editMember = [
            'name' => 'Basically',
            'address' => 'Hanoi BaDinh',
            'age' => 'leu leu leu',
            'email' => 'natsukorom@gmail.com'
        ];

        $response = $this->call('POST',
            route('post.edit', ['id' => $newMember->id]), $editMember);

        $this->assertEquals(302, $response->status());
        $this->assertDatabaseMissing('member',
            [
                'name' => $editMember['name'],
                'address' => $editMember['address'],
                'age' => $editMember['age'],
                'email' => $editMember['email'],
            ]);
    }

    /**
     * //test Add image morethan 10MB
     */
    public function testAddImageGreaterThan10MB()
    {
        $image
            = new \Symfony\Component\HttpFoundation\File\UploadedFile(public_path('admin\images\avatars\test-file.csv'),
            'leuleu.png', 'image/png', 12112121212121212, $error = null, $test = true);

        $newMember = [
            'name' => 'basic',
            'address' => 'basic address',
            'age' => 23,
            'email' => 'romecody@gmail.com',
            'avatar' => $image,
        ];
        $response = $this->call('POST', route('post.add'), $newMember);
        $this->assertEquals(200, $response->status());
        $this->assertDatabaseMissing('member',
            [
                'name' => $newMember['name'],
                'address' => $newMember['address'],
                'age' => $newMember['age'],
                'email' => $newMember['email'],
            ]);
    }
    /**
     * test Edit image morethan 10MB
     */
    public function testEditImageGreaterThan10MB()
    {
        $image
            = new \Symfony\Component\HttpFoundation\File\UploadedFile(public_path('admin\images\avatars\test-file.csv'),
            'leuleu.png', 'image/png', 10485700000, $error = null, $test = true);

        $newMember = Factory(MemberModel::class)->create([
            'name' => 'RomeCody',
            'address' => 'NamTuLiem,HaNoi',
            'age' => 23,
            'email' => 'romecody@gmail.com',
            'avatar' => 'user.png'
        ]);

        $editMember = [
            'name' => 'Basically',
            'address' => 'basically',
            'age' => 21,
            'email' => 'romecody@gmail.com',
            'avatar' => $image,
        ];

        $response = $this->call('POST',
            route('post.edit', ['id' => $newMember->id]), $editMember);

        $this->assertEquals(200, $response->status());
        $this->assertDatabaseMissing('member',
            [
                'name' => $editMember['name'],
                'address' => $editMember['address'],
                'age' => $editMember['age'],
                'email' => $editMember['email'],
            ]);
    }


    /**
     * //test Add image's extention not support
     */
    public function testAddImageExtentionNotSupport()
    {
        $image
            = new \Symfony\Component\HttpFoundation\File\UploadedFile(public_path('admin\images\avatars\test-file.csv'),
            'leuleu.mp3', 'audio/mp3', 12112, $error = null, $test = true);

        $newMember = [
            'name' => 'basic',
            'address' => 'basic address',
            'age' => 23,
            'email' => 'romecody@gmail.com',
            'avatar' => $image,
        ];
        $response = $this->call('POST', route('post.add'), $newMember);
        $this->assertEquals(200, $response->status());
        $this->assertDatabaseMissing('member',
            [
                'name' => $newMember['name'],
                'address' => $newMember['address'],
                'age' => $newMember['age'],
                'email' => $newMember['email'],
            ]);
    }

    /**
     * //test Edit image's extention not support
     */
    public function testEditImageExtentionNotSupport()
    {
        $image
            = new \Symfony\Component\HttpFoundation\File\UploadedFile(public_path('admin\images\avatars\test-file.csv'),
            'leuleu.mp3', 'audio/mp3', 10485700000, $error = null, $test = true);

        $newMember = Factory(MemberModel::class)->create([
            'name' => 'RomeCody',
            'address' => 'NamTuLiem,HaNoi',
            'age' => 23,
            'email' => 'romecody@gmail.com',
            'avatar' => 'user.png'
        ]);

        $editMember = [
            'name' => 'Basically',
            'address' => 'basically',
            'age' => 21,
            'email' => 'romecody@gmail.com',
            'avatar' => $image,
        ];

        $response = $this->call('POST',
            route('post.edit', ['id' => $newMember->id]), $editMember);

        $this->assertEquals(200, $response->status());
        $this->assertDatabaseMissing('member',
            [
                'name' => $editMember['name'],
                'address' => $editMember['address'],
                'age' => $editMember['age'],
                'email' => $editMember['email'],
            ]);
    }
}
