<?php

namespace App\Services;
use App\Http\Responses\ResponseJob;
use App\Models\Job;
use Illuminate\Database\Eloquent\Builder;

class JobService extends BaseService {
   
    public function getJobs($request)
    {
        $query = Job::query()->orderBy('id'); // Ensure ordering for cursor pagination
        $filteredQuery = $this->applyFilters($query, $request->query('filter', ''));
        // Paginate results
        $jobs = $query->cursorPaginate(2, ['id', 'title', 'description', 'company_name', 'salary_min', 'salary_max', 'job_type', 'published_at']);

        return (new ResponseJob())->prepareJobsResponse($jobs);
    
    }

    private function applyFilters(Builder $query, string $filterString): Builder
    {
        if (empty($filterString)) {
            return $query;
        }

        // Parse filter string into structured filters
        $filters = $this->parseFilters($filterString);

        foreach ($filters as $filter) {
            $this->applyFilter($query, $filter);
        }

        return $query;
    }

    private function applyFilter(Builder $query, array $filter): void
    {
        [$field, $operator, $value] = $filter;

        if (in_array($field, ['languages', 'locations'])) {
            // Handle known relationships like languages and locations
            $this->applyRelationFilter($query, $field, 'name', $operator, $value);
        } elseif (str_starts_with($field, 'attribute:')) {
            // Handle attributes as a relationship (EAV pattern)
            $attribute = str_replace('attribute:', '', $field);
            $this->applyAttributeFilter($query, $attribute, $operator, $value);
        } else {
            // Handle normal column filtering
            $this->applyBasicFilter($query, $field, $operator, $value);
        }
    }


    private function applyBasicFilter(Builder $query, string $field, string $operator, mixed $value): void
    {
        match ($operator) {
            '=', '!=', '>', '<', '>=', '<=' => $query->where($field, $operator, $value),
            'LIKE' => $query->where($field, 'LIKE', "%{$value}%"),
            'IN' => $query->whereIn($field, is_array($value) ? $value : explode(',', $value)),
            default => throw new InvalidArgumentException("Invalid operator: $operator"),
        };
    }


    private function applyRelationFilter(Builder $query, string $relation, string $column, string $operator, array|string $value): void
    {
        match ($operator) {
            '=' => $query->whereHas($relation, fn($q) => $q->where($column, $operator, $value)),
            'IN', 'HAS_ANY', 'IS_ANY' => $query->whereHas($relation, fn($q) => $q->whereIn($column, (array) $value)),
            'EXISTS' => $query->whereHas($relation),
            default => throw new InvalidArgumentException("Invalid relation operator: $operator"),
        };
    }


    private function applyAttributeFilter(Builder $query, string $attribute, string $operator, string $value): void
    {
        $query->whereHas('attributes', fn($q) =>
            $q->where('name', $attribute)->where('value', $operator, $value)
        );
    }


    private function parseFilters(string $filterString): array
    {
        $filters = [];
        $tokens = preg_split('/\s+(AND|OR)\s+/i', $filterString, -1, PREG_SPLIT_DELIM_CAPTURE);

        foreach ($tokens as $token) {
            preg_match('/([\w:.]+)\s*(=|!=|>|<|>=|<=|LIKE|IN|HAS_ANY|IS_ANY|EXISTS)\s*\(?([^)]+)?\)?/', trim($token), $match);

            if (!empty($match)) {
                $field = $match[1] ?? null;
                $operator = $match[2] ?? null;
                $value = isset($match[3]) ? trim($match[3]) : null;

                if (!$field || !$operator) {
                    continue;
                }

                // Handle multiple values for IN, HAS_ANY, IS_ANY
                if (in_array($operator, ['IN', 'HAS_ANY', 'IS_ANY'])) {
                    $value = array_map('trim', explode(',', $value));
                }

                $filters[] = [$field, $operator, $value];
            }
        }

        return $filters;
    }




}


?>
