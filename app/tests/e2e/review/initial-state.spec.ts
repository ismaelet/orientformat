import { expect, test } from "./fixtures";

const REQUIRED = ["s2d2", "s6d1", "s6d2", "s7d2"];
const DEPENDENT = ["s2d3a", "s2d3b", "s2d3c", "s2d3d", "s6d3", "s7d3", "s7d4", "s7d5"];

test.describe("initial page state", () => {
  test("loads without JavaScript errors and shows the required questions", async ({ review }) => {
    for (const id of REQUIRED) {
      await expect(review.question(id)).toBeVisible();
      await expect(review.question(id)).not.toHaveAttribute("data-optional", "1");
    }
  });

  test("dependent questions are hidden and optional", async ({ review }) => {
    for (const id of DEPENDENT) {
      await expect(review.question(id)).toBeHidden();
      await expect(review.question(id)).toHaveAttribute("data-optional", "1");
    }
  });

  test("the submit button is enabled and interactive", async ({ review }) => {
    await expect(review.submit).toBeEnabled();
    await expect(review.submit).toHaveText("Invia");
  });
});
