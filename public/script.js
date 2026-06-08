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

document.addEventListener("DOMContentLoaded", () => {
    applySavedTheme();

    const projectCards = Array.from(document.querySelectorAll(".project-trigger"));
    const searchInput = document.getElementById("project-search");
    const creatorFilter = document.getElementById("creator-filter");
    const categoryFilter = document.getElementById("category-filter");
    const resultCount = document.getElementById("project-result-count");
    const emptyState = document.getElementById("project-empty-state");
    const resetButton = document.getElementById("reset-project-filter");

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
            resultCount.textContent = `Menampilkan ${visibleCount} proyek.`;
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
