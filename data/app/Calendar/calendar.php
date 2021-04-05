<?php

namespace App\Calendar;

use Carbon\Carbon;
use Yasumi\Yasumi;

class Calendar
{
    protected const WEEKS = [
        'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'
    ];
    protected array $days = [];
    protected int $firstKey = 0;
    protected int $sumDays = 0;

    public function __construct()
    {
        $nowOnWeek = Carbon::now()->format('D');
        $weekKeyIndex = array_search($nowOnWeek, self::WEEKS, true);
        $this->firstKey = $weekKeyIndex;
    }

    /**
     * @param int $year
     * @return array|\Yasumi\Provider\AbstractProvider
     * @throws \ReflectionException
     *
     * $returnArrayとしているが、正確にはarrayではない
     */
    public function getHolidays(int $year)
    {
        $returnArray = [];

        $Yasumi = new Yasumi();
        $holidays = $Yasumi::create('Japan', $year, 'ja_JP');
        if (!empty($holidays)) $returnArray = $holidays;

        return $returnArray;
    }

    public function getWeeks(): array
    {
        return self::WEEKS;
    }

    public function getDays(): array
    {
        return $this->days;
    }

    public function getSumDays(): int
    {
        return $this->sumDays;
    }

    public function make(string $firstDay = '2021-01-01', int $maxDayNumber = 7, string $format = 'YYYY/MM/DD (ddd)')
    {
        $this->sumDays = $maxDayNumber;

        $Carbon = new Carbon($firstDay);

        $week = [];
        for ($i = $this->firstKey; $i < $maxDayNumber; $i++) {
            $loopNum = floor($i / 7);
            $minus = 7 * $loopNum;

            $week[$i - $minus][] = $Carbon->copy()->addDay($i)->isoFormat($format);
        }

        $this->days = $week;
    }

    public function render()
    {
        $html = '<table class="table table-bordered">';

        $tableHeader = '<tr>';
        foreach ($this->getWeeks() as $week) {
            $tableHeader .= "<th>$week</th>";
        }
        $tableHeader .= '</tr>';
        $html .= $tableHeader;

        $days = $this->getDays();
        $tableBody = '';
        for ($i=0; $i<$this->getSumDays(); $i++) {
            if (0 === $i % 7) $tableBody .= '<tr>';

            $currentChildIndex = floor($i / 7);
            $currentParentIndex = $i - 7 * $currentChildIndex;
            /**
             * remodal用のhash href
             */
            $tableBody .= "<td><a href='#popup-$i'>{$days[$currentParentIndex][$currentChildIndex]}</a></td>";
            /**
             * ここにモーダル用の要素が入る予定
             * モーダル内に選択できるスタッフ一覧を表示し、選択に応じてDBを更新する
             */
            $tableBody .= <<<HTML
                <div class='remodal' data-remodal-id='popup-$i'>
                    <button data-remodal-action='close' class='remodal-close'></button>
                    <button data-remodal-action='cancel' class='remodal-cancel'>Cancel</button>
                    <button data-remodal-action='confirm' class='remodal-confirm'>OK</button>
                </div>
HTML;

            if (0 === $i % 6) $tableHeader .= '</tr>';
        }
        $html .= $tableBody;

        $html .= '</table>';
        return view('calendar.calendar-template', ['renderCalendarTableHtml' => $html]);
    }
}
