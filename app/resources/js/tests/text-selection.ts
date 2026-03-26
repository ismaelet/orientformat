type TextSelectionOption = {
  value: string;
  label: string;
};

declare global {
  interface Window {
    textSelectionOptions?: TextSelectionOption[];
  }
}

export function initTextSelection() {
  const textBlockElement =
    document.querySelector<HTMLElement>(".js-text-block");
  const menuElement = document.querySelector<HTMLElement>(".js-selection-menu");
  const markerElements = [
    ...document.querySelectorAll<HTMLElement>(".js-marker"),
  ];

  if (!textBlockElement || !menuElement) return;

  const textBlock = textBlockElement;
  const menu = menuElement;

  let currentSelectable: HTMLElement | null = null;
  let ignoreNextDocumentClick = false;

  const options = window.textSelectionOptions || [];
  const isSingleMarker = textBlock.dataset.singleMarker === "true";

  /**
   * Clears the current selection and resets the state of the menu.
   */
  function clearCurrentSelection() {
    currentSelectable = null;
  }

  /**
   * Hides the selection menu and clears the current selection.
   */
  function hideMenu() {
    menu.classList.add("hidden");
    menu.setAttribute("aria-hidden", "true");
    menu.innerHTML = "";
    clearCurrentSelection();
  }

  /**
   * Shows the selection menu at the specified coordinates for the given selectable element.
   */
  function showMenu(x: number, y: number, selectable: HTMLElement) {
    currentSelectable = selectable;
    menu.innerHTML = "";

    options.forEach((option) => {
      const markerElement = markerElements.find(
        (element) => element.dataset.markerType === option.value,
      );

      const isInactive = markerElement?.classList.contains("inactive") ?? false;

      const button = document.createElement("button");

      button.type = "button";
      button.innerHTML = option.label;
      button.dataset.textType = option.value;
      button.disabled = isInactive;

      if (isInactive) {
        button.classList.add("inactive");
      }

      button.addEventListener("click", () => {
        if (isInactive) {
          return;
        }

        applySelection(selectable, option.value);
        hideMenu();

        const selection = window.getSelection();
        if (selection) {
          selection.removeAllRanges();
        }
      });

      menu.appendChild(button);
    });

    menu.style.left = `${x}px`;
    menu.style.top = `${y}px`;
    menu.classList.remove("hidden");
    menu.setAttribute("aria-hidden", "false");

    ignoreNextDocumentClick = true;

    setTimeout(() => {
      ignoreNextDocumentClick = false;
    }, 0);
  }

  /**
   * Applies the selected marker type to the given selectable element, updates its state, and refreshes the marker states.
   */
  function applySelection(selectable: HTMLElement, chosenType: string) {
    if (!selectable || selectable.classList.contains("active")) {
      return;
    }

    const correctType = selectable.dataset.textType;
    const input = selectable.querySelector<HTMLInputElement>(".js-answer");

    if (input) {
      input.value = chosenType;
      input.dispatchEvent(
        new Event("change", {
          bubbles: true,
        }),
      );
    }

    selectable.classList.add("active");

    if (chosenType !== correctType) {
      selectable.classList.add("wrong");
    }

    updateMarkerStates();
  }

  function flashSelectionError() {
    textBlock.classList.add("is-selection-error");
  }

  function getTrimmedStartOffset(text: string): number {
    const match = text.match(/^[\s.,;:!?'"“”‘’()«»[\]{}-]*/u);
    return match ? match[0].length : 0;
  }

  function getTrimmedEndOffset(text: string): number {
    const match = text.match(/[\s.,;:!?'"“”‘’()«»[\]{}-]*$/u);
    return match ? text.length - match[0].length : text.length;
  }

  function getSelectableFromSelection() {
    const selection = window.getSelection();

    if (!selection || selection.rangeCount === 0 || selection.isCollapsed) {
      return null;
    }

    const range = selection.getRangeAt(0);

    if (!textBlock.contains(range.commonAncestorContainer)) {
      return null;
    }

    const selectableElements = [
      ...textBlock.querySelectorAll<HTMLElement>(".js-selectable"),
    ].filter((element) => !element.classList.contains("active"));

    let matchedSelectable: HTMLElement | null = null;

    for (const element of selectableElements) {
      const textElement = element.querySelector<HTMLElement>(
        ".js-selectable-text",
      );

      if (!textElement) {
        continue;
      }

      if (!range.intersectsNode(textElement)) {
        continue;
      }

      const textNode = [...textElement.childNodes].find(
        (node) => node.nodeType === Node.TEXT_NODE,
      );

      if (!textNode || !textNode.textContent) {
        continue;
      }

      const text = textNode.textContent;
      const startOffset = getTrimmedStartOffset(text);
      const endOffset = getTrimmedEndOffset(text);

      if (startOffset >= endOffset) {
        continue;
      }

      const fullyContainsTrimmedText =
        range.comparePoint(textNode, startOffset) <= 0 &&
        range.comparePoint(textNode, endOffset) >= 0;

      if (fullyContainsTrimmedText) {
        if (matchedSelectable) {
          return null;
        }

        matchedSelectable = element;
        continue;
      }

      return null;
    }

    return matchedSelectable;
  }

  function updateMarkerStates() {
    markerElements.forEach((markerElement) => {
      const markerType = markerElement.dataset.markerType;
      const maxCount = Number(markerElement.dataset.maxCount || 0);

      const selectedCount = [
        ...textBlock.querySelectorAll<HTMLInputElement>(".js-answer"),
      ].filter((input) => input.value === markerType).length;

      markerElement.classList.toggle("inactive", selectedCount >= maxCount);
    });
  }

  document.addEventListener("mousedown", function () {
    textBlock.classList.remove("is-selection-error");
  });

  document.addEventListener("mouseup", function (event) {
    const target = event.target;

    if (target instanceof Node && menu.contains(target)) {
      return;
    }

    const selection = window.getSelection();

    hideMenu();

    if (!selection || selection.rangeCount === 0 || selection.isCollapsed) {
      return;
    }

    const range = selection.getRangeAt(0);

    if (!range.intersectsNode(textBlock)) {
      return;
    }

    const selectable = getSelectableFromSelection();

    if (!selectable) {
      flashSelectionError();
      return;
    }

    if (isSingleMarker && options.length === 1) {
      applySelection(selectable, options[0].value);
      selection.removeAllRanges();
      return;
    }

    const rect = range.getBoundingClientRect();

    showMenu(rect.left, rect.bottom + 8, selectable);
  });

  document.addEventListener("click", function (event) {
    if (ignoreNextDocumentClick) {
      return;
    }

    const target = event.target;

    if (!(target instanceof Node)) {
      hideMenu();
      return;
    }

    if (
      menu.contains(target) ||
      (currentSelectable && currentSelectable.contains(target))
    ) {
      return;
    }

    hideMenu();
  });

  document.addEventListener("keydown", function (event) {
    if (event.key === "Escape") {
      hideMenu();

      const selection = window.getSelection();
      if (selection) {
        selection.removeAllRanges();
      }
    }
  });

  updateMarkerStates();
}
