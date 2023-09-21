<!--begin::Header-->
<div id="kt_header" class="header header-fixed">
    <div class="container d-flex align-items-stretch justify-content-between">
        <div class="d-none d-lg-flex align-items-center mr-3">
            <button class="btn btn-icon aside-toggle ml-n3 mr-10" id="kt_aside_desktop_toggle">
                <span class="svg-icon svg-icon-xxl svg-icon-dark-75">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                         viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24"/>
                            <rect fill="#000000" opacity="0.3" x="4" y="5" width="16" height="2" rx="1"/>
                            <rect fill="#000000" opacity="0.3" x="4" y="13" width="16" height="2" rx="1"/>
                            <path d="M5,9 L13,9 C13.5522847,9 14,9.44771525 14,10 C14,10.5522847 13.5522847,11 13,11 L5,11 C4.44771525,11 4,10.5522847 4,10 C4,9.44771525 4.44771525,9 5,9 Z M5,17 L13,17 C13.5522847,17 14,17.4477153 14,18 C14,18.5522847 13.5522847,19 13,19 L5,19 C4.44771525,19 4,18.5522847 4,18 C4,17.4477153 4.44771525,17 5,17 Z" fill="#000000"/>
                        </g>
                    </svg>
                </span>
            </button>
            <a href="{{route('classrooms.index')}}">
                <img alt="Logo" src="{{asset('assets/media/logos/logo.svg')}}" class="logo-sticky max-h-35px">
                <span class="font-size-h3 text-body">{{config('app.name' , 'laravel')}}</span>
            </a>
        </div>
        <!--begin::Topbar-->
        <div class="topbar">
            <div class="dropdown">
                <div class="topbar-item mr-4" data-toggle="dropdown" data-offset="10px,0px">
                    <div class="btn btn-icon btn-sm btn-clean" id="kt_quick_panel_toggle">
                        <span class="svg-icon svg-icon-2x">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                 viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"/>
                                    <path d="M11,11 L11,7 C11,6.44771525 11.4477153,6 12,6 C12.5522847,6 13,6.44771525 13,7 L13,11 L17,11 C17.5522847,11 18,11.4477153 18,12 C18,12.5522847 17.5522847,13 17,13 L13,13 L13,17 C13,17.5522847 12.5522847,18 12,18 C11.4477153,18 11,17.5522847 11,17 L11,13 L7,13 C6.44771525,13 6,12.5522847 6,12 C6,11.4477153 6.44771525,11 7,11 L11,11 Z"
                                          fill="#000000"/>
                                </g>
                            </svg><!--end::Svg Icon-->
                        </span>
                    </div>
                </div>
                <div class="dropdown-menu p-0 m-0 dropdown-menu-right">
                    <ul class="navi navi-hover py-5">
                        <li class="navi-item">
                            <a href="#" class="navi-link">
                                <span class="navi-text">Join class</span>
                            </a>
                        </li>
                        <li class="navi-item">
                            <a href="#" class="navi-link" data-toggle="modal"
                               data-target="#ClassModal">
                                <span class="navi-text">Create Class</span>
                            </a>
                        </li>

{{--                        <li class="navi-item">--}}
{{--                            <a href="#" class="navi-link" data-toggle="modal"--}}
{{--                               data-target="#TopicModal">--}}
{{--                                <span class="navi-text">Create Topic</span>--}}
{{--                            </a>--}}
{{--                        </li>--}}
                    </ul>
                </div>
            </div>

            <div class="topbar-item mr-4">
                <div class="btn btn-icon btn-sm btn-clean btn-text-dark-75" id="kt_quick_actions_toggle">
                    <span class="svg-icon svg-icon-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                             viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24"/>
                                <rect fill="#000000" x="4" y="4" width="7" height="7" rx="1.5"/>
                                <path d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z" fill="#000000" opacity="0.3"/>
                            </g>
                        </svg>
                    </span>
                </div>
            </div>
            <div class="dropdown">
                <div class="topbar-item mr-4" data-toggle="dropdown" data-offset="10px,0px">
                    <div class="symbol symbol-40 symbol-light mr-5">
                        <span class="symbol-label">
                            <img src="{{asset('assets/media/svg/avatars/011-boy-5.svg')}}"
                                 class="h-50 align-self-center" alt="">
                        </span>
                    </div>
                </div>
                <div class="dropdown-menu p-0 m-0 dropdown-menu-right">
                    <ul class="navi navi-hover py-5">
                        <li class="navi-item">
                            <x-dropdown-link  class="navi-link" >
                                <div>{{ Auth::user()->name }}</div>
                            </x-dropdown-link>
                            <hr>
                        </li>
                        <li class="navi-item">

                            <x-dropdown-link  class="navi-link" :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>
                        </li>
                        <li class="navi-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link class="navi-link" :href="route('logout')"
                                                 onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal-->
<form id="createClassForm" method="POST" action="{{ route('classrooms.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="modal fade" id="ClassModal" tabindex="-1" role="dialog"
         aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Class</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" value="{{old('name')}}" @class(['form-control','is-invalid' => $errors->has('name')]) placeholder="Enter name">
                        <x-error-feedback name="name"/>

                    </div>
                    <div class="form-group">
                        <label>Section</label>
                        <input type="text" name="section" value="{{old('section')}}" @class(['form-control','is-invalid' => $errors->has('section')]) placeholder="Enter section">
                        <x-error-feedback name="section"/>
                    </div>
                    <div class="form-group">
                        <label>Subject</label>
                        <input type="text" name="subject" value="{{old('subject')}}" @class(['form-control','is-invalid' => $errors->has('subject')]) placeholder="Enter subject">
                        <x-error-feedback name="subject"/>

                    </div>
                    <div class="form-group">
                        <label>Room</label>
                        <input type="text" name="room" value="{{old('room')}}" @class(['form-control','is-invalid' => $errors->has('room')])  placeholder="Enter room">
                        <x-error-feedback name="room"/>

                    </div>
                    <div class="form-group">
                        <label>Cover Image</label>
                        <input name="cover_image" type="file" class="form-control-file">
                        <small class="form-text text-muted">Upload a cover image for the class.</small>
                        <x-error-feedback name="cover_image"/>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close
                    </button>
                    <button type="submit" id="saveChangesBtn" class="btn btn-primary font-weight-bold">Save
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@push('js')
    <script>
        $(document).ready(function() {
            // Submit form using AJAX
            $('#createClassForm').submit(function(e) {
                e.preventDefault(); // Prevent default form submission

                // Serialize form data
                var formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Handle success response
                        $('#ClassModal').modal('hide');
                        window.location.href = "{{ route('classrooms.index') }}";
                    },
                    error: function(xhr, status, error) {
                        // Handle error response
                        var errors = xhr.responseJSON.errors; // Get validation errors
                        $.each(errors, function(key, value) {
                            var inputElement = $('input[name="' + key + '"]');
                            inputElement.addClass('is-invalid');
                            inputElement.closest('.form-group').find('.invalid-feedback').text(value[0]);
                        });
                    }
                });
            });
        });
    </script>

@endpush


