import { expect, test as base, type Locator, type Page } from "@playwright/test";
import { runFixture } from "../support/database";

const EMAIL = "review-student@example.test";
const PASSWORD = "password";
const REVIEW_ID = 9001;

export class ReviewPage {
  constructor(readonly page: Page) {}

  question(id: string): Locator {
    return this.page.locator(`#question-${id}`);
  }

  /** The visually styled control a user actually clicks for a radio input. */
  option(id: string, name: string, value: number | string): Locator {
    return this.question(id).locator("label.checkbox", {
      has: this.page.locator(`input[name="${name}"][value="${value}"]`),
    });
  }

  radio(id: string, name: string, value: number | string): Locator {
    return this.question(id).locator(`input[name="${name}"][value="${value}"]`);
  }

  async choose(id: string, name: string, value: number | string): Promise<void> {
    await this.option(id, name, value).click();
  }

  /** Picks an option of a single-name list question (name equals the question id). */
  async pick(id: string, value: number | string): Promise<void> {
    await this.choose(id, id, value);
  }

  async fillNumber(id: string, value: string): Promise<void> {
    await this.question(id).locator(".js-input").fill(value);
  }

  async answerGrid(values: [number, number, number, number] = [1, 1, 1, 1]): Promise<void> {
    for (const [index, value] of values.entries()) {
      await this.choose("s2d2", `s2d2_${index + 1}`, value);
    }
  }

  /** Answers every always-required question without triggering any dependency. */
  async answerRequired(): Promise<void> {
    await this.answerGrid();
    await this.fillNumber("s6d1", "12");
    await this.pick("s6d2", 1);
    await this.pick("s7d2", 3);
  }

  get submit(): Locator {
    return this.page.locator(".js-attempt-submit");
  }

  get form(): Locator {
    return this.page.locator("[data-review-form]");
  }

  async open(): Promise<void> {
    await this.page.goto(`/review/${REVIEW_ID}`);
    await expect(this.form).toBeVisible();
    await expect(this.submit).toBeVisible();
  }

  async submitAndWait() {
    const [response] = await Promise.all([
      this.page.waitForResponse(
        (candidate) =>
          new URL(candidate.url()).pathname === "/review" &&
          candidate.request().method() === "POST",
      ),
      this.submit.click(),
    ]);
    return response;
  }
}

type Fixtures = { review: ReviewPage; jsErrors: string[] };

export const test = base.extend<Fixtures>({
  jsErrors: async ({ page }, use) => {
    const errors: string[] = [];
    page.on("pageerror", (error) => errors.push(error.message));
    page.on("console", (message) => {
      // Missing font files (built CSS points at a production sub-path) are not script errors.
      if (message.type() === "error" && !message.text().startsWith("Failed to load resource")) {
        errors.push(message.text());
      }
    });
    await use(errors);
    expect(errors, "unexpected JavaScript errors").toEqual([]);
  },

  review: async ({ page, jsErrors: _jsErrors }, use) => {
    runFixture("reset");

    await page.goto("/login");
    const login = page.locator('form[action$="/login"]');
    await login.locator('input[name="email"]').fill(EMAIL);
    await login.locator('input[name="password"]').fill(PASSWORD);
    await login.getByRole("button", { name: "Login" }).click();
    await page.waitForURL((url) => !url.pathname.startsWith("/login"));

    const review = new ReviewPage(page);
    await review.open();
    await use(review);
  },
});

export { expect };
