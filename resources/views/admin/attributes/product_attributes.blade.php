 <!-- this product attributes -->
                               
                                
                                <div id="first-attribute-container">
                                    <div id="first-attribute">
                                        <div class="recordset">
                                            <div class="row">
                                            <div class="col-2">
                                                <select name="product_attributes[0][]" class="form-control product_attributes" id="attributes2">
                                                    <option value="">--please choose--</option>
                                                    @foreach($attributes as $attribute)
                                                        <option value="{{$attribute->id}}">{{$attribute->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-2">
                                                <input type="text" name="attribute_values[0][]" placeholder="quantity" class="form-control attribute_values">
                                            </div>
                                            <div class="col-2">
                                                <input type="file" name="attribute_pictures[0][]" class="form-control attribute_pictures" multiple="">
                                            </div>
                                            <div class="col-2">
                                                <input type="text" name="attribute_prices[0][]" placeholder="Price" class="form-control attribute_prices">
                                            </div>
                                            <div class="col-2">
                                                <input type="text" name="attribute_codes[0][]" placeholder="Code" class="form-control attribute_codes">
                                            </div>
                                            <div class="col-1">
                                                <a href="#" class="add-new-category btn btn-danger" onclick="deleteAttribute(this)">DELETE</a>
                                            </div>
                                            </div>
                                            <br>
                                            
                                        </div>
                                    </div>
                                </div>