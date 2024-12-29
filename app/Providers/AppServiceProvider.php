<?php

namespace App\Providers;

use App\Guards\JwtGuard;
use App\Helpers\QueryBuilderHelper;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->registerBlueprintMacros();
        $this->registerQueryBuilderMacros();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Auth::extend('jwt', function (Application $app, string $name, array $config) {
            $userProvider = Auth::createUserProvider($config['provider']);
            if (! $userProvider) {
                throw new \Exception('User provider cannot be null.');
            }

            return new JwtGuard($userProvider, $app->make('request'));
        });
    }

    /**
     * those macros are used in migration files
     * snowflakeIdAndPrimary is used in migration files for creating and auto filling in id field
     * snowflakeId is used in migration files for creating snowflake data type in fields.
     */
    private function registerBlueprintMacros()
    {
        Blueprint::macro('snowflakeId', fn ($column = 'id') => $this->unsignedBigInteger($column));
        Blueprint::macro('snowflakeIdAndPrimary', fn ($column = 'id') => $this->snowflakeId($column)->primary());

        Blueprint::macro('auditColumns', function () {
            $this->snowflakeId('created_by')->nullable();
            $this->snowflakeId('updated_by')->nullable();
            $this->timestamps();

            return $this;
        });
    }

    private function registerQueryBuilderMacros()
    {
        Builder::macro('purifySortingQuery', fn (?array $order, array $sortableFields) => QueryBuilderHelper::purifySortingQuery($this, $order, $sortableFields));

        Builder::macro('search', fn (array $searchableFields, $keyword) => QueryBuilderHelper::search($this, $searchableFields, $keyword));

        Builder::macro('cleanPaginate', fn ($perPage, $page) => QueryBuilderHelper::cleanPaginate($this, $perPage, $page));

        Builder::macro('whereLike', function ($attributes, string $searchTerm) {
            $this->where(function (Builder $query) use ($attributes, $searchTerm) {
                foreach (\Arr::wrap($attributes) as $attribute) {
                    $query->when(
                        str_contains($attribute, '.'),
                        function (Builder $query) use ($attribute, $searchTerm) {
                            [$relationName, $relationAttribute] = explode('.', $attribute);

                            $query->orWhereHas($relationName, function (Builder $query) use ($relationAttribute, $searchTerm) {
                                $query->where($relationAttribute, 'LIKE', "%{$searchTerm}%");
                            });
                        },
                        function (Builder $query) use ($attribute, $searchTerm) {
                            $query->orWhere($attribute, 'LIKE', "%{$searchTerm}%");
                        }
                    );
                }
            });

            return $this;
        });
    }
}
