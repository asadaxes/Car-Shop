@extends("admin_base")
@section("title") Parts/Accessories Reviews @endsection
@section("style")
<style>
img.avatar_img{
    width: 40px;
    height: 40px;
    border-radius: 50%;   
}
img.product_list_img{
    width: 80px;
    height: 45px;
}
</style>
@endsection
@section("content")
<div class="row">
<div class="col-12">
<h5 class="text-dark border-bottom">Parts/Accessories Reviews</h5>
</div>
<div class="col-12">
<div class="card card-body p-0">
<table class="table table-bordered text-center">
    <thead class="bg-dark">
        <tr>
            <th>#</th>
            <th>User</th>
            <th>Product</th>
            <th>Review</th>
            <th>Date</th>
            <th>Trash</th>
        </tr>
    </thead>
    <tbody>
        @foreach($reviews as $review)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>
                <a href="{{ route('admin_users_view', ['uid' => $review->user->id]) }}" class="text-dark"><img src="{{ Storage::url($review->user->avatar) }}" class="img-fluid avatar_img">
                {{ $review->user->full_name }}</a>
            </td>
            <td>
                <a href="{{ route('admin_pna_inventory_edit', ['id' => $review->pna->id]) }}" class="d-flex align-items-center text-dark">
                    @if($review->pna->images)
                        <?php $images = json_decode($review->pna->images, true); ?>
                        <img src="{{ Storage::url($images[0]) }}" class="img-fluid rounded product_list_img mr-1">
                    @endif
                    <span>{{ Str::limit($review->pna->title, 50) }}</span>
                </div>
            </td>
            <td>
                <div>
                    @for ($i = 0; $i < 5; $i++)
                        @if ($i < $review->rating)
                            <i class="fas fa-star fa-sm text-warning"></i>
                        @else
                            <i class="fas fa-star fa-sm"></i>
                        @endif
                    @endfor
                </div>
                <small class="text-dark">{{ $review->feedback }}</small>
            </td>
            <td>{{ \Carbon\Carbon::parse($review->issued_at)->format('M d, Y h:i A') }}</td>
            <td>
                <form action="{{ route('admin_pna_reviews_remover') }}" method="POST">
                @csrf
                    <input type="hidden" name="id" value="{{ $review->id }}">
                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>
</div>
</div>
@endsection
@section("script")

@endsection