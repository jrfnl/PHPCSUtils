<?php
/**
 * PHPCSUtils, utility functions and classes for PHP_CodeSniffer sniff developers.
 *
 * @package   PHPCSUtils
 * @copyright 2019 PHPCSUtils Contributors
 * @license   https://opensource.org/licenses/LGPL-3.0 LGPL3
 * @link      https://github.com/PHPCSStandards/PHPCSUtils
 */

namespace PHPCSUtils\Utils;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Util\Tokens;
use PHPCSUtils\BackCompat\Helper;
use PHPCSUtils\Tokens\Collections;
use PHPCSUtils\Utils\Lists;

/**
 * Utility functions for use when examining arrays.
 *
 * @since 1.0.0
 */
class Arrays
{

    /**
     * Determine whether a `T_OPEN/CLOSE_SHORT_ARRAY` token is a short array() construct
     * and not a short list.
     *
     * This method also accepts `T_OPEN/CLOSE_SQUARE_BRACKET` tokens to allow it to be
     * PHPCS cross-version compatible as the short array tokenizing has been plagued by
     * a number of bugs over time.
     *
     * @since 1.0.0
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile The file being scanned.
     * @param int                         $stackPtr  The position of the short array bracket token.
     *
     * @return bool True if the token passed is the open/close bracket of a short array.
     *              False if the token is a short list bracket, a plain square bracket
     *              or not one of the accepted tokens.
     */
    public static function isShortArray(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        // Is this one of the tokens this function handles ?
        if (isset($tokens[$stackPtr]) === false
            || isset(Collections::$shortArrayTokensBC[$tokens[$stackPtr]['code']]) === false
        ) {
            return false;
        }

        // All known tokenizer bugs are in PHPCS versions before 3.3.0.
        $phpcsVersion = Helper::getVersion();

        /*
         * Deal with square brackets which may be incorrectly tokenized short arrays.
         */
        if (isset(Collections::$shortArrayTokens[$tokens[$stackPtr]['code']]) === false) {
            if (\version_compare($phpcsVersion, '3.3.0', '>=')) {
                // These will just be properly tokenized, plain square brackets. No need for further checks.
                return false;
            }

            $opener = $stackPtr;
            if ($tokens[$stackPtr]['code'] === \T_CLOSE_SQUARE_BRACKET) {
                $opener = $tokens[$stackPtr]['bracket_opener'];
            }

            if (isset($tokens[$opener]['bracket_closer']) === false) {
                return false;
            }

            $prevNonEmpty = $phpcsFile->findPrevious(Tokens::$emptyTokens, ($opener - 1), null, true);

            if (\version_compare($phpcsVersion, '2.8.0', '>=')) {
                /*
                 * BC: Work around a bug in the tokenizer of PHPCS 2.8.0 - 3.2.3 where a `[` would be
                 * tokenized as T_OPEN_SQUARE_BRACKET instead of T_OPEN_SHORT_ARRAY if it was
                 * preceded by a PHP open tag at the very start of the file.
                 *
                 * If we have square brackets which are not that specific situation, they are just plain
                 * square brackets.
                 *
                 * @link https://github.com/squizlabs/PHP_CodeSniffer/issues/1971
                 */
                if ($prevNonEmpty !== 0 || $tokens[$prevNonEmpty]['code'] !== \T_OPEN_TAG) {
                    return false;
                }
            }

            if (\version_compare($phpcsVersion, '2.8.0', '<')) {
                /*
                 * BC: Work around a bug in the tokenizer of PHPCS < 2.8.0 where a `[` would be
                 * tokenized as T_OPEN_SQUARE_BRACKET instead of T_OPEN_SHORT_ARRAY if it was
                 * preceded by a close curly of a control structure.
                 *
                 * If we have square brackets which are not that specific situation, they are just plain
                 * square brackets.
                 *
                 * @link https://github.com/squizlabs/PHP_CodeSniffer/issues/1284
                 */
                if ($tokens[$prevNonEmpty]['code'] !== \T_CLOSE_CURLY_BRACKET
                    || isset($tokens[$prevNonEmpty]['scope_condition']) === false
                ) {
                    return false;
                }
            }
        } else {
            /*
             * Deal with short array brackets which may be incorrectly tokenized plain square brackets.
             */
            if (\version_compare($phpcsVersion, '2.9.0', '<')) {
                $opener = $stackPtr;
                if ($tokens[$stackPtr]['code'] === \T_CLOSE_SHORT_ARRAY) {
                    $opener = $tokens[$stackPtr]['bracket_opener'];
                }

                /*
                 * BC: Work around a bug in the tokenizer of PHPCS < 2.9.0 where array dereferencing
                 * of short array and string literals would be incorrectly tokenized as short array.
                 * I.e. the square brackets in `'PHP'[0]` would be tokenized as short array.
                 *
                 * @link https://github.com/squizlabs/PHP_CodeSniffer/issues/1381
                 */
                $prevNonEmpty = $phpcsFile->findPrevious(Tokens::$emptyTokens, ($opener - 1), null, true);
                if ($tokens[$prevNonEmpty]['code'] === \T_CLOSE_SHORT_ARRAY
                    || $tokens[$prevNonEmpty]['code'] === \T_CONSTANT_ENCAPSED_STRING
                ) {
                    return false;
                }

                /*
                 * BC: Work around a bug in the tokenizer of PHPCS 2.8.0 and 2.8.1 where array dereferencing
                 * of a variable variable would be incorrectly tokenized as short array.
                 *
                 * @link https://github.com/squizlabs/PHP_CodeSniffer/issues/1284
                 */
                if (\version_compare($phpcsVersion, '2.8.0', '>=')
                    && $tokens[$prevNonEmpty]['code'] === \T_CLOSE_CURLY_BRACKET
                ) {
                    $openCurly     = $tokens[$prevNonEmpty]['bracket_opener'];
                    $beforeCurlies = $phpcsFile->findPrevious(Tokens::$emptyTokens, ($openCurly - 1), null, true);
                    if ($tokens[$beforeCurlies]['code'] === \T_DOLLAR) {
                        return false;
                    }
                }
            }
        }

        // In all other circumstances, make sure this isn't a short list instead of a short array.
        return (Lists::isShortList($phpcsFile, $stackPtr) === false);
    }

    /**
     * Find the array opener & closer based on a T_ARRAY or T_OPEN_SHORT_ARRAY token.
     *
     * This method also accepts `T_OPEN_SQUARE_BRACKET` tokens to allow it to be
     * PHPCS cross-version compatible as the short array tokenizing has been plagued by
     * a number of bugs over time, which affects the short array determination.
     *
     * @since 1.0.0
     *
     * @param \PHP_CodeSniffer_File $phpcsFile    The file being scanned.
     * @param int                   $stackPtr     The position of the T_ARRAY or T_OPEN_SHORT_ARRAY
     *                                            token in the stack.
     * @param true|null             $isShortArray Short-circuit the short array check for T_OPEN_SHORT_ARRAY
     *                                            tokens if it isn't necessary.
     *                                            Efficiency tweak for when this has already been established,
     *                                            i.e. when encountering a nested array while walking the
     *                                            tokens in an array.
     *                                            Use with care.
     *
     * @return array|false Array with two keys `opener`, `closer` or false if
     *                     not a (short) array token or if the opener/closer
     *                     could not be determined.
     */
    public static function getOpenClose(File $phpcsFile, $stackPtr, $isShortArray = null)
    {
        $tokens = $phpcsFile->getTokens();

        // Is this one of the tokens this function handles ?
        if (isset($tokens[$stackPtr]) === false
            || isset(Collections::$arrayTokensBC[$tokens[$stackPtr]['code']]) === false
        ) {
            return false;
        }

        switch ($tokens[$stackPtr]['code']) {
            case \T_ARRAY:
                if (isset($tokens[$stackPtr]['parenthesis_opener'])) {
                    $opener = $tokens[$stackPtr]['parenthesis_opener'];

                    if (isset($tokens[$opener]['parenthesis_closer'])) {
                        $closer = $tokens[$opener]['parenthesis_closer'];
                    }
                }
                break;

            case \T_OPEN_SHORT_ARRAY:
            case \T_OPEN_SQUARE_BRACKET:
                if ($isShortArray === true || self::isShortArray($phpcsFile, $stackPtr) === true) {
                    $opener = $stackPtr;
                    $closer = $tokens[$stackPtr]['bracket_closer'];
                }
                break;
        }

        if (isset($opener, $closer)) {
            return [
                'opener' => $opener,
                'closer' => $closer,
            ];
        }

        return false;
    }
}
