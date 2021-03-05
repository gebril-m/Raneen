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
    <div class="block">
        <h4>HOT POPUP</h4>
        <div class="form-group">
            <label for="product">Product</label>
            <select name="product" id="product" class="form-control" required>
                @foreach(\App\Product::all() as $product)
                    <option value="{{ $product->id }}" @if($content->product == $product->id) selected @endif >{{ $product->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="hidden" name="image~" value="{{ isset($content->{'image'}) && is_string($content->{'image'}) ? $content->{'image'} : '' }}">
            <input type="file"  name="image" id="image" class="form-control" required>
        </div>
    </div>

</div>
