<?php
/**
 * PHPCSUtils, utility functions and classes for PHP_CodeSniffer sniff developers.
 *
 * @package   PHPCSUtils
 * @copyright 2019-2020 PHPCSUtils Contributors
 * @license   https://opensource.org/licenses/LGPL-3.0 LGPL3
 * @link      https://github.com/PHPCSStandards/PHPCSUtils
 */

namespace PHPCSUtils\Tests\Utils\PassedParameters;

use PHPCSUtils\TestUtils\UtilityMethodTestCase;
use PHPCSUtils\Utils\PassedParameters;

/**
 * Tests the support for the PHP 8.0 named parameters feature in the
 * \PHPCSUtils\Utils\PassedParameters::getParameter() and
 * \PHPCSUtils\Utils\PassedParameters::getParameterFromStack() methods.
 *
 * @covers \PHPCSUtils\Utils\PassedParameters::getParameter
 * @covers \PHPCSUtils\Utils\PassedParameters::getParameterFromStack
 *
 * @group passedparameters
 *
 * @since 1.0.0
 */
class GetParameterFromStackTest extends UtilityMethodTestCase
{

    /**
     * Test retrieving the parameter details from a function call without parameters.
     *
     * @return void
     */
    public function testGetParameterNoParams()
    {
        $stackPtr = $this->getTargetToken('/* testNoParams */', \T_STRING);

        $result = PassedParameters::getParameter(self::$phpcsFile, $stackPtr, 2, 'value');
        $this->assertFalse($result);
    }

    /**
     * Test retrieving the parameter details from a non-function call without passing a valid name
     * to make sure that no error notice is thrown for the missing parameter name.
     *
     * @dataProvider dataGetParameterNonFunctionCallMissingParamName
     *
     * @param string     $testMarker The comment which prefaces the target token in the test file.
     * @param int|string $targetType The type of token to look for.
     *
     * @return void
     */
    public function testGetParameterNonFunctionCallMissingParamName($testMarker, $targetType)
    {
        $stackPtr = $this->getTargetToken($testMarker, $targetType);
        $expected = [
            'start' => ($stackPtr + 5),
            'end'   => ($stackPtr + 6),
            'raw'   => '$var2',
            'clean' => '$var2',
        ];

        $result = PassedParameters::getParameter(self::$phpcsFile, $stackPtr, 2);
        $this->assertSame($expected, $result);
    }

    /**
     * Data provider.
     *
     * @see testGetParameterNonFunctionCallMissingParamName() For the array format.
     *
     * @return array
     */
    public function dataGetParameterNonFunctionCallMissingParamName()
    {
        return [
            'isset' => [
                '/* testIsset */',
                \T_ISSET,
            ],
            'array' => [
                '/* testArray */',
                \T_ARRAY,
            ],
        ];
    }

    /**
     * Test retrieving the parameter details from a function call with only positional parameters
     * without passing a valid name.
     *
     * @return void
     */
    public function testGetParameterFunctionCallPositionalMissingParamName()
    {
        $stackPtr = $this->getTargetToken('/* testAllParamsPositional */', \T_STRING);
        $expected = [
            'start' => ($stackPtr + 5),
            'end'   => ($stackPtr + 6),
            'raw'   => "'value'",
            'clean' => "'value'",
        ];

        $result = PassedParameters::getParameter(self::$phpcsFile, $stackPtr, 2);
        $this->assertSame($expected, $result);
    }

    /**
     * Test retrieving the parameter details from a function call with only named parameters
     * without passing a valid name.
     *
     * @return void
     */
    public function testGetParameterFunctionCallMissingParamName()
    {
        $this->expectPhpcsException(
            'To allow for support for PHP 8 named parameters, the $paramNames parameter must be passed.'
        );

        $stackPtr = $this->getTargetToken('/* testAllParamsNamedStandardOrder */', \T_STRING);

        PassedParameters::getParameter(self::$phpcsFile, $stackPtr, 2);
    }

    /**
     * Test retrieving the details for a specific parameter from a function call or construct.
     *
     * @dataProvider dataGetParameterFromStack
     *
     * @param string      $testMarker       The comment which prefaces the target token in the test file.
     * @param array       $expectedName     The expected result array for the $name parameter.
     * @param array|false $expectedExpires  The expected result array for the $expires_or_options parameter.
     * @param array|false $expectedHttpOnly The expected result array for the $httponly parameter.
     *
     * @return void
     */
    public function testGetParameterFromStack($testMarker, $expectedName, $expectedExpires, $expectedHttpOnly)
    {
        $stackPtr   = $this->getTargetToken($testMarker, \T_STRING);
        $parameters = PassedParameters::getParameters(self::$phpcsFile, $stackPtr);

        /*
         * Test $name parameter. Param name passed as string.
         */
        $expected = false;
        if ($expectedName !== false) {
            // Start/end token position values in the expected array are set as offsets
            // in relation to the target token.
            // Change these to exact positions based on the retrieved stackPtr.
            $expected           = $expectedName;
            $expected['start'] += $stackPtr;
            $expected['end']   += $stackPtr;
            if (isset($expected['name_start'], $expected['name_end']) === true) {
                $expected['name_start'] += $stackPtr;
                $expected['name_end']   += $stackPtr;
            }
            $expected['clean'] = $expected['raw'];
        }

        $result = PassedParameters::getParameterFromStack($parameters, 1, 'name');
        $this->assertSame($expected, $result, 'Expected output for parameter 1 ("name") did not match');

        /*
         * Test $expires_or_options parameter. Param name passed as array with alternative names.
         */
        $expected = false;
        if ($expectedExpires !== false) {
            // Start/end token position values in the expected array are set as offsets
            // in relation to the target token.
            // Change these to exact positions based on the retrieved stackPtr.
            $expected           = $expectedExpires;
            $expected['start'] += $stackPtr;
            $expected['end']   += $stackPtr;
            if (isset($expected['name_start'], $expected['name_end']) === true) {
                $expected['name_start'] += $stackPtr;
                $expected['name_end']   += $stackPtr;
            }
            $expected['clean'] = $expected['raw'];
        }

        $result = PassedParameters::getParameterFromStack($parameters, 3, ['expires_or_options', 'expires', 'options']);
        $this->assertSame($expected, $result, 'Expected output for parameter 3 ("expires_or_options") did not match');

        /*
         * Test $httponly parameter. Param name passed as array.
         */
        $expected = false;
        if ($expectedHttpOnly !== false) {
            // Start/end token position values in the expected array are set as offsets
            // in relation to the target token.
            // Change these to exact positions based on the retrieved stackPtr.
            $expected           = $expectedHttpOnly;
            $expected['start'] += $stackPtr;
            $expected['end']   += $stackPtr;
            if (isset($expected['name_start'], $expected['name_end']) === true) {
                $expected['name_start'] += $stackPtr;
                $expected['name_end']   += $stackPtr;
            }
            $expected['clean'] = $expected['raw'];
        }

        $result = PassedParameters::getParameterFromStack($parameters, 7, ['httponly']);
        $this->assertSame($expected, $result, 'Expected output for parameter 7 ("httponly") did not match');
    }

    /**
     * Data provider.
     *
     * @see testGetParameterFromStack() For the array format.
     *
     * @return array
     */
    public function dataGetParameterFromStack()
    {
        return [
            'all-params-all-positional' => [
                'marker'             => '/* testAllParamsPositional */',
                'name'               => [
                    'start' => 2,
                    'end'   => 3,
                    'raw'   => "'name'",
                ],
                'expires_or_options' => [
                    'start' => 8,
                    'end'   => 25,
                    'raw'   => 'time() + (60 * 60 * 24)',
                ],
                'httponly'           => [
                    'start' => 36,
                    'end'   => 38,
                    'raw'   => 'false',
                ],
            ],
            'all-params-all-named-standard-order' => [
                'marker'             => '/* testAllParamsNamedStandardOrder */',
                'name'               => [
                    'name_start' => 2,
                    'name_end'   => 5,
                    'name'       => 'name',
                    'start'      => 6,
                    'end'        => 7,
                    'raw'        => "'name'",
                ],
                'expires_or_options' => [
                    'name_start' => 16,
                    'name_end'   => 19,
                    'name'       => 'expires_or_options',
                    'start'      => 20,
                    'end'        => 37,
                    'raw'        => 'time() + (60 * 60 * 24)',
                ],
                'httponly'           => [
                    'name_start' => 60,
                    'name_end'   => 63,
                    'name'       => 'httponly',
                    'start'      => 64,
                    'end'        => 66,
                    'raw'        => 'false',
                ],
            ],
            'all-params-all-named-random-order' => [
                'marker'             => '/* testAllParamsNamedNonStandardOrder */',
                'name'               => [
                    'name_start' => 32,
                    'name_end'   => 35,
                    'name'       => 'name',
                    'start'      => 36,
                    'end'        => 37,
                    'raw'        => "'name'",
                ],
                'expires_or_options' => [
                    'name_start' => 2,
                    'name_end'   => 5,
                    'name'       => 'expires_or_options',
                    'start'      => 6,
                    'end'        => 23,
                    'raw'        => 'time() + (60 * 60 * 24)',
                ],
                'httponly'           => [
                    'name_start' => 53,
                    'name_end'   => 56,
                    'name'       => 'httponly',
                    'start'      => 57,
                    'end'        => 58,
                    'raw'        => 'false',
                ],
            ],
            'all-params-mixed-positional-and-named' => [
                'marker'             => '/* testMixedPositionalAndNamedParams */',
                'name'               => [
                    'start'      => 2,
                    'end'        => 4,
                    'raw'        => "'name'",
                ],
                'expires_or_options' => [
                    'start'      => 10,
                    'end'        => 28,
                    'raw'        => 'time() + (60 * 60 * 24)',
                ],
                'httponly'           => [
                    'name_start' => 44,
                    'name_end'   => 47,
                    'name'       => 'httponly',
                    'start'      => 48,
                    'end'        => 49,
                    'raw'        => 'false',
                ],
            ],
            'select-params-mixed-positional-and-named' => [
                'marker'             => '/* testMixedPositionalAndNamedParamsNotAllOptionalSet */',
                'name'               => [
                    'start'      => 2,
                    'end'        => 4,
                    'raw'        => "'name'",
                ],
                'expires_or_options' => [
                    'name_start' => 6,
                    'name_end'   => 9,
                    'name'       => 'expires_or_options',
                    'start'      => 10,
                    'end'        => 27,
                    'raw'        => 'time() + (60 * 60 * 24)',
                ],
                'httponly'           => false,
            ],
            'select-params-mixed-positional-and-named-old-name' => [
                'marker'             => '/* testMixedPositionalAndNamedParamsOldName */',
                'name'               => [
                    'start'      => 2,
                    'end'        => 4,
                    'raw'        => "'name'",
                ],
                'expires_or_options' => [
                    'name_start' => 6,
                    'name_end'   => 9,
                    'name'       => 'expires',
                    'start'      => 10,
                    'end'        => 27,
                    'raw'        => 'time() + (60 * 60 * 24)',
                ],
                'httponly'           => false,
            ],
        ];
    }
}
