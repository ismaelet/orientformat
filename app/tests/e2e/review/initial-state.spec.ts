import { expect, test } from "./fixtures";

const REQUIRED = ["s2d2", "s6d1", "s6d2", "s7d2"];
const DEPENDENT = ["s2d3a", "s2d3b", "s2d3c", "s2d3d", "s6d3", "s7d3", "s7d4", "s7d5"];

test.describe("initial page state", () => {
  test("loads built fonts from the production asset prefix", async ({ page }) => {
    const fontResponses: { url: string; status: number }[] = [];
    page.on("response", (response) => {
      if (
        response.url().includes("/orientamento/build/assets/") &&
        response.url().endsWith(".ttf")
      ) {
        fontResponses.push({ url: response.url(), status: response.status() });
      }
    });

    await page.goto("/login");
    await page.evaluate(async () => {
      await Promise.all([
        document.fonts.load('16px "Open Sans"'),
        document.fonts.load('italic 16px "Open Sans"'),
        document.fonts.load('16px "Source Sans 3"'),
        document.fonts.load('italic 16px "Source Sans 3"'),
      ]);
    });

    for (const font of ["OpenSans-", "OpenSans-Italic-", "SourceSans3-", "SourceSans3-Italic-"]) {
      expect(
        fontResponses.some(({ url, status }) => url.includes(`/${font}`) && status === 200),
      ).toBe(true);
    }
  });

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
