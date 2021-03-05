<h6 class="text-info">Stock Details</h6>

                            <div class="form-group">
                                <label for="stock">Stock</label>
                                <input type="number" step="1" class="form-control required" id="stock" name="stock" value="{{ old('stock') }}" min="0" required>
                            </div>

                            <div class="form-group">
                                <label for="minimum_stock">Low Stock Notification</label>
                                <input type="number" step="1" class="form-control required" id="minimum_stock" value="{{ old('minimum_stock') }}" min="0" name="minimum_stock" required>
                            </div>

                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="number" class="form-control required" id="price" min="0" value="{{ old('price') }}" name="price" required>
                            </div>

                            <div class="form-group">
                                <label for="reward_points">Reward Points</label>
                                <input type="number" class="form-control required" id="price" min="0" value="{{ old('reward_points') }}" name="reward_points">
                            </div>

                            <div class="form-group">
                                <label for="return_allowed">
                                    <input type="checkbox" id="return_allowed" name="return_allowed">
                                    Allow Item Return
                                </label>
                            </div>

                            <div class="form-group" data-show="return_allowed" style="display: none">
                                <label for="return_duration">Return duration</label>
                                <input type="number" step="1" class="form-control" min="0" value="{{ old('return_duration') }}" id="return_duration" name="return_duration" max="30" onchange="max_value()">
                            </div>

                            <div class="form-group">
                                <label for="on_sale">
                                    <input type="checkbox" id="on_sale" name="on_sale" >
                                    On sale?
                                </label>
                            </div>

                            <div class="form-group" data-show="on_sale" style="display: none">
                                <label for="before_price">Price After Discount</label>
                                <input type="number" class="form-control" min="0" id="before_price" name="before_price" value="{{ old('before_price') }}">
                            </div>

                            <div class="form-group" data-show="on_sale" style="display: none">
                                <label for="sale_ends_at">On Sale ends at</label>
                                <input type="text" class="form-control" id="sale_ends_at" name="sale_ends_at" value="{{ old('sale_ends_at') }}">
                            </div>

                            <div class="form-group">
                                <label for="is_hot">
                                    <input type="checkbox" id="is_hot" name="is_hot">
                                    Is hot product?
                                </label>
                            </div>
                            <div class="form-group" data-show="is_hot" style="display: none">
                                <label for="hot_starts_at">Hot starts at</label>
                                <input type="text" class="form-control" id="hot_starts_at" name="hot_starts_at" value="{{ old('hot_starts_at') }}">
                            </div>

                            <div class="form-group" data-show="is_hot" style="display: none">
                                <label for="hot_ends_at">Hot ends at</label>
                                <input type="text" class="form-control" id="hot_ends_at" name="hot_ends_at" value="{{ old('hot_ends_at') }}">
                            </div>

                            <div class="form-group" data-show="is_hot" style="display: none">
                                <label for="hot_price">Hot Price</label>
                                <input type="number" class="form-control" min="0" id="hot_price" name="hot_price" value="{{ old('hot_price') }}">
                            </div>
                            <div class="form-group">
                                <label for="is_combo">
                                    <input type="checkbox" id="is_combo" name="is_combo">
                                    Is Combo product?
                                </label>
                            </div>



                            <div class="form-group" data-show="is_combo" style="display: none">
                                <label class="mdb-main-label">Combo</label>
                                <select class="mdb-select colorful-select dropdown-primary md-form" multiple searchable="Search here.." name="combo_id[]">
                                  <option value="" disabled selected>select combo</option>
                                  @foreach($combos as $combo)
                                  <option value="{{$combo->id}}">{{ app()->getLocale()=='ar'? $combo->name_ar: $combo->name_en}}</option>
                                  @endforeach
                                </select>
                                </div>

