<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ClassworkUser extends Pivot
{
    use HasFactory;

    protected $table = 'classwork_user';

    /**
     *  no updated at column in timestamps
     */
    public function getUpdatedAtColumn()
    {

    }

    public function setUpdatedAt($value)
    {
        // $this->{$this->getUpdatedAtColumn()} = $value;
        return $this;
    }

}