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
        <div class="col-md-6">
            <div class="block">
                <h4>NEW PRODUCT</h4>
                <div class="row">
                    <div class="col-md-4">

                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-info active">
                                <div class="custom-control custom-checkbox mr-sm-2">
                                    <input type="checkbox" class="custom-control-input" id="new_active" name="new_active"
                                           @if(isset($content->new_active) && $content->new_active) checked @endif
                                    >
                                    <label class="custom-control-label" for="new_active">Active</label>
                                </div>
                            </label>
                        </div>

                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="new_limit">Limit</label>
                            <input required type="number" step="1" min="3" class="form-control" name="new_limit" id="new_limit" value="{{ $content->new_limit ?? 12 }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="block">
                <h4>FEATURE PRODUCTS</h4>
                <div class="row">
                    <div class="col-md-4">

                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-info active">
                                <div class="custom-control custom-checkbox mr-sm-2">
                                    <input type="checkbox" class="custom-control-input" id="feature_active" name="feature_active"
                                           @if(isset($content->feature_active) && $content->feature_active) checked @endif
                                    >
                                    <label class="custom-control-label" for="feature_active">Active</label>
                                </div>
                            </label>
                        </div>

                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="feature_limit">Limit</label>
                            <input required type="number" step="1" min="3" class="form-control" name="feature_limit" id="feature_limit" value="{{ $content->feature_limit ?? 12 }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="block">
                <h4>BEST SELLERS</h4>
                <div class="row">
                    <div class="col-md-4">

                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-info active">
                                <div class="custom-control custom-checkbox mr-sm-2">
                                    <input type="checkbox" class="custom-control-input" id="best_active" name="best_active"
                                           @if(isset($content->best_active) && $content->best_active) checked @endif
                                    >
                                    <label class="custom-control-label" for="best_active">Active</label>
                                </div>
                            </label>
                        </div>

                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="best_limit">Limit</label>
                            <input required type="number" step="1" min="3" class="form-control" name="best_limit" id="best_limit" value="{{ $content->best_limit ?? 12 }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">

            <div class="block">
                <h4>ON SALE</h4>
                <div class="row">
                    <div class="col-md-4">

                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-info active">
                                <div class="custom-control custom-checkbox mr-sm-2">
                                    <input type="checkbox" class="custom-control-input" id="sale_active" name="sale_active"
                                           @if(isset($content->sale_active) && $content->sale_active) checked @endif
                                    >
                                    <label class="custom-control-label" for="sale_active">Active</label>
                                </div>
                            </label>
                        </div>

                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="sale_limit">Limit</label>
                            <input required type="number" step="1" min="3" class="form-control" name="sale_limit" id="sale_limit" value="{{ $content->sale_limit ?? 12 }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
