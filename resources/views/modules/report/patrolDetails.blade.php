@extends('layouts/layoutMaster')
@section('title', 'Patroli Report')

@section('vendor-style')
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/spinkit/spinkit.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/magnific-popup/magnific-popup.css')}}"/>

@endsection
@section('vendor-script')
    <script src="{{asset('assets/js/cards-actions.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/magnific-popup/magnific-popup.min.js')}}"></script>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
            <!-- User Card -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-around flex-wrap pb-4 border-bottom">
                        <div class="d-flex align-items-start me-4 mt-3 gap-2">
                            <span class="badge bg-label-success p-2 rounded"><i
                                    class="ti ti-circle-check ti-sm"></i></span>
                            <div>
                                <p class="mb-0 fw-semibold">{{$normalObject}}</p>
                                <small>Objek Normal</small>
                            </div>
                        </div>
                        <div class="d-flex align-items-start mt-3 gap-2">
                            <span class="badge bg-label-danger p-2 rounded"><i
                                    class="ti ti-alert-circle ti-sm"></i></span>
                            <div>
                                <p class="mb-0 fw-semibold">{{$abnormalObject}}</p>
                                <small>Objek Abnormal</small>
                            </div>
                        </div>
                    </div>
                    <p class="mt-4 small text-uppercase text-muted">Details</p>
                    <div class="info-container table-responsive text-nowrap">
                        <table class="table table-borderless">
                            <tr>
                                <td width="40%">
                                    <span class="fw-semibold me-1">User</span>
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
                                    <span class="fw-semibold me-1">Jenis Patroli</span>

                                </td>
                                <td>
                                    :
                                    @if($activityPatrol->in_shift)
                                        <span class="badge bg-label-success">Mandatory Patroli</span>
                                    @else
                                        <span class="badge bg-label-success">Additional Patroli</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="fw-semibold me-1">Target Objek</span>

                                </td>
                                <td>
                                    <span>: {{$totalObject}}</span>

                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="fw-semibold me-1">Persentase</span>
                                </td>
                                <td>
                                    : <span class="badge bg-label-success">{{ round((($abnormalObject+$normalObject)/$totalObject)*100)}}%</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="fw-semibold me-1">Waktu Mulai</span>
                                </td>
                                <td>
                                    <span>: {{$activityPatrol->patrol_start_time}}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="fw-semibold me-1">Waktu Berakhir</span>
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
                                                    <td width="40%">CHECKPOINT</td>
                                                    <td>:</td>
                                                    <td>{{ $detail->objectParent->name ?? 'No Checkpoint' }}</td>
                                                </tr>
                                                <tr>
                                                    <td width="40%">Waktu Checkin</td>
                                                    <td>:</td>
                                                    <td>{{ $report->checkin_time }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Waktu Checkout</td>
                                                    <td>:</td>
                                                    <td>{{ $report->checkout_time }}</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Total Objek
                                                    </td>
                                                    <td>:</td>
                                                    <td>{{ count($report->reportPatrolDetail) }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="accordion mt-3" id="accordionExample_{{$report->id_report_patrol}}">
                                        <div class="card accordion-item">
                                            <h2 class="accordion-header" id="heading_{{$report->id_report_patrol}}">
                                                <button type="button" class="accordion-button" data-bs-toggle="collapse"
                                                        data-bs-target="#accordion_{{$report->id_report_patrol}}"
                                                        aria-expanded="true"
                                                        aria-controls="accordion_{{$report->id_report_patrol}}">
                                                    Detail Objek
                                                </button>
                                            </h2>
                                            <div id="accordion_{{$report->id_report_patrol}}"
                                                 class="accordion-collapse collapse"
                                                 data-bs-parent="#accordionExample_{{$report->id_report_patrol}}">
                                                <div class="accordion-body pb-0 px-0">
                                                    <div class="table-responsive text-nowrap">
                                                        <table class="table table-sm">
                                                            <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Nama Objek</th>
                                                                <th>Status</th>
                                                                <th>Catatan</th>
                                                                <th>Tindakan Cepat</th>
                                                                <th>Waktu Visit</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody class="table-border-bottom-0">
                                                            @foreach($report->reportPatrolDetail->sortBy('created_at') as $detail)
                                                                <tr>
                                                                    <td>
                                                                        @if(count($detail->files)>0)
                                                                            <div
                                                                                class="d-flex align-items-center avatar-group thumb_{{$detail->id_report_patrol_detail}}">

                                                                                @foreach($detail->files as $img)
                                                                                    <div class="avatar">
                                                                                        <a href="{{route('report.patrol.preview', ['path'=>$img->path])}}"
                                                                                           title="{{$detail->object->name}}"
                                                                                           data-note="{{$detail->patrol_note=="null"?"-":$detail->patrol_note}}">
                                                                                            <img
                                                                                                src="{{route('report.patrol.preview', ['path'=>$img->path])}}"
                                                                                                alt="Avatar"
                                                                                                class="rounded-circle pull-up"
                                                                                                title="{{$detail->object->name}}"
                                                                                                data-note="{{$detail->patrol_note=="null"?"-":$detail->patrol_note}}">
                                                                                        </a>
                                                                                    </div>
                                                                                @endforeach
                                                                                @push('js')

                                                                                    <script nonce="{{ csp_nonce() }}">
                                                                                        $(document).ready(function () {
                                                                                            $('.thumb_{{$detail->id_report_patrol_detail}}').magnificPopup({
                                                                                                delegate: 'a',
                                                                                                type: 'image',
                                                                                                tLoading: 'Loading image #%curr%...',
                                                                                                mainClass: 'mfp-img-mobile',
                                                                                                gallery: {
                                                                                                    enabled: true,
                                                                                                    navigateByImgClick: true,
                                                                                                    preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
                                                                                                },
                                                                                                image: {
                                                                                                    tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
                                                                                                    titleSrc: function (item) {
                                                                                                        return item.el.attr('title') + '<small>' + item.el.data('note') + '</small>';
                                                                                                    }
                                                                                                }
                                                                                            });
                                                                                        });
                                                                                    </script>
                                                                                @endpush
                                                                            </div>
                                                                        @else
                                                                            -
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <strong>{{$detail->object->name}}</strong></td>
                                                                    <td>
                                                                        @if($detail->is_normal)
                                                                            <span class="badge bg-label-success me-1">Normal</span>
                                                                        @else

                                                                            <span class="badge bg-label-danger me-1">Abnormal</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <span
                                                                            class="text-muted small">
                                                                            @if($detail->patrol_note && $detail->patrol_note!='null')
                                                                                {{$detail->patrol_note}}
                                                                            @elseif($detail->report_ga)
                                                                                Laporkan Ke PIC
                                                                            @elseif($detail->quick_action)
                                                                                {{$detail->quick_action_note}}
                                                                            @elseif($detail->is_normal)
                                                                                -
                                                                            @endif

                                                                        </span>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        @if($detail->quick_action)
                                                                            <span class="badge bg-label-success me-1">Solved</span>
                                                                        @else
                                                                            <span
                                                                                class="badge bg-label-info me-1">-</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <span
                                                                            class="text-muted small">{{$detail->created_at}}</span>
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

    <!-- BEGIN: Page Vendor JS-->
    {{--    <script nonce="{{ csp_nonce() }}">--}}
    {{--        $(document).ready(function () {--}}
    {{--            $('.parent-container').magnificPopup({--}}
    {{--                delegate: 'a',--}}
    {{--                type: 'image',--}}
    {{--                tLoading: 'Loading image #%curr%...',--}}
    {{--                mainClass: 'mfp-img-mobile',--}}
    {{--                gallery: {--}}
    {{--                    enabled: true,--}}
    {{--                    navigateByImgClick: true,--}}
    {{--                    preload: [0, 1] // Will preload 0 - before current, and 1 after the current image--}}
    {{--                },--}}
    {{--                image: {--}}
    {{--                    tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',--}}
    {{--                    titleSrc: function (item) {--}}
    {{--                        return item.el.attr('title') + '<small>' + item.el.data('note') + '</small>';--}}
    {{--                    }--}}
    {{--                }--}}
    {{--            });--}}
    {{--        });--}}
    {{--    </script>--}}

@endsection
