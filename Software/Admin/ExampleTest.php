<?php

class ExampleTest extends PHPUnit\Framework\TestCase {
    public function testThatTwoStringsAreTheSane() {
        $string1 = 'one';
        $string2 = 'one';

        $this->assertSame($string1, $string2);
    }

}