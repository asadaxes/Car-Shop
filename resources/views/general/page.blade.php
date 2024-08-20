@extends("general_base")
@section("title") CarShop - {{ $page->name }} @endsection
@section("content")
<section>
<section class="page-section-pt mb-5">
<div class="container">
<div class="row">
<div class="col-12 text-center">
<div class="section-title mb-3">
    <h4>{{ $page->name }}</h4>
    <div class="separator"></div>
</div>
</div>
<div class="col-12">
<div class="card card-body">
{!! $page->content !!}
</div>
</div>
</div>
</div>
</section>
</section>
@endsection