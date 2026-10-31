import { expect, test } from "vitest";
import { reviewQuestionCompleted } from "../../../resources/js/ui/review.ts";

test("review completion requires every answer group and tracks cleared numeric inputs", () => {
  const choices = [
    { name: "first", checked: true },
    { name: "second", checked: false },
  ];
  const inputs = [];
  const question = {
    dataset: { multiple: "0" },
    querySelectorAll: (selector) => (selector === ".js-cbx" ? choices : inputs),
  };
  expect(reviewQuestionCompleted(question)).toBe(false);
  choices[1].checked = true;
  expect(reviewQuestionCompleted(question)).toBe(true);
  choices[1].checked = false;
  question.dataset.multiple = "1";
  expect(reviewQuestionCompleted(question)).toBe(true);
  choices.length = 0;
  inputs.push({ value: "" });
  expect(reviewQuestionCompleted(question)).toBe(false);
  inputs[0].value = "42";
  expect(reviewQuestionCompleted(question)).toBe(true);
  inputs[0].value = "  ";
  expect(reviewQuestionCompleted(question)).toBe(false);
  inputs.length = 0;
  expect(reviewQuestionCompleted(question)).toBe(true);
});
