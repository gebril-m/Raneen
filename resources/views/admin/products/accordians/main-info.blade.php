<h6 class="text-info">Main Info</h6>

                            <div class="form-group">
                                <label for="category_id">Category</label>
                                <select name="category_id" id="category_id" class="form-control" onchange="attributesDependOnCategory(this)">
                                    @foreach($categories as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="brand_id">Brand</label>
                                <select name="brand_id" id="brand_id" class="form-control">
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="manufacturer_id">Manufacturer</label>
                                <select name="manufacturer_id" id="manufacturer_id" class="form-control">
                                    @foreach($manufacturers as $manufacturer)
                                        <option value="{{ $manufacturer->id }}">{{ $manufacturer->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="barcode">Barcode</label>
                                <input type="text" class="form-control" id="barcode" name="barcode">
                            </div>

                            <div class="form-group">
                                <label for="item_id">Item ID</label>
                                <input type="text" class="form-control" id="item_id" name="item_id">
                            </div>
                            <div class="form-group">
                                <label for="axapta_code">Axapta Code</label>
                                <input type="text" class="form-control" id="axapta_code" name="axapta_code">
                            </div>
                            <div class="form-group">
                                <label for="weight">Weight</label>
                                <input type="number" class="form-control" id="weight" name="weight">
                            </div>
                            <div class="form-group">
                                <label for="length">Length</label>
                                <input type="number" class="form-control" id="length" name="length">
                            </div>
                            <div class="form-group">
                                <label for="width">Width</label>
                                <input type="number" class="form-control" id="width" name="width">
                            </div>
                            <div class="form-group">
                                <label for="height">Height</label>
                                <input type="number" class="form-control" id="height" name="height">
                            </div>

                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-info active">
                                    <div class="custom-control custom-checkbox mr-sm-2">
                                        <input type="checkbox" class="custom-control-input" id="checkbox0" name="active">
                                        <label class="custom-control-label" for="checkbox0">Product Active</label>
                                    </div>
                                </label>
                            </div>
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-info active">
                                    <div class="custom-control custom-checkbox mr-sm-2">
                                        <input type="checkbox" class="custom-control-input" id="checkbox0" name="point">
                                        <label class="custom-control-label" for="checkbox0">Point</label>
                                    </div>
                                </label>
                            </div>

                            <hr>

                            @foreach($languages as $locale)
                                <h6 class="text-info">{{$locale->name}} SEO</h6>
                                <section>
                                    <div class="form-group">
                                        <label for="meta_title[{{$locale->locale}}">Meta Title {{$locale->name}}:</label>
                                        <input type="text" name="meta_title[{{$locale->locale}}]" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="meta_keywords[{{$locale->locale}}]">Meta Keywords {{$locale->name}} :</label>
                                        <input type="text" name="meta_keywords[{{$locale->locale}}]" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="meta_keywords[{{$locale->locale}}]">Meta Description {{$locale->name}} :</label>
                                        <textarea name="meta_keywords[{{$locale->locale}}]" rows="4" class="form-control"></textarea>
                                    </div>
                                </section>
                            @endforeach
