<!-- REQUIRED SCRIPTS -->
@vite('resources/js/app.js')
<!-- jQuery -->
<script src="{{asset('admin/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('admin/dist/js/adminlte.min.js')}}"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/fontawesome-free-6.2.1@6.2.1/js/all.min.js"></script> --}}
<!-- DataTables -->
<script src="{{asset('admin/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ asset('admin/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{ asset('admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{ asset('amdmin/plugins/chart.js/Chart.min.js')}}"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
    $(".datatable").DataTable({
      "responsive": true,
      "autoWidth": false,
    });

    $('.sa-delete').on('click', function () {
      let form_id = $(this).data('form-id');
      swal({
        title: "Menghapus data ini?",
        text: "Anda tidak dapat mengembalikan data",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $('#'+form_id).submit();
          swal("Anda Berhasil menghapus data!", {
            icon: "success",
          });
        } else {
          swal("Anda membatalkan proses hapus!");
        }
      })
    })
</script>
<script>

  let defaultLat = {{ $item->latitude ?? -7.250445 }};
  let defaultLng = {{ $item->longitude ?? 112.768845 }};

  let map = L.map('map').setView([defaultLat, defaultLng], 13);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 18,
      attribution: '© OpenStreetMap'
  }).addTo(map);

  let marker;
  if ({{ isset($item->latitude) && isset($item->longitude) ? 'true' : 'false' }}) {
      marker = L.marker([defaultLat, defaultLng]).addTo(map);
  }

  map.on('click', function(e) {
      let lat = e.latlng.lat;
      let lng = e.latlng.lng;
      if (marker) {
          map.removeLayer(marker);
      }

      marker = L.marker([lat, lng]).addTo(map);

      fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&addressdetails=1`)
          .then(response => response.json())
          .then(data => {
              let address = data.address;

              let formattedAddress = [
                  address.road,
                  address.neighbourhood,
                  address.suburb,
                  address.city || address.town || address.village,
                  address.state,
              ].filter(Boolean).join(', ');
              document.getElementById('alamat').value = formattedAddress || `${lat}, ${lng}`;
          })
          .catch(error => {
              console.error('Error fetching address:', error);
              document.getElementById('alamat').value = `${lat}, ${lng}`; 
          });
  });
</script>
<script>
    document.getElementById('toggle-password').addEventListener('click', function () {
        const passwordInput = document.getElementById('password');
        const icon = this;

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
</script>

<script>
    $(document).ready(function () {
    $('.info').hover(
        function () {
            $(this).find('.user-card').fadeIn(200); // Menampilkan card saat hover
        },
        function () {
            $(this).find('.user-card').fadeOut(200); // Menyembunyikan card saat pointer keluar
        }
    );
});

</script>
@stack('scripts')