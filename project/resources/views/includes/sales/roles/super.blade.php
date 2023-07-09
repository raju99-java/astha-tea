
    <li>
        <a href="#order" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-hand-holding-usd"></i>{{ __('Orders') }}</a>
        <ul class="collapse list-unstyled" id="order" data-parent="#accordion" >
            
            <li>
                <a href="{{route('sales-order-create')}}"> {{ __('Create New Order') }}</a>
            </li> 
            <li>
                <a href="{{route('sales-order-index')}}"> {{ __('Total Sold Orders') }}</a>
            </li>   
              

        </ul>
    </li>
    <li>
        <a href="#customtea-order" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-hand-holding-usd"></i>{{ __('Custom Tea Orders') }}</a>
        <ul class="collapse list-unstyled" id="customtea-order" data-parent="#accordion" >
            <li>
                <a href="{{route('sales-customtea-order-create')}}"> {{ __('Create New Order') }}</a>
            </li>
            <li>
                <a href="{{route('sales-customtea-order-index')}}"> {{ __('Total Sold Orders') }}</a>
            </li>   
            
             

        </ul>
    </li>
    <li>
        <a href="#menu3" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
            <i class="icofont-user"></i>{{ __('Customers') }}
        </a>
        <ul class="collapse list-unstyled" id="menu3" data-parent="#accordion">
            <li>
                <a href="{{ route('sales-user-create') }}"><span>{{ __('Add New Customer') }}</span></a>
            </li>
            <li>
                <a href="{{ route('sales-user-registered') }}"><span>{{ __('Registered Customers List') }}</span></a>
            </li>
            <li>
                <a href="{{ route('sales-user-index') }}"><span>{{ __('Customers List') }}</span></a>
            </li>
            <li>
                <a href="{{ route('sales-domestic-user') }}"><span>{{ __('Domestic Customers') }}</span></a>
            </li>
          	<li>
                <a href="{{ route('sales-commercial-user') }}"><span>{{ __('Commercial Customers') }}</span></a>
            </li>
            
        </ul>
    </li>

    


    

    
    <!-- <li>
        <a href="{{ route('admin-cache-clear') }}" class=" wave-effect"><i class="fas fa-sync"></i>{{ __('Clear Cache') }}</a>
    </li> -->
        