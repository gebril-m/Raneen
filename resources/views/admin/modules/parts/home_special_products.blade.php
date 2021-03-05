<style>
    body.dragging, body.dragging * {
        cursor: move !important;
    }

    .dragged {
        position: absolute;
        opacity: 0.5;
        z-index: 2000;
    }

    ol.vertical {
        margin: 0;
        padding: 0;
        min-height: 10px;
    }

    ol.vertical li.placeholder {
        position: relative;
        margin: 0;
        padding: 0;
        border: none; }

    ol.vertical li.placeholder:before {
        position: absolute;
        content: "";
        width: 0;
        height: 0;
        margin-top: -5px;
        left: -5px;
        top: -4px;
        border: 5px solid transparent;
        border-left-color: red;
        border-right: none; }

    ol.vertical li {
        display: block;
        margin: 5px;
        padding: 5px;
        border: 1px solid #cccccc;
        color: #0088cc;
        background: #eeeeee;
    }
</style>
<ol class='simple_with_drop vertical' id="blocks">
    @if(isset($content->products))
    @foreach($content->products as $product)
            <li>
                <i class='icon-move mdi mdi-cursor-move'></i>
                <select name="products[]" class="">
                    @foreach(\App\Product::all() as $pro)
                        <option value="{{ $pro->id }}" @if($pro->id == $product) selected @endif >{{ $pro->name }}</option>
                    @endforeach
                </select>

                <a href="#" class="delete-item text-danger">[ Delete ]</a>
            </li>
    @endforeach
    @endif
</ol>

<br>
<br>

<div class="row">
    <div class="col-md-12 justify-content-center">
        <a href="#" class="btn btn-success" id="add-new-product">Add new product</a>
    </div>
</div>

    <script type="text/html" id="item">
        <div class="block" data-id="{id}">
            <li>
                <i class='icon-move mdi mdi-cursor-move'></i>
                <select name="products[]" class="">
                    @foreach(\App\Product::all() as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>

                <a href="#" class="delete-item text-danger">[ Delete ]</a>
            </li>
        </div>
    </script>

<script>
    $('#add-new-product').click(function () {
        var html = $('#item').html();
        html = html.replace(/{id}/g, $('[data-id]:last-child').data('id') ? $('[data-id]:last-child').data('id') + 1 : 1);
        $('#blocks').append(html);
        return false;
    })

    $(document).on('click', '.delete-item', function () {
        $(this).parent().remove();
        return false;
    })

</script>

<script src="https://johnny.github.io/jquery-sortable/js/jquery-sortable-min.js"></script>
<script>
    $(function  () {
        $("ol.simple_with_drop").sortable({
            group: 'no-drop',
            handle: 'i.icon-move',
            onDragStart: function ($item, container, _super) {
                // Duplicate items of the no drop area
                if(!container.options.drop)
                    $item.clone().insertAfter($item);
                _super($item, container);
            }
        });
        $("ol.simple_with_no_drop").sortable({
            group: 'no-drop',
            drop: false
        });
        $("ol.simple_with_no_drag").sortable({
            group: 'no-drop',
            drag: false
        });
    });
</script>
