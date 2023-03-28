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

use PHPCSUtils\BackCompat\Helper;
use PHPCSUtils\Tokens\Collections;
use PHPUnit\Framework\TestCase;

/**
 * Test class.
 *
 * @covers \PHPCSUtils\Tokens\Collections::shortArrayTokensBC
 *
 * @group collections
 *
 * @since 1.0.2
 */
final class ShortArrayTokensBCTest extends TestCase
{

    /**
     * Test the method.
     *
     * @return void
     */
    public function testShortArrayTokensBC()
    {
        $expected = [
            \T_OPEN_SHORT_ARRAY  => \T_OPEN_SHORT_ARRAY,
            \T_CLOSE_SHORT_ARRAY => \T_CLOSE_SHORT_ARRAY,
        ];

        if (\version_compare(Helper::getVersion(), '3.7.1', '<=')) {
            $expected[\T_OPEN_SQUARE_BRACKET]  = \T_OPEN_SQUARE_BRACKET;
            $expected[\T_CLOSE_SQUARE_BRACKET] = \T_CLOSE_SQUARE_BRACKET;
        }

        $this->assertSame($expected, Collections::shortArrayTokensBC());
    }
}
