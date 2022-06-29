<?php
/**
 * PHPCSUtils, utility functions and classes for PHP_CodeSniffer sniff developers.
 *
 * @package   PHPCSUtils
 * @copyright 2019-2020 PHPCSUtils Contributors
 * @license   https://opensource.org/licenses/LGPL-3.0 LGPL3
 * @link      https://github.com/PHPCSStandards/PHPCSUtils
 */

namespace PHPCSUtils\Tests\Tokens\Collections;

use PHPCSUtils\Tokens\Collections;
use PHPUnit\Framework\TestCase;

/**
 * Test class.
 *
 * @covers \PHPCSUtils\Tokens\Collections::textStringStartTokens
 *
 * @group collections
 *
 * @since 1.0.0
 */
class TextStringStartTokensTest extends TestCase
{

    /**
     * Test the method.
     *
     * @return void
     */
    public function testTextStringStartTokens()
    {
        $this->assertSame(Collections::$textStingStartTokens, Collections::textStringStartTokens());
    }
}