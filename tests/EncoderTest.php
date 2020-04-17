<?php
/**
 * Rych Bencode
 *
 * Bencode serializer for PHP 5.3+.
 *
 * @package   Rych\Bencode
 * @copyright Copyright (c) 2014, Ryan Chouinard
 * @author    Ryan Chouinard <rchouinard@gmail.com>
 * @license   MIT License - http://www.opensource.org/licenses/mit-license.php
 */

namespace Rych\Bencode;

use PHPUnit_Framework_TestCase as TestCase;
use stdClass;

/**
 * Bencode encoder test
 */
class EncoderTest extends TestCase
{

    /**
     * Test that strings are properly encoded
     *
     */
    public function testCanEncodeString(): void
    {
        $this->assertEquals('6:string', Encoder::encode('string'));
    }

    /**
     * Test that integers are properly encoded
     *
     */
    public function testCanEncodeInteger(): void
    {
        $this->assertEquals('i42e', Encoder::encode(42));
        $this->assertEquals('i-42e', Encoder::encode(-42));
        $this->assertEquals('i0e', Encoder::encode(0));
    }

    /**
     * Test that lists are properly encoded
     *
     */
    public function testCanEncodeList(): void
    {
        $this->assertEquals('l3:foo3:bare', Encoder::encode(array('foo', 'bar')));
    }

    /**
     * Test that dictionaries are properly encoded
     *
     */
    public function testCanEncodeDictionary(): void
    {
        $this->assertEquals('d3:foo3:bare', Encoder::encode(array('foo' => 'bar')));
    }

    /**
     * Test that objects with public properties are properly encoded
     *
     */
    public function testCanEncodeObjectWithoutToArray(): void
    {
        $object = new stdClass;
        $object->string = 'foo';
        $object->integer = 42;

        $this->assertEquals('d7:integeri42e6:string3:fooe', Encoder::encode($object));
    }

    /**
     * Test regression of issue #1
     *
     * Encoder should treat numeric strings as strings rather than
     * integers.
     */
    public function testIssue1Regression(): void
    {
        $data = array(
            'Numeric string value' => '1',
            '1'                    => 'Numeric string key',
        );

        $this->assertEquals('d20:Numeric string value1:11:118:Numeric string keye', Encoder::encode($data));
    }

}
