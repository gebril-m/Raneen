<div>

    <style>
        .block{
            border: 1px solid #DDD;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .block h4 {
            color: blue;
            text-decoration: underline;
        }
    </style>

    <hr>

    <div class="row">

        @foreach(['left', 'right'] as $side)
            <div class="col-md-6">
                <div class="block">
                    <h4>Two cards - {{ $side }}</h4>
                    <div class="form-group">
                        <label for="type_{{ $side }}">Type</label>
                        <select name="type_{{ $side }}" id="type_{{ $side }}" data-side="{{ $side }}" class="form-control type" required>
                            <option value="product" @if(isset($content->{'type_' . $side}) && $content->{'type_' . $side} == 'product') selected @endif >Product</option>
                            <option value="category" @if(isset($content->{'type_' . $side}) && $content->{'type_' . $side} == 'category') selected @endif >Category</option>
                        </select>
                    </div>
                    <div class="form-group" data-show="product" data-side="{{ $side }}">
                        <label for="product_{{ $side }}">Product</label>
                        <select name="product_{{ $side }}" id="product_{{ $side }}" class="form-control" required>
                            @foreach(\App\Product::all() as $product)
                                <option value="{{ $product->id }}" @if(isset($content->{'product_' . $side}) && $content->{'product_' . $side} == $product->id) selected @endif >{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" data-show="category" data-side="{{ $side }}" style="display: none">
                        <label for="category_{{ $side }}">Category</label>
                        <select name="category_{{ $side }}" id="category_{{ $side }}" class="form-control" required>
                            @foreach($categories as $id => $category)
                                <option value="{{ $id }}" @if(isset($content->{'category_' . $side}) && $content->{'category_' . $side} == $id) selected @endif >{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="image_{{ $side }}">Image</label>
                        <input type="hidden" name="image_{{ $side }}~" value="{{ isset($content->{'image_' . $side}) && is_string($content->{'image_' . $side}) ? $content->{'image_' . $side} : '' }}">
                        <input type="file"  name="image_{{ $side }}" id="image_{{ $side }}" class="form-control">
                    </div>
                </div>
            </div>
        @endforeach

            <script>
                $('.type').on('change', function () {
                    var side = $(this).data('side');
                    $('[data-show][data-side="'+ side +'"]').slideUp();
                    $('[data-show="'+ $(this).val() +'"][data-side="'+ side +'"]').slideDown();
                });

                $('.type').trigger('change');
            </script>

    </div>

</div>
