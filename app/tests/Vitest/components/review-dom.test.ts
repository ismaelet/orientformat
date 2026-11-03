// @vitest-environment jsdom
import { beforeEach, describe, expect, test, vi } from "vitest";
import { reviewQuestionCompleted } from "../../../resources/js/ui/review.ts";
import {
  checkedCount,
  click,
  isOptional,
  isVisible,
  mountReview,
  question,
  radioInput,
  submit,
  submitted,
  typeNumber,
} from "../helpers/review-dom.ts";

beforeEach(() => {
  Element.prototype.scrollIntoView = vi.fn();
  mountReview();
});

const completed = (id: string) => reviewQuestionCompleted(question(id));

describe("reviewQuestionCompleted", () => {
  test("a single radio group is incomplete until an option is selected", () => {
    expect(completed("s6d2")).toBe(false);
    click("s6d2", 2);
    expect(completed("s6d2")).toBe(true);
  });

  test("a grid is incomplete while any row is unanswered", () => {
    click("s2d2_1", 1);
    click("s2d2_2", 2);
    click("s2d2_3", 3);
    expect(completed("s2d2")).toBe(false);
  });

  test("a grid is complete once every row has a selection", () => {
    [1, 2, 3, 4].forEach((row) => click(`s2d2_${row}`, 1));
    expect(completed("s2d2")).toBe(true);
  });

  test("a multiple question is complete with at least one option", () => {
    const multiple = question("s2d3a");
    expect(multiple.dataset.multiple).toBe("1");
    expect(completed("s2d3a")).toBe(false);
    radioInput("s2d3a_2", 1).checked = true;
    expect(completed("s2d3a")).toBe(true);
  });

  test("a required number input is incomplete when empty or blank", () => {
    expect(completed("s6d1")).toBe(false);
    typeNumber("s6d1", "   ");
    expect(completed("s6d1")).toBe(false);
  });

  test.each(["0", "101", "-5", "1000"])("number %s outside 1-100 is incomplete", (value) => {
    typeNumber("s6d1", value);
    expect(completed("s6d1")).toBe(false);
  });

  test.each(["1", "50", "100"])("number %s inside 1-100 is complete", (value) => {
    typeNumber("s6d1", value);
    expect(completed("s6d1")).toBe(true);
  });

  test("deselecting the only selected answer makes the question incomplete again", () => {
    click("s6d2", 1);
    expect(completed("s6d2")).toBe(true);
    click("s6d2", 1);
    expect(radioInput("s6d2", 1).checked).toBe(false);
    expect(completed("s6d2")).toBe(false);
    expect(question("s6d2").dataset.completed).toBe("0");
  });
});

describe("dependent questions", () => {
  const triggers = [
    ["s2d3a", "s2d2_1"],
    ["s2d3b", "s2d2_2"],
    ["s2d3c", "s2d2_3"],
    ["s2d3d", "s2d2_4"],
  ] as const;

  test("every dependent question starts hidden and optional", () => {
    const dependents = ["s2d3a", "s2d3b", "s2d3c", "s2d3d", "s6d3", "s7d3", "s7d4", "s7d5"];
    dependents.forEach((id) => {
      expect(isVisible(id)).toBe(false);
      expect(isOptional(id)).toBe(true);
    });
  });

  test.each(triggers)("%s is shown when %s is greater than 1", (dependent, parent) => {
    click(parent, 2);
    expect(isVisible(dependent)).toBe(true);
    expect(isOptional(dependent)).toBe(false);
    triggers
      .filter(([other]) => other !== dependent)
      .forEach(([other]) => {
        expect(isVisible(other)).toBe(false);
      });
  });

  test.each(triggers)("%s stays hidden when %s equals 1", (dependent, parent) => {
    click(parent, 1);
    expect(isVisible(dependent)).toBe(false);
    expect(isOptional(dependent)).toBe(true);
  });

  test("s6d3 is shown when s6d2 is greater than 1 and hidden when it is 1", () => {
    click("s6d2", 2);
    expect(isVisible("s6d3")).toBe(true);
    expect(isOptional("s6d3")).toBe(false);
    click("s6d2", 1);
    expect(isVisible("s6d3")).toBe(false);
    expect(isOptional("s6d3")).toBe(true);
  });

  test("s7d3 is shown only when s7d2 equals 1", () => {
    click("s7d2", 1);
    expect(isVisible("s7d3")).toBe(true);
    expect(isVisible("s7d4")).toBe(false);
    expect(isVisible("s7d5")).toBe(false);
  });

  test("s7d4 and s7d5 are shown only when s7d2 equals 2", () => {
    click("s7d2", 2);
    expect(isVisible("s7d3")).toBe(false);
    expect(isVisible("s7d4")).toBe(true);
    expect(isVisible("s7d5")).toBe(true);
    expect(isOptional("s7d4")).toBe(false);
    expect(isOptional("s7d5")).toBe(false);
  });

  test("s7d2 equal to 3 shows none of its dependents", () => {
    click("s7d2", 3);
    ["s7d3", "s7d4", "s7d5"].forEach((id) => expect(isVisible(id)).toBe(false));
  });

  test("changing a parent answer swaps the visible dependents", () => {
    click("s7d2", 1);
    expect(isVisible("s7d3")).toBe(true);
    click("s7d2", 2);
    expect(isVisible("s7d3")).toBe(false);
    expect(isVisible("s7d4")).toBe(true);
    expect(isVisible("s7d5")).toBe(true);
    click("s7d2", 1);
    expect(isVisible("s7d3")).toBe(true);
    expect(isVisible("s7d4")).toBe(false);
  });

  test("deselecting a parent answer hides its dependents", () => {
    click("s7d2", 2);
    expect(isVisible("s7d4")).toBe(true);
    click("s7d2", 2);
    expect(radioInput("s7d2", 2).checked).toBe(false);
    ["s7d3", "s7d4", "s7d5"].forEach((id) => {
      expect(isVisible(id)).toBe(false);
      expect(isOptional(id)).toBe(true);
    });
  });

  test("answers in a dependent question survive while it stays visible", () => {
    click("s7d2", 2);
    click("s7d4", 1);
    click("s7d5", 2);
    click("s6d2", 1);
    click("s2d2_1", 1);
    submit();
    expect(isVisible("s7d4")).toBe(true);
    expect(radioInput("s7d4", 1).checked).toBe(true);
    expect(radioInput("s7d5", 2).checked).toBe(true);
  });

  test("answers in a dependent question are cleared when it becomes hidden", () => {
    click("s7d2", 2);
    click("s7d4", 1);
    click("s7d5", 2);
    click("s7d2", 3);
    expect(checkedCount("s7d4")).toBe(0);
    expect(checkedCount("s7d5")).toBe(0);
    expect(question("s7d4").dataset.completed).toBe("0");
  });

  test("clearing a grid row clears the matching hidden multiple question only", () => {
    click("s2d2_1", 3);
    click("s2d2_2", 3);
    radioInput("s2d3a_1", 1).click();
    radioInput("s2d3b_2", 1).click();
    click("s2d2_1", 1);
    expect(checkedCount("s2d3a")).toBe(0);
    expect(checkedCount("s2d3b")).toBe(1);
  });

  test("repeated synchronisation does not erase valid answers", () => {
    click("s6d2", 3);
    click("s6d3", 2);
    click("s7d2", 1);
    click("s7d3", 1);

    // Any radio interaction triggers a synchronisation; reselect others repeatedly.
    for (let round = 0; round < 3; round += 1) {
      click("s2d2_1", 1);
      click("s2d2_1", 1);
      typeNumber("s6d1", String(10 + round));
      submit();
    }

    expect(radioInput("s6d3", 2).checked).toBe(true);
    expect(radioInput("s7d3", 1).checked).toBe(true);
    expect(radioInput("s6d2", 3).checked).toBe(true);
  });
});

describe("submit button", () => {
  const answerRequired = () => {
    [1, 2, 3, 4].forEach((row) => click(`s2d2_${row}`, 1));
    typeNumber("s6d1", "12");
    click("s6d2", 1);
    click("s7d2", 3);
  };

  test("does not submit and flags every unanswered visible question", () => {
    submit();
    expect(submitted()).toBe(false);
    ["s2d2", "s6d1", "s6d2", "s7d2"].forEach((id) => {
      expect(question(id).classList.contains("question--error")).toBe(true);
    });
    expect(question("s6d3").classList.contains("question--error")).toBe(false);
    expect(question("s2d3a").classList.contains("question--error")).toBe(false);
  });

  test("scrolls to the first unanswered question", () => {
    submit();
    const scrolled = vi.mocked(Element.prototype.scrollIntoView).mock.contexts;
    expect(scrolled).toEqual([question("s2d2")]);
  });

  test("answering a flagged question removes its error class", () => {
    submit();
    click("s6d2", 1);
    expect(question("s6d2").classList.contains("question--error")).toBe(false);
    expect(question("s6d1").classList.contains("question--error")).toBe(true);
  });

  test("submits when only optional hidden questions are unanswered", () => {
    answerRequired();
    submit();
    expect(submitted()).toBe(true);
  });

  test("regression: dependents revealed then hidden again do not block submission", () => {
    answerRequired();
    click("s6d2", 2);
    click("s6d3", 1);
    click("s6d2", 1);
    submit();
    expect(isVisible("s6d3")).toBe(false);
    expect(submitted()).toBe(true);
  });

  test("a dependent revealed right before submission must be answered", () => {
    answerRequired();
    click("s6d2", 2);
    submit();
    expect(submitted()).toBe(false);
    expect(question("s6d3").classList.contains("question--error")).toBe(true);
    click("s6d3", 1);
    submit();
    expect(submitted()).toBe(true);
  });

  test("an out of range number blocks submission until corrected", () => {
    answerRequired();
    typeNumber("s6d1", "500");
    submit();
    expect(submitted()).toBe(false);
    typeNumber("s6d1", "50");
    submit();
    expect(submitted()).toBe(true);
  });
});
