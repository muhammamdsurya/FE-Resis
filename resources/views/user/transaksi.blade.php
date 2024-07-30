@extends('layout.userLayout')
@section('title', $title)

@section('content')
    <div class="container-fluid">
        <section class="col-12 mt-2">
            <div class="row">
                <div class="col-md-4">
                    <button id="btn-pending" class="btn btn-outline-primary btn-block mb-3">Pending</button>
                </div>
                <div class="col-md-4">
                    <button id="btn-dibeli" class="btn btn-primary btn-block mb-3">Dibeli</button>
                </div>
                <div class="col-md-4">
                    <button id="btn-selesai" class="btn btn-outline-primary btn-block mb-3">Selesai</button>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-6">
                    <div class="card" style="width: 100%;">
                        <img src="{{asset('assets/img/values-1.png') }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <div class="header-card d-flex justify-content-between">
                                <p class="mr-auto small"><i class="fas fa-star text-warning mr-2"></i>4.9</p>
                                <p class="ml-auto small">Berakhir Tanggal : 28/12/2025</p>
                            </div>

                            <h5 class="card-title">Praktikum Laboratorium Dasar</h5>
                            <p class="card-text mt-1">mengajarkan keterampilan dasar laboratorium, seperti...</p>
                            <a href="#" class="btn btn-primary">Lihat <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
    //     $(document).ready(function() {
    //         function loadData(status, containerId) {
    //             $.ajax({
    //                 url: "{{ url('/transaksi') }}/" + status,
    //                 type: 'GET',
    //                 success: function(response) {
    //                     var tasks = response.tasks;
    //                     var taskCardsHtml = '';

    //                     tasks.forEach(function(task) {
    //                         taskCardsHtml += `
    //                             <div class="card mb-3">
    //                                 <div class="card-body">
    //                                     <h5 class="card-title">${task.title}</h5>
    //                                     <p class="card-text">${task.description}</p>
    //                                 </div>
    //                             </div>
    //                         `;
    //                     });

    //                     $('#' + containerId).html(taskCardsHtml);
    //                 },
    //                 error: function(xhr, status, error) {
    //                     console.error(error);
    //                 }
    //             });
    //         }

    //         $('#btn-pending').click(function() {
    //             loadData('pending', 'pending-tasks');
    //         });

    //         $('#btn-dibeli').click(function() {
    //             loadData('dibeli', 'dibeli-tasks');
    //         });

    //         $('#btn-selesai').click(function() {
    //             loadData('selesai', 'selesai-tasks');
    //         });
    //     });
    // </script>
@endsection
