<script type="text/html" id="slide-item">

   <div data-id="{id}">
       <hr>

       <h4 class="text-success">Slide {id} <a href="#" class="text-danger remove-slide">-- REMOVE</a></h4>
       @foreach($languages as $lang)

        @php( $color = sprintf('#%06X', mt_rand(0xFF9999, 0xFFFF00)) )
        @php( $language = '<span style="color:'. $color .'">(' .  $lang->name  . ')</span>' )

           <div class="row">
               <div class="col-md-12">
                   <div class="form-group">
                       <label for="first_title[{{ $lang->locale }}]">Title {!! $language !!}</label>
                       <input class="form-control" type="text" name="slide[{id}][first_title][{{ $lang->locale }}]" id="first_title[{{ $lang->locale }}]" />
                   </div>
               </div>
{{--               <div class="col-md-6">--}}
{{--                   <div class="form-group">--}}
{{--                       <label for="last_title[{{ $lang->locale }}]">Last title {!! $language !!}</label>--}}
{{--                       <input class="form-control" type="text" name="slide[{id}][last_title][{{ $lang->locale }}]" id="last_title[{{ $lang->locale }}]" />--}}
{{--                   </div>--}}
{{--               </div>--}}
           </div>
{{--           <div class="row">--}}
{{--               <div class="col-md-6">--}}
{{--                   <div class="form-group">--}}
{{--                       <label for="sub_title[{{ $lang->locale }}]">Sub title {!! $language !!}</label>--}}
{{--                       <input class="form-control" type="text" name="slide[{id}][sub_title][{{ $lang->locale }}]" id="sub_title[{{ $lang->locale }}]" />--}}
{{--                   </div>--}}
{{--               </div>--}}
{{--               <div class="col-md-6">--}}
{{--                   <div class="form-group">--}}
{{--                       <label for="small_description[{{ $lang->locale }}]">Small description {!! $language !!}</label>--}}
{{--                       <input class="form-control" type="text" name="slide[{id}][small_description][{{ $lang->locale }}]" id="small_description[{{ $lang->locale }}]" />--}}
{{--                   </div>--}}
{{--               </div>--}}
{{--           </div>--}}

{{--       <div class="row">--}}
{{--           <div class="col-md-12">--}}
{{--               <div class="form-group">--}}
{{--                   <label for="button_link">Btn link {!! $language !!}</label>--}}
{{--                   <input type="text" name="slide[{id}][button_link][{{ $lang->locale }}]" class="form-control" />--}}
{{--               </div>--}}
{{--           </div>--}}
{{--       </div>--}}
       @endforeach

       <div class="row">
        <div class="col-md-12">
               <div class="form-group">
                   <label for="image">Image</label>
                   <input class="form-control" type="file" name="slide[{id}][image]" id="image" />
               </div>
           </div>
        <div class="col-md-12">
               <div class="form-group">
                   <label>Product</label>
                   <select class="form-control" name="slide[{id}][product]">
                   @foreach(\App\Product::all() as $product)
                   <option value="{{ $product->id }}">{{ $product->name }}</option>
                   @endforeach
</select>
               </div>
           </div>
       </div>

       {{-- <div class="row">
           <div class="col-md-12">
               <div class="form-group">
                   <label for="bg_image">Bg image</label>
                   <input class="form-control" type="file" name="slide[{id}][bg_image]" id="bg_image" />
               </div>
           </div>
       </div> --}}
   </div>

</script>

@php($content = json_decode($row->content))
<div class="row">

    <div class="col-md-4">
        <div class="form-group">
            <label for="left_top_image">Left Top image (451 x 440)</label>
            <input type="hidden" name="left_top_image~" value="{{ isset($content->left_top_image) && is_string($content->left_top_image) ? $content->left_top_image : '' }}">
            <input class="form-control" type="file" name="left_top_image" id="left_top_image" />
        </div>
    </div>
    @if(isset($content->left_top_image))
        <div class="col-md-2">
            <div class="form-group">
                <img src="{{ route('thumb', ['module', '100', '100', $content->left_top_image]) }}" alt="">
            </div>
        </div>
    @endif
    <div class="col-md-6">
        <div class="form-group">
            <label>Product</label>
            <select class="form-control" name="left_top_product">
                @foreach(\App\Product::all() as $product)
                    <option value="{{ $product->id }}" @if(isset($content->left_top_product) && $content->left_top_product == $product->id) selected @endif >{{ $product->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
{{--    <div class="col-md-6">--}}
{{--        <div class="form-group">--}}
{{--            <label for="left_top_link">Left Top link</label>--}}
{{--            <input class="form-control" type="text" name="left_top_link" id="left_top_link" value="{{ $content->left_top_link ?? '' }}" />--}}
{{--        </div>--}}
{{--    </div>--}}
    <div class="col-md-4">
        <div class="form-group">
            <label for="left_bottom_image">Left Bottom image (430 x 410)</label>
            <input type="hidden" name="left_bottom_image~" value="{{ isset($content->left_bottom_image) && is_string($content->left_bottom_image) ? $content->left_bottom_image : '' }}">
            <input class="form-control" type="file" name="left_bottom_image" id="left_bottom_image" />
        </div>
    </div>
    @if(isset($content->left_bottom_image))
        <div class="col-md-2">
            <div class="form-group">
                <img src="{{ route('thumb', ['module', '100', '100', $content->left_bottom_image]) }}" alt="">
            </div>
        </div>
    @endif
{{--    <div class="col-md-6">--}}
{{--        <div class="form-group">--}}
{{--            <label for="left_bottom_link">Left Bottom link</label>--}}
{{--            <input class="form-control" type="text" name="left_bottom_link" id="left_bottom_link" />--}}
{{--        </div>--}}
{{--    </div>--}}
    <div class="col-md-6">
        <div class="form-group">
            <label>Product</label>
            <select class="form-control" name="left_bottom_product">
                @foreach(\App\Product::all() as $product)
                    <option value="{{ $product->id }}" @if(isset($content->left_bottom_product) && $content->left_bottom_product == $product->id) selected @endif >{{ $product->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

</div>

<div id="slides">


    @if(isset($content->slide))
    @foreach($content->slide as $data)
        @php($index = $loop->index + 1)
        <div data-id="{{ $index }}">
            <hr>

            <h4 class="text-success">Slide {{ $index }} <a href="#" class="text-danger remove-slide">-- REMOVE</a></h4>
            @foreach($languages as $lang)

                @php( $color = sprintf('#%06X', mt_rand(0xFF9999, 0xFFFF00)) )
                @php( $language = '<span style="color:'. $color .'">(' .  $lang->name  . ')</span>' )

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="first_title[{{ $lang->locale }}]">Title {!! $language !!}</label>
                            <input value="{{ $data->first_title->{$lang->locale} ?? '' }}" class="form-control" type="text" name="slide[{{ $index }}][first_title][{{ $lang->locale }}]" id="first_title[{{ $lang->locale }}]" />
                        </div>
                    </div>
{{--                    <div class="col-md-6">--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="last_title[{{ $lang->locale }}]">Last title {!! $language !!}</label>--}}
{{--                            <input value="{{ $data->last_title->{$lang->locale} ?? '' }}" class="form-control" type="text" name="slide[{{ $index }}][last_title][{{ $lang->locale }}]" id="last_title[{{ $lang->locale }}]" />--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
{{--                <div class="row">--}}
{{--                    <div class="col-md-6">--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="sub_title[{{ $lang->locale }}]">Sub title {!! $language !!}</label>--}}
{{--                            <input value="{{ $data->sub_title->{$lang->locale} ?? '' }}" class="form-control" type="text" name="slide[{{ $index }}][sub_title][{{ $lang->locale }}]" id="sub_title[{{ $lang->locale }}]" />--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-md-6">--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="small_description[{{ $lang->locale }}]">Small description {!! $language !!}</label>--}}
{{--                            <input value="{{ $data->small_description->{$lang->locale} ?? '' }}" class="form-control" type="text" name="slide[{{ $index }}][small_description][{{ $lang->locale }}]" id="small_description[{{ $lang->locale }}]" />--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="row">--}}
{{--                    <div class="col-md-12">--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="button_link">Btn link {!! $language !!}</label>--}}
{{--                            <input type="text" name="slide[{{ $index }}][button_link][{{ $lang->locale }}]" class="form-control" value="{{ $data->button_link->{$lang->locale} ?? '' }}" />--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
            @endforeach

            <div class="row">


                <div class="col-md-10">
                    <div class="form-group">
                        <label for="image">Image (430 x 410)</label>
                        <input type="hidden" name="slide[{{ $index }}][image~]" value="{{ isset($data->image) && is_string($data->image) ? $data->image : '' }}">
                        <input class="form-control" type="file" name="slide[{{ $index }}][image]" id="image" />
                    </div>
                </div>
                @if(isset($data->image))
                    <div class="col-md-2">
                        <div class="form-group">
                            <img src="{{ route('thumb', ['module', '100', '100', $data->image]) }}" alt="">
                        </div>
                    </div>
                @endif

                <div class="col-md-12">
                    <div class="form-group">
                        <label>Product</label>
                        <select class="form-control" name="slide[{{ $index }}][product]">
                            @foreach(\App\Product::all() as $product)
                                <option value="{{ $product->id }}" @if(isset($data->product) && $product->id == $data->product) selected @endif >{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>


            {{-- <div class="row">
                <div class="col-md-10">
                    <div class="form-group">
                        <label for="bg_image">Bg image</label>
                        <input type="hidden" name="slide[{{ $index }}][bg_image~]" value="{{ isset($data->bg_image) && is_string($data->bg_image) ? $data->bg_image : '' }}">
                        <input class="form-control" type="file" name="slide[{{ $index }}][bg_image]" id="bg_image" />
                    </div>
                </div>
                @if(isset($data->bg_image))
                <div class="col-md-2">
                    <div class="form-group">
                        <img src="{{ route('thumb', ['module', '100', '100', $data->bg_image]) }}" alt="">
                    </div>
                </div>
                @endif
            </div> --}}
        </div>
    @endforeach
    @endif

</div>

<a href="#" class="btn btn-success" id="add-new-slide">Add new slide</a>

<script>
    $('#add-new-slide').click(function () {
        var html = $('#slide-item').html();
        html = html.replace(/{id}/g, $('[data-id]:last-child').data('id') ? $('[data-id]:last-child').data('id') + 1 : 1);
        $('#slides').append(html);
        return false;
    })
    $(document).on('click', '.remove-slide', function () {
        $(this).parent().parent().remove();
        return false;
    })
</script>
