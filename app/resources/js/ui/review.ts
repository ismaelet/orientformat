export function reviewQuestionCompleted(question: HTMLElement): boolean {
  const choices = [...question.querySelectorAll<HTMLInputElement>(".js-cbx")];

  const inputs = [
    ...question.querySelectorAll<HTMLInputElement | HTMLTextAreaElement>(".js-input"),
  ];

  const checked = choices.filter((input) => input.checked);

  if (choices.length) {
    return question.dataset.multiple === "1"
      ? checked.length > 0
      : [...new Set(choices.map((input) => input.name))].every((name) =>
          checked.some((input) => input.name === name),
        );
  }

  return inputs.every((input) => input.value.trim() !== "" && input.checkValidity());
}

export function initReview() {
  const form = document.querySelector<HTMLFormElement>("[data-review-form]");
  if (!form) return;
  const questions = [...form.querySelectorAll<HTMLElement>(".js-question")];

  const complete = (question: HTMLElement) => {
    const done = reviewQuestionCompleted(question);

    question.dataset.completed = done ? "1" : "0";
    question.classList.toggle("question--completed", done);

    if (done) {
      question.classList.remove("question--error");

      const warning = question.querySelector<HTMLElement>(".js-error-warning");

      if (warning) {
        warning.style.display = "none";
      }
    }
  };

  const dependent = (id: string, visible: boolean) => {
    const question = form.querySelector<HTMLElement>(`#question-${id}`);
    if (!question) return;

    const wasVisible = getComputedStyle(question).display !== "none";

    question.style.display = visible ? "block" : "none";
    question.dataset.optional = visible ? "0" : "1";

    if (wasVisible && !visible) {
      question.querySelectorAll<HTMLInputElement>(".js-cbx").forEach((input) => {
        input.checked = false;
      });
    }

    complete(question);
  };

  const syncDependencies = () => {
    const checkedValue = (selector: string): string | undefined =>
      form.querySelector<HTMLInputElement>(`${selector} .js-cbx:checked`)?.value;

    const s2d2 = form.querySelector<HTMLElement>("#question-s2d2");

    const suffixes = ["3a", "3b", "3c", "3d"];

    suffixes.forEach((suffix, index) => {
      const name = `s2d2_${index + 1}`;

      const selected = s2d2?.querySelector<HTMLInputElement>(`.js-cbx[name="${name}"]:checked`);

      dependent(`s2d${suffix}`, Number(selected?.value ?? 0) > 1);
    });

    dependent("s6d3", Number(checkedValue("#question-s6d2") ?? 0) > 1);

    const s7d2 = checkedValue("#question-s7d2");

    dependent("s7d3", s7d2 === "1");
    dependent("s7d4", s7d2 === "2");
    dependent("s7d5", s7d2 === "2");
  };

  const radioSelections = new WeakMap<HTMLInputElement, boolean>();
  form
    .querySelectorAll<HTMLInputElement>('input[type="radio"]')
    .forEach((input) => radioSelections.set(input, input.checked));

  form.addEventListener("click", (event) => {
    if (!(event.target instanceof HTMLInputElement) || event.target.type !== "radio") return;

    const input = event.target;

    if (radioSelections.get(input)) {
      input.checked = false;
    }

    form.querySelectorAll<HTMLInputElement>('input[type="radio"]').forEach((other) => {
      if (other.name === input.name) {
        radioSelections.set(other, other.checked);
      }
    });

    const question = input.closest<HTMLElement>(".js-question");

    if (question) {
      complete(question);
    }

    // Update dependent questions when a radio is selected or deselected
    syncDependencies();
  });

  form.addEventListener("change", (event) => {
    if (!(event.target instanceof HTMLInputElement)) return;
    const input = event.target;
    const question = input.closest<HTMLElement>(".js-question");
    if (!question) return;
    if (input.matches(".js-cbx") && question.dataset.multiple !== "1" && input.checked) {
      question.querySelectorAll<HTMLInputElement>(".js-cbx").forEach((other) => {
        if (other !== input && other.name === input.name) other.checked = false;
      });
    }
    syncDependencies();
    complete(question);
  });

  form.addEventListener("input", (event) => {
    if (!(event.target instanceof Element)) return;
    const question = event.target.closest<HTMLElement>(".js-question");
    if (question) complete(question);
  });

  const submitButton = form.querySelector<HTMLButtonElement>(".js-attempt-submit");

  submitButton?.addEventListener("click", () => {
    syncDependencies();
    questions.forEach(complete);

    const missing = questions.filter(
      (question) =>
        question.dataset.optional !== "1" &&
        question.dataset.completed !== "1" &&
        getComputedStyle(question).display !== "none",
    );

    if (missing.length > 0) {
      missing.forEach((question) => {
        question.classList.add("question--error");

        question
          .querySelector<HTMLElement>(".js-error-warning")
          ?.style.setProperty("display", "block");
      });

      missing[0].scrollIntoView({
        behavior: "smooth",
        block: "center",
      });

      return;
    }

    form.requestSubmit();
  });

  syncDependencies();
  questions.forEach(complete);
}
