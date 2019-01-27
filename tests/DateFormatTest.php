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
}

