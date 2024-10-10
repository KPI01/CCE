import { type ClassValue, clsx } from "clsx";
import { twMerge } from "tailwind-merge";

export function cn(...inputs: ClassValue[]) {
  return twMerge(clsx(inputs));
}

export function ucfirst(str: string): string {
  const first = str.charAt(0).toUpperCase();
  return `${first}${str.slice(1)}`;
}

export function nameToDisplay(name: string) {
  const separators = ["_", "-"];
  const connectors = ["de", "y"];

  const containsSeparator = separators.reduce(
    (acc, separator) => acc || name.includes(separator),
    false,
  );

  if (!containsSeparator && !connectors.includes(name)) {
    return ucfirst(name);
  }

  const str = separators
    .map((separator) => {
      if (name.includes(separator)) {
        return name.split(separator).map((word) => ucfirst(word));
      }
    })
    .flat()
    .filter((item) => item !== undefined);

  return str.join(": ");
}

export function urlWithoutId(url: string) {
  if (!url.lastIndexOf("/")) {
    console.error("La url debe tener /");
    return url;
  }
  return url.slice(0, url.lastIndexOf("/"));
}
