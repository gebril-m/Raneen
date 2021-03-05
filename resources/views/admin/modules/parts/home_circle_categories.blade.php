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
    <script type="text/html" id="item">
        <div class="block" data-id="{id}">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="categories[{id}][category]">Category</label>
                        <select class="form-control" name="categories[{id}][category]" id="categories[{id}][category]">
                            @foreach($categories as $id => $category)
                                <option value="{{ $id }}">{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="categories[{id}][image]">Product image</label>
                        <input class="form-control" type="file" name="categories[{id}][image]" id="categories[{id}][image]">
                    </div>
                </div>
            </div>
        </div>
    </script>

    <div id="blocks">
        @php($content = json_decode($row->content))
        @if($content)
            @foreach($content->categories as $item)
                <div class="block" data-id="{{ $loop->index + 1 }}">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="categories[{{ $loop->index + 1 }}][category]">Category</label>
                                <select class="form-control" name="categories[{{ $loop->index + 1 }}][category]" id="categories[{{ $loop->index + 1 }}][category]">
                                    @foreach($categories as $id => $category)
                                        <option value="{{ $id }}" @if($id == $item->category ) selected @endif >{{ $category }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="categories[{{ $loop->index + 1 }}][image]">Product image</label>
                                <input type="hidden" name="categories[{{ $loop->index + 1 }}][image~]" value="{{ isset($item->image) && is_string($item->image) ? $item->image : '' }}">
                                <input class="form-control" type="file" name="categories[{{ $loop->index + 1 }}][image]" id="categories[{{ $loop->index + 1 }}][image]">
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>


    <div class="row">
        <div class="col-md-12 justify-content-center">
            <a href="#" class="btn btn-success" id="add-new-category">Add new category</a>
        </div>
    </div>

</div>

<script>
    $('#add-new-category').click(function () {
        var html = $('#item').html();
        html = html.replace(/{id}/g, $('[data-id]:last-child').data('id') ? $('[data-id]:last-child').data('id') + 1 : 1);
        $('#blocks').append(html);
        return false;
    })
</script>
