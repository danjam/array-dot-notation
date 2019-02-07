<?php declare(strict_types=1);

namespace danjam\Dotty;

use InvalidArgumentException;

/**
 * Class Dotty
 */
class Dotty
{
    /** @var string */
    private const DELIMITER = '.';

    /** @var string */
    public const ERROR_INVALID_KEY = 'Invalid key, or key not found - ';

    /** @var string */
    public const ERROR_EMPTY_KEY = 'Key cannot be empty';

    /** @var array */
    private $data = [];

    /**
     * Dotty constructor
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param string $key
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     */
    public function get(string $key)
    {
        if ($key === '') {
            throw new InvalidArgumentException(self::ERROR_EMPTY_KEY);
        }

        $keyParts = explode(self::DELIMITER, $key);

        $array = $this->data;

        foreach ($keyParts as $keyPart) {
            if (!isset($array[$keyPart])) {
                throw new InvalidArgumentException(self::ERROR_INVALID_KEY . $key);
            }

            $array = $array[$keyPart];
        }

        return $array;
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return $this->data;
    }
}
