<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ExistsOnConnection implements Rule
{
    protected $connection;
    protected $table;
    protected $column;

    public function __construct($connection, $table, $column = 'id')
    {
        $this->connection = $connection;
        $this->table = $table;
        $this->column = $column;
    }

    public function passes($attribute, $value)
    {
        $exists = DB::connection($this->connection)
            ->table($this->table)
            ->where($this->column, $value)
            ->exists();

        return $exists;
    }

    public function message()
    {
        return 'The selected :attribute is invalid.';
    }
}
