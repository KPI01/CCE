import { type ClassValue, clsx } from "clsx";
import { twMerge } from "tailwind-merge";

export function cn(...inputs: ClassValue[]) {
  return twMerge(clsx(inputs));
}

export function ucfirst(str: string): string {
  const first = str.charAt(0).toUpperCase();
  return `${first}${str.slice(1)}`;
}
