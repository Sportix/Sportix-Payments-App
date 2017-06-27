<?php

namespace App;

use App\Billing\Charge;
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

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
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
            'transaction_id' => $this->transaction_id,
            'total_amount' => $this->total_amount,
            'payment_amount' => $this->payment_amount,
            'app_fee_percent' => $this->app_fee_percent,
            'charge_app_fee' => $this->charge_app_fee,
            'created_at' => $this->created_at->format('Y-m-d')
        ];
    }

    public function updateFromStripe(Charge $charge)
    {
        $this->card_last_four = $charge->cardLastFour();
        $this->save();
    }

    public static function findByTransactionId($tid)
    {
        return self::with(['product', 'account'])->where('transaction_id', $tid)->first();
    }
}
