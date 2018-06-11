<?php

namespace danjam\dotty;

/**
 * Class Dotty
 */
class Dotty
{
    /** @var string */
    private $delimiter = '.';

    /**
     * ArrayDotNotation constructor.
     *
     * @param string|null $delimiter
     */
    public function __construct(string $delimiter = null)
    {
        if (!is_null($delimiter)) {
            $this->setDelimiter($delimiter);
        }
    }

    /**
     * @param $delimiter
     *
     * @return $this
     */
    public function setDelimiter(string $delimiter)
    {
        $this->delimiter = $delimiter;

        return $this;
    }

    /**
     * @param string $key
     * @param array  $array
     *
     * @return mixed
     */
    public function get(string $key, array $array)
    {
        if (strpos($key, $this->delimiter) === false && array_key_exists($key, $array)) {
            return $array[$key];
        }

        $keyParts = explode($this->delimiter, $key);

        foreach ($keyParts as $keyPart) {
            if (!array_key_exists($keyPart, $array)) {
                throw new InvalidArgumentException('Invalid key ' . $key);
            }

            $array = $array[$keyPart];
        }

        return $array;
    }
}
