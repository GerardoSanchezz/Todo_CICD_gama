<?php

use PHPUnit\Framework\TestCase;

class SampleTest extends TestCase
{
    /**
     * A simple test example.
     */
    public function testAddition()
    {
        $result = $this->add(2, 3);
        $this->assertEquals(5, $result);
    }

    /**
     * Add two numbers.
     *
     * @param int $a
     * @param int $b
     * @return int
     */
    protected function add($a, $b)
    {
        return $a + $b;
    }

    /**
     * Test a basic assertion.
     */
    public function testTrueIsTrue()
    {
        $this->assertTrue(true);
    }

   
}

?>
