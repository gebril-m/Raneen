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
        <h4>Banner</h4>
        @foreach($languages as $lang)
            <h6>{{ $lang->name }}</h6>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Word A</label>
                        <input type="text" class="form-control" name="worda_{{ $lang->locale }}" value="{{ $content->{'worda_' . $lang->locale} ?? '' }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Word B</label>
                        <input type="text" class="form-control" name="wordb_{{ $lang->locale }}" value="{{ $content->{'wordb_' . $lang->locale} ?? '' }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="link_{{ $lang->locale }}">Link</label>
                        <input type="text" class="form-control" name="link_{{ $lang->locale }}" id="link_{{ $lang->locale }}" value="{{ $content->{'link_' . $lang->locale} ?? '' }}">
                    </div>
                </div>
            </div>
        @endforeach
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="image">Category image (1656x302)</label>
                    <input type="hidden" name="image~" value="{{ isset($content->image) && is_string($content->image) ? $content->image : '' }}">
                    <input type="file" class="form-control" name="image" id="image">
                </div>
            </div>
        </div>
    </div>

</div>
