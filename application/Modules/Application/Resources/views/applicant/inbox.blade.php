@extends('application::layouts.backend')

@section('content')
    <!-- Main Container -->
    <main id="main-container">
        <!-- Page Content -->
        <div class="content">
            <div class="row">
                <div class="col-md-5 col-xl-3">
                    <!-- Toggle Inbox Side Navigation -->
                    <div class="d-md-none push">
                        <!-- Class Toggle, functionality initialized in Helpers.oneToggleClass() -->
                        <button type="button" class="btn w-100 btn-primary" data-toggle="class-toggle" data-target="#one-inbox-side-nav" data-class="d-none">
                            Inbox Menu
                        </button>
                    </div>
                    <!-- END Toggle Inbox Side Navigation -->

                    <!-- Inbox Side Navigation -->
                    <div id="one-inbox-side-nav" class="d-none d-md-block push">
                        <!-- Inbox Menu -->
                        <div class="block block-rounded">
                            <div class="block-header block-header-default">
                                <h3 class="block-title">Inbox</h3>
                                <div class="block-options">
{{--                                    <button type="button" class="btn btn-sm btn-alt-primary" data-bs-toggle="modal" data-bs-target="#one-inbox-new-message">--}}
{{--                                        <i class="fa fa-pencil-alt me-1 opacity-50"></i> Compose--}}
{{--                                    </button>--}}
                                </div>
                            </div>
                            <div class="block-content">
                                <ul class="nav nav-pills flex-column fs-sm push">
                                    <li class="nav-item my-1">
                                        <a class="nav-link d-flex justify-content-between align-items-center active" href="{{ route('applicant.inbox') }}">
                          <span>
                            <i class="fa fa-fw fa-inbox me-1 opacity-50"></i> Inbox
                          </span>
                                            <span class="badge rounded-pill bg-black-50">{{ count($notification) }}</span>
                                        </a>
                                    </li>
{{--                                    <li class="nav-item my-1">--}}
{{--                                        <a class="nav-link d-flex justify-content-between align-items-center" href="javascript:void(0)">--}}
{{--                          <span>--}}
{{--                            <i class="fa fa-fw fa-star me-1 opacity-50"></i> Starred--}}
{{--                          </span>--}}
{{--                                            <span class="badge rounded-pill bg-black-50">48</span>--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
                                </ul>
                            </div>
                        </div>
                        <!-- END Inbox Menu -->

                        <!-- Friends -->
{{--                        <div class="block block-rounded">--}}
{{--                            <div class="block-header block-header-default">--}}
{{--                                <h3 class="block-title">Friends</h3>--}}
{{--                                <div class="block-options">--}}
{{--                                    <button type="button" class="btn-block-option">--}}
{{--                                        <i class="si si-settings"></i>--}}
{{--                                    </button>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="block-content">--}}
{{--                                <ul class="nav-items fs-sm">--}}
{{--                                    <li>--}}
{{--                                        <a class="d-flex py-2" href="javascript:void(0)">--}}
{{--                                            <div class="flex-shrink-0 me-3 ms-2 overlay-container overlay-bottom">--}}
{{--                                                <img class="img-avatar img-avatar48" src="assets/media/avatars/avatar4.jpg" alt="">--}}
{{--                                                <span class="overlay-item item item-tiny item-circle border border-2 border-white bg-success"></span>--}}
{{--                                            </div>--}}
{{--                                            <div class="flex-grow-1">--}}
{{--                                                <div class="fw-semibold">Carol White</div>--}}
{{--                                                <div class="fw-normal text-muted">Web Designer</div>--}}
{{--                                            </div>--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                    <li>--}}
{{--                                        <a class="d-flex py-2" href="javascript:void(0)">--}}
{{--                                            <div class="flex-shrink-0 me-3 ms-2 overlay-container overlay-bottom">--}}
{{--                                                <img class="img-avatar img-avatar48" src="assets/media/avatars/avatar10.jpg" alt="">--}}
{{--                                                <span class="overlay-item item item-tiny item-circle border border-2 border-white bg-success"></span>--}}
{{--                                            </div>--}}
{{--                                            <div class="flex-grow-1">--}}
{{--                                                <div class="fw-semibold">Jesse Fisher</div>--}}
{{--                                                <div class="fw-normal text-muted">Graphic Designer</div>--}}
{{--                                            </div>--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                    <li>--}}
{{--                                        <a class="d-flex py-2" href="javascript:void(0)">--}}
{{--                                            <div class="flex-shrink-0 me-3 ms-2 overlay-container overlay-bottom">--}}
{{--                                                <img class="img-avatar img-avatar48" src="assets/media/avatars/avatar8.jpg" alt="">--}}
{{--                                                <span class="overlay-item item item-tiny item-circle border border-2 border-white bg-warning"></span>--}}
{{--                                            </div>--}}
{{--                                            <div class="flex-grow-1">--}}
{{--                                                <div class="fw-semibold">Amber Harvey</div>--}}
{{--                                                <div class="fw-normal text-muted">Photographer</div>--}}
{{--                                            </div>--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                    <li>--}}
{{--                                        <a class="d-flex py-2" href="javascript:void(0)">--}}
{{--                                            <div class="flex-shrink-0 me-3 ms-2 overlay-container overlay-bottom">--}}
{{--                                                <img class="img-avatar img-avatar48" src="assets/media/avatars/avatar13.jpg" alt="">--}}
{{--                                                <span class="overlay-item item item-tiny item-circle border border-2 border-white bg-warning"></span>--}}
{{--                                            </div>--}}
{{--                                            <div class="flex-grow-1">--}}
{{--                                                <div class="fw-semibold">Brian Cruz</div>--}}
{{--                                                <div class="fw-normal text-muted">Copywriter</div>--}}
{{--                                            </div>--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                    <li>--}}
{{--                                        <a class="d-flex py-2" href="javascript:void(0)">--}}
{{--                                            <div class="flex-shrink-0 me-3 ms-2 overlay-container overlay-bottom">--}}
{{--                                                <img class="img-avatar img-avatar48" src="assets/media/avatars/avatar12.jpg" alt="">--}}
{{--                                                <span class="overlay-item item item-tiny item-circle border border-2 border-white bg-danger"></span>--}}
{{--                                            </div>--}}
{{--                                            <div class="flex-grow-1">--}}
{{--                                                <div class="fw-semibold">David Fuller</div>--}}
{{--                                                <div class="fw-normal text-muted">UI designer</div>--}}
{{--                                            </div>--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                </ul>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <!-- END Friends -->

                        <!-- Account -->
{{--                        <div class="block block-rounded">--}}
{{--                            <div class="block-header block-header-default">--}}
{{--                                <h3 class="block-title">Account</h3>--}}
{{--                                <div class="block-options">--}}
{{--                                    <button type="button" class="btn-block-option">--}}
{{--                                        <i class="si si-settings"></i>--}}
{{--                                    </button>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="block-content">--}}
{{--                                <!-- Easy Pie Chart (.js-pie-chart class is initialized in Helpers.jqEasyPieChart()) -->--}}
{{--                                <!-- For more info and examples you can check out http://rendro.github.io/easy-pie-chart/ -->--}}
{{--                                <!-- Pie Chart Container -->--}}
{{--                                <div class="js-pie-chart pie-chart push" data-percent="35" data-line-width="3" data-size="100" data-bar-color="#abe37d" data-track-color="#eeeeee" data-scale-color="#dddddd">--}}
{{--                      <span>--}}
{{--                        <img class="img-avatar" src="assets/media/avatars/avatar6.jpg" alt="">--}}
{{--                      </span>--}}
{{--                                </div>--}}
{{--                                <a class="block block-rounded block-bordered block-link-shadow" href="javascript:void(0)">--}}
{{--                                    <div class="block-content block-content-full text-center">--}}
{{--                                        <div class="push">--}}
{{--                                            <i class="si si-like fa-2x text-success"></i>--}}
{{--                                        </div>--}}
{{--                                        <div class="fs-2 fw-bold">--}}
{{--                                            <span class="text-muted">+</span> 2.5TB--}}
{{--                                        </div>--}}
{{--                                        <div class="fs-sm text-muted text-uppercase">Upgrade Now</div>--}}
{{--                                    </div>--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <!-- END Account -->
                    </div>
                    <!-- END Inbox Side Navigation -->
                </div>
                <div class="col-md-7 col-xl-9">
                    <!-- Message List -->
                    <div class="block block-rounded">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">
                                Messages
                            </h3>
                        </div>
                        <div class="block-content py-0"><!-- Messages and Checkable Table (.js-table-checkable class is initialized in Helpers.oneTableToolsCheckable()) -->
                            <div class="pull-x">
                                <table class="js-table-checkable table table-hover table-vcenter fs-sm">
                                    <tbody>
                                        @foreach($notification as $message)
                                            <tr>
                                                <td class="d-none d-sm-table-cell fw-semibold" style="width: 140px;">
                                                    @if($message->role_id == 1)
                                                        Registrar AA
                                                    @elseif($message->role_id == 2)
                                                        Chairman of Department
                                                    @elseif($message->role_id == 3)
                                                        Student Finance
                                                    @else
                                                        Dean of Student
                                                    @endif

                                                </td>
                                                <td>
                                                    <a class="fw-semibold" data-bs-toggle="modal" data-bs-target="#one-inbox-message" href="#">{{ $message->subject }}</a>
                                                    <div class="text-muted mt-1">{{ $message->comment }}</div>
                                                </td>
                                                <td class="d-none d-xl-table-cell text-muted" style="width: 80px;">
                                                    <i class="fa fa-paperclip me-1"></i> (3)
                                                </td>
                                                <td class="d-none d-xl-table-cell text-muted" style="width: 120px;">
                                                    <em>{{ \Carbon\Carbon::parse($message->created_at)->diffForHumans() }}</em>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- END Messages and Checkable Table -->
                        </div>
                    </div>
                    <!-- END Message List -->
                </div>
            </div>

            <!-- New Message Modal -->
            <div class="modal fade" id="one-inbox-new-message" tabindex="-1" role="dialog" aria-labelledby="one-inbox-new-message" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="be_pages_generic_inbox.html" method="POST" onsubmit="return false;">
                            <div class="block block-rounded block-transparent mb-0">
                                <div class="block-header block-header-default">
                                    <h3 class="block-title">
                                        <i class="fa fa-pencil-alt me-1"></i> New Message
                                    </h3>
                                    <div class="block-options">
                                        <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                            <i class="fa fa-fw fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="block-content">
                                    <div class="mb-4">
                                        <label class="form-label" for="message-email">Email</label>
                                        <input class="form-control form-control-alt" type="email" id="message-email" name="message-email">
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label" for="message-subject">Subject</label>
                                        <input class="form-control form-control-alt" type="text" id="message-subject" name="message-subject">
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label" for="message-msg">Message</label>
                                        <textarea class="form-control form-control-alt" id="message-msg" name="message-msg" rows="6"></textarea>
                                        <div class="form-text">Feel free to use common tags: &lt;blockquote&gt;, &lt;strong&gt;, &lt;em&gt;</div>
                                    </div>
                                </div>
                                <div class="block-content block-content-full text-end bg-body">
                                    <button type="button" class="btn btn-sm btn-alt-secondary me-1" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        <i class="fa fa-paper-plane me-1 opacity-50"></i> Send Message
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- END New Message Modal -->

            <!-- Message Modal -->
            <div class="modal fade" id="one-inbox-message" tabindex="-1" role="dialog" aria-labelledby="one-inbox-message" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-popout" role="document">
                    <div class="modal-content">
                        <div class="block block-rounded block-transparent mb-0">
                            <div class="block-header block-header-default">
                                <h3 class="block-title">Welcome to our service</h3>
                                <div class="block-options">
                                    <button type="button" class="btn-block-option" data-bs-toggle="tooltip" data-bs-placement="left" title="Reply" aria-label="Reply">
                                        <i class="fa fa-fw fa-reply"></i>
                                    </button>
                                    <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                        <i class="fa fa-fw fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="block-content block-content-full text-center bg-image" style="background-image: url('assets/media/photos/photo7.jpg');">
                                <img class="img-avatar img-avatar96 img-avatar-thumb" src="assets/media/avatars/avatar4.jpg" alt="">
                            </div>
                            <div class="block-content block-content-full fs-sm d-flex justify-content-between bg-body-light">
                                <a href="javascript:void(0)">user@example.com</a>
                                <span class="text-muted"><em>2 min ago</em></span>
                            </div>
                            <div class="block-content">
                                <p>Dear John,</p>
                                <p>Dolor posuere proin blandit accumsan senectus netus nullam curae, ornare laoreet adipiscing luctus mauris adipiscing pretium eget fermentum, tristique lobortis est ut metus lobortis tortor tincidunt himenaeos habitant quis dictumst proin odio sagittis purus mi, nec taciti vestibulum quis in sit varius lorem sit metus mi.</p>
                                <p>Dolor posuere proin blandit accumsan senectus netus nullam curae, ornare laoreet adipiscing luctus mauris adipiscing pretium eget fermentum, tristique lobortis est ut metus lobortis tortor tincidunt himenaeos habitant quis dictumst proin odio sagittis purus mi, nec taciti vestibulum quis in sit varius lorem sit metus mi.</p>
                                <p>Best Regards,</p>
                                <p>Amanda Powell</p>
                            </div>
                            <div class="block-content bg-body-light">
                                <div class="row g-sm items-push fs-sm">
                                    <div class="col-md-4">
                                        <div class="options-container fx-item-zoom-in mb-2">
                                            <img class="img-fluid options-item" src="assets/media/photos/photo1.jpg" alt="">
                                            <div class="options-overlay bg-black-75">
                                                <div class="options-overlay-content">
                                                    <a class="btn btn-sm btn-light" href="javascript:void(0)">
                                                        <i class="fa fa-download me-1"></i> Download
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-muted">01.jpg (350kb)</div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="options-container fx-item-zoom-in mb-2">
                                            <img class="img-fluid options-item" src="assets/media/photos/photo2.jpg" alt="">
                                            <div class="options-overlay bg-black-75">
                                                <div class="options-overlay-content">
                                                    <a class="btn btn-sm btn-light" href="javascript:void(0)">
                                                        <i class="fa fa-download me-1"></i> Download
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-muted">02.jpg (480kb)</div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="options-container fx-item-zoom-in mb-2">
                                            <img class="img-fluid options-item" src="assets/media/photos/photo3.jpg" alt="">
                                            <div class="options-overlay bg-black-75">
                                                <div class="options-overlay-content">
                                                    <a class="btn btn-sm btn-light" href="javascript:void(0)">
                                                        <i class="fa fa-download me-1"></i> Download
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-muted">03.jpg (652kb)</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Message Modal -->
        </div>
        <!-- END Page Content -->
    </main>
    <!-- END Main Container -->

@endsection
