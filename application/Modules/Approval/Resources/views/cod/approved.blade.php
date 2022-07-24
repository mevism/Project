@extends('approval::layouts.backend')
@section('content')
    <!-- Page Content -->
    <!-- Approved Page -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('css/index.css') }}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.2.0/css/rowGroup.dataTables.min.css">

    <script src = "{{ asset('js/jquery.js') }}" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>

    <div class="bg-body-light">
        <div class="content content-full">
            <div class = "d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h5 fw-bold mb-2">
                        APPROVALS
                    </h1>
                </div>
                <nav class = "flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label = "breadcrumb">
                    <ol class = "breadcrumb breadcrumb-alt">
                        <li class = "breadcrumb-item">
                            <a class = "link-fx" href = "javascript:void(0)">Location</a>
                        </li>
                        <li class = "breadcrumb-item" aria-current = "page">
                            APPROVED
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="content-force">
        <div class="row">
            APPROVED
        </div>
    </div>
    <!-- END Page Content -->

    <script src = "{{ asset('js/build.js') }}"></script>
    <script>
        retrieveApplication({"status" : 1, "role" : 2});
    </script>
@endsection
