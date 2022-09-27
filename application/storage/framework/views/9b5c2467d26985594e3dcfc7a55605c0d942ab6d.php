<?php $__env->startSection('content'); ?>
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



                                </div>
                            </div>
                            <div class="block-content">
                                <ul class="nav nav-pills flex-column fs-sm push">
                                    <li class="nav-item my-1">
                                        <a class="nav-link d-flex justify-content-between align-items-center active" href="<?php echo e(route('applicant.inbox')); ?>">
                          <span>
                            <i class="fa fa-fw fa-inbox me-1 opacity-50"></i> Inbox
                          </span>
                                            <span class="badge rounded-pill bg-black-50"><?php echo e(count($notification)); ?></span>
                                        </a>
                                    </li>








                                </ul>
                            </div>
                        </div>
                        <!-- END Inbox Menu -->

                        <!-- Friends -->










































































                        <!-- END Friends -->

                        <!-- Account -->































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
                                        <?php $__currentLoopData = $notification; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td class="d-none d-sm-table-cell fw-semibold" style="width: 140px;">
                                                    <?php if($message->role_id == 1): ?>
                                                        Registrar AA
                                                    <?php elseif($message->role_id == 2): ?>
                                                        Chairman of Department
                                                    <?php elseif($message->role_id == 3): ?>
                                                        Student Finance
                                                    <?php else: ?>
                                                        Dean of Student
                                                    <?php endif; ?>

                                                </td>
                                                <td>
                                                    <a class="fw-semibold" data-bs-toggle="modal" data-bs-target="#one-inbox-message" href="#"><?php echo e($message->subject); ?></a>
                                                    <div class="text-muted mt-1"><?php echo e($message->comment); ?></div>
                                                </td>
                                                <td class="d-none d-xl-table-cell text-muted" style="width: 80px;">
                                                    <i class="fa fa-paperclip me-1"></i> (3)
                                                </td>
                                                <td class="d-none d-xl-table-cell text-muted" style="width: 120px;">
                                                    <em><?php echo e(\Carbon\Carbon::parse($message->created_at)->diffForHumans()); ?></em>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

<?php $__env->stopSection(); ?>

<?php echo $__env->make('application::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sims\application\Modules/Application\Resources/views/applicant/inbox.blade.php ENDPATH**/ ?>