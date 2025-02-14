@extends('layouts.master')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Penjualan Barang</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('sale.index') }}">Penjualan</a></li>
          <li class="breadcrumb-item active">Tambah Penjualan</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<div class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- Gunakan kolom dengan ukuran yang sesuai -->
      <div class="col-12 col-lg-10">
        <div class="card card-primary card-outline">
          <div class="card-body">
            <h5 class="card-title">Form Penjualan</h5><br><br>
            <form action="{{ route('sale.store') }}" method="post">
              @csrf
              <div class="row">
                <div class="col-lg-6">
                  <!-- Client Selection -->
                  <div class="form-group">
                    <label>Client</label>
                    <select name="client_id" class="form-control" required>
                      <option value="">Pilih Client</option>
                      @foreach($clients as $client)
                        <option value="{{ $client->id }}" @selected(old('client_id') == $client->id)>
                          {{ $client->nama }}
                        </option>
                      @endforeach
                    </select>
                    @error('client_id')
                      <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>

                  <!-- Sales User Selection -->
                  <div class="form-group">
                    <label>Sales</label>
                    <select name="user_id" class="form-control" required>
                      <option value="">Pilih Sales</option>
                      @foreach($salesUsers as $salesUser)
                        <option value="{{ $salesUser->id }}" @selected(old('user_id') == $salesUser->id)>
                          {{ $salesUser->name }}
                        </option>
                      @endforeach
                    </select>
                    @error('user_id')
                      <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>

                  <!-- Gudang Selection -->
                  <div class="form-group">
                    <label>Gudang</label>
                    <select id="gudang" name="id_gudang" class="form-control" required>
                      <option value="">Pilih Gudang</option>
                      @foreach($gudangs as $gudang)
                        <option value="{{ $gudang->id }}" @selected(old('id_gudang') == $gudang->id)>
                          {{ $gudang->nama }}
                        </option>
                      @endforeach
                    </select>
                    @error('id_gudang')
                      <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>

                  <!-- Tanggal -->
                  <div class="form-group">
                    <label>Tanggal</label>
                    <input name="tanggal" type="date" class="form-control" value="{{ old('tanggal') }}" required>
                    @error('tanggal')
                      <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                </div>
                <!-- Jika diperlukan, kolom kedua bisa ditambahkan di sini -->
              </div>

              <h5 class="mt-4">Barang</h5>
              <table class="table table-bordered datatable" id="stok-table">
                <thead>
                  <tr>
                    <th>Barang</th>
                    <th>Harga</th>
                    <th>Kuantitas</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody id="stok-container">
                  @php
                    $oldStok = old('stok', [['id_barang' => '', 'kuantitas' => '']]);
                  @endphp
                  @foreach($oldStok as $index => $stok)
                  <tr class="stok-row">
                    <td>
                      <select name="stok[{{ $index }}][id_barang]" class="form-control barang-dropdown" required>
                        <option value="">Pilih Barang</option>
                        @if(old('id_gudang'))
                          @php $selectedGudang = $gudangs->find(old('id_gudang')); @endphp
                          @if($selectedGudang)
                            @foreach($selectedGudang->jumlahstok as $stokGudang)
                              <option value="{{ $stokGudang->barang->id }}"
                                data-harga="{{ $stokGudang->barang->harga }}"
                                @selected($stok['id_barang'] == $stokGudang->barang->id)>
                                {{ $stokGudang->barang->nama }}
                              </option>
                            @endforeach
                          @endif
                        @endif
                      </select>
                    </td>
                    <td>
                      <input type="text" class="form-control harga-display" readonly>
                    </td>
                    <td>
                      <input name="stok[{{ $index }}][kuantitas]" type="number" class="form-control qty-input" min="1" placeholder="Masukkan Kuantitas" value="{{ $stok['kuantitas'] }}">
                    </td>
                    <td>
                      <input type="text" class="form-control subtotal-display" readonly>
                    </td>
                    <td>
                      @if($index > 0)
                        <button type="button" class="btn btn-danger remove-stok">
                          <i class="fa fa-solid fa-trash me-2"></i>
                        </button>
                      @endif
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              <button type="button" class="btn btn-success mt-3" id="add-stok">
                Tambah Barang
              </button>
              <div class="form-group mt-3">
                <label>Total</label>
                <input type="text" class="form-control" id="total-display" readonly>
                <input type="hidden" name="total" id="total">
              </div>
              <button type="submit" class="btn btn-primary my-3">
                <i class="fa fa-save"></i> Submit
              </button>
            </form>
          </div><!-- /.card-body -->
        </div><!-- /.card -->
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div><!-- /.content -->

<!-- Script-skrip tetap (JS kalkulator, loadBarang, updateRow, dll) -->
<script>
  const barangPerGudang = @json($gudangs->mapWithKeys(function($gudang) {
    return [$gudang->id => $gudang->jumlahstok->map(function($stok) {
      return [
        'id' => $stok->barang->id,
        'nama' => $stok->barang->nama,
        'harga' => $stok->barang->harga
      ];
    })];
  }));

  function loadBarang(gudangId, dropdown, selectedId = '') {
    dropdown.innerHTML = '<option value="">Pilih Barang</option>';
    if (barangPerGudang[gudangId]) {
      barangPerGudang[gudangId].forEach(barang => {
        const selected = barang.id == selectedId ? 'selected' : '';
        dropdown.innerHTML += `<option value="${barang.id}" data-harga="${barang.harga}" ${selected}>${barang.nama}</option>`;
      });
    }
  }

  document.getElementById('gudang').addEventListener('change', function () {
    const gudangId = this.value;
    document.querySelectorAll('.barang-dropdown').forEach(dropdown => {
      loadBarang(gudangId, dropdown);
    });
    document.querySelectorAll('.stok-row').forEach(row => {
      updateRow(row);
    });
  });

  let stokIndex = {{ count($oldStok) }};
  document.getElementById('add-stok').addEventListener('click', function () {
    const container = document.getElementById('stok-container');
    const newRow = document.createElement('tr');
    newRow.classList.add('stok-row');
    newRow.innerHTML = `
      <td>
        <select name="stok[${stokIndex}][id_barang]" class="form-control barang-dropdown" required>
          <option value="">Pilih Barang</option>
        </select>
      </td>
      <td>
        <input type="text" class="form-control harga-display" readonly>
      </td>
      <td>
        <input name="stok[${stokIndex}][kuantitas]" type="number" class="form-control qty-input" min="1" placeholder="Masukkan Kuantitas">
      </td>
      <td>
        <input type="text" class="form-control subtotal-display" readonly>
      </td>
      <td>
        <button type="button" class="btn btn-danger remove-stok">
          <i class="fa fa-solid fa-trash me-2"></i>
        </button>
      </td>
    `;
    container.appendChild(newRow);
    const gudangId = document.getElementById('gudang').value;
    const dropdown = newRow.querySelector('.barang-dropdown');
    loadBarang(gudangId, dropdown);
    stokIndex++;
  });

  document.addEventListener('click', function (e) {
    if (e.target && e.target.classList.contains('remove-stok')) {
      e.target.closest('.stok-row').remove();
      updateTotal();
    }
  });

  function formatRupiah(number) {
    return 'Rp. ' + new Intl.NumberFormat('id-ID').format(number);
  }

  function updateRow(row) {
    const barangSelect = row.querySelector('.barang-dropdown');
    const hargaDisplay = row.querySelector('.harga-display');
    const qtyInput = row.querySelector('.qty-input');
    const subtotalDisplay = row.querySelector('.subtotal-display');

    const selectedOption = barangSelect.options[barangSelect.selectedIndex];
    let harga = selectedOption && selectedOption.dataset.harga
                ? parseFloat(selectedOption.dataset.harga)
                : 0;
    hargaDisplay.value = formatRupiah(harga);

    let qty = parseFloat(qtyInput.value) || 0;
    let subtotal = harga * qty;
    subtotalDisplay.value = formatRupiah(subtotal);

    updateTotal();
  }

  function updateTotal() {
    let total = 0;
    document.querySelectorAll('.stok-row').forEach(row => {
      const subtotalDisplay = row.querySelector('.subtotal-display');
      let subtotalStr = subtotalDisplay.value.replace(/[^0-9]/g, '');
      let subtotal = parseFloat(subtotalStr) || 0;
      total += subtotal;
    });
    document.getElementById('total-display').value = formatRupiah(total);
    document.getElementById('total').value = total;
  }

  document.addEventListener('change', function(e) {
    if (e.target && e.target.classList.contains('barang-dropdown')) {
      updateRow(e.target.closest('.stok-row'));
    }
  });
  document.addEventListener('input', function(e) {
    if (e.target && e.target.classList.contains('qty-input')) {
      updateRow(e.target.closest('.stok-row'));
    }
  });

  document.addEventListener('DOMContentLoaded', function () {
    const gudangId = document.getElementById('gudang').value;
    document.querySelectorAll('.barang-dropdown').forEach((dropdown, index) => {
      const oldStok = {!! json_encode(old('stok')) !!} || [];
      const selectedId = oldStok[index] ? oldStok[index]['id_barang'] : '';
      loadBarang(gudangId, dropdown, selectedId);
      updateRow(dropdown.closest('.stok-row'));
    });
  });
</script>
@endsection
