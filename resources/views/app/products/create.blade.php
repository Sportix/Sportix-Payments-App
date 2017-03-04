@extends('layouts.app')

@section('content')

<section class="page-heading">
    <div class="container">
        <span class="page-heading-title">Add A New Payment</span>
        <span class="pull-right">
            <a href="/" class="btn btn-success">Payment Pages</a>
        </span>         
    </div>
</section>

<!-- Container -->
<div class="container">
    <div class="row">
        <form>
            <div class="col-lg-8">

                <div class="content-wrapper mt-25">

                    <div class="form-group">
                        <label>Payment Title</label>
                        <input type="text" class="form-control" placeholder="Title">
                    </div>

                    <div class="form-group">
                        <label>Payment Description</label>
                        <textarea type="text" class="form-control" placeholder="Description" rows="5"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Expiry Date</label>
                                <input type="text" class="form-control" placeholder="Payments Expires On">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="checkbox-inline">
                                <input type="checkbox" id="activate" value="1"> Activate Payment
                            </label>
                        </div>
                    </div>

                    <div class="form-group form-buttons">
                        <button type="submit" class="btn btn-primary">Save Payment</button>
                        <button type="submit" class="btn btn-default btn-cancel">Cancel</button>
                    </div>
                </div><!--/content-wrapper-->

            </div><!--/col-lg-7-->

            <div class="col-lg-4">
                <div class="content-wrapper mt-25">
                    <h5 class="side-title">
                        <i class="fa fa-money" aria-hidden="true"></i>
                        Payment Details
                    </h5>

                    <div class="lt-highlight center mb-10">
                        <label class="checkbox-inline">
                            <input type="checkbox" id="notsure" value="1"> Customer decides the amount
                        </label>
                    </div>

                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="form-group">
                                <label class="control-label">Fixed Payment Amount</label>
                                <div class="input-group">
                                    <span class="input-group-addon">$</span>
                                    <input type="text" class="form-control" id="payment-amount" placeholder="0.00">
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="lt-highlight">
                        <label class="radio-inline">
                            <input type="radio" name="frequency" id="frequncy1" value="1" checked="1"> One-Time Payment
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="frequency" id="frequency2" value="2"> Recurring Payments
                        </label>
                    </div>

                    <hr>

                    <!-- Recurring Options -->
                    <div id="recurring-id">
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="uppercase">Recurring Payment Details:</h6>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Billing Interval</label>
                                    <select class="form-control" name="interval">
                                        <option value="">Monthly</option>
                                        <option value="">Yearly</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Num of Cycles</label>
                                    <select class="form-control" name="interval">
                                        <option value="">2</option>
                                        <option value="">3</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div><!--/#recurring-id-->

                    <div class="lt-highlight center">
                        <label class="checkbox-inline">
                            <input type="checkbox" id="charge_customer" value="1"> Customer pays app fee
                        </label>
                    </div>

                </div>
            </div><!--/col-lg-5-->

        </form>
    </div><!--/row-->
</div><!--/container-->

@endsection
