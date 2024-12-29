<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

class QueryBuilderHelper
{
    /**
     * @param  $sortableFields  array
     * @return mixed
     *               accepted format for $sortableFields are as follows
     *               ['id', 'name']
     *               ['id' => 'id', 'name' => 'name'] => where the key of array is the column from request and value of array is the column name in the table and relations
     *
     * @author naythukhant644@gmail.com
     */
    public static function purifySortingQuery(Builder $builder, $order, array $sortableFields): mixed
    {
        return $builder->when($order, function (Builder $builder) use ($sortableFields, $order) {
            collect($order)->map(function ($column) use ($sortableFields, $builder) {
                if (! Arr::has($column, ['column', 'order'])) {
                    return false;
                }

                if (Arr::isAssoc($sortableFields)) {
                    $allowedFields = collect($sortableFields)->keys()->all();
                    $field = $sortableFields[$column['column']];
                } else {
                    $allowedFields = $sortableFields;
                    $field = $column['column'];
                }

                if (collect($allowedFields)->contains($column['column']) && collect(['desc', 'asc'])->contains($column['order'])) {
                    return $builder->orderBy($field, $column['order']);
                }

                return false;
            });
        });
    }

    /**
     * @param  $searchableFields  array
     * @param  $keyword  string
     * @return mixed
     *               accepted value for $searchableFields is the list of columns that you let the user search from table or relations
     */
    public static function search(Builder $builder, array $searchableFields, ?string $keyword): mixed
    {
        return $builder->when($keyword && $searchableFields, function (Builder $builder) use ($keyword, $searchableFields) {
            $searchableFields = collect($searchableFields);

            $builder->where(function (Builder $builder) use ($keyword, $searchableFields) {
                return $searchableFields->map(function ($field) use ($keyword, $builder, $searchableFields) {
                    $method = $searchableFields->first() === $field ? 'where' : 'orWhere';

                    return $builder->{$method}($field, 'LIKE', "%$keyword%");
                });
            });
        });
    }

    /**
     * @param  int|null  $perPage  integer The number of result for a page
     * @param  int|null  $page  integer Page number for a pagination
     *
     * @author aungkyawminn.me@gmail.com
     */
    public static function cleanPaginate(Builder $builder, $perPage, ?int $page): array
    {

        $perPage = $perPage ?? 5;
        $page = $page ?? 1;
        if ($perPage == 'all') {
            $data = $builder->get();

            return ['data' => $data, 'total' => count($data)];
        }

        $data = $builder->when(
            $page && $perPage,
            fn (Builder $builder) => $builder->paginate(perPage: (int) $perPage, page: $page)->appends(app('request')->query())->toArray(),
            fn (Builder $builder) => $builder->get()
        );

        return Arr::only($data, ['data', 'current_page', 'per_page', 'total']);

    }
}
