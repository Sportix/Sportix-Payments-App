<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The guarded attributes on the model.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Cancel and Delete the order
     */
    public function cancel()
    {
        $this->delete();
    }

    /**
     * Overwrite the array conversion
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'total_amount' => $this->total_amount,
            'fee_amount' => $this->fee_amount,
            'app_fee_percent' => $this->app_fee_percent,
            'charge_app_fee' => $this->charge_app_fee,
            'created_at' => $this->created_at->format('Y-m-d')
        ];
    }
}
