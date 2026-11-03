import { expect, test } from "./fixtures";

const COMPLETED = /completato il formulario/;

test.describe("successful submission through Laravel", () => {
  test("a complete questionnaire is saved and the completion page is shown", async ({
    review,
    page,
  }) => {
    await review.answerRequired();
    await expect(review.submit).toBeEnabled();

    const response = await review.submitAndWait();

    expect(response.status()).toBe(302);
    await expect(page).toHaveURL(/\/review\/9001$/);
    await expect(page.getByText(COMPLETED)).toBeVisible();
    await expect(review.submit).toHaveCount(0);

    await page.reload();
    await expect(page.getByText(COMPLETED)).toBeVisible();
  });

  test("regression: dependents answered and then hidden never block submission", async ({
    review,
    page,
  }) => {
    await review.pick("s6d2", 2);
    await expect(review.question("s6d3")).toBeVisible();
    await review.pick("s6d3", 1);

    await review.pick("s7d2", 2);
    await review.pick("s7d4", 1);
    await review.pick("s7d5", 2);

    await review.pick("s6d2", 1);
    await review.pick("s7d2", 3);
    await expect(review.question("s6d3")).toBeHidden();
    await expect(review.question("s7d4")).toBeHidden();

    await review.answerGrid([2, 1, 3, 1]);
    await review.choose("s2d3a", "s2d3a_1", 1);
    await review.choose("s2d3c", "s2d3c_2", 1);
    await review.choose("s2d2", "s2d2_1", 1);
    await expect(review.question("s2d3a")).toBeHidden();
    await expect(review.question("s2d3c")).toBeVisible();
    await review.fillNumber("s6d1", "33");

    const response = await review.submitAndWait();

    expect(response.status()).toBe(302);
    await expect(page.getByText(COMPLETED)).toBeVisible();
  });

  test("a dependent revealed right before submission blocks until answered", async ({
    review,
    page,
  }) => {
    await review.answerRequired();
    await review.pick("s6d2", 3);

    await review.submit.click();
    await expect(review.question("s6d3")).toHaveClass(/question--error/);
    await expect(review.submit).toBeEnabled();
    await expect(page.getByText(COMPLETED)).toHaveCount(0);

    await review.pick("s6d3", 2);
    await expect(review.question("s6d3")).not.toHaveClass(/question--error/);

    const response = await review.submitAndWait();
    expect(response.status()).toBe(302);
    await expect(page.getByText(COMPLETED)).toBeVisible();
  });

  test("an invalid answer can be corrected and the submission retried", async ({
    review,
    page,
  }) => {
    await review.answerRequired();
    await review.fillNumber("s6d1", "0");

    await review.submit.click();
    await expect(review.question("s6d1")).toHaveClass(/question--error/);
    await expect(review.submit).toBeEnabled();

    await review.fillNumber("s6d1", "10");
    const response = await review.submitAndWait();

    expect(response.status()).toBe(302);
    await expect(page.getByText(COMPLETED)).toBeVisible();
  });

  test("submits after the parent answers were changed several times", async ({ review, page }) => {
    await review.answerRequired();

    for (const value of [2, 1, 3, 2, 1, 3]) {
      await review.pick("s7d2", value);
    }
    for (const value of [2, 1, 3]) {
      await review.pick("s6d2", value);
    }
    await review.pick("s6d2", 3);
    await review.pick("s6d2", 3);
    await review.pick("s6d2", 1);
    await review.choose("s2d2", "s2d2_3", 4);
    await review.choose("s2d2", "s2d2_3", 4);
    await review.choose("s2d2", "s2d2_3", 1);

    for (const id of ["s2d3c", "s6d3", "s7d3", "s7d4", "s7d5"]) {
      await expect(review.question(id)).toBeHidden();
    }

    const response = await review.submitAndWait();

    expect(response.status()).toBe(302);
    await expect(page.getByText(COMPLETED)).toBeVisible();
  });
});
