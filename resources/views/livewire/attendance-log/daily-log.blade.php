<div>
    <section class="row">
        <div class="col-12 col-lg-12">
            <div class="row">
                <div class="col-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="text-end">{{ $today }}</h6>
                            <h4 class="text-center border-bottom text-muted">{{ $workingSiteName }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3 align-items-center">
                                <div class="col-lg-1 col-md-1 col-sm-1 text-center">
                                    <strong>Filter</strong>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <div class="input-group">
                                        <select class="choices form-select" wire:model="workingSite">
                                            <option value="">Filter by site...</option>
                                            @foreach ($sites as $site)
                                            <option value="{{$site->id}}">{{ $site->site_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    {{-- <div>@json($workingSite)</div> --}}
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <div class="input-group">
                                        <input type="date" class="form-control" min="2018-01-01" >
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2">
                                    <a href="#" wire:click.prevent = "clearFilter()">Clear all</a>
                                </div>
                            </div>

                            <div class="row mb-1">
                                <div class="col d-flex justify-content-start align-items-center">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Employee name..."
                                            aria-label="Recipient's username" aria-describedby="button-addon2"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="i.e. (Last name, First name, or both)"
                                            wire:model.debounce.3000 = "searchString"
                                            >
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="bi bi-search"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col d-flex justify-content-end">
                                    <button class="btn btn-info">Upload Time Record</button>
                                </div>
                            </div>
    
                            <div class="table-responsive">
                                <table class="table table-hover table-lg">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>In <small>(AM)</small></th>
                                            <th>Out <small>(AM)</small></th>
                                            <th>In <small>(PM)</small></th>
                                            <th>Out <small>(PM)</small></th>
                                            <th>In <small>(OT)</small></th>
                                            <th>Out <small>(OT)</small></th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($employees as $employee)
                                        <tr>
                                            <td class="col-auto">
                                                <div class="d-flex align-items-center">
                                                    <p class="font-bold ms-3 mb-0">
                                                        {{ Str::ucfirst(Str::lower($employee->last_name)) }}, 
                                                        {{ Str::ucfirst(Str::lower($employee->first_name )) }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="col-auto">
                                                <p class=" mb-0"></p>
                                            </td>
                                            <td class="col-auto">
                                                <p class=" mb-0"></p>
                                            </td>
                                            <td class="col-auto">
                                                <p class=" mb-0"></p>
                                            </td>
                                            <td class="col-auto">
                                                <p class=" mb-0"></p>
                                            </td>
                                            <td class="col-auto">
                                                <p class=" mb-0"></p>
                                            </td>
                                            <td class="col-auto">
                                                <p class=" mb-0"></p>
                                            </td>
                                            <td class="col-auto">
                                                <p class=" mb-0">Alter log</p>
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
</div>
