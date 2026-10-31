export function initForms() {
  document.addEventListener("keydown", (event) => {
    if (
      event.key === " " &&
      event.target instanceof Element &&
      event.target.matches(".inp-nospace, .js-input-no-space")
    ) {
      event.preventDefault();
    }
  });

  const updateFilled = (input: HTMLInputElement) => {
    input.closest(".fancy-input")?.classList.toggle("not-filled", !input.value);
  };
  document.querySelectorAll<HTMLInputElement>(".fancy-input .inp").forEach(updateFilled);
  document.addEventListener("input", (event) => {
    if (event.target instanceof HTMLInputElement) updateFilled(event.target);
  });

  document.addEventListener("change", (event) => {
    if (!(event.target instanceof HTMLInputElement)) return;
    const input = event.target;
    if (input.matches(".file-inp")) {
      input.closest("form")?.querySelector<HTMLButtonElement>(".file-submit")?.click();
    }
  });

  document.addEventListener("submit", (event) => {
    if (!(event.target instanceof HTMLFormElement) || !event.target.matches(".file-form")) return;
    const form = event.target;
    form
      .querySelectorAll<HTMLElement>(".file-cancel, .file-submit")
      .forEach((element) => (element.style.display = "none"));
    form.querySelectorAll<HTMLElement>(".file-load, .file-stick").forEach((element) => {
      element.style.display = "block";
      element.style.opacity = "1";
    });
  });
}
