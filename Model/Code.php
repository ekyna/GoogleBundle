<?php

namespace Ekyna\Bundle\GoogleBundle\Model;

/**
 * Class Code
 * @package Ekyna\Bundle\GoogleBundle\Model
 * @author  Étienne Dauvergne <contact@ekyna.com>
 */
class Code
{
    public const TYPE_CONFIG     = 'config';
    public const TYPE_CONVERSION = 'conversion';

    /**
     * @var string
     */
    private $value;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $host;


    /**
     * Returns the available types.
     *
     * @return string[]
     */
    public static function getTypes(): array
    {
        return [
            self::TYPE_CONFIG     => self::TYPE_CONFIG,
            self::TYPE_CONVERSION => self::TYPE_CONVERSION,
        ];
    }

    /**
     * Returns the value.
     *
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * Sets the value.
     *
     * @param string $value
     *
     * @return Code
     */
    public function setValue(string $value): Code
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Returns the type.
     *
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * Sets the type.
     *
     * @param string $type
     *
     * @return Code
     */
    public function setType(string $type): Code
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Returns the host.
     *
     * @return string|null
     */
    public function getHost(): ?string
    {
        return $this->host;
    }

    /**
     * Sets the host.
     *
     * @param string|null $host
     *
     * @return Code
     */
    public function setHost(string $host = null): Code
    {
        $this->host = $host;

        return $this;
    }
}
