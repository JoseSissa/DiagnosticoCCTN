<?php

namespace Infinitesimal\Util;

use DateTime;
use InvalidArgumentException;

class Date
{
    /** @var DateTime */
    private $date;

    private function __construct(DateTime $dateTime)
    {
        $this->date = $dateTime;
    }

    public function year(): int
    {
        return intval($this->format('Y'));
    }

    public function month(): int
    {
        return intval($this->format('m'));
    }

    public function day(): int
    {
        return intval($this->format('d'));
    }

    public function timestamp(): int
    {
        return $this->date->getTimestamp();
    }

    public function toIso8601()
    {
        return $this->format('Y-m-d');
    }

    public function format(string $format)
    {
        return $this->date->format($format);
    }

    public function isSameDay(Date $other)
    {
        return $this->toIso8601() === $other->toIso8601();
    }

    public function isAfter(Date $other)
    {
        return $this->toIso8601() > $other->toIso8601();
    }

    public function isBefore(Date $other)
    {
        return $this->toIso8601() < $other->toIso8601();
    }

    public function __toString()
    {
        return $this->toIso8601();
    }

    public static function fromValues(int $year, int $month, int $day): Date
    {
        $year = self::padZeroes($year, 4);
        $month = self::padZeroes($month, 2);
        $day = self::padZeroes($day, 2);
        return new Date(new DateTime("$year-$month-$day"));
    }

    public static function fromIso8601(string $string): Date
    {
        self::validateIso8601($string);
        return new Date(new DateTime($string));
    }

    public static function now(): Date
    {
        return new Date(new DateTime());
    }

    public static function fromDateTime(DateTime $dateTime)
    {
        return new Date($dateTime);
    }

    private static function padZeroes(int $number, int $length): string
    {
        return str_pad($number, $length, '0', STR_PAD_LEFT);
    }

    private static function validateIso8601(string $string)
    {
        if (!preg_match("/(\d{4})\D?(\d{2})\D?(\d{2})/", $string)) throw new InvalidArgumentException("Invalid ISO-8601 date: $string");
    }
}