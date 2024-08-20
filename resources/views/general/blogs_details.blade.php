@extends("general_base")
@section("title") CarShop - Article: {{ $post->title }} @endsection
@section("content")
@section("style")
<style>
.bg-1{
  background-image: url("{{ Storage::url($post->thumbnail) }}");
}
</style>
@endsection
<!--================================= inner-intro -->
 <section class="inner-intro bg-1 bg-overlay-black-70">
  <div class="container">
     <div class="row text-center intro-title">
           <div class="col-md-6 text-md-start d-inline-block">
            <h3 class="text-white">{{ $post->title }}</h3>
           </div>
           <div class="col-md-6 text-md-end float-end">
            <ul class="page-breadcrumb">
                <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Home</a><i class="fa fa-angle-double-right"></i></li>
                <li><a href="{{ route('blogs') }}">News & Blogs</a><i class="fa fa-angle-double-right"></i></li>
                <li><span>Article</span></li>
            </ul>
           </div>
     </div>
  </div>
</section>
<!--================================= inner-intro -->
<!--================================= article details -->
<section class="blog blog-single page-section-ptb">
  <div class="container">
    <div class="row">
     <div class="col-md-8">
        <div class="blog-entry">
          <div class="blog-entry-image  clearfix">
             <div class="portfolio-item">
               <img class="img-fluid rounded" src="{{ Storage::url($post->thumbnail) }}">
              </div>
            </div>
          <div class="entry-title">
            <a>{{ $post->title }}</a>
          </div>
          <div class="entry-meta d-flex justify-content-end">
            Published at: {{ \Carbon\Carbon::parse($post->publish_date)->format('M d, Y') }}
          </div>
          <div class="entry-content">
            {!! $post->content !!}
          </div>
        </div>

        <div class="mt-5">
            <span class="fw-bold">Tags</span>
            <hr class="mt-0 mb-1">
            @php
                $tags = json_decode($post->tags);
            @endphp
        
            @foreach ($tags as $tag)
                <span class="badge text-muted border">{{ $tag }}</span>
            @endforeach
        </div>        
        
     </div>
<!-- ============================================ -->
      <div class="col-md-4">
        <div class="blog-sidebar">
          <div class="sidebar-widget">
            <h6>Recent Posts</h6>
            @forelse ($recent_posts as $post)
            <div class="recent-post">
             <div class="recent-post-image">
              <a href="{{ route('blogs_details', ['article' => $post->slug]) }}"><img src="{{ Storage::url($post->thumbnail) }}" class="img-fluid rounded"></a>
             </div>
             <div class="recent-post-info">
               <a href="{{ route('blogs_details', ['article' => $post->slug]) }}">{{ Str::limit($post->title, 25) }}</a>
              <span><i class="fa fa-calendar"></i> {{ \Carbon\Carbon::parse($post->publish_date)->format('M d, Y') }}</span>
             </div>
            </div>
            @empty
                <div>no posts found!</div>
            @endforelse
          </div>
        </div>
      </div>
     </div>
   </div>
</section>
<!--================================= article details -->
@endsection