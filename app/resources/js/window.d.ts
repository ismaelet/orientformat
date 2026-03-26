import type { initTextSelection } from "./tests/text-selection";

declare global {
  interface Window {
    printPage: () => void;
    initTextSelection: typeof initTextSelection;
    textSelectionOptions?: {
      value: string;
      label: string;
    }[];
  }
}

export {};
