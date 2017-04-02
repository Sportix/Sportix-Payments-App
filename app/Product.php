<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Exceptions\PastDueDateException;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    /**
     * The guarded attributes on the model.
     *
     * @var array
     */
    protected $guarded = ['id'];
    protected $dates = ['due_date', 'published_at', 'deleted_at'];

    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at');
    }

    public function getFormattedDueDateAttribute()
    {
        return $this->due_date->format('F j, Y');
    }

    public function getTotalDueAttribute()
    {
        return '$' . number_format($this->payment_amount / 100, 2);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'product_id');
    }

    public static function createNewProduct($request)
    {
        return self::create([
            'account_id'            => 1,
            'created_by'		 	=> 1,
            'product_name'          => $request->product_name,
            'payment_amount'        => $request->payment_amount,
            'payment_description'   => $request->payment_description,
            'description'           => $request->description,
            'is_recurring'      	=> $request->is_recurring,
            'recurring_interval'  	=> $request->recurring_interval,
            'recurring_cycles'		=> 0,
            'due_date'              => $request->due_date,
            'is_public'             => $request->is_public,
            'charge_app_fee'        => $request->charge_app_fee,
            'app_fee_percent'       => 4,
            'published_at'          => null,
        ]);
    }

    /**
     * Check if the fund is no longer available
     *
     * @return bool
     */
    public function isPastDue()
    {
        if($this->due_date < Carbon::now()) {
            return true;
        }

        return false;
    }

    public function isPublished() {
        if(is_null($this->published_at)) {
            return false;
        }
        return true;
    }

    public function displayStatus()
    {
        if($this->isPastDue()) {
            return '<span class="label label-error label-outline">Ended</span>';
        }

        if( ! $this->isPublished()) {
            return '<span class="label label-warning label-outline">Unpublished</span>';
        }

        return '<span class="label label-success label-outline">Active</span>';
    }

    /**
     * Verify if app fee is charged to customer
     *
     * @return mixed
     */
    public function chargeCustomerAppFee()
    {
        return $this->charge_app_fee;
    }

    /**
     * Create the order
     *
     * @param $email
     * @return Model
     */
    public function makePayment($email)
    {
        if($this->isPastDue()) {
            throw new PastDueDateException;
        }

        return $this->orders()->create([
            'email' => $email,
            'product_id' => $this->id,
            'product_type' => 'FUND',
            'total_amount' => $this->getTotalAmount(),
            'payment_amount' => $this->payment_amount,
            'app_fee_percent' => $this->app_fee_percent,
            'charge_app_fee' => $this->charge_app_fee
        ]);
    }

    public function getInstallmentOptionsDropdown()
    {

    }

    public function getTotalRevenue()
    {
        return $this->orders()->sum('total_amount');
    }

    /**
     * Return the calculated total amount due to customer
     *
     * @return mixed
     */
    protected function getTotalAmount()
    {
        $amount = $this->payment_amount;

        if($this->chargeCustomerAppFee()) {
            $amount = $this->payment_amount + ($this->payment_amount * $this->app_fee_percent) / 100;
        }

        return intval($amount);
    }
}
