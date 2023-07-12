@extends('../layout/layout')

@push('sites-leftside-menu')
@foreach ($sites as $site)
<li class="submenu-item ">
    <a href="{{ route('attendance.showlog.persite', ['siteId' => $site->id]) }}">{{
        $site->site_name }}</a>
</li>
@endforeach
@endpush

@section('page-heading')
<h1>Add Employee</h1>
@endsection

@section('page-content')
@if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
@endif
<div class="row">
    <div class="col-5"></div>
    <div class="col-md-3 col-sm-3">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ $employee->first_name.' '.$employee->last_name }} Information</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 text-center">
                                    <label>Working Site</label>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group ">
                                        <div class="position-relative">
                                            <input type="text" class="col-md-12 col-sm-12" value="{{ $findSite->site_name }} " disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 text-center">
                                    <label>Job Title</label>
                                </div>
                                <div class="col-md-12 col-sm-12 text-center">
                                    <div class="form-group ">
                                        <div class="position-relative">
                                            <input type="text" class="col-md-12 col-sm-12" value="{{ $employee->job_title }} " disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 text-center">
                                    <label>Daily Rate</label>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group ">
                                        <div class="position-relative">
                                            <input type="text" class="col-md-12 col-sm-12" value="{{ $employee->daily_rate }} " disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 text-center">
                                    <label>Address</label>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group ">
                                        <div class="position-relative">
                                            <input type="text" class="col-md-12 col-sm-12" value="{{ $employee->address }} " disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 text-center">
                                    <label>Contact #</label>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group ">
                                        <div class="position-relative">
                                            <input type="text" class="col-md-12 col-sm-12" value="{{ $employee->contact_number }} " disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <a href="{{route('employees.list')}}" type="submit" class="btn btn-primary me-1 mb-1">Back to View</a>
                            </div>
                        </div>
                </div>     
                </form>
            </div>
        </div>
    </div>
</div>
{{-- <div class="container-fluid ">
    <div class="row ">
        <div class="col-md-3"></div>
        <div class="col-md-6 ">
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
            <form action="{{ route('employees.store') }}" method="POST"
                class="border border-secondary border-2 border-lg-3 p-4 ">
                @csrf
                <h3>Employee Personal Information</h3>
                <div class="form-group row ">
                    <label for="firstName" class="col-sm-3 text-right p-0">First Name</label>
                    <div class="col-sm-9 ">
                        <input type="text" class="form-control" id="firstName" name="firstName" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="middleName" class="col-sm-3 text-right p-0">Middle Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="middleName" name="middleName" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="lastName" class="col-sm-3 text-right p-0">Last Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="lastName" name="lastName" required>
                    </div>
                </div>

                <div class="mb-3 form-group row ">
                    <label for="gender" class="col-sm-3 text-right p-0">Gender</label>
                    <div class="col-sm-9">
                        <select class="form-control" id="gender" name="gender" required>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3 form-group row ">
                    <label for="jobTitle" class="col-sm-3 text-right p-0">Job Title</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="jobTitle" name="jobTitle" required>
                    </div>
                </div>

                <div class="mb-3 form-group row ">
                    <label for="dailyRate" class="col-sm-3 text-right p-0">Daily Rate</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="dailyRate" name="dailyRate" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="address" class="col-sm-3 text-right p-0">Address</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="contactNumber" class="col-sm-3 text-right p-0">Contact Number</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="contactNumber" name="contactNumber" required>
                    </div>
                </div>
                <div class="d-flex justify-content-end ">
                    <button type="submit" class="btn btn-primary mr-4 ">Add Employee</button>
                    <a href="{{ route('employees.list') }}" class="btn btn-primary ml-5 ">Go to Employee List</a>
                </div>
            </form>
        </div>
    </div>

</div> --}}
@endsection