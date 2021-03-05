
@if(isset($avg))
	@if($avg >= 1)
	<i class="fa fa-star"></i>
	@else
	<i class="fa fa-star-o"></i>
	@endif
	@if($avg >= 2)
	<i class="fa fa-star"></i>
	@else
	<i class="fa fa-star-o"></i>
	@endif
	@if($avg >= 3)
	<i class="fa fa-star"></i>
	@else
	<i class="fa fa-star-o"></i>
	@endif
	@if($avg >= 4)
	<i class="fa fa-star"></i>
	@else
	<i class="fa fa-star-o"></i>
	@endif
	@if($avg >= 5)
	<i class="fa fa-star"></i>
	@else
	<i class="fa fa-star-o"></i>
	@endif
	  {{intval($avg)}} {{__('Review.Total')}}
@endif
@if(isset($stars))
	@if($stars == 1)
	<i class="fa fa-star"></i>
	@else
	<i class="fa fa-star-o"></i>
	@endif
	@if($stars == 2)
	<i class="fa fa-star"></i>
	@else
	<i class="fa fa-star-o"></i>
	@endif
	@if($stars == 3)
	<i class="fa fa-star"></i>
	@else
	<i class="fa fa-star-o"></i>
	@endif
	@if($stars == 4)
	<i class="fa fa-star"></i>
	@else
	<i class="fa fa-star-o"></i>
	@endif
	@if($stars == 5)
	<i class="fa fa-star"></i>
	@else
	<i class="fa fa-star-o"></i>
	@endif
	  0 {{__('Review.Total')}}
@endif
