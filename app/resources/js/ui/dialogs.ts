function updateScrollLock() {
  document.body.classList.toggle(
    "fixed",
    Boolean(document.querySelector(".modal.open, .lbox.open")),
  );
}

export function initDialogs() {
  document.addEventListener("click", (event) => {
    if (!(event.target instanceof Element)) return;
    const trigger = event.target.closest<HTMLElement>(".js-open-modal, .lbox-open");
    if (trigger) {
      const id = trigger.dataset.target ?? trigger.dataset.tar?.replace(/^#/, "");
      const dialog = id ? document.getElementById(id) : null;
      // Blade's modal component owns its Alpine state and scroll locking.
      if (dialog && !dialog.hasAttribute("data-open")) {
        if (dialog.classList.contains("lbox")) {
          document.querySelectorAll(".lbox.open").forEach((box) => box.classList.remove("open"));
        }
        dialog.classList.add("open");
        updateScrollLock();
      }
      return;
    }

    const close = event.target.closest(
      ".modal__close, .modal_close, .js-close-modal, .lbox-close, .close-icon",
    );
    const dialog = (close ?? event.target).closest<HTMLElement>(".modal, .lbox");
    if (dialog && !dialog.hasAttribute("data-open") && (close || event.target === dialog)) {
      dialog.classList.remove("open");
      updateScrollLock();
    }
  });

  document.addEventListener("keydown", (event) => {
    if (event.key !== "Escape") return;
    document
      .querySelectorAll(".modal.open, .lbox.open")
      .forEach((dialog) => dialog.classList.remove("open"));
    updateScrollLock();
  });
}
