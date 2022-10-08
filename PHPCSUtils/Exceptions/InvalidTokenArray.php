<?php
/**
 * PHPCSUtils, utility functions and classes for PHP_CodeSniffer sniff developers.
 *
 * @package   PHPCSUtils
 * @copyright 2019-2020 PHPCSUtils Contributors
 * @license   https://opensource.org/licenses/LGPL-3.0 LGPL3
 * @link      https://github.com/PHPCSStandards/PHPCSUtils
 */

namespace PHPCSUtils\Exceptions;

use PHP_CodeSniffer\Exceptions\RuntimeException;

/**
 * Exception thrown when an non-existent token array is requested.
 *
 * @since 1.0.0-alpha4
 */
final class InvalidTokenArray extends RuntimeException
{

    /**
     * Create a new invalid token array exception with a standardized text.
     *
     * @param string $name The name of the token array requested.
     *
     * @return \PHPCSUtils\Exceptions\InvalidTokenArray
     */
    public static function create($name)
    {
        // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_debug_backtrace
        $stack = \debug_backtrace(\DEBUG_BACKTRACE_IGNORE_ARGS, 2);

        return new self(
            \sprintf(
                'Call to undefined method %s::%s()',
                $stack[1]['class'],
                $name
            )
        );
    }
}