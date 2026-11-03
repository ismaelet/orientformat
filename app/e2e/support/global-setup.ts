import { prepareDirectories, runFixture } from "./database";

export default function globalSetup(): void {
  prepareDirectories();
  runFixture("seed");
}
