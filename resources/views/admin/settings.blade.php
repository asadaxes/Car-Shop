@extends("admin_base")
@section("title") Settings @endsection
@section("style")
<style>
img.favicon_preview{
    width: 25px;
}
img.logo_img_preview{
    width: 250px;
}
</style>
@endsection
@section("content")
<div class="row">
<div class="col-12">
<h5 class="text-dark border-bottom">Settings</h5>
</div>
<div class="col-12">
<div class="card card-body">
<form action="{{ route('admin_settings_updater') }}" method="POST" enctype="multipart/form-data">
@csrf
<div class="row">
<div class="col-12 border-bottom text-center mb-3">
<small class="text-muted">Favicon & Logo</small>
</div>
<div class="col-12 mb-4">
<div class="row">
    <div class="col-md-4 d-flex flex-column align-items-center">
        <span>Favicon Icon</span>
        <img src="{{ $settings->favicon ? Storage::url($settings->favicon) : asset('images/favicon.ico') }}" class="img-fluid rounded favicon_preview mt-2 mb-3">
        <input type="file" name="favicon" class="favicon mb-md-0 mb-3">
    </div>
    <div class="col-md-4 d-flex flex-column align-items-center">
        <span>Site logo</span>
        <img src="{{ $settings->logo_site ? Storage::url($settings->logo_site) : asset('images/placeholder_img.png') }}" class="img-fluid rounded logo_img_preview img_preview_site my-2">
        <input type="file" name="logo_site" class="logo_site mb-md-0 mb-3">
    </div>
    <div class="col-md-4 d-flex flex-column align-items-center">
        <span>Admin logo</span>
        <img src="{{ $settings->logo_admin ? Storage::url($settings->logo_admin) : asset('images/placeholder_img.png') }}" class="img-fluid rounded logo_img_preview img_preview_admin my-2">
        <input type="file" name="logo_admin" class="logo_admin">
    </div>
</div>
</div>

<div class="col-12 border-bottom text-center mb-3">
<small class="text-muted">Title</small>
</div>
<div class="col-md-10 mx-auto mb-4">
<div class="row">
<div class="col-md-6 mb-md-0 mb-3">
    <label for="title_site" class="text-dark mb-0">Site Title</label>
    <input type="text" name="title_site" class="form-control" id="title_site" value="{{ $settings->title_site }}" required>
</div>
<div class="col-md-6">
    <label for="title_admin" class="text-dark mb-0">Admin Title</label>
    <input type="text" name="title_admin" class="form-control" id="title_admin" value="{{ $settings->title_admin }}" required>
</div>
</div>
</div>

<div class="col-12 border-bottom text-center mb-3">
<small class="text-muted">Footer</small>
</div>
<div class="col-12 mx-auto mb-4">
<div class="row">
<div class="col-md-7 mb-md-0 mb-3">
    <label for="footer_copyright" class="text-dark mb-0">Footer Copyright</label>
    <input type="text" name="footer_copyright" class="form-control mb-3" id="footer_copyright" value="{{ $settings->footer_copyright }}" required>
    <label for="footer_description" class="text-dark mb-0">Footer Description</label>
    <textarea name="footer_description" class="form-control" id="footer_description" rows="4">{{ $settings->footer_description }}</textarea>
</div>
<div class="col-md-5">
    <label for="footer_link_1" class="text-dark mb-0">Footer Links 1</label>
    <input type="text" name="footer_link_1" class="form-control mb-3" id="footer_link_1" value="{{ $settings->footer_link_1 }}" required>
    <label for="footer_link_2" class="text-dark mb-0">Footer Links 2</label>
    <input type="text" name="footer_link_2" class="form-control mb-3" id="footer_link_2" value="{{ $settings->footer_link_2 }}" required>
    <label for="footer_link_3" class="text-dark mb-0">Footer Contact Details</label>
    <input type="text" name="footer_link_3" class="form-control mb-3" id="footer_link_3" value="{{ $settings->footer_link_3 }}" required>
</div>
<div class="col-12">
<div class="row">
    <div class="col-md-4">
        <label for="contact_address" class="text-dark mb-0">Contact Address</label>
        <input type="text" name="contact_address" class="form-control mb-3" id="contact_address" value="{{ $settings->contact_address }}" required>
    </div>
    <div class="col-md-4">
        <label for="contact_phone" class="text-dark mb-0">Contact Phone</label>
        <input type="tel" name="contact_phone" class="form-control mb-3" id="contact_phone" value="{{ $settings->contact_phone }}" required>
    </div>
    <div class="col-md-4">
        <label for="contact_email" class="text-dark mb-0">Contact Email</label>
        <input type="email" name="contact_email" class="form-control" id="contact_email" value="{{ $settings->contact_email }}" required>
    </div>
</div>
</div>
</div>
</div>

<div class="col-12 border-bottom text-center mb-3">
<small class="text-muted">SEO</small>
</div>
<div class="col-12 mb-4">
<div class="row">
    <div class="col-md-5">
        <label for="ga_id" class="text-dark mb-0">Google Analytics ID</label>
        <input type="text" name="ga_id" class="form-control mb-3" id="ga_id" value="{{ $settings->ga_id }}" placeholder="UA-01234560-0">
    </div>
    <div class="col-md-7">
        <label for="meta_author" class="text-dark mb-0">Meta Author</label>
        <input type="text" name="meta_author" class="form-control mb-3" id="meta_author" value="{{ $settings->meta_author }}">
    </div>
    <div class="col-md-6 mb-md-0 mb-3">
        <label for="meta_description" class="text-dark mb-0">Meta Description</label>
        <textarea name="meta_description" class="form-control" id="meta_description" rows="3">{{ $settings->meta_description }}</textarea>
    </div>
    <div class="col-md-6">
        <label for="meta_keywords" class="text-dark mb-0">Meta Keywords</label>
        <textarea name="meta_keywords" class="form-control" id="meta_keywords" rows="3">{{ $settings->meta_keywords }}</textarea>
    </div>
</div>
</div>

<div class="col-12 border-bottom text-center mb-3">
<small class="text-muted">Social Links</small>
</div>
<div class="col-12 mb-4">
<div class="row">
<div class="col-md-4 mb-md-0 mb-3">
    <label for="platform" class="text-dark mb-0">Select Platform</label>
    <select class="custom-select mb-3" id="platform">
        <option selected disabled>-- select --</option>
        <option value="fab fa-facebook">Facebook</option>
        <option value="fab fa-facebook-messenger">Facebook Messenger</option>
        <option value="fab fa-twitter">Twitter</option>
        <option value="fab fa-square-x-twitter">X (New Twitter)</option>
        <option value="fab fa-instagram">Instagram</option>
        <option value="fab fa-tiktok">TikTok</option>
        <option value="fab fa-linkedin">LinkedIn</option>
        <option value="fab fa-github">GitHub</option>
        <option value="fab fa-discord">Discord</option>
        <option value="fab fa-youtube">YouTube</option>
        <option value="fab fa-medium">Medium</option>
        <option value="fab fa-vimeo">Vimeo</option>
        <option value="fab fa-whatsapp">WhatsApp</option>
        <option value="fab fa-telegram">Telegram</option>
        <option value="fab fa-pinterest">Pinterest</option>
        <option value="fab fa-skype">Skype</option>
        <option value="fab fa-viber">Viber</option>
        <option value="fab fa-tumblr">Tumblr</option>
        <option value="fab fa-snapchat">Snapchat</option>
        <option value="fab fa-reddit">Reddit</option>
    </select>

    <label for="url" class="text-dark mb-0">Paste URL</label>
    <div class="input-group">
        <input type="url" class="form-control" id="url">
        <div class="input-group-prepend">
            <button type="button" class="input-group-text add_link"><i class="fas fa-plus"></i></button>
        </div>
    </div>
</div>
<div class="col-md-6 mb-md-0 mb-3 offset-2">
    <ul class="list-group" id="link_list">
        <li class="list-group-item text-muted text-center">you have no links added yet!</li>
    </ul>
</div>
</div>
</div>
<input type="hidden" name="social_ids" id="social_ids_field" value="{{ $settings->social_ids }}" required>
<div class="col-12 text-center">
<button type="submit" class="btn btn-success">Save Changes</button>
</div>

</div>
</form>
</div>
</div>
</div>
@endsection
@section("script")
<script>
$(document).ready(function() {
    $('.favicon').on('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('.favicon_preview').attr('src', e.target.result);
            }
            reader.readAsDataURL(file);
        }
    });

    $('.logo_site').on('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('.img_preview_site').attr('src', e.target.result);
            }
            reader.readAsDataURL(file);
        }
    });

    $('.logo_admin').on('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('.img_preview_admin').attr('src', e.target.result);
            }
            reader.readAsDataURL(file);
        }
    });

    let links = {!! $settings->social_ids !!};
    function displayInitialLinks() {
        $('#link_list').empty();
        if (links && links.length > 0) {
            links.forEach(link => {
                let listItem = `<a href="${link.url}" class="list-group-item d-flex justify-content-between align-items-center text-dark" target="_blank">
                                    <span><i class="${link.platform}"></i> ${link.url}</span>
                                    <button type="button" class="btn btn-sm btn-danger remove_link" data-url="${link.url}"><i class="fas fa-minus fa-sm"></i></button>
                                </a>`;
                $('#link_list').append(listItem);
            });
        } else {
            $('#link_list').html('<li class="list-group-item text-muted text-center">You have no links added yet!</li>');
        }
    }
    displayInitialLinks();
    $('.add_link').click(function() {
        let platform = $('#platform').val();
        let url = $('#url').val();
        if (!links) {
            links = [];
        }
        if (platform && url) {
            links.push({ platform: platform, url: url });
            $('#social_ids_field').val(JSON.stringify(links));
            let listItem = `<a href="${url}" class="list-group-item d-flex justify-content-between align-items-center text-dark" target="_blank">
                                <span><i class="${platform}"></i> ${url}</span>
                                <button type="button" class="btn btn-sm btn-danger remove_link" data-url="${url}"><i class="fas fa-minus fa-sm"></i></button>
                            </a>`;
            $('#link_list').append(listItem);
            $('#platform').val($('#platform option:first').val());
            $('#url').val('');
        }
    });
    $('#link_list').on('click', '.remove_link', function() {
        let urlToRemove = $(this).data('url');
        links = links.filter(link => link.url !== urlToRemove);
        $('#social_ids_field').val(JSON.stringify(links));
        $(this).closest('li').remove();
        if ($('#link_list').children().length === 0) {
            $('#link_list').html('<li class="list-group-item text-muted text-center">You have no links added yet!</li>');
        }
    });
});
</script>
@endsection