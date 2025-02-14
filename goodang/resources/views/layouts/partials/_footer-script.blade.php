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
<!-- Select2 -->

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

<script>
  document.getElementById('generate-sku').addEventListener('click', function () {
      const randomDigits = () => Math.floor(100000000 + Math.random() * 900000000);
      const randomTwoDigits = () => Math.floor(10 + Math.random() * 90);
      const sku = `BRG-${randomDigits()}`;
      document.getElementById('kode_sku').value = sku;
  });
</script>

<script>
  document.getElementById('generate-referensi').addEventListener('click', function () {
    const randomDigits = () => Math.floor(100000000 + Math.random() * 900000000);
    const referensi = `TRX-${randomDigits()}`;
    document.getElementById('kode_referensi').value = referensi;
  });
</script>

<script>
  function formatRupiah(angka) {
      let number_string = angka.toString(),
          sisa = number_string.length % 3,
          rupiah = number_string.substr(0, sisa),
          ribuan = number_string.substr(sisa).match(/\d{3}/g);
  
      if (ribuan) {
          let separator = sisa ? '.' : '';
          rupiah += separator + ribuan.join('.');
      }
  
      return 'Rp ' + rupiah;
  }

  document.querySelectorAll('.format-harga').forEach(function(element) {
      // Ambil nilai harga dari atribut data-harga
      let harga = element.getAttribute('data-harga');
      
      // Format harga ke Rupiah
      if (harga) {
          element.textContent = formatRupiah(harga);
      }
  });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/libphonenumber-js/1.10.13/libphonenumber-js.min.js"></script>


<script>
      const teleponInput = document.getElementById("telepon");

      teleponInput.addEventListener("input", function () {
          let numbers = this.value.replace(/\D/g, ""); // Hapus semua karakter non-digit

          // Kosongkan input jika tidak ada angka
          if (numbers === '') {
              this.value = '';
              return;
          }

          // Handle nomor yang dimulai dengan 0
          if (numbers.startsWith("0")) {
              numbers = "62" + numbers.substring(1);
          } 
          // Pastikan nomor selalu dimulai dengan 62
          else if (!numbers.startsWith("62")) {
              numbers = "62" + numbers;
          }

          let formatted = '+62';
          const digits = numbers.substring(2); // Ambil angka setelah 62

          if (digits) {
              // Format angka menjadi kelompok 3 digit dengan hyphen
              formatted += ' ' + digits.replace(/(\d{3})(?=\d)/g, '$1-');
          }

          // Update nilai input
          this.value = formatted;
      });
</script>

@stack('scripts')