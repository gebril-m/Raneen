<h6 class="text-info">Image list</h6>

<style>
    .gallery ul {
        padding: 0;
        margin: 0;
    }
    .gallery ul {
        list-style: none;
    }
    .gallery ul li {
        margin: 5px;
        float: left;
        padding: 3px;
        border: 1px solid #DDD;
        width: 200px;
        height: 200px;
        position: relative;
        overflow: hidden;
    }
    .gallery ul li img {
        width: 192px;
        max-height: 192px;
    }
    .gallery ul li .options {
        position: absolute;
        height: 30px;
        left: 3px;
        bottom: 3px;
        right: 3px;
        padding: 0 10px;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .gallery ul li .options a {
        color: white;
        font-size: 14px;
    }
    .gallery ul li .options i {
        font-size: 20px;
    }
    .gallery ul li .options i.delete {
        color: red;
    }
    .gallery .icon {
        display: none;
    }
    .gallery .selected .icon {
        display: block;
        position: absolute;
        font-size: 50px;
        color: green;
        left: 50%;
        top: 50%;
        transform: translateY(-50%) translateX(-50%);
    }
    .add-new {
        cursor: pointer;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .add-new i {
        font-size: 30px;
    }
</style>

<script id="gallery-item" type="text/html">
    <li>
        <img class="thumbnail" src="" alt="">
        <input type="file" name="images[]" class="file required" required />
        <input type="hidden" name="thumbnail[]" class="thumb-input" value="0" />
        <div class="options">
            <a href="#" class="set-thumbnail"><i class="mdi mdi-checkbox-blank-circle-outline"></i> Thumbnail</a>
            <a href="#" class="delete-gallery"><i class="delete mdi mdi-delete"></i></a>
        </div>
        <i class="icon mdi mdi-check-circle-outline"></i>
    </li>
</script>

<div class="gallery">
    <ul>
{{--                                    @foreach(range(1, 3) as $a)--}}
{{--                                        <li>--}}
{{--                                            <img class="thumbnail" src="https://picsum.photos/{{ rand(190, 220) }}" alt="">--}}
{{--                                            <div class="options">--}}
{{--                                                <a href="#" class="set-thumbnail"><i class="mdi mdi-checkbox-blank-circle-outline"></i> Thumbnail</a>--}}
{{--                                                <a href="#" class="delete-gallery"><i class="delete mdi mdi-delete"></i></a>--}}
{{--                                            </div>--}}
{{--                                            <i class="icon mdi mdi-check-circle-outline"></i>--}}
{{--                                        </li>--}}
{{--                                    @endforeach--}}
        <li class="add-new">
            <a href="#"><i class="mdi mdi-plus-box-outline"></i></a>
        </li>
    </ul>
</div>