<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UpdateScheduleController extends Controller
{
    public function update(Request $request)
    {
        if ($request->ajax()) {
            $isActive = $request->get('active');
            $date = $request->get('date');
            $userId = $request->get('userId');

            if (empty($isActive) || empty($date) || empty($userId)) abort(500, 'Error!');

            $actionType = '';

            DB::beginTransaction();
            try {
                if ('false' === $isActive) {
                    Schedule::create([
                        'user_id' => $userId,
                        'date' => $date
                    ]);
                    $actionType = 'insert';
                } else if ('true' === $isActive) {
                    $Schedule = new Schedule();
                    if ($Schedule->exists()) $Schedule->delete();
                    $actionType = 'delete';
                }

                DB::commit();

                return $this->returnStatus(200, $actionType, '更新完了');
            } catch (\Exception $e) {
                DB::rollBack();
            }
        }
    }

    protected function returnStatus(int $responseStatus, string $actionType, string $message = ''): array
    {
        return [
            'status' => $responseStatus,
            'actionType' => $actionType,
            'message' => $message
        ];
    }
}
