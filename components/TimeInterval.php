<?php
/**
 * Created by PhpStorm.
 * User: 123
 * Date: 26.03.2018
 * Time: 21:59
 */

namespace humhub\modules\schedule\components;


class TimeInterval
{
    private $data;
    private $timezone;
    private $start;
    private $end;

    public function __construct($serialized, $timezoneName = 'Europe/Moscow')
    {
        $this->parse($serialized);
        $this->timezone = new \DateTimeZone($timezoneName);
        $this->makeStart();
        $this->makeEnd();
    }

    public function contains(\DateTimeInterface $date)
    {
        return $date >= $this->start && $date <= $this->end;
    }

    public function isNow()
    {
        $now = new \DateTimeImmutable('now', $this->timezone);
        return $this->contains($now);
    }

    private function parse($serialized)
    {
        $parts = explode('-', $serialized);

        $this->data = [
            'start' => $this->parsePart($parts[0]),
            'end' => $this->parsePart($parts[1]),
        ];
    }

    private function makeStart()
    {
        $this->start = $this->makeDate($this->data['start']['hour'], $this->data['start']['minute']);
    }

    private function makeEnd()
    {
        $this->end = $this->makeDate($this->data['end']['hour'], $this->data['end']['minute']);
        $this->ensureEndIsAfterStart();
    }

    private function parsePart($part)
    {
        list($hour, $minute) = explode(':', $part);

        return [
            'hour' => $hour,
            'minute' => $minute,
        ];
    }

    private function makeDate($hour, $minute)
    {
        list($day, $month, $year) = explode('.', date('d.m.Y'));

        $date = new \DateTime('now', $this->timezone);

        $date->setDate($year, $month, $day);
        $date->setTime($hour, $minute);

        return $date;
    }

    private function ensureEndIsAfterStart()
    {
        if ($this->start > $this->end)
        {
            $this->end->add(new \DateInterval('P1D'));
        }
    }

    public static function currentWeekDayOfMonth($day, $monday = 'last Monday')
    {
        //date_default_timezone_set('Europe/Moscow');

        $monthes = [
            1 => 'Января', 2 => 'Февраля', 3 => 'Марта', 4 => 'Апреля',
            5 => 'Мая', 6 => 'Июня', 7 => 'Июля', 8 => 'Августа',
            9 => 'Сентября', 10 => 'Октября', 11 => 'Ноября', 12 => 'Декабря'
        ];

        $monday = strtotime($monday);

        return date('d ', strtotime('+' . $day . ' day', $monday)) . $monthes[(date('n'))];
    }
}