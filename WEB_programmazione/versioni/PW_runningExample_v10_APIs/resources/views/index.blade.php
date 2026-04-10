@extends('layouts.master') <!-- title - active_home - active_MyLibrary - breadcrumb - body -->

@section('title', __('messages.title'))

@section('active_home','active')

@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page">Home</li>
@endsection

@section('body')
<div class="row">
    <div class="col-lg-9 col-sm-12">
        <div class="citazione">
            <p>{{ $content  }}
            </p>
            <blockquote>
                <p>{{ trans('messages.proverb') }} </p>
                <small>[{{ trans('messages.citation') }}]</small>
            </blockquote>
        </div>
    </div>

    <div class="col-lg-3 col-sm-12">
        <div class="imgBiblio">
            <img class="img-thumbnail img-responsive" src="{{ url('/') }}/img/pretty-4-th.jpg">
        </div>
    </div>
</div>
@endsection