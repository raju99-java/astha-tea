

<li>
        <a href="#order" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-hand-holding-usd"></i>{{ __('Orders') }}</a>
        <ul class="collapse list-unstyled" id="order" data-parent="#accordion" >
            
            <li>
                <a href="{{route('delivery-order-pending')}}"> {{ __('Pending Orders') }}</a>
            </li>
            <li>
                <a href="{{route('delivery-order-delivered')}}"> {{ __('Delivered Orders') }}</a>
            </li>
            <li>
                <a href="{{route('delivery-order-completed')}}"> {{ __('Completed Orders') }}</a>
            </li>
              

        </ul>
    </li>
    <li>
        <a href="#customtea-order" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-hand-holding-usd"></i>{{ __('Custom Tea Orders') }}</a>
        <ul class="collapse list-unstyled" id="customtea-order" data-parent="#accordion" >
            
            <li>
                <a href="{{route('delivery-customtea-order-pending')}}"> {{ __('Pending Orders') }}</a>
            </li>
            <li>
                <a href="{{route('delivery-customtea-order-delivered')}}"> {{ __('Delivered Orders') }}</a>
            </li>
            <li>
                <a href="{{route('delivery-customtea-order-completed')}}"> {{ __('Completed Orders') }}</a>
            </li>
            
             

        </ul>
    </li>

    


    

    
        <!-- <li>
            <a href="{{ route('admin-cache-clear') }}" class=" wave-effect"><i class="fas fa-sync"></i>{{ __('Clear Cache') }}</a>
        </li> -->
        