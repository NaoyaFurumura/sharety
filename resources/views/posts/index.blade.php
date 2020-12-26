@extends('layouts.app')

@section('content')

@include('item.items')

<div class="d-flex justify-content-center" style="margin-top:20px;">
    {{ $posts->links() }}
</div>

s
@endsection
