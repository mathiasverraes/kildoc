<?php declare(strict_types=1);

namespace Verraes\Kildoc;

final class DateFormat
{
    private $format = [];

    public static function ISO8601() : DateFormat
    {
        return (new DateFormat)
            ->year()->dash()->month()->dash()->day()
            ->raw("\T")
            ->hours()->colon()->minutes()->colon()->seconds()
            ->diffToUTCInHours();
    }

    public function __invoke(\DateTimeImmutable $datetime) : string
    {
        $format = implode($this->format, "");
        return $datetime->format($format);
    }

    public function year() : DateFormat{return $this->append("Y");}
    public function month() : DateFormat{return $this->append("m");}
    public function day() : DateFormat{return $this->append("d");}
    public function hours() : DateFormat{return $this->append("H");}
    public function minutes() : DateFormat{return $this->append("i");}
    public function seconds() : DateFormat{return $this->append("s");}
    public function diffToUTCInHours() : DateFormat{return $this->append("O");}
    public function dash() : DateFormat{return $this->append("-");}
    public function colon() : DateFormat{return $this->append(":");}
    public function space(): DateFormat{return $this->append(" ");}
    public function raw(string $string) : DateFormat {return $this->append($string);}

    public function join(DateFormat $other) : DateFormat
    {
        $new = new DateFormat();
        $new->format = array_merge($this->format, $other->format);
        return $new;
    }

    private function append(string $string): DateFormat
    {
        $new = new DateFormat();
        $new->format = $this->format;
        $new->format[] = $string;
        return $new;
    }
}

