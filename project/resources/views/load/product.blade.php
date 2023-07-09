<div class="row">
    <div class="col-lg-12">
        <div class="left-area">
            <h4 class="heading">{{ __('Select Product') }}* </h4>
        </div>
    </div>
    <div class="col-lg-12">
        <select name="product[]" required="" class="select2 bold">
            <option value="">Select Product</option>
            @foreach($prod as $p)
            <option value="{{$p->id}}">{{$p->name}}</option>
            @endforeach
        </select>
    </div>
</div>



