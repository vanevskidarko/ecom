@extends('layouts.front')
@section('title', $products->name)


@section('content')

<div class="container">

    <div class="py-3 mb-4 shadow-sm bg-warning border-top">
        <div class="container">
            <h6 class="mb-0">
                <a href="{{url('category')}}">
                    Collections
                </a>
                <a href="{{url('view-category/'.$products->category->name)}}">
                    {{$products->category->name}}
                </a>
                <a href="{{url('category/'.$products->category->name.'/'.$products->name)}}">
                    {{$products->name}}
                </a>
            </h6>
        </div>
    </div>
    <div class="row">

        <div class="col-12 col-sm-8 col-md-6 col-lg-4 product_data">
            <div class="card">
                <img class="card-img" src="{{asset('assets/uploads/products/'.$products->image)}}" alt="Vans">
                <div class="card-body">
                    @if ($products->trending == '1')
                    <label class="bg-danger text-white btn float-right">Trending</label>
                    @endif
                    <h4 class="card-title">{{$products->name}}</h4>
                    
                    <p class="card-text">
                        {{$products->small_description}} </p>
                        @if ($products->qty>0)
                            <label for="" class="badge bg-success">In Stock</label>
                            @else
                            <label for="" class="badge bg-warning">Out of Stock</label>

                        @endif
                   
                    <br>
                    <input type="hidden" name="product_id" class="product_id" value="{{$products->id}}">
                    <div class="input-group text-center mb-3">
                        <label for="qty">Quantity</label>
                        <button class="input-group-text decrement-btn">-</button>
                        <input type="text" name="qty" id="" class="form-control qty text-center" value="1">
                        <button class="input-group-text increment-btn">+</button>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="price text-success">
                            <h5 class="mt-4">${{$products->selling_price}}</h5>
                        </div>
                        @if ($products->qty > 0)
                        <a href="#" class="btn btn-primary ml-1 p-1 mt-3 addToCart"> Add to Cart <i class="fa fa-shopping-cart"></i></a>
                        @endif
                        <a href="#" class="btn btn-success addToWishlist mx-1 p-1 mt-3"> Add to Wishlist <i class="fa fa-heart"></i></a>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
@endsection

@section('scripts')

<script>
    $(document).ready(function(){

        $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

        $('.addToCart').click(function(e){
            e.preventDefault;

            var product_id = $(this).closest('.product_data').find('.product_id').val();
            var product_quantity = $(this).closest('.product_data').find('.qty').val();
            

            $.ajax({
                method: 'POST',
                url:    '/add-to-cart',
                data:   {
                    'product_id'    : product_id,
                    'product_qty'   :product_quantity
                },
                success: (response)=>{
                   swal(response.status)
                }
            })
        })

        $('.increment-btn').click(function(e){
            e.preventDefault();

            var inc_value = $(this).closest('.product_data').find('.qty').val();
            var value = parseInt(inc_value,10);
            value = isNaN(value) ? 0 : value;
            if(value < 10){
                value++;
                $('.qty').val(value);
            }
        }),

        $('.decrement-btn').click(function(e){
            e.preventDefault();

            var dec_value = $(this).closest('.product_data').find('.qty').val();
            var value = parseInt(dec_value,10);
            value = isNaN(value) ? 0 : value;
            if(value > 1){
                value--;
                $('.qty').val(value);
            }
        }),

        $('.addToWishlist').click(function(e){
            e.preventDefault()

            var product_id = $(this).closest('.product_data').find('.product_id').val();

            $.ajax({
                method: 'POST',
                url:    '/add-to-wishlist',
                data:   {
                    'product_id'    : product_id,
                },
                success: (response)=>{
                   swal(response.status)
                }
            })
        })
    })
</script>

@endsection
