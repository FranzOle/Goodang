<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
<title>{{config('app.name')}}</title>

<!-- Font Awesome Icons -->
<link rel="stylesheet" href="{{asset('admin/plugins/fontawesome-free/css/all.min.css')}}">
<!-- Theme style -->
<link rel="stylesheet" href="{{asset('admin/dist/css/adminlte.min.css')}}">
{{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/flat-ui/2.3.0/css/flat-ui.min.css" rel="stylesheet"/> --}}
<!-- Google Font: Source Sans Pro -->
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{ asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fontawesome-free-6.2.1@6.2.1/css/all.min.css"> --}}
<!--Datatable -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
crossorigin=""/>

<style>
    /* Sembunyikan user-card secara default */
    .user-card {
        display: none;
        transition: opacity 0.3s ease-in-out;
    }
  
    /* Tampilkan user-card saat hover */
    .user-panel:hover .user-card {
        display: block;
        opacity: 1;
    }
  
    /* Atur posisi user-card */
    .user-panel {
        position: relative;
    }
  
    .user-card {
        position: absolute;
        top: 100%; /* Tampilkan di bawah user-panel */
        left: 0;
        width: 250px;
        z-index: 9999;
        background-color: #fff;
        border: 1px solid #ddd;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        padding: 10px;
        border-radius: 5px;
    }
  
    /* Optional: Tambahkan animasi muncul */
    .user-card {
        opacity: 0;
        pointer-events: none;
    }
  
    .user-panel:hover .user-card {
        pointer-events: auto;
        opacity: 1;
    }
  </style>
  


@stack('css')