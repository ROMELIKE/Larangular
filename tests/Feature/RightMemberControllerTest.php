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

class RightMemberControllerTest extends TestCase
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

    /**
     * test delete have file
     */
    public function testDeleteMemberHaveAvatar()
    {
        $image
            = new \Symfony\Component\HttpFoundation\File\UploadedFile(public_path('admin\images\avatars\test-file.csv'),
            'leuleu.png', 'image/png', 111, $error = null, $test = true);

        $newMember = Factory(MemberModel::class)->create([
            'name' => 'Root',
            'address' => 'TranDaiNghia',
            'age' => 21,
            'email' => 'romelike@gmail.com',
            'avatar' => $image,
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

    /**
     * //test add.name 99 character
     */
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


    /**
     * //test add.name 100 character
     */
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


    /**
     *test edit.name 99 character
     */
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

    //
    /**
     *test edit.name 100 character
     */
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

    //
    /**
     *test add.address 299 character
     */
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

    //
    /**
     *test edit.address 299 character
     */
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

    //
    /**
     *test add.address 300 character
     */
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

    //
    /**
     *test edit.address 300 character
     */
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

    //
    /**
     *test add.image lessthan 10MB
     */
    public function testAddImageLessthan10MB()
    {
        $image
            = new \Symfony\Component\HttpFoundation\File\UploadedFile(public_path('admin\images\avatars\test-file.csv'),
            'leuleu.png', 'image/png', 111, $error = null, $test = true);

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

    //
    /**
     *test edit.image lessthan 10MB
     */
    public function testEditImageLessthan10MB()
    {
        $image
            = new \Symfony\Component\HttpFoundation\File\UploadedFile(public_path('admin\images\avatars\test-file.csv'),
            'leuleu.png', 'image/jpg', 104857, $error = null, $test = true);

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
        $this->assertDatabaseHas('member',
            [
                'name' => $editMember['name'],
                'address' => $editMember['address'],
                'age' => $editMember['age'],
                'email' => $editMember['email'],
            ]);
    }

    /**
     * test add image equal 10 MB
     */
    public function testAddImageEqual10MB()
    {
        $image
            = new \Symfony\Component\HttpFoundation\File\UploadedFile(public_path('admin\images\avatars\test-file.csv'),
            'leuleu.png', 'image/png', 10485760, $error = null, $test = true);

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

    /**
     * test Edit image equal 10MB
     */
    public function testEditImageEqual10MB()
    {
        $image
            = new \Symfony\Component\HttpFoundation\File\UploadedFile(public_path('admin\images\avatars\test-file.csv'),
            'leuleu.jpg', 'image/jpg', 10485760, $error = null, $test = true);

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
        $this->assertDatabaseHas('member',
            [
                'name' => $editMember['name'],
                'address' => $editMember['address'],
                'age' => $editMember['age'],
                'email' => $editMember['email'],
            ]);
    }
    //
    /**
     *test add.image's extention = jpg
     */
    public function testAddImageJpg()
    {
        $image
            = new \Symfony\Component\HttpFoundation\File\UploadedFile(public_path('admin\images\avatars\test-file.csv'),
            'leuleu.jpg', 'image/jpg', 111, $error = null, $test = true);

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

    //
    /**
     *test edit.image's extention = jpg
     */
    public function testEditImageJpg()
    {
        $image
            = new \Symfony\Component\HttpFoundation\File\UploadedFile(public_path('admin\images\avatars\test-file.csv'),
            'leuleu.jpg', 'image/jpg', 104857, $error = null, $test = true);

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
        $this->assertDatabaseHas('member',
            [
                'name' => $editMember['name'],
                'address' => $editMember['address'],
                'age' => $editMember['age'],
                'email' => $editMember['email'],
            ]);
    }

    //
    /**
     *test add.image's extention = png
     */
    public function testAddImagePng()
    {
        $image
            = new \Symfony\Component\HttpFoundation\File\UploadedFile(public_path('admin\images\avatars\test-file.csv'),
            'leuleu.png', 'image/png', 111, $error = null, $test = true);

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

    //
    /**
     *test edit.image's extention = png
     */
    public function testEditImagePng()
    {
        $image
            = new \Symfony\Component\HttpFoundation\File\UploadedFile(public_path('admin\images\avatars\test-file.csv'),
            'leuleu.png', 'image/png', 104857, $error = null, $test = true);

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
        $this->assertDatabaseHas('member',
            [
                'name' => $editMember['name'],
                'address' => $editMember['address'],
                'age' => $editMember['age'],
                'email' => $editMember['email'],
            ]);
    }

    //
    /**
     * test add.image's extention = gif
     */
    public function testAddImageGif()
    {
        $image
            = new \Symfony\Component\HttpFoundation\File\UploadedFile(public_path('admin\images\avatars\test-file.csv'),
            'leuleu.gif', 'image/gif', 111, $error = null, $test = true);

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


    /**
     *test edit.image's extention = gif
     */
    public function testEditImageGif()
    {
        $image
            = new \Symfony\Component\HttpFoundation\File\UploadedFile(public_path('admin\images\avatars\test-file.csv'),
            'leuleu.gif', 'image/gif', 104857, $error = null, $test = true);

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
        $this->assertDatabaseHas('member',
            [
                'name' => $editMember['name'],
                'address' => $editMember['address'],
                'age' => $editMember['age'],
                'email' => $editMember['email'],
            ]);
    }
    public function testAddScriptName()
    {
        $image
            = new \Symfony\Component\HttpFoundation\File\UploadedFile(public_path('admin\images\avatars\test-file.csv'),
            'leuleu.png', 'image/png', 111, $error = null, $test = true);

        $newMember = [
            'name' => "<script>alert('leuleuleu')</script>",
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


    /**
     *test edit.image's extention = gif
     */
    public function testEditScriptName()
    {
        $image
            = new \Symfony\Component\HttpFoundation\File\UploadedFile(public_path('admin\images\avatars\test-file.csv'),
            'leuleu.png', 'image/png', 104857, $error = null, $test = true);

        $newMember = Factory(MemberModel::class)->create([
            'name' => 'RomeCody',
            'address' => 'NamTuLiem,HaNoi',
            'age' => 23,
            'email' => 'romecody@gmail.com',
            'avatar' => 'user.png'
        ]);

        $editMember = [
            'name' => "<script>alert('leuleuleu')</script>",
            'address' => 'basically',
            'age' => 21,
            'email' => 'romecody@gmail.com',
            'avatar' => $image,
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
    public function testAddScriptAddress()
    {
        $image
            = new \Symfony\Component\HttpFoundation\File\UploadedFile(public_path('admin\images\avatars\test-file.csv'),
            'leuleu.png', 'image/png', 111, $error = null, $test = true);

        $newMember = [
            'name' => "basically",
            'address' => "<script>alert('leuleuleu')</script>",
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


    /**
     *test edit.image's extention = gif
     */
    public function testEditScriptAddress()
    {
        $image
            = new \Symfony\Component\HttpFoundation\File\UploadedFile(public_path('admin\images\avatars\test-file.csv'),
            'leuleu.png', 'image/png', 104857, $error = null, $test = true);

        $newMember = Factory(MemberModel::class)->create([
            'name' => 'RomeCody',
            'address' => 'NamTuLiem,HaNoi',
            'age' => 23,
            'email' => 'romecody@gmail.com',
            'avatar' => 'user.png'
        ]);

        $editMember = [
            'name' => "basically",
            'address' => "<script>alert('leuleuleu')</script>",
            'age' => 21,
            'email' => 'romecody@gmail.com',
            'avatar' => $image,
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
    public function testAddNameTo0()
    {
        $image
            = new \Symfony\Component\HttpFoundation\File\UploadedFile(public_path('admin\images\avatars\test-file.csv'),
            'leuleu.png', 'image/png', 111, $error = null, $test = true);

        $newMember = [
            'name' => 0,
            'address' => "<script>alert('leuleuleu')</script>",
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


    /**
     *test edit.image's extention = gif
     */
    public function testEditNameTo0()
    {
        $image
            = new \Symfony\Component\HttpFoundation\File\UploadedFile(public_path('admin\images\avatars\test-file.csv'),
            'leuleu.png', 'image/png', 104857, $error = null, $test = true);

        $newMember = Factory(MemberModel::class)->create([
            'name' => 'RomeCody',
            'address' => 'NamTuLiem,HaNoi',
            'age' => 23,
            'email' => 'romecody@gmail.com',
            'avatar' => 'user.png'
        ]);

        $editMember = [
            'name' => 0,
            'address' => "<script>alert('leuleuleu')</script>",
            'age' => 21,
            'email' => 'romecody@gmail.com',
            'avatar' => $image,
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
    public function testAddAddressTo0()
    {
        $image
            = new \Symfony\Component\HttpFoundation\File\UploadedFile(public_path('admin\images\avatars\test-file.csv'),
            'leuleu.png', 'image/png', 111, $error = null, $test = true);

        $newMember = [
            'name' => "basically",
            'address' => 0,
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


    /**
     *test edit.image's extention = gif
     */
    public function testEditAddressTo0()
    {
        $image
            = new \Symfony\Component\HttpFoundation\File\UploadedFile(public_path('admin\images\avatars\test-file.csv'),
            'leuleu.png', 'image/png', 104857, $error = null, $test = true);

        $newMember = Factory(MemberModel::class)->create([
            'name' => 'RomeCody',
            'address' => 'NamTuLiem,HaNoi',
            'age' => 23,
            'email' => 'romecody@gmail.com',
            'avatar' => 'user.png'
        ]);

        $editMember = [
            'name' => "basically",
            'address' => 0,
            'age' => 21,
            'email' => 'romecody@gmail.com',
            'avatar' => $image,
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
}
