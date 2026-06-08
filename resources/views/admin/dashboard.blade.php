<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - RJ Tech Node</title>
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
                <h1>Admin Dashboard</h1>
                <p class="admin-subtitle">Manage portfolio content, project data, and creator CVs from a single page.</p>
            </div>
            <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
                <span style="font-weight:600; color:#0f172a;">Logged in as {{ auth()->user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-delete">Logout</button>
                </form>
            </div>
        </div>

        <div class="stats-grid" aria-label="Data summary">
            <div class="stat-card"><strong>{{ $projects->count() }}</strong><span>Total projects</span></div>
            <div class="stat-card"><strong>{{ $projects->whereNotNull('image')->count() }}</strong><span>Projects with images</span></div>
        </div>

        @if(session('success'))
            <div class="status-box" role="status">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="error-box" role="alert">
                <strong>Please review the following input:</strong>
                <ul style="margin: 8px 0 0 18px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="section-block" aria-labelledby="add-project-heading">
            <h3 id="add-project-heading">Add New Project</h3>
            <div class="card-block">
                <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="title">Project Title</label>
                            <input id="title" type="text" name="title" value="{{ old('title') }}" placeholder="Example: IoT Monitoring System" required>
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
                            <label for="category">Category</label>
                            <input id="category" type="text" name="category" value="{{ old('category') }}" placeholder="Example: Network Engineering" required>
                        </div>
                        <div class="form-group">
                            <label for="image">Project Image</label>
                            <input id="image" type="file" name="image" accept="image/*">
                            <div class="help-text">Optional. Common image formats only, maximum size 2MB.</div>
                        </div>
                        <div class="form-group full-span">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" rows="5" placeholder="Explain the purpose, technology stack, and project results." required>{{ old('description') }}</textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn-add">Save Project</button>
                </form>
            </div>
        </section>

        <section class="section-block" aria-labelledby="manage-project-heading">
            <h3 id="manage-project-heading">Manage Projects</h3>
            <div class="card-block table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Creator</th>
                            <th>Category</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($projects as $project)
                            <tr>
                                <td>
                                    <strong>{{ $project->title }}</strong>
                                    <div class="help-text">Created on {{ $project->created_at->format('d M Y') }}</div>
                                </td>
                                <td>{{ $project->creator }}</td>
                                <td>{{ $project->category }}</td>
                                <td style="min-width: 170px;">
                                    @if($project->image)
                                        <img src="{{ asset('uploads/' . $project->image) }}" alt="Preview of {{ $project->title }}" class="project-thumb">
                                        <form onsubmit="event.preventDefault(); confirmDelete(this, 'Remove this project image?');" action="{{ route('projects.removePhoto', $project) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-warning">Remove Image</button>
                                        </form>
                                    @else
                                        <form action="{{ route('projects.uploadPhoto', $project) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group" style="margin-bottom:8px;">
                                                <label for="upload-photo-{{ $project->id }}">Add Image</label>
                                                <input id="upload-photo-{{ $project->id }}" type="file" name="image" accept="image/*" required>
                                            </div>
                                            <button type="submit" class="btn-success">Upload Image</button>
                                        </form>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-group">
                                        <button type="button" class="btn-secondary" onclick="toggleEditForm({{ $project->id }})" aria-expanded="false" aria-controls="edit-row-{{ $project->id }}">
                                            Edit
                                        </button>
                                        <form onsubmit="event.preventDefault(); confirmDelete(this, 'Are you sure you want to delete this project?');" action="{{ route('projects.destroy', $project) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <tr id="edit-row-{{ $project->id }}" class="edit-row">
                                <td colspan="5">
                                    <div class="edit-panel">
                                        <h4 style="margin-bottom: 14px;">Edit Project: {{ $project->title }}</h4>
                                        <form action="{{ route('projects.update', $project) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-grid">
                                                <div class="form-group">
                                                    <label for="edit-title-{{ $project->id }}">Project Title</label>
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
                                                    <label for="edit-category-{{ $project->id }}">Category</label>
                                                    <input id="edit-category-{{ $project->id }}" type="text" name="category" value="{{ $project->category }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="edit-image-{{ $project->id }}">Replace Image</label>
                                                    <input id="edit-image-{{ $project->id }}" type="file" name="image" accept="image/*">
                                                    <div class="help-text">Leave blank if you do not want to replace the image.</div>
                                                </div>
                                                <div class="form-group full-span">
                                                    <label for="edit-description-{{ $project->id }}">Description</label>
                                                    <textarea id="edit-description-{{ $project->id }}" name="description" rows="4" required>{{ $project->description }}</textarea>
                                                </div>
                                            </div>
                                            <div class="action-group">
                                                <button type="submit" class="btn-success">Save Changes</button>
                                                <button type="button" class="btn-warning" onclick="toggleEditForm({{ $project->id }})">Close Editor</button>
                                            </div>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">No projects yet. Add your first project using the form above.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section class="section-block" aria-labelledby="manage-cv-heading">
            <h3 id="manage-cv-heading">Manage Profiles & CVs</h3>
            <div class="cv-grid">
                @foreach($cvs as $cv)
                    <div class="cv-card">
                        <h4 style="color: #0056b3; margin-bottom: 15px;">Edit CV: {{ $cv->name }}</h4>
                        <div class="creator-preview">
                            @php
                                $fallbackPhoto = $cv->slug === 'remano' ? asset('foto-remano.jpg') : asset('foto-jonathan.jpg');
                                $creatorPhoto = $cv->photo ? asset('uploads/' . $cv->photo) : $fallbackPhoto;
                            @endphp
                            <img src="{{ $creatorPhoto }}" alt="Photo of {{ $cv->name }}">
                            <div>
                                <strong>{{ $cv->name }}</strong>
                                <div class="help-text">This image will appear in the About The Creators section.</div>
                            </div>
                        </div>
                        <form action="{{ route('cv.update', $cv) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="photo-{{ $cv->id }}">Creator Photo</label>
                                <input id="photo-{{ $cv->id }}" type="file" name="photo" accept="image/*">
                                <div class="help-text">Leave blank if you do not want to replace the photo.</div>
                                @if($cv->photo)
                                    <label class="inline-check" for="remove-photo-{{ $cv->id }}">
                                        <input id="remove-photo-{{ $cv->id }}" type="checkbox" name="remove_photo" value="1">
                                        Remove the custom photo and revert to the default one.
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
                                <div class="help-text">Separate each skill with a comma.</div>
                            </div>
                            <div class="form-group">
                                <label for="experience-{{ $cv->id }}">Experience</label>
                                <textarea id="experience-{{ $cv->id }}" name="experience" rows="4">{{ implode("\n", $cv->experience ?? []) }}</textarea>
                                <div class="help-text">Write one experience entry per line.</div>
                            </div>
                            <div class="form-group">
                                <label for="certifications-{{ $cv->id }}">Certifications</label>
                                <textarea id="certifications-{{ $cv->id }}" name="certifications" rows="3">{{ implode("\n", $cv->certifications ?? []) }}</textarea>
                                <div class="help-text">Write one certification per line.</div>
                            </div>
                            <button type="submit" class="btn-success" style="width: 100%; padding: 12px;">Save {{ strtoupper($cv->slug) }} Updates</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="section-block" aria-labelledby="account-heading">
            <h3 id="account-heading">Admin Account Settings</h3>
            <div class="cv-grid">
                <div class="cv-card">
                    <h4 style="color: #0056b3; margin-bottom: 15px;">Change Admin Username</h4>
                    <form action="{{ route('admin.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="admin-name">Admin Username</label>
                            <input id="admin-name" type="text" name="name" value="{{ auth()->user()->name }}" required>
                            <div class="help-text">This name appears in the dashboard as the currently logged-in admin.</div>
                        </div>
                        <button type="submit" class="btn-success" style="width: 100%; padding: 12px;">Save Username</button>
                    </form>
                </div>
                <div class="cv-card">
                    <h4 style="color: #0056b3; margin-bottom: 15px;">Change Admin Password</h4>
                    <form action="{{ route('admin.password.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="current-password">Current Password</label>
                            <input id="current-password" type="password" name="current_password" required>
                        </div>
                        <div class="form-group">
                            <label for="new-password">New Password</label>
                            <input id="new-password" type="password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="password-confirmation">Confirm New Password</label>
                            <input id="password-confirmation" type="password" name="password_confirmation" required>
                            <div class="help-text">Must be at least 8 characters and different from the current password.</div>
                        </div>
                        <button type="submit" class="btn-success" style="width: 100%; padding: 12px;">Save New Password</button>
                    </form>
                </div>
            </div>
        </section>

        <a href="{{ url('/') }}" style="color: #555; display: inline-block; margin-top: 10px; margin-bottom: 20px; text-decoration: none; font-weight: 600;">&larr; View Public Website</a>
    </div>
    <script>
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: @js(session('success')),
                timer: 1800,
                showConfirmButton: false
            });
        @endif

        function confirmDelete(form, message) {
            Swal.fire({
                title: 'Confirm action',
                text: message || 'This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff4d4d',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, continue',
                cancelButtonText: 'Cancel'
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
