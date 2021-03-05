@extends('website.layouts.master')

@section('title','Products')

@section('stylesheet')

<style>
    .color.active{
        border:2px solid black;
    }
    #ads {
    margin: 30px 0 30px 0;
   
}

.slider {
  -webkit-appearance: none;
  width: 100%;
  height: 15px;
  background: #d3d3d3;
  outline: none;
  
  -webkit-transition: .2s;
  
}

.slider:hover {
  opacity: 1;
}

.slider::-webkit-slider-thumb {
  -webkit-appearance: none;
  appearance: none;
  width: 25px;
  height: 25px;
  background: #b22827;
  cursor: pointer;
  border-radius: 50%;
}

.slider::-moz-range-thumb {
  width: 25px;
  height: 25px;
  background: #b22827;
  cursor: pointer;
  border-radius: 50%;
}

</style>

@endsection

@section('content')

@include('website.components.header')
@include('website.components.nav-sub')
@include('website.components.breadcrumb')

    <base href="/">

    <app-root></app-root>

    
@endsection

@section('javascript')
<script src="{{ asset('js/runtime.js') }}" type="module"></script>
<script src="{{ asset('js/polyfills.js') }}" type="module"></script>
<script src="{{ asset('js/styles.js') }}" type="module"></script>
<script src="{{ asset('js/vendor.js') }}" type="module"></script>
<script src="{{ asset('js/components-products-products-module.js') }}" type="module"></script>
<script src="{{ asset('js/main.js') }}" type="module"></script>

<script>
  function getUrlVars()
  {
      var vars = [], hash;
      var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
      for(var i = 0; i < hashes.length; i++)
      {
          hash = hashes[i].split('=');
          vars.push(hash[0]);
          vars[hash[0]] = hash[1];
      }
      return vars;
  }

  function getVal(){
    var input = document.getElementsByClassName("myRange");
    var output = document.getElementById("demo");
    output.innerHTML = input.text;
  }

    
    </script>
@endsection