import { expect, test } from "./fixtures";

test.describe("dependent questions", () => {
  const gridTriggers = [
    ["s2d3a", 1],
    ["s2d3b", 2],
    ["s2d3c", 3],
    ["s2d3d", 4],
  ] as const;

  for (const [dependent, row] of gridTriggers) {
    test(`${dependent} appears when s2d2 row ${row} is above 1`, async ({ review }) => {
      await review.choose("s2d2", `s2d2_${row}`, 2);
      await expect(review.question(dependent)).toBeVisible();
      await expect(review.question(dependent)).toHaveAttribute("data-optional", "0");
    });

    test(`${dependent} stays hidden when s2d2 row ${row} equals 1`, async ({ review }) => {
      await review.choose("s2d2", `s2d2_${row}`, 1);
      await expect(review.question(dependent)).toBeHidden();
    });
  }

  test("s6d3 follows s6d2", async ({ review }) => {
    await review.pick("s6d2", 1);
    await expect(review.question("s6d3")).toBeHidden();
    await review.pick("s6d2", 3);
    await expect(review.question("s6d3")).toBeVisible();
  });

  test("s7d3 appears for s7d2 = 1 and s7d4/s7d5 for s7d2 = 2", async ({ review }) => {
    await review.pick("s7d2", 1);
    await expect(review.question("s7d3")).toBeVisible();
    await expect(review.question("s7d4")).toBeHidden();
    await expect(review.question("s7d5")).toBeHidden();

    await review.pick("s7d2", 2);
    await expect(review.question("s7d3")).toBeHidden();
    await expect(review.question("s7d4")).toBeVisible();
    await expect(review.question("s7d5")).toBeVisible();

    await review.pick("s7d2", 3);
    for (const id of ["s7d3", "s7d4", "s7d5"]) await expect(review.question(id)).toBeHidden();
  });

  test("deselecting a selected radio recalculates dependencies", async ({ review }) => {
    await review.pick("s6d2", 2);
    await expect(review.question("s6d3")).toBeVisible();

    await review.pick("s6d2", 2);

    await expect(review.radio("s6d2", "s6d2", 2)).not.toBeChecked();
    await expect(review.question("s6d3")).toBeHidden();
  });

  test("a revealed dependent question must be answered before submission", async ({
    review,
    page,
  }) => {
    await review.answerRequired();
    await review.pick("s7d2", 1);
    await expect(review.question("s7d3")).toBeVisible();

    await review.submit.click();
    await expect(review.question("s7d3")).toHaveClass(/question--error/);
    await expect(page).toHaveURL(/\/review\/9001$/);
    await expect(review.form).toBeVisible();
  });

  test("answers of questions that stay visible survive synchronisation", async ({ review }) => {
    await review.pick("s7d2", 2);
    await review.pick("s7d4", 1);
    await review.pick("s7d5", 2);

    await review.pick("s6d2", 3);
    await review.fillNumber("s6d1", "7");
    await review.choose("s2d2", "s2d2_1", 1);

    await expect(review.radio("s7d4", "s7d4", 1)).toBeChecked();
    await expect(review.radio("s7d5", "s7d5", 2)).toBeChecked();
  });

  test("answers are cleared when their question is hidden again", async ({ review }) => {
    await review.pick("s7d2", 2);
    await review.pick("s7d4", 1);

    await review.pick("s7d2", 3);
    await review.pick("s7d2", 2);

    await expect(review.radio("s7d4", "s7d4", 1)).not.toBeChecked();
  });
});
