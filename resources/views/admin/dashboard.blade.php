<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - RJ Tech Node</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <style>
        body { padding: 40px 20px; }
        .admin-container { max-width: 1180px; margin: auto; background: rgba(255,255,255,0.78); padding: 30px; border-radius: 18px; border: 1px solid rgba(0,0,0,0.1); box-shadow: 0 4px 30px rgba(0,0,0,0.1); backdrop-filter: blur(10px); }
        .admin-header { display: flex; justify-content: space-between; gap: 16px; align-items: flex-start; flex-wrap: wrap; }
        .admin-subtitle { color: #4b5563; margin-top: 6px; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(170px, 1fr)); gap: 15px; margin: 25px 0 30px; }
        .stat-card { background: rgba(255,255,255,0.85); border: 1px solid rgba(0,0,0,0.08); border-radius: 14px; padding: 18px; }
        .stat-card strong { display: block; font-size: 1.7rem; color: #0056b3; }
        .section-block { margin-top: 35px; }
        .section-block h3 { color: #111; margin-bottom: 15px; }
        .card-block { background: rgba(255,255,255,0.88); border: 1px solid rgba(0,0,0,0.08); padding: 24px; border-radius: 16px; }
        .form-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 16px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 6px; font-size: 13px; font-weight: 600; color: #333; }
        .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 10px 12px; border-radius: 8px; border: 1px solid #cbd5e1; font-family: 'Poppins', sans-serif; font-size: 14px; }
        .full-span { grid-column: 1 / -1; }
        .btn-add, .btn-delete, .btn-warning, .btn-success, .btn-secondary { border: none; border-radius: 8px; cursor: pointer; font-weight: 600; transition: 0.2s ease; }
        .btn-add { background: #4da3ff; color: white; padding: 11px 20px; }
        .btn-add:hover { background: #3588e6; }
        .btn-delete { background: #ff4d4d; color: white; padding: 8px 12px; }
        .btn-delete:hover { background: #e63939; }
        .btn-warning { background: #ffc107; color: #000; padding: 8px 12px; }
        .btn-success { background: #28a745; color: white; padding: 8px 12px; }
        .btn-secondary { background: #0f172a; color: white; padding: 8px 12px; }
        .action-group { display: flex; gap: 8px; flex-wrap: wrap; }
        table { width: 100%; margin-top: 20px; border-collapse: collapse; color: #333; font-size: 14px; }
        th, td { padding: 14px 10px; border-bottom: 1px solid rgba(0,0,0,0.1); text-align: left; vertical-align: top; }
        th { font-weight: 700; color: #111; background: rgba(240,244,248,0.8); }
        .table-wrap { overflow-x: auto; }
        .project-thumb { width: 96px; border-radius: 8px; display: block; margin-bottom: 10px; }
        .edit-row { display: none; background: rgba(248,250,252,0.9); }
        .edit-row.is-open { display: table-row; }
        .edit-panel { padding: 18px 10px 8px; }
        .cv-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .cv-card { background: rgba(255,255,255,0.9); padding: 25px; border-radius: 14px; border: 1px solid #d6dde5; }
        .creator-preview { display: flex; align-items: center; gap: 14px; margin-bottom: 16px; }
        .creator-preview img { width: 82px; height: 82px; border-radius: 50%; object-fit: cover; border: 3px solid #0056b3; background: #f8fafc; }
        .inline-check { display: flex; align-items: center; gap: 8px; margin-top: 10px; font-size: 13px; color: #334155; }
        .status-box { background: #fff4d6; color: #7c5b00; padding: 12px 14px; border-radius: 10px; margin-top: 18px; }
        .error-box { background: #ffeded; color: #8f1d1d; padding: 14px 16px; border-radius: 10px; margin-top: 18px; }
        .help-text { font-size: 12px; color: #64748b; margin-top: 4px; }
        @media (max-width: 768px) {
            body { padding: 20px 12px; }
            .admin-container { padding: 20px; }
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <div>
                <h1>Dashboard Admin</h1>
                <p class="admin-subtitle">Kelola portfolio, data proyek, dan CV creator dari satu halaman.</p>
            </div>
            <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
                <span style="font-weight:600; color:#0f172a;">Login sebagai {{ auth()->user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-delete">Logout</button>
                </form>
            </div>
        </div>

        <div class="stats-grid" aria-label="Ringkasan data">
            <div class="stat-card"><strong>{{ $projects->count() }}</strong><span>Total proyek</span></div>
            <div class="stat-card"><strong>{{ $projects->whereNotNull('image')->count() }}</strong><span>Proyek bergambar</span></div>
            <div class="stat-card"><strong>{{ $cvs->count() }}</strong><span>CV aktif</span></div>
        </div>

        @if(session('success'))
            <div class="status-box" role="status">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="error-box" role="alert">
                <strong>Periksa input berikut:</strong>
                <ul style="margin: 8px 0 0 18px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="section-block" aria-labelledby="add-project-heading">
            <h3 id="add-project-heading">Tambah Proyek Baru</h3>
            <div class="card-block">
                <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="title">Judul Proyek</label>
                            <input id="title" type="text" name="title" value="{{ old('title') }}" placeholder="Contoh: Sistem Monitoring IoT" required>
                        </div>
                        <div class="form-group">
                            <label for="creator">Creator</label>
                            <select id="creator" name="creator" required>
                                <option value="Remano & Jonathan" @selected(old('creator') === 'Remano & Jonathan')>Remano & Jonathan</option>
                                <option value="Mochamad Remano D." @selected(old('creator') === 'Mochamad Remano D.')>Mochamad Remano D.</option>
                                <option value="Jonathan Christopher S. D." @selected(old('creator') === 'Jonathan Christopher S. D.')>Jonathan Christopher S. D.</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="category">Kategori</label>
                            <input id="category" type="text" name="category" value="{{ old('category') }}" placeholder="Contoh: Network Engineering" required>
                        </div>
                        <div class="form-group">
                            <label for="image">Gambar Proyek</label>
                            <input id="image" type="file" name="image" accept="image/*">
                            <div class="help-text">Opsional. Format gambar umum, ukuran maksimum 2MB.</div>
                        </div>
                        <div class="form-group full-span">
                            <label for="description">Deskripsi</label>
                            <textarea id="description" name="description" rows="5" placeholder="Jelaskan tujuan, teknologi, dan hasil proyek." required>{{ old('description') }}</textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn-add">Simpan Proyek</button>
                </form>
            </div>
        </section>

        <section class="section-block" aria-labelledby="manage-project-heading">
            <h3 id="manage-project-heading">Kelola Proyek</h3>
            <div class="card-block table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Creator</th>
                            <th>Kategori</th>
                            <th>Foto</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($projects as $project)
                            <tr>
                                <td>
                                    <strong>{{ $project->title }}</strong>
                                    <div class="help-text">Dibuat {{ $project->created_at->format('d M Y') }}</div>
                                </td>
                                <td>{{ $project->creator }}</td>
                                <td>{{ $project->category }}</td>
                                <td style="min-width: 170px;">
                                    @if($project->image)
                                        <img src="{{ asset('uploads/' . $project->image) }}" alt="Preview {{ $project->title }}" class="project-thumb">
                                        <form onsubmit="event.preventDefault(); confirmDelete(this, 'Hapus foto proyek ini?');" action="{{ route('projects.removePhoto', $project) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-warning">Hapus Foto</button>
                                        </form>
                                    @else
                                        <form action="{{ route('projects.uploadPhoto', $project) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group" style="margin-bottom:8px;">
                                                <label for="upload-photo-{{ $project->id }}">Tambah Foto</label>
                                                <input id="upload-photo-{{ $project->id }}" type="file" name="image" accept="image/*" required>
                                            </div>
                                            <button type="submit" class="btn-success">Upload Foto</button>
                                        </form>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-group">
                                        <button type="button" class="btn-secondary" onclick="toggleEditForm({{ $project->id }})" aria-expanded="false" aria-controls="edit-row-{{ $project->id }}">
                                            Edit
                                        </button>
                                        <form onsubmit="event.preventDefault(); confirmDelete(this, 'Yakin ingin menghapus proyek ini?');" action="{{ route('projects.destroy', $project) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <tr id="edit-row-{{ $project->id }}" class="edit-row">
                                <td colspan="5">
                                    <div class="edit-panel">
                                        <h4 style="margin-bottom: 14px;">Edit Proyek: {{ $project->title }}</h4>
                                        <form action="{{ route('projects.update', $project) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-grid">
                                                <div class="form-group">
                                                    <label for="edit-title-{{ $project->id }}">Judul Proyek</label>
                                                    <input id="edit-title-{{ $project->id }}" type="text" name="title" value="{{ $project->title }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="edit-creator-{{ $project->id }}">Creator</label>
                                                    <select id="edit-creator-{{ $project->id }}" name="creator" required>
                                                        <option value="Remano & Jonathan" @selected($project->creator === 'Remano & Jonathan')>Remano & Jonathan</option>
                                                        <option value="Mochamad Remano D." @selected($project->creator === 'Mochamad Remano D.')>Mochamad Remano D.</option>
                                                        <option value="Jonathan Christopher S. D." @selected($project->creator === 'Jonathan Christopher S. D.')>Jonathan Christopher S. D.</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="edit-category-{{ $project->id }}">Kategori</label>
                                                    <input id="edit-category-{{ $project->id }}" type="text" name="category" value="{{ $project->category }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="edit-image-{{ $project->id }}">Ganti Gambar</label>
                                                    <input id="edit-image-{{ $project->id }}" type="file" name="image" accept="image/*">
                                                    <div class="help-text">Kosongkan jika gambar tidak ingin diganti.</div>
                                                </div>
                                                <div class="form-group full-span">
                                                    <label for="edit-description-{{ $project->id }}">Deskripsi</label>
                                                    <textarea id="edit-description-{{ $project->id }}" name="description" rows="4" required>{{ $project->description }}</textarea>
                                                </div>
                                            </div>
                                            <div class="action-group">
                                                <button type="submit" class="btn-success">Simpan Perubahan</button>
                                                <button type="button" class="btn-warning" onclick="toggleEditForm({{ $project->id }})">Tutup Editor</button>
                                            </div>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">Belum ada proyek. Tambahkan proyek pertama dari form di atas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section class="section-block" aria-labelledby="manage-cv-heading">
            <h3 id="manage-cv-heading">Kelola Biodata & CV</h3>
            <div class="cv-grid">
                @foreach($cvs as $cv)
                    <div class="cv-card">
                        <h4 style="color: #0056b3; margin-bottom: 15px;">Edit CV: {{ $cv->name }}</h4>
                        <div class="creator-preview">
                            @php
                                $fallbackPhoto = $cv->slug === 'remano' ? asset('foto-remano.jpg') : asset('foto-jonathan.jpg');
                                $creatorPhoto = $cv->photo ? asset('uploads/' . $cv->photo) : $fallbackPhoto;
                            @endphp
                            <img src="{{ $creatorPhoto }}" alt="Foto {{ $cv->name }}">
                            <div>
                                <strong>{{ $cv->name }}</strong>
                                <div class="help-text">Foto ini akan tampil di bagian About The Creators.</div>
                            </div>
                        </div>
                        <form action="{{ route('cv.update', $cv) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="photo-{{ $cv->id }}">Foto Creator</label>
                                <input id="photo-{{ $cv->id }}" type="file" name="photo" accept="image/*">
                                <div class="help-text">Kosongkan jika tidak ingin mengganti foto.</div>
                                @if($cv->photo)
                                    <label class="inline-check" for="remove-photo-{{ $cv->id }}">
                                        <input id="remove-photo-{{ $cv->id }}" type="checkbox" name="remove_photo" value="1">
                                        Hapus foto custom dan kembali ke foto default.
                                    </label>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="role-{{ $cv->id }}">Role / Tagline</label>
                                <input id="role-{{ $cv->id }}" type="text" name="role" value="{{ $cv->role }}" required>
                            </div>
                            <div class="form-group">
                                <label for="bio-{{ $cv->id }}">About Me</label>
                                <textarea id="bio-{{ $cv->id }}" name="bio" rows="4" required>{{ $cv->bio }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="education-{{ $cv->id }}">Education</label>
                                <input id="education-{{ $cv->id }}" type="text" name="education" value="{{ $cv->education }}" required>
                            </div>
                            <div class="form-group">
                                <label for="skills-{{ $cv->id }}">Skills</label>
                                <textarea id="skills-{{ $cv->id }}" name="skills" rows="2">{{ implode(', ', $cv->skills ?? []) }}</textarea>
                                <div class="help-text">Pisahkan skill menggunakan koma.</div>
                            </div>
                            <div class="form-group">
                                <label for="experience-{{ $cv->id }}">Experience</label>
                                <textarea id="experience-{{ $cv->id }}" name="experience" rows="4">{{ implode("\n", $cv->experience ?? []) }}</textarea>
                                <div class="help-text">Satu pengalaman per baris.</div>
                            </div>
                            <div class="form-group">
                                <label for="certifications-{{ $cv->id }}">Certifications</label>
                                <textarea id="certifications-{{ $cv->id }}" name="certifications" rows="3">{{ implode("\n", $cv->certifications ?? []) }}</textarea>
                                <div class="help-text">Satu sertifikasi per baris.</div>
                            </div>
                            <button type="submit" class="btn-success" style="width: 100%; padding: 12px;">Simpan Update {{ strtoupper($cv->slug) }}</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="section-block" aria-labelledby="account-heading">
            <h3 id="account-heading">Pengaturan Akun Admin</h3>
            <div class="cv-grid">
                <div class="cv-card">
                    <h4 style="color: #0056b3; margin-bottom: 15px;">Ubah Username Admin</h4>
                    <form action="{{ route('admin.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="admin-name">Username Admin</label>
                            <input id="admin-name" type="text" name="name" value="{{ auth()->user()->name }}" required>
                            <div class="help-text">Nama ini tampil di dashboard sebagai identitas admin yang sedang login.</div>
                        </div>
                        <button type="submit" class="btn-success" style="width: 100%; padding: 12px;">Simpan Username</button>
                    </form>
                </div>
                <div class="cv-card">
                    <h4 style="color: #0056b3; margin-bottom: 15px;">Ubah Password Admin</h4>
                    <form action="{{ route('admin.password.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="current-password">Password Lama</label>
                            <input id="current-password" type="password" name="current_password" required>
                        </div>
                        <div class="form-group">
                            <label for="new-password">Password Baru</label>
                            <input id="new-password" type="password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="password-confirmation">Konfirmasi Password Baru</label>
                            <input id="password-confirmation" type="password" name="password_confirmation" required>
                            <div class="help-text">Minimal 8 karakter dan harus berbeda dari password lama.</div>
                        </div>
                        <button type="submit" class="btn-success" style="width: 100%; padding: 12px;">Simpan Password Baru</button>
                    </form>
                </div>
            </div>
        </section>

        <a href="{{ url('/') }}" style="color: #555; display: inline-block; margin-top: 10px; margin-bottom: 20px; text-decoration: none; font-weight: 600;">&larr; Lihat Website Publik</a>
    </div>
    <script>
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: @js(session('success')),
                timer: 1800,
                showConfirmButton: false
            });
        @endif

        function confirmDelete(form, message) {
            Swal.fire({
                title: 'Konfirmasi aksi',
                text: message || 'Data ini tidak bisa dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff4d4d',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, lanjutkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }

        function toggleEditForm(projectId) {
            const row = document.getElementById(`edit-row-${projectId}`);
            const isOpen = row.classList.toggle('is-open');
            const trigger = document.querySelector(`button[aria-controls="edit-row-${projectId}"]`);

            if (trigger) {
                trigger.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            }
        }
    </script>
</body>
</html>
