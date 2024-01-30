<div>
<section class="row">
    <div class="col-12 col-lg-12">
        <div class="row">
            <div class="col-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h6 class="text-end">{{\Carbon\Carbon::now()->toFormattedDateString()}}</h6>
                        
                    </div>
                    <div class="card-body">
                        <div class="row mb-3 align-items-center">
                            <div class="col-lg-1 col-md-1 col-sm-1 text-center">
                                <strong>Filter</strong>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="input-group">
                                    <select class="choices form-select" wire:model="workingSiteFilter">
                                        <option value="0">Filter by site...</option>
                                        @foreach ($sites as $site)
                                        <option value="{{$site->id}}">{{ $site->site_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="input-group">
                                    <input 
                                        type="month" 
                                        wire:model="monthFilter"
                                        class="form-control">
                                        {{-- {{Carbon\Carbon::create($monthFilter)->format('m')}} --}}
                                        {{-- {{Carbon\Carbon::create($monthFilter)->startOfMonth()->format('Y-m-d')}} --}}
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2">
                                <a href="#" wire:click.prevent="clearFilter()">Clear all</a>
                            </div>
                        </div>

                        <div class="row mb-1">
                            <div class="col d-flex justify-content-start align-items-center">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Employee name..."
                                        aria-label="Recipient's username" aria-describedby="button-addon2"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="i.e. (Last name, First name, or both)"
                                        wire:model.debounce.3000="searchString">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="bi bi-search"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="row">
                            <div class="col">
                                {{\Carbon\Carbon::now()->startOfMonth()}} <br>
                                {{\Carbon\Carbon::now()->startOfMonth()->format('Y-m-d')}} <br>
                                {{\Carbon\Carbon::now()->endOfMonth()->format('Y-m-d')}}
                            </div>
                        </div> --}}
                        @if ($workingSiteName)
                        <div class="row mb-2 my-3">
                            <div class="col">
                                <h5 class="text-center border-bottom">
                                    {{$workingSiteName}} Working site
                                </h5>
                            </div>
                        </div>
                        @endif

                        <div class="table-responsive ">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Total attendance</th>
                                        <th>Total OT</th>
                                        <th>From/To</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employees as $index => $employee)
                                    <tr wire:key="emp-field-{{ $employee->id }}">
                                        <td class="col-auto">
                                            <div class="d-flex align-items-center">
                                                <p class="font-bold ms-3 mb-0">
                                                    {{ Str::ucfirst(Str::lower($employee->last_name)) }},
                                                    {{ Str::ucfirst(Str::lower($employee->first_name )) }}
                                                </p>
                                            </div>
                                        </td>
                                        <td class="col-auto">
                                            {{-- {{$filterFrom}} --}}
                                            @php
                                                $attendance = DB::table('employee_time_records')
                                                    ->where('employee_id', $employee->id)
                                                    ->whereBetween(\DB::raw('DATE(attendance_from)'), [
                                                        $filterFrom ? $filterFrom : Carbon\Carbon::now()->startOfMonth(),
                                                        $filterTo ? $filterTo : Carbon\Carbon::now()->endOfMonth(),
                                                    ])
                                                    ->sum('days_present');
                                            @endphp
                                            {{$attendance}}
                                        </td>
                                        <td class="col-auto">
                                            @php
                                                $totalOt = DB::table('employee_time_records')
                                                    ->where('employee_id', $employee->id)
                                                    ->whereBetween(\DB::raw('DATE(attendance_from)'), [
                                                        $filterFrom ? $filterFrom : Carbon\Carbon::now()->startOfMonth(),
                                                        $filterTo ? $filterTo : Carbon\Carbon::now()->endOfMonth(),
                                                    ])
                                                ->sum('total_ot');
                                            @endphp
                                            {{$totalOt}}
                                        </td>
                                        <td class="col-auto">
                                            <div>
                                                {{
                                                    $filterFrom 
                                                        ? Carbon\Carbon::create($filterFrom)->format('Y-m-d') 
                                                        : Carbon\Carbon::now()->startOfMonth()->format('Y-m-d')
                                                }}/
                                                {{
                                                    $filterTo 
                                                        ? Carbon\Carbon::create($filterTo)->format('Y-m-d') 
                                                        : Carbon\Carbon::now()->endOfMonth()->format('Y-m-d')
                                                }}
                                            </div>
                                        </td>
                                        <td class="col-auto">
                                            <div class="d-flex align-items-center">
                                                {{-- <a href="{{route('working.site.assigned.employees', ['siteId' => $site->id])}}">
                                                    <span data-bs-toggle="tooltip" title="Show assigned employees">
                                                        <i class="bi bi-person-lines-fill"></i>
                                                    </span>
                                                </a> &nbsp; | &nbsp; --}}
                                            
                                                <a href="#" 
                                                    wire:click.prevent="showInputEmployeeAttendance({{$employee->id}})"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#inputDtr"
                                                    >
                                                    <span data-bs-toggle="tooltip" title="Input/Edit DTR">
                                                        <i class="bi bi-card-checklist"></i>
                                                    </span>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="row">
                            <div class="col d-flex justify-content-start align-items-center">
                                <strong>Total: </strong> <small>{{ $employees->total() }}</small>
                            </div>
                            <div class="col d-flex justify-content-end">
                                {{ $employees->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@livewire('employee-attendance-management.input-employee-attendance')



</div>