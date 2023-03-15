<!-- Edit User Modal -->
<div class="modal fade" id="updateShift" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-edit-shift">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2">Update Shift Configuration</h3>
                </div>
                <form id="editShift" class="row g-3" method="post"
                      action="{{route('scheduleconfig.updateShift', ['company_id'=> $company->id_company])}}"
                      enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id_company" value="{{$company->id_company}}">
                    <div class="card">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-borderless">
                                <thead>
                                <tr>
                                    <th>Shift Name</th>
                                    <th>Start Hour</th>
                                    <th>End Hour</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($patrolScheduleShift as $shift)
                                    <tr>
                                        <td>
                                            {{$shift->shift_name}}
                                            <input type="hidden"
                                                   name="shift[{{$shift->patrol_schedule_shift_id}}][id]"
                                                   value="{{$shift->patrol_schedule_shift_id}}">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control flatpickr"
                                                   placeholder="HH:MM"
                                                   value="{{$shift->start_hour}}"
                                                   name="shift[{{$shift->patrol_schedule_shift_id}}][start_hour]"
                                                   id="start_hour_{{$shift->patrol_schedule_shift_id}}"/>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control flatpickr"
                                                   placeholder="HH:MM"
                                                   value="{{$shift->end_hour}}"
                                                   name="shift[{{$shift->patrol_schedule_shift_id}}][end_hour]"
                                                   id="end_hour_{{$shift->patrol_schedule_shift_id}}"/>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1">Update</button>
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
