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
    @php
        $categories = [];
        getCategories(null, $categories);

        $brands = \App\Brand::all();

    @endphp

    <hr>
    @foreach (['first', 'second', 'third'] as $type)
        <div class="block">
            <h4>{{ $type }}</h4>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-control" id="{{ $type }}_category" name="{{ $type }}_category">
                            @foreach($categories as $id => $name)
                                <option value="{{ $id }}" @if(isset($content->{$type . '_category'}) && $id == $content->{$type . '_category'}) selected @endif >{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Brand</label>
                        <select name="{{ $type }}_brand" id="{{ $type }}_brand" class="form-control">
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" @if(isset($content->{$type . '_brand'}) && $brand->id == $content->{$type . '_brand'}) selected @endif >{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <hr>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="{{ $type }}_image">Category image (540x244)</label>
                        <input type="hidden" name="{{ $type }}_image~" value="{{ isset($content->{$type . '_image'}) && is_string($content->{$type . '_image'}) ? $content->{$type . '_image'} : '' }}">
                        <input type="file" class="form-control" name="{{ $type }}_image" id="{{ $type }}_image">
                    </div>
                </div>
            </div>
        </div>
    @endforeach

</div>
