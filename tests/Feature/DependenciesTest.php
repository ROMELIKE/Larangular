<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DependenciesTest extends TestCase
{

    public function addNumber($a, $b)
    {
        return $a + $b;
    }

    public function testAssert()
    {
        $sampleArray = [
            1 => 'Java',
            2 => 'PHP',
            3 => 'Python',
            4 => 'C#',
            5 => 'Ruby'
        ];

        $emptyArray = [];

        $this->assertEquals(5, $this->addNumber(2, 3));
        $this->assertCount(5, $sampleArray);
        $this->assertNotEmpty($sampleArray);
        $this->assertEmpty($emptyArray);
        $this->assertArraySubset([1 => 'Java', 3 => 'Python'], $sampleArray);
        $this->assertArrayHasKey(3, $sampleArray);
    }
}