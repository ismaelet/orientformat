import { expect, test } from "./fixtures";

const REQUIRED = ["s2d2", "s6d1", "s6d2", "s7d2"];

test.describe("validation and highlighting", () => {
  test("Invia with unanswered questions does not submit and flags them all", async ({
    review,
    page,
  }) => {
    let posted = false;
    page.on("request", (request) => {
      posted ||= request.method() === "POST";
    });

    await review.submit.click();

    for (const id of REQUIRED) {
      await expect(review.question(id)).toHaveClass(/question--error/);
    }
    await expect(review.question("s6d3")).not.toHaveClass(/question--error/);
    await expect(review.submit).toBeEnabled();
    await expect(review.form).toBeVisible();
    expect(posted).toBe(false);
  });

  test("scrolls to the first unanswered required question", async ({ review, page }) => {
    await page.setViewportSize({ width: 1280, height: 320 });
    await review.question("s7d2").scrollIntoViewIfNeeded();
    await expect(review.question("s2d2")).not.toBeInViewport();

    await review.submit.click();

    await expect(review.question("s2d2")).toBeInViewport();
  });

  test("answering a highlighted question removes its error styling", async ({ review }) => {
    await review.submit.click();
    await expect(review.question("s6d2")).toHaveClass(/question--error/);

    await review.pick("s6d2", 2);

    await expect(review.question("s6d2")).not.toHaveClass(/question--error/);
    await expect(review.question("s6d1")).toHaveClass(/question--error/);
  });

  test("a number outside the allowed range keeps the question flagged", async ({ review }) => {
    await review.answerRequired();
    await review.fillNumber("s6d1", "500");
    await review.submit.click();
    await expect(review.question("s6d1")).toHaveClass(/question--error/);

    await review.fillNumber("s6d1", "50");
    await expect(review.question("s6d1")).not.toHaveClass(/question--error/);
  });

  test("shows a warning per unanswered question and hides it once answered", async ({ review }) => {
    const warning = (id: string) => review.question(id).locator(".js-error-warning");

    await expect(warning("s6d2")).toBeHidden();

    await review.submit.click();
    await expect(warning("s6d2")).toBeVisible();
    await expect(warning("s6d2")).toHaveText(/Risposta obbligatoria/);
    await expect(warning("s6d3")).toBeHidden();

    await review.pick("s6d2", 1);
    await expect(warning("s6d2")).toBeHidden();
    await expect(warning("s6d1")).toBeVisible();
  });
});
