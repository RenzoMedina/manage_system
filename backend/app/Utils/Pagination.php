<?php 

namespace App\Utils;

use Medoo\Medoo;

class Pagination{
    
    /**
     * Summary of paginate
     * @param \Medoo\Medoo $db
     * @param string $table
     * @param int $limit
     * @param int $offset
     * @return array{data: array|null, pagination: array{limit: int, offset: int, total: int|null}}
     */
    public static function paginate(Medoo $db, string $table, int $limit = 10, int $offset = 0){
        $total = $db->count($table);
        $next = $offset + $limit < $total ? $offset + $limit : null;
        $prev = $offset - $limit >= 0 ? $offset - $limit : null;
        $url = "/api/v1/patient";
        $nextUrl = $next ? "{$url}?limit={$limit}&offset={$next}" : null;
        $prevUrl = $prev ? "{$url}?limit={$limit}&offset={$prev}" : null;
        $data = $db->select($table, '*', [
            "LIMIT" => [$offset, $limit]
        ]);

        return [
            "data" => $data,
            "pagination" => [
                "limit" => $limit,
                "offset" => $offset,
                "total" => $total,
                "next" => $next,
                "prev" => $prev,
                "next_url" => $nextUrl,
                "prev_url" => $prevUrl,
                "current_page" => floor($offset / $limit) + 1,
                "last_page" => ceil($total / $limit)

            ]
        ];

    }

    public static function paginateById(Medoo $db, string $table, array $filters = [], $uri, int $limit = 10, int $offset = 0){
        
        $total = $db->count($table, $filters);

        $next = $offset + $limit < $total ? $offset + $limit : null;
        $prev = $offset - $limit >= 0 ? $offset - $limit : null;

        $url = $uri;
        $queryFilters = http_build_query($filters);
        $nextUrl = $next ? "{$url}?limit={$limit}&offset={$next}&{$queryFilters}" : null;
        $prevUrl = $prev ? "{$url}?limit={$limit}&offset={$prev}&{$queryFilters}" : null;

        // 🗂 Traer solo datos filtrados y paginados
        $data = $db->select($table, '*', array_merge($filters, [
            "LIMIT" => [$offset, $limit]
        ]));

        return [
            "data" => $data,
            "pagination" => [
                "limit" => $limit,
                "offset" => $offset,
                "total" => $total,
                "next" => $next,
                "prev" => $prev,
                "next_url" => $nextUrl,
                "prev_url" => $prevUrl,
                "current_page" => floor($offset / $limit) + 1,
                "last_page" => ceil($total / $limit)
            ]
        ];
    }
}