@extends('approval::layouts.backend')
@section('content')
    <!-- Page Content -->

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('css/index.css') }}" rel="stylesheet" />
    <script src = "{{ asset('js/plugins/chart.js/Chart.min.js') }}" ></script>
    <script src = "{{ asset('js/utils.js') }}" ></script>
    <script src = "{{ asset('jquery.js') }}" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <div class="content-force">
        <div class="row">
            PENDING
        </div>
    </div>
    <!-- END Page Content -->

    <script src = "{{ asset('js/build.js') }}"></script>
    <script>
        retrieveApplication({"status" : 0, "role" : 4});
    </script>
@endsection
