@extends("general_base")
@section("title") CarShop - News & Blogs @endsection
@section("content")
<!--================================= inner-intro -->
 <section class="inner-intro bg-1 bg-overlay-black-70">
  <div class="container">
     <div class="row text-center intro-title">
           <div class="col-md-6 text-md-start d-inline-block">
            <h3 class="text-white">Our News & Blogs</h3>
           </div>
           <div class="col-md-6 text-md-end float-end">
            <ul class="page-breadcrumb">
                <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Home</a><i class="fa fa-angle-double-right"></i></li>
                <li><span>News & Blogs</span></li>
            </ul>
           </div>
     </div>
  </div>
</section>
<!--================================= inner-intro -->
<!--================================= blog -->
<section class="latest-blog border masonry-main page-section-ptb">
 <div class="container">
   <div class="row">
    <div class="col-md-12">
     <div class="masonry columns-3">
       <div class="grid-sizer"></div>
       @forelse ($posts as $post)
        <div class="masonry-item clearfix">
           <div class="blog-2">
            <div class="blog-image">
              <a href="{{ route('blogs_details', ['article' => $post->slug]) }}"><img class="img-fluid" src="{{ Storage::url($post->thumbnail) }}"></a>
              <div class="date">
                <span>{{ date('d', strtotime($post->publish_date)) }} {{ date('M', strtotime($post->publish_date)) }}</span>
              </div>
            </div>
            <div class="blog-content">
              <div class="blog-description text-center">
                 <a href="{{ route('blogs_details', ['article' => $post->slug]) }}">{{ Str::limit($post->title, 25) }}</a>
                 <div class="separator"></div>
                <p>{{ Str::limit($post->content, 100) }}</p>
              </div>
            </div>
          </div>
        </div>
        @empty
            <div>no posts found!</div>
        @endforelse 
      </div>
     </div>
    <div class="col-12 d-flex justify-content-between align-items-baseline py-4">
        <small class="text-muted">Showing {{ $posts->firstItem() }} to {{ $posts->lastItem() }} of {{ $posts->total() }} results</small>
        {{ $posts->links("partial.pagination") }}
    </div>
    </div>
   </div>
</section>
<!--================================= blog -->
@endsection