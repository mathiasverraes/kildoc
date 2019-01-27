<?php declare(strict_types=1);

namespace Verraes\Kildoc;

use DateTimeImmutable;
use DateTimeZone;
use PHPUnit\Framework\TestCase;

final class DateFormatTest extends TestCase
{
    private $date;

    protected function setUp()
    {
        $this->date = new DateTimeImmutable("2019-02-07 10:25:55", new DateTimeZone("CET"));
    }

    public function testISO8601()
    {
        $format = (new DateFormat)
                ->year()->dash()->month()->dash()->day()
                ->raw("\T")
                ->hours()->colon()->minutes()->colon()->seconds()
                ->diffToUTCInHours();

        $this->assertSame(
            "2019-02-07T10:25:55+0100",
            $format($this->date)
        );
    }

    public function testUsingAPreset()
    {
        $format = DateFormat::ISO8601();

        $this->assertSame(
            "2019-02-07T10:25:55+0100",
            $format($this->date)
        );
    }

    public function testMerge()
    {
        $dateFormat = (new DateFormat)->year()->dash()->month()->dash()->day();
        $space = (new DateFormat)->space();
        $timeFormat = (new DateFormat)->hours()->colon()->minutes();

        $format = $dateFormat->join($space)->join($timeFormat);

        $this->assertSame(
            "2019-02-07 10:25",
            $format($this->date)
        );
    }

    public function testNumberOfDigitsForYear()
    {
        $format = (new DateFormat)->year();
        $this->assertSame("2019", $format($this->date), "Defaults to 4 digits");
        $format = (new DateFormat)->year(4);
        $this->assertSame("2019", $format($this->date));
        $format = (new DateFormat)->year(2);
        $this->assertSame("19", $format($this->date));
    }

    public function testIllegalNumberOfDigits()
    {
        $this->expectException(\InvalidArgumentException::class);
        $format = (new DateFormat)->year(1);
    }

    public function testLeadingZeros()
    {
        $format = (new DateFormat)->month();
        $this->assertSame("02", $format($this->date), "Defaults to leading zeros");
        $format = (new DateFormat)->month(true);
        $this->assertSame("02", $format($this->date));
        $format = (new DateFormat)->month(false);
        $this->assertSame("2", $format($this->date));
    }

    public function testElegantInterface()
    {
        $this->fail("Not implemented");
        /**
         * This would be a nicer interface:
         * $format
         *     ->year()->twoDigits()
         *     ->month()->noLeadingZeros
         *     ->...
         */

    }

    public function testMissing()
    {
        $this->fail("All kinds of stuff is missing.");
        /*
         * - leading zeros for other things
         * - all the features from http://php.net/manual/en/datetime.createfromformat.php
         * - escaping strings
         * - printf
         */
    }
}

