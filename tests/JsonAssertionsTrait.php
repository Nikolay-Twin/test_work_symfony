<?php
declare(strict_types=1);
namespace App\Tests;

use function PHPUnit\Framework\assertEquals;

/**
 *
 */
trait JsonAssertionsTrait
{
    /**
     * @param array $expectedJson
     * @param string $message
     * @return void
     */
    protected function assertJsonEquals(array $expectedJson, string $message = ''): void
    {
        $jsonFlags = \JSON_PRETTY_PRINT;

        if (!isset($_SERVER['ESCAPE_JSON']) || true !== $_SERVER['ESCAPE_JSON']) {
            $jsonFlags |= \JSON_UNESCAPED_UNICODE | \JSON_UNESCAPED_SLASHES;
        }

        $content = static::$client->getResponse()->getContent();
        $actualJson = json_encode(json_decode($content, true), $jsonFlags);

        $this->assertEquals(json_encode($expectedJson, JSON_PRETTY_PRINT), trim($actualJson), $message);
    }

    /**
     * @param array|string $expected
     * @param string $message
     * @return void
     */
    protected function assertJsonContains(array|string $expected, string $message = ''): void
    {
        $expected = is_array($expected) ? $expected : [$expected];
        $actualJson = json_decode(static::$client->getResponse()->getContent(), true);
        //dd($actualJson);
        $exists = [];
        foreach ($expected as $value) {
            if ($this->arraySearchRecursive($value, $actualJson)) {
                continue;
            }
            $exists[] = $value;
        }

        if (count($exists)) {
            self::fail($message ?: "Response does not contain test data\n". var_export($exists, true));
            return;
        }

        /** For counting */
        $this->assertTrue(true);
    }

    /**
     * @param string $needle
     * @param mixed $haystack
     * @return bool
     */
    private function arraySearchRecursive(string $needle, mixed $haystack): bool
    {
        if (!is_array($haystack) ) {
            return false;
        }

        foreach ($haystack as $value) {
            if ($value === $needle) {
                return true;
            } elseif (is_array($value)) {
                if (false !== ($this->arraySearchRecursive($needle, $value))) {
                    return true;
                }
            }
        }

        return false;
    }
}
