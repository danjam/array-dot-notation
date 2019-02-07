<?php declare(strict_types=1);

namespace danjam\Dotty\tests;

use danjam\Dotty\Dotty;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class DottyTest extends TestCase
{
    /** @var string */
    private const TEST_VALUE = 'value';

    /** @var array */
    private const TEST_ARRAY = [
        'foo' => [
            'bar' => [
                'baz' => self::TEST_VALUE
            ],
        ],
    ];

    /**
     * @return array
     */
    public function getDataProvider(): array
    {
        return [
            '1 level'  => ['foo', self::TEST_ARRAY['foo']],
            '2 levels' => ['foo.bar', self::TEST_ARRAY['foo']['bar']],
            '3 levels' => ['foo.bar.baz', self::TEST_VALUE],
        ];
    }

    /**
     * @dataProvider getDataProvider
     *
     * @param string       $key
     * @param array|string $expected
     */
    public function testGet(string $key, $expected): void
    {
        self::assertSame(
            $expected,
            (new Dotty(self::TEST_ARRAY))->get($key)
        );
    }

    /**
     * @return array
     */
    public function getThrowsExceptionOnInvalidKeyDataProvider(): array
    {
        return [
            'Invalid key single' => ['invalid', Dotty::ERROR_INVALID_KEY],
            'Invalid key double' => ['invalid.key', Dotty::ERROR_INVALID_KEY],
            'Empty key'          => ['', Dotty::ERROR_EMPTY_KEY],
        ];
    }

    /**
     * @dataProvider getThrowsExceptionOnInvalidKeyDataProvider
     *
     * @param string $key
     * @param string $message
     */
    public function testGetThrowsExceptionOnInvalidKey(string $key, string $message): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage($message);

        (new Dotty(self::TEST_ARRAY))->get($key);
    }

    public function testAll(): void
    {
        self::assertSame(
            self::TEST_ARRAY,
            (new Dotty(self::TEST_ARRAY))->all()
        );
    }
}
