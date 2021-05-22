<?php

namespace App\Calendar;

use App\Models\Schedule;
use App\Models\User;
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

    public function make(string $firstDay = '2021-01-01', int $maxDayNumber = 7, string $format = 'Y/m/d')
    {
        $this->sumDays = $maxDayNumber;

        $Carbon = new Carbon($firstDay);

        $week = [];
        $loopCounter = 0;
        for ($i = $this->firstKey; $i <= $this->firstKey + $maxDayNumber; $i++) {
            $loopNum = floor($i / 7);
            $minus = 7 * $loopNum;

            $week[$i - $minus][$loopNum] = [$Carbon->copy()->addDay($loopCounter)->format('Y/m/d') => $Carbon->copy()->addDay($loopCounter)->format($format)];
            $loopCounter++;
        }

        ksort($week);

        $this->days = $week;
    }

    public function render()
    {
        $User = new User();
        $Schedule = new Schedule();
        $activeUserCollections = $User->getScheduleActiveUsers();

        $html = "<table class='table table-bordered'>";
        $dateTextClassName = true === $User->isAdmin(auth()->id()) ? 'text-primary' : '';

        $tableHeader = "<thead><tr>";
        foreach ($this->getWeeks() as $week) {
            $tableHeader .= "<th>$week</th>";
        }
        $tableHeader .= "</tr></thead>";
        $html .= $tableHeader;

        $days = $this->getDays();
        $weekLoopNumber = ceil(($this->firstKey + $this->getSumDays()) / 7);
        $maxDayNumber = $weekLoopNumber * 7;
        $modalItems = "";
        $tableBody = "<tbody>";
        for ($i = 0; $i < $maxDayNumber; $i++) {
            if (0 === $i % 7) $tableBody .= "<tr>";

            $currentChildIndex = floor($i / 7);
            $currentParentIndex = $i - 7 * $currentChildIndex;

            $tableCel = "";
            if (isset($days[$currentParentIndex][$currentChildIndex])) {
                $dateData = $days[$currentParentIndex][$currentChildIndex];
                $dateDataFirstKey = key($dateData);

                $choicesUsers = $Schedule->getUsersIdToArrayByDate($dateData[$dateDataFirstKey]);
                $tableCelBody = "<span class='{$dateTextClassName}'>{$dateData[$dateDataFirstKey]}</span><span class='row pl-3 pr-3 pt-2 js-scheduling-activeUsers-{$i}'>";
                foreach ($choicesUsers as $choiceUser) {
                    $userData = $User->getUserByOne($choiceUser);
                    if (empty($userData)) continue;

                    $tableCelBody .= "<span class='btn btn-success calendar-table-cel-user' data-user-id='{$userData->id}'>{$userData->name}</span>";
                }
                $tableCelBody .= "</span>";

                if (true === $User->isAdmin(auth()->id())) {

                    $tableCelBody .= "<a class='modal-open-link' href='#popup-$i'></a>";

                    /**
                     * モーダル内に選択できるスタッフ一覧を表示し、選択に応じてDBを更新する
                     */
                    $modalItems .= "<div class='remodal' data-remodal-id='popup-$i'><button data-remodal-action='close' class='remodal-close'></button>";
                    $modalItems .= "<div class='row'>";
                    foreach ($activeUserCollections as $user) {
                        $record = $Schedule->getDataByOne($user->id, $dateDataFirstKey);
                        $btnDataActiveName = empty($record) ? 'false' : 'true';
                        $btnColorClassName = empty($record) ? 'btn-success' : 'btn-warning';

                        $modalItems .= "<div class='pl-1 pr-1 mt-3'><div class='btn $btnColorClassName js-scheduling-user' data-user-id='{$user->id}' data-user-name='{$user->name}' data-date='{$dateDataFirstKey}' data-active='{$btnDataActiveName}' data-schedule-id='{$i}'>{$user->name}</div></div>";
                    }
                    $modalItems .= "</div>";
                    $modalItems .= "<button data-remodal-action='cancel' class='remodal-cancel mt-5'>Cancel</button></div>";

                }

                $tableCel = "<div>{$tableCelBody}</div>";
            }

            $tableBody .= "<td class='calendar-table-cel-body'>$tableCel</td>";
        }
        $tableBody .= '</tbody>';
        $html .= $tableBody;

        $html .= "</table>";

        $html .= $modalItems;
        return view('calendar.calendar-template', ['renderCalendarTableHtml' => $html]);
    }
}
