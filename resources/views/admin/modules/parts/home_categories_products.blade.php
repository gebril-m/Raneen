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
            <div class="col-md-4">
                <div class="form-group">
                    <label for="categories[{id}][category]">Category</label>
                    <select class="form-control" name="categories[{id}][category]" id="categories[{id}][category]">
                        @foreach($categories as $id => $category)
                            <option value="{{ $id }}">{{ $category }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="categories[{id}][type]">Product types</label>
                    <select class="form-control" name="categories[{id}][type]" id="categories[{id}][type]">
                        <option value="latest">Latest</option>
                        <option value="top_sales">Top sales</option>
                        <option value="on_sales">On sales</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="categories[{id}][limit]">Products limit</label>
                    <input required class="form-control" type="number" step="1" min="1" max="20" name="categories[{id}][limit]" id="categories[{id}][limit]" value="5">
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
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="categories[{{ $loop->index + 1 }}][category]">Category</label>
                        <select class="form-control" name="categories[{{ $loop->index + 1 }}][category]" id="categories[{{ $loop->index + 1 }}][category]">
                            @foreach($categories as $id => $category)
                                <option value="{{ $id }}" @if($id == $item->category ) selected @endif >{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="categories[{{ $loop->index + 1 }}][type]">Product types</label>
                        <select class="form-control" name="categories[{{ $loop->index + 1 }}][type]" id="categories[{{ $loop->index + 1 }}][type]">
                            <option value="latest" @if($item->type == "latest" ) selected @endif  >Latest</option>
                            <option value="top_sales" @if($item->type == "top_sales" ) selected @endif  >Top sales</option>
                            <option value="on_sales" @if($item->type == "on_sales" ) selected @endif  >On sales</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="categories[{{ $loop->index + 1 }}][limit]">Products limit</label>
                        <input required value="{{ $item->limit }}" class="form-control" type="number" step="1" min="1" max="20" name="categories[{{ $loop->index + 1 }}][limit]" id="categories[{{ $loop->index + 1 }}][limit]">
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
