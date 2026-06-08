const THEME_STORAGE_KEY = "rj-theme";

function updateThemeButton() {
    const button = document.getElementById("themeBtn");

    if (!button) {
        return;
    }

    button.textContent = document.body.classList.contains("dark-mode")
        ? "Light Mode"
        : "Dark Mode";
}

function applySavedTheme() {
    const savedTheme = localStorage.getItem(THEME_STORAGE_KEY);

    if (savedTheme === "dark") {
        document.body.classList.add("dark-mode");
    }

    updateThemeButton();
}

function toggleTheme() {
    document.body.classList.toggle("dark-mode");

    localStorage.setItem(
        THEME_STORAGE_KEY,
        document.body.classList.contains("dark-mode") ? "dark" : "light"
    );

    updateThemeButton();
}

function showModal(modalId) {
    const modal = document.getElementById(modalId);

    if (!modal) {
        return;
    }

    modal.style.display = "flex";
    modal.setAttribute("aria-hidden", "false");
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);

    if (!modal) {
        return;
    }

    modal.style.display = "none";
    modal.setAttribute("aria-hidden", "true");
}

function initBrandShowcase() {
    const canvas = document.getElementById("brandShowcaseCanvas");

    if (!canvas) {
        return;
    }

    const ctx = canvas.getContext("2d");
    const container = canvas.parentElement;

    if (!ctx || !container) {
        return;
    }

    const lines = Array.from({ length: 14 }, (_, index) => ({
        y: (index + 1) * 18,
        speed: 0.3 + index * 0.04,
        width: 70 + index * 18,
        alpha: 0.08 + (index % 4) * 0.03,
    }));

    function resizeCanvas() {
        const { width, height } = container.getBoundingClientRect();
        canvas.width = Math.max(1, Math.floor(width));
        canvas.height = Math.max(1, Math.floor(height));
    }

    function draw(timestamp) {
        const width = canvas.width;
        const height = canvas.height;
        const isDark = document.body.classList.contains("dark-mode");

        ctx.clearRect(0, 0, width, height);

        const glow = ctx.createRadialGradient(
            width * 0.75,
            height * 0.4,
            10,
            width * 0.75,
            height * 0.4,
            width * 0.55
        );

        glow.addColorStop(0, isDark ? "rgba(255,255,255,0.16)" : "rgba(255,255,255,0.22)");
        glow.addColorStop(1, "rgba(255,255,255,0)");

        ctx.fillStyle = glow;
        ctx.fillRect(0, 0, width, height);

        lines.forEach((line, index) => {
            const x =
                ((timestamp * line.speed) / 10 + index * 48) %
                (width + line.width + 40) -
                line.width;
            const y = (line.y + index * 10) % height;

            ctx.fillStyle = isDark
                ? `rgba(0, 0, 0, ${line.alpha + 0.05})`
                : `rgba(0, 0, 0, ${line.alpha})`;
            ctx.fillRect(x, y, line.width, 5 + (index % 3));
        });

        for (let i = 0; i < 18; i += 1) {
            const dotX = ((timestamp * 0.03) + i * 90) % (width + 50);
            const dotY = (height * 0.18 + i * 13) % height;

            ctx.fillStyle = isDark ? "rgba(255,255,255,0.1)" : "rgba(255,255,255,0.18)";
            ctx.fillRect(dotX, dotY, 3, 3);
        }

        requestAnimationFrame(draw);
    }

    resizeCanvas();
    window.addEventListener("resize", resizeCanvas);
    requestAnimationFrame(draw);
}

document.addEventListener("DOMContentLoaded", () => {
    applySavedTheme();
    initBrandShowcase();

    const projectCards = Array.from(document.querySelectorAll(".project-trigger"));
    const searchInput = document.getElementById("project-search");
    const creatorFilter = document.getElementById("creator-filter");
    const categoryFilter = document.getElementById("category-filter");
    const resultCount = document.getElementById("project-result-count");
    const emptyState = document.getElementById("project-empty-state");
    const resetButton = document.getElementById("reset-project-filter");
    const header = document.getElementById("siteHeader");
    const backToTopButton = document.getElementById("backToTopBtn");
    const navLinks = Array.from(document.querySelectorAll("[data-section-link]"));
    const observedSections = navLinks
        .map((link) => document.getElementById(link.dataset.sectionLink))
        .filter(Boolean);

    function updateScrollUi() {
        const shouldCompactHeader = window.scrollY > 18;

        header?.classList.toggle("is-scrolled", shouldCompactHeader);
        backToTopButton?.classList.toggle("is-visible", window.scrollY > 280);
    }

    function updateActiveSection() {
        if (!observedSections.length) {
            return;
        }

        let activeId = observedSections[0].id;

        observedSections.forEach((section) => {
            const rect = section.getBoundingClientRect();

            if (rect.top <= 140 && rect.bottom >= 140) {
                activeId = section.id;
            }
        });

        navLinks.forEach((link) => {
            link.classList.toggle("is-active", link.dataset.sectionLink === activeId);
        });
    }

    function filterProjects() {
        const keyword = (searchInput?.value || "").trim().toLowerCase();
        const creatorValue = creatorFilter?.value || "";
        const categoryValue = categoryFilter?.value || "";

        let visibleCount = 0;

        projectCards.forEach((card) => {
            const haystack = [
                card.dataset.title,
                card.dataset.creator,
                card.dataset.category,
                card.dataset.description,
            ]
                .join(" ")
                .toLowerCase();

            const matchesKeyword = !keyword || haystack.includes(keyword);
            const matchesCreator =
                !creatorValue || card.dataset.creatorGroup === creatorValue;
            const matchesCategory =
                !categoryValue ||
                (card.dataset.category || "").toLowerCase() === categoryValue;

            const isVisible = matchesKeyword && matchesCreator && matchesCategory;
            card.hidden = !isVisible;

            if (isVisible) {
                visibleCount += 1;
            }
        });

        if (resultCount) {
            resultCount.textContent = `Showing ${visibleCount} projects.`;
        }

        if (emptyState) {
            emptyState.hidden = visibleCount !== 0;
        }
    }

    [searchInput, creatorFilter, categoryFilter].forEach((element) => {
        element?.addEventListener("input", filterProjects);
        element?.addEventListener("change", filterProjects);
    });

    resetButton?.addEventListener("click", () => {
        if (searchInput) searchInput.value = "";
        if (creatorFilter) creatorFilter.value = "";
        if (categoryFilter) categoryFilter.value = "";
        filterProjects();
    });

    filterProjects();
    updateScrollUi();
    updateActiveSection();

    window.addEventListener("scroll", () => {
        updateScrollUi();
        updateActiveSection();
    });

    backToTopButton?.addEventListener("click", () => {
        window.scrollTo({ top: 0, behavior: "smooth" });
    });

    document.querySelectorAll("[data-close-modal]").forEach((button) => {
        button.addEventListener("click", () => {
            closeModal(button.dataset.closeModal);
        });
    });

    document.querySelectorAll(".modal").forEach((modal) => {
        modal.addEventListener("click", (event) => {
            if (event.target === modal) {
                closeModal(modal.id);
            }
        });
    });

    document.addEventListener("keydown", (event) => {
        if (event.key === "Escape") {
            document.querySelectorAll(".modal").forEach((modal) => {
                if (modal.style.display === "flex") {
                    closeModal(modal.id);
                }
            });
        }
    });
});
