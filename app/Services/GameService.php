<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class GameService
{

    /**
     * @param string $uuid
     * @return Builder[]|Collection
     */
    public function getHistory(string $uuid): Collection
    {
        return User::query()->select('link','win','result','number','history.created_at')
            ->join('history','users.id','=', 'history.user_id')
            ->where('link', 'LIKE', $uuid)
            ->orderBy('history.created_at', 'DESC')
            ->limit(3)
            ->get()->transform( function ($item){
                return [
                    'win'       => $item->win,
                    'result'    => $item->result,
                    'date'      => $item->created_at ? $item->created_at->format('Y-m-d H:i:s') : $item->created_at
                ];
            });
    }

    /**
     * @param string $uuid
     * @return array
     */
    public function game(string $uuid): array
    {
        $result = [
          'type'   => 'lose',
          'win'    => 0,
          'number' => 0
        ];

        $number = rand(0,1000);
        if ($number%2 == 0){
           $result['win'] = round($this->calculateWin($number));
           $result['type'] = 'win';
           $result['number'] = $number;
        }

        User::query()->where('link', 'LIKE', $uuid)->first()->history()->create([
                'result' => $result['type'],
                'win'    => $result['win'],
                'number' => $result['number']
            ]
        );

        return $result;
    }

    /**
     * @param int $win
     * @return float
     */
    protected function calculateWin(int $win): float
    {
        switch (true){
            case $win > 900:
                return $this->percentage($win, 70);
            case $win > 600:
                return $this->percentage($win, 50);
            case $win > 300:
                return $this->percentage($win, 30);
            default:
                return $this->percentage($win, 10);
        }
    }

    /**
     * @param int $number
     * @param int $percent
     * @return float
     */
    protected function percentage(int $number, int $percent): float
    {
        return ($number / 100) * $percent;
    }

}
