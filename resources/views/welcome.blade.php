<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="RJ Tech Node team portfolio showcasing creator profiles, project gallery, and a Laravel-based admin dashboard.">
    <title>RJ Tech Node - Portfolio App</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>
<body>
    @php
        $remanoCv = $cvs->firstWhere('slug', 'remano');
        $jonathanCv = $cvs->firstWhere('slug', 'jonathan');
        $remanoPhoto = $remanoCv?->photo ? asset('uploads/' . $remanoCv->photo) : asset('foto-remano.jpg');
        $jonathanPhoto = $jonathanCv?->photo ? asset('uploads/' . $jonathanCv->photo) : asset('foto-jonathan.jpg');
    @endphp
    <header>
        <h1>RJ Tech Node<span style="color: #4da3ff;">.</span></h1>
        <div class="header-actions">
            <button class="theme-btn" type="button" onclick="toggleTheme()" id="themeBtn" aria-label="Change page theme">Dark Mode</button>
            <nav class="header-nav" aria-label="Main navigation">
                <a href="#creators" class="nav-link">Creator</a>
                <a href="#projects" class="nav-link">Projects</a>
            </nav>
            <a href="{{ route('login') }}" class="admin-link">Admin Login</a>
        </div>
    </header>

    <main>
        <section class="hero fade-up" aria-labelledby="hero-title">
            <p style="text-transform: uppercase; font-weight: 600; letter-spacing: 1.5px; color: var(--primary-color);">Semester Portfolio Project</p>
            <h2 id="hero-title">Engineering the Future.</h2>
            <p>This web app showcases the creators, interactive CVs, and a Laravel-based project gallery with an admin dashboard for data management.</p>
            <div class="hero-actions">
                <a href="#projects" class="hero-link hero-link-primary">View Projects</a>
                <a href="#stack-title" class="hero-link">View Tech Stack</a>
            </div>
        </section>

        <section class="container fade-up" style="animation-delay: 0.15s;" aria-label="Portfolio summary">
            <div class="portfolio-highlights">
                <article class="highlight-card" style="display:flex; align-items:center; justify-content:center; text-align:center;">
                    <div style="width:100%; text-align:center;">
                        <strong style="display:block; width:100%; text-align:center;">{{ $projects->count() }}</strong>
                        <span style="display:block; width:100%; text-align:center;">Total projects</span>
                    </div>
                </article>
                <article class="highlight-card" style="display:flex; align-items:center; justify-content:center; text-align:center;">
                    <div style="width:100%; text-align:center;">
                        <strong style="display:block; width:100%; text-align:center;">Laravel 12</strong>
                        <span style="display:block; width:100%; text-align:center;">Primary framework</span>
                    </div>
                </article>
            </div>
        </section>

        <section class="container" id="creators" aria-labelledby="creators-title">
            <h2 class="section-title fade-up" style="animation-delay: 0.2s;" id="creators-title">About The Creators</h2>
            <div class="creators-section fade-up" style="animation-delay: 0.3s;">
                <button type="button" class="creator-card creator-trigger" data-person="remano" aria-haspopup="dialog" aria-controls="cvModal">
                    <img src="{{ $remanoPhoto }}" alt="Photo of Mochamad Remano" class="avatar" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="avatar-fallback" style="display:none;">MR</div>
                    <h3>Mochamad Remano D.</h3>
                    <p><strong>NIM:</strong> 2403421006</p>
                    <p><strong>Class:</strong> BM-4A</p>
                    <p><strong>Role:</strong> Front-End & UI/UX</p>
                    <span class="click-hint">Click to view CV</span>
                </button>

                <button type="button" class="creator-card creator-trigger" data-person="jonathan" aria-haspopup="dialog" aria-controls="cvModal">
                    <img src="{{ $jonathanPhoto }}" alt="Photo of Jonathan Christopher" class="avatar" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="avatar-fallback" style="display:none;">JO</div>
                    <h3>Jonathan Christopher S. D.</h3>
                    <p><strong>NIM:</strong> 2403421031</p>
                    <p><strong>Class:</strong> BM-4A</p>
                    <p><strong>Role:</strong> Logic & Integration</p>
                    <span class="click-hint" style="color: var(--jonathan-color);">Click to view CV</span>
                </button>
            </div>
        </section>

        <section class="container" id="projects" aria-labelledby="projects-title">
            <h2 class="section-title fade-up" style="animation-delay: 0.4s;" id="projects-title">Our Project Gallery</h2>
            <div class="project-toolbar fade-up" style="animation-delay: 0.45s;" aria-label="Project filter">
                <div class="toolbar-field">
                    <label for="project-search">Search projects</label>
                    <input id="project-search" type="search" placeholder="Search by title, category, or description">
                </div>
                <div class="toolbar-field">
                    <label for="creator-filter">Filter by creator</label>
                    <select id="creator-filter">
                        <option value="">All creators</option>
                        <option value="remano">Remano</option>
                        <option value="jonathan">Jonathan</option>
                        <option value="kolaborasi">Collaboration</option>
                    </select>
                </div>
                <div class="toolbar-field">
                    <label for="category-filter">Filter by category</label>
                    <select id="category-filter">
                        <option value="">All categories</option>
                        @foreach($projects->pluck('category')->unique()->sort()->values() as $category)
                            <option value="{{ Str::lower($category) }}">{{ $category }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <p id="project-result-count" class="project-result-count fade-up" style="animation-delay: 0.47s;">
                Showing {{ $projects->count() }} projects.
            </p>
            <div class="projects-grid fade-up" style="animation-delay: 0.5s;">
                @forelse($projects as $project)
                    <button
                        type="button"
                        class="project-card project-trigger"
                        aria-haspopup="dialog"
                        aria-controls="projectModal"
                        data-title="{{ $project->title }}"
                        data-creator="{{ $project->creator }}"
                        data-category="{{ $project->category }}"
                        data-description="{{ $project->description }}"
                        data-image="{{ $project->image }}"
                        data-creator-group="{{ str_contains($project->creator, 'Remano') && str_contains($project->creator, 'Jonathan') ? 'kolaborasi' : (str_contains($project->creator, 'Jonathan') ? 'jonathan' : 'remano') }}"
                    >
                        <h4>{{ $project->title }}</h4>
                        <span class="creator-tag {{ str_contains($project->creator, 'Jonathan') ? 'jonathan-tag' : '' }}">{{ $project->creator }}</span>
                        <p>{{ Str::limit($project->description, 110) }}</p>
                        <p class="category">{{ $project->category }}</p>
                    </button>
                @empty
                    <p style="text-align: center; grid-column: 1/-1;">No projects are currently available in the database. Please log in as admin to add data.</p>
                @endforelse
            </div>
            <div id="project-empty-state" class="empty-state" hidden>
                <h3>No projects found</h3>
                <p>Try changing the keyword or reset the filters to show all projects again.</p>
                <button type="button" class="hero-link hero-link-primary" id="reset-project-filter">Reset Filters</button>
            </div>
        </section>

        <section class="container" aria-labelledby="stack-title">
            <h2 class="section-title fade-up" style="animation-delay: 0.55s;" id="stack-title">Tech Stack</h2>
            <div class="stack-list fade-up" style="animation-delay: 0.6s;">
                <span class="stack-chip">Laravel 12</span>
                <span class="stack-chip">PHP 8.2</span>
                <span class="stack-chip">Blade</span>
                <span class="stack-chip">JavaScript</span>
                <span class="stack-chip">MySQL / SQLite</span>
                <span class="stack-chip">SweetAlert2</span>
                <span class="stack-chip">Vite</span>
                <span class="stack-chip">PHPUnit</span>
            </div>
        </section>
    </main>

    <footer>
        <p>RJ Tech Node Portfolio App - Laravel, admin CRUD, and interactive CVs.</p>
    </footer>

    <div id="projectModal" class="modal" role="dialog" aria-modal="true" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-content">
            <button type="button" class="close-btn" data-close-modal="projectModal" aria-label="Close project details">&times;</button>
            <img id="modalImage" src="" alt="" style="width: 100%; border-radius: 10px; margin-bottom: 15px; display: none; object-fit: contain; max-height: 300px;">
            <h2 id="modalTitle">Project Title</h2>
            <span id="modalCreator" class="creator-tag" style="margin: 10px 0; display: inline-block;">Creator</span>
            <p id="modalCategory" class="category" style="margin-bottom: 15px; font-weight: bold;"></p>
            <p id="modalDesc">Detailed project explanation will appear here.</p>
        </div>
    </div>

    <div id="cvModal" class="modal" role="dialog" aria-modal="true" aria-labelledby="cvName" aria-hidden="true">
        <div class="modal-content cv-content">
            <button type="button" class="close-btn" data-close-modal="cvModal" aria-label="Close creator CV">&times;</button>
            <div class="cv-header">
                <h2 id="cvName">Full Name</h2>
                <h4 id="cvRole" style="color: gray; margin-bottom: 15px;">Role</h4>
            </div>
            <div class="cv-section">
                <h3>About Me</h3>
                <p id="cvBio">Brief description.</p>
            </div>
            <div class="cv-section">
                <h3>Education</h3>
                <p id="cvEducation">Educational Background</p>
            </div>
            <div class="cv-section">
                <h3>Experience</h3>
                <div id="cvExperience" class="cv-list-container"></div>
            </div>
            <div class="cv-section">
                <h3>Technical Skills</h3>
                <div id="cvSkills" class="skill-tags"></div>
            </div>
            <div class="cv-section" id="certSection">
                <h3>Certifications</h3>
                <ul id="cvCertifications" style="margin-left: 20px; line-height: 1.8;"></ul>
            </div>
        </div>
    </div>

    <script src="{{ asset('script.js') }}"></script>
    <script>
        const cvData = @json($cvs->keyBy('slug'));

        function openProjectModal(project) {
            const modal = document.getElementById('projectModal');
            const modalImg = document.getElementById('modalImage');

            document.getElementById('modalTitle').innerText = project.title;
            document.getElementById('modalCreator').innerText = project.creator;
            document.getElementById('modalCategory').innerText = project.category;
            document.getElementById('modalDesc').innerText = project.description;

            if (project.image) {
                modalImg.src = `/uploads/${project.image}`;
                modalImg.alt = `Project image for ${project.title}`;
                modalImg.style.display = 'block';
            } else {
                modalImg.removeAttribute('src');
                modalImg.alt = '';
                modalImg.style.display = 'none';
            }

            showModal(modal.id);
        }

        function openCvModal(person) {
            const data = cvData[person];
            const modal = document.getElementById('cvModal');

            if (!data) {
                return;
            }

            document.getElementById('cvName').innerText = data.name;
            document.getElementById('cvRole').innerText = data.role;
            document.getElementById('cvBio').innerText = data.bio;
            document.getElementById('cvEducation').innerText = data.education;

            const skillsContainer = document.getElementById('cvSkills');
            skillsContainer.innerHTML = '';
            (data.skills || []).forEach((skill) => {
                const span = document.createElement('span');
                span.className = 'skill-tag';
                span.innerText = skill;
                skillsContainer.appendChild(span);
            });

            const expContainer = document.getElementById('cvExperience');
            expContainer.innerHTML = '';
            (data.experience || []).forEach((exp) => {
                const p = document.createElement('p');
                p.style.marginBottom = '15px';
                p.innerHTML = `• ${exp}`;
                expContainer.appendChild(p);
            });

            const certContainer = document.getElementById('cvCertifications');
            const certSection = document.getElementById('certSection');
            certContainer.innerHTML = '';

            if (data.certifications && data.certifications.length > 0) {
                certSection.style.display = 'block';
                data.certifications.forEach((cert) => {
                    const li = document.createElement('li');
                    li.innerText = cert;
                    certContainer.appendChild(li);
                });
            } else {
                certSection.style.display = 'none';
            }

            showModal(modal.id);
        }

        document.querySelectorAll('.project-trigger').forEach((button) => {
            button.addEventListener('click', () => {
                openProjectModal({
                    title: button.dataset.title,
                    creator: button.dataset.creator,
                    category: button.dataset.category,
                    description: button.dataset.description,
                    image: button.dataset.image,
                });
            });
        });

        document.querySelectorAll('.creator-trigger').forEach((button) => {
            button.addEventListener('click', () => {
                openCvModal(button.dataset.person);
            });
        });
    </script>
</body>
</html>
