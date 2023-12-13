<?php

namespace App\Filters\V1;

use Illuminate\Http\Request;

class ProductFilter
{

    protected $safeParms = [
        'id' => ['eq'],
        'name' => ['eq', 'like'],
        'price' => ['eq', 'gt', 'lt', 'gte', 'lte'],
    ];

    protected $columnMap = [];

    protected $operatorMap = [
        'eq' => '=',
        'gt' => '>',
        'lt' => '<',
        'gte' => '>=',
        'lte' => '<=',
        'like' => 'like',
    ];

    public function transform(Request $request)
    {
        $eloQuery = [];

        foreach ($this->safeParms as $parm => $operators) {
            $query = $request->query($parm);

            if (!isset($query)) {
                continue;
            }

            $column = $this->columnMap[$parm] ?? $parm;

            foreach ($operators as $operator) {
                if (isset($query[$operator])) {
                    if ($operator === 'like') {
                        $eloQuery[] = [$column, $this->operatorMap[$operator], '%' . $query[$operator] . '%'];
                    } else {
                        $eloQuery[] = [$column, $this->operatorMap[$operator], $query[$operator]];
                    }
                }
            }
        }

        return $eloQuery;
    }
}
