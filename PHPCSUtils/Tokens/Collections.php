<?php
/**
 * PHPCSUtils, utility functions and classes for PHP_CodeSniffer sniff developers.
 *
 * @package   PHPCSUtils
 * @copyright 2019-2020 PHPCSUtils Contributors
 * @license   https://opensource.org/licenses/LGPL-3.0 LGPL3
 * @link      https://github.com/PHPCSStandards/PHPCSUtils
 */

namespace PHPCSUtils\Tokens;

/**
 * Collections of related tokens as often used and needed for sniffs.
 *
 * These are additional "token groups" to compliment the ones available through the PHPCS
 * native {@see \PHP_CodeSniffer\Util\Tokens} class.
 *
 * @see \PHP_CodeSniffer\Util\Tokens    PHPCS native token groups.
 * @see \PHPCSUtils\BackCompat\BCTokens Backward compatible version of the PHPCS native token groups.
 *
 * @since 1.0.0
 */
class Collections
{

    /**
     * Control structures which can use the alternative control structure syntax.
     *
     * @since 1.0.0-alpha2
     *
     * @var array <int> => <int>
     */
    public static $alternativeControlStructureSyntaxTokens = [
        \T_IF      => \T_IF,
        \T_ELSEIF  => \T_ELSEIF,
        \T_ELSE    => \T_ELSE,
        \T_FOR     => \T_FOR,
        \T_FOREACH => \T_FOREACH,
        \T_SWITCH  => \T_SWITCH,
        \T_WHILE   => \T_WHILE,
        \T_DECLARE => \T_DECLARE,
    ];

    /**
     * Alternative control structure syntax closer keyword tokens.
     *
     * @since 1.0.0-alpha2
     *
     * @var array <int> => <int>
     */
    public static $alternativeControlStructureSyntaxCloserTokens = [
        \T_ENDIF      => \T_ENDIF,
        \T_ENDFOR     => \T_ENDFOR,
        \T_ENDFOREACH => \T_ENDFOREACH,
        \T_ENDWHILE   => \T_ENDWHILE,
        \T_ENDSWITCH  => \T_ENDSWITCH,
        \T_ENDDECLARE => \T_ENDDECLARE,
    ];

    /**
     * Tokens which are used to create arrays.
     *
     * @since 1.0.0
     *
     * @see \PHPCSUtils\Tokens\Collections::$shortArrayTokens Related property containing only tokens used
     *                                                        for short arrays.
     *
     * @var array <int|string> => <int|string>
     */
    public static $arrayTokens = [
        \T_ARRAY             => \T_ARRAY,
        \T_OPEN_SHORT_ARRAY  => \T_OPEN_SHORT_ARRAY,
        \T_CLOSE_SHORT_ARRAY => \T_CLOSE_SHORT_ARRAY,
    ];

    /**
     * Tokens which are used to create arrays.
     *
     * List which is backward-compatible with PHPCS < 3.3.0.
     * Should only be used selectively.
     *
     * @since 1.0.0
     *
     * @see \PHPCSUtils\Tokens\Collections::$shortArrayTokensBC Related property containing only tokens used
     *                                                          for short arrays (cross-version).
     *
     * @var array <int|string> => <int|string>
     */
    public static $arrayTokensBC = [
        \T_ARRAY                => \T_ARRAY,
        \T_OPEN_SHORT_ARRAY     => \T_OPEN_SHORT_ARRAY,
        \T_CLOSE_SHORT_ARRAY    => \T_CLOSE_SHORT_ARRAY,
        \T_OPEN_SQUARE_BRACKET  => \T_OPEN_SQUARE_BRACKET,
        \T_CLOSE_SQUARE_BRACKET => \T_CLOSE_SQUARE_BRACKET,
    ];

    /**
     * Modifier keywords which can be used for a class declaration.
     *
     * @since 1.0.0
     *
     * @var array <int|string> => <int|string>
     */
    public static $classModifierKeywords = [
        \T_FINAL    => \T_FINAL,
        \T_ABSTRACT => \T_ABSTRACT,
    ];

    /**
     * List of tokens which represent "closed" scopes.
     *
     * I.e. anything declared within that scope - except for other closed scopes - is
     * outside of the global namespace.
     *
     * This list doesn't contain `T_NAMESPACE` on purpose as variables declared
     * within a namespace scope are still global and not limited to that namespace.
     *
     * @since 1.0.0
     *
     * @var array <int|string> => <int|string>
     */
    public static $closedScopes = [
        \T_CLASS      => \T_CLASS,
        \T_ANON_CLASS => \T_ANON_CLASS,
        \T_INTERFACE  => \T_INTERFACE,
        \T_TRAIT      => \T_TRAIT,
        \T_FUNCTION   => \T_FUNCTION,
        \T_CLOSURE    => \T_CLOSURE,
    ];

    /**
     * Control structure tokens.
     *
     * @since 1.0.0-alpha2
     *
     * @var array <int> => <int>
     */
    public static $controlStructureTokens = [
        \T_IF      => \T_IF,
        \T_ELSEIF  => \T_ELSEIF,
        \T_ELSE    => \T_ELSE,
        \T_FOR     => \T_FOR,
        \T_FOREACH => \T_FOREACH,
        \T_SWITCH  => \T_SWITCH,
        \T_DO      => \T_DO,
        \T_WHILE   => \T_WHILE,
        \T_DECLARE => \T_DECLARE,
    ];

    /**
     * Tokens which are used to create lists.
     *
     * @since 1.0.0
     *
     * @see \PHPCSUtils\Tokens\Collections::$shortListTokens Related property containing only tokens used
     *                                                       for short lists.
     *
     * @var array <int|string> => <int|string>
     */
    public static $listTokens = [
        \T_LIST              => \T_LIST,
        \T_OPEN_SHORT_ARRAY  => \T_OPEN_SHORT_ARRAY,
        \T_CLOSE_SHORT_ARRAY => \T_CLOSE_SHORT_ARRAY,
    ];

    /**
     * Tokens which are used to create lists.
     *
     * List which is backward-compatible with PHPCS < 3.3.0.
     * Should only be used selectively.
     *
     * @since 1.0.0
     *
     * @see \PHPCSUtils\Tokens\Collections::$shortListTokensBC Related property containing only tokens used
     *                                                         for short lists (cross-version).
     *
     * @var array <int|string> => <int|string>
     */
    public static $listTokensBC = [
        \T_LIST                 => \T_LIST,
        \T_OPEN_SHORT_ARRAY     => \T_OPEN_SHORT_ARRAY,
        \T_CLOSE_SHORT_ARRAY    => \T_CLOSE_SHORT_ARRAY,
        \T_OPEN_SQUARE_BRACKET  => \T_OPEN_SQUARE_BRACKET,
        \T_CLOSE_SQUARE_BRACKET => \T_CLOSE_SQUARE_BRACKET,
    ];

    /**
     * List of tokens which can end a namespace declaration statement.
     *
     * @since 1.0.0
     *
     * @var array <int|string> => <int|string>
     */
    public static $namespaceDeclarationClosers = [
        \T_SEMICOLON          => \T_SEMICOLON,
        \T_OPEN_CURLY_BRACKET => \T_OPEN_CURLY_BRACKET,
        \T_CLOSE_TAG          => \T_CLOSE_TAG,
    ];

    /**
     * OO structures which can use the `extends` keyword.
     *
     * @since 1.0.0
     *
     * @var array <int|string> => <int|string>
     */
    public static $OOCanExtend = [
        \T_CLASS      => \T_CLASS,
        \T_ANON_CLASS => \T_ANON_CLASS,
        \T_INTERFACE  => \T_INTERFACE,
    ];

    /**
     * OO structures which can use the `implements` keyword.
     *
     * @since 1.0.0
     *
     * @var array <int|string> => <int|string>
     */
    public static $OOCanImplement = [
        \T_CLASS      => \T_CLASS,
        \T_ANON_CLASS => \T_ANON_CLASS,
    ];

    /**
     * OO scopes in which constants can be declared.
     *
     * Note: traits can not declare constants.
     *
     * @since 1.0.0
     *
     * @var array <int|string> => <int|string>
     */
    public static $OOConstantScopes = [
        \T_CLASS      => \T_CLASS,
        \T_ANON_CLASS => \T_ANON_CLASS,
        \T_INTERFACE  => \T_INTERFACE,
    ];

    /**
     * OO scopes in which properties can be declared.
     *
     * Note: interfaces can not declare properties.
     *
     * @since 1.0.0
     *
     * @var array <int|string> => <int|string>
     */
    public static $OOPropertyScopes = [
        \T_CLASS      => \T_CLASS,
        \T_ANON_CLASS => \T_ANON_CLASS,
        \T_TRAIT      => \T_TRAIT,
    ];

    /**
     * Token types which can be encountered in a parameter type declaration.
     *
     * @since 1.0.0
     *
     * @var array <int|string> => <int|string>
     */
    public static $parameterTypeTokens = [
        \T_ARRAY_HINT   => \T_ARRAY_HINT, // PHPCS < 3.3.0.
        \T_CALLABLE     => \T_CALLABLE,
        \T_SELF         => \T_SELF,
        \T_PARENT       => \T_PARENT,
        \T_STRING       => \T_STRING,
        \T_NS_SEPARATOR => \T_NS_SEPARATOR,
    ];

    /**
     * Modifier keywords which can be used for a property declaration.
     *
     * @since 1.0.0
     *
     * @var array <int|string> => <int|string>
     */
    public static $propertyModifierKeywords = [
        \T_PUBLIC    => \T_PUBLIC,
        \T_PRIVATE   => \T_PRIVATE,
        \T_PROTECTED => \T_PROTECTED,
        \T_STATIC    => \T_STATIC,
        \T_VAR       => \T_VAR,
    ];

    /**
     * Token types which can be encountered in a property type declaration.
     *
     * @since 1.0.0
     *
     * @var array <int|string> => <int|string>
     */
    public static $propertyTypeTokens = [
        \T_ARRAY_HINT   => \T_ARRAY_HINT, // PHPCS < 3.3.0.
        \T_CALLABLE     => \T_CALLABLE,
        \T_SELF         => \T_SELF,
        \T_PARENT       => \T_PARENT,
        \T_STRING       => \T_STRING,
        \T_NS_SEPARATOR => \T_NS_SEPARATOR,
    ];

    /**
     * Token types which can be encountered in a return type declaration.
     *
     * @since 1.0.0
     *
     * @var array <int|string> => <int|string>
     */
    public static $returnTypeTokens = [
        \T_STRING       => \T_STRING,
        \T_CALLABLE     => \T_CALLABLE,
        \T_SELF         => \T_SELF,
        \T_PARENT       => \T_PARENT,
        \T_NS_SEPARATOR => \T_NS_SEPARATOR,
        \T_RETURN_TYPE  => \T_RETURN_TYPE, // PHPCS 2.4.0 < 3.3.0.
        \T_ARRAY_HINT   => \T_ARRAY_HINT, // PHPCS < 2.8.0 / PHPCS < 3.5.3 for arrow functions.
        \T_ARRAY        => \T_ARRAY, // PHPCS < 3.5.4 for select arrow functions.
    ];

    /**
     * Tokens which are used for short arrays.
     *
     * @since 1.0.0
     *
     * @see \PHPCSUtils\Tokens\Collections::$arrayTokens Related property containing all tokens used for arrays.
     *
     * @var array <int|string> => <int|string>
     */
    public static $shortArrayTokens = [
        \T_OPEN_SHORT_ARRAY  => \T_OPEN_SHORT_ARRAY,
        \T_CLOSE_SHORT_ARRAY => \T_CLOSE_SHORT_ARRAY,
    ];

    /**
     * Tokens which are used for short arrays.
     *
     * List which is backward-compatible with PHPCS < 3.3.0.
     * Should only be used selectively.
     *
     * @since 1.0.0
     *
     * @see \PHPCSUtils\Tokens\Collections::$arrayTokensBC Related property containing all tokens used for arrays
     *                                                    (cross-version).
     *
     * @var array <int|string> => <int|string>
     */
    public static $shortArrayTokensBC = [
        \T_OPEN_SHORT_ARRAY     => \T_OPEN_SHORT_ARRAY,
        \T_CLOSE_SHORT_ARRAY    => \T_CLOSE_SHORT_ARRAY,
        \T_OPEN_SQUARE_BRACKET  => \T_OPEN_SQUARE_BRACKET,
        \T_CLOSE_SQUARE_BRACKET => \T_CLOSE_SQUARE_BRACKET,
    ];

    /**
     * Tokens which are used for short lists.
     *
     * @since 1.0.0
     *
     * @see \PHPCSUtils\Tokens\Collections::$listTokens Related property containing all tokens used for lists.
     *
     * @var array <int|string> => <int|string>
     */
    public static $shortListTokens = [
        \T_OPEN_SHORT_ARRAY  => \T_OPEN_SHORT_ARRAY,
        \T_CLOSE_SHORT_ARRAY => \T_CLOSE_SHORT_ARRAY,
    ];

    /**
     * Tokens which are used for short lists.
     *
     * List which is backward-compatible with PHPCS < 3.3.0.
     * Should only be used selectively.
     *
     * @since 1.0.0
     *
     * @see \PHPCSUtils\Tokens\Collections::$listTokensBC Related property containing all tokens used for lists
     *                                                    (cross-version).
     *
     * @var array <int|string> => <int|string>
     */
    public static $shortListTokensBC = [
        \T_OPEN_SHORT_ARRAY     => \T_OPEN_SHORT_ARRAY,
        \T_CLOSE_SHORT_ARRAY    => \T_CLOSE_SHORT_ARRAY,
        \T_OPEN_SQUARE_BRACKET  => \T_OPEN_SQUARE_BRACKET,
        \T_CLOSE_SQUARE_BRACKET => \T_CLOSE_SQUARE_BRACKET,
    ];

    /**
     * Tokens which can start a - potentially multi-line - text string.
     *
     * @since 1.0.0
     *
     * @var array <int|string> => <int|string>
     */
    public static $textStingStartTokens = [
        \T_START_HEREDOC            => \T_START_HEREDOC,
        \T_START_NOWDOC             => \T_START_NOWDOC,
        \T_CONSTANT_ENCAPSED_STRING => \T_CONSTANT_ENCAPSED_STRING,
        \T_DOUBLE_QUOTED_STRING     => \T_DOUBLE_QUOTED_STRING,
    ];

    /**
     * Tokens which can represent the arrow function keyword.
     *
     * Note: this is a method, not a property as the `T_FN` token may not exist.
     *
     * @since 1.0.0
     *
     * @return array <int|string> => <int|string>
     */
    public static function arrowFunctionTokensBC()
    {
        $tokens = [
            \T_STRING => \T_STRING,
        ];

        if (\defined('T_FN') === true) {
            // PHP 7.4 or PHPCS 3.5.3+.
            $tokens[\T_FN] = \T_FN;
        }

        return $tokens;
    }
}
