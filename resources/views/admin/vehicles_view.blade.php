@extends("admin_base")
@section("title") Vehicles - {{ $vehicle->model }} @endsection
@section("style")
<style>
.dealer_img{
    width: 80px;
    height: 80px;
    border-radius: 50%;
    margin-right: 13px;
}
img.car_images_preview{
    width: 125px;
}
</style>
@endsection
@section("content")
<div class="card card-body">
<div class="row mb-3">
<div class="col-12">
<h5 class="text-dark border-bottom"><a href="{{ route('admin_vehicles_list') }}" class="text-muted">Vehicles</a>/{{ $vehicle->brand->name }} - {{ $vehicle->model }}</h5>
</div>
</div>
<form action="{{ route('admin_vehicles_view_handler') }}" method="POST" enctype="multipart/form-data">
@csrf
<input type="hidden" name="id" value="{{ $vehicle->id }}">
<input type="hidden" name="dealer_id" value="{{ $vehicle->dealer_id }}">
<div class="row mb-3">
<div class="col-md-4">
<ul class="list-group">
  <a href="{{ route('admin_users_view', ['uid' => $vehicle->dealer->id]) }}" class="list-group-item text-dark bg-light d-flex justify-content-start px-md-3 px-2">
    <img src="{{ Storage::url($vehicle->dealer->avatar) }}" class="dealer_img">
    <div class="d-flex flex-column">
        <small class="text-muted font-weight-bold">Dealer <img src="{{ asset('flags/'.$vehicle->dealer->flag.'.svg') }}" class="img-fluid rounded" width="15" title="{{ $vehicle->dealer->country }}, {{ $vehicle->dealer->city }}"></small>
        <h5 class="mb-0">{{ $vehicle->dealer->full_name }}</h5>
        <small class="my-1"><i class="far fa-envelope"></i> {{ $vehicle->dealer->email }}</small>
        <small><i class="fa-solid fa-mobile-screen-button"></i> {{ $vehicle->dealer->phone }} - <i class="fab fa-whatsapp"></i> {{ $vehicle->dealer->whatsapp_no }}</small>
    </div>
  </a>
</ul>
</div>
</div>
<div class="row mb-2">
<div class="col-lg-3 col-md-6 mb-3">
    <label for="brand" class="text-dark mb-0">Maker/Brand <small class="text-danger">*</small></label>
    <select name="brand_id" class="custom-select" id="brand" required>
        <option selected disabled>-- Select --</option>
        @foreach ($brands as $brand)
            <option value="{{ $brand->id }}" {{ ($brand->name === $vehicle->brand->name) ? "selected" : "" }}>{{ $brand->name }}</option>
        @endforeach
    </select>
</div>
<div class="col-lg-3 col-md-6 mb-3">
    <label for="category" class="text-dark mb-0">Category <small class="text-danger">*</small></label>
    <select name="category_id" class="custom-select" id="category" required>
        <option selected disabled>-- Select --</option>
        @foreach ($vehicle_categories as $category)
            <option value="{{ $category->id }}" {{ ($category->title === $vehicle->category->title) ? "selected" : "" }}>{{ $category->title }}</option>
        @endforeach
    </select>
</div>
<div class="col-lg-3 col-md-6 mb-3">
    <label for="condition" class="text-dark mb-0">Condition <small class="text-danger">*</small></label>
    <select name="condition" class="custom-select" id="condition" required>
        <option selected disabled>-- Select --</option>
        <option value="new" {{ $vehicle->condition === "new" ? 'selected' : '' }}>New</option>
        <option value="used" {{ $vehicle->condition === "used" ? 'selected' : '' }}>Used</option>
        <option value="recondition" {{ $vehicle->condition === "recondition" ? 'selected' : '' }}>Recondition</option>
        <option value="modified" {{ $vehicle->condition === "modified" ? 'selected' : '' }}>Modified</option>
    </select>
</div>
<div class="col-lg-3 col-md-6">
    <label for="status" class="text-dark mb-0">Status <small class="text-danger">*</small></label>
    <select name="status" class="custom-select" id="status" required>
        <option selected disabled>-- Select --</option>
        <option value="active" {{ $vehicle->status === 'active' ? 'selected' : '' }}>Active</option>
        <option value="closed" {{ $vehicle->status === 'closed' ? 'selected' : '' }}>Closed</option>
        <option value="sold" {{ $vehicle->status === 'sold' ? 'selected' : '' }}>Sold</option>
    </select>
</div>
</div>
<hr class="text-muted mt-0">
<div class="row mb-3">
<div class="col-md-8 mb-3">
    <label for="model" class="text-dark mb-0">Vehicle Model <small class="text-danger">*</small></label>
    <input type="text" name="model" class="form-control" id="model" value="{{ $vehicle->model }}" required>
</div>
<div class="col-md-4 mb-3">
    <label for="price" class="text-dark mb-0">Price <small class="text-danger">*</small></label>
    <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text">BDT</span>
        </div>
        <input type="tel" name="price" class="form-control border-left-0" id="price" value="{{ $vehicle->price }}" required>
    </div>
</div>
<div class="col-12">
    <label for="description" class="text-dark mb-0">Write a brief about your car <small class="text-danger">*</small></label>
    <textarea name="description" class="form-control" id="description" rows="3">{{ $vehicle->description }}</textarea>
</div>
</div>
<div class="row mb-2">
<div class="col-md-8 mb-3">
    <label for="model" class="mb-0">Add car features & options <small class="text-danger">*</small></label>
    <div class="input-group">
        <input type="text" class="form-control key_input" placeholder="key">
        <input type="text" class="form-control value_input border-right-0" placeholder="value">
        <div class="input-group-prepend">
            <span class="input-group-text cursor_pointer add_option"><i class="fas fa-plus"></i></span>
        </div>
    </div>
    <input type="hidden" name="features_options" value="{{ $vehicle->details }}">
    <div class="features_options_container mt-2">
        @php
            $details = json_decode($vehicle->details, true);
        @endphp
        @if(!empty($details))
            @foreach($details as $detail)
                @foreach($detail as $key => $value)
                    <span class="badge rounded-pill bg-secondary mx-1">{{ $key }}: {{ $value }} <i class="fas fa-times cursor_pointer remove_option"></i></span>
                @endforeach
            @endforeach
        @else
            <p>No details available</p>
        @endif
    </div>
</div>
<div class="col-md-4">
    <label for="model" class="mb-0">Extra features <small class="text-danger">*</small></label>
    <div class="input-group">
        <input type="text" class="form-control feature_input border-right-0">
        <div class="input-group-prepend">
            <span class="input-group-text cursor_pointer add_feature"><i class="fas fa-plus"></i></span>
        </div>
    </div>
    <input type="hidden" name="features" value="{{ $vehicle->features }}">
    <div class="badge_container mt-2">
        @php
            $features = json_decode($vehicle->features, true);
        @endphp
        @if(!empty($features))
            @foreach($features as $feature)
                <span class="badge rounded-pill bg-secondary mx-1">{{ $feature }} <i class="fas fa-times cursor_pointer remove_feature"></i></span>
            @endforeach
        @else
            <p>No features available</p>
        @endif
    </div>
</div>
</div>
<hr class="text-muted mt-0">
<div class="row mb-2">
    <div class="col-lg-3 col-md-6 mb-3">
        <label for="mileage" class="mb-0">Mileage <small class="text-danger">*</small></label>
        <input type="number" name="mileage" class="form-control" id="mileage" value="{{ $vehicle->mileage }}" required>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <label for="fuel_type" class="mb-0">Fuel type <small class="text-danger">*</small></label>
        <input type="text" name="fuel_type" class="form-control" id="fuel_type" placeholder="Diesel, LPG, CNG etc..." value="{{ $vehicle->fuel_type }}" required>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <label for="engine" class="mb-0">Engine <small class="text-danger">*</small></label>
        <input type="text" name="engine" class="form-control" id="engine" value="{{ $vehicle->engine }}" required>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <label for="drivetrain" class="mb-0">Drivetrain <small class="text-danger">*</small></label>
        <input type="text" name="drivetrain" class="form-control" id="drivetrain" value="{{ $vehicle->drivetrain }}" required>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <label for="exterior_color" class="mb-0">Exterior color <small class="text-danger">*</small></label>
        <input type="text" name="exterior_color" class="form-control" id="exterior_color" value="{{ $vehicle->exterior_color }}" required>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <label for="interior_color" class="mb-0">Interior color <small class="text-danger">*</small></label>
        <input type="text" name="interior_color" class="form-control" id="interior_color" value="{{ $vehicle->interior_color }}" required>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <label for="model_year" class="mb-0">Model year <small class="text-danger">*</small></label>
        <input type="tel" name="model_year" class="form-control" id="model_year" value="{{ $vehicle->model_year }}" required>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <label for="registration_year" class="mb-0">Registration year <small class="text-muted">(if have)</small></label>
        <input type="tel" name="registration_year" class="form-control" id="registration_year" placeholder="optional" value="{{ $vehicle->registration_year }}">
    </div>
</div>
<hr class="text-muted mt-0">
<div class="row mb-3">
    <div class="col-md-6 d-flex flex-column justify-content-center align-items-center">
        <label for="images">Select your car photos</label>
        <input type="file" id="images" accept=".png, .jpg, .jpeg" multiple>
    </div>
    <div class="col-md-6">
        <input type="hidden" name="images" class="images-data" value="{{ $vehicle->images }}">
        <ul class="list-group image-previews">
            @php
                $images = json_decode($vehicle->images, true);
            @endphp
            @foreach($images as $image)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>{{ $loop->iteration }}.</span>
                    <img src="{{ Storage::url($image) }}" class="car_images_preview rounded">
                    <i class="fas fa-trash-alt fa-lg text-danger cursor_pointer remove-image"></i>
                </li>
            @endforeach
        </ul>
    </div>
</div>
<hr class="text-muted mt-0">
<div class="col-12 text-center">
    <button type="submit" class="btn btn-primary"><i class="fas fa-car"></i> Save Changes</button>
</div>
</form>
</div>
@endsection
@section("script")
<script>
$(document).ready(function(){
    function addFeature() {
        let featureValue = $('.feature_input').val().trim();
        if (featureValue !== "") {
            let featuresArray = JSON.parse($('input[name="features"]').val());
            featuresArray.push(featureValue);
            $('input[name="features"]').val(JSON.stringify(featuresArray));
            $('.badge_container').append('<span class="badge rounded-pill bg-secondary mx-1">' + featureValue + ' <i class="fas fa-times cursor_pointer remove_feature"></i></span>');
            $('.feature_input').val("");
            $('.feature_input').focus();
        }
    }
    $('.add_feature').click(addFeature);
    $('.feature_input').keypress(function(event) {
        if (event.which == 13) {
            addFeature();
        }
    })
    $(document).on('click', '.remove_feature', function() {
        let featureToRemove = $(this).parent().text().trim();
        let featuresArray = JSON.parse($('input[name="features"]').val());
        let index = featuresArray.indexOf(featureToRemove);
        if (index !== -1) {
            featuresArray.splice(index, 1);
            $('input[name="features"]').val(JSON.stringify(featuresArray));
        }
        $(this).parent().remove();
    });

    function addOption() {
        let key = $('.key_input').val().trim();
        let value = $('.value_input').val().trim();
        if (key !== "" && value !== "") {
            let optionsArray = JSON.parse($('input[name="features_options"]').val() || "[]");
            optionsArray.push({ [key]: value });
            $('input[name="features_options"]').val(JSON.stringify(optionsArray));
            $('.features_options_container').append('<span class="badge bg-secondary mx-1">' + key + ': ' + value + ' <i class="fas fa-times cursor_pointer remove_option"></i></span>');
            $('.key_input').val("");
            $('.value_input').val("");
            $('.key_input').focus();
        }
    }
    $('.add_option').click(addOption);
    $('.value_input').keypress(function(event) {
        if (event.which == 13) {
            addOption();
        }
    });
    $(document).on('click', '.remove_option', function() {
        let badgeIndex = $(this).parent().index();
        let optionsArray = JSON.parse($('input[name="features_options"]').val());
        if (badgeIndex !== -1) {
            optionsArray.splice(badgeIndex, 1);
            $('input[name="features_options"]').val(JSON.stringify(optionsArray));
        }
        $(this).parent().remove();
    });

    let imageDataArray = @json(json_decode($vehicle->images, true));
    $('#images').change(async function() {
        let existingImagesCount = $('.image-previews li').length;
        for (let index = 0; index < this.files.length; index++) {
            const file = this.files[index];
            const reader = new FileReader();
            await new Promise((resolve, reject) => {
                reader.onload = function(event) {
                    $('.image-previews').append('<li class="list-group-item d-flex justify-content-between align-items-center">' +
                        '<span>'+ (existingImagesCount + index + 1) +'.</span>' +
                        '<img src="' + event.target.result + '" class="car_images_preview rounded">' +
                        '<i class="fas fa-trash-alt fa-lg text-danger cursor_pointer remove-image"></i>' +
                        '</li>');
                    imageDataArray.push(event.target.result);
                    $('.images-data').val(JSON.stringify(imageDataArray));
                    resolve();
                };
                reader.onerror = function(error) {
                    reject(error);
                };
                reader.readAsDataURL(file);
            });
        }
    });
    $(document).on('click', '.remove-image', function() {
        let imageIndex = $(this).parent().index();
        imageDataArray.splice(imageIndex, 1);
        $('.images-data').val(JSON.stringify(imageDataArray));
        $(this).parent().remove();
    });
});
</script>
@endsection