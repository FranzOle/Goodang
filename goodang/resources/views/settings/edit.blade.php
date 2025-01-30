@extends('layouts.master')
@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edit Pengaturan Website</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.index') }}">Pengaturan Website</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-10">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <h5 class="card-title">Form Edit Pengaturan</h5><br>

                        <!-- Form Edit Pengaturan -->
                        <form action="{{ route('settings.update', $setting->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Sidebar Theme -->
                            <div class="form-group">
                                <label for="sidebar_theme">Tema Sidebar</label>
                                <div>
                                    @foreach($availableThemes as $theme)
                                        <button type="button" class="btn btn-{{ $theme }} btn-sm theme-selector"
                                            data-theme="{{ $theme }}"
                                            style="margin-right: 5px; {{ $setting->sidebar_theme == $theme ? 'border: 2px solid black;' : '' }}">
                                            {{ ucfirst($theme) }}
                                        </button>
                                    @endforeach
                                </div>
                                <input type="hidden" id="sidebar_theme" name="sidebar_theme" value="{{ $setting->sidebar_theme }}">
                            </div>

                            <!-- Overall Theme -->
                            <div class="form-group">
                                <label for="overall_theme">Tema Keseluruhan</label>
                                <div>
                                    @foreach($availableThemes as $theme)
                                        <button type="button" class="btn btn-{{ $theme }} btn-sm theme-selector"
                                            data-theme="{{ $theme }}"
                                            style="margin-right: 5px; {{ $setting->overall_theme == $theme ? 'border: 2px solid black;' : '' }}">
                                            {{ ucfirst($theme) }}
                                        </button>
                                    @endforeach
                                </div>
                                <input type="hidden" id="overall_theme" name="overall_theme" value="{{ $setting->overall_theme }}">
                            </div>

                            <!-- Terms and Conditions -->
                            <div class="form-group">
                                <label for="terms_and_conditions">Peraturan Penggunaan</label>
                                <textarea id="terms_and_conditions" name="terms_and_conditions" class="form-control" rows="4">{{ $setting->terms_and_conditions }}</textarea>
                            </div>

                            <!-- Upload Terms File -->
                            <div class="form-group">
                                <label for="terms_file">Upload File Peraturan (PDF/DOC)</label>
                                <input type="file" id="terms_file" name="terms_file" class="form-control-file">
                                @if($setting->terms_file)
                                    <a href="{{ Storage::url($setting->terms_file) }}" target="_blank">Lihat File</a>
                                @endif
                            </div>

                            <!-- Admin Phone -->
                            <div class="form-group">
                                <label for="admin_phone">Nomor Pengelola</label>
                                <input type="text" id="admin_phone" name="admin_phone" class="form-control" value="{{ $setting->admin_phone }}">
                            </div>

                            <!-- Upload Company Logo -->
                            <div class="form-group">
                                <label for="company_logo">Logo Perusahaan</label>
                                <input type="file" id="company_logo" name="company_logo" class="form-control-file">
                                @if($setting->company_logo)
                                    <div class="mt-2">
                                        <img src="{{ Storage::url($setting->company_logo) }}" alt="Logo Perusahaan" style="width: 100px; height: auto;">
                                    </div>
                                @endif
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            <a href="{{ route('settings.index') }}" class="btn btn-secondary">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.querySelectorAll('.theme-selector').forEach(button => {
        button.addEventListener('click', function() {
            const theme = this.dataset.theme;
            const inputId = this.closest('.form-group').querySelector('input[type="hidden"]').id;

            // Update hidden input value
            document.getElementById(inputId).value = theme;

            // Reset border for all buttons in the same group
            this.closest('.form-group').querySelectorAll('.theme-selector').forEach(btn => {
                btn.style.border = 'none';
            });

            // Highlight the selected button
            this.style.border = '2px solid black';
        });
    });
</script>
@endpush
