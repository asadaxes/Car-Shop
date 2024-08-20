@extends("general_base")
@section("title") CarShop - Publish New Car @endsection
@section("style")
<style>
.hr_bg{
    background-color: #c3c3c3;
    border: none;
    margin-bottom: 13px; 
}
img.car_images_preview{
    width: 125px;
}
.progress{
    height: 15px;
}
</style>
@endsection
@section("content")
<div class="container mtb_6030">
<div class="card card-body mb-4">
<form action="{{ route('vehicle_publish_new_handler') }}" method="POST" enctype="multipart/form-data">
@csrf
<div class="row mb-2">
<div class="col-12 mb-3">
<h4 class="text-danger text-center">Post Your Car</h4>
<hr class="w-25 mx-auto">
<span id="progress_bar_text">Fill Information</span>
<div class="progress mt-0 mb-4" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
    <div class="progress-bar bg-danger" style="width: 0%;"></div>
</div>
</div>
<div id="page_info">
<div class="row">
    <div class="col-md-4 mb-3">
        <label for="brand" class="mb-0">Select Brand <small class="text-danger">*</small></label>
        <select name="brand_id" class="form-select" id="brand" required>
            <option selected disabled>-- Select --</option>
            @foreach ($brands as $brand)
                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4 mb-3">
        <label for="category" class="mb-0">Select Category <small class="text-danger">*</small></label>
        <select name="category_id" class="form-select" id="category" required>
            <option selected disabled>-- Select --</option>
            @foreach ($vehicle_categories as $category)
                <option value="{{ $category->id }}">{{ $category->title }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <label for="condition" class="mb-0">Select Condition <small class="text-danger">*</small></label>
        <select name="condition" class="form-select" id="condition" required>
            <option selected disabled>-- Select --</option>
            <option value="new">New</option>
            <option value="used">Used</option>
            <option value="recondition">Recondition</option>
            <option value="modified">Modified</option>
        </select>
    </div>
    </div>
    <hr class="hr_bg">
    <div class="row mb-3">
    <div class="col-md-8 mb-3">
        <label for="model" class="mb-0">Vehicle Model <small class="text-danger">*</small></label>
        <input type="text" name="model" class="form-control" id="model" required>
    </div>
    <div class="col-md-4 mb-3">
        <label for="price" class="mb-0">Price <small class="text-danger">*</small></label>
        <div class="input-group">
            <span class="input-group-text">BDT</span>
            <input type="tel" name="price" class="form-control" id="price" required>
        </div>
    </div>
    <div class="col-12">
        <label for="description" class="mb-0">Write a brief about your car <small class="text-danger">*</small></label>
        <textarea name="description" class="form-control" id="description" rows="3"></textarea>
    </div>
    </div>
    <div class="row mb-2">
    <div class="col-md-8 mb-3">
        <label for="model" class="mb-0">Add car features & options <small class="text-danger">*</small></label>
        <div class="input-group">
            <input type="text" class="form-control key_input" placeholder="key">
            <input type="text" class="form-control value_input" placeholder="value">
            <span class="input-group-text cursor_pointer add_option"><i class="fas fa-plus"></i></span>
        </div>
        <input type="hidden" name="features_options" value="[]">
        <div class="features_options_container mt-2">
        </div>
    </div>
    <div class="col-md-4">
        <label for="model" class="mb-0">Extra features <small class="text-danger">*</small></label>
        <div class="input-group">
            <input type="text" class="form-control feature_input">
            <span class="input-group-text cursor_pointer add_feature"><i class="fas fa-plus"></i></span>
        </div>
        <input type="hidden" name="features" value="[]">
        <div class="badge_container mt-2">
        </div>
    </div>
    </div>
    <hr class="hr_bg">
    <div class="row mb-2">
    <div class="col-md-4 mb-3">
        <label for="mileage" class="mb-0">Mileage <small class="text-danger">*</small></label>
        <input type="number" name="mileage" class="form-control" id="mileage" required>
    </div>
    <div class="col-md-4 mb-3">
        <label for="fuel_type" class="mb-0">Fuel type <small class="text-danger">*</small></label>
        <input type="text" name="fuel_type" class="form-control" id="fuel_type" placeholder="Diesel, LPG, CNG etc..." required>
    </div>
    <div class="col-md-4 mb-3">
        <label for="engine" class="mb-0">Engine <small class="text-danger">*</small></label>
        <input type="text" name="engine" class="form-control" id="engine" required>
    </div>
    <div class="col-md-4 mb-3">
        <label for="drivetrain" class="mb-0">Drivetrain <small class="text-danger">*</small></label>
        <input type="text" name="drivetrain" class="form-control" id="drivetrain" required>
    </div>
    <div class="col-md-4 mb-3">
        <label for="exterior_color" class="mb-0">Exterior color <small class="text-danger">*</small></label>
        <input type="text" name="exterior_color" class="form-control" id="exterior_color" required>
    </div>
    <div class="col-md-4 mb-3">
        <label for="interior_color" class="mb-0">Interior color <small class="text-danger">*</small></label>
        <input type="text" name="interior_color" class="form-control" id="interior_color" required>
    </div>
    <div class="col-md-4 mb-3">
        <label for="model_year" class="mb-0">Model year <small class="text-danger">*</small></label>
        <input type="number" name="model_year" class="form-control" id="model_year" required>
    </div>
    <div class="col-md-4 mb-3">
        <label for="registration_year" class="mb-0">Registration year <small class="text-muted">(if have)</small></label>
        <input type="number" name="registration_year" class="form-control" id="registration_year" placeholder="optional">
    </div>
    </div>
    <hr class="hr_bg">
    <div class="row mb-3">
        <div class="col-md-6 d-flex flex-column justify-content-center align-items-center">
            <label for="images">Select your car photos</label>
            <input type="file" id="images" accept=".png, .jpg, .jpeg" multiple>
        </div>
        <div class="col-md-6">
            <input type="hidden" name="images" class="images-data">
            <ul class="list-group list-group-numbered image-previews">
            </ul>
        </div>
    </div>
    <input type="hidden" name="campaign" id="campaign_field">
    <hr class="hr_bg">
    <div class="text-center">
        <button type="button" class="btn btn-primary" id="process_next_btn">Process Next <i class="fas fa-angle-right"></i></button>
    </div>
</div>
</div>
<div id="page_campaign">
<div class="row d-flex justify-content-center mb-4">
@foreach($campaigns as $campaign)
    <div class="col-md-4">
        <div class="card card-body bg-light pb-0">
            <h4 class="text-danger text-center">{{ $campaign->name }}</h4>
            <table class="table text-center mb-0">
                <tbody>
                    @foreach(json_decode($campaign->pricing) as $pricing)
                        @foreach($pricing as $days => $price)
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input type="radio" name="pricing_field" class="form-check-input pricing_radio" id="pricing_{{ $loop->parent->index }}_{{ $campaign->id }}" data-campaign="{{ $campaign->name }}" data-days="{{ $days }}" data-price="{{ $price }}">
                                        <label class="form-check-label" for="pricing_{{ $loop->parent->index }}_{{ $campaign->id }}">{{ $days }} Days - {{ $price }} BDT</label>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endforeach
</div>
<hr class="hr_bg">
<div class="d-flex justify-content-end">
    <button type="button" class="btn btn-secondary me-2" id="go_back_btn"><i class="fas fa-angle-left"></i> Back</button>
    <button type="submit" class="btn btn-success">Proceed to Checkout</button>
</div>
</div>
</form>
</div>
</div>
@endsection
@section("script")
<script>
$(document).ready(function(){
    $("#page_campaign").hide();
    $("#process_next_btn").click(function(){
        $("#page_info").hide();
        $("#page_campaign").show();
        $("#progress_bar_text").text("Select Your Ad Campaign");
        $(".progress-bar").css("width", "50%");
    });
    $("#go_back_btn").click(function(){
        $("#page_info").show();
        $("#page_campaign").hide();
        $("#progress_bar_text").text("Fill Information");
        $(".progress-bar").css("width", "0%");
    });

    $('.pricing_radio').on('change', function() {
        let campaignName = $(this).data('campaign');
        let days = $(this).data('days');
        let price = $(this).data('price');
        let campaignData = {};
        campaignData[campaignName] = {};
        campaignData[campaignName][days] = price;
        $('#campaign_field').val(JSON.stringify(campaignData));
    });

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

    $('#images').change(function() {
        let imageDataArray = [];
        $.each(this.files, function(index, file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                $('.image-previews').append('<li class="list-group-item d-flex justify-content-between align-items-center">' +
                    '<div><img src="' + event.target.result + '" class="car_images_preview rounded"></div>' +
                    '<i class="fas fa-trash-alt fa-lg text-danger cursor_pointer remove-image"></i>' +
                    '</li>');
                imageDataArray.push(event.target.result);
                $('.images-data').val(JSON.stringify(imageDataArray));
            };
            reader.readAsDataURL(file);
        });
    });
    $(document).on('click', '.remove-image', function() {
        let imageIndex = $(this).parent().index();
        let imageDataArray = JSON.parse($('.images-data').val() || '[]');
        imageDataArray.splice(imageIndex, 1);
        $('.images-data').val(JSON.stringify(imageDataArray));
        $(this).parent().remove();
    });
});
</script>
@endsection