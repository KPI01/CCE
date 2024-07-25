import { type ClassValue, clsx } from "clsx";
import { twMerge } from "tailwind-merge";

export function cn(...inputs: ClassValue[]) {
  return twMerge(clsx(inputs));
}

export function convertNullToUndefined(obj: any) {
    for (const key in obj) {
      if (obj[key] === null) {
        obj[key] = undefined;
      } else if (typeof obj[key] === 'object' && obj[key] !== null) {
        convertNullToUndefined(obj[key]);
      }
    }
  }