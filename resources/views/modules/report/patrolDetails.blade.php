@extends('layouts/layoutMaster')
@section('title', 'Patrol Report')

@section('vendor-style')
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/spinkit/spinkit.css')}}"/>

@endsection

@section('content')
  <div class="row">
    <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
      <!-- User Card -->
      <div class="card mb-4">
        <div class="card-body">
          <div class="d-flex justify-content-around flex-wrap pb-4 border-bottom">
            <div class="d-flex align-items-start me-4 mt-3 gap-2">
              <span class="badge bg-label-success p-2 rounded"><i class="ti ti-circle-check ti-sm"></i></span>
              <div>
                <p class="mb-0 fw-semibold">10</p>
                <small>Object Normal</small>
              </div>
            </div>
            <div class="d-flex align-items-start mt-3 gap-2">
              <span class="badge bg-label-danger p-2 rounded"><i class="ti ti-alert-circle ti-sm"></i></span>
              <div>
                <p class="mb-0 fw-semibold">8</p>
                <small>Abnormal Object</small>
              </div>
            </div>
          </div>
            <p class="mt-4 small text-uppercase text-muted">Details</p>
            <div class="info-container table-responsive text-nowrap">
                <table class="table table-borderless">
                    <tr>
                        <td width="40%">
                            <span class="fw-semibold me-1">Username</span>
                        </td>
                        <td>
                            <span>: {{$activityPatrol->user->name}}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="fw-semibold me-1">Shift</span>
                        </td>
                        <td>
                            <span>: {{$activityPatrol->patrolShift->shift_name}}</span>

                        </td>
              </tr>
              <tr>
                <td>
                  <span class="fw-semibold me-1">Patrol Type</span>

                </td>
                <td>
                  :
                  @if($activityPatrol->in_shift)
                    <span class="badge bg-label-success">Mandatory Patrol</span>
                  @else
                    <span class="badge bg-label-success">Additional Patrol</span>
                  @endif
                </td>
              </tr>
              <tr>
                <td>
                  <span class="fw-semibold me-1">Total Object</span>

                </td>
                <td>
                  <span>: {{count($reportPatrol)}}</span>

                </td>
              </tr>
              <tr>
                <td>
                  <span class="fw-semibold me-1">Percentage</span>
                </td>
                <td>
                  : <span class="badge bg-label-success">100%</span>
                </td>
              </tr>
              <tr>
                <td>
                  <span class="fw-semibold me-1">Start at</span>
                </td>
                <td>
                  <span>: {{$activityPatrol->patrol_start_time}}</span>
                </td>
              </tr>
              <tr>
                <td>
                  <span class="fw-semibold me-1">End at</span>
                </td>
                <td>
                  <span>: {{$activityPatrol->patrol_start_time}}</span>
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <!-- /User Card -->
    </div>

    <!-- list start -->
    <div class="col-xl-8 mb-4 mb-xl-0">
      <div class="card">
        <h5 class="card-header">Basic</h5>
        <div class="card-body pb-0">
          <ul class="timeline mb-0">
            @foreach($reportPatrol as $report)
              <li class="timeline-item timeline-item-transparent">
                <span class="timeline-point timeline-point-primary"></span>
                <div class="timeline-event">
                  <div class="timeline-header mb-1">
                    <h6 class="mb-0">
                      @if($report->level4)
                        {{$report->level4->name}}
                      @elseif($report->level3)
                        {{$report->level3->name}}
                      @elseif($report->level2)
                        {{$report->level2->name}}
                      @elseif($report->level1)
                        {{$report->level1->name}}
                      @endif

                    </h6>
                    <span class="text-muted">{{ $report->created_at }}</span>
                  </div>
                  <!-- START LAMPIRAN -->
                  <div class="row mb-3">
                    <div class="col-8">
                      <table>
                        <tr>
                          <td width="40%">Checkin at</td>
                          <td>:</td>
                          <td>{{ $report->checkin_time }}</td>
                        <tr>
                          <td>Checkout at</td>
                          <td>:</td>
                          <td>{{ $report->checkout_time }}</td>
                        </tr>
                        <tr>
                          <td>
                            Total Object
                          </td>
                          <td>:</td>
                          <td>{{ count($report->reportPatrolDetail) }}</td>
                        </tr>
                      </table>
                    </div>
                    <div class="col-4 text-end">
                      <p class="mb-2 text-muted"><i class="ti ti-paperclip ti-sm"></i>Abnormal Attachment</p>
                      <div class="d-flex align-items-center justify-content-end avatar-group">
                        <div class="avatar pull-up" data-bs-toggle="tooltip" data-popup="tooltip-custom"
                             data-bs-placement="top" aria-label="Vinnie Mostowy"
                             data-bs-original-title="Vinnie Mostowy">
                          <img src="{{asset('/assets/img/avatars/5.png')}}" alt="Avatar" class="rounded-circle">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="accordion mt-3" id="accordionExample">
                    <div class="card accordion-item">
                      <h2 class="accordion-header" id="headingOne">
                        <button type="button" class="accordion-button" data-bs-toggle="collapse"
                                data-bs-target="#accordionOne" aria-expanded="true" aria-controls="accordionOne">
                          Detail Object
                        </button>
                      </h2>
                      <div id="accordionOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body pb-0">
                          <div class="table-responsive text-nowrap">
                            <table class="table table-sm">
                              <thead>
                              <tr>
                                <th>Object Name</th>
                                <th>Status</th>
                                <th>Notes</th>
                                <th>Quick Action</th>
                                <th>Visit time</th>
                              </tr>
                              </thead>
                              <tbody class="table-border-bottom-0">
                              @foreach($report->reportPatrolDetail as $detail)
                                <tr>
                                  <td><strong>{{$detail->object->name}}</strong></td>
                                  <td>
                                    @if($detail->object->name)
                                      <span class="badge bg-label-success me-1">Normal</span>
                                    @else
                                      <span class="badge bg-label-danger me-1">Abnormal</span>
                                    @endif
                                  </td>
                                  <td>
                                    <span class="text-muted small">{{$detail->patrol_note}}</span>
                                  </td>
                                  <td class="text-center">
                                    @if($detail->quick_action)
                                      <span class="badge bg-label-success me-1">Solved</span>
                                    @else
                                      <span class="badge bg-label-info me-1">-</span>
                                    @endif
                                  </td>
                                  <td>
                                    <span class="text-muted small">{{$detail->created_at}}</span>
                                  </td>
                                </tr>
                              @endforeach

                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- END LAMPIRAN -->
                </div>
              </li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('page-script')
  <script src="{{asset('assets/js/cards-actions.js')}}"></script>

  <!-- BEGIN: Page Vendor JS-->
  <script>

  </script>
@endsection
