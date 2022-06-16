<?php
/**
 * PHPCSUtils, utility functions and classes for PHP_CodeSniffer sniff developers.
 *
 * @package   PHPCSUtils
 * @copyright 2019-2020 PHPCSUtils Contributors
 * @license   https://opensource.org/licenses/LGPL-3.0 LGPL3
 * @link      https://github.com/PHPCSStandards/PHPCSUtils
 */

namespace PHPCSUtils\Tests\Internal\NoFileCache;

use PHPCSUtils\Internal\NoFileCache;
use PHPCSUtils\Tests\TypeProviderHelper;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the file-independent caching functionality.
 *
 * @group cache
 *
 * @covers \PHPCSUtils\Internal\NoFileCache::isCached
 * @covers \PHPCSUtils\Internal\NoFileCache::get
 * @covers \PHPCSUtils\Internal\NoFileCache::set
 *
 * @since 1.0.0
 */
class SetTest extends TestCase
{

    /**
     * Clear the cache between tests.
     *
     * @before
     * @after
     *
     * @return void
     */
    protected function clearCache()
    {
        NoFileCache::clear();
    }

    /**
     * Test that every data type is accepted as a cachable value, including `null`, that the
     * `NoFileCache::isCached()` function recognizes a set value correctly and that all values can be retrieved.
     *
     * @dataProvider dataEveryTypeOfInput
     *
     * @param mixed $input Value to cache.
     *
     * @return void
     */
    public function testSetAcceptsEveryTypeOfInput($input)
    {
        $id = $this->getName();
        NoFileCache::set(__METHOD__, $id, $input);

        $this->assertTrue(
            NoFileCache::isCached(__METHOD__, $id),
            'NoFileCache::isCached() could not find the cached value'
        );

        $this->assertSame(
            $input,
            NoFileCache::get(__METHOD__, $id),
            'Value retrieved via NoFileCache::get() did not match expectations'
        );
    }

    /**
     * Data provider.
     *
     * @return array
     */
    public function dataEveryTypeOfInput()
    {
        return TypeProviderHelper::getAll();
    }

    /**
     * Verify that all supported types of IDs are accepted.
     *
     * Note: this doesn't test the unhappy path of passing an unsupported type of key, but
     * non-int/string keys are not accepted by PHP for arrays anyway, so that should result
     * in PHP warnings/errors anyway and as this is an internal class, I'm not too concerned
     * about that kind of mistake being made.
     *
     * @dataProvider dataSetAcceptsIntAndStringIdKeys
     *
     * @param int|string $id ID for the cache.
     *
     * @return void
     */
    public function testSetAcceptsIntAndStringIdKeys($id)
    {
        $value = 'value' . $id;

        NoFileCache::set(__METHOD__, $id, $value);

        $this->assertTrue(
            NoFileCache::isCached(__METHOD__, $id),
            'NoFileCache::isCached() could not find the cached value'
        );

        $this->assertSame(
            $value,
            NoFileCache::get(__METHOD__, $id),
            'Value retrieved via NoFileCache::get() did not match expectations'
        );
    }

    /**
     * Data provider.
     *
     * @return array
     */
    public function dataSetAcceptsIntAndStringIdKeys()
    {
        return [
            'ID: int zero' => [
                'id' => 0,
            ],
            'ID: positive int' => [
                'id' => 12832,
            ],
            'ID: negative int' => [
                'id' => -274,
            ],
            'ID: string' => [
                'id' => 'string ID',
            ],
        ];
    }

    /**
     * Verify that a previously set cached value will be overwritten when set() is called again
     * with the same file, ID and key.
     *
     * @return void
     */
    public function testSetWillOverwriteExistingValue()
    {
        $id        = 'my key';
        $origValue = 'original value';

        NoFileCache::set(__METHOD__, $id, $origValue);

        // Verify that the original value was set correctly.
        $this->assertTrue(
            NoFileCache::isCached(__METHOD__, $id),
            'NoFileCache::isCached() could not find the originally cached value'
        );
        $this->assertSame(
            $origValue,
            NoFileCache::get(__METHOD__, $id),
            'Original value retrieved via NoFileCache::get() did not match expectations'
        );

        $newValue = 'new value';
        NoFileCache::set(__METHOD__, $id, $newValue);

        // Verify the overwrite happened.
        $this->assertTrue(
            NoFileCache::isCached(__METHOD__, $id),
            'NoFileCache::isCached() could not find the newly cached value'
        );
        $this->assertSame(
            $newValue,
            NoFileCache::get(__METHOD__, $id),
            'New value retrieved via NoFileCache::get() did not match expectations'
        );
    }
}