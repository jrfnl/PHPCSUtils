<?php
/**
 * PHPCSUtils, utility functions and classes for PHP_CodeSniffer sniff developers.
 *
 * @package   PHPCSUtils
 * @copyright 2019-2024 PHPCSUtils Contributors
 * @license   https://opensource.org/licenses/LGPL-3.0 LGPL3
 * @link      https://github.com/PHPCSStandards/PHPCSUtils
 */

namespace PHPCSUtils\Tests\Utils\FileInfo;

use PHPCSUtils\TestUtils\UtilityMethodTestCase;
use PHPCSUtils\Utils\FileInfo;

/**
 * Tests for the \PHPCSUtils\Utils\FileInfo::hasSheBang() method.
 *
 * @covers \PHPCSUtils\Utils\FileInfo::hasSheBang
 *
 * @since 1.1.0
 */
final class HasSheBangPHPWithParamNTest extends UtilityMethodTestCase
{

    /**
     * Test whether a byte order mark at the start of the file is correctly recognized.
     *
     * @return void
     */
    public function testHasSheBang()
    {
        $this->assertTrue(FileInfo::hasSheBang(self::$phpcsFile));
    }
}
