<?php

namespace App\Helpers;

use Illuminate\Support\Carbon;

class DateBetween
{
    /**
     * Scope a query to only include records within the specified date range.
     *
     * @author Aung Kyaw Minn
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  array  $dateBetween  Array of two dates to filter the records
     * @param  string  $dateField  The date field to be used for filtering (default is 'created_at')
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function dateBetween($query, $dateBetween, $dateField = 'created_at')
    {
        if (count($dateBetween) > 0) {
            $dateBetween = collect($dateBetween)->filter()->toArray();
            if (count($dateBetween) == 1 || $dateBetween[0] == $dateBetween[1]) {
                return $query->whereDate($dateField, Carbon::create($dateBetween[0])->format('Y-m-d'));
            } else {
                return $query->whereBetween($dateField, [Carbon::create($dateBetween[0])->format('Y-m-d'), Carbon::create($dateBetween[1])->format('Y-m-d')]);
            }
        }

        return $query;
    }
}
