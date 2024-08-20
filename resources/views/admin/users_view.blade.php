@extends("admin_base")
@section("title") Modify User - {{ $user->full_name }} @endsection
@section("style")
<style>
#avatar_img_preview{
    width: 200px;
    height: 200px;
    border-radius: 50%;
    margin-bottom: 10px;
}
.input-group-text{
    cursor: pointer;
}
#flag_icon{
    width: 20px;
}
.country_list_item:hover{
    background-color: #505050;
    color: #ffffff;
    cursor: pointer;
}
</style>
@endsection
@section("content")
<div class="row">
<div class="col-12 mb-2">
<h5 class="text-dark border-bottom"><a href="{{ route('admin_users_list') }}" class="text-muted">Users List</a>/Modify User - {{ $user->full_name }}</h5>
</div>
<div class="col-12">
<div class="card card-body">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <form action="{{ route('admin_users_view_handler') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                    <div class="col-12 mb-3">
                        <div class="row">
                            <div class="col-md-4 mx-auto d-flex flex-column align-items-center">
                                <img id="avatar_img_preview" src="{{ Storage::url($user->avatar) }}" class="img-fluid" width="150px">
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="avatar" class="custom-file-input" id="avatar_img" onchange="previewAvatar(this)">
                                        <label class="custom-file-label" for="avatar_img">Update profile picture</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="full_name" class="text-muted mb-1">Full Name</label>
                        <input type="text" class="form-control" name="full_name" id="full_name" value="{{ $user->full_name }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email" class="text-muted mb-1">Email</label>
                        <input type="text" class="form-control" name="email" id="email" value="{{ $user->email }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="phone" class="text-muted mb-1">Mobile Number</label>
                        <input type="tel" class="form-control" name="phone" id="phone" value="{{ $user->phone }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="whatsapp_no" class="text-muted mb-1">WhatsApp Number</label>
                        <input type="tel" class="form-control" name="whatsapp_no" id="whatsapp_no" value="{{ $user->whatsapp_no }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="gender" class="text-muted mb-1">Gender</label>
                        <select name="gender" class="custom-select" required>
                          <option selected disabled>-- select --</option>
                          <option value="male" {{ $user->gender === 'male' ? 'selected' : '' }}>Male</option>
                          <option value="female" {{ $user->gender === 'female' ? 'selected' : '' }}>Female</option>
                          <option value="others" {{ $user->gender === 'others' ? 'selected' : '' }}>Others</option>
                        </select>
                      </div>
                    <div class="col-md-6 mb-3">
                        <label for="birth_date" class="text-muted mb-1">Date of Birth</label>
                        <input type="date" class="form-control" name="birth_date" id="birth_date" value="{{ $user->birth_date }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="address" class="text-muted mb-1">Address</label>
                        <input type="text" class="form-control" name="address" id="address" value="{{ $user->address }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="city" class="text-muted mb-1">City</label>
                        <input type="text" class="form-control" name="city" id="city" value="{{ $user->city }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="state" class="text-muted mb-1">State/Region</label>
                        <input type="text" class="form-control" name="state" id="state" value="{{ $user->state }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted mb-1">Country</label>
                        <div class="d-flex justify-content-between">
                            <span id="user_country_info"><img src="{{ asset('flags/' . $user->flag . '.svg') }}" id="flag_icon"> {{ $user->country }}</span>
                            <button type="button" class="btn bg-light text-center border p-2" data-toggle="modal" data-target="#country_selector_modal"><i class="fas fa-flag text-dark p-0"></i></button>
                        </div>
                        <input type="hidden" name="flag" id="flag_field" value="{{ $user->flag }}">
                        <input type="hidden" name="country" id="country_field" value="{{ $user->country }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="zip_code" class="text-muted mb-1">Zip Code</label>
                        <input type="tel" class="form-control" name="zip_code" id="zip_code" value="{{ $user->zip_code }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold text-muted mb-1">Member Since</label>
                        <div>{{ \Carbon\Carbon::parse(auth()->user()->joined_date)->format('M d, Y') }}</div>
                    </div>
                    <div class="col-12">
                        <hr class="my-2">
                    </div>
                    <div class="col-12 my-3">
                    <div class="row">
                    <div class="col-md-6">
                        <label for="password" class="text-muted mb-1">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control border-right-0" name="password" id="password" placeholder="type for update password or ignore it">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white border-left-0" onclick="togglePasswordVisibility()">
                                    <i id="eye-icon" class="fas fa-eye-slash"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="password" class="text-muted mb-1">Account Status</label>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="status_active" name="is_active" class="custom-control-input" value="1" {{ $user->is_active ? "checked" : "" }}>
                            <label class="custom-control-label" for="status_active">Active</label>
                          </div>
                          <div class="custom-control custom-radio">
                            <input type="radio" id="status_inactive" name="is_active" class="custom-control-input" value="0" {{ $user->is_active ? "" : "checked" }}>
                            <label class="custom-control-label" for="status_inactive">Inactive</label>
                          </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="password" class="text-muted mb-1">Admin Access</label>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="admin_access_yes" name="is_admin" class="custom-control-input" value="1" {{ $user->is_admin ? "checked" : "" }}>
                            <label class="custom-control-label" for="admin_access_yes">Yes</label>
                          </div>
                          <div class="custom-control custom-radio">
                            <input type="radio" id="admin_access_no" name="is_admin" class="custom-control-input" value="0" {{ $user->is_admin ? "" : "checked" }}>
                            <label class="custom-control-label" for="admin_access_no">No</label>
                          </div>
                    </div>
                    </div>
                    </div>
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <div class="col-md-8 mx-auto d-flex justify-content-center mt-3">
                    <button type="submit" class="btn bg-success">Save Changes</button>
                </form>
            </div>
        </div>
</div>
</div>
</div>

<div class="modal fade" id="country_selector_modal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="mb-0">Select Your Country</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-2">
        <input type="text" id="country_search" class="form-control mb-2" placeholder="Search for your country">
        <ul class="list-group" id="country_list">
        </ul>
      </div>
    </div>
  </div>
</div>
@endsection
@section("script")
<script>
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('avatar_img_preview').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
function togglePasswordVisibility() {
    let passwordInput = document.getElementById('password');
    let eyeIcon = document.getElementById('eye-icon');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
    } else {
        passwordInput.type = 'password';
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
    }
}
const countryData = {
    "af": "Afghanistan", "al": "Albania", "dz": "Algeria", "as": "American Samoa", "ad": "Andorra", "ao": "Angola", "ai": "Anguilla", "aq": "Antarctica", "ag": "Antigua and Barbuda", "ar": "Argentina", "am": "Armenia", "aw": "Aruba", "au": "Australia", "at": "Austria", "az": "Azerbaijan", "bs": "Bahamas", "bh": "Bahrain", "bd": "Bangladesh", "bb": "Barbados", "by": "Belarus", "be": "Belgium", "bz": "Belize", "bj": "Benin", "bm": "Bermuda", "bt": "Bhutan", "bo": "Bolivia", "bq": "Bonaire, Sint Eustatius and Saba", "ba": "Bosnia and Herzegovina", "bw": "Botswana", "bv": "Bouvet Island", "br": "Brazil", "io": "British Indian Ocean Territory", "bn": "Brunei Darussalam", "bg": "Bulgaria", "bf": "Burkina Faso", "bi": "Burundi", "kh": "Cambodia", "cm": "Cameroon", "ca": "Canada", "cv": "Cabo Verde", "ky": "Cayman Islands", "cf": "Central African Republic", "td": "Chad", "cl": "Chile", "cn": "China", "cx": "Christmas Island", "cc": "Cocos (Keeling) Islands", "co": "Colombia", "km": "Comoros", "cg": "Congo", "cd": "Congo, Democratic Republic of the", "ck": "Cook Islands", "cr": "Costa Rica", "hr": "Croatia", "cu": "Cuba", "cw": "Curaçao", "cy": "Cyprus", "cz": "Czech Republic", "dk": "Denmark", "dj": "Djibouti", "dm": "Dominica", "do": "Dominican Republic", "ec": "Ecuador", "eg": "Egypt", "sv": "El Salvador", "gq": "Equatorial Guinea", "er": "Eritrea", "ee": "Estonia", "et": "Ethiopia", "eu": "European Union", "fk": "Falkland Islands (Malvinas)", "fo": "Faroe Islands", "fj": "Fiji", "fi": "Finland", "fr": "France", "gf": "French Guiana", "pf": "French Polynesia", "tf": "French Southern Territories", "ga": "Gabon", "gm": "Gambia", "ge": "Georgia", "de": "Germany", "gh": "Ghana", "gi": "Gibraltar", "gr": "Greece", "gl": "Greenland", "gd": "Grenada", "gp": "Guadeloupe", "gu": "Guam", "gt": "Guatemala", "gg": "Guernsey", "gn": "Guinea", "gw": "Guinea-Bissau", "gy": "Guyana", "ht": "Haiti", "hm": "Heard Island and McDonald Islands", "va": "Holy See (Vatican City State)", "hn": "Honduras", "hk": "Hong Kong", "hu": "Hungary", "is": "Iceland", "in": "India", "id": "Indonesia", "ir": "Iran, Islamic Republic of", "iq": "Iraq", "ie": "Ireland", "il": "Israel (Palestinian Territory)", "im": "Isle of Man", "it": "Italy", "jm": "Jamaica", "jp": "Japan", "je": "Jersey", "jo": "Jordan", "kz": "Kazakhstan", "ke": "Kenya", "ki": "Kiribati", "kp": "Korea, Democratic People's Republic of", "kr": "Korea, Republic of", "xk": "Kosovo", "kw": "Kuwait", "kg": "Kyrgyzstan", "la": "Lao People's Democratic Republic", "lv": "Latvia", "lb": "Lebanon", "ls": "Lesotho", "lr": "Liberia", "ly": "Libya", "li": "Liechtenstein", "lt": "Lithuania", "lu": "Luxembourg", "mo": "Macao", "mg": "Madagascar", "mw": "Malawi", "my": "Malaysia", "mv": "Maldives", "ml": "Mali", "mt": "Malta", "mh": "Marshall Islands", "mq": "Martinique", "mr": "Mauritania", "mu": "Mauritius", "yt": "Mayotte", "mx": "Mexico", "fm": "Micronesia, Federated States of", "md": "Moldova, Republic of", "mc": "Monaco", "mn": "Mongolia", "me": "Montenegro", "ms": "Montserrat", "ma": "Morocco", "mz": "Mozambique", "mm": "Myanmar", "na": "Namibia", "nr": "Nauru", "np": "Nepal", "nl": "Netherlands", "nc": "New Caledonia", "nz": "New Zealand", "ni": "Nicaragua", "ne": "Niger", "ng": "Nigeria", "nu": "Niue", "nf": "Norfolk Island", "mp": "Northern Mariana Islands", "no": "Norway", "om": "Oman", "pk": "Pakistan", "pw": "Palau", "ps": "Palestine", "pa": "Panama", "pg": "Papua New Guinea", "py": "Paraguay", "pe": "Peru", "ph": "Philippines", "pn": "Pitcairn", "pl": "Poland", "pt": "Portugal", "pr": "Puerto Rico", "qa": "Qatar", "re": "Réunion", "ro": "Romania", "ru": "Russian Federation", "rw": "Rwanda", "sh": "Saint Helena, Ascension and Tristan da Cunha", "kn": "Saint Kitts and Nevis", "lc": "Saint Lucia", "mf": "Saint Martin (French part)", "pm": "Saint Pierre and Miquelon", "vc": "Saint Vincent and the Grenadines", "ws": "Samoa", "sm": "San Marino", "st": "Sao Tome and Principe", "sa": "Saudi Arabia", "sn": "Senegal", "rs": "Serbia", "sc": "Seychelles", "sl": "Sierra Leone", "sg": "Singapore", "sx": "Sint Maarten (Dutch part)", "sk": "Slovakia", "si": "Slovenia", "sb": "Solomon Islands", "so": "Somalia", "za": "South Africa", "gs": "South Georgia and the South Sandwich Islands", "ss": "South Sudan", "es": "Spain", "lk": "Sri Lanka", "sd": "Sudan", "sr": "Suriname", "sj": "Svalbard and Jan Mayen", "se": "Sweden", "ch": "Switzerland", "sy": "Syrian Arab Republic", "tw": "Taiwan, Province of China", "tj": "Tajikistan", "tz": "Tanzania, United Republic of", "th": "Thailand", "tl": "Timor-Leste", "tg": "Togo", "tk": "Tokelau", "to": "Tonga", "tt": "Trinidad and Tobago", "tn": "Tunisia", "tr": "Turkiye", "tm": "Turkmenistan", "tc": "Turks and Caicos Islands", "tv": "Tuvalu", "ug": "Uganda", "ua": "Ukraine", "ae": "United Arab Emirates", "gb": "United Kingdom", "us": "United States", "um": "United States Minor Outlying Islands", "un": "United Nations", "uy": "Uruguay", "uz": "Uzbekistan", "vu": "Vanuatu", "ve": "Venezuela, Bolivarian Republic of", "vn": "Viet Nam", "vg": "Virgin Islands, British", "vi": "Virgin Islands, U.S.", "wf": "Wallis and Futuna", "eh": "Western Sahara", "ye": "Yemen", "zm": "Zambia", "zw": "Zimbabwe"
};
function populateCountryList() {
  const modalBody = document.querySelector("#country_selector_modal .modal-body");
  const searchInput = modalBody.querySelector("#country_search");
  const countryList = modalBody.querySelector("#country_list");

  searchInput.addEventListener("input", function () {
    const searchTerm = searchInput.value.toLowerCase();
    const matchedCountries = Object.entries(countryData)
      .filter(([code, name]) => name.toLowerCase().includes(searchTerm))
      .slice(0, 5);

    renderCountryList(matchedCountries);
  });

  renderCountryList(Object.entries(countryData).slice(0, 5));
}
function renderCountryList(countryListData) {
  const listContainer = document.querySelector("#country_list");
  listContainer.innerHTML = "";

  for (const [countryCode, countryName] of countryListData) {
    const listItem = document.createElement("li");
    listItem.classList.add("list-group-item");
    listItem.classList.add("country_list_item");
    listItem.innerHTML = `<img src="{{ asset('flags') }}/${countryCode}.svg" id="flag_icon"> ${countryName}`;
    listItem.addEventListener('click', function () {
      document.getElementById('country_field').value = countryName;
      document.getElementById('flag_field').value = countryCode;
      document.getElementById('user_country_info').innerHTML = `<img src="{{ asset('flags') }}/${countryCode}.svg" id="flag_icon"> ${countryName}`;
      $('#country_selector_modal').modal('hide');
    });
    listContainer.appendChild(listItem);
  }
}
$('#country_selector_modal').on('shown.bs.modal', function () {
  populateCountryList();
  $("#country_search").focus();
});
</script>
@endsection