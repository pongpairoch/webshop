<div class="col-lg-12">
    <form id="contactForm" enctype="multipart/form-data" action="{{route('frontend.order_payment')}}" class="p-0" method="POST">
        @csrf
        <input type="hidden" name="method" value="flutterwave">
        <input type="hidden" name="amount" value="{{ $total_amount}}">
        <div class="row">
            <div class="col-lg-12">
                <label for="">{{ __('common.name') }} <span class="text-danger">*</span></label>
                <input class="form-control" type="text" required name="name" placeholder="{{ __('common.name') }}" value="{{$address->name}}">
            </div>
            <div class="col-lg-12">
                <label for="">{{ __('common.email') }}<span class="text-danger">*</span></label>
                <input class="form-control" type="text" required name="email" placeholder="{{ __('common.email') }}" value="{{$address->email}}">
            </div>
            <div class="col-lg-12">
                <label for="">{{ __('common.mobile') }}<span class="text-danger">*</span></label>
                <input class="form-control" type="text" required name="phone" placeholder="{{ __('common.mobile') }}" value="{{@old('phone')}}">
                <input type="hidden" value="Order Payment" name="purpose">
            </div>
        </div>
        <button class="btn_1 d-none" id="flutterwave_btn" type="submit">{{ __('wallet.continue_to_pay') }}</button>
    </form>
</div>