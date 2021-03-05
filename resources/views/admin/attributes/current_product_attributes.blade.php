<option value="">--please choose--</option>
@foreach($attributes as $attribute)
    <option value="{{$attribute->id}}">{{$attribute->name}}</option>
@endforeach