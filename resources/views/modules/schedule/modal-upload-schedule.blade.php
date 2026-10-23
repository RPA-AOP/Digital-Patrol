<!-- Edit User Modal -->
<div class="modal fade" id="uploadSchedule" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-edit-user">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2">Upload Patrol Schedule</h3>
                    <p class="text-muted">Import patrol from excel.</p>
                </div>
                <form id="editUserForm" class="row g-3" method="post" action="{{route('scheduleconfig.import')}}"
                      enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id_company" value="{{$company->id_company}}">
                    <div class="col-12">
                        <label class="form-label" for="areaSelect">Patrol Area</label>
                        <select id="areaSelect" class="form-control selectpicker" name="area" data-style="btn-default">
                            @foreach($area as $a)
                                <option value="{{ $a->id_detail_patrol_config }}">(Level {{ $a->level }}
                                    ) {{ $a->name }}</option>
                            @endforeach
                        </select>
                        <div class="form-text">Patrol Area based on specific level of area in user configuration.</div>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="monthSelect">Month</label>
                        @php
                            $months = [];
                            for ($m=1; $m<=12; $m++) {
                                $months[] = date('F', mktime(0,0,0,$m, 1, date('Y')));
                            }
                        @endphp
                        <select id="monthSelect" class="form-control selectpicker" name="month"
                                data-style="btn-default">
                            @foreach($months as $k => $month)
                                <option value="{{ $k+1 }}" {{now()->month ==($k+1)?'selected':''}}>{{ $month }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="yearSelect">Year</label>
                        @php
                            use Carbon\Carbon;use Illuminate\Support\Facades\Auth;
                            
                            $years = collect(range(2024 , (now()->year + 5)))->map(function ($item) {
                                return (string) $item;
                            });
                        @endphp
                        <select id="yearSelect" class="form-control selectpicker" name="year" data-style="btn-default">
                            @foreach($years as $year)
                                <option value="{{ $year }}" {{date('Y')==$year?'selected':''}}>{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <x-fileinput
                            label=""
                            id="import-data patroli"
                            placeholder="Choose Patrol Schedule file (.xslx)"
                            :required="true"
                            :multiple="false"
                            :extensions="['xlsx']"
                        >
                        </x-fileinput>
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1">Upload</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
    </div>
  </div>
</div>
<!--/ Edit User Modal -->
