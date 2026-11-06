import { execFileSync } from "node:child_process";
import { expect, test } from "@playwright/test";
import { phpEnv } from "../support/env";

function fixture(action: "seed" | "results") {
  return JSON.parse(
    execFileSync("php", ["tests/Support/seed-temperamento-e2e.php", action], {
      env: { PATH: process.env.PATH ?? "", HOME: process.env.HOME ?? "", ...phpEnv },
      encoding: "utf8",
    }),
  );
}

for (const scenario of [
  { name: "desktop", viewport: { width: 1280, height: 900 }, reducedMotion: "no-preference" },
  { name: "mobile", viewport: { width: 390, height: 844 }, reducedMotion: "no-preference" },
  { name: "reduced motion", viewport: { width: 1280, height: 900 }, reducedMotion: "reduce" },
] as const) {
  test(`completes all five temperament activities on ${scenario.name}`, async ({ page }) => {
    test.setTimeout(60_000);
    const { urls, sectionUrl } = fixture("seed") as { urls: string[]; sectionUrl: string };
    const errors: string[] = [];
    page.on("pageerror", (error) => errors.push(error.message));
    await page.setViewportSize(scenario.viewport);
    await page.emulateMedia({ reducedMotion: scenario.reducedMotion });

    // Visiting the protected activity first also gives login a safe intended URL.
    await page.goto(urls[0]);
    const login = page.locator('form[action$="/login"]');
    await login.locator('input[name="email"]').fill("temperamento-student@example.test");
    await login.locator('input[name="password"]').fill("password");
    await login.getByRole("button", { name: "Login" }).click();
    await page.waitForURL((url) => !url.pathname.startsWith("/login"));
    await page.goto(urls[0]);

    const answers = [0, 2, 3, 5];
    for (const [activityIndex, url] of urls.entries()) {
      await expect(page).toHaveURL(url);
      const questions = page.locator(".temperamento-question");
      const confirm = page.locator("button.confirm-button:visible");
      await expect(questions).toHaveCount(4);

      for (const [index, answer] of answers.entries()) {
        const current = questions.nth(index);
        await expect(current).toBeVisible();
        await expect(current).toBeEnabled();
        await expect(confirm).toHaveCount(0);
        await expect(questions.filter({ visible: true })).toHaveCount(1);

        // Check the scale stays horizontal, with graduated circle sizes.
        const boxes = await current.locator(".temperamento-circle").evaluateAll((circles) =>
          circles.map((circle) => {
            const rect = circle.getBoundingClientRect();
            return { x: rect.x, width: rect.width };
          }),
        );
        expect(boxes.every((box, i) => i === 0 || box.x > boxes[i - 1].x)).toBe(true);
        expect(boxes[0].width).toBeGreaterThan(boxes[1].width);
        expect(boxes[1].width).toBeGreaterThan(boxes[2].width);

        const questionTop = await current.evaluate(
          (element) => element.getBoundingClientRect().top + window.scrollY,
        );
        await current.locator(".temperamento-option").nth(answer).click();
        await expect(current.locator(`input[value="${answer}"]`)).toBeChecked();
        await expect(confirm).toBeEnabled();

        if (index < answers.length - 1) {
          await confirm.click();
          await expect(questions.nth(index + 1)).toBeVisible();
          await expect(questions.nth(index + 1)).toBeEnabled();
          await expect(current).toBeHidden();
          const nextTop = await questions
            .nth(index + 1)
            .evaluate((element) => element.getBoundingClientRect().top + window.scrollY);
          expect(Math.abs(nextTop - questionTop)).toBeLessThan(1);
        } else {
          const post = page.waitForResponse(
            (response) =>
              response.request().method() === "POST" && response.url().endsWith("/store"),
          );
          await confirm.click();
          expect((await post).status()).toBe(302);
          await expect(page).toHaveURL(urls[activityIndex + 1] ?? sectionUrl);
        }
      }
    }

    // Read the isolated DB rather than inferring successful saving from a redirect.
    expect(fixture("results")).toEqual(
      [41, 42, 43, 44, 45].map((testId) => ({
        testId,
        result: "0,2,3,5",
        percentage: 50,
        completed: 1,
      })),
    );

    // A completed activity must not offer another submission, including after reload.
    await page.goto(urls[0]);
    await expect(page.locator(".temperamento-question")).toHaveCount(0);
    await page.reload();
    await expect(page.locator("button.confirm-button")).toHaveCount(0);
    expect(fixture("results")).toHaveLength(5);
    expect(errors).toEqual([]);
  });
}
