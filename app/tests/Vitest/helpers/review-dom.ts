import { initReview } from "../../../resources/js/ui/review.ts";

type Question = {
  id: string;
  type: "list" | "grid" | "number";
  options?: number;
  multiple?: boolean;
  optional?: boolean;
  rows?: number;
};

const QUESTIONS: Question[] = [
  { id: "s2d2", type: "grid", rows: 4, options: 4 },
  ...["a", "b", "c", "d"].map((suffix): Question => ({
    id: `s2d3${suffix}`,
    type: "list",
    options: 3,
    multiple: true,
    optional: true,
  })),
  { id: "s6d1", type: "number" },
  { id: "s6d2", type: "list", options: 3 },
  { id: "s6d3", type: "list", options: 2, optional: true },
  { id: "s7d2", type: "list", options: 3 },
  { id: "s7d3", type: "list", options: 2, optional: true },
  { id: "s7d4", type: "list", options: 2, optional: true },
  { id: "s7d5", type: "list", options: 2, optional: true },
];

const radio = (name: string, value: number) =>
  `<input type="radio" class="field js-cbx" name="${name}" value="${value}" />`;

function markup(question: Question): string {
  const range = Array.from({ length: question.options ?? 0 }, (_, index) => index + 1);
  let body = "";

  if (question.type === "number") {
    body = `<input type="number" class="field js-input" name="${question.id}" min="1" max="100" required />`;
  } else if (question.type === "grid") {
    body = Array.from({ length: question.rows ?? 1 }, (_, row) =>
      range.map((value) => radio(`${question.id}_${row + 1}`, value)).join(""),
    ).join("");
  } else if (question.multiple) {
    body = range.map((value) => radio(`${question.id}_${value}`, 1)).join("");
  } else {
    body = range.map((value) => radio(question.id, value)).join("");
  }

  return `<div id="question-${question.id}" class="question js-question"
    data-optional="${question.optional ? 1 : 0}" data-completed="0"
    data-multiple="${question.multiple ? 1 : 0}">${body}</div>`;
}

/** Renders the questionnaire markup produced by show.blade.php and boots initReview(). */
export function mountReview(): HTMLFormElement {
  document.body.innerHTML = `<form data-review-form novalidate>
    ${QUESTIONS.map(markup).join("")}
    <button type="button" class="js-attempt-submit">Invia</button>
  </form>`;

  const form = document.querySelector<HTMLFormElement>("[data-review-form]")!;
  form.addEventListener("submit", (event) => {
    event.preventDefault();
    form.dataset.submitted = "1";
  });

  initReview();

  return form;
}

export const question = (id: string) => document.querySelector<HTMLElement>(`#question-${id}`)!;

export const isVisible = (id: string) => question(id).style.display !== "none";

export const isOptional = (id: string) => question(id).dataset.optional === "1";

export function radioInput(name: string, value: number | string): HTMLInputElement {
  return document.querySelector<HTMLInputElement>(`input[name="${name}"][value="${value}"]`)!;
}

/** Clicks a radio like a user would; clicking a selected radio deselects it. */
export function click(name: string, value: number | string): void {
  radioInput(name, value).click();
}

export function typeNumber(id: string, value: string): void {
  const input = question(id).querySelector<HTMLInputElement>(".js-input")!;
  input.value = value;
  input.dispatchEvent(new Event("input", { bubbles: true }));
}

export const submit = () =>
  document.querySelector<HTMLButtonElement>(".js-attempt-submit")!.click();

export const submitted = () => document.querySelector("form")!.dataset.submitted === "1";

export const checkedCount = (id: string) => question(id).querySelectorAll(".js-cbx:checked").length;
